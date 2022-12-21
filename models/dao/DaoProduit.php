<?php
require_once('../models/Produit.php');
require_once('../utilitaires/FonctionsUtiles.php');
require_once('../config/config.php');
//*********************************************** PRODUIT PRODUIT PRODUIT
//*********************************************** PRODUIT PRODUIT PRODUIT
//*********************************************** PRODUIT PRODUIT PRODUIT

class DaoProduit
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

//CETTE FONCTION PERMET DE CREER UN NOUVEAU PRODUIT
    function createProduit(): array
    {
        //ON INSTANCIE UN PRODUIT EN PASSANT DANS LE CONSTRUCTEUR LES VALEURS POSTEES VIA LE FORMULAIRE DE CREATION D UN PRODUIT
        $produit = new Produit(0, $_POST['produitNom'], $_POST['produitPrix'], $_POST['produitImage']);

        //ON UTILISE LA METHODE prepare() de PDO POUR FAIRE UNE REQUETE PARAMETREE
        $query = $this->maConnection->prepare("INSERT INTO produit(PRODUIT_NOM, PRODUIT_PRIX, PRODUIT_IMAGE) VALUES (?, ?, ?)");
        $result = $query->execute(array(
            $produit->getProduitNom(),
            $produit->getProduitPrix(),
            $produit->getProduitImage()
        ));
        //ON RECUPERE LID DU NOUVEAU PRODUIT
        $produit->setProduitId($this->maConnection->lastInsertId());
        //ON RETOURNE LE PRODUIT DANS UN TABLEAU AU CONTROLLER
        //LE CONTROLEUR VA APPELER LA FONCTION "afficherProduits"
        // et lui passer le tableau en parametre
        $tabProduits = array();
        array_push($tabProduits, $produit);
        return $tabProduits;
    }


//CETTE FONCTION PERMET DE METTRE A JOUR UN PRODUIT
//ELLE RENVOIT LE PRODUIT MODIFIE AU CONTROLLEUR DANS UN TABLEAU
    function updateProduit(): array
    {
        if (empty($_POST['newImage'])) {
            $image = $_POST['produitImage'];
        } else {
            $image = $_POST['newImage'];
        }

        //ON INSTANCIE UN PRODUIT EN PASSANT DANS LE CONSTRUCTEUR LES VALEURS POSTEES VIA LE FORMULAIRE DE CREATION D UN PRODUIT
        $produit = new Produit($_POST['produitId'], $_POST['produitNom'], $_POST['produitPrix'], $image);

        //ON UTILISE LA METHODE prepare() de PDO POUR FAIRE UNE REQUETE PARAMETREE
        $query = $this->maConnection->prepare("UPDATE produit SET PRODUIT_NOM=?, PRODUIT_PRIX=?, PRODUIT_IMAGE=? WHERE PRODUIT_ID=?");
        $result = $query->execute(array(
            $produit->getProduitNom(),
            $produit->getProduitPrix(),
            $produit->getProduitImage(),
            $produit->getProduitId()
        ));
        //ON RETOURNE LE PRODUIT DANS UN TABLEAU AU CONTROLLER
        //LE CONTROLEUR VA APPELER LA FONCTION "afficherProduits"
        // et lui passer le tableau en parametre
        $tabProduits = array();
        array_push($tabProduits, $produit);
        return $tabProduits;
    }

    //CETTE FONCTION PERMET DE SUPPRIMER UN PRODUIT
    function deleteProduit(): void
    {
        $query = $this->maConnection->prepare("DELETE FROM produit WHERE PRODUIT_ID =?");
        $query->execute(array($_POST['produitId']));
    }

    //CETTE FONCTION PREND EN ARGUMENT UN JEU DE RESULTATS DE BDD ET LE TRANSFORME EN ARRAY D OBJETS DE TYPE PRODUITS
    function resultToObjects($result): array
    {   //ON RECUPERE LE RÉSULTAT DE LA REQUETE DANS UN TABLEAU
        //QUI CONTIENDRA 1 OU PLUSIEURS OBJETS DE TYPE PRODUIT
        $listProduits = array();
        foreach ($result as $row) {
            $produit = new Produit($row['PRODUIT_ID'], $row['PRODUIT_NOM'], $row['PRODUIT_PRIX'], $row['PRODUIT_IMAGE']);
            array_push($listProduits, $produit);
        }
        return $listProduits;
    }

    //CETTE METHODE PERMET DE TROUVER UN PRODUIT PAR SON ID
    function getProduitById($id): array
    {
        $query = $this->maConnection->prepare("SELECT PRODUIT_ID, PRODUIT_NOM,PRODUIT_PRIX ,PRODUIT_IMAGE FROM produit WHERE PRODUIT_ID =?");
        $query->execute(array(
            $id));
        $result = $query->fetchAll();
        //ON TRANSFORME LE RESULTAT EN TABLEAU CONTENANT UN OU PLUSIEURS OBJETS DE TYPE PRODUIT
        return $this->resultToObjects($result);
    }

    //CETTE METHODE PERMET DE TROUVER UN PRODUIT PAR CRITERE DE PRIX
    function getProduitByPrix($prix): array
    {
        $query = $this->maConnection->prepare("SELECT PRODUIT_ID, PRODUIT_NOM,PRODUIT_PRIX ,PRODUIT_IMAGE FROM produit WHERE PRODUIT_PRIX <?");
        $query->execute(array(
            $prix));
        $result = $query->fetchAll();
        //ON TRANSFORME LE RESULTAT EN TABLEAU CONTENANT UN OU PLUSIEURS OBJETS DE TYPE PRODUIT
        return $this->resultToObjects($result);
    }

    //CETTE METHODE PERMET DE TROUVER UN PRODUIT PAR CRITERE DE PRIX
    function getAll(): array
    {
        $query = $this->maConnection->prepare("SELECT PRODUIT_ID, PRODUIT_NOM,PRODUIT_PRIX ,PRODUIT_IMAGE FROM produit");
        $query->execute();
        $result = $query->fetchAll();
        //ON TRANSFORME LE RESULTAT EN TABLEAU CONTENANT UN OU PLUSIEURS OBJETS DE TYPE PRODUIT
        return $this->resultToObjects($result);
    }



