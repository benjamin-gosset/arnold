        <a href="#top" class="back-top">&wedge;<span class="sr-only">Haut de page</span></a>
    </main>
    <?php wp_footer(); ?>
    <footer role="contentinfo">
        <div class="footer__about">
            <a href="<?php echo site_url(); ?>">
                <svg role="img" aria-label="Benjamin Gosset - Accueil" class="normal">
                    <use xlink:href="#logo-bg-head" />
                </svg>
            </a>
        </div>
        <div class="footer__nav">
            <p class="footer__menu__title">Expertises</p>
            <?php wp_nav_menu( array(
                'menu' => 'Footer menu 1',
                'theme_location' => 'footer-menu-1'
            ));
            ?>
        </div>
        <div class="footer__links">
            <p class="footer__menu__title">Liens utiles</p>
            <?php wp_nav_menu( array(
                'menu' => 'Footer menu 2',
                'theme_location' => 'footer-menu-2'
            ));
            ?>
        </div>
        <div class="footer__bottom-bar">
            <?php wp_nav_menu( array(
                'menu' => 'Footer bottom',
                'theme_location' => 'footer-bottom'
            ));
            ?>
        </div>
    </footer>
</body>
</html>