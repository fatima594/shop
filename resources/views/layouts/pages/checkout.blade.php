


@section('header')
    @include('layouts.pages.header')
@show


<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Fresh and Organic</p>
                    <h1>Check Out</h1>
                </div>
            </div>
        </div>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- check out section -->
<div class="checkout-section mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="checkout-accordion-wrap">
                    <div class="accordion" id="accordionExample">
                        <!-- Billing Address -->
                        <div class="card single-accordion">
                            <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Billing Address
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="billing-address-form">
                                        <form action="{{ route('orders.store') }}" method="POST">
                                            @csrf
                                            <p><input type="text" name="name" placeholder="Name" required></p>
                                            <p><input type="email" name="email" placeholder="Email" required></p>
                                            <p><input type="text" name="address" placeholder="Address" required></p>
                                            <p><input type="tel" name="phone" placeholder="Phone" required></p>
                                            <p><input type="text" name="total" placeholder="Total" required></p>


                                            <p><textarea name="bill" id="bill" cols="30" rows="10" placeholder="Say Something"></textarea></p>

                                            <p><input type="text" name="shipping_address" placeholder="Shipping Address" required></p>
                                            <p><input type="text" name="shipping_cost" placeholder="shipping cost" required></p>

                                            <p><input type="text" name="card_number" placeholder="Card Number" required></p>
                                            <p><input type="text" name="card_expiry" placeholder="Expiry Date" required></p>
                                            <p><input type="text" name="card_cvc" placeholder="CVC" required></p>

                                            <!-- بيانات العناصر (items) -->
                                            <div id="order-items">
                                                <p><input type="text" name="items[0][product_name]" placeholder="Product 1 Name" required></p>
                                                <p><input type="number" name="items[0][quantity]" placeholder="Quantity" required></p>
                                                <p><input type="text" name="items[0][price]" placeholder="Price" required></p>
                                            </div>


                                            <button type="submit" class="boxed-btn">Place Order</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="order-details-wrap">
                    <table class="order-details">
                        <thead>
                        <tr>
                            <th>Your order Details</th>
                            <th>Price</th>
                        </tr>
                        </thead>
                        <tbody class="order-details-body">
                        @foreach ($orders as $order)
                            @foreach ($order->items as $item)
                                <tr>
                                    <td>{{ $item->product_name }}</td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                        </tbody>
                        <tbody class="checkout-details">
                        @php
                            $subtotal = $orders->flatMap->items->sum('total');
                            $shipping = 50; // Example shipping cost, adjust as needed
                            $total = $subtotal + $shipping;
                        @endphp
                        <tr>
                            <td>Subtotal</td>
                            <td>${{ number_format($subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Shipping</td>
                            <td>${{ number_format($shipping, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td>${{ number_format($total, 2) }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end check out section -->


@section('footer')
    @include('layouts.pages.footer')
@show
