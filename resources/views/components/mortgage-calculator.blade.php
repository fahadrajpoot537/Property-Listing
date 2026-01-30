@php
    $mortgageSetting = \App\Models\MortgageSetting::first() ?? new \App\Models\MortgageSetting(['down_payment_percentage' => 20, 'interest_rate' => 3.5, 'loan_term_years' => 20]);
    $price = $slot; 
@endphp

<div class="property-calculator sidebar-widget p-4 mb-4" style="background: #f8f9fa; border-radius: 10px;">
    <h4 class="mb-3">Mortgage Calculator</h4>

    <div class="row">
        <!-- Result Display -->
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted">Monthly Payment</span>
                <span class="h4 text-primary m-0" id="monthly-payment-display">AED 0.00</span>
            </div>

            <div class="d-flex justify-content-between small text-muted mb-1">
                <span>Down Payment:</span>
                <span id="down-payment-display">AED 0.00</span>
            </div>
            <div class="d-flex justify-content-between small text-muted">
                <span>Loan Amount:</span>
                <span id="loan-amount-display">AED 0.00</span>
            </div>
        </div>

        <!-- Calculator Inputs -->
        <div class="col-md-12 mb-3">
            <label class="small text-muted mb-1">Total Amount (AED)</label>
            <input type="number" id="calc-total-amount" class="form-control" value="{{ $price }}">
        </div>

        <div class="col-md-12 mb-3">
            <label class="small text-muted mb-1">Down Payment (%)</label>
            <div class="input-group">
                <input type="number" id="calc-down-payment" class="form-control"
                    value="{{ $mortgageSetting->down_payment_percentage }}">
                <span class="input-group-text">%</span>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="small text-muted mb-1">Interest Rate (%)</label>
            <div class="input-group">
                <input type="number" id="calc-interest-rate" class="form-control" step="0.1"
                    value="{{ $mortgageSetting->interest_rate }}">
                <span class="input-group-text">%</span>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="small text-muted mb-1">Loan Terms (Years)</label>
            <input type="number" id="calc-loan-terms" class="form-control"
                value="{{ $mortgageSetting->loan_term_years }}">
        </div>

        <div class="col-12">
            <button type="button" class="btn btn-outline-primary w-100" onclick="calculateMortgage()">Calculate</button>
        </div>
    </div>
</div>

<script>
    function calculateMortgage() {
        // Get values
        const totalAmount = parseFloat(document.getElementById('calc-total-amount').value) || 0;
        const downPaymentPercent = parseFloat(document.getElementById('calc-down-payment').value) || 0;
        const interestRate = parseFloat(document.getElementById('calc-interest-rate').value) || 0;
        const years = parseFloat(document.getElementById('calc-loan-terms').value) || 0;

        // Calculations
        const downPaymentAmount = totalAmount * (downPaymentPercent / 100);
        const loanAmount = totalAmount - downPaymentAmount;

        // Monthly interest rate
        const monthlyRate = (interestRate / 100) / 12;
        const numberOfPayments = years * 12;

        let monthlyPayment = 0;

        if (interestRate === 0) {
            monthlyPayment = loanAmount / numberOfPayments;
        } else {
            // Mortgage formula: M = P [ i(1 + i)^n ] / [ (1 + i)^n – 1 ]
            monthlyPayment = loanAmount * (monthlyRate * Math.pow(1 + monthlyRate, numberOfPayments)) / (Math.pow(1 + monthlyRate, numberOfPayments) - 1);
        }

        // Display results
        const formatter = new Intl.NumberFormat('en-AE', {
            style: 'currency',
            currency: 'AED',
            minimumFractionDigits: 2
        });

        document.getElementById('monthly-payment-display').innerText = formatter.format(monthlyPayment);
        document.getElementById('down-payment-display').innerText = formatter.format(downPaymentAmount);
        document.getElementById('loan-amount-display').innerText = formatter.format(loanAmount);
    }

    // Run calculation on load
    document.addEventListener('DOMContentLoaded', function () {
        calculateMortgage();

        // Add event listeners for Enter key
        const inputs = ['calc-total-amount', 'calc-down-payment', 'calc-interest-rate', 'calc-loan-terms'];
        inputs.forEach(id => {
            document.getElementById(id).addEventListener('input', calculateMortgage);
        });
    });
</script>