@extends('seller.layouts.master')

<style>
    .workspace-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 1.25rem;
        max-width: 890px;
        width: 100%;
        padding: 2.5rem;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.02);
        margin: 40px auto;
    }

    .header-section {
        margin-bottom: -1rem;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 1.25rem;
    }

    .header-section h1 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f172a;
    }

    .header-section p {
        font-size: 0.9rem;
        color: #64748b;
        margin-top: 0.35rem;
    }

    .form-layout {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        position: relative;
    }

    .field-label {
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #64748b;
    }

    .tags-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 0.25rem;
    }

    .tag-pill {
        background-color: #fff7ed;
        border: 1px solid #ffedd5;
        color: #ff6b00;
        padding: 0.4rem 0.75rem;
        border-radius: 2rem;
        font-size: 0.85rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .tag-pill .remove-btn {
        cursor: pointer;
        color: #a1a1aa;
        font-weight: bold;
    }

    .tag-pill .remove-btn:hover {
        color: #ef4444;
    }

    .light-search-input {
        width: 100%;
        padding: 0.85rem 1.25rem;
        font-size: 0.95rem;
        background-color: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 0.75rem;
        outline: none;
    }

    .light-search-input:focus {
        border-color: #071835;
        background-color: #ffffff;
        box-shadow: 0 0 0 3px rgba(0, 51, 102, 0.12);
    }

    .dropdown-popover {
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        margin-top: 0.5rem;
        max-height: 240px;
        overflow-y: auto;
        z-index: 10;
        display: none;
    }

    .bulk-action-row {
        background-color: #f8fafc;
        padding: 0.65rem 1.25rem;
        font-size: 0.85rem;
        font-weight: 700;
        color: #071835;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
    }

    .bulk-action-item {
        cursor: pointer;
    }

    .dropdown-option {
        padding: 0.75rem 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        border-bottom: 1px solid #f1f5f9;
    }

    .dropdown-option:hover {
        background-color: #fafafa;
    }

    .option-name {
        font-size: 0.95rem;
        font-weight: 500;
        color: #334155;
    }

    .option-meta {
        font-size: 0.85rem;
        color: #64748b;
    }

    .toggle-switch-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        background-color: #f1f5f9;
        padding: 0.3rem;
        border-radius: 0.6rem;
        gap: 0.3rem;
    }

    .toggle-option {
        text-align: center;
        padding: 0.5rem;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        border-radius: 0.4rem;
        color: #64748b;
    }

    .toggle-option.active {
        background-color: #ffffff;
        color: #071835;
    }

    .currency-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .currency-addon {
        position: absolute;
        left: 1.25rem;
        color: #64748b;
        font-weight: 600;
    }

    .modern-input {
        width: 100%;
        padding: 0.85rem 1rem 0.85rem 2.25rem;
        font-size: 1rem;
        background-color: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 0.75rem;
        outline: none;
    }

    .modern-input:focus {
        border-color: #ff6b00;
        box-shadow: 0 0 0 3px rgba(255, 107, 0, 0.12);
    }

    .preview-box {
        background-color: #fafafa;
        border: 1px dashed #cbd5e1;
        border-radius: 0.75rem;
        padding: 1rem;
        display: none;
        flex-direction: column;
        gap: 0.4rem;
    }

    .preview-title {
        font-size: 0.8rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
    }

    .preview-item {
        display: flex;
        justify-content: space-between;
        font-size: 0.85rem;
    }

    .btn-submit {
        background-color: #071835;
        color: #ffffff;
        border: none;
        padding: 1rem;
        font-size: 0.95rem;
        font-weight: 700;
        border-radius: 0.75rem;
        cursor: pointer;
        width: 100%;
    }

    .btn-submit:hover {
        opacity: 0.9;
    }
     @media (max-width: 992px) {
        .workspace-card {
            width: 74% ;
            margin-top: 0px;
        }
        .header-section h1 {
            font-size: 15px; 
            font-weight: 700;
            color: #0f172a;
            
            white-space: nowrap; 
            overflow: hidden;    
            text-overflow: ellipsis; 
}

        
        
     }
