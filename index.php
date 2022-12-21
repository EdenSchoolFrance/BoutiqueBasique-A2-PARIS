<?PHP
//ini_set('sendmail_from','pauldupont@hotmail.com');
//ini_set('SMTP','smtp.orange.fr');
//ini_set('smtp_port',25 );
//echo (mail("sibylle.huez@gmail.com" , "coucou" , "HELLO WORLD" ));
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8"> <!--Meta-->
    <meta name="description" content="">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <title></title> <!--title of page-->
</head>
<body>
<header>
    <a href="index.php"><img src="assets/img/house-solid.svg" alt="house" id="house"></a>
    <h1>BoutiqueBasique c'est fantastique !</h1>
    <nav>
        <ul>
             <li>
                <a href='controllers/Controller.php?todo=afficherProduits'>Voir les produits</a>
            </li>

        </ul>
    </nav>
</header>
</body>
</html>