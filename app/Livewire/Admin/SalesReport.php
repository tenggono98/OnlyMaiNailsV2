<?php

namespace App\Livewire\Admin;

use App\Models\TBooking;
use App\Models\TDBooking;
use App\Models\User;
use App\Models\MService;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class SalesReport extends Component
{
    use WithPagination, LivewireAlert;

    public $dateRange = 'all';
    public $startDate;
    public $endDate;
    public $searchQuery = '';
    public $status = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;
    public $customerFilter = '';
    public $statusFilter = '';
    public $depositFilter = '';
    public $exportName = '';

    protected $queryString = [
        'searchQuery' => ['except' => ''],
        'status' => ['except' => ''],
        'dateRange' => ['except' => 'all'],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function mount()
    {
        // Initialize date range if custom period is selected
        if ($this->dateRange === 'custom') {
            $this->startDate = now()->subMonth()->format('Y-m-d');
            $this->endDate = now()->format('Y-m-d');
        }
    }

    public function updatedDateRange()
    {
        if ($this->dateRange === 'custom') {
            $this->startDate = now()->subMonth()->format('Y-m-d');
            $this->endDate = now()->format('Y-m-d');
        }
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function getBookingsQuery()
    {
        $query = TBooking::query()
            ->with(['client', 'detailService.service', 'scheduleDateBook', 'scheduleTimeBook']);

        if ($this->searchQuery) {
            $query->where(function ($q) {
                $q->whereHas('client', function ($userQuery) {
                    $userQuery->where('name', 'like', '%' . $this->searchQuery . '%')
                        ->orWhere('email', 'like', '%' . $this->searchQuery . '%')
                        ->orWhere('phone', 'like', '%' . $this->searchQuery . '%');
                })
                ->orWhere('booking_number', 'like', '%' . $this->searchQuery . '%');
            });
        }

        // Apply status filter from status or statusFilter property
        if ($this->status) {
            $query->where('status', $this->status);
        } elseif ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        // Apply customer filter
        if ($this->customerFilter) {
            $query->where('user_id', $this->customerFilter);
        }

        // Apply deposit filter
        if ($this->depositFilter === 'paid') {
            $query->where('is_deposit_paid', '1');
        } elseif ($this->depositFilter === 'unpaid') {
            $query->where('is_deposit_paid', '0');
        }

        // Filter by date range
        switch ($this->dateRange) {
            case 'today':
                $query->whereDate('created_at', Carbon::today());
                break;
            case 'yesterday':
                $query->whereDate('created_at', Carbon::yesterday());
                break;
            case 'this_week':
                $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'last_week':
                $query->whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]);
                break;
            case 'this_month':
                $query->whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year);
                break;
            case 'last_month':
                $query->whereMonth('created_at', Carbon::now()->subMonth()->month)
                    ->whereYear('created_at', Carbon::now()->subMonth()->year);
                break;
            case 'custom':
                if ($this->startDate && $this->endDate) {
                    $query->whereBetween('created_at', [
                        Carbon::parse($this->startDate)->startOfDay(),
                        Carbon::parse($this->endDate)->endOfDay()
                    ]);
                }
                break;
        }

        return $query->orderBy($this->sortField, $this->sortDirection);
    }

    public function render()
    {
        $bookings = $this->getBookingsQuery()->paginate($this->perPage);

        $totalRevenue = $this->getBookingsQuery()
            ->where('status', 'completed')
            ->sum('total_price_booking');

        $totalBookings = $this->getBookingsQuery()->count();

        $completedBookings = $this->getBookingsQuery()
            ->where('status', 'completed')
            ->count();

        $cancelledBookings = $this->getBookingsQuery()
            ->where('status', 'cancel')
            ->count();

        $pendingBookings = $this->getBookingsQuery()
            ->where('status', '1')
            ->count();

        // Get all customers for the filter dropdown
        $customers = User::where('role', 'user')->orderBy('name')->get();

        $summaryStats = [
            'totalBookings' => $totalBookings,
            'totalRevenue' => $totalRevenue,
            'completedBookings' => $completedBookings,
            'cancelledBookings' => $cancelledBookings,
            'pendingBookings' => $pendingBookings,
            'totalDeposits' => $this->getBookingsQuery()->where('is_deposit_paid', '1')->sum('deposit_price_booking') ?? 0,
            'pendingDeposits' => $this->getBookingsQuery()->where('is_deposit_paid', '0')->sum('deposit_price_booking') ?? 0
        ];

        return view('livewire.admin.reports', [
            'bookings' => $bookings,
            'customers' => $customers,
            'summaryStats' => $summaryStats
        ])->layout('components.layouts.app-admin');
    }

    public function updateDateRange($range)
    {
        $this->dateRange = $range;
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['dateRange', 'startDate', 'endDate', 'searchQuery', 'status', 'customerFilter', 'statusFilter', 'depositFilter']);
        $this->resetPage();
    }

    public function exportToExcel()
    {
        // Use the user-provided filename or default if empty
        $fileName = $this->exportName ?
            $this->exportName . '_' . date('Y-m-d') . '.xlsx' :
            'bookings_report_' . date('Y-m-d_H-i-s') . '.xlsx';

        $this->alert('success', 'Exporting data to Excel...', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
        ]);

        return $this->exportExcel($fileName);
    }

    public function exportExcel($fileName = null)
    {
        // If no filename is provided, use default
        if (!$fileName) {
            $fileName = 'bookings_report_' . date('Y-m-d_H-i-s') . '.xlsx';
        }

        // Get all bookings without pagination
        $bookings = $this->getBookingsQuery()->get();

        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set document properties
        $spreadsheet->getProperties()
            ->setCreator('OnlyMaiNails')
            ->setLastModifiedBy('OnlyMaiNails')
            ->setTitle('Bookings Report')
            ->setSubject('Bookings Report')
            ->setDescription('Bookings report generated on ' . date('Y-m-d H:i:s'));

        // Set header row
        $sheet->setCellValue('A1', 'Booking Number');
        $sheet->setCellValue('B1', 'Customer Name');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Phone');
        $sheet->setCellValue('E1', 'Services');
        $sheet->setCellValue('F1', 'Date & Time');
        $sheet->setCellValue('G1', 'Status');
        $sheet->setCellValue('H1', 'Total Amount');
        $sheet->setCellValue('I1', 'Deposit Status');
        $sheet->setCellValue('J1', 'Created At');

        // Bold the header row
        $sheet->getStyle('A1:J1')->getFont()->setBold(true);

        // Set data rows
        $row = 2;
        foreach ($bookings as $booking) {
            // Collect all services for this booking
            $services = [];
            foreach ($booking->detailService as $detail) {
                if ($detail->service) {
                    $services[] = $detail->service->name_service;
                }
            }

            // Get the scheduled date and time
            $scheduledDateTime = '';
            if ($booking->scheduleDateBook && $booking->scheduleTimeBook) {
                $scheduledDateTime = Carbon::parse($booking->scheduleDateBook->date_schedule)->format('M d, Y') . ' ' .
                    Carbon::parse($booking->scheduleTimeBook->time)->format('h:i A');
            }

            $sheet->setCellValue('A' . $row, $booking->booking_number);
            $sheet->setCellValue('B' . $row, $booking->client->name ?? 'N/A');
            $sheet->setCellValue('C' . $row, $booking->client->email ?? 'N/A');
            $sheet->setCellValue('D' . $row, $booking->client->phone ?? 'N/A');
            $sheet->setCellValue('E' . $row, implode(', ', $services));
            $sheet->setCellValue('F' . $row, $scheduledDateTime);
            $sheet->setCellValue('G' . $row, ucfirst($booking->status));
            $sheet->setCellValue('H' . $row, '$' . number_format($booking->total_price_booking, 2));
            $sheet->setCellValue('I' . $row, $booking->is_deposit_paid ? 'Paid' : 'Unpaid');
            $sheet->setCellValue('J' . $row, $booking->created_at->format('M d, Y h:i A'));
            $row++;
        }

        // Add summary information at the bottom
        $row += 2; // Add some space
        $sheet->setCellValue('A' . $row, 'Report Summary');
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);

        $row++;
        $sheet->setCellValue('A' . $row, 'Total Bookings:');
        $sheet->setCellValue('B' . $row, $bookings->count());

        $row++;
        $sheet->setCellValue('A' . $row, 'Total Revenue:');
        $sheet->setCellValue('B' . $row, '$' . number_format($bookings->where('status', 'completed')->sum('total_price_booking'), 2));

        $row++;
        $sheet->setCellValue('A' . $row, 'Completed Bookings:');
        $sheet->setCellValue('B' . $row, $bookings->where('status', 'completed')->count());

        $row++;
        $sheet->setCellValue('A' . $row, 'Pending Bookings:');
        $sheet->setCellValue('B' . $row, $bookings->where('status', '1')->count());

        $row++;
        $sheet->setCellValue('A' . $row, 'Cancelled Bookings:');
        $sheet->setCellValue('B' . $row, $bookings->where('status', 'cancel')->count());

        $row++;
        $sheet->setCellValue('A' . $row, 'Total Deposits Collected:');
        $sheet->setCellValue('B' . $row, '$' . number_format($bookings->where('is_deposit_paid', '1')->sum('deposit_price_booking') ?? 0, 2));

        $row++;
        $sheet->setCellValue('A' . $row, 'Pending Deposits:');
        $sheet->setCellValue('B' . $row, '$' . number_format($bookings->where('is_deposit_paid', '0')->sum('deposit_price_booking') ?? 0, 2));

        // Add filter criteria used
        $row += 2;
        $sheet->setCellValue('A' . $row, 'Filter Criteria:');
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);

        $row++;
        $sheet->setCellValue('A' . $row, 'Date Range:');
        $dateRangeText = 'All Time';
        if ($this->dateRange === 'today') {
            $dateRangeText = 'Today';
        } elseif ($this->dateRange === 'yesterday') {
            $dateRangeText = 'Yesterday';
        } elseif ($this->dateRange === 'this_week') {
            $dateRangeText = 'This Week';
        } elseif ($this->dateRange === 'last_week') {
            $dateRangeText = 'Last Week';
        } elseif ($this->dateRange === 'this_month') {
            $dateRangeText = 'This Month';
        } elseif ($this->dateRange === 'last_month') {
            $dateRangeText = 'Last Month';
        } elseif ($this->dateRange === 'custom') {
            $dateRangeText = 'Custom: ' . $this->startDate . ' to ' . $this->endDate;
        }
        $sheet->setCellValue('B' . $row, $dateRangeText);

        if ($this->statusFilter) {
            $row++;
            $sheet->setCellValue('A' . $row, 'Status Filter:');
            $sheet->setCellValue('B' . $row, ucfirst($this->statusFilter));
        }

        if ($this->customerFilter) {
            $row++;
            $sheet->setCellValue('A' . $row, 'Customer Filter:');
            $customerName = User::find($this->customerFilter)->name ?? 'Unknown';
            $sheet->setCellValue('B' . $row, $customerName);
        }

        if ($this->depositFilter) {
            $row++;
            $sheet->setCellValue('A' . $row, 'Deposit Status Filter:');
            $sheet->setCellValue('B' . $row, ucfirst($this->depositFilter));
        }

        // Add report generation info
        $row += 2;
        $sheet->setCellValue('A' . $row, 'Report Generated:');
        $sheet->setCellValue('B' . $row, now()->format('M d, Y h:i A'));

        // Auto size columns
        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Create a temporary file
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);

        // Save the spreadsheet to the temporary file
        $writer = new Xlsx($spreadsheet);
        $writer->save($tempFile);

        // Return the file as a download
        return response()->download($tempFile, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }
}
