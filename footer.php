        <a href="#top" class="back-top">&wedge;<span class="sr-only">Haut de page</span></a>
    </main>
    <?php wp_footer(); ?>
    <footer role="contentinfo">
        <div class="footer__cols container">
            <div class="footer__about">
                <a href="<?php echo site_url(); ?>">
                    <svg role="img" aria-label="Benjamin Gosset - Accueil" class="normal">
                        <use xlink:href="#logo-bg-head" />
                    </svg>
                </a>
                <p class="h2">Benjamin Gosset</p>
                <p>Développeur WordPress <br>freelance situé à Caen</p>
                <a href="mailto:contact@benjamin-gosset.fr">contact@benjamin-gosset.fr</a>
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
            <div class="footer__social">
                <p class="footer__menu__title">Ailleurs sur le web</p>
                <?php wp_nav_menu( array(
                    'menu' => 'Footer menu 3',
                    'theme_location' => 'footer-menu-3'
                ));
                ?>
            </div>
        </div>
        <div class="footer__bottom-bar">
            <p>Benjamin Gosset - <?php echo date('Y'); ?> - Fièrement propulsé par <a href="https://wordpress.org">WordPress</a></p>
        </div>
    </footer>
</body>
</html>