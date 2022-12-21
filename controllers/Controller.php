<?php
session_start();
require('ControllerProduit.php');
require('ControllerClient.php');
require('ControllerCommande.php');


//ON INSTANCIE LES CONTROLLEURS DONT ON A BESOIN
$cp = new ControllerProduit();
$cc = new ControllerClient();
$ccm = new ControllerCommande();


// ************************************************************************
// *****************   REQUETES EN GET VIA URL  ***************************
//RECUPERATION DE L ACTION A ACCOMPLIR VIA L'URL
if (isset($_GET['todo'])) {
    switch ($_GET['todo']) {

        // L'UTILISATEUR A CLIQUE SUR LE LIEN "MOUVEAU PRODUIT" dans le menu
        case
        "creerProduit":
        {//On appelle la méthode concernée dans la classe ControllerProduit
            $cp->showCreate();
            break;
        }
        // L'UTILISATEUR A CLIQUE SUR LE LIEN "PRODUITS" dans le menu
        case "afficherProduits":
        {
            //On appelle la méthode concernée dans la classe ControllerProduit
            $cp->showAll();
            break;
        }

        // L'UTILISATEUR A CLIQUE SUR LE LIEN "modifier le produit" sur un article du catalogue
        case
        "modifierProduit":
        {
            //On appelle la méthode concernée dans la classe ControllerProduit
            $cp->showModify();
            break;
        }
        // L'UTILISATEUR A CLIQUE SUR LE LIEN "NOUVEAU CLIENT" dans le menu
        case
        "creerClient":
        {
            //On appelle la méthode concernée dans la classe ControllerClient
            $cc->showCreate();
            break;
        }

        // L'UTILISATEUR A CLIQUE SUR LE LIEN "CLIENTS"
        case "afficherClients":
        {
            //On appelle la méthode concernée dans la classe ControllerClient
            $cc->showAll();
            break;
        }
        // L'UTILISATEUR A CLIQUE SUR LE LIEN "modifier le client" sur l'affichage d'un client
        case "modifierClient":
        {
            //On appelle la méthode concernée dans la classe ControllerClient
            $cc->showModify();
            break;
        }
        // L'UTILISATEUR A CLIQUE SUR LE LIEN "passer commande" sur l'affichage d'un client
        case "commencerCommande":
        {
            //On appelle la méthode concernée dans la classe ControllerPanier
            $cp->showAll();
            break;
        }
        // L'UTILISATEUR A CLIQUE SUR LE LIEN "COMMANDES"
        case "afficherCommandes":
        {
            $ccm->showAll();
            break;
        }

        // L'UTILISATEUR A CLIQUE SUR LE LIEN "AJOUTER AU PANIER" sur l'affichage d'un PRODUIT
        case "ajouterAuPanier":
        {
            //On appelle la méthode concernée dans la classe ControllerPanier
            $cp->ajouterAuPanier();
            break;
        }
        // L'UTILISATEUR A CLIQUE SUR L'ICONE DU CADDIE
        case "montrerPanier":
        {
            //On appelle la méthode concernée dans la classe ControllerPanier
            $cp->montrerPanier();
            break;
        }
        // L'UTILISATEUR A CLIQUE sur "se déconnecter"
        case "deconnexion":
        {
            //ON DECONNECTE LE CLIENT
            session_destroy();
            //On redirige vers le layout
            require('../views/Layout.php');
            break;
        }

        //GESTION DES CAS D'ERREURS
        default :
        {
            echo "erreur de redirection!!!";
            break;
        }

    }//**********************  FIN  DU  SWITCH
}// FIN DES REQUETES EN GET VIA URL
//*************************************************
//*************************************************
//*************************************************


//*************************************************
//*************************************************
//*************************************************
//*************************************************
// REQUETES EN POST VIA FORMULAIRES
if (isset($_POST['todo'])) {

    switch ($_POST['todo']) {

        // L UTILISATEUR A POSTER LE FORMULAIRE DE LOGIN
        case "seConnecter":
        {
            //On appelle  la méthode concernée dans la classe ControllerClient
            $cc->login();
            break;
        }
        // L UTILISATEUR A POSTE LE FORMULAIRE DE CREATION D UN PRODUIT
        case  "creerProduit":
        {
            //On appelle la méthode concernée dans la classe ControllerProduit
            $cp->store();
            break;
        }

          // L UTILISATEUR A POSTE LE FORMULAIRE DE MODIFICATION D UN PRODUIT
        case
        "modifierProduit":
        {
            //On appelle la méthode concernée dans la classe ControllerProduit
            $cp->update();
            break;
        }

        // L UTILISATEUR A POSTE LE FORMULAIRE DE SUPPRESSION D UN PRODUIT
        case
        "supprimerProduit":
        {
            //On appelle la méthode concernée dans la classe ControllerProduit
            $cp->delete();
            break;
        }
        // L UTILISATEUR A POSTE LE FORMULAIRE DE CREATION D UN CLIENT
        case  "creerClient":
        {
            //On appelle la méthode concernée dans la classe ControllerClient
            $cc->store();
            break;
        }

        // L UTILISATEUR A POSTE LE FORMULAIRE DE MODIFICATION D UN CLIENT
        case
        "modifierClient":
        {
            //On appelle la méthode concernée dans la classe ControllerClient
            $cc->update();
            break;
        }

        // L UTILISATEUR A POSTE LE FORMULAIRE DE SUPPRESSION D UN CLIENT
        case
        "supprimerClient":
        {
            //On appelle la méthode concernée dans la classe ControllerClient
            $cc->delete();
            break;
        }

        // L'UTILISATEUR A CLIQUE SUR VALIDER COMMANDE DANS LE PANIER
        case "passerCommande":
        {  //On appelle la méthode concernée dans la classe ControllerPanier
            $ccm->validerCommande();
            break;
        }
        //GESTION DES CAS D'ERREURS
        default :
        {
            echo "erreur de redirection!!!";
            break;
        }

    }//**********************  FIN  DU  SWITCH
}// FIN DES REQUETES EN POST VIA LES FORMULAIRES
//*************************************************
//*************************************************
//*************************************************
