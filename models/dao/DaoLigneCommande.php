<?php
require_once('../utilitaires/FonctionsUtiles.php');
require_once('../models/LigneCommande.php');
require_once('DaoCommande.php');
require_once('DaoProduit.php');

class DaoLigneCommande
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


//CETTE FONCTION PERMET DE TRANSFORMER UN PANIER EN SESSION EN LIGNES DE COMMANDE
    function createLigneCommande($commandeid) : void
    {
        /* On parcourt le panier en session pour insérer chaqune de ses lignes dans la base de données */
        for ($i = 0; $i < count($_SESSION['panier']['produitId']); $i++) {
            //ON INSTANCIE UN OBJET DE TYPE DaoProduit pour obtenir le prix du produit
            //CAR IL N'EST PAS EN SESSION
            $outilProduit = new DaoProduit();
            $produit = $outilProduit->getProduitById($_SESSION['panier']['produitId'][$i])[0];
            $query = $this->maConnection->prepare("INSERT INTO `LigneCommande`(`COMMANDE_ID`,`PRODUIT_ID`,`QUANTITE`,`PRIX`) values(?, ?, ?,?)");
            $result = $query->execute(array(
                $commandeid,
                $_SESSION['panier']['produitId'][$i],
                $_SESSION['panier']['qte'][$i],
                $produit->getProduitPrix()
            ));
        }
    }

    //CETTE FONCTION CALCULE LE TOTAL D'UNE COMMANDE
    function totalCommande($idCommande): float
    {
        $query = $this->maConnection->prepare("SELECT SUM(PRIX*QUANTITE) as total
                                    FROM LigneCommande 
                                    WHERE COMMANDE_ID =?");
        $query->execute(array(
            $idCommande));
        return  $query->fetch()[0];
    }

    //CETTE FONCTION PREND EN ARGUMENT UN JEU DE RESULTATS DE BDD ET LE TRANSFORME EN ARRAY D OBJETS
    function resultToObjects($result)
    {   //ON RECUPERE LE RÉSULTAT DE LA REQUETE DANS UN TABLEAU
        //QUI CONTIENDRA 1 OU PLUSIEURS OBJETS DE TYPE COMMANDE
        //ON CREE UN TABLEAU QUI CONTIENDRA LES LIGNES DE COMMANDES RECHERCHEES
        $lesLigneCommandes = array();
        //ON INSTANCIE UN OBJET DE TYPE DaoCommande
        $outilCommande = new DaoCommande();
        //ON INSTANCIE UN OBJET DE TYPE DaoProduit
        $outilProduit = new DaoProduit();

        foreach ($result as $row) {
                   //LA METHODE "getCommandeById" nous renvoie un objet de type Commande
            $commande = $outilCommande->getCommandeById($row['COMMANDE_ID'])[0];
            //LA METHODE "getProduitById" nous renvoie un objet de type Produit
            $produit = $outilProduit->getProduitById($row['PRODUIT_ID'])[0];
            //ON ENVOIE LE CLIENT DANS LE CONSTRUCTEUR DE LA COMMANDE
            $LigneCommande = new LigneCommande($commande, $produit, $row['QUANTITE'], $row['PRIX']);
            array_push($lesLigneCommandes, $LigneCommande);
        }
        return $lesLigneCommandes;
    }


    //CETTE METHODE PERMET DE TROUVER LES LIGNES DE COMMANDE D'UNE COMMANDE
    function getLigneCommandeByIdCommande($id): array
    {
        $query = $this->maConnection->prepare("SELECT COMMANDE_ID,PRODUIT_ID, QUANTITE, PRIX
                                    FROM LigneCommande 
                                    WHERE COMMANDE_ID =?");
        $query->execute(array(
            $id));
        $result = $query->fetchAll();
        //ON TRANSFORME LE RESULTAT EN TABLEAU CONTENANT UN OU PLUSIEURS OBJETS DE TYPE PRODUIT
        return $this->resultToObjects($result);
    }

    function afficherLigneCommandes($idCommande): string
    {
        //ON APPELLE LA FONCTION QUI VA FAIRE LA REQUETE AUPRES DE LA BASE DE DONNEES
        //CETTE FONCTION RENVOIE UN TABLEAU CONTENANT UN OU PLUSIEURS OBJETS DE TYPE LIGNEDECOMMANDE
        $lesLigneCommandes = $this->getLigneCommandeByIdCommande($idCommande);
        //ON AFFICHE LE HTML POUR LE FICHIER "AfficherLigneCommandes"
        $nbProduit = 1;
        $contenu =
            "
        <h3>Contenu de la commande</h3></section><br><div>";
        foreach ($lesLigneCommandes as $LigneCommande) {
            $contenu .= "
             <h4> " . $nbProduit . ")    " . $LigneCommande->getProduit()->getProduitNom() . "  **  Prix pièce: " . $LigneCommande->getPrix() . " EUROS  ** Qté : " . $LigneCommande->getQuantite() . "   ** Total : " . $LigneCommande->getTotal() . " EUROS</h4> 
             <br>";
            $nbProduit++;
        }
        $contenu .= "</div>";
        return $contenu;
    }

}

