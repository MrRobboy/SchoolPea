#include <stdio.h>
#include <stdlib.h>
#include <stdarg.h>
#include <assert.h>

void * nmalloc(size_t atomic, int dimensions, ...) {
	/* TODO : construire un tableau dynamique à 'dimensions' dimensions. */
	/* (Chaque élément fait atomic octets). */
	int i;
	va_list ap;
	va_start(ap, dimensions);
	for(i = 0; i < dimensions; ++i) {
		printf("Dimensions %d / %d = %d\n", i + 1, dimensions, va_arg(ap, int));
	}
	va_end(ap);
	return NULL;
}

void test_dim4() {
	int nx = 4, ny = 5, nz = 6, nw = 7;
	int **** voxel = nmalloc(sizeof(int), 4, nx, ny, nz, nw);
	int i, j, k, l;
	for(i = 0; i < nx; ++i) {
		for(j = 0; j < ny; ++j) {
			for(k = 0; k < nz; ++k) {
				for(l = 0; l < nw; ++l) {
					voxel[i][j][k][l] = i * ny * nz * nw + j * nz * nw + k * nw + l;
				}
			}
		}
	}
	for(i = 0; i < nx; ++i) {
		for(j = 0; j < ny; ++j) {
			for(k = 0; k < nz; ++k) {
				for(l = 0; l < nw; ++l) {
					assert(voxel[i][j][k][l] == i * ny * nz * nw + j * nz * nw + k * nw + l);
				}
			}
		}
	}
	free(voxel);
	voxel = NULL;
}

void test_voxel() {
	int nx = 5, ny = 7, nz = 10;
	int *** voxel = nmalloc(sizeof(int), 3, nx, ny, nz);
	int i, j, k;
	for(i = 0; i < nx; ++i) {
		for(j = 0; j < ny; ++j) {
			for(k = 0; k < nz; ++k) {
				voxel[i][j][k] = i * ny * nz + j * nz + k;
			}
		}
	}
	for(i = 0; i < nx; ++i) {
		for(j = 0; j < ny; ++j) {
			for(k = 0; k < nz; ++k) {
				assert(voxel[i][j][k] == i * ny * nz + j * nz + k);
			}
		}
	}
	free(voxel);
	voxel = NULL;
}

void test_pixel() {
	int nx = 10, ny = 20;
	int ** pixel = nmalloc(sizeof(int), 2, nx, ny);
	int i, j;
	for(i = 0; i < nx; ++i) {
		for(j = 0; j < ny; ++j) {
			pixel[i][j] = i * ny + j;
		}
	}
	for(i = 0; i < nx; ++i) {
		for(j = 0; j < ny; ++j) {
			assert(pixel[i][j] == i * ny + j);
		}
	}
	free(pixel);
	pixel = NULL;
}

void test_list() {
	int nx = 10;
	int * list = nmalloc(sizeof(int), 1, nx);
	int i;
	for(i = 0; i < nx; ++i) {
		list[i] = i;
	}
	for(i = 0; i < nx; ++i) {
		assert(list[i] == i);
	}
	free(list);
	list = NULL;
}

int main() {
	test_list();
	test_pixel();
	test_voxel();
	test_dim4();
	printf("Pas d'arrêt, vérifier avec valgrind.\n");
	exit(EXIT_SUCCESS);
}