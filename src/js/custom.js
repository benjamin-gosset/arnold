// Hamburger Nav
const navButton = document.querySelector('.header__toggle');
const navMenu = document.querySelector('.main-nav');
const navCtaButton = document.querySelector('.header__cta');
let buttonAttribute = navButton.getAttribute('aria-expanded');

navButton.onclick = () => {
    navMenu.classList.toggle('is-active');
    navCtaButton.classList.toggle('is-active');
    if ( buttonAttribute == 'true' ) {
        buttonAttribute = 'false';
    } else {
        buttonAttribute = 'true';
    }
    navButton.setAttribute('aria-expanded', buttonAttribute);
}
