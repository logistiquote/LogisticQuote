@extends('frontend.layouts.app')

@section('content')
    <div class="main-content mt-5">
        <div class="container">
            @include('panels.includes.errors')
            <div class="form-container" style="text-align: left">
                <form class="form active contact-us-form" action="{{ route('dhl.quote') }}" method="GET">
                    @csrf
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
                            <label class="quotation-label" for="origin_country">Country Code *</label>
                            <input
                                type="text"
                                id="origin_country"
                                name="origin_country"
                                class="@error('origin_country') is-invalid @enderror"
                                placeholder="US, GB, DE, etc."
                                maxlength="2"
                                value="{{ old('origin_country', $DHLQuoteData['origin_country'] ?? '') }}"
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
                                value="{{ old('origin_city', $DHLQuoteData['origin_city'] ?? '') }}"
                                required
                            >
                        </div>

                        <div class="input-group">
                            <label class="quotation-label" for="origin_postal_code">Postal Code *</label>
                            <input
                                type="text"
                                id="origin_postal_code"
                                name="origin_postal_code"
                                class="@error('origin_postal_code') is-invalid @enderror"
                                placeholder="Origin Postal Code"
                                minlength="1" maxlength="45"
                                value="{{ old('origin_postal_code', $DHLQuoteData['origin_postal_code'] ?? '') }}"
                                required
                            >
                        </div>
                    </div>

                    <!-- Destination Address -->
                    <h4 class="section-title">Destination Address</h4>
                    <div class="form-grid mb-3">
                        <div class="input-group">
                            <label class="quotation-label" for="destination_country">Country Code *</label>
                            <input
                                type="text"
                                id="destination_country"
                                name="destination_country"
                                class="@error('destination_country') is-invalid @enderror"
                                placeholder="US, GB, DE, etc."
                                maxlength="2"
                                value="{{ old('destination_country', $DHLQuoteData['destination_country'] ?? '') }}"
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
                                value="{{ old('destination_city', $DHLQuoteData['destination_city'] ?? '') }}"
                                required
                            >
                        </div>

                        <div class="input-group">
                            <label class="quotation-label" for="destination_postal_code">Postal Code *</label>
                            <input
                                type="text"
                                id="destination_postal_code"
                                name="destination_postal_code"
                                class="@error('destination_postal_code') is-invalid @enderror"
                                placeholder="Destination Postal Code"
                                minlength="1" maxlength="45"
                                value="{{ old('destination_postal_code', $DHLQuoteData['destination_postal_code'] ?? '') }}"
                                required
                            >
                        </div>
                    </div>

                    <!-- Package Details -->
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
                                max="1000"
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
                                max="300"
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
                                max="120"
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
                                max="160"
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
