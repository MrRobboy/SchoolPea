// Variables globales
var DIRECTION = {
    NULL: 0,
    HAUT: 1,
    BAS: 2,
    GAUCHE: 3,
    DROITE: 4
};
 
var rounds = [5, 5, 3, 3, 2];
var colors = ['#1abc9c', '#2ecc71', '#3498db', '#8c52ff', '#9b59b6'];
 
// L'objet Ball (Le cube qui rebondit)
var Ball = {
    nouveau: function (vitesseIncremente) {
        return {
            largeur: 18,
            hauteur: 18,
            x: (this.canvas.width / 2) - 9,
            y: (this.canvas.height / 2) - 9,
            deplacementX: DIRECTION.NULL,
            deplacementY: DIRECTION.NULL,
            vitesse: vitesseIncremente || 7 
        };
    }
};
 
// L'objet Ai (Les deux lignes qui montent et descendent)
var IA = {
    nouveau: function (cote) {
        return {
            largeur: 18,
            hauteur: 180,
            x: cote === 'gauche' ? 150 : this.canvas.width - 150,
            y: (this.canvas.height / 2) - 35,
            score: 0,
            deplacement: DIRECTION.NULL,
            vitesse: 8
        };
    }
};
 
var Jeu = {
    initialiser: function () {
        this.canvas = document.querySelector('canvas');
        this.context = this.canvas.getContext('2d');
 
        this.canvas.width = 1400;
        this.canvas.height = 1000;
 
        this.canvas.style.width = (this.canvas.width / 2) + 'px';
        this.canvas.style.height = (this.canvas.height / 2) + 'px';
 
        this.joueur = IA.nouveau.call(this, 'gauche');
        this.ia = IA.nouveau.call(this, 'droite');
        this.Ball = Ball.nouveau.call(this);
 
        this.ia.vitesse = 8;
        this.enCours = this.termine = false;
        this.tour = this.ia;
        this.timer = this.manche = 0;
        this.couleur = '#8c52ff';
 
        Pong.menu();
        Pong.ecouter();
    },
 
    menuFinDeJeu: function (texte) {
        // change la taille de police du canvas et la couleur
        Pong.context.font = '45px Courier New';
        Pong.context.fillStyle = this.couleur;
 
        // crée le rectangle derrière le texte 'Appuyez sur une touche pour commencer'
        Pong.context.fillRect(
            Pong.canvas.width / 2 - 350,
            Pong.canvas.height / 2 - 48,
            700,
            100
        );
 
        // change la couleur du canvas
        Pong.context.fillStyle = '#ffffff';
 
        // crée le texte du menu de fin de jeu ('Jeu Terminé' et 'Gagnant')
        Pong.context.fillText(texte,
            Pong.canvas.width / 2,
            Pong.canvas.height / 2 + 15
        );
 
        setTimeout(function () {
            Pong = Object.assign({}, Jeu);
            Pong.initialiser();
        }, 3000);
    },
 
    menu: function () {
        // crée tous les objets Pong dans leur état actuel
        Pong.crée();
 
        // change la taille de police du canvas et la couleur
        this.context.font = '50px Courier New';
        this.context.fillStyle = this.couleur;
 
        // crée le rectangle derrière le texte 'Appuyez sur une touche pour commencer'
        this.context.fillRect(
            this.canvas.width / 2 - 350,
            this.canvas.height / 2 - 48,
            700,
            100
        );
 
        // change la couleur du canvas
        this.context.fillStyle = '#ffffff';
 
        // crée le texte 'Appuyez sur une touche pour commencer'
        this.context.fillText('Appuyez sur une touche pour commencer',
            this.canvas.width / 2,
            this.canvas.height / 2 + 15
        );
    },
 
    // met  à jour tous les objets (deplace le joueur, ia, Ball, incrémenter le score, etc.)
    update: function () {
        if (!this.termine) {
            // Si  Ball heurte les limites - corriger les coordonnées x et y.
            if (this.Ball.x <= 0) Pong._reinitialiserTour.call(this, this.ia, this.joueur);
            if (this.Ball.x >= this.canvas.width - this.Ball.largeur) Pong._reinitialiserTour.call(this, this.joueur, this.ia);
            if (this.Ball.y <= 0) this.Ball.deplacementY = DIRECTION.BAS;
            if (this.Ball.y >= this.canvas.height - this.Ball.hauteur) this.Ball.deplacementY = DIRECTION.HAUT;
 
            // deplace le joueur si la valeur joueur.deplacement a été mise à jour par un événement clavier
            if (this.joueur.deplacement === DIRECTION.HAUT) this.joueur.y -= this.joueur.vitesse;
            else if (this.joueur.deplacement === DIRECTION.BAS) this.joueur.y += this.joueur.vitesse;
 
           
            if (Pong._delaiDuTourEstTermine.call(this) && this.tour) {
                this.Ball.deplacementX = this.tour === this.joueur ? DIRECTION.GAUCHE : DIRECTION.DROITE;
                this.Ball.deplacementY = [DIRECTION.HAUT, DIRECTION.BAS][Math.round(Math.random())];
                this.Ball.y = Math.floor(Math.random() * this.canvas.height - 200) + 200;
                this.tour = null;
            }
 
            // Si le joueur heurte les limites, met  à jour les coordonnées x et y.
            if (this.joueur.y <= 0) this.joueur.y = 0;
            else if (this.joueur.y >= (this.canvas.height - this.joueur.hauteur)) this.joueur.y = (this.canvas.height - this.joueur.hauteur);
 
            // deplace le Ball dans la direction prévue en fonction des valeurs de deplacementY et deplacementX
            if (this.Ball.deplacementY === DIRECTION.HAUT) this.Ball.y -= (this.Ball.vitesse );
            else if (this.Ball.deplacementY === DIRECTION.BAS) this.Ball.y += (this.Ball.vitesse );
            if (this.Ball.deplacementX === DIRECTION.GAUCHE) this.Ball.x -= this.Ball.vitesse;
            else if (this.Ball.deplacementX === DIRECTION.DROITE) this.Ball.x += this.Ball.vitesse;
 
            // gèere les mouvements HAUT et BAS de l'ia
            if (this.ia.y > this.Ball.y - (this.ia.hauteur / 2)) {
                if (this.Ball.deplacementX === DIRECTION.DROITE) this.ia.y -= this.ia.vitesse;
                else this.ia.y -= this.ia.vitesse / 4;
            }
            if (this.ia.y < this.Ball.y - (this.ia.hauteur / 2)) {
                if (this.Ball.deplacementX === DIRECTION.DROITE) this.ia.y += this.ia.vitesse;
                else this.ia.y += this.ia.vitesse / 4;
            }
 
            // gèere les collisions murales de l'ia
            if (this.ia.y >= this.canvas.height - this.ia.hauteur) this.ia.y = this.canvas.height - this.ia.hauteur;
            else if (this.ia.y <= 0) this.ia.y = 0;
 
            // gèere les collisions Joueur-Ball
            if (this.Ball.x - this.Ball.largeur <= this.joueur.x && this.Ball.x >= this.joueur.x - this.joueur.largeur) {
                if (this.Ball.y <= this.joueur.y + this.joueur.hauteur && this.Ball.y + this.Ball.hauteur >= this.joueur.y) {
                    this.Ball.x = (this.joueur.x + this.Ball.largeur);
                    this.Ball.deplacementX = DIRECTION.DROITE;
                }
            }
 
            // gèere les collisions ia-Ball
            if (this.Ball.x - this.Ball.largeur <= this.ia.x && this.Ball.x >= this.ia.x - this.ia.largeur) {
                if (this.Ball.y <= this.ia.y + this.ia.hauteur && this.Ball.y + this.Ball.hauteur >= this.ia.y) {
                    this.Ball.x = (this.ia.x - this.Ball.largeur);
                    this.Ball.deplacementX = DIRECTION.GAUCHE;
                }
            }
        }
 
        // gèere la transition de fin de manche 
        // verifi si le joueur a gagné la manche.
if (this.joueur.score === rounds[this.manche]) {
    // verifi s'il reste des rounds/niveaux et afficher l'écran de victoire s'il n'y en a plus.
    if (!rounds[this.manche + 1]) {
    this.termine = true;
    setTimeout(function () { Pong.menuFinDeJeu('Gagnant!'); }, 1000);
    } else {
    // S'il reste une autre manche, réinitialiser toutes les valeurs et incrémenter le numéro de la manche.
    this.couleur = this._genererCouleurManche();
    this.joueur.score = this.ia.score = 0;
    this.joueur.vitesse += 0.5;
    this.ia.vitesse += 1;
    this.Ball.vitesse += 1;
    this.manche += 1;
    }
    }
    // verifi si l'ia a gagné la manche.
    else if (this.ia.score === rounds[this.manche]) {
    this.termine = true;
    setTimeout(function () { Pong.menuFinDeJeu('Jeu Terminé!'); }, 1000);
    }
    },// crée les objets sur l'élément canvas
    crée: function () {
        // efface le canvas
        this.context.clearRect(
            0,
            0,
            this.canvas.width,
            this.canvas.height
        );
    
        // definit la couleur de remplissage sur la couleur de fond
        this.context.fillStyle = this.couleur;
    
        // crée l'arrière-plan
        this.context.fillRect(
            0,
            0,
            this.canvas.width,
            this.canvas.height
        );
    
        // definit la couleur de remplissage sur blanc (pour les raquettes et le Ball)
        this.context.fillStyle = '#ffffff';
    
        // crée le Joueur
        this.context.fillRect(
            this.joueur.x,
            this.joueur.y,
            this.joueur.largeur,
            this.joueur.hauteur
        );
    
        // crée l'IA
        this.context.fillRect(
            this.ia.x,
            this.ia.y,
            this.ia.largeur,
            this.ia.hauteur 
        );
    
        // crée le Ball
        if (Pong._delaiDuTourEstTermine.call(this)) {
            this.context.fillRect(
                this.Ball.x,
                this.Ball.y,
                this.Ball.largeur,
                this.Ball.hauteur
            );
        }
    
        // crée le filet (ligne au milieu)
        this.context.beginPath();
        this.context.setLineDash([7, 15]);
        this.context.moveTo((this.canvas.width / 2), this.canvas.height - 140);
        this.context.lineTo((this.canvas.width / 2), 140);
        this.context.lineWidth = 10;
        this.context.strokeStyle = '#ffffff';
        this.context.stroke();
    
        // definit la police par défaut du canvas et l'aligner au centre
        this.context.font = '100px Courier New';
        this.context.textAlign = 'center';
    
        // crée le score du joueur (à gauche)
        this.context.fillText(
            this.joueur.score.toString(),
            (this.canvas.width / 2) - 300,
            200
        );
    
        // crée le score de l'ia (à droite)
        this.context.fillText(
            this.ia.score.toString(),
            (this.canvas.width / 2) + 300,
            200
        );
    
        // change la taille de la police pour le texte central du score
        this.context.font = '30px Courier New';
    
        // crée le score gagnant (centre)
        this.context.fillText(
            'Manche ' + (Pong.manche + 1),
            (this.canvas.width / 2),
            35
        );
    
        // change la taille de la police pour la valeur du numéro de manche
        this.context.font = '40px Courier';
    
        // crée le numéro actuel de la manche
        this.context.fillText(
            rounds[Pong.manche] ? rounds[Pong.manche] : rounds[Pong.manche - 1],
            (this.canvas.width / 2),
            100
        );
    },
    
    boucle: function () {
        Pong.update();
        Pong.crée();
    
        // Si le jeu n'est pas terminé, crée la prochaine frame.
        if (!Pong.termine) requestAnimationFrame(Pong.boucle);
    },
    
    ecouter: function () {
        document.addEventListener('keydown', function (touche) {
            // gèere la fonction 'Appuyez sur une touche pour commencer' et démarrer le jeu.
            if (Pong.enCours === false) {
                Pong.enCours = true;
                window.requestAnimationFrame(Pong.boucle);
            }
    
            // gèere les événements de la flèche haut et de la touche w
            if (touche.keyCode === 38 || touche.keyCode === 87) Pong.joueur.deplacement = DIRECTION.HAUT;
    
            // gèere les événements de la flèche bas et de la touche s
            if (touche.keyCode === 40 || touche.keyCode === 83) Pong.joueur.deplacement = DIRECTION.BAS;
        });
    
        // Arrêter le déplacement du joueur lorsqu'aucune touche n'est pressée.
        document.addEventListener('keyup', function (touche) { Pong.joueur.deplacement = DIRECTION.NULL; });
    },
    
    // Réinitialiser la position du Ball, les tours du joueur et definit un délai avant que le prochain tour commence.
    _reinitialiserTour: function(vainqueur, perdant) {
        this.Ball = Ball.nouveau.call(this, this.Ball.vitesse);
        this.tour = perdant;
        this.timer = (new Date()).getTime();
    
        vainqueur.score++;
    },
    
  
    _delaiDuTourEstTermine: function() {
        return ((new Date()).getTime() - this.timer >= 1000);
    },
    
    // Sélectionner une couleur aléatoire pour l'arrière-plan de chaque niveau/manche.
    _genererCouleurManche: function () {
        var nouvelleCouleur = colors[Math.floor(Math.random() * colors.length)];
        if (nouvelleCouleur === this.couleur) return Pong._genererCouleurManche();
        return nouvelleCouleur;
    }
};

var Pong = Object.assign({}, Jeu);
Pong.initialiser();
    
