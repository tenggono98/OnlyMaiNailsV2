<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>OnlyMaiNails - Invoice {{ $invoice->invoice_number }}</title>
    <style>
        @page { margin: 24px 28px; }
        body { font-family: DejaVu Sans, sans-serif; color:#111; font-size: 12px; }
        .container { max-width: 820px; margin: 0 auto; }
        .card { background:#fff; border-radius:8px; padding:16px; }
        .row { width:100%; display: table; table-layout: fixed; }
        .col { display: table-cell; vertical-align: top; }
        .pr-4 { padding-right: 16px; }
        .text-right { text-align:right; }
        .title { font-size: 26px; font-weight: 800; letter-spacing:.3px; }
        .muted { color:#666; }
        .hr { height:1px; background:#e5e7eb; margin: 14px 0; }
        .block-title { font-weight:700; margin-bottom:6px; }
        table { width:100%; border-collapse: collapse; }
        th, td { padding:8px; border-bottom:1px solid #e5e7eb; }
        thead th { background:#f8fafc; border-top:1px solid #e5e7eb; border-bottom-color:#e5e7eb; }
        .right { text-align:right; }
        .nowrap { white-space:nowrap; }
        .totals td { border:none; padding:6px 0; }
        .totals .grand { border-top:1px solid #e5e7eb; padding-top:8px; font-weight:800; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <!-- Header: Logo + Invoice Title/Number -->
            <div class="row" style="margin-bottom: 8px;">
                <div class="col pr-4">
                    <div class="title">ONLYMAI<span style="color:#f17ea2">NAILS</span></div>
                    <div class="muted" style="margin-top:2px;">Professional Nails & Beauty</div>
                </div>
                <div class="col">
                    <div class="text-right" style="font-size:22px; font-weight:800;">INVOICE</div>
                    <div class="text-right muted">{{ $invoice->invoice_number }}</div>
                </div>
            </div>

            <!-- Bill To / Pay To -->
            <table style="margin-bottom: 10px;">
                <tr>
                    <td class="pr-4" style="width: 130px;"><span class="block-title">BILLED TO</span></td>
                    <td>
                        @if($invoice->order && $invoice->order->client)
                            <div style="font-size:13px; font-weight:600;">{{ $invoice->order->client->name }}</div>
                            <div class="muted">{{ $invoice->order->client->email }}</div>
                        @else
                            <div class="muted">No client information</div>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="pr-4"><span class="block-title">PAY TO</span></td>
                    <td>
                        <div>{{ $payTo['company'] ?? 'OnlyMaiNails' }}</div>
                        @if(!empty($payTo['address']))
                            <div class="muted">{{ $payTo['address'] }}</div>
                        @endif
                        @if(!empty($payTo['payment_email']))
                            <div class="muted">{{ $payTo['payment_email'] }}</div>
                        @endif
                        @if(!empty($payTo['account']))
                            <div class="muted">Account: {{ $payTo['account'] }}</div>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="pr-4">Date</td>
                    <td class="muted">{{ optional($invoice->created_at)->format('M d, Y') }}</td>
                </tr>
            </table>

            <!-- Summary of Order -->
            <div class="muted" style="margin-bottom:6px;">Summary of Order</div>
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th class="right">Price</th>
                        <th class="right">Qty</th>
                        <th class="right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $subtotal = 0; @endphp
                    @foreach(($invoice->order->items ?? []) as $it)
                        @php $subtotal += (float)$it->subtotal; @endphp
                        <tr>
                            <td>
                                <div style="font-weight:600;">{{ $it->name }}</div>
                                @if($it->variant)
                                    <div class="muted" style="margin-top:2px;">Variant: {{ $it->variant->name }} @if($it->variant->sku) • SKU: {{ $it->variant->sku }} @endif</div>
                                @endif
                            </td>
                            <td class="right nowrap">${{ number_format($it->price,2) }}</td>
                            <td class="right nowrap">{{ $it->qty }}</td>
                            <td class="right nowrap">${{ number_format($it->subtotal,2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" style="border-bottom: none;">
                            <table class="totals" style="margin-left:auto; width: 300px;">
                                <tr>
                                    <td class="right">Subtotal</td>
                                    <td class="right nowrap">${{ number_format($subtotal,2) }}</td>
                                </tr>
                                <tr>
                                    <td class="right grand">Total</td>
                                    <td class="right grand nowrap">${{ number_format($invoice->total ?? $subtotal,2) }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tfoot>
            </table>

            <div class="hr"></div>
            <div class="muted" style="line-height:1.5;">
                Thank you for your business. If you have any questions about this invoice, please reply to this email or contact our support.
            </div>
        </div>
    </div>
</body>
</html>
