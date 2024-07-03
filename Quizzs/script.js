document.addEventListener('DOMContentLoaded', () => {
    let questionIndex = 1;


    document.querySelector('.add-choice').addEventListener('click', function() {
        addChoice(this.closest('.question'), 0);
    });

    document.getElementById('add-question').addEventListener('click', () => {
        addQuestion();
    });

    function addQuestion() {
        const questionContainer = document.createElement('div');
        questionContainer.classList.add('question');
        questionContainer.setAttribute('data-question-index', questionIndex);

        questionContainer.innerHTML = `
            <label>Question:</label>
            <textarea name="questions[${questionIndex}][text]" required></textarea>
            <div class="choices">
                <div class="choice" data-choice-index="0">
                    <label>Choice:</label>
                    <input type="text" name="questions[${questionIndex}][choices][0][text]" required>
                    <label>Correct:</label>
                    <input type="checkbox" name="questions[${questionIndex}][choices][0][is_correct]">
                </div>
            </div>
            <button type="button" class="add-choice">Add Choice</button>
        `;

        questionContainer.querySelector('.add-choice').addEventListener('click', function() {
            addChoice(this.closest('.question'), questionIndex);
        });

        document.getElementById('questions-container').appendChild(questionContainer);
        questionIndex++;
    }

    function addChoice(questionElement, questionIndex) {
        const choicesContainer = questionElement.querySelector('.choices');
        const choiceCount = choicesContainer.querySelectorAll('.choice').length;

        const choiceElement = document.createElement('div');
        choiceElement.classList.add('choice');
        choiceElement.setAttribute('data-choice-index', choiceCount);

        choiceElement.innerHTML = `
            <label>Choice:</label>
            <input type="text" name="questions[${questionIndex}][choices][${choiceCount}][text]" required>
            <label>Correct:</label>
            <input type="checkbox" name="questions[${questionIndex}][choices][${choiceCount}][is_correct]">
        `;

        choicesContainer.appendChild(choiceElement);
    }
});
