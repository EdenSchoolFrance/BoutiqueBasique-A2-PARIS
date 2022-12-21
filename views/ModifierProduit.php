<?php include("header.php");?>
<main>
    <H2>
        FORMULAIRE DE MODIFICATION D'UN PRODUIT
    </H2>
    <section id='section'>
        <div class='container'>
            <img src="../assets/img/<?php echo $produit->getProduitImage() ?>" alt="">
        </div>
        <form action='../controllers/Controller.php' method="post" id="formCreate">
            <input type='hidden' name='todo' value='modifierProduit'>
            <input type="hidden" name="produitId" value="<?php echo $produit->getProduitId() ?>">
            <div>
                <label for="produitNom">Nom du Produit</label>
                <input type="text" name="produitNom" value="<?php echo $produit->getProduitNom() ?>" required id="produitNom">
            </div>
            <div>
                <label for="produitPrix">Prix du Produit</label>
                <input type="text" name="produitPrix" value="<?php echo $produit->getProduitPrix() ?>" required id="produitPrix">
            </div>

            <div>
                <input type="hidden" name="produitImage" value="<?php echo $produit->getProduitImage() ?>" id="produitImage">
                <label for="newImage">Changer l'image du Produit</label>
                <input type="file" name="newImage" value="img">
            </div>
            <div>
                <input type="submit" name="submitModifierProduit" value="MODIFIER LE PRODUIT" id="submit">
            </div>
        </form>
        <form action='../controllers/Controller.php' method="post" id="formDelete">
            <input type='hidden' name='todo' value='supprimerProduit'>
            <input type="hidden" name="produitId" value="<?php echo $produit->getProduitId() ?>">
            <button type="submit" name="submitSupprimerProduit" id="delete"
                    onclick="return confirm('Êtes-vous sur de vouloir supprimer ce produit ?')">
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