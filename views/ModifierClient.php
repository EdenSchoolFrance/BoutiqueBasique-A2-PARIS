<?php include("header.php");?>
<main>
         <H2>
            FORMULAIRE DE MODIFICATION D'UN CLIENT
        </H2>
        <section id='section'>
            <div class='container'>
                <img src="../assets/img/<?php echo $client->getClientSigne() ?>" alt="">
            </div>

            <form action='../controllers/Controller.php' method="post" id="formCreate">
                <input type='hidden' name='todo' value='modifierClient'>

                <input type="hidden" name="clientId" value="<?php echo $client->getClientId() ?>">

                <div>
                    <label for="clientPrenom">Prenom du client</label>
                    <input type="text" name="clientPrenom" value="<?php echo $client->getClientPrenom() ?>" required id="clientPrenom">
                </div>
                <div>
                    <label for="clientNom">Nom du client</label>
                    <input type="text" name="clientNom" value="<?php echo $client->getClientNom() ?>" required id="clientNom">
                </div>

                <div>
                    <label for="clientNaissance">Changer la date de naissance</label>
                    <input type="date" name="clientNaissance" value="<?php echo $client->getClientNaissance() ?>" id="clientNaissance">
                </div>

                <div>
                    <label for="clientMail">Adresse mail</label>
                    <input type="email" name="clientMail" id="clientMail" value="<?php echo $client->getClientMail() ?>">
                </div>
                <div>
                    <label for="clientPassword"> Mot de passe</label>
                    <input type="text" name="clientPassword" id="clientPassword">
                </div>
                <div>
                <div>
                    <input type="submit" name="submitModifierClient" value="MODIFIER LE CLIENT" id="submit">
                </div>
            </form>
            <form action='../controllers/Controller.php' method="post" id="formDelete">
                <input type='hidden' name='todo' value='supprimerClient'>
                <input type="hidden" name="clientId" value="<?php echo $client->getClientId() ?>">
                <button type="submit" name="submitUpdateClient" id="delete"
                        onclick="return confirm('Êtes-vous sur de vouloir supprimer ce client ?')">
                    SUPPRIMER
                </button>
            </form>
    </section>

</main>
<footer>
    <small>&copy; 2022 - boutiquebasique</small>
</footer>


</body>
</html>