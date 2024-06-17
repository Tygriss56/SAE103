#!/bin/bash

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