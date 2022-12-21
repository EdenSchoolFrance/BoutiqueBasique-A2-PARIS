
# BOUTIQUE BASIQUE

******Utilisation d'un Layout(view), de l'Objet (modèle), de sessions (panier, login), de controlers,  de l'objet PDO (DAO) ****** 

Il s'agit d'une boutique qui permet à un utilisateur de mettre des produits dans un panier et de passer une commande.


Au niveau de la bdd :  4 tables :  Client  -  Commande  - LigneCommande  -  Produit
(le script sql est dans le dossier config)


Il y a 2 types d'utilisateurs :

Le client qui peut se logger et passer une commande et également modifier son compte
identifiant :  admin@boutiquebasique.com  
password : admin


L'admin qui lui peut faire le CRUD sur les clients et les produits
identifiant :   admin@boutiquebasique.com  
password :  admin


**WARNING *****  Cette version n'est pas sécurisée,  possibilité de hacker en passant par l'URL,  en modifiant dans la vue l'attribut "todo" des formulaires**

