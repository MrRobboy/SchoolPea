/**
 * ESGI : Cours de Langage C de Kevin TRANCHO.
 * Correction de l'exercice 52.
 */

#include <stdio.h>
#include <stdlib.h>

int main() {
  int variable = 42;
  unsigned long pointeur = (long)&variable;
  *((int *)pointeur) = 1337;
  printf("%d = 1337 ?\n", variable);
  exit(EXIT_SUCCESS);
}