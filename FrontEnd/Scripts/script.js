const Conteneur = document.getElementById("Conteneur");
const InscriptionBtn = document.getElementById("Inscription");
const ConnexionBtn = document.getElementById("Connexion");

InscriptionBtn.addEventListener("click", () => {
    document.title = "Inscription | SchoolPéa";
    Conteneur.classList.add("Inscription");
    Conteneur.classList.remove("Connexion");
});

ConnexionBtn.addEventListener("click", () => {
    document.title = "Connexion | SchoolPéa";
    Conteneur.classList.remove("Inscription");
    Conteneur.classList.add("Connexion");
});


// Fonction pour gérer le clic sur l'image SchoolPea.png
function easterEgg() {
    // Vérifier si le compteur existe dans le sessionStorage
    if (sessionStorage.getItem('clickCount') === null) {
        sessionStorage.setItem('clickCount', 0);
    }

    // Incrémente le compteur de clics
    var clickCount = parseInt(sessionStorage.getItem('clickCount'));
    clickCount++;
    sessionStorage.setItem('clickCount', clickCount);

    // Vérifier si le compteur atteint 10
    if (clickCount === 10) {
        // Déclencher l'action surprise
        createFirework();
        // Réinitialiser le compteur après avoir déclenché l'action
        sessionStorage.setItem('clickCount', 0);
    }
}

// Fonction pour créer les feux d'artifice
function createFirework() {
    const firework = document.createElement('div');
    firework.classList.add('firework');
    const colors = ['#f00', '#0f0', '#00f', '#ff0', '#f0f', '#0ff'];
    const color = colors[Math.floor(Math.random() * colors.length)];
    firework.style.backgroundColor = color;

    const xPos = Math.random() * 100;
    const yPos = Math.random() * 100;
    firework.style.left = xPos + '%';
    firework.style.top = yPos + '%';

    document.getElementById('fireworks').appendChild(firework);

    // Supprime le feu d'artifice après 2 secondes
    setTimeout(() => {
        firework.remove();
    }, 2000);
}

// Ajouter un écouteur d'événements sur le clic de l'image
document.getElementById('logo_header').addEventListener('click', easterEgg);


///API FETCH 

function searchCourse() {
    const inputElement = document.getElementById('coursenquizz-search');

    inputElement.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            chercheCoursEtQuizz();
        }
    });
    
    function chercheCoursEtQuizz() {
        const searchTerm = document.getElementById('coursenquizz-search').value;
        // Effectuez une requête SQL pour vérifier si le cours ou le quiz existe dans vos tables COURS et QUIZZ.
        SELECT *FROM COURS WHERE nom LIKE '%searchTerm%'
        UNION ALL 
        SELECT *FROM TEST WHERE nom LIKE '%searchTerm%';

        // Si le cours ou le quiz est trouvé, affichez les détails.
        // Sinon, affichez un message indiquant que le cours ou le quiz n'a pas été trouvé.
    }

}
    