//*******************************************************************************************
//*******************************************************************************************
//*******************************************************************************************
//*******************************************************************************************
//*******************************************************************************************
//CETTE METHODE PERMET D'AFFICHER UN OU PLUSIEURS PRODUITS
//ELLE RECOIT EN PARAMETRE UN TABLEAU DE PRODUIT QUI PEUT ETRE NULL
//ELLE PEUT RECUPERER UN OU PLUSIEURS PRODUITS VIA LE FORMULAIRE DE RECHERCHE
//SINON ELLE AFFICHE PAR DEFAUT TOUT LE CATALOGUE
    function afficherProduits($tabProduits = null): string
    {
        $search = false;
        $lesProduits = array();
        //SI UN TABLEAU EST ENVOYE EN PARAMETRE
        if ($tabProduits != null) {
            $lesProduits = $tabProduits;
            $search = true;
        }
        //SI UNE RECHERCHE PAR PRIX A ETE EFFECTUEE
        if (!empty($_POST['prixProduit'])) {
            /* récupérer les données du formulaire en utilisant
               la valeur des attributs name comme clé */
            $lesProduits = $this->getProduitByPrix($_POST['prixProduit']);
            $search = true;
        }
        //SI UNE RECHERCHE PAR NOM DE PRODUIT A ETE EFFECTUEEE
        if (!empty($_POST['produitId'])) {
            /* récupérer les données du formulaire en utilisant
                la valeur des attributs name comme clé
               */
            $lesProduits = $this->getProduitById($_POST['produitId']);
            $search = true;
        }

        //SINON ON AFFICHE TOUT LE CATALOGUE
        if ($search == false) {
            //ON AFFICHE TOUS LES PRODUITS
            $lesProduits = $this->getAll();
        }
        //SUITE A LA SUPPRESSION D UN PRODUIT ON REAFFICHE TOUT LE CATALOGUE
        if ((isset($_POST['todo'])) && ($_POST['todo'] == "supprimerProduit")) {
            //ON AFFICHE TOUS LES PRODUITS
            $lesProduits = $this->getAll();
        }

        //ON CONSTRUIT LE HTML POUR AFFICHER LE OU LES PRODUITS
        $contenu =
            "<section id='slogan'>
        <h2>Catalogue Produits</h2></div ></section><div id='menu'>";

        foreach ($lesProduits as $produit) {
            $id = $produit->getProduitId();
            $contenu .= "<article class='article' >";
            if (isset($_SESSION["client"])) {
                $contenu .= " <a href = '../controllers/Controller.php?todo=ajouterAuPanier&produitId=$id'>AJOUTER AU PANIER</a> ";
            }

            $contenu .= "<div class='container' ><img class='image' src = '../assets/img/" . $produit->getProduitImage() . " ' alt=''></div >
             <h2 > " . $produit->getProduitNom() . "</h2 >
             <p > " . $produit->getProduitPrix() . " EUROS </p >
            <br>";

            if (isset($_SESSION["client"])) {
                if ($_SESSION["client"]['role'] == "ADMIN") {
                    $contenu .= "<button id='submit'>
                <a href = '../controllers/Controller.php?todo=modifierProduit&id=$id' > MODIFIER LE PRODUIT </a>
            </button>";
                }
            }

            $contenu .= "</article > ";
        }
        //ON RENVOIE LE HTML AU CONTROLEUR QUI VA LE TRANSMETTRE A LA VUE
        return $contenu;
    }