</style>

@section('content')
    <div class="workspace-card">
        <div class="header-section">
            <h1>Create Promotional Offer</h1>
            <p>Search items to append variations or choose global select rules to deploy discounts.</p>
        </div>

        <form action="{{ route('seller.promotional-offers.store') }}" method="POST" class="form-layout" id="offerForm">
            @csrf 
            
            @if(session('success'))
                <div style="color: #155724; background-color: #d4edda; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div style="color: #721c24; background-color: #f8d7da; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="form-group">
                <label class="field-label">Target Inventory Products</label>
                <div class="tags-container" id="tagsContainer"></div>

                <input type="text" id="tokenSearch" class="light-search-input"
                    placeholder="Type product name or browse catalog..." onfocus="showDropdown()"
                    oninput="filterDropdown()">

                <div class="dropdown-popover" id="dropdownPanel">
                    <div class="bulk-action-row">
                        <span class="bulk-action-item" onclick="selectAllCatalog(event)">✨ Select All Available Products</span>
                        <span class="bulk-action-item" style="color: #ef4444;" onclick="clearAllSelections(event)">🗑️ Clear All</span>
                    </div>

                   
                    @foreach($products as $product)
                        @php 
                            
                            $price = !empty($product->selling_price) ? $product->selling_price : 0.00; 
                        @endphp
                        <div class="dropdown-option" 
                             data-id="{{ $product->id }}" 
                             data-name="{{ strtolower($product->item_name) }}" 
                             data-price="{{ $price }}"
                             onclick="addTag('{{ $product->id }}', '{{ addslashes($product->item_name) }}', '{{ $price }}')">
                            <span class="option-name">{{ $product->item_name }}</span>
                            <span class="option-meta"><b>${{ number_format($price, 2) }}</b></span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <label class="field-label">Discount Type Rule</label>
                <div class="toggle-switch-container">
                    <div class="toggle-option active" id="typeFixed" onclick="setDiscountType('fixed')">Fixed Deal Price</div>
                    <div class="toggle-option" id="typePercentage" onclick="setDiscountType('percentage')">Percentage Off (%)</div>
                </div>
                <input type="hidden" name="discount_type" id="discountTypeField" value="fixed">
            </div>

            <div class="form-group">
                <label for="offerPrice" class="field-label" id="valueInputLabel">New Promotional Offer Price</label>
                <div class="currency-wrapper">
                    <span class="currency-addon" id="addonIcon">$</span>
                    <input type="number" id="offerPrice" name="offer_price" class="modern-input" placeholder="0.00"
                        min="0.01" step="0.01" oninput="calculateLivePreviews()" required>
                </div>
            </div>

            <div class="preview-box" id="previewPanel">
                <div class="preview-title">Live Pricing Summary Preview</div>
                <div id="previewItemsContainer"></div>
            </div>

            <button type="submit" class="btn-submit">Publish Promo Offer</button>
        </form>
    </div>

