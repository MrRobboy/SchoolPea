typedef struct LinkedList * LinkedList;
struct LinkedList {
  int value;
  LinkedList next;
};

/* Renvoie une liste vide */
LinkedList LL_empty();

/* Libère la liste */
void LL_free(LinkedList * liste);

/* Ajoute un élément en fin */
int LL_add_tail(LinkedList * liste, int value);

/* Ajoute un élément en tête */
int LL_add_head(LinkedList * liste, int value);

/* Ajoute un élément à une position donnée */
int LL_insert(LinkedList * liste, int id, int value);

/* Supprime l'élément en fin */
int LL_pop_tail(LinkedList * liste, int * value);

/* Supprime l'élément en tête */
int LL_pop_head(LinkedList * liste, int * value);

/* Supprime l'élément à une position donnée */
int LL_delete(LinkedList * liste, int id, int * value);

/* Affiche la liste */
void LL_print(FILE * flow, const LinkedList * liste);

typedef struct ArrayList ArrayList;
struct ArrayList {
  int * values;
  int size;
  int capacite;
};

/* Renvoie une liste vide */
ArrayList AL_empty();

/* Libère la liste */
void AL_free(ArrayList * liste);

/* Ajoute un élément en fin */
int AL_add_tail(ArrayList * liste, int value);

/* Ajoute un élément en tête */
int AL_add_head(ArrayList * liste, int value);

/* Ajoute un élément à une position donnée */
int AL_insert(ArrayList * liste, int id, int value);

/* Supprime l'élément en fin */
int AL_pop_tail(ArrayList * liste, int * value);

/* Supprime l'élément en tête */
int AL_pop_head(ArrayList * liste, int * value);

/* Supprime l'élément à une position donnée */
int AL_delete(ArrayList * liste, int id, int * value);

/* Affiche la liste */
void AL_print(FILE * flow, const ArrayList * liste);