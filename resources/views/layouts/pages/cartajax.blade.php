@section('header')
    @include('layouts.pages.header')
@show


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
                                    <form class="remove-item-form" data-id="{{ $item->id }}">
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
                                    <form class="update-quantity-form" data-id="{{ $item->id }}">
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
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('submit', '.update-quantity-form', function(e) {
        e.preventDefault();

        const form = $(this);
        const itemId = form.data('id');
        const quantity = form.find('input[name="quantity"]').val();

        $.ajax({
            url: '/api/cart/' + itemId,
            method: 'PUT',
            data: {
                quantity: quantity,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // يمكنك تحديث واجهة المستخدم هنا إذا لزم الأمر
                location.reload(); // إعادة تحميل الصفحة لتحديث البيانات
            },
            error: function(xhr) {
                // التعامل مع الأخطاء
            }
        });
    });

    $(document).on('submit', '.remove-item-form', function(e) {
        e.preventDefault();

        const form = $(this);
        const itemId = form.data('id');

        $.ajax({
            url: '/api/cart/' + itemId,
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // إزالة العنصر من واجهة المستخدم
                location.reload(); // إعادة تحميل الصفحة لتحديث البيانات
            },
            error: function(xhr) {
                // التعامل مع الأخطاء
            }
        });
    });
</script>

@section('footer')
    @include('layouts.pages.footer')
@show
