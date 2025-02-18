@extends('frontend.layouts.app')

@section('content')
    <div class="main-content mt-5">
        <div class="container">
            <div class="form-container" style="text-align: left">
                <form class="form active contact-us-form" action="{{ route('dhl.quote') }}" method="POST">
                    @csrf
                    <h3 class="section-title">Delivery Info</h3>

                    <!-- Planned Shipping Date -->
                    <div class="form-grid mb-3">
                        <div class="input-group">
                            <label class="quotation-label" for="planned_shipping_date">Planned Shipping Date *</label>
                            <input
                                type="date"
                                class="@error('planned_shipping_date') is-invalid @enderror"
                                id="planned_shipping_date"
                                name="planned_shipping_date"
                                min="{{ now()->addDay()->toDateString() }}"
                                max="{{ now()->addDays(30)->toDateString() }}"
                                required
                            >
                        </div>
                    </div>

                    <!-- Origin Address -->
                    <h4 class="section-title">Origin Address</h4>
                    <div class="form-grid mb-3">
                        <div class="input-group">
                            <label class="quotation-label" for="origin_country">Country *</label>
                            <input
                                type="text"
                                id="origin_country"
                                name="origin_country"
                                class="@error('origin_country') is-invalid @enderror"
                                placeholder="Origin Country"
                                value="{{ old('origin_country', $DHLQuoteData['origin_country'] ?? '') }}"
                                minlength="2" maxlength="2"
                                required
                            >
                        </div>

                        <div class="input-group">
                            <label class="quotation-label" for="origin_postal">Postal Code *</label>
                            <input
                                type="text"
                                id="origin_postal"
                                name="origin_postal"
                                class="@error('origin_postal') is-invalid @enderror"
                                placeholder="Origin Postal Code"
                                value="{{ old('origin_postal', $DHLQuoteData['origin_postal'] ?? '') }}"
                                maxlength="12"
                                required
                            >
                        </div>

                        <div class="input-group">
                            <label class="quotation-label" for="origin_city">City *</label>
                            <input
                                type="text"
                                id="origin_city"
                                name="origin_city"
                                class="@error('origin_city') is-invalid @enderror"
                                placeholder="Origin City"
                                minlength="1" maxlength="45"
                                required
                            >
                        </div>

                        <div class="input-group">
                            <label class="quotation-label" for="origin_province">Province</label>
                            <input
                                type="text"
                                id="origin_province"
                                name="origin_province"
                                class="@error('origin_province') is-invalid @enderror"
                                placeholder="Origin Province/State"
                                minlength="2" maxlength="35"
                            >
                        </div>

                        <div class="input-group">
                            <label class="quotation-label" for="origin_address_line1">Address Line 1 *</label>
                            <input
                                type="text"
                                id="origin_address_line1"
                                name="origin_address_line1"
                                class="@error('origin_address_line1') is-invalid @enderror"
                                placeholder="Address Line 1"
                                minlength="1" maxlength="45"
                                required
                            >
                        </div>

                        <div class="input-group">
                            <label class="quotation-label" for="origin_address_line2">Address Line 2</label>
                            <input
                                type="text"
                                id="origin_address_line2"
                                name="origin_address_line2"
                                class="@error('origin_address_line2') is-invalid @enderror"
                                placeholder="Address Line 2"
                                minlength="1" maxlength="45"
                            >
                        </div>

                        <div class="input-group">
                            <label class="quotation-label" for="origin_address_line3">Address Line 3</label>
                            <input
                                type="text"
                                id="origin_address_line3"
                                name="origin_address_line3"
                                class="@error('origin_address_line3') is-invalid @enderror"
                                placeholder="Address Line 3"
                                minlength="1" maxlength="45"
                            >
                        </div>

                        <div class="input-group">
                            <label class="quotation-label" for="origin_county">County</label>
                            <input
                                type="text"
                                id="origin_county"
                                name="origin_county"
                                class="@error('origin_county') is-invalid @enderror"
                                placeholder="Origin County"
                                minlength="1" maxlength="45"
                            >
                        </div>
                    </div>

                    <!-- Origin Address -->
                    <h4 class="section-title">Destination Address</h4>
                    <div class="form-grid mb-3">
                        <div class="input-group">
                            <label class="quotation-label" for="destination_country">Country *</label>
                            <input
                                type="text"
                                id="destination_country"
                                name="destination_country"
                                class="@error('destination_country') is-invalid @enderror"
                                placeholder="Destination Country"
                                value="{{ old('destination_country', $DHLQuoteData['destination_country'] ?? '') }}"
                                minlength="2" maxlength="2"
                                required
                            >
                        </div>

                        <div class="input-group">
                            <label class="quotation-label" for="destination_postal">Postal Code *</label>
                            <input
                                type="text"
                                id="destination_postal"
                                name="destination_postal"
                                class="@error('destination_postal') is-invalid @enderror"
                                placeholder="Destination Postal Code"
                                value="{{ old('destination_postal', $DHLQuoteData['destination_postal'] ?? '') }}"
                                maxlength="12"
                                required
                            >
                        </div>

                        <div class="input-group">
                            <label class="quotation-label" for="destination_city">City *</label>
                            <input
                                type="text"
                                id="destination_city"
                                name="destination_city"
                                class="@error('destination_city') is-invalid @enderror"
                                placeholder="Destination City"
                                minlength="1" maxlength="45"
                                required
                            >
                        </div>

                        <div class="input-group">
                            <label class="quotation-label" for="destination_province">Province</label>
                            <input
                                type="text"
                                id="destination_province"
                                name="destination_province"
                                class="@error('destination_province') is-invalid @enderror"
                                placeholder="Destination Province/State"
                                minlength="2" maxlength="35"
                            >
                        </div>

                        <div class="input-group">
                            <label class="quotation-label" for="destination_address_line1">Address Line 1 *</label>
                            <input
                                type="text"
                                id="destination_address_line1"
                                name="destination_address_line1"
                                class="@error('destination_address_line1') is-invalid @enderror"
                                placeholder="Address Line 1"
                                minlength="1" maxlength="45"
                                required
                            >
                        </div>

                        <div class="input-group">
                            <label class="quotation-label" for="destination_address_line2">Address Line 2</label>
                            <input
                                type="text"
                                id="destination_address_line2"
                                name="destination_address_line2"
                                class="@error('destination_address_line2') is-invalid @enderror"
                                placeholder="Address Line 2"
                                minlength="1" maxlength="45"
                            >
                        </div>

                        <div class="input-group">
                            <label class="quotation-label" for="destination_address_line3">Address Line 3</label>
                            <input
                                type="text"
                                id="destination_address_line3"
                                name="destination_address_line3"
                                class="@error('destination_address_line3') is-invalid @enderror"
                                placeholder="Address Line 3"
                                minlength="1" maxlength="45"
                            >
                        </div>

                        <div class="input-group">
                            <label class="quotation-label" for="destination_county">County</label>
                            <input
                                type="text"
                                id="destination_county"
                                name="destination_county"
                                class="@error('destination_county') is-invalid @enderror"
                                placeholder="Destination County"
                                minlength="1" maxlength="45"
                            >
                        </div>
                    </div>

                    <h4 class="section-title">Package Details</h4>
                    <div class="form-grid mb-3">
                        <div class="input-group">
                            <label class="quotation-label" for="weight">Weight (kg) *</label>
                            <input
                                type="number"
                                id="weight"
                                name="weight"
                                class="@error('weight') is-invalid @enderror"
                                placeholder="Package Weight"
                                step="0.1"
                                min="0.1"
                                max="999999999999"
                                required
                            >
                        </div>

                        <div class="input-group">
                            <label class="quotation-label" for="length">Length (cm) *</label>
                            <input
                                type="number"
                                id="length"
                                name="length"
                                class="@error('length') is-invalid @enderror"
                                placeholder="Package Length"
                                step="1"
                                min="1"
                                max="9999999"
                                required
                            >
                        </div>

                        <div class="input-group">
                            <label class="quotation-label" for="width">Width (cm) *</label>
                            <input
                                type="number"
                                id="width"
                                name="width"
                                class="@error('width') is-invalid @enderror"
                                placeholder="Package Width"
                                step="1"
                                min="1"
                                max="9999999"
                                required
                            >
                        </div>

                        <div class="input-group">
                            <label class="quotation-label" for="height">Height (cm) *</label>
                            <input
                                type="number"
                                id="height"
                                name="height"
                                class="@error('height') is-invalid @enderror"
                                placeholder="Package Height"
                                step="1"
                                min="1"
                                max="9999999"
                                required
                            >
                        </div>
                    </div>

                    <button type="submit" id="quote-submit" class="submit-button">Get Quote Info</button>
                </form>
            </div>
        </div>
    </div>
@endsection
