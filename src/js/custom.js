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

const subMenuBtn = document.querySelector('.menu-item-has-children button');
subMenuBtn.onclick = (e) => e.target.closest('.menu-item').classList.toggle('is-open');

// Swiper JS
const slider = document.querySelector('.swiper');
console.log( slider );
if ( typeof( slider ) != 'undefined' && slider != null ) {
    const swiper = new Swiper('.swiper', {
        direction: 'horizontal',
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        }
    });
}
