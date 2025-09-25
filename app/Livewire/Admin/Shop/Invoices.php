<?php

namespace App\Livewire\Admin\Shop;

use App\Models\TInvoice;
use App\Models\TOrder;
use App\Models\SettingWeb;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Barryvdh\DomPDF\Facade\Pdf;

#[Layout('components.layouts.app-admin')]
class Invoices extends Component
{
    use LivewireAlert;

    public $invoices;
    public $order_id;
    public $invoice_number;

    public function render()
    {
        $this->invoices = TInvoice::with('order.items.variant','order.client')->orderByDesc('id')->get();
        $orders = TOrder::orderByDesc('id')->get();
        return view('livewire.admin.shop.invoices', compact('orders'));
    }

    public function createFromOrder()
    {
        $this->validate([
            'order_id' => 'required|exists:t_orders,id',
        ]);
        $order = TOrder::find($this->order_id);
        $invoice = TInvoice::create([
            'uuid' => generateUUID(10),
            't_order_id' => $order->id,
            'invoice_number' => 'INV-' . strtoupper(generateUUID(6)),
            'total' => $order->total_price,
            'status' => 'issued',
        ]);
        $this->alert('success','Invoice generated');
        $this->reset(['order_id']);
    }

    private function getPayTo(): array
    {
        return [
            'company' => 'OnlyMaiNails',
            'address' => optional(SettingWeb::where('name','Address')->first())->value,
            'payment_email' => optional(SettingWeb::where('name','PaymentEmail')->first())->value
                ?? optional(SettingWeb::where('name','paymentEmail')->first())->value,
            'account' => optional(SettingWeb::where('name','PaymentAccount')->first())->value,
        ];
    }

    private function ensurePdfExists(TInvoice $invoice): string
    {
        $directoryPath = storage_path('app/public/PDF_Shop_Invoices');
        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true);
        }
        $fileName = 'SHOP_' . $invoice->invoice_number . '.pdf';
        $fullPath = $directoryPath . '/' . $fileName;

        if (!file_exists($fullPath)) {
            $pdf = Pdf::loadView('pdf.shop-invoice', [ 'invoice' => $invoice, 'payTo' => $this->getPayTo() ]);
            $pdf->save($fullPath);
            $invoice->pdf_path = 'PDF_Shop_Invoices/' . $fileName;
            $invoice->save();
        }
        return $fullPath;
    }

    public function generatePdf($id)
    {
        $invoice = TInvoice::with('order.items.variant','order.client')->find($id);
        if (!$invoice) { $this->alert('error','Invoice not found'); return; }

        try {
            $this->ensurePdfExists($invoice);
            $this->alert('success','Invoice PDF generated');
        } catch (\Throwable $e) {
            Log::error('Failed to generate shop invoice PDF: ' . $e->getMessage());
            $this->alert('error','Failed to generate PDF');
        }
    }

    public function emailInvoice($id)
    {
        $invoice = TInvoice::with('order.items.variant','order.client')->find($id);
        if (!$invoice) { $this->alert('error','Invoice not found'); return; }
        if (!$invoice->order || !$invoice->order->client) { $this->alert('error','Order or client missing'); return; }

        try {
            // Ensure PDF exists and get full path
            $fullPath = $this->ensurePdfExists($invoice);

            $to = $invoice->order->client->email;
            $subject = 'Your Invoice ' . $invoice->invoice_number;

            $viewData = [
                'invoice' => $invoice,
                'payTo' => $this->getPayTo(),
                'clientName' => $invoice->order->client->name,
            ];

            Mail::send('mail.shop-invoice', $viewData, function($message) use ($to, $subject, $fullPath) {
                $message->to($to)->subject($subject);
                if (file_exists($fullPath)) {
                    $message->attach($fullPath);
                }
            });

            $this->alert('success','Invoice email sent');
        } catch (\Throwable $e) {
            Log::warning('Failed to email invoice: ' . $e->getMessage());
            $this->alert('error','Failed to send email');
        }
    }
}
