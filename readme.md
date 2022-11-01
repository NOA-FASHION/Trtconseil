
# PROJET TRT-CONSEIL
TRT-CONSEIL
Ce document est un guide de déploiement et un manuel d'utilisation 
pour l'application TRT-CONSEIL dévéloppé dans le cadre de l'ECF d'entrainement ayant pour titre:
<br/>
**Développer la partie back-end d’une application web**
de l'école STUDI.
<br/>
Selon le cahier des charges l'application demandé devra permettre aux acteurs de l'hotellerie de se confronté.
<br/>
TRT Conseil est une agence de recrutement spécialisée dans l’hôtellerie et la restauration qui souhaite dévelloper
 un outils ou les recruteurs pourrons proposé des postes de travail et les candidats pourronts y postuler, 
tout cela sous l'administration des consultants de la boite.


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

* Chaque type d'utilisateur posséderons un espace type spécifique, qui sont l'espace candidat pour les candidats, l'espace partenaire pour les partenaires et l'espace consultant pour les consultant
* L'espace recruteurs donnera accés aux annonces qui lui appartiennent 
* L'espace candidats donnera accés aux annonces activés 
* L'espace consultants donnera accés aux annonces, aux comptes candidats et aux comptes recruteurs 
* L'espace administrateur permettra la gestion des comptes de type consultants.

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

7.  ## Postuler à une annonce

#### Utilisateur consernés: candidats

* Depuis la liste de toutes les annonces disponibles sur l’application, un candidat peut postuler à une offre en appuyant sur un simple bouton.
* Si c’est approuvé, le recruteur concerné recevra un email avec le nom/prénom du candidat ainsi
que son CV.

8.  ## Activation annonce et candidature

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
# mise en production de l'environement

## Installation des dépendances

```Terminal
$ sudo symfony composer install
```

## Connexion de symfony à la base de données et paramétrage du MailerDSN pour le routage des emails
Cela se fait en rentrant les paramètre de connexion dans le fichier .env qui se trouve à la racine du porjet


## création de la base des tables et des données factices

```Terminal
$ php bin/console doctrine:migration:migrate
$ php bin/console doctrine:fixtures:load
```
## Modification de la variable d'environement en prod
```VsCode 
APP_ENV=prod
```
## publication en ligne du site

Pour rendre votre site accessible sur le port web (443) vous devez installer un reverse proxy. nginx est le serveur HTTP et reverse proxy le plus connu.
```Terminal
$ sudo apt-get update
$ sudo apt-get install -y nginx
```
### installer un certificat valide
Apres avoir télécharge et configurer un certificat sur ZeroSsl.com, créer un dossier /etc/nginx/certificat/
et copier le certificat dans ce dossier.

### configurez nginx
Ouvrez le fichier de configuration principal :
```Terminal
$ sudo nano /etc/nginx/sites-available/default
```

### Ensuite, remplacez le contenu du fichier par ce qui suit :

```Nano
server {
    # Listen HTTPS
    listen 443 ssl;
    server_name api.example.com;

    # SSL config
    ssl_certificate /etc/nginx/certificat/certificate.crt;
    ssl_certificate_key /etc/nginx/certificat/private.key;
   
     root /var/www/sport_training/public;
   
        # Proxy Config
    location / {
        proxy_pass http://localhost:1337;
        proxy_http_version 1.1;
        proxy_set_header X-Forwarded-Host $host;
        proxy_set_header X-Forwarded-Server $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
        proxy_set_header Host $http_host;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection "Upgrade";
        proxy_pass_request_headers on;
    }
   
location /trt-conseil {
root $symfonyRoot;
rewrite ^/trt-conseil/(.*)$ /$1 break;
try_files $uri @symfonyFront;
}



set $symfonyRoot /var/www/trt-conseil/public;
set $symfonyScript index.php;
   
  # This is for the Symfony application
location @symfonyFront {
fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
include /etc/nginx/fastcgi_params;
fastcgi_param SCRIPT_FILENAME $symfonyRoot/$symfonyScript;
fastcgi_param SCRIPT_NAME /trt-conseil/$symfonyScript;
fastcgi_param REQUEST_URI /trt-conseil$uri?$args;
}
   
 

   # return 404 for all other php files not matching the front controller
   # this prevents access to other php files you don't want to be accessible.
   location ~ \.php$ {
     return 404;
   }
       
}
```

### Redémarrez nginx :
```Terminal
$ sudo systemctl restart nginx
```
### Redémarrez nginx :

votre site sera disponible àl'adresse suivante:
https://<adressIP>/trt-conseil/
Le serveur hébergeant déja un site, l'application symfony sera dispoble dans un sous-dossier sport_training.

# sécurisation de l'environement

Il est maintenant temps de mettre en place un pare-feu. Un pare-feu est essentiel lors de la configuration du VPS pour limiter le trafic indésirable sortant ou entrant dans votre VPS. Installez ufw et configurez un pare-feu pour autoriser les opérations SSH en faisant:

## Installation du parefeu ufw
```Terminal
$ sudo apt install ufw -y
```
## configuration du parefeu

```Terminal
$ sudo ufw allow OpenSSH
$ sudo ufw allow 443
$ sudo ufw allow OpenSSH
$ sudo ufw enable -y 
```
## Installation du fail2ban

fail2ban est un logiciel qui se charge d'analyser les logs de divers services installés sur la machine, pour bannir automatiquement un hôte via iptables pour une durée déterminée, en cas d'échec après X tentatives.
C'est un élément essentiel pour sécuriser son système, et éviter des intrusions via brute-force.

```Terminal
$ sudo apt install fail2ban
```


------