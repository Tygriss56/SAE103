#!/bin/bash

# Création du volume sae103
docker volume create sae103

# Lancement du conteneur clock en mode détaché avec le volume sae103 
docker run -d --name sae103-forever -v sae103:/work clock

version_major=$(cat config | egrep VERSION | cut -d'=' -f2 | cut -d"." -f1)
version_minor=$(cat config | egrep VERSION | cut -d'=' -f2 | cut -d"." -f2)
version_build=$(cat config | egrep VERSION | cut -d'=' -f2 | cut -d"." -f3)

if [ "$1" = "--major" ]; then
    version_major=$((version_major + 1))
    version_minor=0
    version_build=0
elif [ "$1" = "--minor" ]; then
    version_minor=$((version_minor + 1))
    version_build=0
elif [ "$1" = "--build" ]; then
    version_build=$((version_build + 1))
fi

client=$(head -n1 config)
produit=$(head -n2 config | tail -n1)

echo $client > config
echo $produit >> config
echo "VERSION=${version_major}.${version_minor}.${version_build}" >> config


new_config=$(cat config | head -n2)

echo $new_config > config
echo VERSION=${version_major}.${version_minor}.${version_build} >> config

version=${version_major}.${version_minor}.${version_build}

# Copie des fichiers .c dans le volume sae103 en utilisant sae103-forever comme conteneur cible
for fic in $(ls ../codes-sources)
do
    echo ../codes-sources/$fic
    docker cp ../codes-sources/$fic sae103-forever:/work
done

for fic in $(ls ../PHP)
do
    echo ../PHP/$fic
    docker cp ../PHP$fic sae103-forever:/work
done

for fic in $(ls ../to-be-modified)
do
    echo ../to-be-modified/$fic
    docker cp ../to-be-modified/$fic sae103-forever:/work
done

# Lancement du conteneur PHP
docker run -d -v sae103:/work sae103-php

# Lancement de tous les autres traitements en mode non interactif
docker exec -it sae103-php gendoc-tech.php *.c > doc-tech-$version.html
docker exec -it sae103-php gendoc-user.php *.c > doc-user-$version.html

# Conversion du fichier HTML en PDF
docker run -v sae103:/work html2pdf
docker ,,, nom_de_l_image "html2pdf fichier.html fichier.pdf"


# Récupération de l’archive finale depuis le volume sae103 en utilisant sae103-forever comme conteneur source

docker cp sae103-forever:/archive_finale.tar.gz

# Arrêt du conteneur sae103-forever

docker stop sae103-forever

# Suppression du conteneur sae103-forever

docker rm sae103-forever

# Suppression du volume sae103

docker volume rm sae103
