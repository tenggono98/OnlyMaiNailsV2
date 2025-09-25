<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>OnlyMaiNails</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div class="py-6 container-fluid min-vh-100 d-flex align-items-center justify-content-center ">

        <div class="p-4 bg-white rounded " style="max-width: 49rem; margin: auto;">



            <div class="table-responsive">
                <table class="table table-borderless table-sm">
                    <tbody>
                        <td>
                    <img src="https://onlymainails.alfonso-tenggono.online/img/transparant-logo-v2.png" class="img-fluid" alt="OnlyMaiNails" style="height: 7.5rem;">

                        </td>
                        <td>

                            <p class="mb-1 h4">OnlyMaiNails</p>
                            <small>{{ $address }}</small><br>
                            <small>Email : {{ $email }}</small>

                        </td>
                    </tbody>

                </table>

            </div>

            <p>Dear, <span class="fs-3">{{ $clientName }}</span></h>

            {{-- Appointment Details --}}
            <ul class="list-unstyled">
                <li><p class="">Appointment Details</p></li>
                <li><small>Here, you’ll see a quick overview of your appointment. It includes the type of service you booked, along with the date and time. This helps you double-check everything before your visit.</small></li>
                <li>
                    <div class="mt-3 table-responsive">
                        <table class="table table-borderless table-sm">
                            <tbody>
                                <tr>
                                    <th scope="row">Date</th>
                                    <td>{{ $booking_date }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Time</th>
                                    <td>{{ $booking_time }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </li>
            </ul>

            {{-- Summary of Order --}}
            <ul class="list-unstyled">
                <li><p class="">Summary Of Order</p></li>
                <li><small>This section shows what you’ve ordered, including each item or service and its price. It gives you a clear picture of what you're paying for and the total amount.</small></li>
                {{-- <li><p>Number of People : <span class="">{{ $qty_people }}</span></p></li> --}}
                <li>
                    <div class="mt-3 table-responsive">
                        <table class="table table-borderless table-sm">
                            <thead class="table-light ">
                                <tr>
                                    <th scope="">Service Name</th>
                                    <th scope="">Price</th>
                                    <th scope="" class="text-right">Subtotal</th>
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
                                    <td class="text-right">${{ $qty_people * $order['price_service'] }}</td>
                                </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2">Total Price</td>
                                    <td class="text-right">${{ $total_price }}</td>
                                </tr>
                                @if($tax !== null)

                                <tr>
                                    <td colspan="2">Total Price + Tax</td>
                                    <td class="text-right">${{ $tax }}</td>
                                </tr>

                                @endif
                                <tr>
                                    <td colspan="2">Deducted Deposit </td>
                                    <td class="text-right">-${{ $deposit_price }}</td>
                                </tr>
                                @if($tax !== null)
                                <tr>
                                    <td colspan="2">Total Payment </td>
                                    <td class="text-right">${{ $tax - $deposit_price }}</td>
                                </tr>

                                @else

                                <tr>
                                    <td colspan="2">Total Payment </td>
                                    <td class="text-right">${{ $total_price - $deposit_price }}</td>
                                </tr>


                                @endif



                            </tfoot>
                        </table>
                    </div>
                </li>
            </ul>

            {{-- Location Detail --}}
            <ul class="list-unstyled">
                <li><p class="">Location Detail</p></li>
                <li><small>This part tells you where to go for your appointment. It includes the address and any important details you might need to find us easily.</small></li>
                <li>
                    <div class="mt-3 table-responsive">
                        <table class="table table-borderless table-sm">
                            <tbody>
                                <tr>
                                    <th scope="row">Address</th>
                                    <td>{{ $address }}</td>
                                </tr>
                                {{-- <tr>
                                    <th scope="row">Notes</th>
                                    <td>(There is very little parking at the front as the studio is on a busy street, but there are spots a little further down) Not liable for any tickets/towing</td>
                                </tr> --}}
                                <tr>
                                    <th scope="row">Google Maps Links</th>
                                    <td><a href="{{ $gmaps }}" class="text-decoration-underline" target="_blank">{{ $address }}</a><br>
                                    <a href="{{ $gmaps }} ">({{ $gmaps }})</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </li>
            </ul>

            {{-- Reschedule Link --}}
            <ul class="list-unstyled">
                <li><p class="">Change Appointment</p></li>
                <li><small>If you need to reschedule or change your appointment, click this link. It’s an easy way to update your booking to a new time that works better for you.</small></li>
                <li>
                    <div class="mt-3 table-responsive">
                        <table class="table table-borderless table-sm">
                            <tbody>
                                <tr>
                                    <td>
                                        <a href="{{ route('book') .'/'. $reschedule_token }}" class="btn btn-outline-primary ">Change</a><br>
                                        <a href="{{ route('book') .'/'. $reschedule_token }}">({{ route('book') .'/'. $reschedule_token}})</a>
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </li>
            </ul>

            <small>Thank You for Your Order! We appreciate your business and are delighted to serve you. If you have any questions or need further assistance, please feel free to reach out. Enjoy your purchase!</small>
        </div>
    </div>



</html>
