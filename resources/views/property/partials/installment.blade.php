<div class="section-content">
    <div class="row">
        <div class="col-sm-6 mb-3 mt-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="installments_available" name="installments_available"
                    value="true" @checked($property ? $property->installments_available : old('installments_available'))>
                <label class="form-check-label" for="installments_available">Installments Available?</label>
            </div>
            <label class="form-check-label" for="installments_available">Enable this option if your property is
                available on installments</label>
        </div>
    </div>
</div>
<div id="installment-block">
    <hr>
    <div class="section-title">Installment Details</div>
    <div class="section-content">
        <div class="row">
            <div class="col-sm-6 mb-3">
                <label for="title">Advance Amount</label>
                <div class="input-group">
                    <input type="number" class="form-control " name="advance_amount" id="advance-amount" step="any"
                        value="{{ $property ? $property->advance_amount : old('advance_amount') }}" min="0" oninput="this.value = Math.max(0, this.value)" disabled
                        placeholder="Enter amount" >
                    <span class="input-group-text ms-1">PKR</span>
                </div>
                <div id="advance-amount-error" class="text-danger position-relative" style="display: none;bottom: 12px"></div>

            </div>
          
            <div class="col-sm-3 mb-3">
                <label for="title">No. of Installments</label>
                <input type="number" class="form-control" name="no_of_installments" id="no-of-installments" min="0" oninput="this.value = Math.max(0, this.value)" step="any"
                    value="{{ $property ? $property->no_of_installments : old('no_of_installments') }}" disabled
                    placeholder="Enter number">
            </div>
              <div class="col-sm-6 mb-3">
                <label for="title">Monthly Installments</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="monthly-installment"
                        value="{{ $property ? $property->monthly_installment : old('monthly_installment') }}" readonly
                        placeholder="Enter amount">
                    <input type="hidden" name="monthly_installment" id="hidden-monthly-installment" min="0"
                        value="{{ $property ? $property->monthly_installment : old('monthly_installment') }}">
                    <span class="input-group-text ms-1">PKR</span>
                </div>
            </div>
        </div>
    </div>
</div>

@include('property.installment.script')