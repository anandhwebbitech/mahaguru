@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-md-6 mx-auto">

            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Add Shipping Charge</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('admin.shipping.store') }}" method="POST">
                        @csrf

                        {{-- COUNTRY DROPDOWN --}}
                        <div class="mb-3">
                            <label class="form-label">
                                Country <span class="text-danger">*</span>
                            </label>
                            <select name="country" id="country-dropdown" class="form-control" required>
                                <option value="">Select Country</option>
                                <option value="India" {{ old('country') == 'India' ? 'selected' : '' }}>India</option>
                                <option value="United States" {{ old('country') == 'United States' ? 'selected' : '' }}>United States</option>
                                <option value="United Kingdom" {{ old('country') == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                                <option value="United Arab Emirates" {{ old('country') == 'United Arab Emirates' ? 'selected' : '' }}>UAE</option>
                                <option value="Malaysia" {{ old('country') == 'Malaysia' ? 'selected' : '' }}>Malaysia</option>
                                <option value="Singapore" {{ old('country') == 'Singapore' ? 'selected' : '' }}>Singapore</option>
                                <option value="Australia" {{ old('country') == 'Australia' ? 'selected' : '' }}>Australia</option>
                            </select>
                            
                            @error('country')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- STATE DROPDOWN (Dynamically Loaded via Third-Party API) --}}
                        <div class="mb-3">
                            <label class="form-label">
                                State Name <span class="text-danger">*</span>
                            </label>

                            <select name="state" id="state-dropdown" class="form-control" required>
                                <option value="">Select State</option>
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
                                   value="{{ old('charge_amount') }}"
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
                                    class="btn btn-success">
                                Save Shipping Charge
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

{{-- Third-Party API JavaScript Logic --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    
    const countryDropdown = document.getElementById('country-dropdown');
    const stateDropdown = document.getElementById('state-dropdown');

    countryDropdown.addEventListener('change', function () {
        let selectedCountry = this.value;
        
        // பழைய ஆப்ஷன்களை கிளியர் செய்துவிட்டு Loading மெசேஜ் காட்டுகிறோம்
        stateDropdown.innerHTML = '<option value="">Loading States...</option>';
        
        if (!selectedCountry) {
            stateDropdown.innerHTML = '<option value="">Select State</option>';
            return;
        }

        // CountriesNow API-க்கு POST Request அனுப்புகிறோம்
        fetch('https://countriesnow.space/api/v0.1/countries/states', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                country: selectedCountry // எ.கா: "India" அல்லது "United States"
            })
        })
        .then(response => response.json())
        .then(resData => {
            stateDropdown.innerHTML = '<option value="">Select State</option>';
            
            // API-யில் இருந்து டேட்டா சரியாக வந்தால் (data.states இருக்கும்)
            if (resData.data && resData.data.states && resData.data.states.length > 0) {
                
                resData.data.states.forEach(function (stateObject) {
                    let option = document.createElement('option');
                    // API-யில் மாநிலத்தின் பெயர் 'name' கீ-க்குள் இருக்கும் (e.g. stateObject.name = "Tamil Nadu")
                    option.value = stateObject.name;
                    option.textContent = stateObject.name;
                    stateDropdown.appendChild(option);
                });

                // 💡 பேக்அப்பிற்காக 'Other States' ஆப்ஷனையும் கடைசியாக சேர்த்துக் கொள்வோம்
                let defaultOption = document.createElement('option');
                defaultOption.value = 'Other States';
                defaultOption.textContent = 'Other States (Default)';
                stateDropdown.appendChild(defaultOption);

            } else {
                // ஒருவேளை அந்த நாட்டுக்கு மாநிலங்கள் இல்லை என்றால்
                stateDropdown.innerHTML = '<option value="Other States">Other States (Default)</option>';
            }
        })
        .catch(error => {
            console.error('Error fetching from API:', error);
            stateDropdown.innerHTML = '<option value="Other States">Error Loading! Select Other States </option>';
        });
    });
});
</script>

@endsection