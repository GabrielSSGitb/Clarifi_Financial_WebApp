const calcDisplay = document.getElementById('calcDisplay');
const calcHistory = document.getElementById('calcHistory');
const calc_btn = document.querySelectorAll('.calc-btn ');

let currentInput = '';
let expression = '';

calc_btn.forEach(button => {
    button.addEventListener('click', () => {
        const val = button.getAttribute('data-val')

        switch (val) {
            case '+':
                console.log('Addup')
                break
            case '-':
                console.log('substraction')
                break
            case '*':
                console.log('product')
                break
            case '/':
                console.log('divide')
                break
            case 'C':
                console.log('clear all')
                break
            case '^':
                console.log('exp')
                break
            case '=':
                console.log('=')
                break
            default:
               currentInput += val
                calcDisplay.textContent=""
                calcDisplay.append(currentInput)

        }

        console.log(currentInput)
    })
})

document.querySelector('#deleteLineBtn').addEventListener('click', () => {
    let newInputValue = currentInput.slice(0, -1)
    currentInput = newInputValue
    calcDisplay.textContent=currentInput
})
document.querySelector('#equalBtn').addEventListener('click', () => {
    calcDisplay.textContent=""
    calcDisplay.append('00.00')
})
