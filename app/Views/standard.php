<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Standard Calculator</title>
    <style>
        
       .calculator-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 30px;
            margin-top: 30px;
        }

        .calculator, .history {
            display: flex;
            flex-direction: column;
            gap: 10px;
            background: linear-gradient(135deg, #d1b3e0, #f8c6d8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 400px;
            height: 550px;
            color: white;
        }

        .calculator {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }

        .display {
            grid-column: span 4;
            background: linear-gradient(135deg, #e2c6f2, #fad0e6);
            border-radius: 5px;
            padding: 20px;
            font-size: 32px;
            text-align: right;
            overflow: hidden;
            white-space: nowrap;
        }

        .calculator button {
            font-size: 22px;
            padding: 20px;
            border: none;
            border-radius: 5px;
            background: linear-gradient(135deg, #b277d6, #d48cb3);
            color: white;
            cursor: pointer;
            transition: background 0.2s ease, transform 0.1s ease;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
        }

        .calculator button:active {
            background: linear-gradient(135deg, #9b5fc1, #c0789c);
            transform: scale(0.95);
        }

        .calculator button.equal {
            background: linear-gradient(135deg, #f37ba3, #f8bbd0);
            font-weight: bold;
        }

        .history h3 {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .history .entry {
            font-size: 18px;
            margin: 5px 0;
            padding: 5px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            color: white;
        }

        #delete-history {
            background: none;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="calculator-container">
        <div class="calculator">
            <div class="display" id="display">0</div>
            <button class="special">C</button>
            <button class="backspace">&larr;</button>
            <button>/</button>
            <button>*</button>
            <button>7</button>
            <button>8</button>
            <button>9</button>
            <button>-</button>
            <button>4</button>
            <button>5</button>
            <button>6</button>
            <button>+</button>
            <button>1</button>
            <button>2</button>
            <button>3</button>
            <button>0</button>
            <button>.</button>
            <button class="equal">=</button>
        </div>

        <div class="history" id="history">
            <h3>
                History
                <button id="delete-history">🗑</button>
            </h3>
            <p id="no-history">No history available.</p>
        </div>
    </div>

    <script>
        const display = document.getElementById('display');
        const historyContainer = document.getElementById('history');
        const buttons = document.querySelectorAll('.calculator button');
        let currentExpression = '';

        function updateHistoryUI() {
            const history = JSON.parse(localStorage.getItem('history')) || [];
            historyContainer.innerHTML = '<h3>History <button id="delete-history">🗑</button></h3>';
            if (history.length === 0) {
                historyContainer.innerHTML += '<p id="no-history">No history available.</p>';
            } else {
                history.forEach(entry => {
                    const div = document.createElement('div');
                    div.classList.add('entry');
                    div.textContent = `${entry.expression} = ${entry.result}`;
                    historyContainer.appendChild(div);
                });
            }
            document.getElementById('delete-history').addEventListener('click', clearHistory);
        }

        buttons.forEach(button => {
            button.addEventListener('click', () => {
                const value = button.textContent;
                if (value === 'C') {
                    display.textContent = '0';
                    currentExpression = '';
                } else if (value === '=') {
                    try {
                        const result = eval(currentExpression);
                        display.textContent = result;
                        addHistory(currentExpression, result);
                        currentExpression = result.toString();
                    } catch {
                        display.textContent = 'Error';
                    }
                } else if (value === '←') {
                    currentExpression = currentExpression.slice(0, -1);
                    display.textContent = currentExpression || '0';
                } else {
                    currentExpression += value;
                    display.textContent = currentExpression;
                }
            });
        });

        function addHistory(expression, result) {
            const history = JSON.parse(localStorage.getItem('history')) || [];
            history.push({ expression, result });
            localStorage.setItem('history', JSON.stringify(history));
            updateHistoryUI();
        }

        function clearHistory() {
            localStorage.removeItem('history');
            updateHistoryUI();
        }

        updateHistoryUI();
    </script>
</body>
</html>