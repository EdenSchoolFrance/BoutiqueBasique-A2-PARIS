<?php
require('../models/dao/DaoClient.php');

class ControllerClient
{
    //on déclare un attribut de type daoClient
    private $daoClient;

    public function __construct()
    {
        //on instancie un objet de type daoClient
        //en utilisant la variable $daoClient
        $this->daoClient = new DaoClient();
    }

    /** Affichage du formulaire de création d'un client **/
    public function showCreate()
    {
        //On appelle le formulaire de création de client
        require('../views/CreerClient.php');
    }

    /** Enregistrement du nouveau client dans la base de données**/
    public function store()
    {
        //On appelle la méthode qui crée le client
        //cette méthode renvoie l'ID du dernier client inséré
        $lesClients = $this->daoClient->createClient();
        //On appelle la méthode qui permet d'afficher la barre de recherche
        $recherche = $this->daoClient->rechercheClient();
        //On récupère $contenu et on le passe à la vue concernée
        $contenu = $this->daoClient->afficherClients($lesClients);
        require('../views/Layout.php');
    }

    /** Affichage des clients **/
    public function showAll()
    {
        //On appelle la méthode qui permet d'afficher la barre de recherche
        $recherche = $this->daoClient->rechercheClient();
        //On récupère la methode de daoClient qui recherche les clients
        //et qui les retourne sous forme de variable $contenu que l'on passe à la vue concernée.
        $contenu = $this->daoClient->afficherClients();
        require('../views/Layout.php');
    }
    /** Affichage du formulaire de modification **/
    public function showModify()
    {
         //On appelle la méthode de la classe DaoClient qui retourne le client concerné
        $client = $this->daoClient->afficherFormModif();
        //On récupère $client et on le passe à la vue concernée
        require('../views/ModifierClient.php');
    }

    /** enregistrement des modifications dans la bdd **/
    public function update()
    {
        //On appelle la méthode qui permet de mettre à jour le client dansDaoClient
         $lesClients= $this->daoClient->updateClient();
        //On récupère $contenu et on le passe à la vue concernée
        $contenu = $this->daoClient->afficherClients($lesClients);
        require('../views/Layout.php');
    }


    /** Suppression d'un client **/
    public function delete()
    {
        //On appelle la méthode qui permet de supprimer le client
        $this->daoClient->deleteClient();
        $this->showAll();
    }

    /**VALIDATION DU  **/
    public function login()
    {
        //ON APPELLE LA METHODE QUI VERIFIE LE LOGIN
        //ET QUI AFFICHE LE PROFIL DU CLIENT SI LE LOGIN EST BON
        //OU AFFICHE UN MESSAGE D ERREUR SI LE LOGIN EST FAUX
        $contenu = $this->daoClient->login();

        if ($contenu=="LE LOGIN EST ERRONE")
        {require('../views/Login.php');}
        else
        {require('../views/Layout.php');}
    }

}