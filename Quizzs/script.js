document.addEventListener('DOMContentLoaded', function() {
    let questionIndex = 1;
    const addQuestionButton = document.getElementById('add-question');
    const questionsContainer = document.getElementById('questions-container');

    addQuestionButton.addEventListener('click', function() {
        const questionDiv = document.createElement('div');
        questionDiv.classList.add('question');
        questionDiv.innerHTML = `
            <label>Question:</label>
            <textarea name="questions[${questionIndex}][text]" required></textarea>
            <div class="choices">
                <div class="choice">
                    <label>Choice:</label>
                    <input type="text" name="questions[${questionIndex}][choices][0][text]" required>
                    <label>Correct:</label>
                    <input type="checkbox" name="questions[${questionIndex}][choices][0][is_correct]">
                </div>
            </div>
            <button type="button" class="add-choice">Add Choice</button>
        `;
        questionsContainer.appendChild(questionDiv);
        questionIndex++;
    });

    questionsContainer.addEventListener('click', function(event) {
        if (event.target.classList.contains('add-choice')) {
            const choicesDiv = event.target.previousElementSibling;
            const choiceCount = choicesDiv.children.length;
            const questionIndex = choicesDiv.parentElement.querySelector('textarea').name.match(/\d+/)[0];
            const choiceDiv = document.createElement('div');
            choiceDiv.classList.add('choice');
            choiceDiv.innerHTML = `
                <label>Choice:</label>
                <input type="text" name="questions[${questionIndex}][choices][${choiceCount}][text]" required>
                <label>Correct:</label>
                <input type="checkbox" name="questions[${questionIndex}][choices][${choiceCount}][is_correct]">
            `;
            choicesDiv.appendChild(choiceDiv);
        }
    });
});
