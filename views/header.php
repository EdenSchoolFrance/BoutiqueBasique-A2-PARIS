<?php @session_start();
require_once('../config/config.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"> <!--Meta-->
    <meta name="description" content="">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../assets/css/header.css">
    <title></title>
    <link rel="stylesheet" href="../assets/css/normalize.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/pokedex.css">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

</head>
<body>
<header>
    <a href="../index.php"><img src="../assets/img/house-solid.svg" alt="house" id="house"></a>
    <a href="#" id="linkTop"><img src="../assets/img/up.png" alt="#" id="arrowTop"></a>
    <?php
    if (!isset($_SESSION["client"])) {
        echo '<a href="../views/Login.php"><img src="../assets/img/profil.png" alt="#" id="profil"></a>';
    } else {
        if (isset($_SESSION["panier"])) {
            $nbarticle = array_sum($_SESSION["panier"]["qte"]);
            echo '<div class="qte">' . $nbarticle . '</div>';
        }
        echo '<a href="../controllers/Controller.php?todo=montrerPanier"><img src="../assets/img/panier.svg" alt="voir mon panier" id="profil"></a>';
    }
    ?>
    <h1>BoutiqueBasique c'est fantastique !</h1>
    <div class='login'>
        <?php
        if (isset($_SESSION["client"])) {
            echo "Bienvenue " . $_SESSION["client"]["prenom"];
            echo " <a href='../controllers/Controller.php?todo=deconnexion'>déconnexion</a>";
        }
        ?>
    </div>
    <nav>
        <ul>
            <?PHP

            if (isset($_SESSION["client"])) {
                if ($_SESSION["client"]['role'] == "ADMIN") {

                    echo "<li>
                <a href='../controllers/Controller.php?todo=creerClient'>NOUVEAU CLIENT</a>
            </li>
            <li>
                <a href='../controllers/Controller.php?todo=afficherClients'>CLIENTS</a>
            </li>
            <li>
                <a href='../controllers/Controller.php?todo=creerProduit'>NOUVEAU PRODUIT</a>
            </li>
            <li>
                <a href='../controllers/Controller.php?todo=afficherCommandes'>COMMANDES</a>
            </li>";
                } else {
                    echo "<li>
                    <a href='../controllers/Controller.php?todo=afficherClients'>VOIR MON COMPTE</a>
                      </li>";
                }
            }
            ?>
            <li>
                <a href='../controllers/Controller.php?todo=afficherProduits'>PRODUITS</a>
            </li>
        </ul>
    </nav>
</header>
