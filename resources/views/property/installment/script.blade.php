<script>
    (function() {
        function ready(fn) {
            if (document.readyState !== 'loading') {
                fn();
            } else {
                document.addEventListener('DOMContentLoaded', fn);
            }
        }

        ready(function() {
            var $ = window.jQuery;
            var advanceAmount = document.getElementById('advance-amount');
            var price = document.getElementById('price');
            var monthlyInstallment = document.getElementById('monthly-installment');
            var noOfInstallments = document.getElementById('no-of-installments');
            var errorElement = document.getElementById('advance-amount-error');
            var hiddenMonthlyInstallment = document.getElementById('hidden-monthly-installment');

            function validateAdvanceAmount() {
                var advanceValue = parseFloat($ ? $(advanceAmount).val() : advanceAmount.value);
                var priceValue = parseFloat($ ? $(price).val() : price.value);

                if (isNaN(advanceValue) || isNaN(priceValue)) {
                    if ($) {
                        $(errorElement).hide();
                    } else {
                        errorElement.style.display = 'none';
                    }
                    return;
                }

                if (advanceValue >= priceValue) {
                    if ($) {
                        $(errorElement).text('Advance amount must be less than the total price.').show();
                        $(advanceAmount).val('');
                    } else {
                        errorElement.textContent = 'Advance amount must be less than the total price.';
                        errorElement.style.display = 'block';
                        advanceAmount.value = '';
                    }
                } else {
                    if ($) {
                        $(errorElement).hide();
                    } else {
                        errorElement.style.display = 'none';
                    }
                }
                calculateMonthlyInstallment();
            }

            function calculateMonthlyInstallment() {
                var advanceValue = parseFloat($ ? $(advanceAmount).val() : advanceAmount.value);
                var priceValue = parseFloat($ ? $(price).val() : price.value);
                var installmentsValue = parseInt($ ? $(noOfInstallments).val() : noOfInstallments.value);

                if (!isNaN(priceValue) && !isNaN(advanceValue) && !isNaN(installmentsValue) &&
                    installmentsValue > 0) {
                    var remainingAmount = priceValue - advanceValue;
                    var monthlyAmount = remainingAmount / installmentsValue;

                    if ($) {
                        $(monthlyInstallment).val(monthlyAmount.toFixed(2));
                        $(hiddenMonthlyInstallment).val(monthlyAmount.toFixed(2));
                    } else {
                        monthlyInstallment.value = monthlyAmount.toFixed(2);
                        hiddenMonthlyInstallment.value = monthlyAmount.toFixed(2);
                    }
                } else {
                    if ($) {
                        $(monthlyInstallment).val('');
                        $(hiddenMonthlyInstallment).val('');
                    } else {
                        monthlyInstallment.value = '';
                        hiddenMonthlyInstallment.value = '';
                    }
                }
            }

            if ($) {
                $(advanceAmount).on('input', validateAdvanceAmount);
                $(price).on('input', validateAdvanceAmount);
                $(noOfInstallments).on('input', calculateMonthlyInstallment);
            } else {
                advanceAmount.addEventListener('input', validateAdvanceAmount);
                price.addEventListener('input', validateAdvanceAmount);
                noOfInstallments.addEventListener('input', calculateMonthlyInstallment);
            }

            // Initial calculation
            calculateMonthlyInstallment();
        });
    })();
</script>
