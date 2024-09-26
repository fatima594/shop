<h1 style="text-align: center">Our Products</h1>


<!-- products -->
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
                        <form action="{{ route('cart.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="number" name="quantity" value="1" min="1">
                            <button type="submit" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- end products -->
