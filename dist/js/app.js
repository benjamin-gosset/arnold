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

/**
 * File skip-link-focus-fix.js.
 *
 * Helps with accessibility for keyboard only users.
 *
 * Learn more: https://git.io/vWdr2
 */
( function() {
	var isIe = /(trident|msie)/i.test( navigator.userAgent );

	if ( isIe && document.getElementById && window.addEventListener ) {
		window.addEventListener( 'hashchange', function() {
			var id = location.hash.substring( 1 ),
				element;

			if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
				return;
			}

			element = document.getElementById( id );

			if ( element ) {
				if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
					element.tabIndex = -1;
				}

				element.focus();
			}
		}, false );
	}
} )();
