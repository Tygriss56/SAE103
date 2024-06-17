/**
 *   Un autre exemple de code C avec des directives de préprocesseur, des structures, des variables globales et des fonctions.
 */

#include <stdio.h>

#define MAX_VALEURS 5 /** Nombre maximal d'elements */
#define PI 3.14159 /** Nombre PI */

typedef struct {
    double centreX; /** Coordonnée x du centre du cercle */
    double centreY; /** Coordonnée y du centre du cercle */
    double rayon; /** Rayon du cercle */
} Cercle; /** Structure représentant un cercle défini par son centre et son rayon.*/


typedef struct {
    double x; /** Coordonnée x d'un point */
    double y; /** Coordonnée y d'un point */
    double z; /** Coordonnée z d'un point */
} Point3D; /** Structure représentant un point dans un espace tridimensionnel.*/

double valeurGlobale = 42.0; /** Variable globale de type double */

Cercle cercleGlobal; /** Variable globale de type Cercle */

/**
 * \brief Fonction pour afficher les coordonnées d'un point.
 * \param x Coordonnée x du point.
 * \param y Coordonnée y du point.
 */
void afficherPoint(double x, double y) {
    printf("Coordonnées du point : (%lf, %lf)\n", x, y);
}

/**
 * \brief Fonction pour afficher les détails d'un cercle.
 * \param c Le cercle à afficher.
 */
void afficherCercle(Cercle c) {
    printf("Cercle :\n");
    printf("Centre : (%lf, %lf)\n", c.centreX, c.centreY);
    printf("Rayon : %lf\n", c.rayon);
}

/**
 * \brief Fonction principale.
 * \return Code de sortie du programme.
 */
int main() {
    afficherPoint(2.0, 3.5); /**< Affichage des coordonnées d'un point */

    cercleGlobal = (Cercle){1.0, -1.0, 5.0}; /**< Initialisation de cercleGlobal avec des coordonnées et un rayon spécifiques */
    afficherCercle(cercleGlobal);

    Point3D point3D = {2.0, 3.5, 1.5}; /**< Initialisation d'une structure Point3D */
    printf("Coordonnées du point 3D : (%lf, %lf, %lf)\n", point3D.x, point3D.y, point3D.z);

    return 0;
}