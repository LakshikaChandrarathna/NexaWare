@extends('buyer.layouts.master')

@section('content')
    <link rel="stylesheet" href="src/css/buyer.css">

    <style>
        /* COLOR VARIABLES */
        :root {
            --primary-blue: #071835;
            --light-highlight: #b5cbf0;
            --dark-navy: #071835;
            --deep-background: #010813;
            --text-main: #01060e;
            --white: #ffffff;
            --black: #000000;
        }

        /* CONTACT ROW STYLE */
        .contact-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        /* INPUTS AND SELECTS */
        .contact-row select,
        .contact-row input {
            height: 40px;
            padding: 0 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 13px;
            outline: none;
        }

        /* Remove button */
        .remove-btn {
            color: red;
            font-size: 20px;
            cursor: pointer;
            font-weight: bold;
            margin-left: 5px;
        }

        /* Primary radio alignment */
        .primary-container {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 13px;
            white-space: nowrap;
        }

        /* ALL FORM GROUP SAME STYLE */
        .checkout-form-group label,
        .text-field label {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-main);
            margin-bottom: 4px;
            display: block;
        }

        /* ALL INPUT + SELECT SAME */
        .checkout-input,
        .text-field input,
        .checkout-form-group select {
            width: 100%;
            height: 40px;
            padding: 8px 10px;
            font-size: 13px;
            border: 1px solid #ccc;
            border-radius: 6px;
            outline: none;
            transition: 0.2s;
        }

        /* FOCUS EFFECT */
        .checkout-input:focus,
        .text-field input:focus,
        .checkout-form-group select:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 2px rgba(7, 24, 53, 0.1);
        }

        /* ADDRESS FIELD GAP FIX */
        .text-field {
            margin-bottom: 10px;
        }

        .text-field span {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .breadcrumb {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #777;
            margin-bottom: 15px;
        }

        .breadcrumb span {
            margin-right: 5px;
        }

        .breadcrumb .arrow {
            color: #aaa;
        }

        .breadcrumb .active {
            color: var(--black);
            font-weight: bold;
        }

        .Order-Id {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 12px;
            margin-left: -12px;
        }

        .Order-Id span:first-child {
            font-size: 12px;
            font-weight: 600;
        }

        .Order-Id span:last-child {
            font-size: 13px;
            font-weight: 600;
            color: var(--primary-blue);
            margin-right: -13px;
        }

       
        .checkout-btn-container {
            display: flex;
            justify-content: flex-end; 
            margin-top: 25px;
            width: 100%;
        }

        
        .btn-submit-checkout {
        background-color: var(--primary-blue);
        color: var(--white);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 15px;
        font-weight: 600;
        padding: 13px 80px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        margin-top: 13px;
        width: 100%;
        font-weight: bold;
        }


        /* .btn-submit-checkout:hover {
            background-color: #004085;  
            transform: translateY(-2px);  
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15); 
        } */
        .btn-add-more {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 12px;
            font-size: 14px;
            color: var(--primary-blue);
            text-decoration: none;
            border: 1px solid var(--primary-blue);
            border-radius: 4px;
            transition: all 0.2s ease-in-out;
        }

    .btn-add-more:hover {
        background-color: var(--primary-blue);
        color: #fff;
    }
    .addressedit{
        display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 15px; 
    font-size: 13px; 
    cursor: pointer;
    font-size: 13px;
    color: var(--primary-blue);
    text-decoration: none;
    border: 1px solid var(--primary-blue);
    border-radius: 4px;
    transition: all 0.2s ease-in-out;
    background-color: white;
    margin-left: 965px; 
    }
 @media (max-width: 768px) {
    .addressedit{

  margin-left: 118px; 
}
 }

    </style>

    <div class="breadcrumb">
        <span>Home</span>
        <span class="arrow"></span>
        <span class="active">Cart</span>
    </div>

    <div class="cart-wrapper">
        <div class="cart-main">
            <div id="cart-view">
                <div class="shipping-banner" style="background-color: var(--light-highlight); color: var(--dark-navy);">
                    <span class="check-icon">✓</span>
                    <span>Free shipping special for you</span>
                    <span class="limit-offer">Limited-time offer</span>
                </div>

                <div class="cart-section">
                    

    <div class="select-all-bar">
   
        <label><input type="checkbox" checked> Select all ({{ $cartItems->count() }})</label>
        <a href="/shop" class="btn-add-more">
        <i class="fa fa-plus"></i> Add product</a>
        </div>

   
    @foreach($cartItems as $item)
     <div class="product-row">
            <!-- <input type="checkbox" checked class="row-checkbox"> -->
            
             
             <img src="{{ $item->image_url }}" class="product-img" alt="Product">
            
            <div class="product-details">
                
                <p class="product-title" style="color: var(--text-main);">{{ $item->title }}</p>
                <p class="product-variant">Beige Color/1pc </p>
                <p class="sale-label">Big sale</p>
                
                <div class="price-info">
           
                    <span class="price-tag" style="color: var(--primary-blue);">LKR {{ number_format($item->unit_price, 2) }}</span>
                    
                   
                    <small style="color: #777; block: block; font-size: 11px;">Subtotal: LKR {{ number_format($item->total_price, 2) }}</small>
                </div>
            </div>

            <div class="action-col">
                <select class="qty-dropdown">
           
                    <option {{ $item->quantity == 1 ? 'selected' : '' }}>Qty 1</option>
                        <option {{ $item->quantity == 2 ? 'selected' : '' }}>Qty 2</option>
                        <option {{ $item->quantity == 3 ? 'selected' : '' }}>Qty 3</option>
                        
                </select>
                <!-- <i class="fa fa-trash-alt delete-icon"></i> -->
                    <form action="{{ route('cart.remove', $item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-icon" style="background:none; border:none; cursor:pointer; color:#777;">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                    </form>
                </select>

            </div>
        </div>
    @endforeach
   
    </div>

             
            </div>

            <div id="checkout-view" style="display: none; margin-bottom: 20px; border: 1px solid var(--light-highlight); padding: 15px; border-radius: 6px; background-color: var(--white);">
                <div class="cart-section1">
                    <div class="checkout-header">
                        <span onclick="toggleView('cart')" class="back-link" style="color: var(--primary-blue);">← Back to cart</span>
                        <div class="summary-title" style="color: var(--text-main);">Shipping Address</div>
                         
                    </div>
          

                <form>
                @csrf
                        <div class="checkout-form-grid">
                            <div class="checkout-form-group">
                                <label>First Name</label>
                                <input type="text" id="cust_first_name" class="checkout-input" value="{{ $human->firstname ?? '' }}" readonly style="background-color: #f1f3f5; cursor: not-allowed; color: #6c757d;">
                            </div>
                            
                            <div class="checkout-form-group">
                                <label>Last Name</label>
                                <input type="text" id="cust_last_name" class="checkout-input" value="{{ $human->surname ?? '' }}" readonly style="background-color: #f1f3f5; cursor: not-allowed; color: #6c757d;">
                            </div>
                            
                            <div class="checkout-form-group">
                                <label>Email</label>
                                <input type="text" id="cust_email" class="checkout-input" value="{{ $primaryEmail->email ?? '' }}" readonly style="background-color: #f1f3f5; cursor: not-allowed; color: #6c757d;">
                            </div>
                            
                            <div class="checkout-form-group">
                                <label>Contact</label>
                                <div id="contact-container">
                                    <input type="text" name="contact[]" class="checkout-input" value="{{ $primaryContact->contact_no ?? '' }}" readonly style="background-color: #f1f3f5; cursor: not-allowed; color: #6c757d;">
                                </div>
                                <!-- <div onclick="addContactField()"
                                    style="display: flex; align-items: center; cursor: pointer; color: var(--primary-blue); font-family: sans-serif; font-size: 12px; font-style: italic; font-weight: normal; margin-top: 10px; text-decoration: none;">
                                    <span style="display: flex; align-items: center; justify-content: center; width: 22px; height: 22px; background-color: var(--primary-blue); color: var(--white); border-radius: 50%; margin-right: 8px; font-size: 14px; font-weight: bold; line-height: 1;">+</span>
                                    <span style="border-bottom: 1px solid transparent; transition: border-color 0.2s;"
                                        onmouseover="this.style.borderColor='var(--primary-blue)'"
                                        onmouseout="this.style.borderColor='transparent'">Add Contact</span>
                                </div> -->
                            </div>
                        </div>

    
                    <form id="shipping-details-form" onsubmit="event.preventDefault();">
                        @csrf

                        <div class="checkout-form-grid">
                            <div class="checkout-form-group">
                                <label>Postal Code</label>
                                <input type="text" class="checkout-input" id="postal_code" value="{{ $human->postal_code ?? '' }}" >
                            </div>
                            

                        <div class="checkout-form-group"> 
                            <label>Province</label>

                            <select name="province" id="province" class="checkout-input">
                                <option value="">Select Province</option>
                                
                                @foreach(($provinces ?? \App\Models\Province::all()) as $province)
                                    <option value="{{ $province->id }}" 
                                        {{ (isset($human) && !empty($human->province) && $human->province == $province->id) ? 'selected' : '' }}>
                                        {{ $province->p_name ?? $province->name }}
                                    </option> 
                                @endforeach
                            </select>
                        </div>

                        
                        <div class="checkout-form-group">
                            <label>District</label>
                            <select class="checkout-input" id="cust_district" name="district">
                                <option value="">Select District</option>
                            
                                @if(isset($human->district))
                                    <option value="{{ $human->discrict }}" selected>
                                        {{ $human->district->d_name }}
                                    </option>
                                @endif
                            
                            </select>
                        </div>

                        <div class="checkout-form-group">
                                <label>GN Division</label>
                                <select class="checkout-input" id="gn_division" name="gndivision">
                                    <option value="">Select GN Division</option>
                                    @if(isset($human->g_n_divisions))
                                        <option value="{{ $human->gndivision }}" selected>
                                            {{ $human->g_n_divisions->name_en ?? $human->g_n_divisions->name ?? $human->g_n_divisions }}
                                        </option>
                                    @endif
                                </select>
                            </div>


                            <div class="checkout-form-group">
                                <label>House / Building No</label>
                                <input type="text" class="checkout-input" id="building_no" value="{{ $human->house_no ?? '' }}">
                            </div>

                            <div id="address_all">
                                <div class="text-field" id="address_line_div_1">
                                    <label>Address line 1</label>
                                    <div style="display:flex; align-items:center; gap:10px;">
                                        <input type="text" name="address_line[]" id="address_line_1" class="checkout-input"
                                            value="{{ $human->addressone ?? '' }}" style="flex:1; text-transform: capitalize;" require>
                                    </div>
                                    
                                    @if(!empty($human->addresstwo))
                                    <div style="display:flex; align-items:center; gap:10px; margin-top:10px;">
                                        <input type="text" name="address_line[]" class="checkout-input"
                                            value="{{ $human->addresstwo ?? '' }}" style="flex:1; text-transform: capitalize;">
                                    </div>
                                    @endif

                                    <div onclick="addaddressField()"
                                        style="display: flex; align-items: center; cursor: pointer; color: var(--primary-blue); font-size: 12px; font-style: italic; margin-top: 10px;">
                                        <span style="display: flex; align-items: center; justify-content: center; width: 22px; height: 22px; background-color: var(--primary-blue); color: var(--white); border-radius: 50%; margin-right: 8px; font-size: 14px; font-weight: bold;">+</span>
                                        <span>Add Address Line</span>
                                    </div>
                                </div>

                                <div id="address-container"></div>
                            </div>
                        </div>

                        <div class="payment-section-title" style="color: var(--text-main);">Payment Method</div>
                        <label class="payment-option-card">
                            <input type="radio" checked name="pay">
                            <strong style="color: var(--text-main);">Credit / Debit Card</strong>
                        </label>
                        <div>
                            <input type="submit" value="Save Shipping Details" class="btn-submit-checkout" onclick="saveShippingDetails(event)">
                        </div>
                    </form>
                </form>

            </div>
        </div>

        <div class="summary-card" style="background-color: var(--white); border: 1px solid var(--light-highlight); width:auto; height:auto;">
             <div class="summary-title" style="color: var(--text-main);">Shipping Address</div>
             <button type="button" class="addressedit" id="edit-address-btn" onclick="toggleAddressForm()" >
                <i class="fa fa-edit"></i>Edit</button>
             

            <p style="color: var(--text-main); margin-top: 5px; line-height: 1.6; margin-bottom: revert;">
    
                    @if(isset($human))
                
                    @php
                    $human->loadMissing(['provinceRelation', 'district', 'g_n_divisions']);
                    @endphp

                    @if(!empty($human->house_no))
                        {{ $human->house_no }},
                    @endif

                    @if(isset($human->g_n_divisions) && is_object($human->g_n_divisions))
                        
                        {{ $human->g_n_divisions->name_in_english ?? $human->g_n_divisions->name_en ?? $human->g_n_divisions->name }},
                    @elseif(!empty($human->gndivision))
                        {{ $human->gndivision }},
                    @endif

                    @if(isset($human->district) && is_object($human->district))
                        
                        {{ $human->district->d_name ?? $human->district->name_en ?? $human->district->name }},
                    @elseif(!empty($human->discrict))
                        {{ $human->discrict }},
                    @endif

                    @if(isset($human->provinceRelation) && is_object($human->provinceRelation))
                        {{ $human->provinceRelation->name_en ?? $human->provinceRelation->name }}
                    @elseif(!empty($human->province))
                        {{ $human->province }}
                    @endif
                    
                    @else
                        No shipping address provided.
                    @endif
            </p>

                <div class="summary-title" style="color: var(--text-main);">Order Summary</div>
                <div class="Order-Id">
                    <span>Order Id:</span>
                    <span id="display_order_id" style="color: var(--primary-blue);">{{ $order_id }}</span>
                </div>
                <div class="summary-item">
                    <span>Item total:</span>
                    <span>LKR {{ number_format($totalAmount, 2) }}</span>
                </div>
                <div class="summary-item discount-text">
                    <span>Item discount:</span>
                    <span>-LKR 0.00</span>
                </div>
                <div class="summary-item discount-text">
                    <span>Shipping:</span>
                    <span>FREE</span>
                </div>
                <div class="total-amount" style="border-top: 1px solid var(--light-highlight);">
                    <span>Total</span>
                    <span style="color: var(--primary-blue);">LKR {{ number_format($totalAmount, 2) }}</span>
                </div>
                <p class="payment-note">Please refer to your final actual payment amount.</p>

                <button class="checkout-btn" id="main-action-btn" onclick="toggleView('checkout')"   style="background-color: var(--primary-blue); color: var(--white);"   >Checkout (1)</button>

                <div class="security-note" style="color: var(--dark-navy);">
                    <i class="fa fa-lock"></i>
                    <strong>Safe Payment Options</strong>
                </div>
                <p class="security-desc">dbonda is committed to protecting your payment information.</p>

                <div class="payment-icons">
                    <img src="https://img.icons8.com/color/48/visa.png" alt="Visa">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="Mastercard">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="Paypal">
                </div>
            </div>
        </div>

   

 

<script>

function saveShippingDetails(e) 
{
    e.preventDefault();  

    
    const postalCode = document.getElementById('postal_code').value.trim();
    const province = document.getElementById('province') ? document.getElementById('province').value : "";
    const city = document.getElementById('cust_district') ? document.getElementById('cust_district').value : "";
    const gnDivision = document.getElementById('gn_division') ? document.getElementById('gn_division').value : "";
    const buildingNo = document.getElementById('building_no').value.trim();
    
    
    const addressLines = Array.from(document.querySelectorAll('input[name="address_line[]"]'))
                              .map(input => input.value.trim())
                              .filter(val => val !== ""); 

    
    if (!postalCode || !province || !city || !gnDivision) {
        alert("Please fill in all required shipping details fields.");
        return;
    }

    const humanId = "{{ $human->id }}";
    
    
    fetch(`/checkout/update/${humanId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            postal_code: postalCode,
            province: province,
            cust_district: city,     
            gn_division: gnDivision, 
            building_no: buildingNo,
            address_line: addressLines
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            
            alert("Shipping details saved successfully!");
            console.log("Database updated successfully!");
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("Failed to save shipping details. Something went wrong.");
    });
}


document.addEventListener("DOMContentLoaded", function () 
{
    const provinceSelect = document.getElementById('province');
    const districtSelect = document.getElementById('cust_district');
    const gndivisionSelect = document.getElementById('gn_division');

    
    const savedDistrictId = "{{ $human->discrict ?? '' }}";
    const savedGnDivisionId = "{{ $human->gndivision ?? '' }}";

  
    provinceSelect.addEventListener('change', function () {
        let provinceId = this.value;
        
        districtSelect.innerHTML = '<option value="">Select District</option>';
        gndivisionSelect.innerHTML = '<option value="">Select GN Division</option>';

        if (!provinceId) return;

        fetch('/get-districtss/' + provinceId)
            .then(response => response.json())
            .then(data => {
                console.log("Districts fetched:", data);  
                data.forEach(item => {
                    let name = item.name_en || item.d_name || item.name;
                    
                    
                    let isSelected = (item.id == savedDistrictId) ? 'selected' : '';
                    
                    districtSelect.innerHTML += `<option value="${item.id}" ${isSelected}>${name}</option>`;
                });

                
                if (districtSelect.value) {
                    loadGnDivisions(districtSelect.value);
                }
            })
            .catch(error => console.error('Error:', error));
    });

     
    function loadGnDivisions(districtId) 
    {
        gndivisionSelect.innerHTML = '<option value="">Select GN Division</option>';

        if (!districtId) return;

        fetch(`/get-gn-divisionss/${districtId}`)
            .then(response => response.json())
            .then(data => {
                console.log("GN Divisions fetched:", data);
                data.forEach(gndivision => {
                    const option = document.createElement('option');
                    option.value = gndivision.id;
                    
                     
                    option.textContent = gndivision.name_in_english || gndivision.name_en || gndivision.name; 
                    
                     
                    if (gndivision.id == savedGnDivisionId) {
                        option.selected = true;
                    }
                    
                    gndivisionSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching GN Divisions:', error));
    }

     
    districtSelect.addEventListener('change', function() 
    {
        loadGnDivisions(this.value);
    });
    if (provinceSelect.value) 
    {
        
        provinceSelect.dispatchEvent(new Event('change'));
    }

});

</script>


<script>
    function toggleAddressForm() {
    const checkoutView = document.getElementById('checkout-view');
    const editBtn = document.getElementById('edit-address-btn');

    if (checkoutView.style.display === 'none' || checkoutView.style.display === '') {
        checkoutView.style.display = 'block';
        editBtn.innerHTML = 'Close';
        editBtn.style.color = 'red';
        editBtn.style.borderColor = 'red';
        
       
        checkoutView.scrollIntoView({ behavior: 'smooth', block: 'start' });
    } else {
        checkoutView.style.display = 'none';
        editBtn.innerHTML = 'Edit';
        editBtn.style.color = 'var(--primary-blue)';
        editBtn.style.borderColor = 'var(--primary-blue)';
    }
    
}

    let contactCounter = 1;
    let addressCounter = 2;

    window.onload = function () {
        addContactField(true);
    };

    function toggleView(view) 
{
    const cartView = document.getElementById('cart-view');
    const checkoutView = document.getElementById('checkout-view'); 
    const btn = document.getElementById('main-action-btn');
    const editBtn = document.getElementById('edit-address-btn');

    if (view === 'checkout') {
        cartView.style.display = 'none';
        
        
        checkoutView.style.display = 'none'; 
        
   
        if (editBtn) {
            editBtn.style.display = 'inline-flex'; 
        }

        btn.innerHTML = 'Confirm Order';

        btn.onclick = function (e) {
            e.preventDefault();  

            const fName = document.getElementById('cust_first_name').value.trim();
            const lName = document.getElementById('cust_last_name').value.trim();
            const email = document.getElementById('cust_email').value.trim();
            const address = document.getElementById('address_line_1').value.trim();
            const city = document.getElementById('cust_district').value;
            const postalCode = document.getElementById('postal_code').value.trim();
            const province = document.getElementById('province') ? document.getElementById('province').value : "";
            const gnDivision = document.getElementById('gn_division') ? document.getElementById('gn_division').value : "";
            const buildingNo = document.getElementById('building_no').value.trim();
            const addressLines = Array.from(document.querySelectorAll('input[name="address_line[]"]')).map(input => input.value);

            if (!fName || !email || !address || !postalCode || !city || !gnDivision) {
                alert("Please fill in all required fields.");
                return;
            }

            const humanId = "{{ $human->id ?? '' }}"; 
            if (!humanId) {
                alert("User session has expired. Please log in again.");
                return;
            }
            
            fetch(`/checkout/update/${humanId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    postal_code: postalCode,
                    province: province,
                    cust_district: city,
                    gn_division: gnDivision,
                    building_no: buildingNo,
                    address_line: addressLines
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    window.location.href = '/payhere'; 
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(error => {
                console.error('Error Details:', error);
                alert("Failed to update shipping details.");
            });
        };

        window.scrollTo({ top: 0, behavior: 'smooth' });

    } else {
        cartView.style.display = 'block';
        checkoutView.style.display = 'none';
        
        btn.innerHTML = 'Checkout (1)';
        btn.onclick = function () {
            toggleView('checkout');
        };
    }
}
    function addaddressField() 
    {
        const container = document.getElementById("address-container");
        if (addressCounter > 6) return alert("Limit reached");

        const div = document.createElement("div");
        div.className = "text-field";
        div.id = "address_line_div_" + addressCounter;
        div.innerHTML = `
            <label>Address line ${addressCounter}</label>
            <div style="display:flex; align-items:center; gap:10px;">
                <input type="text" name="address_line[]" class="checkout-input" style="flex:1;">
                <span onclick="removeField(${addressCounter})" style="cursor:pointer; color:red; font-weight:bold; font-size:20px;">−</span>
            </div>
        `;
        container.appendChild(div);
        addressCounter++;
    }

    function removeField(id) 
    {
        const element = document.getElementById("address_line_div_" + id);
        if(element) element.remove();
    }

    function removeContact(id)
    {
        const element = document.getElementById("contact_row_" + id);
        if(element) element.remove();
        contactCounter--;
    }
</script>
@endsection