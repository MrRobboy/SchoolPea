#define SDL_MAIN_HANDLED
#include <stdio.h>
#include <stdlib.h>
#include <math.h>
#include <time.h>
#include <SDL/SDL.h>
#include <SDL/SDL_gfxPrimitives.h>

/* Paramètres de la fenêtre : */
const int largeur = 800;
const int hauteur = 800;
const char * titre = "ESGI fusion";

#define grid_width 10
#define grid_height 9
/* Should stay between 2 and 9 (advised real max : 13) */
int items = 9;

int score = 0;

int mouse_x, mouse_y;
int grab = 0;
int add_score = 0;

SDL_Surface * ecran = NULL;

int grid[grid_width][grid_height];

int grab_id = -1;
int visu = 0;

void draw_shape(int id, double x, double y, double scale, double light);

void init() {
	/* TODO : initialise la grille. */
}

void start_grab() {
	/* TODO : pression du clic de souris. */
}

void end_grab() {
	/* TODO : libération du clic de souris. */
}

void affichage() {
	/* Remplissage de l'écran par un gris foncé uniforme : */
	SDL_FillRect(ecran, NULL, SDL_MapRGB(ecran->format, 51, 51, 102));
	draw_shape(1, largeur / 4, hauteur / 4, largeur / 4, 0.5 * (mouse_x < largeur / 2 && mouse_y < hauteur / 2));
	draw_shape(2, 3 * largeur / 4, hauteur / 4, largeur / 4, 0.5 * (mouse_x > largeur / 2 && mouse_y < hauteur / 2));
	draw_shape(3, largeur / 4, 3 * hauteur / 4, largeur / 4, 0.5 * (mouse_x < largeur / 2 && mouse_y > hauteur / 2));
	draw_shape(4, 3 * largeur / 4, 3 * hauteur / 4, largeur / 4, 0.5 * (mouse_x > largeur / 2 && mouse_y > hauteur / 2));
}

/* Dessin des gemmes : */

void draw_regular_poly(double x, double y, double scale, int n, int r, int g, int b, int a) {
	Sint16 xs[n];
	Sint16 ys[n];
	int i;
	for(i = 0; i < n; ++i) {
		xs[i] = scale * cos(i * 2 * M_PI / n - M_PI / 2.) + x;
		ys[i] = scale * sin(i * 2 * M_PI / n - M_PI / 2.) + y;
	}
	filledPolygonRGBA(ecran, xs, ys, n, r, g, b, a);
}

void draw_regular_poly_corner(double x, double y, double inner_scale, double outter_scale, int i, int n, int r, int g, int b, int a) {
	Sint16 xs[4] = {
		inner_scale * cos(i * 2 * M_PI / n - M_PI / 2.) + x,
		outter_scale * cos(i * 2 * M_PI / n - M_PI / 2.) + x,
		outter_scale * cos((i + 1) * 2 * M_PI / n - M_PI / 2.) + x,
		inner_scale * cos((i + 1) * 2 * M_PI / n - M_PI / 2.) + x
	};
	Sint16 ys[4] = {
		inner_scale * sin(i * 2 * M_PI / n - M_PI / 2.) + y,
		outter_scale * sin(i * 2 * M_PI / n - M_PI / 2.) + y,
		outter_scale * sin((i + 1) * 2 * M_PI / n - M_PI / 2.) + y,
		inner_scale * sin((i + 1) * 2 * M_PI / n - M_PI / 2.) + y
	};
	filledPolygonRGBA(ecran, xs, ys, 4, r, g, b, a);
}

void draw_regular_poly_corners(double x, double y, double inner_scale, double outter_scale, double shadow, double light, int n, int r, int g, int b, int a) {
	int i;
	double sf;
	for(i = 0; i < n; ++i) {
		sf = 255 * (light + shadow * sin(i * 2 * M_PI / n + M_PI / 2.));
		draw_regular_poly_corner(x, y, inner_scale, outter_scale, i, n, fmin(fmax(sf + r, 0), 255), fmin(fmax(sf + g, 0), 255), fmin(fmax(sf + b, 0), 255), a);
	}
}

