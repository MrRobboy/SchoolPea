/**
 * ESGI : Cours de Langage C de Kevin TRANCHO.
 * Correction de l'exercice 81.
 */

#include <stdio.h>
#include <stdlib.h>

typedef struct Stats Stats;
struct Stats {
  int vie;
  int attaque;
  int defense;
  int vitesse;
};

int Stats_creer(Stats * perso, int vie, int attaque, int defense, int vitesse) {
  if(vie < 0 || attaque < 0 || defense < 0 || vitesse < 0) {
    fprintf(stderr, "Les statistiques ne peuvent pas être négatives.\n");
    return 0;
  }
  perso->vie = vie;
  perso->attaque = attaque;
  perso->defense = defense;
  perso->vitesse = vitesse;
  return 1;
}

void Stats_afficher(const Stats * perso) {
  printf("Perso : {\n");
  printf("\tvie : %d\n", perso->vie);
  printf("\tattaque : %d\n", perso->attaque);
  printf("\tdefense : %d\n", perso->defense);
  printf("\tvitesse : %d\n", perso->vitesse);
  printf("}\n");
}

int main() {
  Stats perso;
  if(! Stats_creer(&perso, 100, 50, 70, 30)) {
    fprintf(stderr, "Erreur création personnage : arrêt.\n");
    exit(EXIT_FAILURE);
  }
  Stats_afficher(&perso);
  exit(EXIT_SUCCESS);
}