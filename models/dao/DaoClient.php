<?php
require_once('../utilitaires/FonctionsUtiles.php');
require_once('../models/Client.php');
require_once('../config/config.php');
//***********************************************CLIENT  CLIENT  CLIENT
//***********************************************CLIENT  CLIENT  CLIENT
//***********************************************CLIENT  CLIENT  CLIENT
class DaoClient
{
    //ATTRIBUT DE LA CLASSE DaoClient
    private $maConnection;

    //CONSTRUCTEUR DE LA CLASSE DaoClient
    public function __construct()
    {
        //INSTANCIATION DE LA CONNEXION PAR APPEL AU CONSTRUCTEUR PDO ET VALORISATION DES ATTRIBUTS
        $this->maConnection = new PDO('mysql:host=' . HOST . ';dbname=' . DATABASE . ';charset=utf8;', USER, PASSWORD);
        //PARAMETRAGE POUR AFFICHAGE DES ERREURS RELATIVES A LA CONNEXION
        $this->maConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

//CETTE FONCTION PERMET DE CREER UN NOUVEAU CLIENT
    function createClient(): array
    {
        $client = new Client(0, $_POST['clientPrenom'], $_POST['clientNom'], $_POST['clientNaissance'], $_POST['clientMail'], password_hash($_POST['clientPassword'], PASSWORD_BCRYPT));

        //ON UTILISE LA METHODE prepare() de PDO POUR FAIRE UNE REQUETE PARAMETREE
        $query = $this->maConnection->prepare("INSERT INTO `client`(`CLIENT_PRENOM`,`CLIENT_NOM`,`CLIENT_NAISSANCE`,`CLIENT_MAIL` , `CLIENT_PASSWORD`) values(?, ?, ?, ?, ?)");
        $result = $query->execute(array(
            $client->getClientPrenom(),
            $client->getClientNom(),
            $client->getClientNaissance(),
            $client->getClientMail(),
            $client->getClientPassword()
        ));
        //ON RECUPERE LID DU NOUVEAU CLIENT
        $client->setClientId($this->maConnection->lastInsertId());
        //ON RETOURNE LE CLIENT DANS UN TABLEAU AU CONTROLLER
        //LE CONTROLEUR VA APPELER LA FONCTION "afficherClients"
        // et lui passer le tableau en parametre
        $tabClients = array();
        array_push($tabClients, $client);
        return $tabClients;
    }


//CETTE FONCTION PERMET DE METTRE A JOUR UN CLIENT
    function updateClient(): array
    {
        $client = new Client($_POST['clientId'], $_POST['clientPrenom'], $_POST['clientNom'], $_POST['clientNaissance'], $_POST['clientMail'], password_hash($_POST['clientPassword'], PASSWORD_BCRYPT));

        //ON UTILISE LA METHODE prepare() de PDO POUR FAIRE UNE REQUETE PARAMETREE
        $query = $this->maConnection->prepare("UPDATE client SET CLIENT_PRENOM=?, CLIENT_NOM=?, CLIENT_NAISSANCE=?, CLIENT_MAIL=?, CLIENT_PASSWORD=? WHERE CLIENT_ID=?");
        $result = $query->execute(array(
            $client->getClientPrenom(),
            $client->getClientNom(),
            $client->getClientNaissance(),
            $client->getClientMail(),
            $client->getClientPassword(),
            $client->getClientId()
        ));
        //ON RETOURNE LE CLIENT DANS UN TABLEAU QUE L'ON DONNE AU CONTROLLER
        //LE CONTROLEUR VA APPELER LA FONCTION "afficherClients"
        // et lui passer le tableau en parametre
        $tabClients = array();
        array_push($tabClients, $client);
        return $tabClients;
    }

//CETTE FONCTION PERMET DE SUPPRIMER UN CLIENT
    function deleteClient(): void
    {
        $query = $this->maConnection->prepare("DELETE FROM client WHERE CLIENT_ID =?");
       $query->execute(array($_POST['clientId']));
    }

    //CETTE FONCTION PREND EN ARGUMENT UN JEU DE RESULTATS DE BDD ET LE TRANSFORME EN ARRAY D OBJETS DE TYPE CLIENTS
    function resultToObjects($result)
    {   //ON RECUPERE LE RÉSULTAT DE LA REQUETE DANS UN TABLEAU
        //QUI CONTIENDRA 1 OU PLUSIEURS OBJETS DE TYPE CLIENT
        $listClients = array();
        foreach ($result as $row) {
            $client = new Client($row['CLIENT_ID'], $row['CLIENT_PRENOM'], $row['CLIENT_NOM'], $row['CLIENT_NAISSANCE'], $row['CLIENT_MAIL'], $row['CLIENT_PASSWORD'],$row['CLIENT_ROLE']);
            array_push($listClients, $client);
        }
        return $listClients;
    }

    //CETTE METHODE PERMET DE TROUVER UN CLIENT PAR SON ID
    function getClientByMail($mail): array
    {
        $query = $this->maConnection->prepare(" SELECT CLIENT_ID,CLIENT_PRENOM, CLIENT_NOM, CLIENT_NAISSANCE , CLIENT_MAIL , CLIENT_PASSWORD , CLIENT_ROLE FROM client WHERE CLIENT_MAIL =?");
        $query->execute(array(
            $mail));
        $result = $query->fetchAll();
        //ON TRANSFORME LE RESULTAT EN TABLEAU CONTENANT UN OU PLUSIEURS OBJETS DE TYPE CLIENT
        return $this->resultToObjects($result);
    }

    //CETTE METHODE PERMET DE SELECTIONNER TOUS LES CLIENTS
    function getAll(): array
    {
        $lesClients = array();
        //CETTE REQUETE NE DOIT ETRE ACCESSIBLE UNIQUEMENT SI UN UTILISATEUR EST CONNECTE
        //ET QUE CET UTILISATEUR A LE ROLE D'ADMIN
        if (isset($_SESSION["client"])) {
            if ($_SESSION["client"]['role'] == "ADMIN") {
                $query = $this->maConnection->prepare("SELECT CLIENT_ID,CLIENT_PRENOM, CLIENT_NOM, CLIENT_NAISSANCE , CLIENT_MAIL , CLIENT_PASSWORD , CLIENT_ROLE FROM client");
                $query->execute();
                $result = $query->fetchAll();
                //ON TRANSFORME LE RESULTAT EN TABLEAU CONTENANT UN OU PLUSIEURS OBJETS DE TYPE CLIENT
                $lesClients = $this->resultToObjects($result);
            }
            //SI L UTILISATEUR CONNECTE A UN ROLE DE CLIENT
            //ON NE DONNE ACCES QU A SON PROFIL
            else
            {
                $lesClients = $this->getClientById($_SESSION["client"]['id']);
            }
        }
        return $lesClients;
    }


    //CETTE METHODE PERMET DE TROUVER UN CLIENT PAR SON ID
    function getClientById($id): array
    {
        $query = $this->maConnection->prepare(" SELECT CLIENT_ID,CLIENT_PRENOM, CLIENT_NOM, CLIENT_NAISSANCE , CLIENT_MAIL , CLIENT_PASSWORD, CLIENT_ROLE   FROM client WHERE CLIENT_ID =?");
        $query->execute(array(
            $id));
        $result = $query->fetchAll();
        //ON TRANSFORME LE RESULTAT EN TABLEAU CONTENANT UN OU PLUSIEURS OBJETS DE TYPE CLIENT
        return $this->resultToObjects($result);
    }


    //CETTE FONCTION PERMETS D'AFFICHER LES INFORMATIONS DU CLIENT
    function afficherClients($tabClients = null): string
    {
        $contenu = "<section id='slogan'><div class='erreur'>ERREUR  404 -  PAGE NON TROUVÉE</div></section>";

        $lesClients=array();
        if (!empty($_POST['clientId'])) {
            /* récupérer les données du formulaire en utilisant
               la valeur des attributs name comme clé*/
            $lesClients = $this->getClientById($_POST['clientId']);
        }
        if (($tabClients == null) && (!isset($_POST['clientId']))) {
            //ON APPELLE LA FONCTION QUI VA FAIRE LA REQUETE AUPRES DE LA BASE DE DONNEES
            //CETTE FONCTION RENVOIE UN TABLEAU CONTENANT UN OU PLUSIEURS OBJETS DE TYPE CLIENTS
            $lesClients = $this->getAll();
        }
        //SUITE A LA SUPPRESSION D UN CLIENT ON REAFFICHE TOUT LES CLIENTS
        if ((isset($_POST['todo'])) && ($_POST['todo']=="supprimerClient")) {
            //ON AFFICHE TOUS LES CLIENTS
            $lesClients = $this->getAll();
        }

        if ($tabClients != null) {
            $lesClients = $tabClients;
        }

        //ON AFFICHE LE HTML POUR LE FICHIER "AfficherClients"
        if (isset($_SESSION["client"])) {
            $contenu =
                "<section id='slogan'>
        <h2>Mon profil</h2></div ></section><div id='menu'>";
        }

        foreach ($lesClients as $client) {
            $id = $client->getClientId();
            $naissance = strftime('%d/%m/%Y', strtotime($client->getClientNaissance()));
            $signe = $client->getClientSigne();
            $contenu .= "<article class='article' >
            <div class='container' >";
            if (isset($_SESSION["client"])) {
                $contenu .= "<a href = '../controllers/Controller.php?todo=commencerCommande'>COMMENCER VOS ACHATS</a>";
            }
            $contenu .= "<img class='image' src = '../assets/img/" . $signe . " ' alt=''></div >
             <h2 > " . $client->getClientPrenom() . ' ' . $client->getClientNom() . "</h2 >
             <p style='text-align: center;'> date de naissance " . $naissance . " 
             <br>" . $client->getClientAge() . " ANS</p><br>
            <button id='submit'>
                <a href = '../controllers/Controller.php?todo=modifierClient&id=$id'>MODIFIER OU SUPPRIMER</a>
            </button><br> ";

             $contenu .= "</article > ";
        }
        return $contenu;
    }

//CETTE FONCTION PERMET D'AFFICHER UN FORMULAIRE DE RECHERCHE DE CLIENTS
    function rechercheClient(): string
    {    //ON APPELLE LA FONCTION QUI VA FAIRE LA REQUETE AUPRES DE LA BASE DE DONNEES
        //CETTE FONCTION RENVOIE TOUS LES Client SOUS FORME DE TABLEAU D'OBJETS
        $lesClients = $this->getAll();

        //ON AFFICHE LE HTML POUR LE FICHIER "ModifierClients"
        $recherche = "
<form name='searchProduct' action='#' method='post' class='search-form'>
    <label for='clientId' hidden></label>
    <select name='clientId' id='nomClient' class='header-select' onchange='this.form.submit()'>
        <option value=''>Choisir un client</option>";
        foreach ($lesClients as $client) {
            $recherche .= "<option value=" . $client->getClientId() . ">" . $client->getClientPrenom() . ' ' . $client->getClientNom() . "</option>";
        }

        $recherche .= "</select>
</form>";

        return $recherche;
    }

//CETTE FONCTION PREND EN GET DANS L URL UN ID Client
//ET RENVOIE Client
    function afficherFormModif(): Client
    {
        //ON APPELLE LA FONCTION QUI VA FAIRE LA REQUETE AUPRES DE LA BASE DE DONNEES
        //CETTE FONCTION RENVOIE UN TABLEAU CONTENANT LE Client A MODIFIER
        //ON RETOURNE CET OBJET Client AU CONTROLEUR QUI A APPELLE LA FONCTION
        //LE CONTROLEUR RETOURNERA L'OBJET A LA VUE "ModifierClient";
        return $this->getClientById($_GET['id'])[0];
    }

    //CETTE FONCTION VERIFIE LE LOGIN ET MET LE CLIENT EN SESSION
    function login(): string
    {
        //ON VA CHERCHER DANS LA BASE DE DONNES SI LE MAIL FOURNI (POST) EXISTE
        //SI IL EXISTE ON RECUPERE LE CLIENT SOUS FORME D'OBJET DANS UN TABLEAU
        $tclient = $this->getClientByMail($_POST['clientMail']);
        $ok = false;

        //SI LE TABLEAU CONTIENT UN ELEMENT
        //ON VERIFIE QUE LE MOT DE PASSE FOURNI (POST) CORRESPOND AU MOT DE PASSE CRYPTE DANS LA BASE DE DONNEES
        //SI TOUT EST BON ON PASSE LE BOOLEEN ok A TRUE
        if (count($tclient) == 1) {
            $client = $tclient[0];
            if (password_verify($_POST['clientPassword'], $client->getClientPassword())) {
                $ok = true;
            }
        }

        //SI ok EST FALSE, ON RETOURNE UN MESSAGE D'ERREUR
        if (!$ok) {
            return "LE LOGIN EST ERRONE";
        }
        //SINON ON MET LE CLIENT EN SESSION ET ON APPELLE LA FONCTION QUI PERMETTRA
        //DE L'AFFICHER DANS "Layout'
        else {
            $_SESSION["client"] = [
                "id" => $client->getClientId(),
                "prenom" => $client->getClientPrenom(),
                "nom" => $client->getClientNom(),
                "role" => $client->getClientRole()
            ];
            return $this->afficherClients($tclient);
        }
    }
}