@extends('layouts.main')

@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">History</h1>
    </div>
    <!-- Single Page Header End -->

    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Produk</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Jumlah </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($details as $detail)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="img/vegetable-item-3.png" class="img-fluid me-5 rounded-circle"
                                            style="width: 80px; height: 80px;" alt="">
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4">{{ $detail->produk->nama }}</p>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4">{{ $detail->total_qty }}</p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
