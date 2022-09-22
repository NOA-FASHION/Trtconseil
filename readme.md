
# PROJET TRT-CONSEIL
TRT-CONSEIL
Ce document est un guide de déploiement et un manuel d'utilisation 
pour l'application TRT-CONSEIL dévéloppé dans le cadre de l'ECF d'entrainement ayant pour titre:
**Développer la partie back-end d’une application web**
de l'école STUDI.
Selon le cahier des charges l'application demandé devra permettre aux acteurs de l'hotellerie de se confronté.
TRT Conseil est une agence de recrutement spécialisée dans l’hôtellerie et la restauration qui souhaite dévelloper
 un outils ou les recruteurs pourrons proposé des postes de travail et les candidats pourronts y postuler, 
tout cela sous l'administration des consultants de la boite


# Fonctionnalités de l'application


1. ## Se connecter

#### Utilisateur consernés: Recruteurs, candidats, consultants, administrateurs


4 types d’utilisateur devront pouvoir se connecter :
* Les recruteurs : Une entreprise qui recherche un employé.
* Les candidats : Un serveur, responsable de la restauration, chef cuisinier etc.
* Les consultants : Missionnés par TRT Conseil pour gérer les liaisons sur le back-office entre
recruteurs et candidats.
* L’administrateur : La personne en charge de la maintenance de l’application.
* Chaque type d'utilisateur posséderons un compte pour accéder à leur espace personel et respectif.


2.  ## Espace spécifique

#### Utilisateur consernés: Recruteurs, candidats, consultants, administrateurs

* Chaque type d'utilisateur posséderons un espace type spécifique
* L'espace recruteurs donnera accés aux annonces qui appartiennent et à l'espace personnel de l'utilisateur de type recruteur
* L'espace candidats donnera accés aux annonces qui seront activés et à l'espace personnel de l'utilisateur de type candidats
* L'espace consultants donnera accés aux annonces, aux compte candidat et recruteur et à l'espace personnel de l'utilisateur de type consultant
* L'espace administrateur permettra la gestion des comptes de type consultants

3.  ## Créer son compte

#### Utilisateur consernés: Recruteurs, candidats, 

* Les recruteurs et les candidats  aurons la possibilité de créer leur compte qui sera par defaut désactivé

* Pour les comptes des consultants c'est l'administratuer qui aura le droit de les créer.

4.  ## Activation des comptes

#### Utilisateur consernés:  consultant

* Le consultant pourra activer les comptes des candidats et des recruteurs

5.  ## Compléter son profil

#### Utilisateur consernés: Recruteurs, candidats, 

* Les candidats pourront préciser leur nom, prénom ainsi que transmettre leur CV (obligatoirement au format PDF).
* Les recruteurs pourront préciser le nom de l’entreprise ainsi qu’une adresse.

6.  ## Publier une annonce

#### Utilisateur consernés: recruteurs

* Un formulaire devra demander l’intitulé du poste, le lieu de travail et une description détaillée (horaires, salaire, etc.).
* Pour chaque offre qu’il a transmise, une liste des candidats validés par TRT Conseil et qui ont
postulés à cette annonce sera visible par le recruteur. 

6.  ## Postuler à une annonce

#### Utilisateur consernés: candidats

* Depuis la liste de toutes les annonces disponibles sur l’application, un candidat peut postuler à une offre en appuyant sur un simple bouton.
* Si c’est approuvé, le recruteur concerné recevra un email avec le nom/prénom du candidat ainsi
que son CV.

6.  ## Activation annonce et candidature

#### Utilisateur consernés: consultant

* Un consultant doit valider l’annonce d'un partenaire avant qu’elle soit visible pour les candidats.
* Un consultant doit approuver la candidature d'un candidat

------
# Tech Stack

**Client:** Css, Html, Bootstrap, Bootswatch, js

**Server:** Php, Symfony

**Sql:** PostGres

------
# Installation de l'environement


## Les pré-requis 

### installation de la base de données

Télécharger les paquets de postgress à l'adresse suivante : 
[Download PostGress](postgresql.org/download/macosx/), installer les paquets sur votre ordinateurs

### installation de symfony

