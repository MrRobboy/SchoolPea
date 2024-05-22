const Conteneur = document.getElementById("Conteneur");
const InscriptionBtn = document.getElementById("Inscription");
const ConnexionBtn = document.getElementById("Connexion");

InscriptionBtn.addEventListener("click", () => {
    Conteneur.classList.add("Inscription");
    Conteneur.classList.remove("Connexion");
    document.title = "Inscription | SchoolPéa";
});

ConnexionBtn.addEventListener("click", () => {
    Conteneur.classList.remove("Inscription");
    Conteneur.classList.add("Connexion");
    document.title = "Connexion | SchoolPéa";
});
