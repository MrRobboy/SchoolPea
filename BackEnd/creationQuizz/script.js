// script.js

// Utilisation de Vue.js pour la liaison des données et la mise à jour en temps réel
var app = new Vue({
    el: '#quizPreview',
    data: {
        quiz: {
            nom: '',
            path_img_pres: '',
        },
        questions: [],
    },
    mounted() {
        // Écoute des changements dans le formulaire
        var form = document.getElementById('quizForm');
        form.addEventListener('input', this.updatePreview);
    },
    methods: {
        updatePreview() {
            // Mettre à jour les données de prévisualisation à partir du formulaire
            this.quiz.nom = document.querySelector('input[name="nom_quizz"]').value;
            this.quiz.path_img_pres = document.querySelector('input[name="path_img_pres"]').value;

            // Mettre à jour les questions
            var totalQuestions = parseInt(document.querySelector('input[name="total_questions"]').value);
            this.questions = [];
            for (var i = 1; i <= totalQuestions; i++) {
                var question = {
                    question_text: document.querySelector('input[name="question_' + i + '"]').value,
                    choices: document.querySelector('input[name="choices_' + i + '"]').value.split(','),
                };
                this.questions.push(question);
            }
        }
    }
});
