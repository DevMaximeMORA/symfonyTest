# Test [Symfony]
Application ***_symfony test_***

## Comment l'installer :
- Clonez le projet `git clone git@github.com:DevMaximeMORA/symfonyTest.git`
- Exécutez le script `install.sh` à la racine du projet et l'application s'ouvrira en local [`http://127.0.0.1`](http://127.0.0.1)

## Comment exporter les produits en csv :
- `cd infra && docker-compose run php php bin/console app:export_products csv && cd ..`
- Ou exécutez le script `export.sh`

### Indications
- [x] L’application propose 12 produits au total.
- [x] Les produits contiennent les champs suivants : id, nom, description, prix.
- [x] Les produits seront stockés en base de données.
- [x] Le panier sera stocké en session.

### Ecrans

 - [x] Page d’accueil : afficher la totalité des produits ordonnes par nom, un bouton “voir la fiche” permet d’aller sur la page de détails du produit.
 - [x] Page de détails d’un produit : afficher les informations du produit ainsi qu’un bouton permettant l’ajout au panier, avec le choix de la quantité (lors de l’ajout d’un produit au panier, si celui-ci est déjà présent il faudra mettre à jour sa quantité, et non pas le dupliquer).
 - [x] Page du panier : détailler le contenu du panier, afficher son montant total et un bouton permettant de vider le panier.
 - [x] Sur toutes les pages : afficher le nombre d’articles présents dans le panier dans un encart dédié.

### Fonctionnaliés avancées : 
   - [x] Fournir une configuration Docker / Docker Compose pour faire tourner le projet
   - [ ] Installer un espace d'administration permettant de gérer les produits (easyadmin)
   - [ ] Produit : ajouter une photo visible sur les pages d’accueil et de détails
   - [x] Produit : ajouter un slug qui servira à afficher la page de détails
   - [x] Sécuriser cet espace d’administration (utilisateur “admin” avec pour mot de passe “password” de type in_memory) `=> Users stockes dans la BDD avec hash du passsword`
   - [x] Produit : ajouter un slug qui servira à afficher la page de détails
   - [x] Page panier : pouvoir modifier les quantités
   - [x] Page panier : pouvoir supprimer un produit
   - [ ] Proposer un point d’API renvoyant l’intégralité des produits au format JSON
   - [x] Proposer un export au format CSV de l’intégralité des produits depuis une commande console dédiée
   - [ ] Permettre au visiteur de choisir la langue du site : fr ou en (les produits et les urls ne sont pas à traduire, seule l’interface est à adapter)
   - [ ] Tests plus complets

**Test réalisé par : MAXIME MORA**
