

<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Our Categories</p>
                    <h1>Shop Now</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->
<div class="product-section mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div  class="product-filters">
                    <ul>
                        <li class="active" data-filter="*">All</li>
                        @foreach($categories as $category)
                            <li data-filter=".{{ $category->slug }}">{{ $category->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="row product-lists">
            @foreach($categories as $category)
                @foreach($category->products as $product)
                    <div class="col-lg-4 col-md-6 text-center {{ $category->slug }}">
                        <div class="single-product-item">
                            <div class="product-image">
                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" style="width:300px;height: 200px !important;">
                            </div>
                            <h5>{{ $product->name }}</h5>
                            <p>{{ $product->description }}</p>
                            <h5>Price {{ $product->price }}$</h5>
                            <a style="background: lightsalmon; color: whitesmoke" href="{{ route('product.show', $product->slug) }}" class="btn btn-primary">Add And See More</a>

                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>


    </div>
</div>
<style>
    .category-filters ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-wrap: wrap;
    }

    .category-filters ul li {
        display: inline-block;
        margin: 5px;
        padding: 10px 20px;
        border-radius: 5px;
        background-color: grey;
        border: 1px solid #ddd;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s;
        text-align: center;
        font-size: 14px;
    }

    .category-filters ul li.active {
        background-color: darkorange;
        color: white;
        border-color: orange;
    }

    .category-filters ul li:hover {
        background-color: orange;
    }

</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        // Handle click event on filter items
        $('.product-filters ul li').click(function() {
            // Remove 'active' class from all filter items
            $('.product-filters ul li').removeClass('active');

            // Add 'active' class to the clicked item
            $(this).addClass('active');

            // Get the filter value from the clicked item
            var filterValue = $(this).attr('data-filter');

            // Show or hide product items based on the filter
            if (filterValue === '*') {
                $('.product-lists .col-lg-4').show(); // Show all products
            } else {
                $('.product-lists .col-lg-4').each(function() {
                    // Check if the product has the filter class
                    if ($(this).hasClass(filterValue.slice(1))) {
                        $(this).show(); // Show the product
                    } else {
                        $(this).hide(); // Hide the product
                    }
                });
            }
        });
    });
</script>
<!-- end category -->
