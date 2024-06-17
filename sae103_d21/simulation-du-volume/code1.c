/**
 *   Exemple de code en C avec des directives de préprocesseur,
 *   des structures, des variables globales et des fonctions.
 */

#include <stdio.h>

#define MAX_ELEMENTS 10 /** Nombre maximal d'elements */
#define UN 1 /** Nombre un */

typedef struct {
    double x; /** Coordonnée x d'un point */
    double y; /** Coordonnée y d'un point */
} Point; /** Structure représentant un point */

typedef struct {
    Point coinSuperieurGauche; /** Coordonnées du coin supérieur gauche du rectangle */
    Point coinInferieurDroit;  /** Coordonnées du coin inférieur droit du rectangle */
} Rectangle; /** structure d'un rectangle */

double variableGlobale = 3.14; /** PI */

Rectangle rectangleGlobal; /** un rectangle en variable global */

/**
 * \brief Procédure pour afficher les coordonnées d'un point.
 * \details Procedure qui va afficher les coordonnées en utilisant
 * les composants du paramètre de type Point.
 * \param p Le point à afficher.
 */
void afficherPoint(Point p) {
    printf("Coordonnées du point : (%lf, %lf)\n", p.x, p.y);
}

/**
 * \brief Procédure pour afficher les détails d'un rectangle.
 * \details La procédure va utiliser les composants coinSuperieurGauche et
 * coinSuperieurGauche de type Point dont on va utiliser les composants x et y.
 * \param rect Le rectangle à afficher.
 */
void afficherRectangle(Rectangle rect) {
    printf("Rectangle:\n");
    printf("Coin Supérieur Gauche : (%lf, %lf)\n", rect.coinSuperieurGauche.x, rect.coinSuperieurGauche.y);
    printf("Coin Inférieur Droit : (%lf, %lf)\n", rect.coinInferieurDroit.x, rect.coinInferieurDroit.y);
}

/**
 * \brief Fonction principale.
 * \details Programme principal qui :
 * - on initialise un point et on l'affiche
 * - on initialise un rectangle et on l'affiche
 * \return Code de sortie du programme.
 */
int main() {
    Point monPoint = {1.0, 2.5}; /** Initialisation d'une structure Point */
    afficherPoint(monPoint);

    rectangleGlobal = (Rectangle){{0.0, 3.0}, {4.0, 1.0}}; /** Initialisation de rectangleGlobal avec des coordonnées spécifiques */
    afficherRectangle(rectangleGlobal);

    return 0;
}
