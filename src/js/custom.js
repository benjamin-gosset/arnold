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

// Leaflet Map
const leafletMap = document.querySelector('#contact-map');
if ( typeof( leafletMap ) != 'undefined' && leafletMap != null ) {
    var map = L.map('contact-map').setView([49.18276, -0.37017], 12);
    
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox/dark-v10',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'pk.eyJ1IjoiYmVuamFtaW5nb3NzZXQiLCJhIjoiY2s2cGVlemFqMWRkZTNmbGlleGM3aHcxcyJ9.6maugSRBLdjsEhYFc0KNtg'
    }).addTo(map);
}