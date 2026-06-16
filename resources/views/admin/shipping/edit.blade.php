@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-md-6 mx-auto">

            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Edit Shipping Charge</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('admin.shipping.update', $shipping->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- COUNTRY DROPDOWN --}}
                        <div class="mb-3">
                            <label class="form-label">
                                Country <span class="text-danger">*</span>
                            </label>
                            <select name="country" id="country-dropdown" class="form-control" required>
                                <option value="">Select Country</option>
                                <option value="India" {{ old('country', $shipping->country) == 'India' ? 'selected' : '' }}>India</option>
                                <option value="United States" {{ old('country', $shipping->country) == 'United States' ? 'selected' : '' }}>United States</option>
                                <option value="United Kingdom" {{ old('country', $shipping->country) == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                                <option value="United Arab Emirates" {{ old('country', $shipping->country) == 'United Arab Emirates' ? 'selected' : '' }}>UAE</option>
                                <option value="Malaysia" {{ old('country', $shipping->country) == 'Malaysia' ? 'selected' : '' }}>Malaysia</option>
                                <option value="Singapore" {{ old('country', $shipping->country) == 'Singapore' ? 'selected' : '' }}>Singapore</option>
                                <option value="Australia" {{ old('country', $shipping->country) == 'Australia' ? 'selected' : '' }}>Australia</option>
                            </select>
                            
                            @error('country')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- STATE DROPDOWN (Dynamically Loaded & Auto-Selected) --}}
                        <div class="mb-3">
                            <label class="form-label">
                                State Name <span class="text-danger">*</span>
                            </label>

                            <select name="state" id="state-dropdown" class="form-control" required>
                                <option value="{{ $shipping->state }}" selected>{{ $shipping->state }}</option>
                            </select>

                            @error('state')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- SHIPPING CHARGE AMOUNT --}}
                        <div class="mb-3">
                            <label class="form-label">
                                Charge Amount (₹) <span class="text-danger">*</span>
                            </label>

                            <input type="number"
                                   step="0.01"
                                   name="charge_amount"
                                   class="form-control"
                                   placeholder="Enter Amount (e.g. 100)"
                                   value="{{ old('charge_amount', $shipping->charge_amount) }}"
                                   min="0"
                                   required>

                            @error('charge_amount')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- BUTTONS --}}
                        <div class="text-end">
                            <a href="{{ route('admin.shipping.index') }}"
                               class="btn btn-secondary">
                                Back
                            </a>

                            <button type="submit"
                                    class="btn btn-primary">
                                Update Shipping Charge
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

{{-- Third-Party API JavaScript for Edit Screen --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    
    const countryDropdown = document.getElementById('country-dropdown');
    const stateDropdown = document.getElementById('state-dropdown');
    
    // 💡 ஏற்கனவே டேட்டாபேஸில் சேமிக்கப்பட்டுள்ள தற்போதைய மாநிலத்தின் பெயர்
    const savedState = "{{ $shipping->state }}";

    // மாநிலங்களை ஏபிஐ மூலம் கொண்டு வரும் ஃபங்க்ஷன்
    function loadStates(countryName, selectedState = '') {
        if (!countryName) {
            stateDropdown.innerHTML = '<option value="">Select State</option>';
            return;
        }

        stateDropdown.innerHTML = '<option value="">Loading States...</option>';

        fetch('https://countriesnow.space/api/v0.1/countries/states', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ country: countryName })
        })
        .then(response => response.json())
        .then(resData => {
            stateDropdown.innerHTML = '<option value="">Select State</option>';
            
            if (resData.data && resData.data.states && resData.data.states.length > 0) {
                resData.data.states.forEach(function (stateObject) {
                    let option = document.createElement('option');
                    option.value = stateObject.name;
                    option.textContent = stateObject.name;
                    
                    // லோடான மாநிலங்களில் சேமிக்கப்பட்ட மாநிலம் மேட்ச் ஆனால் அதை 'selected' செய்கிறது
                    if (stateObject.name === selectedState) {
                        option.selected = true;
                    }
                    stateDropdown.appendChild(option);
                });

                // Other States Default Option
                let defaultOption = document.createElement('option');
                defaultOption.value = 'Other States';
                defaultOption.textContent = 'Other States (Default)';
                if (selectedState === 'Other States') {
                    defaultOption.selected = true;
                }
                stateDropdown.appendChild(defaultOption);

            } else {
                stateDropdown.innerHTML = '<option value="Other States" selected>Other States (Default)</option>';
            }
        })
        .catch(error => {
            console.error('Error fetching from API:', error);
            stateDropdown.innerHTML = `<option value="${savedState}" selected>${savedState}</option>`;
        });
    }

    // 1️⃣ பக்கம் லோட் ஆனவுடன் தற்போதைய நாட்டுக்குரிய மாநிலங்களை தானாக லோட் செய்ய
    if (countryDropdown.value) {
        loadStates(countryDropdown.value, savedState);
    }

    // 2️⃣ அட்மின் எடிட் பக்கத்தில் நாட்டை மாற்றும்போது மாநிலங்களை மாற்றுவதற்கு
    countryDropdown.addEventListener('change', function () {
        loadStates(this.value);
    });
});
</script>

@endsection