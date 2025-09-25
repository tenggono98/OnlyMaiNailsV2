<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Your Invoice {{ $invoice->invoice_number }}</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif; color:#0f172a;">
    <div style="max-width:640px;margin:0 auto;padding:16px;">
        <h2 style="margin:0 0 8px 0;">Hi {{ $clientName ?? 'there' }},</h2>
        <p style="margin:0 0 12px 0;">Thanks for your purchase. Please find your invoice attached.</p>

        <div style="border:1px solid #e5e7eb;border-radius:8px;padding:12px;margin-bottom:12px;">
            <div style="display:flex;justify-content:space-between;">
                <div>
                    <div style="font-weight:700;">Invoice</div>
                    <div style="color:#475569;">{{ $invoice->invoice_number }}</div>
                </div>
                <div style="text-align:right;">
                    <div style="font-weight:700;">Total</div>
                    <div style="color:#475569;">${{ number_format($invoice->total,2) }}</div>
                </div>
            </div>
            <div style="margin-top:8px;color:#475569;">Date: {{ optional($invoice->created_at)->format('M d, Y') }}</div>
        </div>

        <p style="margin:0 0 12px 0;">If you have any questions, you can reply to this email.</p>
        @if(!empty($payTo['payment_email']))
            <p style="margin:0 0 12px 0;">Payment support: {{ $payTo['payment_email'] }}</p>
        @endif
        @if(!empty($payTo['address']))
            <p style="margin:0 0 12px 0;">Address: {{ $payTo['address'] }}</p>
        @endif

        <p style="margin:0;color:#64748b;">— OnlyMaiNails</p>
    </div>
</body>
</html>
