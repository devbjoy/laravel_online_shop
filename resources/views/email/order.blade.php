<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Send Email For Ordering</title>
</head>
<body style="font-size: 16px; font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif">
    
    @if ($data['userType'] == 'customer')
    <h1>Thanks for Your Order !!</h1>
    <h2>Your Order Id Is: #{{ $data['order']->id }}</h2>
    @else
    <h1>Your have received an order</h1>
    <h2>Order Id: #{{ $data['order']->id }}</h2>
    @endif
   
    <div class="col-sm-4 invoice-col">
        <h1 class="h5 mb-3">Shipping Address</h1>
        <address>
            <strong>{{ ucwords($data['order']->first_name) }} {{ $data['order']->last_name }}</strong><br>
            {{ $data['order']->address }}<br>
            {{ $data['order']->country->name }}<br>
            Phone: {{ $data['order']->mobile }}<br>
            Email: {{ $data['order']->email }}
        </address>
        </div>
    <h2>Product Details</h2>
    <table>
        <thead style="background-color: gray">
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>                                        
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @if ($data['order']->items->isNotEmpty())
            @foreach ($data['order']->items as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>${{ number_format($item->price,2) }}</td>                                        
                <td>{{ $item->qty }}</td>
                <td>${{ number_format($item->total,2) }}</td>
            </tr>
            @endforeach
            @endif
            
            <tr>
                <th colspan="3" class="text-right">Subtotal:</th>
                <td>${{ number_format($data['order']->subtotal,2) }}</td>
            </tr>
            <tr>
                <th colspan="3" class="text-right">Discount: {{ (!empty($data['order']->coupon_code)) ? '('.$data['order']->coupon_code .')' : '' }} </th>
                <td>${{ number_format($data['order']->discount,2) }}</td>
            </tr>
            <tr>
                <th colspan="3" class="text-right">Shipping:</th>
                <td>${{ number_format($data['order']->shipping,2) }}</td>
            </tr>
            <tr>
                <th colspan="3" class="text-right">Grand Total:</th>
                <td>${{ number_format($data['order']->grand_total,2) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>