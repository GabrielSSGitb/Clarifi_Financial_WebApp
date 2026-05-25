let result = null;

export function addup(currentInput) {
    const num = Number(currentInput);
    result = (result === null) ? num : result + num;
    return result.toFixed(2);
}

export function subtraction(currentInput) {
    const num = Number(currentInput);
    result = (result === null) ? num : result - num;
    return result.toFixed(2);
}

export function product(currentInput) {
    const num = Number(currentInput);
    result = (result === null) ? num : result * num;
    return result.toFixed(2);
}

export function division(currentInput) {
    const num = Number(currentInput);
    if (num === 0 && result !== null) {
        alert("Cannot divide by zero");
        return result.toFixed(2);
    }
    result = (result === null) ? num : result / num;
    return result.toFixed(2);
}

export function exponecial(currentInput) {
    const num = Number(currentInput);
    result = (result === null) ? num : Math.pow(result, num);
    return result.toFixed(2);
}

export function clearInputVariable() {
    result = null;
}

export function exportResultValue() {
    return result.toFixed(2) ?? 0;
}
