<?php include("header.php"); ?>
<main>
    <section id='slogan'>
        <h2>Contenu du panier</h2></div ></section>
    <section style="display: flex; align-items: center; flex-direction: column;">

        <article style="border:black solid; width: 40%;height: 50vh;border-radius: 25px;">
            <?php
            if (isset($contenu)) {
                echo "<div class='panier scroller'>$contenu</div>";
            }
            ?>
         </article>

    </section>
</main>
<footer>
    <small>&copy; 2022 - boutiquebasique</small>
</footer>
</body>
</html>
