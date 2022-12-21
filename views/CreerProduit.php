<?php include("header.php");?>
<main>

    <article id="slogan">
        <h2> FORMULAIRE DE CRÉATION D'UN PRODUIT </h2>
    </article>
    <section id='section'>
        <form action="../controllers/Controller.php" method="post" id="formCreate">
            <input type='hidden' name='todo' value='creerProduit'>
            <div>
                <label for="produitNom">nom du produit</label>
                <input type="text" name="produitNom" required id="produitNom">
            </div>
            <div>
                <label for="produitPrix">prix du produit</label>
                <input type="text" name="produitPrix" required id="produitPrix">
            </div>
            <div>
                <label for="produitImage">image du produit</label>
                <input type="file" name="produitImage" id="produitImage">
            </div>
            <div>
                <input type="submit" name="submitCreerProduit" id="submit">
            </div>
        </form>
    </section>
</main>
<footer>
    <small>&copy; 2022 - boutiquebasique</small>
</footer>
</body>
</html>