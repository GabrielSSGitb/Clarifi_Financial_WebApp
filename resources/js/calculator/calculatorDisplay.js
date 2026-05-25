document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('toggleCalculatorBtn');
    const calcWidget = document.getElementById('globalCalculator');

    // 1. Toggle visibility animation
    toggleBtn.addEventListener('click', function () {
        if (calcWidget.classList.contains('hidden')) {
            calcWidget.classList.remove('hidden');

            setTimeout(() => {
                calcWidget.classList.remove('scale-95', 'opacity-0');
            }, 10);
        } else {
            calcWidget.classList.add('scale-95', 'opacity-0');
            setTimeout(() => calcWidget.classList.add('hidden'), 200);
        }
    });
});
