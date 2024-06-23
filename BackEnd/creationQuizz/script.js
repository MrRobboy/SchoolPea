// script.js

function addQuestion() {
    var totalQuestions = document.getElementById('total_questions').value;
    var container = document.getElementById('questionsContainer');

    for (var i = 1; i <= totalQuestions; i++) {
        var questionDiv = document.createElement('div');
        questionDiv.classList.add('question');

        var questionHeader = document.createElement('h3');
        questionHeader.textContent = 'Question ' + i;
        questionDiv.appendChild(questionHeader);

        var questionText = document.createElement('p');
        questionText.innerHTML = '<label>Texte de la question</label><input type="text" name="question_' + i + '" required>';
        questionDiv.appendChild(questionText);

        var choices = document.createElement('p');
        choices.innerHTML = '<label>Choix de Réponses (séparés par des virgules)</label><input type="text" name="choices_' + i + '" required>';
        questionDiv.appendChild(choices);

        var correctChoices = document.createElement('p');
        correctChoices.innerHTML = '<label>Réponses correctes (numéros des choix corrects séparés par des virgules)</label><input type="text" name="correct_choices_' + i + '" required>';
        questionDiv.appendChild(correctChoices);

        container.appendChild(questionDiv);
    }
}

// Prévisualisation du quiz en direct avec Vue.js ou JavaScript peut être ajoutée ici
