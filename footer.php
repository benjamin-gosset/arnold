        <a href="#top" class="back-top">&wedge;<span class="sr-only">Haut de page</span></a>
    </main>
    <?php wp_footer(); ?>
    <footer role="contentinfo">
        <div class="footer__cols container">
            <div class="footer__about">
                <a href="<?php echo site_url(); ?>">
                    <svg role="img" aria-label="Benjamin Gosset - Accueil" class="normal logo">
                        <use xlink:href="#logo-bg-head" />
                    </svg>
                </a>
                <p class="h4">Benjamin Gosset</p>
                <p class="baseline">Développeur WordPress <br>freelance situé à Caen</p>
                <a href="mailto:contact@benjamin-gosset.fr">contact@benjamin-gosset.fr</a>
                <div class="social-links">
                    <a href="https://twitter.com" target="_blank">
                        <svg role="img" aria-label="Compte Twitter de Benjamin Gosset (nouvelle fenêtre)">
                            <use xlink:href="#twitter" />
                        </svg>
                    </a>
                    <a href="https://linkedin.com" target="_blank">
                        <svg role="img" aria-label="Compte LinkedIn de Benjamin Gosset (nouvelle fenêtre)">
                            <use xlink:href="#linkedin-icon" />
                        </svg>
                    </a>
                    <a href="https://wordpress.org" target="_blank">
                        <svg role="img" aria-label="Profil WordPress de Benjamin Gosset (nouvelle fenêtre)">
                            <use xlink:href="#wordpress-icon" />
                        </svg>
                    </a>
                    <a href="https://github.com" target="_blank">
                        <svg role="img" aria-label="Compte GitHub de Benjamin Gosset (nouvelle fenêtre)">
                            <use xlink:href="#github-icon" />
                        </svg>
                    </a>
                </div>
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
        </div>
        <div class="footer__bottom-bar">
            <p>Benjamin Gosset - <?php echo date('Y'); ?> - Fièrement propulsé par 
                <a href="https://wordpress.org" target="_blank" aria-label="Site de WordPress (nouvelle fenêtre)">WordPress 
                    <svg role="img" aria-label="">
                        <use xlink:href="#external-link" />
                    </svg>
                </a>
            </p>
        </div>
    </footer>
</body>
</html>