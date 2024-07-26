<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>OnlyMaiNails</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div class="py-6 container-fluid min-vh-100 d-flex align-items-center justify-content-center ">

        <div class="p-4 bg-white rounded " style="max-width: 49rem; margin: auto;min-width:40rem">



            <div class="table-responsive">
                <table class="table table-borderless table-sm">
                    <tbody>
                        <td>
                    <img src="https://onlymainails.alfonso-tenggono.online/img/transparant-logo.png" class="img-fluid" alt="OnlyMaiNails" style="height: 7.5rem;">

                        </td>
                        <td>


                            <h1 class="text-right">INVOICE</h1>
                            <p class="text-right">{{ $invoice_number }}</p>

                        </td>
                    </tbody>

                </table>

            </div>

            <table>
                <tr>
                    <td class="pr-5 font-bold"><p><strong>BILLED TO</strong></p></td>
                    <td><p class="fs-3">{{ $clientName ?? '' }}</p></td>
                </tr>
                <tr>
                    <td><p class=""><strong>PAY TO</strong></p></td>
                    <td>
                        <ul class="fs-3" style="list-style-type:none;padding:0">
                            <li>OnlyMaiNails</li>
                            <li><small>{{ $address }}</small></li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td class="pr-5 font-bold"><p>Account Name</p></td>
                    <td><p class="fs-3">{{ $account_payment ?? '' }}</p></td>
                </tr>
                <tr>
                    <td class="pr-5 font-bold"><p>Payment Email</p></td>
                    <td><p class="fs-3">{{ $email_payment ?? '' }}</p></td>
                </tr>
            </table>





            {{-- Summary of Order --}}
            <ul class="list-unstyled">
                <li><p class="fw-bold">Summary Of Order</p></li>
                <li>
                    <div class="mt-3 table-responsive">
                        <table class="table table-borderless table-sm">
                            <thead class="table-light text-uppercase border-bottom">
                                <tr>
                                    <th scope="col">Service Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col" class="text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_price = 0;
                                @endphp
                                @foreach ($list_order as $order)
                                @php
                                    $total_price += $qty_people * $order['price_service'];
                                @endphp
                                <tr>
                                    <th scope="row" class="text-wrap">({{ $order['service']['category']['name_service_categori'] }}) {{ $order['name_service'] }}</th>
                                    <td class="text-left">${{ $order['price_service'] }}</td>
                                    <td class="text-left">{{ $qty_people }}</td>
                                    <td class="text-right">${{ $qty_people * $order['price_service'] }}</td>
                                </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr class="border-top border-bottom">
                                    <td colspan="3">Total Price</td>
                                    <td class="text-right">${{ $total_price }}</td>
                                </tr>
                                @if($tax !== null)

                                <tr>
                                    <td colspan="3">Total Price + Tax</td>
                                    <td class="text-right">${{ $tax }}</td>
                                </tr>

                                @endif
                                <tr>
                                    <td colspan="3">Deducted Deposit </td>
                                    <td class="text-right">-${{ $deposit_price }}</td>
                                </tr>
                                @if($tax !== null)
                                <tr>
                                    <td colspan="3">Total Payment </td>
                                    <td class="text-right">${{ $tax - $deposit_price }}</td>
                                </tr>

                                @else

                                <tr class="border-top">
                                    <td colspan="3" ><h3 class="fs-1">Total</h3> </td>
                                    <td class="text-right"><h3>${{ $total_price - $deposit_price }}</h3></td>
                                </tr>


                                @endif



                            </tfoot>
                        </table>
                    </div>
                </li>
            </ul>




            <small>PAYMENT EXPLENATION HERE</small>

            <h3>Thank you for your business</h3>
        </div>
    </div>



</html>
