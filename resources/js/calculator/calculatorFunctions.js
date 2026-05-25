import {
    addup,
    subtraction,
    product,
    division,
    exponecial,
    clearInputVariable,
    exportResultValue
} from "./basicMath.js";

document.addEventListener('DOMContentLoaded', function () {
    const calcDisplay = document.getElementById('calcDisplay');
    const calcHistory = document.getElementById('calcHistory');
    const calc_btn = document.querySelectorAll('.calc-btn');

    let currentInput = '';
    let expression = '';

    calc_btn.forEach(button => {
        button.addEventListener('click', () => {
            const val = button.getAttribute('data-val');

            switch (val) {
                case '+':
                    if (!currentInput) return;
                    calcHistory.textContent = addup(currentInput) + " +";
                    calcDisplay.textContent = "0";
                    expression = '+';
                    currentInput = "";
                    break;
                case '-':
                    if (!currentInput) return;
                    calcHistory.textContent = subtraction(currentInput) + " -";
                    calcDisplay.textContent = "0";
                    expression = '-';
                    currentInput = "";
                    break;
                case '*':
                    if (!currentInput) return;
                    calcHistory.textContent = product(currentInput) + " *";
                    calcDisplay.textContent = "0";
                    expression = '*';
                    currentInput = "";
                    break;
                case '/':
                    if (!currentInput) return;
                    calcHistory.textContent = division(currentInput) + " /";
                    calcDisplay.textContent = "0";
                    expression = '/';
                    currentInput = "";
                    break;
                case '^':
                    if (!currentInput) return;
                    calcHistory.textContent = exponecial(currentInput) + " ^";
                    calcDisplay.textContent = "0";
                    expression = '^';
                    currentInput = "";
                    break;
                default:
                    if (val === '.' && currentInput.includes('.')) return;

                    currentInput += val;
                    calcDisplay.textContent = currentInput;
            }
        });
    });

    document.querySelector('#deleteLineBtn').addEventListener('click', () => {
        currentInput = currentInput.slice(0, -1);
        calcDisplay.textContent = currentInput || "0";
    });

    document.querySelector('#equalBtn').addEventListener('click', () => {
        if (currentInput !== "") {
            if (expression === '+') addup(currentInput);
            if (expression === '-') subtraction(currentInput);
            if (expression === '*') product(currentInput);
            if (expression === '/') division(currentInput);
            if (expression === '^') exponecial(currentInput);
        }

        calcHistory.textContent = "";
        calcDisplay.textContent = exportResultValue();
        currentInput = exportResultValue().toString();
        expression = "";
    });

    document.querySelector('#clearScreenBtn').addEventListener('click', () => {
        calcDisplay.textContent = "0";
        calcHistory.textContent = "";
        currentInput = '';
        expression = '';
        clearInputVariable();
    });
});
