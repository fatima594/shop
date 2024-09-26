<h1 style="text-align: center">Our Products</h1>

<div class="product-section mt-150 mb-150">
    <div class="container">
        <div class="row product-lists">
            @foreach($products as $product)
                <div class="col-lg-4 col-md-6 text-center strawberry">
                    <div class="single-product-item">
                        <div class="product-image">
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" style="width:300px;height: 200px !important;">
                        </div>
                        <h3>{{ $product->name }}</h3>
                        <p>{{ $product->description }}</p>
                        <p>Quantity: {{ $product->quantity }}</p>
                        <h5>Price: {{ $product->price }}$</h5>
                        <p class="product-price"><span>kg: {{ $product->weight }}</span></p>
                        <form class="add-to-cart-form" data-product-id="{{ $product->id }}">
                            @csrf
                            <input type="number" name="quantity" value="1" min="1">
                            <button type="submit" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div id="message"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).on('submit', '.add-to-cart-form', function(e) {
        e.preventDefault();

        const form = $(this);
        const productId = form.data('product-id');
        const quantity = form.find('input[name="quantity"]').val();

        $.ajax({
            url: '/api/cart',
            method: 'POST',
            data: {
                product_id: productId,
                quantity: quantity,
                _token: '{{ csrf_token() }}' // تأكد من تضمين CSRF token
            },
            success: function(response) {
                $('#message').html('<div class="alert alert-success">' + response.message + '</div>');
            },
            error: function(xhr) {
                const errors = xhr.responseJSON.errors;
                let errorMessage = '<div class="alert alert-danger"><ul>';
                $.each(errors, function(key, value) {
                    errorMessage += '<li>' + value[0] + '</li>';
                });
                errorMessage += '</ul></div>';
                $('#message').html(errorMessage);
            }
        });
    });
</script>