<script>
    const selectedProducts = new Map();

    function showDropdown() {
        document.getElementById('dropdownPanel').style.display = 'block';
    }

    document.addEventListener('click', function (e) {
        const container = document.getElementById('tokenSearch').closest('.form-group');
        if (!container.contains(e.target)) {
            document.getElementById('dropdownPanel').style.display = 'none';
        }
    });

    function filterDropdown() {
        const query = document.getElementById('tokenSearch').value.toLowerCase().trim();
        const options = document.querySelectorAll('.dropdown-option');

        options.forEach(opt => {
            const searchKey = opt.getAttribute('data-name');
            opt.style.display = searchKey.includes(query) ? 'flex' : 'none';
        });
    }

    function addTag(id, name, basePrice) {
        if (selectedProducts.has(id)) return;

        selectedProducts.set(id, parseFloat(basePrice));
        const container = document.getElementById('tagsContainer');

        const pill = document.createElement('div');
        pill.className = 'tag-pill';
        pill.id = 'pill-' + id;
        pill.innerHTML = `
            <span>${name}</span>
            <span class="remove-btn" onclick="removeTag('${id}', event)">&times;</span>
        `;
        container.appendChild(pill);

        document.getElementById('tokenSearch').value = '';
        filterDropdown();
        calculateLivePreviews();
    }

    function removeTag(id, e) {
        if (e) e.stopPropagation();
        selectedProducts.delete(id);
        const pill = document.getElementById('pill-' + id);
        if (pill) pill.remove();
        calculateLivePreviews();
    }

    function selectAllCatalog(e) {
        if (e) e.stopPropagation();
        const options = document.querySelectorAll('.dropdown-option');
        options.forEach(opt => {
            if (opt.style.display !== 'none') {
                const id = opt.getAttribute('data-id');
                const name = opt.querySelector('.option-name').innerText;
                const price = opt.getAttribute('data-price');
                addTag(id, name, price);
            }
        });
        document.getElementById('dropdownPanel').style.display = 'none';
    }

    function clearAllSelections(e) {
        if (e) e.stopPropagation();
        selectedProducts.clear();
        document.getElementById('tagsContainer').innerHTML = '';
        calculateLivePreviews();
        document.getElementById('dropdownPanel').style.display = 'none';
    }

    function setDiscountType(type) {
        const fixedOpt = document.getElementById('typeFixed');
        const percentOpt = document.getElementById('typePercentage');
        const hiddenField = document.getElementById('discountTypeField');
        const addonIcon = document.getElementById('addonIcon');
        const label = document.getElementById('valueInputLabel');
        const inputField = document.getElementById('offerPrice');

        hiddenField.value = type;
        inputField.value = '';

        if (type === 'fixed') {
            fixedOpt.classList.add('active');
            percentOpt.classList.remove('active');
            addonIcon.innerText = '$';
            label.innerText = 'New Promotional Offer Price';
            inputField.removeAttribute('max');
        } else {
            percentOpt.classList.add('active');
            fixedOpt.classList.remove('active');
            addonIcon.innerText = '%';
            label.innerText = 'Percentage Deduction Rate';
            inputField.setAttribute('max', '99');
        }
        calculateLivePreviews();
    }

    function calculateLivePreviews() {
        const previewPanel = document.getElementById('previewPanel');
        const container = document.getElementById('previewItemsContainer');
        const inputValue = parseFloat(document.getElementById('offerPrice').value);
        const discountType = document.getElementById('discountTypeField').value;

        if (selectedProducts.size === 0 || !inputValue || inputValue <= 0) {
            previewPanel.style.display = 'none';
            return;
        }

        container.innerHTML = '';
        previewPanel.style.display = 'flex';

        selectedProducts.forEach((basePrice, id) => {
            const productOptionNode = document.querySelector(`.dropdown-option[data-id="${id}"]`);
            const productName = productOptionNode.querySelector('.option-name').innerText;

            let finalPrice = 0;
            if (discountType === 'fixed') {
                finalPrice = inputValue;
            } else {
                finalPrice = basePrice - (basePrice * (inputValue / 100));
            }

            if (finalPrice < 0) finalPrice = 0;

            const element = document.createElement('div');
            element.className = 'preview-item';
            element.innerHTML = `
                <span style="color: #475569;">${productName}</span>
                <span><del style="color: #94a3b8; margin-right: 0.5rem;">$${basePrice.toFixed(2)}</del> <b style="color: #ff6b00;">$${finalPrice.toFixed(2)}</b></span>
            `;
            container.appendChild(element);
        });
    }

    // FORM SUBMISSION HANDLING
    document.getElementById('offerForm').addEventListener('submit', function (e) {
        if (selectedProducts.size === 0) {
            e.preventDefault();
            alert('Please link at least one target inventory product before publishing changes.');
            return;
        }

        const oldInputs = this.querySelectorAll('input[name="selected_products[]"]');
        oldInputs.forEach(input => input.remove());

        selectedProducts.forEach((price, id) => {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'selected_products[]';
            hiddenInput.value = id;
            this.appendChild(hiddenInput);
        });
    });
</script>
@endsection