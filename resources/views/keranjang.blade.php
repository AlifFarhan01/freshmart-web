<!-- resources/views/keranjang.blade.php -->
<div id="cartSidebar" class="cart-sidebar">
    <a href="javascript:void(0)" class="closebtn" onclick="closeCart()">×</a>
    <h2 style="padding:10px;">Your Cart</h2>
    <div class="table-responsive" style="max-height: 400px; overflow-y: auto; padding:10px;">
        <table class="table">
            <thead style="font-size: 10px;">
                <tr>
                    <th scope="col">Products</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Total</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody id="cart-table-body">
                <!-- Rows will be inserted here by JavaScript -->
            </tbody>
        </table>
    </div>
    <div id="cart-items"></div>
    <div class="total-container d-flex justify-content-center py-3 border-bottom border-top">
        <p class="mb-0 text-dark text-uppercase">TOTAL: <span id="total-price">0</span></p>

    </div>
    <div class="d-flex justify-content-center mt-4">
        <button class="btn border-secondary rounded-pill px-4 py-3 text-primary" type="button"
            onclick="addTransaksi()">Bayar</button>
    </div>
</div>

<a href="javascript:void(0)" class="position-relative me-4 my-auto" onclick="openCart()">
    <i class="fa fa-shopping-bag fa-2x"></i>
    <span id="cart-count"
        class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1"
        style="top: -5px; left: 15px; height: 20px; min-width: 20px;">0</span>
</a>

<script>
    function openCart() {
        if (window.innerWidth < 768) {
            document.getElementById("cartSidebar").style.width = "100%"; // Versi mobile
        } else {
            document.getElementById("cartSidebar").style.width = "30%"; // Versi desktop
        }

        loadCartItems();
    }

    function closeCart() {
        document.getElementById("cartSidebar").style.width = "0";
    }

    function loadCartItems() {
        fetch("{{ route('keranjang.items') }}")
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                let cartTableBody = '';
                let totalPrice = 0;

                if (data.length > 0) {
                    data.slice(0, 5).forEach(item => { // Show only the first 5 items
                        const itemTotal = item.produk.harga * item.qty;
                        totalPrice += itemTotal;

                        cartTableBody += `
                            <tr style="font-size: 10px; width:100%;">
                                <th scope="row" style="vertical-align: middle;">
                                    <div>
                                        <img src="/storage/${item.produk.image}" class="img-fluid rounded-circle" style="width: 30px; height: 30px;" alt="${item.produk.nama}"><br>
                                    </div>
                                </th>
                                <td style="vertical-align: middle;">
                                    ${item.produk.nama}
                                </td>
                                <td style="vertical-align: middle;">Rp ${item.produk.harga.toLocaleString('id-ID')}</td>
                                <td style="vertical-align: middle;">${item.qty}</td>
                                <td style="vertical-align: middle;">Rp ${itemTotal.toLocaleString('id-ID')}</td>
                                <td style="vertical-align: middle;"><button class="btn btn-md rounded-circle bg-light border" onclick="deleteCartItem(${item.id})" >
                                    <i class="fa fa-times text-danger"></i>
                                </button></td>
                            </tr>
                        `;
                    });
                } else {
                    cartTableBody = '<tr><td colspan="6"><p>Keranjang anda kosong.</p></td></tr>';
                }

                document.getElementById('cart-table-body').innerHTML = cartTableBody;
                document.getElementById('total-price').innerText = totalPrice.toLocaleString('id-ID');
                document.getElementById('cart-count').innerText = data.length;
            })
            .catch(error => console.error('Error loading cart items:', error));
    }

    function addTransaksi() {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let totalText = document.getElementById('total-price').innerText;
        let total = parseFloat(totalText);
        fetch("{{ route('transaksi.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({
                    total
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw new Error(errorData.message || 'Unknown error');
                    });
                }
                return response.json();
            })
            .then(data => {
                alert('Transaksi berhasil disimpan');
                // Reset cart after successful transaction
                var reviewModal = new bootstrap.Modal(document.getElementById('reviewModal'), {
                    keyboard: false
                });
                reviewModal.show();
                loadCartItems();
            })
            .catch(error => {
                console.error('Error saving transaction:', error);
                alert('Terjadi kesalahan saat menyimpan transaksi: ' + error.message);
            });
    }


    function deleteCartItem(itemId) {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(`{{ route('keranjang.delete', ['id' => '__id__']) }}`.replace('__id__', itemId), {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                // Reload cart items after successful deletion
                loadCartItems();
            })
            .catch(error => console.error('Error deleting item:', error));
    }

    loadCartItems();
</script>
