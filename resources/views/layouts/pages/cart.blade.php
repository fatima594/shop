@section('header')
    @include('layouts.pages.header')
@show



<!-- cart -->

<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Fresh and Organic</p>
                    <h1>Cart</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->
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

<div class="cart-section mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="cart-table-wrap">
                    <table class="cart-table">
                        <thead class="cart-table-head">
                        <tr class="table-head-row">
                            <th class="product-remove"></th>
                            <th class="product-image">Product Image</th>
                            <th class="product-name">Name</th>
                            <th class="product-price">Price</th>
                            <th class="product-quantity">Quantity</th>
                            <th class="product-total">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($cartItems as $item)
                            <tr class="table-body-row">
                                <td class="product-remove">
                                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"><i class="far fa-window-close"></i></button>
                                    </form>
                                </td>
                                <td class="product-image">
                                    <img src="{{ Storage::url($item->product->image) }}" alt="{{ $item->product->name }}" style="width:50px;height: 50px !important;">

                                </td>
                                <td class="product-name">{{ $item->product->name }}</td>
                                <td class="product-price">${{ $item->product->price }}</td>
                                <td class="product-quantity">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1">
                                        <button type="submit">Update</button>
                                    </form>
                                </td>
                                <td class="product-total">${{ $item->product->price * $item->quantity }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

            <div class="col-lg-4">
                <div class="total-section">
                    <table class="total-table">
                        <thead class="total-table-head">
                        <tr class="table-total-row">
                            <th>Total</th>
                            <th>Price</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="total-data">
                            <td><strong>Subtotal: </strong></td>
                            <td>${{ $subtotal }}</td>
                        </tr>
                        <tr class="total-data">
                            <td><strong>Shipping: </strong></td>
                            <td>${{ $shipping }}</td>
                        </tr>
                        <tr class="total-data">
                            <td><strong>Total: </strong></td>
                            <td>${{ $total }}</td>
                        </tr>
                        </tbody>


                    </table>


                    <div class="cart-buttons">
                        <a href="{{ route('orders.index') }}" class="boxed-btn black">Check Out</a>
                    </div>
                </div>

{{--                <div class="coupon-section">--}}
{{--                    <h3>Apply Coupon</h3>--}}
{{--                    <div class="coupon-form-wrap">--}}
{{--                        <form action="index.html">--}}
{{--                            <p><input type="text" placeholder="Coupon"></p>--}}
{{--                            <p><input type="submit" value="Apply"></p>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
</div>
<!-- end cart -->


<!-- footer -->
@section('footer')
    @include('layouts.pages.footer')
@show
