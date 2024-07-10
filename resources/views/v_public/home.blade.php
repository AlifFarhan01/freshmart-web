<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penjualan Produk</title>
    <link rel="stylesheet" href="styles.css">
</head>

<style>
    /* Reset some default styles */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

/* Basic styling for the container */
.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

/* Styling for the product items */
.product {
    display: flex;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    padding: 10px;
}

.product img {
    width: 150px;
    height: 150px;
    object-fit: cover;
    margin-right: 10px;
}

.product-info {
    flex: 1;
}

.product-info h2 {
    font-size: 1.2em;
    margin-bottom: 10px;
}

.product-info .price {
    font-size: 1.1em;
    color: green;
}

.buy-btn {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 8px 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.buy-btn:hover {
    background-color: #0056b3;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .product {
        flex-direction: column;
    }

    .product img {
        width: 100%;
        margin-right: 0;
        margin-bottom: 10px;
    }
}

</style>
<body>
    <div class="container">
        <h1>Daftar Produk</h1>
        @foreach ($produk as $item)
            
        <div class="product">
            <div class="product-info">
                <h2>{{ $item['nama'] }}</h2>
                <p class="price">Rp.{{ $item['harga'] }}</p>
                <button class="buy-btn">Beli</button>
            </div>
        </div>
    
        @endforeach
    </div>
</body>
</html>