void draw_polygon(double x, double y, double scale, int n, int r, int g, int b, int a) {
	int i;
	double top = 0, bot = 0;
	double v;
	for(i = 0; i < n; ++i) {
		v = scale * sin(i * 2 * M_PI / n - M_PI / 2.);
		if(v > top) top = v;
		if(v < bot) bot = v;
	}
	y -= 0.5 * (top + bot);
	draw_regular_poly(x, y, scale, n, r, g, b, a);
	draw_regular_poly(x, y, 0.25 * scale, n, 0.75 * r, 0.75 * g, 0.75 * b, a);
	draw_regular_poly_corners(x, y, scale, 0.75 * scale, 0.5, 0.1, n, r, g, b, a);
	draw_regular_poly_corners(x, y, 0.5 * scale, 0.25 * scale, -0.5, 0.1, n, r, g, b, a);
}

void draw_shape(int id, double x, double y, double scale, double light) {
	if(id < 0) return;
	int r, g, b, a = 255;
	switch(id % 9) {
		case 1 : r = 0; g = 255; b = 0; break;
		case 2 : r = 255; g = 0; b = 0; break;
		case 3 : r = 0; g = 0; b = 255; break;
		case 4 : r = 255; g = 255; b = 0; break;
		case 5 : r = 255; g = 0; b = 255; break;
		case 6 : r = 0; g = 255; b = 255; break;
		case 7 : r = 0; g = 0; b = 0; break;
		case 8 : r = 255; g = 127; b = 0; break;
		default : r = 255; g = 255; b = 255; break;
	}
	r = fmin(fmax(63 + 0.5 * r + 255 * light, 0), 255);
	g = fmin(fmax(63 + 0.5 * g + 255 * light, 0), 255);
	b = fmin(fmax(63 + 0.5 * b + 255 * light, 0), 255);
	draw_polygon(x, y, scale, id + 2, r, g, b, a);
}

int main(int argc, char *argv[]) {
	srand(time(NULL));
	/* Création d'une fenêtre SDL : */
	if(SDL_Init(SDL_INIT_EVERYTHING) != 0) {
		fprintf(stderr, "Error in SDL_Init : %s\n", SDL_GetError());
		exit(EXIT_FAILURE);
	}
	if((ecran = SDL_SetVideoMode(largeur, hauteur, 32, SDL_HWSURFACE | SDL_DOUBLEBUF)) == NULL) {
		fprintf(stderr, "Error in SDL_SetVideoMode : %s\n", SDL_GetError());
		SDL_Quit();
		exit(EXIT_FAILURE);
	}
	SDL_WM_SetCaption(titre, NULL);
	init();
	
	int active = 1;
	SDL_Event event;
	int refresh = 1;
	
	while(active) {
		
		if(refresh) {
			affichage();
			SDL_Flip(ecran);
			refresh = 0;
		}
		
		while(SDL_PollEvent(&event)) {
			
			switch(event.type) {
				/* Utilisateur clique sur la croix de la fenêtre : */
				case SDL_QUIT : {
					active = 0;
				} break;
				
				/* Utilisateur enfonce une touche du clavier : */
				case SDL_KEYDOWN : {
					switch(event.key.keysym.sym) {
						/* Touche Echap : */
						case SDLK_ESCAPE : {
							active = 0;
						} break;
					}
				} break;
				
				case SDL_MOUSEBUTTONDOWN : {
					switch(event.button.button) {
						case SDL_BUTTON_LEFT : {
							grab = 1;
							start_grab();
							refresh = 1;
						} break;
					}
				} break;
				
				case SDL_MOUSEBUTTONUP : {
					switch(event.button.button) {
						case SDL_BUTTON_LEFT : {
							grab = 0;
							end_grab();
							refresh = 1;
						} break;
					}
				} break;
				
				case SDL_MOUSEMOTION : {
					mouse_x = event.motion.x;
					mouse_y = event.motion.y;
					refresh = 1;
				} break;
			}
		}
		
		SDL_Delay(1000 / 60);
	}
	
	SDL_FreeSurface(ecran);
	SDL_Quit();
	exit(EXIT_SUCCESS);
}