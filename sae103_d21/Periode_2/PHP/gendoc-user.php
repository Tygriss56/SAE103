<?php

require 'Parsedown.php';

// Récupérer le chemin d'accès du fichier Markdown depuis la ligne de commande
$markdownFilePath = isset($argv[1]) ? $argv[1] : 'votre_fichier.md';

// Vérifier si le fichier existe
if (!file_exists($markdownFilePath)) {
    echo "Le fichier Markdown n'existe pas.\n";
    exit(1);
}

// Lire le contenu du fichier Markdown
$markdownCode = file_get_contents($markdownFilePath);

// Utiliser Parsedown pour convertir le Markdown en HTML
$parsedown = new Parsedown();

// Convertir le Markdown en HTML
$htmlCode = $parsedown->text($markdownCode);

// Remplacer les marqueurs dans le modèle HTML par le contenu généré
$htmlTemplate = <<<HTML
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <header>
            <!-- ... -->
            <article>
                <h3>Client : Valeur_Client</h3>
                <h3>Produit : Valeur_Produit</h3>
                <h3>Version : Valeur_Version</h3>
                <h3> Date actuelle</h3>
            </article>
            <article>
                <h2>Actions Possibles</h2>
                <div class="bloc">
                    $htmlCode
                </div>
            </article>
        </header>
        <main>
            <!-- ... (pour chaque fichier passé en argument) -->
            <section id="s1">
                <h1>Nom_Fichier1</h1>
                <p>
                    Présentation : Description du fichier...
                </p>
                <article id="1_actions">
                    <h2>Actions Possibles</h2>
                    <div class="bloc">
                        $htmlCode
                    </div>
                </article>
            </section>
            <!-- ... (pour chaque fichier passé en argument) -->
        </main>
    </body>
</html>
HTML;

$htmlTemplate = str_replace(
    ['Valeur_Client', 'Valeur_Produit', 'Valeur_Version', 'Nom_Fichier1'],
    ['Client123', 'ProduitXYZ', 'Version123', $htmlCode],
    $htmlTemplate
);

// Écrire le HTML généré dans un fichier HTML
file_put_contents('documentation_utilisateur.html', $htmlTemplate);

// Afficher un message de confirmation
echo 'Le fichier HTML complet a été généré avec succès et enregistré sous le nom "documentation_utilisateur.html".';
?>
