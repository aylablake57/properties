<x-guest-layout>
    <style>
    </style>
     <div class="box-wrapper p-0 pb-5" style="height: auto;">
        <div class="modal fade show d-block" id="agreementModal" tabindex="-1" aria-labelledby="agreementModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="agreementModalLabel">User Agreement</h5>
                    </div>
                    <div class="modal-body">
                        <p>Please read and accept the following agreement to proceed:</p>
                        <div class="p-3" style="max-height: 300px; overflow-y: auto; border: 1px solid #a0af50;">
                            <p>
                                Any one is allowed to offer property for sale himself or on behalf
                                If wrongly uploaded than upon complaint and proof of exact ownership provided by complainant the dealer detail is provided to complainant
                                If still an issue than upon proof of non resolution we can block the dealer as punitive action
                                If dealer proves that the property was offered by owner himself than the owner is responsible.
                            </p>
                        </div>
                        <form action="{{ route('agreement.accept') }}" method="POST" class="mt-3">
                            @csrf
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="agree" id="agree" required>
                                <label class="form-check-label" for="agree">
                                    I have read and agree to the terms and conditions.
                                </label>
                                @error('agree')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-accent">Accept</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
     </div>
 </x-guest-layout>
