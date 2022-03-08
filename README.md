[![Maintainability](https://api.codeclimate.com/v1/badges/24f7d94b96d3412089fe/maintainability)](https://codeclimate.com/github/cegepst/code-wars/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/24f7d94b96d3412089fe/test_coverage)](https://codeclimate.com/github/cegepst/code-wars/test_coverage)
[![StyleCI](https://github.styleci.io/repos/403798502/shield?style=flat&branch=dev)](https://github.styleci.io/repos/403798502)

# Code Wars

### Introduction

~~~
Code Wars est une plateforme de remise d'exercice de programation pour
les élèves faisant parti du cours de "Programmation Orientée Objet 1".
Dans la thémathique Star-Wars, les élèves s'affronte les Rebels contre
les Sith pour obtenir le plus haut score. En accomplissant des exercices,
vous obtener des points avec lesquels vous pouvez acheter de objets dans
le marché qui donne des bonus en classe.
~~~

### Installation

~~~
Avant de faire toute configuration, assurez vous d'avoir une machine
aproprié pour intégrer le projet. Vous devriez au moins avoir :

- Apache
- PostgresSQL

Pour plus d'information sur l'installation d'un LAMP, veuillez vous
référer à ce Gist :

https://gist.github.com/dadajuice/a10b953b7c01db11f0c6d498f1dcc8ed
~~~

### Intégration

~~~
1 - Cloner le repo
    sudo -u www-data git clone https://github.com/cegepst/code-wars.git

2 - Installer les dépendances
    cd code-wars
    sudo -u www-data composer install
~~~

### Gestion de version

~~~
1 - Vérifier les dernier changement
    sudo -u www-data git fetch
    
2 - Checkout à la dernière version
    sudo -u www-data git checkout tags/<Derniere version>
~~~

### VHost

~~~
Pour faire le lien avec le dossier, il faut ajouter un virtual host.
Pout changer votre fichier VHost, veuillez enlever le VirtualHost
de base et en ajoutant le VirtualHost dessous au fichier suivant

-> /etc/apache2/sites-enabled/000-default.conf

avec l'éditeur de texte de votre choix (Nano pour les faibles). 

Si vous avez suivi le Gist, le fichier VHost est dans votre répertoire
"Home" de base.
~~~

```bash
<VirtualHost *:80>
	ServerName <Votre URL>

	ServerAdmin webmaster@localhost
	DocumentRoot /var/www/code-wars/public
	<Directory /var/www>
		AllowOverride All
		Require all granted
	</Directory>

	SetEnv PASSWORD_PEPPER "aPHOl9397AJuHOts7ZOj4DUMK4rC9+LuxopfSiKrvLw="

	ErrorLog ${APACHE_LOG_DIR}/error.log
	CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

~~~
Après avoir terminé cette configuration, vous devez redemmarer Apache.

- sudo systemctl restart apache2
~~~

### Création de la base de donnée

~~~
Pour populer la base de donner, commencer par créer vos utilisateurs de
la base avec l'outil de ligne de commande PostgresSQL.

sudo -u postgres psql

postgres=# CREATE ROLE <USER> WITH SUPERUSER CREATEDB CREATEROLE LOGIN ENCRYPTED PASSWORD '<PASS>';
postgres=# CREATE ROLE <USER_APP> WITH LOGIN ENCRYPTED PASSWORD '<PASS_APP>';
postgres=# \q

Ensuite créer votre base de donnée via la ligne de commande traditionelle.  

createdb codewars

Après, donner les droits à votre utilisateur de base de donnée.

sudo -u postgres psql
postgres=# grant all privileges on database codewars to <USER_APP>;
postgres=# \q

Finalement, importer les données des scripts SQL.

sudo -u postgres psql
postgres=# \c codewars
codewars=# \i \home\<User Linux>\www\code-wars\codewars_script.sql
codewars=# \i \home\<User Linux>\www\code-wars\mock-data.sql
codewars=# \q
~~~

### Crédits

<img src="https://avatars.githubusercontent.com/u/72167870?s=60&v=4" />
<img src="https://avatars.githubusercontent.com/u/72167889?s=60&v=4" />
<img src="https://avatars.githubusercontent.com/u/58580199?s=60&v=4" />
<img src="https://avatars.githubusercontent.com/u/72167772?s=60&v=4" />
<img src="https://avatars.githubusercontent.com/u/72167795?s=60&v=4" />
<img src="https://avatars.githubusercontent.com/u/4491532?s=60&v=4" />
<img src="https://avatars.githubusercontent.com/u/3046578?s=60&v=4" />

~~~
Samuel Tessier
  - Développeur back-end
  - Coordonnateur
  
Tommy-Lee Pigeon
  - Développeur fullstack
  - Responsable des tests unitaires
  
Jérémie Bouchard
  - Développeur fullstack
  - Responsable de la base de données
  
Joshua Leblanc
  - Développeur front-end
  - Responsable UI/UX
  
Julien Deguire
  - Développeur back-end
~~~

## License

[MIT](https://opensource.org/licenses/MIT)

## Droits d'auteur

© 2021-present, Ether
