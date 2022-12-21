<?php
require_once('../utilitaires/FonctionsUtiles.php');
require_once('../models/Commande.php');
require_once('DaoClient.php');
require_once('DaoLigneCommande.php');
require_once('../config/config.php');

class DaoCommande
{
    //ATTRIBUT DE LA CLASSE DaoProduit
    private $maConnection;

    //CONSTRUCTEUR DE LA CLASSE DaoProduit
    public function __construct()
    {
        //INSTANCIATION DE LA CONNEXION PAR APPEL AU CONSTRUCTEUR PDO ET VALORISATION DES ATTRIBUTS
        $this->maConnection = new PDO('mysql:host=' . HOST . ';dbname=' . DATABASE . ';charset=utf8;', USER, PASSWORD);
        //PARAMETRAGE POUR AFFICHAGE DES ERREURS RELATIVES A LA CONNEXION
        $this->maConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

//CETTE FONCTION PERMET DE CREER UNE NOUVELLE COMMANDE A PARTIR D UN PANIER EN SESSION
    function createCommande(): array
    {
        //ON INSERE UNIQUEMENT L ID DU CLIENT,  LA DATE DOIT ETRE RENSEIGNEE AUTOMATIQUEMENT PAR LA BASE DE DONNEES (CURRENT TIMESTAMP)
        $query = $this->maConnection->prepare("INSERT INTO commande(CLIENT_ID) VALUES (?)");
        $result = $query->execute(array(
            $_SESSION["client"]["id"]
        ));

        //ON RECUPERE L'ID DE LA NOUVELLE COMMANDE
        //POUR LE TRANSMETTRE A LA METHODE DE daoLignecCommande :  createLigneCommande($nouvelid);
        $nouvelid = $this->maConnection->lastInsertId();
        //ON INSTANCIE UN OBJET OUTIL de type  DaoLigneCommande
        // afin de pouvoir rattacher la commande à ses lignes de commandes
        $outilLigneCommande = new DaoLigneCommande();
        $outilLigneCommande->createLigneCommande($nouvelid);
        //ON VIDE LE PANIER POUR QU'IL PUISSE AFFICHER LA NOUVELLE COMMANDE
        unset($_SESSION["panier"]);
        //ON RETOURNE LA COMMANDE DANS UN TABLEAU AU CONTROLLER
        //LE CONTROLEUR VA APPELER LA FONCTION "afficherProduits"
        // et lui passer le tableau en parametre
        $tabCommandes = $this->getCommandeById($nouvelid);
        return $tabCommandes;

    }

    //CETTE FONCTION PREND EN ARGUMENT UN JEU DE RESULTATS DE BDD ET LE TRANSFORME EN ARRAY D OBJETS
    function resultToObjects($result) : array
    {   //ON RECUPERE LE RÉSULTAT DE LA REQUETE DANS UN TABLEAU
        //QUI CONTIENDRA 1 OU PLUSIEURS OBJETS DE TYPE COMMANDE

        //ON CREE UN TABLEAU QUI CONTIENDRA LES COMMANDES RECHERCHEES
        $lesCommandes = array();
        //ON INSTANCIE UN OBJET DE TYPE DaoClient
        $outilClient = new DaoClient();

        foreach ($result as $row) {

            //LA METHODE "getClientById" nous renvoie un objet de type client
            $client = $outilClient->getClientById($row['CLIENT_ID']);
            //ON ENVOIE LE CLIENT DANS LE CONSTRUCTEUR DE LA COMMANDE
            $commande = new Commande($row['COMMANDE_ID'], $client[0], $row['COMMANDE_DATE']);
            array_push($lesCommandes, $commande);
        }
        return $lesCommandes;
    }

    //CETTE METHODE PERMET DE TROUVER TOUTES LES COMMANDES DE LA BOUTIQUE
    function getAll(): array
    {
        $query = $this->maConnection->prepare("SELECT COMMANDE_ID,CLIENT_ID, COMMANDE_DATE
                                    FROM commande
                                    ORDER BY COMMANDE_ID");
        $query->execute();
        $result = $query->fetchAll();
        //ON TRANSFORME LE RESULTAT EN TABLEAU CONTENANT UN OU PLUSIEURS OBJETS DE TYPE PRODUIT
        return $this->resultToObjects($result);
    }

    //CETTE METHODE PERMET DE TROUVER UNE COMMANDE PAR SON ID
    function getCommandeById($id): array
    {
        $query = $this->maConnection->prepare("SELECT COMMANDE_ID,CLIENT_ID, COMMANDE_DATE
                                    FROM commande  WHERE COMMANDE_ID =?");
        $query->execute(array(
            $id));
        $result = $query->fetchAll();
        //ON TRANSFORME LE RESULTAT EN TABLEAU CONTENANT UN OU PLUSIEURS OBJETS DE TYPE PRODUIT
        return $this->resultToObjects($result);
    }

    //CETTE METHODE RECOIT EN PARAMETRE UN TABLEAU DE PRODUIT QUI PEUT ETRE NULL
//ELLE PEUT RECUPERER UN OU PLUSIEURS PRODUITS VIA LE FORMULAIRE DE RECHERCHE
//SINON ELLE AFFICHE PAR DEFAUT TOUT LE CATALOGUE
    function afficherCommandes($tabCommandes = null): string
    {
        //ON INSTANCIE UN OBJET DE TYPE LigneCommande afin de pouvoir afficher les produits commandés
        $outilLigneCommande = new DaoLigneCommande();
        //on déclare un tableau qui contiendra une ou plusieurs commandes
        $lesCommandes = array();
        $search = false;

        //SI UN TABLEAU EST ENVOYE EN PARAMETRE
        if ($tabCommandes != null) {
            $lesCommandes = $tabCommandes;
            $search = true;
        }
        //On vérifie si il y a eu une recherche commande de postée via le MENU SELECT
        if (!empty($_POST['commandeId'])) {
            //ON VA CHERCHER LA COMMANDE CORRESPONDANT A L ID EN PARAMETRE  */
            $lesCommandes = $this->getCommandeById($_POST['commandeId']);
            $search = true;
        }
        //SINON ON AFFICHE TOUTES LES COMMANDES
        if ($search == false) {
            $lesCommandes = $this->getAll();
        }

        //ON AFFICHE LE HTML POUR LE FICHIER "AfficherCommandes"
        $contenu =
            "<section id='slogan'>
        <h2>Liste des Commandes</h2></div></section>";
        foreach ($lesCommandes as $commande) {
            $contenu .= "<article class='article'>
                <h3> Commande n° " . $commande->getCommandeId() . "  du : " . dateEnClair($commande->getCommandeDate()) . " <br>(Client  : " . $commande->getClient()->getClientPrenom() . " " . $commande->getClient()->getClientNom() . " )</h3>
          <br><h3> Total de la commande :   " . $commande->getTotal() . " EUROS </h3>
             <br>";
            //ON APPELLE LA FONCTION afficherLigneCommandes() DU DaoLigneCommande POUR AFFICHER LES PRODUITS COMMANDES
            $detailCommande = $outilLigneCommande->afficherLigneCommandes($commande->getCommandeId());
            $contenu .= $detailCommande;
            $contenu .= "</article>";
        }
        return $contenu;
    }

//CETTE FONCTION PERMET D'AFFICHER UN FORMULAIRE DE RECHERCHE DE COMMANDES
    function rechercheCommande(): string
    {   //ON APPELLE LA FONCTION QUI VA FAIRE LA REQUETE AUPRES DE LA BASE DE DONNEES
        //CETTE FONCTION RENVOIE TOUS LES COMMANDES SOUS FORME DE TABLEAU D'OBJETS
        $lesCommandes = $this->getAll();
        $recherche = "
<form name='searchProduct' action='#' method='post' class='search-form'>
     <label for='commandeId' hidden></label>
    <select name='commandeId' id='commandeId' class='header-select' onchange='this.form.submit()'>
        <option value=''>Choisir une commande </option>";
        foreach ($lesCommandes as $commande) {
            $recherche .= "<option value=" . $commande->getCommandeId() . ">" . $commande->getCommandeId() . ' ' . "</option>";
        }
        $recherche .= "</select>
</form>";
        return $recherche;
    }
}