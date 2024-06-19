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
