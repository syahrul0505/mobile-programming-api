<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Triple N</title>
    <style>
        * {
            font-size: 14px;
            font-family: 'Times New Roman';
        }

        td, th, tr, table {
            border-top: 1px solid black;
            border-collapse: collapse;
            padding: 4px;
        }

        td.description, th.description {
            width: 120px;
            max-width: 120px;
        }

        td.quantity, th.quantity {
            width: 100px;
            max-width: 20px;
            word-break: break-all;
            text-align: center;
        }

        td.price, th.price {
            width: 80px;
            max-width: 80px;
            word-break: break-all;
            text-align: center;
        }

        .centered {
            text-align: center;
            align-content: center;
            margin: 0;
            font-weight: 400;
        }

        .ticket {
            width: 100%;
            text-align: center;
        }

        img {
            width: 100px;
        }

        @media print {
            .hidden-print, .hidden-print * {
                display: none !important;
            }
        }

        @page {
            size: 70mm 180mm;
            margin: 5;
        }

        .head__text {
            text-align: center;
            font-size: 18px;
            font-weight: 700;
            padding: 0;
        }

        .line {
            width: 100%;
            border-top: 1px dashed #3f3f3f;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .invoiceNumber {
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding-left: 5px;
            padding-right: 5px;
            text-align: left;
            margin-top: 3px;
            margin-bottom: 3px;
        }

        .invoiceNumber > div {
            font-weight: 400;
        }
    </style>
</head>
<body>
   
    <div class="ticket">
        {{-- <img src="{{ asset('assets/images/logo/logo-print.jpg') }}" alt="Logo"> --}}
        {{-- <div class="line"></div> --}}
        <h2 class="head__text">Triple N Bengkel
            <span class="centered">
                {{-- <br>Bundaran Ciater, Tanggerang Selatan --}}
                <br>
            </span>
        </h2>
        <div class="line"></div>

        <div class="invoiceNumber">
            <div style="margin-left: 2px;">
                No. Invoice:
                <span style="float: right; margin-right: 15px;">#{{ $orders->invoice_no }}</span>
            </div>
        </div>

        @if ($orders->tipe_pemesanan == null)
            
        <div class="invoiceNumber">
            <div style="margin-left: 2px;">
                Metode Pembayaran:
                <span style="float: right; margin-right: 15px;"> {{ $orders->metode_pembayaran }}</span>
            </div>
        </div>

        @elseif($orders->tipe_pemesanan == "QR-BJB")
            <div style="margin-left: 2px;">
                Metode Pembayaran:
                <span style="float: right; margin-right: 10px;"> {{ $orders->metode_pembayaran }}</span>
            </div>
        @else
        
        <div class="invoiceNumber">
            <div style="margin-left: 2px;">
                Metode Pembayaran:
                <span style="float: right; margin-right: 15px;"> {{ $orders->metode_edisi }}</span>
            </div>
        </div>
        @endif
        
        <div class="invoiceNumber">
            <div style="margin-left: 2px;">
                Datetime:
                <span style="float: right; margin-right: 15px;">{{ $orders->created_at }}</span>
            </div>
        </div>
        <div class="line"></div>

        <div class="invoiceNumber">
            <div style="margin-left: 2px;">
                Customer:
                <span style="float: right; margin-right: 15px;">{{ $orders->name ?? '-' }} </span>
            </div>
        </div>

        <div class="invoiceNumber">
            <div style="margin-left: 2px;">
                Kasir:
                <span style="float: right; margin-right: 15px;">{{ $orders->user->name ?? '-' }} </span>
            </div>
        </div>

        <div style="margin-bottom: 5px"></div>
        <table>
            <thead>
                <tr>
                    <th class="quantity">Menu</th>
                    <th class="description">Qty</th>
                    <th class="price">Price</th>
                </tr>
            </thead>
            <tbody>

            @php
            
            $totalPrice = 0;
            @endphp
                @foreach ($orders->orderDetail as $orderPivot)
                    <tr>
                        <td class="quantity">{{ $orderPivot->restaurant->name }}</td>
                        <td class="description" style="text-align: center">{{ $orderPivot->qty }}</td>
                        <td class="price" style="text-align: right">Rp.{{ number_format($orderPivot->price_discount * $orderPivot->qty,0) }}</td>
                    </tr>
                    @php
                    // Calculate the running total for each item
                    $totalPrice += $orderPivot->price_discount * $orderPivot->qty ;
                    @endphp
                    {{-- {{ dd($orderPivot) }} --}}

                @endforeach
                
                <tr>
                    <td class="quantity"> &nbsp;</td>
                    <td class="description">&nbsp;</td>
                    <td class="price" style="text-align: right">&nbsp;</td>
                </tr>

                <tr>
                    <td class="quantity">&nbsp;</td>
                    <td class="description">Sub Total</td>
                    <td class="price" style="text-align: right">Rp.{{ number_format($totalPrice,0) }}</td>
                </tr>

                @if ($orders->pb01 != 0)
                <tr style="margin-top: 20px !important;">
                    <td class="quantity"></td>
                    <td class="description">PB01</td>
                    <?php
                        $biaya_pb01 = $totalPrice * $orders->persentase_pb01/100;
                    ?>
                    <td class="price" style="text-align: right">Rp.{{ number_format($biaya_pb01,0) }}</td>
                </tr>
                    
                <tr>
                    <td class="quantity">&nbsp;</td>
                    <td class="description">Sub Total</td>
                    <?php
                        $total = $totalPrice + $biaya_pb01;
                    ?>
                    <td class="price" style="text-align: right">Rp.{{ number_format($total,0) }}</td>
                </tr>
                @else
                <tr>
                    <td class="quantity"></td>
                    <td class="description">Total</td>
                    <?php
                        $totalAll = $orders->total_price;
                    ?>
                    <td class="price" style="text-align: right">Rp.{{ number_format($totalAll)}}</td>
                </tr>
                @endif

                
                @if ($orders->cash != 0)
                                                                
                <tr>
                    <td class="" colspan="2">Kembalian Cash</td>
                    <td class="price" style="text-align: right">Rp.{{ number_format($orders->kembalian)}}</td>
                </tr>
                @endif
                
            </tbody>
        </table>

        <div class="line"></div>
        <p class="centered" style="margin-top: 10px; font-weight: 600;">Thanks for your purchase!</p>
        <div class="line"></div>
    </div>
</body>
</html>