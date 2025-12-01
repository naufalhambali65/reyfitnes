@extends('dashboard.layouts.main')

@section('container')
    <div class="row">
        <div class="col-12">
            {{-- Header --}}
            <div class="card shadow-sm mb-3">
                <div class="card-body d-flex align-items-center gap-3 flex-wrap">
                    <div>
                        <h4 class="mb-0 fw-bold">
                            <i class="fas fa-shopping-bag text-primary me-2"></i> Katalog Produk & Pembelian
                        </h4>
                        <div class="small text-muted">Pilih produk, atur kuantitas, lalu checkout untuk membuat pembayaran.
                        </div>
                    </div>

                    <div class="ms-auto d-flex gap-2">
                        {{-- <a href="{{ route('product-stocks.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a> --}}
                    </div>
                </div>
            </div>
        </div>

        {{-- Left: Product Grid --}}
        <div class="col-md-8 mb-3">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0"><i class="fas fa-box-open me-1"></i> Daftar Produk</h5>
                        <div class="d-flex gap-2">
                            <form method="GET" action="#" class="d-flex">
                                {{-- <input type="text" name="q" class="form-control form-control-sm"
                                    placeholder="Cari produk..." value="{{ request('q') }}">
                                <button class="btn btn-sm btn-primary ms-2"><i class="fas fa-search"></i></button> --}}
                            </form>
                        </div>
                    </div>

                    <div class="row g-3">
                        @foreach ($products as $product)
                            <div class="col-lg-6 col-md-12">
                                <div
                                    class="p-3 border rounded shadow-sm d-flex gap-3 align-items-center
                                    {{ $product->stock <= 0 ? 'border-danger' : ($product->stock <= $product->min_stock ? 'border-warning' : '') }}">

                                    <div style="width:100px;">
                                        @if ($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                alt="{{ $product->name }}" class="img-fluid rounded"
                                                style="height:80px;object-fit:cover;width:100%;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center"
                                                style="height:80px;width:100%;">No image</div>
                                        @endif
                                    </div>

                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-bold">{{ $product->name }}</h6>

                                        <div class="small text-muted mb-1">
                                            {{ $product->category->name ?? '-' }} • {{ $product->unit->name ?? '' }}
                                        </div>

                                        <div class="fw-semibold text-success">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </div>

                                        <div class="small text-muted">
                                            Stok: {{ $product->stock }} • Min: {{ $product->min_stock }}
                                        </div>

                                        <div class="mt-2 d-flex gap-2">
                                            {{-- tombol tambah ke cart --}}
                                            <button type="button" class="btn btn-sm btn-primary add-to-cart-btn"
                                                data-id="{{ $product->id }}" data-name="{{ e($product->name) }}"
                                                data-price="{{ $product->price }}" data-stock="{{ $product->stock }}"
                                                {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                                <i class="fas fa-cart-plus me-1"></i> Tambah
                                            </button>

                                            {{-- <a href="{{ route('product-stocks.show', $product->slug) }}"
                                                class="btn btn-sm btn-secondary">
                                                <i class="fas fa-eye me-1"></i> Detail
                                            </a> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>

        {{-- Right: Cart / Checkout --}}
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="fas fa-shopping-cart me-1"></i> Keranjang Pembelian</h5>

                    <div id="cartEmptyNotice" class="text-center text-muted"
                        @if (session('cart') && count(session('cart')) > 0) style="display:none" @endif>
                        Keranjang masih kosong.
                    </div>

                    <div id="cartItemsWrap">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-end">Qty</th>
                                    <th class="text-end">Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="cartItems">
                                {{-- JS will populate --}}
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <div class="small text-muted">Total</div>
                            <div class="fw-bold" id="cartTotalText">Rp 0</div>
                        </div>

                        <hr>

                        <form id="checkoutForm" action="{{ route('payments.store') }}" method="POST">
                            @csrf
                            {{-- hidden inputs for items will be appended here by JS --}}
                            <div class="mb-3">
                                <label class="form-label">Metode Pembayaran</label>
                                <select name="payment_method" id="paymentMethod" class="form-control" required>
                                    <option value="">-- Pilih Metode Pembayaran --</option>
                                    <option value="transfer">Transfer Bank</option>
                                    <option value="qris">QRIS</option>
                                    <option value="cash">Tunai</option>
                                </select>
                            </div>

                            <div class="mb-3 d-none" id="bankWrapperCheckout">
                                <label class="form-label">Pilih Bank</label>
                                <select name="bank_id" class="form-control" id="bankSelect">
                                    <option value="">-- Pilih Bank --</option>
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}">{{ $bank->display_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Catatan (opsional)</label>
                                <textarea name="notes" class="form-control" rows="3" placeholder="Catatan pembelian (opsional)"></textarea>
                            </div>

                            <input type="hidden" name="amount" id="amountInput" value="0">

                            <div class="d-grid">
                                <button type="button" id="checkoutBtn" class="btn btn-success" disabled>
                                    <i class="fas fa-credit-card me-1"></i> Checkout & Buat Pembayaran
                                </button>
                            </div>
                        </form>

                        {{-- <div class="small text-muted mt-2">Catatan: transaksi akan membuat record di tabel payments dan
                            payment_items (item=Product).</div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Quantity (when adding product) --}}
    <div class="modal fade" id="qtyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form id="qtyForm" onsubmit="return false;">
                    <div class="modal-header">
                        <h5 class="modal-title">Atur Kuantitas</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="qtyProductId">
                        <div class="mb-2"><strong id="qtyProductName"></strong></div>
                        <div class="mb-3">
                            <label class="form-label">Kuantitas</label>
                            <input type="number" id="qtyInput" class="form-control" min="1" value="1"
                                required>
                            <div class="small text-muted mt-1" id="qtyStockNotice"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="confirmAddBtn">Tambah ke Keranjang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // Simple in-memory cart for this page (also render from session if needed)
        let CART = {}; // keys: productId -> { id, name, price, qty, stock }

        // Helper format rupiah
        function formatRupiah(number) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
        }

        // Add-to-cart button handler
        document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const name = this.dataset.name;
                const price = parseFloat(this.dataset.price);
                const stock = parseInt(this.dataset.stock);

                // open qty modal
                document.getElementById('qtyProductId').value = id;
                document.getElementById('qtyProductName').innerText = name;
                document.getElementById('qtyInput').value = 1;
                document.getElementById('qtyStockNotice').innerText = 'Stok tersedia: ' + stock;
                document.getElementById('qtyInput').max = stock || 9999;

                new bootstrap.Modal(document.getElementById('qtyModal')).show();
            });
        });

        // Confirm add
        document.getElementById('confirmAddBtn').addEventListener('click', function() {
            const id = document.getElementById('qtyProductId').value;
            const qty = parseInt(document.getElementById('qtyInput').value) || 1;
            const btn = document.querySelector('.add-to-cart-btn[data-id="' + id + '"]');
            const name = btn.dataset.name;
            const price = parseFloat(btn.dataset.price);
            const stock = parseInt(btn.dataset.stock);

            if (qty < 1) return alert('Kuantitas minimal 1');
            if (stock !== 0 && qty > stock) return alert('Kuantitas melebihi stok');

            if (CART[id]) {
                CART[id].qty += qty;
                if (stock !== 0 && CART[id].qty > stock) CART[id].qty = stock;
            } else {
                CART[id] = {
                    id: id,
                    name: name,
                    price: price,
                    qty: qty,
                    stock: stock
                };
            }

            updateCartUI();
            bootstrap.Modal.getInstance(document.getElementById('qtyModal')).hide();
        });

        // Update cart UI
        function updateCartUI() {
            const tbody = document.getElementById('cartItems');
            tbody.innerHTML = '';

            let total = 0;
            let hasItems = false;

            Object.values(CART).forEach(item => {
                hasItems = true;
                const subtotal = item.price * item.qty;
                total += subtotal;

                const tr = document.createElement('tr');
                tr.innerHTML = `
                <td class="align-middle">${item.name}</td>
                <td class="text-end align-middle">
                    <div class="d-flex justify-content-end align-items-center gap-2">
                        <button class="btn btn-sm btn-outline-secondary decrease-qty" data-id="${item.id}">-</button>
                        <span>${item.qty}</span>
                        <button class="btn btn-sm btn-outline-secondary increase-qty" data-id="${item.id}">+</button>
                    </div>
                </td>
                <td class="text-end align-middle">${formatRupiah(subtotal)}</td>
                <td class="text-center align-middle">
                    <button class="btn btn-sm btn-danger remove-item-btn" data-id="${item.id}"><i class="fas fa-trash"></i></button>
                </td>
            `;
                tbody.appendChild(tr);
            });

            document.getElementById('cartEmptyNotice').style.display = hasItems ? 'none' : 'block';
            document.getElementById('cartTotalText').innerText = formatRupiah(total);
            document.getElementById('amountInput').value = total.toFixed(2);

            // enable checkout if cart not empty
            document.getElementById('checkoutBtn').disabled = !hasItems;

            // bind increase/decrease/remove
            document.querySelectorAll('.increase-qty').forEach(b => b.addEventListener('click', function() {
                const id = this.dataset.id;
                const item = CART[id];
                if (item.stock !== 0 && item.qty + 1 > item.stock) return;
                item.qty++;
                updateCartUI();
            }));

            document.querySelectorAll('.decrease-qty').forEach(b => b.addEventListener('click', function() {
                const id = this.dataset.id;
                const item = CART[id];
                item.qty = Math.max(1, item.qty - 1);
                updateCartUI();
            }));

            document.querySelectorAll('.remove-item-btn').forEach(b => b.addEventListener('click', function() {
                const id = this.dataset.id;
                delete CART[id];
                updateCartUI();
            }));
        }

        // Toggle bank select
        document.getElementById('paymentMethod').addEventListener('change', function() {
            const bankWrap = document.getElementById('bankWrapperCheckout');
            const bankSelect = document.getElementById('bankSelect'); // ID dropdown bank kamu

            if (this.value === 'transfer') {
                bankWrap.classList.remove('d-none');
            } else {
                bankWrap.classList.add('d-none');

                // Reset pilihan bank
                if (bankSelect) {
                    bankSelect.selectedIndex = 0; // reset ke opsi pertama
                    bankSelect.value = ""; // atau kosongkan value
                }
            }
        });

        // Checkout click: build hidden inputs and submit form
        document.getElementById('checkoutBtn').addEventListener('click', function() {
            const form = document.getElementById('checkoutForm');

            // clear previous item inputs
            document.querySelectorAll('input[name^="items"]').forEach(n => n.remove());

            // build items: morph expects item_type and item_id; we'll use App\\Models\\Product
            let index = 0;
            Object.values(CART).forEach(item => {
                // item[index][item_type], item[index][item_id], item[index][quantity], item[index][price], item[index][subtotal]
                const base = `items[${index}]`;

                const itemType = document.createElement('input');
                itemType.type = 'hidden';
                itemType.name = `${base}[item_type]`;
                itemType.value = 'App\\\\Models\\\\Product';
                form.appendChild(itemType);

                const itemId = document.createElement('input');
                itemId.type = 'hidden';
                itemId.name = `${base}[item_id]`;
                itemId.value = item.id;
                form.appendChild(itemId);

                const qty = document.createElement('input');
                qty.type = 'hidden';
                qty.name = `${base}[quantity]`;
                qty.value = item.qty;
                form.appendChild(qty);

                const price = document.createElement('input');
                price.type = 'hidden';
                price.name = `${base}[price]`;
                price.value = item.price;
                form.appendChild(price);

                const subtotal = document.createElement('input');
                subtotal.type = 'hidden';
                subtotal.name = `${base}[subtotal]`;
                subtotal.value = (item.price * item.qty).toFixed(2);
                form.appendChild(subtotal);

                index++;
            });

            // final amount already in amountInput
            // submit (you may want to add confirmation)
            // if (confirm('Buat pembayaran untuk ' + Object.keys(CART).length + ' item?')) {
            //     form.submit();
            // }

            Swal.fire({
                title: 'Konfirmasi Pembayaran',
                text: 'Buat pembayaran untuk ' + Object.keys(CART).length + ' item?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // If backend passed initial cart via session (optional), you can hydrate CART here
        @if (session('cart') && is_array(session('cart')))
            (function() {
                const s = @json(session('cart'));
                for (const id in s) {
                    CART[id] = s[id];
                }
                updateCartUI();
            })();
        @endif
    </script>
@endsection
