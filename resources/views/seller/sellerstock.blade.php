@extends('seller.layouts.master')

@section('content')
    <style>
   :root {
            --primary-blue: #071835;
            --light-highlight: #b5cbf0;
            --dark-navy: #071835;
            --deep-background: #010813;
            --text-main: #01060e;
            --white: #ffffff;
            --black: #000000;
            --gray-bg: #f3f4f6;
            --gray-border: #e5e7eb;
            --text-muted: #6b7280;

            /* Structural mapping to replace the old variables seamlessly */
            --bg-color: var(--gray-bg);
            --card-bg: var(--white);
            --text-sub: var(--text-muted);
            --border-color: var(--gray-border);
            --shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        body {
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
            background-color: var(--bg-color);
            margin: 0;
            padding: 40px 20px;
            color: var(--text-main);
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            width: 100%;
            box-sizing: border-box;
        }

        .card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 24px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
            width: 115%;
            box-sizing: border-box;
            margin-left : -77px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 15px;
        }

        .card-title {
            font-size: 18px;
            font-weight: 700;
            margin: 0;
            color: var(--text-main);
        }

        .btn-add-main {
            background-color: var(--primary-blue);
            color: var(--white);
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
            border: none;
            cursor: pointer;
            white-space: nowrap;
        }

        .btn-add-main:hover {
            background-color: var(--dark-navy);
            opacity: 0.9;
            transform: translateY(-2px);
        }

        /* Modal Overlay */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(1, 8, 19, 0.6);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            backdrop-filter: blur(5px);
            padding: 15px;
            box-sizing: border-box;
        }

        .modal-content {
            background: var(--white);
            width: 100%;
            max-width: 450px;
            border-radius: 20px;
            padding: 30px;
            position: relative;
            animation: fadeIn 0.3s ease-out;
            max-height: 90vh;
            overflow-y: auto;
            color: var(--text-main);
            box-sizing: border-box;
            margin-left: 251px;
            margin-top: 41px;
        }
        .modal-content1 {
            background: var(--white);
            width: 100%;
            max-width: 450px;
            border-radius: 20px;
            padding: 30px;
            position: relative;
            animation: fadeIn 0.3s ease-out;
            max-height: 90vh;
            overflow-y: auto;
            color: var(--text-main);
            box-sizing: border-box;
            margin-left: 600px;
            margin-top: 41px;
        }

        @keyframes fadeIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .close-modal {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 28px;
            cursor: pointer;
            color: var(--text-sub);
        }

        .add-card {
            text-align: center;
        }

        .icon-box {
            font-size: 40px;
            margin-bottom: 10px;
        }

        .add-text {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--text-main);
        }

        .description {
            color: var(--text-sub);
            font-size: 13px;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            text-align: left;
            gap: 10px;
        }

        label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-main);
        }

        input,
        textarea,
        select {
            padding: 12px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            outline: none;
            background: var(--gray-bg);
            font-family: inherit;
            color: var(--text-main);
            width: 100%;
            box-sizing: border-box;
        }

        .qty-box {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .qty-box button {
            background: var(--gray-bg);
            color: var(--text-main);
            border: none;
            padding: 10px 15px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 6px;
            font-weight: bold;
        }

        .qty-box input {
            text-align: center;
            width: 80px;
            padding: 10px;
            background: var(--white);
        }

        .table-responsive {
            overflow-x: auto;
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 15px;
            background: var(--gray-bg);
            color: var(--text-sub);
            font-size: 12px;
            text-transform: uppercase;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            font-size: 14px;
            color: var(--text-main);
        }

        .td-img {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            object-fit: cover;
        }

        .editbutton,
        .deletebutton {
            border: none;
            background: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px;
        }

        .editbutton {
            color: var(--primary-blue);
        }

        .deletebutton {
            color: var(--text-muted);
        }

        .breadcrumb {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: var(--text-sub);
            margin-bottom: 15px;
        }

        .breadcrumb span {
            margin-right: 5px;
        }

        .breadcrumb .arrow {
            color: var(--text-muted);
        }

        .breadcrumb .active {
            color: var(--black);
            font-weight: bold;
        }

        .search-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .search-input {
            padding-left: 35px;
            padding-right: 15px;
            padding-top: 10px;
            padding-bottom: 10px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            width: 250px;
            background: var(--white);
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            pointer-events: none;
        }

        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .scard {
            padding: 20px;
            border-radius: 12px;
            background: var(--white);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-color);
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .scard h3 {
            font-size: 22px;
            margin: 5px 0 0 0;
            color: var(--text-main);
        }

        .scard span {
            font-size: 14px;
            color: var(--text-sub);
        }

        .modal-footer {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-cancel {
            flex: 1;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            background: var(--white);
            color: var(--text-sub);
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-cancel:hover {
            background: var(--gray-bg);
        }

        .btn-save {
            flex: 1;
            padding: 12px;
            border-radius: 10px;
            border: none;
            background: var(--primary-blue);
            color: var(--white);
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-save:hover {
            background-color: var(--dark-navy);
            opacity: 0.9;
            transform: translateY(-2px);
        }

        @media screen and (max-width: 768px) {
            body {
                padding: 20px 10px;
            }

            .card {
                padding: 15px;
                margin-left: -1px;
                width: 247px;
            }

            .card-header {
                flex-direction: column;
                align-items: stretch;
            }

            .card-header > div {
                display: flex;
                flex-direction: column;
                gap: 10px;
                width: 100%;
            }

            .search-input {
                width: 100%;
            }

            .btn-add-main {
                justify-content: center;
                width: 100%;
            }

            .modal-content {
                padding: 20px;
                margin-left: 0px;
            }
            .modal-content1{
                margin-left:0px
            }

            thead {
                display: none;
            }

            tbody tr {
                display: block;
                background: var(--white);
                margin-bottom: 15px;
                padding: 10px;
                border-radius: 12px;
                border: 1px solid var(--border-color);
            }

            tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 0;
                border-bottom: 1px solid var(--gray-bg);
                text-align: right;
            }

            tbody td:last-child {
                border-bottom: none;
            }

            tbody td::before {
                content: attr(data-label);
                font-weight: 600;
                color: var(--text-sub);
                text-align: left;
                padding-right: 10px;
            }
            
            tbody td div {
                justify-content: flex-end;
            }
        }

        @media screen and (max-width: 480px) {
            .card-title {
                font-size: 16px;
            }

            tbody td {
                font-size: 13px;
                padding: 8px 0;
            }

            .td-img {
                width: 32px;
                height: 32px;
            }
        }
</style>

    <div class="breadcrumb">
        <span>Home</span>
        <span class="arrow">›</span>
        <span class="active">Stock</span>
    </div>

    <div class="dashboard-cards">
        <div class="scard">
            <span>Total Products</span>
            <h3>{{ isset($items) ? count($items) : 0 }}</h3>
        </div>
<div class="scard">
    <span>Low Stock</span>
    <h3>{{ $lowStockCount }}</h3>
</div>
<div class="scard">
    <span>Out of Stock</span>
    <h3>{{ $outOfStockCount }}</h3>
</div>
    </div>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Manage Stock</h2>
                <div style="display:flex; gap:10px; align-items:center;">
                    <!-- <div class="search-wrapper">
                        <i class="fa fa-search search-icon"></i>
                        <input type="text" id="searchInput" class="search-input" placeholder="Search products..."
                            onkeyup="searchTable()">
                    </div> -->
                    <button class="btn-add-main" onclick="openQuickStockModal()">
                        <i class="fa fa-plus"></i> Add Quantity
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Ref</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Update Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @isset($items)
                            @foreach($items as $index => $item)
                                <tr>
                                    <td data-label="Ref">{{ $index + 1 }}</td>
                                    <td data-label="Product">
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <img src="{{ $item->image_url ?? 'https://via.placeholder.com/40' }}" class="td-img">
                                            <b>{{ $item->item_name ?? $item->name }}</b>
                                        </div>
                                    </td>
                                    <td data-label="Category">{{ $item->item_category ?? '' }}</td>

                                    <td data-label="Quantity">{{ $item->stock ?? 0 }}</td>

                                    <td data-label="Price">LKR {{ number_format($item->selling_price ?? 0, 2) }}</td>


                                    <td data-label="Updated Date">{{ $item->updated_at}} </td>

                                    <td data-label="Actions">
                                        <button class="editbutton"
                                            onclick="openEditModal('{{ $item->item_name ?? $item->name }}', '{{ $item->item_category }}', '{{ $item->item_price ?? 0 }}', '{{ $item->stock ?? 0 }}', '{{ $item->id }}', '')">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button onclick="openDeleteModal('{{ $item->id }}')" class="deletebutton">
                                            <i class="far fa-trash-alt"></i>
                                        </button>

                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" style="text-align: center;">No Products Available</td>
                            </tr>
                        @endisset
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Stock Modal -->
    <div class="modal-overlay" id="editStockModal">
        <div class="modal-content1">
            <span class="close-modal" onclick="closeModal('editStockModal')">&times;</span>
            <div class="add-card">
                <div class="icon-box">📦</div>
                <div class="add-text">Edit Product & Stock</div>
                <p class="description">Update product info and stock details</p>

                <form action="/seller/stock-update" method="POST">
                    @csrf


                    <input type="hidden" id="edit-product-id" name="product_id">

                    <label>Category</label>
                    <input type="text" id="edit-category" readonly required>

                    <label>Product Name</label>
                    <input type="text" id="edit-name" readonly required>

                    <label>Product No</label>
                    <input type="text" id="edit-pNo" readonly required>

                    <label>Current Stock</label>
                    <input type="number" id="edit-current-stock" disabled>

                    <label>Adjust Quantity</label>
                    <div class="qty-box">
                        <button type="button" onclick="decrease()">−</button>
                        <input type="text" id="qty" name="quantity" value="1">
                        <button type="button" onclick="increase()">+</button>
                    </div>

                    <label>Price</label>
                    <input type="text" id="edit-price" name="price" required>

                    <label>Update date</label>
                    <input type="date" id="edit-date" name="update_date" required>

                    <label>Note</label>
                    <textarea name="note" placeholder="Reason for stock update..."></textarea>

                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" onclick="closeModal('editStockModal')">Cancel</button>
                        <button type="submit" class="btn-save">Update All</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal-overlay" id="deleteProductModal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('deleteProductModal')">&times;</span>
            <div class="add-card">
                <div class="icon-box" style="font-size: 40px; color: #e53e3e;">🗑️</div>
                <div class="add-text">Are you sure?</div>
                <p class="description">This action cannot be undone. All data related to this product will be permanently
                    removed.</p>

                <form id="deleteProductForm" method="POST" action="">
                    @csrf
                    @method('DELETE')

                    <div style="display: flex; gap: 10px; justify-content: center; margin-top: 20px;">
                        <button type="button" onclick="closeModal('deleteProductModal')" class="btn-cancel"
                            style="padding: 10px 20px;">Cancel</button>
                        <button type="submit"
                            style="padding: 10px 20px; border-radius: 8px; border: none; background: #e53e3e; color: white; cursor: pointer;">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Quick Add Modal (FIXED) -->
    <div class="modal-overlay" id="quickStockModal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('quickStockModal')">&times;</span>
            <div class="add-card">
                <div class="icon-box">➕</div>
                <div class="add-text">Add Quantity</div>
                <p class="description">Quickly update product stock</p>

                <!-- Form Submission Action -->
                <form action="/seller/products/quick-add-stock" method="POST">
                    @csrf

                    <label>Product</label>
                    <select id="qs-product" name="product_id" required>
                        <option value="">Select Product</option>
                        @isset($products)
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->item_name ?? $product->name }}</option>
                            @endforeach
                        @endisset
                    </select>

                    <label>Add Quantity</label>
                    <input type="number" id="qsqty" name="quantity" value="1" min="1" required>

                    <label>Price</label>
                    <input type="text" id="quickprice" name="price" placeholder="e.g. LKR 3,000" class="price">

                    <label>Update Date</label>
                    <input type="date" name="update_date" value="{{ date('Y-m-d') }}" required>

                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" onclick="closeModal('quickStockModal')">Cancel</button>
                        <button type="submit" class="btn-save">Add Quantity</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        function openEditModal(name, category, price, stock, productId, pNo) {
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-category').value = category;
            document.getElementById('edit-price').value = price;
            document.getElementById('edit-current-stock').value = stock;
            document.getElementById('edit-pNo').value = pNo || 'N/A';


            document.getElementById('edit-product-id').value = productId;

            document.getElementById('edit-date').value = new Date().toISOString().substring(0, 10);

            document.getElementById('editStockModal').style.display = 'block';
        }

        function increase() {
            let qty = document.getElementById('qty');
            qty.value = parseInt(qty.value) + 1;
        }

        function decrease() {
            let qty = document.getElementById('qty');
            if (qty.value > 1) qty.value = parseInt(qty.value) - 1;
        }

        let productToDelete = null;

        function openDeleteModal(productId) {
            productToDelete = productId;


            let deleteForm = document.getElementById('deleteProductForm');
            deleteForm.action = '/seller/stock-remove/' + productId;


            document.getElementById('deleteProductModal').style.display = 'flex';
        }



        function performDelete() {
            if (productToDelete) {
                alert('Product ' + productToDelete + ' deleted successfully!');
                closeModal('deleteProductModal');
            }
        }

        function searchTable() {
            let input = document.getElementById("searchInput");
            let filter = input.value.toLowerCase();
            let table = document.querySelector("table");
            let tr = table.getElementsByTagName("tr");
            for (let i = 1; i < tr.length; i++) {
                let td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    let txtValue = td.textContent || td.innerText;
                    tr[i].style.display = txtValue.toLowerCase().includes(filter) ? "" : "none";
                }
            }
        }

        window.onclick = function (event) {
            if (event.target === document.getElementById('editStockModal')) closeModal('editStockModal');
            if (event.target === document.getElementById('deleteProductModal')) closeModal('deleteProductModal');
            if (event.target === document.getElementById('quickStockModal')) closeModal('quickStockModal');
        }

        function openQuickStockModal() {
            document.getElementById('quickStockModal').style.display = 'flex';
        }
    </script>
@endsection