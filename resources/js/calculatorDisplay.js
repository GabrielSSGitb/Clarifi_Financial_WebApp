document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('toggleCalculatorBtn');
    const calcWidget = document.getElementById('globalCalculator');
    const calcDisplay = document.getElementById('calcDisplay');
    const calcHistory = document.getElementById('calcHistory');

    let currentInput = '';
    let expression = '';

    // 1. Toggle visibility animation
    toggleBtn.addEventListener('click', function () {
        if (calcWidget.classList.contains('hidden')) {
            calcWidget.classList.remove('hidden');
            // Give browser an instant to catch DOM update for smooth transition
            setTimeout(() => {
                calcWidget.classList.remove('scale-95', 'opacity-0');
            }, 10);
        } else {
            calcWidget.classList.add('scale-95', 'opacity-0');
            setTimeout(() => calcWidget.classList.add('hidden'), 200);
        }
    });
});
