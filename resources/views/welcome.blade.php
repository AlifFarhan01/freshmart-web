@extends('layouts.main')
@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success"role="alert">
            {{ Session::get('success') }}
        </div>
    @endif

    <!-- Modal Search Start -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center">
                    <div class="input-group w-75 mx-auto d-flex">
                        <input type="search" class="form-control p-3" placeholder="keywords"
                            aria-describedby="search-icon-1">
                        <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Search End -->

    <!-- Hero Start -->
    <div class="container-fluid py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-md-12 col-lg-7">
                    <h4 class="mb-3 text-secondary">100% Organic Foods</h4>
                    <h1 class="mb-5 display-3 text-primary">Organic Veggies & Fruits Foods</h1>
                    <div class="position-relative mx-auto">
                        <input class="form-control border-2 border-secondary w-75 py-3 px-4 rounded-pill" type="number"
                            placeholder="Search">
                        <button type="submit"
                            class="btn btn-primary border-2 border-secondary py-3 px-4 position-absolute rounded-pill text-white h-100"
                            style="top: 0; right: 25%;">Submit Now</button>
                    </div>
                </div>
                <div class="col-md-12 col-lg-5">
                    <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active rounded">
                                <img src="{{ asset('template/img/hero-img-1.png') }}"
                                    class="img-fluid w-100 h-100 bg-secondary rounded" alt="First slide">
                                <a href="#" class="btn px-4 py-2 text-white rounded">Fruites</a>
                            </div>
                            <div class="carousel-item rounded">
                                <img src="{{ asset('template/img/hero-img-2.jpg') }}" class="img-fluid w-100 h-100 rounded"
                                    alt="Second slide">
                                <a href="#" class="btn px-4 py-2 text-white rounded">Vesitables</a>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselId"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselId"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->

    <!-- Fruits Shop Start-->
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <h1 class="mb-4">Fresh fruits shop</h1>
            <div class="row g-4 justify-content-center">
                @foreach ($produk as $index => $item)
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="rounded position-relative fruite-item" style="height: 400px;">
                            <div class="fruite-img" style="height: 235px;">
                                <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid w-100 rounded-top"
                                    alt="{{ $item->name }}" style="height: 100%;">
                            </div>
                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                style="top: 10px; left: 10px;">{{ $item->kategori->name }}</div>
                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                <h4>{{ $item->nama }}</h4>
                                <p class="description">{{ $item->deskripsi }}</p>
                                <p class="text-dark fs-5 fw-bold mb-4">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                                <div class="d-flex align-items-center">
                                    <button class="btn border border-secondary rounded-pill px-3 text-primary"
                                        onclick="decreaseQty({{ $index }})">-</button>
                                    <span id="qty-{{ $index }}" class="mx-2">1</span>
                                    <button class="btn border border-secondary rounded-pill px-3 text-primary"
                                        onclick="increaseQty({{ $index }})">+</button>

                                    @if (Auth::check())
                                        <form id="cart-form-{{ $index }}" data-index="{{ $index }}">
                                            @csrf
                                            <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
                                            <input type="hidden" name="id_produk" value="{{ $item->id }}">
                                            <input type="hidden" name="qty" id="form-qty-{{ $index }}"
                                                value="1">
                                            <button type="button"
                                                class="btn border border-secondary rounded-pill px-3 text-primary ms-auto"
                                                onclick="submitCartForm({{ $index }})">
                                                <i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}"
                                            class="btn border border-secondary rounded-pill px-3 text-primary ms-auto">
                                            <i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach



                <div class="col-12">
                    <div class="pagination d-flex justify-content-center mt-5">
                        @if ($produk->onFirstPage())
                            <a href="#" class="rounded disabled" aria-disabled="true">&laquo;</a>
                        @else
                            <a href="{{ $produk->previousPageUrl() }}" class="rounded">&laquo;</a>
                        @endif

                        @foreach (range(1, $produk->lastPage()) as $i)
                            @if ($i == $produk->currentPage())
                                <a href="#" class="active rounded">{{ $i }}</a>
                            @else
                                <a href="{{ $produk->url($i) }}" class="rounded">{{ $i }}</a>
                            @endif
                        @endforeach

                        @if ($produk->hasMorePages())
                            <a href="{{ $produk->nextPageUrl() }}" class="rounded">&raquo;</a>
                        @else
                            <a href="#" class="rounded disabled" aria-disabled="true">&raquo;</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Fruits Shop End-->



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fetch the initial cart count
            fetch('/cart-count')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('cart-count').innerText = data.cartCount;
                });

            window.submitCartForm = function(index) {
                const form = document.getElementById('cart-form-' + index);
                const formData = new FormData(form);

                fetch('{{ route('keranjang.store') }}', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('cart-count').innerText = data.cartCount;
                            alert(data.success);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });

            };

            window.increaseQty = function(index) {
                let qtyElement = document.getElementById('qty-' + index);
                let formQtyElement = document.getElementById('form-qty-' + index);
                let qty = parseInt(qtyElement.innerText);
                qty++;
                qtyElement.innerText = qty;
                formQtyElement.value = qty;
            };

            window.decreaseQty = function(index) {
                let qtyElement = document.getElementById('qty-' + index);
                let formQtyElement = document.getElementById('form-qty-' + index);
                let qty = parseInt(qtyElement.innerText);
                if (qty > 1) {
                    qty--;
                    qtyElement.innerText = qty;
                    formQtyElement.value = qty;
                }
            };
        });
    </script>
@endsection
