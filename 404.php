<?php get_header(); ?>

<div class="container">
    <?php
        $error_img = get_template_directory_uri() . '/dist/img/error.png';
    ?>
    <img src="<?php echo $error_img; ?>" alt="">
    <p class="h3">Oups, ceci est une erreur dite 404 ! La page ne peut être trouvée... </p>
    <p><a href="<?php echo site_url(); ?>">Un retour à l'accueil vous aidera certainement à retrouver votre chemin</a></p>
</div>

<?php get_footer(); ?>