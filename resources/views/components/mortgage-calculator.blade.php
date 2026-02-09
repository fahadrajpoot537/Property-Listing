@php
    $mortgageSetting = \App\Models\MortgageSetting::first() ?? new \App\Models\MortgageSetting(['down_payment_percentage' => 20, 'interest_rate' => 3.5, 'loan_term_years' => 20]);
    $price = $slot; 
@endphp

<div class="calculator-container-v2 p-6 rounded-3xl bg-gray-50 border border-gray-100 shadow-inner">
    <div class="mb-6 pb-6 border-b border-gray-200">
        <label class="text-xs font-black uppercase tracking-widest text-gray-400 mb-2 block">Estimated Monthly
            Payment</label>
        <div class="text-4xl font-black text-secondary" id="monthly-payment-display">£0.00</div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="col-span-full">
            <label class="text-xs font-bold text-primary mb-1 block">Total Amount (£)</label>
            <input type="number" id="calc-total-amount"
                class="w-full bg-white border border-gray-200 rounded-xl p-3 font-bold focus:ring-secondary focus:border-secondary"
                value="{{ $price }}">
        </div>

        <div>
            <label class="text-xs font-bold text-primary mb-1 block">Down Payment (%)</label>
            <input type="number" id="calc-down-payment"
                class="w-full bg-white border border-gray-200 rounded-xl p-3 font-bold focus:ring-secondary focus:border-secondary"
                value="{{ $mortgageSetting->down_payment_percentage }}">
        </div>

        <div>
            <label class="text-xs font-bold text-primary mb-1 block">Interest Rate (%)</label>
            <input type="number" id="calc-interest-rate"
                class="w-full bg-white border border-gray-200 rounded-xl p-3 font-bold focus:ring-secondary focus:border-secondary"
                step="0.1" value="{{ $mortgageSetting->interest_rate }}">
        </div>

        <div class="col-span-full">
            <label class="text-xs font-bold text-primary mb-1 block">Loan Terms (Years)</label>
            <input type="number" id="calc-loan-terms"
                class="w-full bg-white border border-gray-200 rounded-xl p-3 font-bold focus:ring-secondary focus:border-secondary"
                value="{{ $mortgageSetting->loan_term_years }}">
        </div>
    </div>

    <div class="mt-8 space-y-3">
        <div class="flex justify-between items-center text-sm">
            <span class="text-gray-500 font-medium">Down Payment Amount:</span>
            <span class="font-bold text-primary" id="down-payment-display">£0.00</span>
        </div>
        <div class="flex justify-between items-center text-sm">
            <span class="text-gray-500 font-medium">Loan Amount:</span>
            <span class="font-bold text-primary" id="loan-amount-display">£0.00</span>
        </div>
    </div>
</div>

<script>
    function calculateMortgage() {
        const totalAmount = parseFloat(document.getElementById('calc-total-amount').value) || 0;
        const downPaymentPercent = parseFloat(document.getElementById('calc-down-payment').value) || 0;
        const interestRate = parseFloat(document.getElementById('calc-interest-rate').value) || 0;
        const years = parseFloat(document.getElementById('calc-loan-terms').value) || 0;

        const downPaymentAmount = totalAmount * (downPaymentPercent / 100);
        const loanAmount = totalAmount - downPaymentAmount;

        const monthlyRate = (interestRate / 100) / 12;
        const numberOfPayments = years * 12;

        let monthlyPayment = 0;

        if (interestRate === 0) {
            monthlyPayment = loanAmount / numberOfPayments;
        } else if (numberOfPayments > 0) {
            monthlyPayment = loanAmount * (monthlyRate * Math.pow(1 + monthlyRate, numberOfPayments)) / (Math.pow(1 + monthlyRate, numberOfPayments) - 1);
        }

        const formatter = new Intl.NumberFormat('en-GB', {
            style: 'currency',
            currency: 'GBP',
            minimumFractionDigits: 2
        });

        document.getElementById('monthly-payment-display').innerText = formatter.format(monthlyPayment);
        document.getElementById('down-payment-display').innerText = formatter.format(downPaymentAmount);
        document.getElementById('loan-amount-display').innerText = formatter.format(loanAmount);
    }

    document.addEventListener('DOMContentLoaded', function () {
        calculateMortgage();
        ['calc-total-amount', 'calc-down-payment', 'calc-interest-rate', 'calc-loan-terms'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.addEventListener('input', calculateMortgage);
        });
    });
</script>