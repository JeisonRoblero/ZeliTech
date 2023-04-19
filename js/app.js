navSlide = () => {
    const burger = document.querySelector('.burger');
    const nav = document.querySelector('.menu');
    const navLinks = document.querySelectorAll('.menu a');

    burger.addEventListener('click', () => {
        //Toggle Nav
        nav.classList.toggle('menu-active');

        //Animate Links
        navLinks.forEach((link, index) => {
            if(link.style.animation) {
                link.style.animation = '';
            } else {
                link.style.animation = `navLinkFade 0.5s ease forwards ${index / 7 + 0.3}s`;
            }
        });

        //Burger Animation
        burger.classList.toggle('toggle');
    });
}

navSlide();

/* 
window.addEventListener('load', () => {
    const loader = document.querySelector('.contenedor-loader');
    loader.style.opacity = 0;
    loader.style.visibility = 'hidden';
}); */


var slideUp = {
    distance: '150%',
    origin: 'bottom',
    opacity: null
};

ScrollReveal().reveal('.producto', slideUp);


window.addEventListener('load', () => {
    setTimeout(function(){
        const loader = document.querySelector('.loader');
        loader.style.opacity = 0;
        loader.style.visibility = 'hidden';
    }, 0);
});



