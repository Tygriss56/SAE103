/**
 * \file code3.c
 * \brief Un autre exemple de code C avec des directives de préprocesseur, des structures, des variables globales et des fonctions.
 */

#include <stdio.h>

#define TAILLE_MAX 8
#define DRAPEAU 0

/**
 * \struct Etudiant
 * \brief Structure représentant un étudiant avec un nom et un âge.
 */
struct Etudiant {
    char nom[50]; /**< Nom de l'étudiant */
    int age;      /**< Âge de l'étudiant */
};

/**
 * \struct Adresse
 * \brief Structure représentant une adresse avec le numéro de rue et le nom de la rue.
 */
struct Adresse {
    int numeroRue;      /**< Numéro de rue */
    char nomRue[50];    /**< Nom de la rue */
};

int entierGlobal = 123; /**< Variable globale de type int */

struct Etudiant etudiantGlobal; /**< Variable globale de type Etudiant */

/**
 * \brief Fonction pour afficher les détails d'un étudiant.
 * \param e L'étudiant à afficher.
 */
void afficherDetailsEtudiant(struct Etudiant e) {
    printf("Détails de l'étudiant :\n");
    printf("Nom : %s\n", e.nom);
    printf("Âge : %d\n", e.age);
}

/**
 * \brief Fonction pour afficher les détails d'une adresse.
 * \param a L'adresse à afficher.
 */
void afficherDetailsAdresse(struct Adresse a) {
    printf("Détails de l'adresse :\n");
    printf("Numéro de rue : %d\n", a.numeroRue);
    printf("Nom de la rue : %s\n", a.nomRue);
}

/**
 * \brief Fonction principale.
 * \return Code de sortie du programme.
 */
int main() {
    etudiantGlobal = (struct Etudiant){"John Doe", 20}; /**< Initialisation d'etudiantGlobal avec un nom et un âge spécifiques */
    afficherDetailsEtudiant(etudiantGlobal);

    struct Adresse adresse = {123, "Rue de la Paix"}; /**< Initialisation d'une structure Adresse */
    afficherDetailsAdresse(adresse);

    return 0;
}
