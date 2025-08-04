@extends('guest.layouts.guest')
@section('title') Area Unit Converter @endsection
@section('local-style')
<link href="{{getAdminAsset('css/inner.css')}}?v={{ config('app.version') }}" rel="stylesheet">
<style>
    .toggle-button {
        background-color: #e9ecef;
        color: #333;
        padding: 10px 20px;
        border-radius: 30px;
        transition: all 0.3s ease;
        cursor: pointer;
        border: 1px solid #ddd;
        text-align: center;
        width: 100%;
        display: inline-block;
    }

    .toggle-button:hover {
        background-color: #a0af50;
        color: white;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection

@section('page')
<div class="main my-5 py-5">
    <div class="container ad-margin-top">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="converter-section-title">
                    <h2>Area Unit Converter</h2>
                </div>
            </div>

            <!-- Converter Container -->
            <div class="converter-container">
                <!-- Right Container -->
                <div class="converter-right-container">
                    <label class="form-label">Marla Size:</label>
                    <div class="row g-0 justify-content-center">
                        <div>
                            <div class="col-md-12 mb-4">
                                <span class="toggle-button active-cal-area" onclick="setConversionRate(225, this)">225 /Sq. ft.</span>
                            </div>
                            <div class="col-md-12 mb-4">
                                <span class="toggle-button" onclick="setConversionRate(250, this)">250 /Sq. ft.</span>
                            </div>
                            <div class="col-md-12 mb-4">
                                <span class="toggle-button" onclick="setConversionRate(272, this)">272 /Sq. ft.</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Center Container -->
                <div class="converter-center-container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <input type="number" id="inputValue" class="form-control area-input-form-control" oninput="convertArea('input')" value="1">
                                <select id="inputUnit" class="form-select area-select-form-control" onchange="convertArea('input')">
                                    <option value="sqft">Sq. ft.</option>
                                    <option value="sqyd">Sq. yd.</option>
                                    <option value="sqm">Sq. m.</option>
                                    <option value="marla" selected>Marla</option>
                                    <option value="kanal">Kanal</option>
                                    <option value="acre">Acre</option>
                                    <option value="murabba">Murabba</option>
                                    <option value="hectare">Hectare</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <input type="number" id="outputValue" class="form-control area-input-form-control" oninput="convertArea('output')" value="225">
                                <select id="outputUnit" class="form-select area-select-form-control" onchange="convertArea('output')">
                                    <option value="sqft">Sq. ft.</option>
                                    <option value="sqyd">Sq. yd.</option>
                                    <option value="sqm">Sq. m.</option>
                                    <option value="marla">Marla</option>
                                    <option value="kanal">Kanal</option>
                                    <option value="acre">Acre</option>
                                    <option value="murabba">Murabba</option>
                                    <option value="hectare">Hectare</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Left Container -->
                <div class="converter-left-container">
                    <label class="form-label">Quick Converters</label>
                    <div class="row g-0 justify-content-center">
                        <div class="col-auto mb-4 me-1">
                            <span class="toggle-button" onclick="setConversionUnit('sqft', 'sqyd')">Sq. ft. -> Sq. yd.</span>
                        </div>
                        <div class="col-auto mb-4 me-1">
                            <span class="toggle-button" onclick="setConversionUnit('marla', 'sqyd')">Marla -> Sq. yd.</span>
                        </div>
                        <div class="col-auto mb-4 me-1">
                            <span class="toggle-button" onclick="setConversionUnit('sqm', 'sqyd')">Sq. m. -> Sq. yd.</span>
                        </div>
                        <div class="col-auto mb-4 me-1">
                            <span class="toggle-button" onclick="setConversionUnit('kanal', 'marla')">Kanal -> Marla</span>
                        </div>
                        <div class="col-auto mb-4 me-1">
                            <span class="toggle-button" onclick="setConversionUnit('sqft', 'sqm')">Sq. ft. -> Sq. m.</span>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
