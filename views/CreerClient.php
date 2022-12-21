<?php include("header.php"); ?>
<main>

    <article id="slogan">
        <h2> FORMULAIRE DE CRÉATION D'UN CLIENT </h2>
    </article>
        <section id='section'>
            <form action="../controllers/Controller.php" method="post" id="formCreate">
                <input type='hidden' name='todo' value='creerClient'>
                <div>
                    <label for="clientPrenom">Prénom du client</label>
                    <input type="text" name="clientPrenom" required id="clientPrenom">
                </div>
                <div>
                    <label for="clientNom">Nom du client</label>
                    <input type="text" name="clientNom" required id="clientNom">
                </div>
                <div>
                    <label for="clientNaissance">Date de naissance du client</label>
                    <input type="date" name="clientNaissance" id="clientNaissance">
                </div>

                <div>
                    <label for="clientMail">Adresse mail</label>
                    <input type="email" name="clientMail" id="clientMail" required">
                </div>
                <div>
                    <label for="clientPassword"> Mot de passe</label>
                    <input type="password" name="clientPassword" id="clientPassword" required">
                </div>

                <div>
                    <input type="submit" name="submitCreerClient" id="submit">
                </div>
            </form>
        </section>
</main>
<footer>
    <small>&copy; 2022 - boutiquebasique</small>
</footer>
</body>
</html>