//CETTE METHODE PERMET D'AFFICHER UN FORMULAIRE DE RECHERCHE DE PRODUITS
    function rechercheProduit(): string
    {    //ON APPELLE LA METHODE QUI VA FAIRE LA REQUETE AUPRES DE LA BASE DE DONNEES
        //CETTE METHODE RENVOIE TOUS LES PRODUITS SOUS FORME DE TABLEAU D'OBJETS
        //POUR AFFICHER LES NOMS DES PRODUITS DANS LE SELECT
        $lesProduits = $this->getAll();

        //ON CONSTRUIT LE HTML POUR LE FICHIER "ModifierProduit"
        $recherche = "<form name='searchProduct' action='#' method='post' class='search-form'>

    <label for='nomProduit' hidden></label>
    <select name='produitId' id='nomProduit' class='header-select' onchange='this.form.submit()'>
        <option value=''>Choisir un produit</option>";

        foreach ($lesProduits as $produit) {
            $recherche .= "<option value=" . $produit->getProduitId() . ">" . $produit->getProduitNom() . "</option>";
        }

        $recherche .= "</select>
   <label for='prixProduit' hidden></label>
 <select name='prixProduit' id='prixProduit' class='header-select' onchange='this.form.submit()'>
                            <option value='' >choisir un prix</option>
                            <option value='50'  >Moins de 50 euros</option>
                            <option value='100' >Moins de 100 euros</option>
                            <option value='200' >Moins de 200 euros</option>
                            <option value='300' >Moins de 300 euros</option>
                            <option value='500' >Moins de 500 euros</option>
                            <option value='800' >Moins de 800 euros</option>
                            <option value='1000' >Moins de 1000 euros</option>
                            <option value='2000' >Moins de 2000 euros</option>
                           <option value='5000' >Moins de 5000 euros</option>  
                         </select>
</form>";
        return $recherche;
    }

//CETTE METHODE PREND EN GET DANS L URL UN ID PRODUIT
//ET RENVOIE PRODUIT
    function afficherFormModif(): Produit
    {
        //ON APPELLE LA METHODE QUI VA FAIRE LA REQUETE AUPRES DE LA BASE DE DONNEES
        //CETTE METHODE RENVOIE UN TABLEAU CONTENANT LE PRODUIT A MODIFIER
        //ON RETOURNE CET OBJET PRODUIT AU CONTROLEUR QUI A APPELLE LA METHODE
        //LE CONTROLEUR RETOURNERA L'OBJET A LA VUE "ModifierProduit";
        return $this->getProduitById($_GET['id'])[0];
    }

//CETTE METHODE PERMET D AJOUTER UN PRODUIT AU PANIER EN SESSION
    function ajouterAuPanier(): void
    {
        $rajoute = false;
        /* On vérifie l'existence du panier, si il n'existe pas, on le crée */
        if (!isset($_SESSION['panier'])) {
            /* Initialisation du panier */
            $_SESSION['panier'] = array();
            /* Subdivision du panier */
            $_SESSION['panier']['produitId'] = array();
            $_SESSION['panier']['qte'] = array();
        }
        //SI LE PANIER EXISTE DEJA
        //ON vérifie si l'article existe déjà on modifie juste la quantité
        /* On parcourt le panier en session pour modifier l'article précis. */
        for ($i = 0; $i < count($_SESSION['panier']['produitId']); $i++) {
            //SI L'ARTICLE EST DEJA DANS LE PANIER ON AUGMENTE LA QUANTITE
            if (isset($_GET['produitId'])) {
                if ($_GET['produitId'] == $_SESSION['panier']['produitId'][$i]) {
                    $_SESSION['panier']['qte'][$i] = $_SESSION['panier']['qte'][$i] + 1;
                    $rajoute = true;
                }
            }
        }
        //Si le produit n'existe pas encore dans le panier, on le rajoute
        if (!$rajoute) {
            //Rajout d'un produit dans le panier
            array_push($_SESSION['panier']['produitId'], $_GET['produitId']);
            array_push($_SESSION['panier']['qte'], 1);
        }
    }

