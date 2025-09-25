<?php

namespace App\Http\Controllers\Pdf;

use App\Http\Controllers\Controller;
use App\Models\TInvoice;
use App\Models\SettingWeb;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;

class ShopInvoice extends Controller
{
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

    public function download($id)
    {
        $invoice = TInvoice::with('order.items.variant','order.client')->findOrFail($id);

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

        return response()->download($fullPath, $fileName);
    }
}