Selon la [Documentation](https://symfony.com/doc/current/setup.html#technical-requirements) de symfony avant de créer votre première 
application Symfony vous devez :


### Installer PHP 8.1
* Installez PHP 8.1 ou supérieur et ces extensions.

### Installer Composer
* install Composer , qui est utilisé pour installer les packages PHP.



### Installer Symfony CLI
Il est recommandé aussi l'installation de 
[Symfony CLI](https://symfony.com/download)

La descriptions des procédures d'installation suivantes sont destinées à l'OS MACOS, pour les autres système 
d'exploitaion vous pouvez vous référez à la documentation officielle.

## Procédures d'installation 

### Installation de php
```Terminal 
$ brew install php
```

### Installation de symfony-cli

```Terminal 
$ brew install symfony-cli/tap/symfony-cli

```
### Installation de Composer

```Terminal 
$ brew install composer
```
crée le lien symbolique:

```Terminal 
$ brew link --overwrite composer
```

## Test de l'environnement 

Le symfonybinaire fournit également un outil pour vérifier si votre ordinateur répond à toutes 
les exigences. 
Ouvrez votre terminal de console et exécutez cette commande :
```Terminal 
$ symfony check:requirements
```
Si votre environnement est optimal vous recevrez un retour positif dans votre terminal:


```Terminal 
$ [OK]                                         
 Your system is ready to run Symfony projects 
```


------


# Création et fonctionnement d'une application symfony


## Création de l'application
Apres avoir créer le dossier qui recevra tous les élements de votre appplication symfony, 
vous pouvez l'ouvrir avec votre éditeur de texte préféré.

Ensuite vous ouvrz un terminal à la racine du dossier et vous tapez la commande suivante:

```Terminal 
$ symfony new my_project --full
```

L'option --full est l'option pour préciser à symfony cli d'installer tous les packets nécéssaires 
pour faire une application web complète.

## Démarer l'environnement

Pour démarer l'environement il faut rentrer dans le projet et démarer le server symfony 
avec les commandes suivantes:
```Terminal 
$ cd my-project/
$ symfony server:start
```

------
# Installation de  l'environnement GIT

Se connecter sur le serveur GITHUB et créer un repositories.

## Initialiser votre dépot et créer votre premier commit
* git init
* git add README.md
* git commit -m "first commit"
* git branch -M main
* git remote add origin https://github.com/NOA-FASHION/trtConseil.git

## Synchroniser le sur votre serveur GITHUB.
git push -u origin main

------


# Déploiement de l'application
Le déploiement à été éffectué sur un serveur VPS, le choix du provider est Hostinger.

# Installation de l'environement

## Les pré-requis 


### installation de la base de données PostGres

La procédure d'installation est la suivante:

```Terminal 
$ sudo sh -c 'echo "deb http://apt.postgresql.org/pub/repos/apt $(lsb_release -cs)-pgdg main" > /etc/apt/sources.list.d/pgdg.list'

$ wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | sudo apt-key add -

$ sudo apt-get update

$ sudo apt-get -y install postgresql
```

### installation de symfony

Selon la documentation de symfony avant de créer votre première 
application Symfony vous devez :

[Documentation symfony](https://symfony.com/doc/current/setup.html#technical-requirements)
### Installer PHP 8.1
* Installez PHP 8.1 ou supérieur et ces extensions.

### Installer Composer
* install Composer , qui est utilisé pour installer les packages PHP.



### Installer Symfony CLI
Il est recommandé aussi l'installation de 
[Symfony CLI](https://symfony.com/download)

La descriptions des procédures d'installation suivantes sont destinées à l'OS Linux Ubuntu, pour les autres système 
d'exploitaion vous pouvez vous référez à la documentation officielle.

## Procédures d'installation 

### Mise à jour des paquets d'installation
```Terminal 
$ sudo apt-get update && apt-get upgrade
```
### Installation de php
```Terminal 
$ sudo apt-get install php
```

### Installation de symfony-cli

```Terminal 
$ sudo apt install git zip unzip
$ wget https://get.symfony.com/cli/installer -O - | bash
```
### Installation de Composer

```Terminal 
$ sudo apt install composer
```
Se définir propriétaire des répertoires associés pour permettre
 à composer de créer les caches sans utiliser sudo

```Terminal 
$ sudo chown -R $USER $HOME/.composer
```

crée le lien symbolique:

```Terminal 
$ export PATH="$HOME/.symfony/bin:$PATH"
```

# Test de l'environnement 

Le symfonybinaire fournit également un outil pour vérifier si votre ordinateur répond à toutes 
les exigences. 
Ouvrez votre terminal de console et exécutez cette commande :
```Terminal 
$ symfony check:requirements
```
Si votre environnement est optimal vous recevrez un retour positif dans votre terminal:


```Terminal 
$ [OK]                                         
 Your system is ready to run Symfony projects 
```



# Instalation et paramétrage de GIT


## installer GIT
```Terminal 
$ sudo apt install git
```

## initialisr Git
```Terminal 
$ git config --global user.name "Your Name"
$ git config --global user.email "youremail@domain.com"
```
## syncroniser Github avec votre Git en local

```Terminal 
$ git remote add origin https://github.com/NOA-FASHION/sport-training.git
$ git branch -M main
$ git push -u origin main
```
------
# sécurisation de l'environement
------
# mise en production de l'environement