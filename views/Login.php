<?php include("header.php"); ?>
<main>
    <article id="slogan">
        <h2> FORMULAIRE DE CONNEXION D'UN CLIENT
            <?php
            if (isset($contenu)) {
                echo "<div class='erreur'>$contenu</div>";
            }
            ?></h2>
    </article>
    <section id='section'>
        <form action="../controllers/Controller.php" method="post" id="formLogin">
            <input type='hidden' name='todo' value='seConnecter'>
            <div>
                <label for="clientMail">Entrez votre identifiant</label>
                <input type="text" name="clientMail" id="clientMail" required>
            </div>
            <div>
                <label for="clientPassword"> Entrez votre mot de passe</label>
                <input type="password" name="clientPassword" id="clientPassword" required>
            </div>
            <div>
                <input type="submit" name="submitLogin" value="CONNEXION" id="submit">
            </div>
        </form>
    </section>
</main>
<footer>
    <small>&copy; 2022 - boutiquebasique</small>
</footer>
</body>
</html>