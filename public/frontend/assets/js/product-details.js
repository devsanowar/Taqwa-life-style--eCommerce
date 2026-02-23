document.addEventListener('DOMContentLoaded', function() {

    const galleryMainEl = document.querySelector('.product__media--preview.swiper');
    const galleryThumbsEl = document.querySelector('.product__media--nav.swiper');

    if(galleryMainEl && galleryThumbsEl) {

        const galleryThumbs = new Swiper(galleryThumbsEl, {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
            slideToClickedSlide: true,
            loop: false,
        });

        const galleryMain = new Swiper(galleryMainEl, {
            spaceBetween: 10,
            loop: false,             
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            thumbs: {
                swiper: galleryThumbs
            }
        });
    }

    // Lightbox init
    const lightbox = GLightbox({
        selector: '.glightbox',
        touchNavigation: true,
        loop: true,
    });


    // category accordion

     customAccordion(
            ".accordion__container",
            ".accordion__items",
            ".accordion__items--body"
        );

        customAccordion(
            ".widget__categories--menu",
            ".widget__categories--menu__list",
            ".widget__categories--sub__menu"
        );

});


document.addEventListener('DOMContentLoaded', function() {
    const minicart = document.querySelector('.offCanvas__minicart');
    if (!minicart) return;

    // Open minicart
    document.body.addEventListener('click', function(e) {
        const openBtn = e.target.closest('.minicart__open--btn');
        if(openBtn) {
            minicart.classList.add('is-visible');
            e.preventDefault();
        }
    });

    // Close minicart on close button
    const closeBtn = minicart.querySelector('.minicart__close--btn');
    if(closeBtn) {
        closeBtn.addEventListener('click', function(e) {
            minicart.classList.remove('is-visible');
        });
    }

    // Close minicart on outside click
    document.addEventListener('click', function(e) {
        if(minicart.classList.contains('is-visible')) {
            // check if click is outside minicart
            if(!e.target.closest('.offCanvas__minicart') &&
               !e.target.closest('.minicart__open--btn')) {
                minicart.classList.remove('is-visible');
            }
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // Open/close offcanvas menu
    const menuOpenBtn = document.querySelector('.offcanvas__header--menu__open--btn');
    const menuCloseBtn = document.querySelector('.offcanvas__close--btn');
    const menu = document.querySelector('.offcanvas__header');

    if(menuOpenBtn){
        menuOpenBtn.addEventListener('click', () => {
            menu.classList.add('open');
        });
    }

    if(menuCloseBtn){
        menuCloseBtn.addEventListener('click', () => {
            menu.classList.remove('open');
        });
    }

    // Handle submenu toggle
    const menuItems = document.querySelectorAll('.offcanvas__menu_li > .offcanvas__menu_item');

    menuItems.forEach(item => {
        const submenu = item.nextElementSibling;
        if(submenu && submenu.classList.contains('offcanvas__sub_menu')){
            // Add toggle class to main link
            item.classList.add('toggle');

            // Click to open/close submenu
            item.addEventListener('click', (e) => {
                e.preventDefault(); // prevent page reload
                submenu.style.display = (submenu.style.display === 'block') ? 'none' : 'block';
                item.classList.toggle('open');
            });
        }
    });

    // Optional: handle nested submenus recursively
    const nestedSubmenus = document.querySelectorAll('.offcanvas__sub_menu_li > .offcanvas__sub_menu_item');
    nestedSubmenus.forEach(item => {
        const submenu = item.nextElementSibling;
        if(submenu && submenu.classList.contains('offcanvas__sub_menu')){
            item.classList.add('toggle');
            item.addEventListener('click', (e) => {
                e.preventDefault();
                submenu.style.display = (submenu.style.display === 'block') ? 'none' : 'block';
                item.classList.toggle('open');
            });
        }
    });
});
