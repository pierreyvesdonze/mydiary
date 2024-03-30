var app = {

    init: () => {

        /**
        * *****************************
        * L I S T E N E R S
        * *****************************
        */
        /* $('.custom-btn').on('click', function(e) {
            if (!$(this).hasClass('no-load-anim')) {
                app.loadingAnim();
            }
        });

        app.closeLoadingAnim(); */

        console.log('JS is working');

        // Fade out flash messages
        setTimeout(() => {
            $('.alert').fadeOut('fast')
        }, 2200);

        // nav sticky au scroll
        window.addEventListener('scroll', function () {
            const nav = document.querySelector('.nav');
            if (window.scrollY > 200) { // Changez 200 à la hauteur souhaitée pour activer la nav sticky
                nav.classList.add('sticky');
            } else {
                nav.classList.remove('sticky');
            }
        });

        // MATERIALIZE INIT 
        $(document).ready(function () {
            $('.sidenav').sidenav();
            $(".dropdown-trigger").dropdown();
            $('.collapsible').collapsible();
            $('select').formSelect();
            $('.parallax').parallax();
            //$('.modal').modal();
        });
    },

    /**
    * *****************************
    * F U N C T I O N S
    * *****************************
    */
    loadingAnim: (e) => {
        $('.animation-loading-container').fadeIn().css('display', 'block');
    },

    closeLoadingAnim: () => {
        setTimeout(() => {
            $('.animation-loading-container').fadeIn().css('display', 'none');
        }, 2000);
    },
}

document.addEventListener('DOMContentLoaded', app.init);
