@extends('seller.layouts.master')

@section('content')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/css/selleraddproduct.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Product Management Dashboard</title>
    <style>

    </style>

    <div class="breadcrumb">
        <span>Home</span>
        <span class="arrow">›</span>
        <span class="active">Products</span>
    </div>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Manage Products</h2>
                <button class="btn-add-main" onclick="toggleModal(true)">
                    <span>+</span> Add New Product
                </button>
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Ref</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $index => $item)
                            <tr>
                                <td data-label="Ref">{{ $index + 1 }}</td>
                                <td data-label="Product">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <img src="{{ $item->images->first() ? asset($item->images->first()->image_path) : 'https://via.placeholder.com/40' }}"
                                            class="td-img">
                                        <b>{{ $item->item_name }}</b>
                                    </div>
                                </td>
                                <td data-label="Category">{{ $item->item_category }}</td>
                                <td data-label="Sub Category">{{ $item->item_sub_category }}</td>
                                <td data-label="Actions">
                                    <button type="button" class="btn-edit" onclick="openEditModal(
                                                                    '{{ $item->id }}', 
                                                                    '{{ $item->item_name }}', 
                                                                    '{{ $item->item_category }}', 
                                                                    '{{ $item->item_sub_category }}', 
                                                                    '{{ $item->item_code }}', 
                                                                    '{{ $item->item_no }}', 
                                                                    '{{ asset($item->images->first()->image_path ?? '') }}',
                                                                    '{{ $item->color_string }}', 
                                                                    '{{ $item->size_string }}'
                                                                )"><i class="fas fa-edit"></i></button>
                                    <button onclick="openDeleteModal('{{ $item->id }}')" class="deletebutton">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: var(--text-sub);">No Products Found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="productModal">
        <div class="modal-content">
            <span class="close-modal" onclick="toggleModal(false)">&times;</span>
            <div class="add-card">
                <div class="icon-box">📦</div>
                <div class="add-text">Add New Product</div>
                <p class="description">Upload high-quality images and set product details</p>

                <form id="addProductForm" enctype="multipart/form-data">
                    <input type="hidden" id="csrf-token" value="{{ csrf_token() }}">

                    <label>Product Image</label>
                    <div class="upload-box" onclick="document.getElementById('product-img').click()">
                        <input type="file" name="product_img" id="product-img" hidden accept="image/*"
                            onchange="previewImage(event)">
                        <div id="preview-placeholder">
                            <span>📸</span>
                            <p style="margin:0; font-size: 12px;">Click to upload</p>
                        </div>
                        <img id="image-preview" src="">
                    </div>

                    <div class="meta-field-wrapper">
                        <label>Category</label>
                        <div class="input-with-btn">
                            <select name="category" id="category" required>
                                <option value="">Select Category</option>
                                @foreach($categories ?? [] as $cat)
                                    <option value="{{ $cat->group_name }}">{{ $cat->group_name }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="add-small-btn"
                                onclick="toggleInlineInput('category', 'Category Group')">+</button>
                        </div>
                        <div id="category-inline-container" class="inline-add-container"></div>
                    </div>

                    <div class="meta-field-wrapper">
                        <label>Sub Category </label>
                        <div class="input-with-btn">
                            <select name="subcategory1" id="subcategory1" required>
                                <option value="">Select Sub Category </option>
                                @foreach($subcategories1 ?? [] as $sub1)
                                    <option value="{{ $sub1->group_name }}">{{ $sub1->group_name }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="add-small-btn"
                                onclick="toggleInlineInput('subcategory1', 'Sub Category 1 Group')">+</button>
                        </div>
                        <div id="subcategory1-inline-container" class="inline-add-container"></div>
                    </div>

                    <div class="meta-field-wrapper">
                        <label>Group 1</label>
                        <div class="input-with-btn">
                            <select name="subcategory2" id="subcategory2" required>
                                <option value="">Select Group 1</option>
                                @foreach($groups ?? [] as $g1)
                                    <option value="{{ $g1->group_name }}">{{ $g1->group_name }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="add-small-btn"
                                onclick="toggleInlineInput('subcategory2', 'Sub Category 2 Group')">+</button>
                        </div>
                        <div id="subcategory2-inline-container" class="inline-add-container"></div>
                    </div>

                    <label>Product Name</label>
                    <input type="text" name="productname" id="productname" required>

                    <label>Product Code</label>
                    <input type="text" name="productcode" id="productcode" required>

                    <label>Product No</label>
                    <input type="text" name="productno" id="productno" required>

                    <label>Color</label>
                    <input type="text" name="productcolor" id="productcolor">

                    <label>Size</label>
                    <input type="text" name="productsize" id="productsize">

                    <button type="submit" class="btn-submitp">Save Product</button>
                </form>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="editProductModal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('editProductModal')">&times;</span>
            <div class="add-card">
                <div class="icon-box">✏️</div>
                <div class="add-text">Edit Product</div>
                <p class="description">Update your product details below</p>

                <form id="editProductForm" enctype="multipart/form-data">
                    <input type="hidden" id="edit-id">
                    <label>Product Image</label>
                    <div class="upload-box" onclick="document.getElementById('edit-product-img').click()">
                        <input type="file" name="edit_product_img" id="edit-product-img" hidden accept="image/*"
                            onchange="previewEditImage(event)">
                        <div id="edit-preview-placeholder">
                            <span>📸</span>
                            <p style="margin:0; font-size: 12px;">Click to upload</p>
                        </div>
                        <img id="edit-image-preview" src="">
                    </div>

                    <label>Category</label>
                    <input type="text" name="category" id="edit-category" required>

                    <label>Product Sub Category</label>
                    <input type="text" name="subcategory" id="edit-subcategory" required>

                    <label>Product Name</label>
                    <input type="text" name="productname" id="edit-name" required>

                    <label>Product Code</label>
                    <input type="text" name="productcode" id="edit-code" required>

                    <label>Product No</label>
                    <input type="text" name="productno" id="edit-no" required>

                    <label>Color</label>
                    <input type="text" name="productcolor" id="edit-productcolor">

                    <label>Size</label>
                    <input type="text" name="productsize" id="edit-productsize">

                    <button type="submit" class="btn-submitp">Update Product</button>
                </form>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="deleteProductModal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('deleteProductModal')">&times;</span>
            <div class="add-card">
                <div class="icon-box" style="font-size: 40px; color: #e53e3e;">🗑️</div>
                <div class="add-text">Are you sure?</div>
                <p class="description">This action cannot be undone. All data related to this product will be permanently
                    removed.</p>

                <div style="display: flex; gap: 10px; justify-content: center; margin-top: 20px;">
                    <button onclick="closeModal('deleteProductModal')"
                        style="padding: 10px 20px; border-radius: 8px; border: 1px solid #ddd; background: #fff; cursor: pointer;">Cancel</button>
                    <button onclick="performDelete()"
                        style="padding: 10px 20px; border-radius: 8px; border: none; background: #e53e3e; color: white; cursor: pointer;">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function toggleModal(show) {
            const modal = document.getElementById('productModal');
            modal.style.display = show ? 'flex' : 'none';
            if (!show) document.getElementById('addProductForm').reset();
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('image-preview').src = e.target.result;
                    document.getElementById('image-preview').style.display = 'block';
                    document.getElementById('preview-placeholder').style.display = 'none';
                }
                reader.readAsDataURL(file);
            }
        }

        function previewEditImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('edit-image-preview').src = e.target.result;
                    document.getElementById('edit-image-preview').style.display = 'block';
                    document.getElementById('edit-preview-placeholder').style.display = 'none';
                }
                reader.readAsDataURL(file);
            }
        }


        function openEditModal(id, name, category, subcategory, code, no, imageSrc, colors, sizes) {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-category').value = category;
            document.getElementById('edit-subcategory').value = subcategory;
            document.getElementById('edit-code').value = code;
            document.getElementById('edit-no').value = no;

            // colors parameter එක පාවිච්චි කරලා load කිරීම
            if (colors) {
                tagInputInstances["edit-productcolor"].tagsArray = colors.split(",").map(s => s.trim()).filter(s => s);
            } else {
                tagInputInstances["edit-productcolor"].tagsArray = [];
            }
            tagInputInstances["edit-productcolor"].updateUI();

            // sizes parameter එක පාවිච්චි කරලා load කිරීම
            if (sizes) {
                tagInputInstances["edit-productsize"].tagsArray = sizes.split(",").map(s => s.trim()).filter(s => s);
            } else {
                tagInputInstances["edit-productsize"].tagsArray = [];
            }
            tagInputInstances["edit-productsize"].updateUI();

            const preview = document.getElementById('edit-image-preview');
            const placeholder = document.getElementById('edit-preview-placeholder');

            if (imageSrc) {
                preview.src = imageSrc;
                preview.style.display = 'block';
                placeholder.style.display = 'none';
            } else {
                preview.style.display = 'none';
                placeholder.style.display = 'block';
            }

            document.getElementById('editProductModal').style.display = 'flex';
        }
        // INSERT (AJAX)
        document.getElementById('addProductForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch("/products/store", {
                method: "POST",
                headers: { 'X-CSRF-TOKEN': csrfToken },
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                }).catch(err => alert('Something went wrong!'));
        });

        // UPDATE (AJAX)
        document.getElementById('editProductForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const id = document.getElementById('edit-id').value;
            const formData = new FormData(this);

            fetch(`/products/update/${id}`, {
                method: "POST",
                headers: { 'X-CSRF-TOKEN': csrfToken },
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                }).catch(err => alert('Something went wrong!'));
        });

        // DELETE (AJAX)
        let productToDelete = null;
        function openDeleteModal(productId) {
            productToDelete = productId;
            document.getElementById('deleteProductModal').style.display = 'flex';
        }

        function performDelete() {
            if (productToDelete) {
                fetch(`/products/delete/${productToDelete}`, {
                    method: "DELETE",
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            location.reload();
                        } else {
                            alert('Error: ' + data.message);
                        }
                    }).catch(err => alert('Something went wrong!'));
            }
        }

        window.onclick = function (event) {
            const addModal = document.getElementById('productModal');
            const editModal = document.getElementById('editProductModal');
            const deleteModal = document.getElementById('deleteProductModal');
            if (event.target === addModal) toggleModal(false);
            if (event.target === editModal) closeModal('editProductModal');
            if (event.target === deleteModal) closeModal('deleteProductModal');
        }
        function toggleInlineInput(type, description) {
            const container = document.getElementById(`${type}-inline-container`);

            // If field is already open, close it on second click
            if (container.children.length > 0) {
                container.innerHTML = '';
                return;
            }

            // Clean up any other open inline forms to avoid clutter
            document.querySelectorAll('.inline-add-container').forEach(el => el.innerHTML = '');

            // Inject the inline field structure
            container.innerHTML = `
                            <input type="text" id="${type}-new-val" class="inline-input-field" placeholder="Enter new item value..." autocomplete="off">
                            <button type="button" class="inline-submit-btn" onclick="submitInlineData('${type}', '${description}')">Save</button>
                            <button type="button" class="inline-cancel-btn" onclick="document.getElementById('${type}-inline-container').innerHTML=''">X</button>
                        `;
            document.getElementById(`${type}-new-val`).focus();
        }

        function submitInlineData(type, description) {
            const inputElement = document.getElementById(`${type}-new-val`);
            const newValue = inputElement.value.trim();
            const token = document.getElementById('csrf-token').value;

            if (!newValue) {
                alert('Please provide a valid entry value.');
                return;
            }


            let backendType = '';
            let parentCategoryId = null;

            if (type === 'category') {
                backendType = 'category';
            } else if (type === 'subcategory1') {
                backendType = 'subcategory';


                const catSelect = document.getElementById('category');
                if (catSelect) {
                    parentCategoryId = catSelect.value;
                }

                if (!parentCategoryId) {
                    alert('Please select a Category first before adding a Sub Category!');
                    return;
                }
            } else if (type === 'subcategory2') {
                backendType = 'group';
            }


            fetch('/meta-groups/store-inline', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    type: backendType,
                    group_name: newValue,
                    description: description,
                    category_id: parentCategoryId
                })
            })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw err; });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        const selectElement = document.getElementById(type);
                        const opt = document.createElement('option');


                        opt.value = data.group_name;
                        opt.text = data.group_name;
                        opt.selected = true;

                        selectElement.add(opt);

                        // Terminate container display layout cleanly
                        document.getElementById(`${type}-inline-container`).innerHTML = '';
                    } else {
                        alert(data.message || 'Error occurred while updating storage metadata.');
                    }
                })
                .catch(error => {
                    console.error('Meta-storage transmission routing error:', error);
                    alert('Error: ' + (error.message || 'Failed to execute transmission process execution layers.'));
                });
        }

        let tagInputInstances = {}; // හැම input එකකම tags array එක track කරන්න object එකක්

        document.addEventListener("DOMContentLoaded", function () {
            // Add Modal Inputs
            initTagInput("productcolor", "Type color and press Enter");
            initTagInput("productsize", "Type size and press Enter");

            // Edit Modal Inputs
            initTagInput("edit-productcolor", "Type color and press Enter");
            initTagInput("edit-productsize", "Type size and press Enter");
        });

        function initTagInput(inputId, placeholderText) {
            const originalInput = document.getElementById(inputId);
            if (!originalInput) return;

            const wrapper = document.createElement("div");
            wrapper.classList.add("tags-input-wrapper");
            originalInput.parentNode.insertBefore(wrapper, originalInput);

            const textInput = document.createElement("input");
            textInput.type = "text";
            textInput.placeholder = placeholderText;

            originalInput.type = "hidden";
            wrapper.appendChild(textInput);

            tagInputInstances[inputId] = {
                tagsArray: [],
                updateUI: function () {
                    const badges = wrapper.querySelectorAll(".tag-badge");
                    badges.forEach(b => b.remove());

                    this.tagsArray.forEach((tag, index) => {
                        const badge = document.createElement("span");
                        badge.classList.add("tag-badge");
                        badge.innerHTML = `${tag} <span class="remove-tag" data-input-id="${inputId}" data-index="${index}">&times;</span>`;
                        wrapper.insertBefore(badge, textInput);
                    });

                    originalInput.value = this.tagsArray.join(",");
                }
            };

            wrapper.addEventListener("click", () => textInput.focus());

            textInput.addEventListener("keydown", function (e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                    let value = textInput.value.trim();

                    if (value && !tagInputInstances[inputId].tagsArray.includes(value)) {
                        tagInputInstances[inputId].tagsArray.push(value);
                        tagInputInstances[inputId].updateUI();
                        textInput.value = "";
                    }
                }
            });

            wrapper.addEventListener("click", function (e) {
                if (e.target.classList.contains("remove-tag")) {
                    const index = e.target.getAttribute("data-index");
                    const targetId = e.target.getAttribute("data-input-id");
                    tagInputInstances[targetId].tagsArray.splice(index, 1);
                    tagInputInstances[targetId].updateUI();
                    textInput.focus();
                }
            });
        }

    </script>
@endsection