//AFFICHER LE CONTENU D'UN PANIER
//CETTE FONCTION RENVOIE L'AFFICHAGE DU PANIER AVEC SON HTML
    function afficherPanier(): string
    {
        $contenu = "";
        // SI LE PANIER CONTIEN AU MOINS UN ARTICLE ON AFFICHE LE CONTENU
        if ((isset($_SESSION['panier'])) && (count($_SESSION['panier']['produitId']) > 0)) {
            $contenu .= "";
            //SI ON A AUGMENTE OU DIMINUE UNE QUANTITE D UN PRODUIT DANS LE PANIER
            if (isset($_POST['moreOrLess'])) {
                $_SESSION['panier']['qte'][$_POST['indice']] = $_SESSION['panier']['qte'][$_POST['indice']] + $_POST['moreOrLess'];
                //SI LA QUANTITE EST EGALE A ZERO ON ENLEVE LE PRODUIT DU PANIER
                if ($_SESSION['panier']['qte'][$_POST['indice']] == 0) {
                    array_splice($_SESSION['panier']["produitId"], $_POST['indice'], 1);
                    array_splice($_SESSION['panier']["qte"], $_POST['indice'], 1);
                    header("Location: ../controllers/Controller.php?todo=montrerPanier");
                }
            }
            //SI ON A CLIQUE SUR LE BOUTON "SUPPRIMER" DEVANT UN PRODUIT DANS LE PANIER
            //ON RETIRE LE PRODUIT ET ON REAFFICHE LE PANIER
            if (isset($_POST['supprimerProduit'])) {
                //array_splice($input, 0, 0, array($x, $y));
                array_splice($_SESSION['panier']["produitId"], $_POST['indice'], 1);
                array_splice($_SESSION['panier']["qte"], $_POST['indice'], 1);
                header("Location: ../controllers/Controller.php?todo=montrerPanier");
            }

            $prixTotal = 0;
            /* On parcourt le panier en session pour afficher chaque produit et sa quantite. */
            for ($i = 0; $i < count($_SESSION['panier']['produitId']); $i++) {

                $produit = $this->getProduitById($_SESSION['panier']['produitId'][$i])[0];
                $prixTotal += $produit->getProduitPrix() * $_SESSION['panier']['qte'][$i];

                $contenu .= "<div >
                                <h4><img src='../../assets/img/" . $produit->getProduitImage() . "' class='imgPanier'>
                                " . $produit->getProduitNom() . "</h4>
                                <h4>Prix : " . $produit->getProduitPrix() . "€  | Qté : " . $_SESSION['panier']['qte'][$i] . " | Total : " . $produit->getProduitPrix() * $_SESSION['panier']['qte'][$i] . " €</h4>
                                <div class='choiceQuantity'> 
                                    <form action='#' method='post' class='formProduit'>
                                    <input type='submit' name='moreOrLess' value='+1' class='InputProduit'>
                                    <input type='text' name='indice' value='$i' hidden>
                                    </form>
                                   
                                    <form action='#' method='post' class='formProduit'>
                                    <input type='text' name='indice' value='$i' hidden>
                                    <input type='submit'  name='moreOrLess' value='-1' class='InputProduit InputProduitlast'>
                                    </form>
   
                                    <form action='#' method='post' class='formProduit'>
                                    <input type='text' name='indice' value='$i' hidden>
                                    <input type='submit' class='supprimer' name='supprimerProduit' value='supprimer'>
                                    </form>
                            </div></div>";
            }
            $contenu .= "</div><h4 class='total'><DIV align='right'>Prix Total De La Commande: $prixTotal €</h4>
<form action='../controllers/Controller.php' method='post'><input type='text' name='todo' value='passerCommande' hidden><input type='submit' id='validerPanier' name='validerPanier' value='passer la commande'></form>";
        } else {
            $contenu = "VOTRE PANIER EST VIDE<br><a href='../controllers/Controller.php?todo=afficherProduits'>Commencer vos achats</a>
";
        }

        return $contenu;

    }
}


