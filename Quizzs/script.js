document.addEventListener('DOMContentLoaded', () => {
    let questionIndex = 0;

    // Add initial question and choice elements
    addQuestion();

    document.getElementById('add-question').addEventListener('click', () => {
        addQuestion();
    });

    function addQuestion() {
        questionIndex++;
        const questionContainer = document.createElement('div');
        questionContainer.classList.add('question');
        questionContainer.setAttribute('data-question-index', questionIndex);

        questionContainer.innerHTML = `
            <label>Question:</label>
            <textarea name="questions[${questionIndex}][text]" required></textarea>
            <button type="button" class="delete-question">Delete Question</button>
            <div class="choices">
                <div class="choice" data-choice-index="0">
                    <label>Choice:</label>
                    <input type="text" name="questions[${questionIndex}][choices][0][text]" required>
                    <label>Correct:</label>
                    <input type="checkbox" name="questions[${questionIndex}][choices][0][is_correct]">
                    <button type="button" class="delete-choice">Delete Choice</button>
                </div>
            </div>
            <button type="button" class="add-choice">Add Choice</button>
        `;

        // Attach events for deleting questions and choices
        questionContainer.querySelector('.delete-question').addEventListener('click', function() {
            this.closest('.question').remove();
        });

        questionContainer.querySelector('.add-choice').addEventListener('click', function() {
            addChoice(this.closest('.question'));
        });

        document.getElementById('questions-container').appendChild(questionContainer);
    }

    function addChoice(questionElement) {
        const choicesContainer = questionElement.querySelector('.choices');
        const choiceCount = choicesContainer.querySelectorAll('.choice').length;

        const choiceElement = document.createElement('div');
        choiceElement.classList.add('choice');
        choiceElement.setAttribute('data-choice-index', choiceCount);

        choiceElement.innerHTML = `
            <label>Choice:</label>
            <input type="text" name="questions[${questionElement.dataset.questionIndex}][choices][${choiceCount}][text]" required>
            <label>Correct:</label>
            <input type="checkbox" name="questions[${questionElement.dataset.questionIndex}][choices][${choiceCount}][is_correct]">
            <button type="button" class="delete-choice">Delete Choice</button>
        `;

        choiceElement.querySelector('.delete-choice').addEventListener('click', function() {
            this.closest('.choice').remove();
        });

        choicesContainer.appendChild(choiceElement);
    }

    document.addEventListener('click', (event) => {
        if (event.target && event.target.classList.contains('delete-question')) {
            event.target.closest('.question').remove();
        }

        if (event.target && event.target.classList.contains('delete-choice')) {
            event.target.closest('.choice').remove();
        }
    });
});
