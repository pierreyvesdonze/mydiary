var app = {

    init: () => {

        /**
        * *****************************
        * L I S T E N E R S
        * *****************************
        */
        //$('.custom-btn').on('click', app.loadingAnim);

        // Fade out flash messages
        setTimeout(() => {
            $('.alert').fadeOut('fast')
        }, 3000);

        // If Spinner anim, disabled it onload
        app.closeLoadingAnim();

        // MATERIALIZE INIT 
        $(document).ready(function () {
            $('.sidenav').sidenav();
            $(".dropdown-trigger").dropdown();
            $('.collapsible').collapsible();
        });

    },

    /**
    * *****************************
    * F U N C T I O N S
    * *****************************
    */
    loadingAnim: () => {
        $('.animation-loading-container').fadeIn().css('display', 'block');
    },

    closeLoadingAnim: () => {
        setTimeout(() => {
            $('.animation-loading-container').fadeIn().css('display', 'none');
        }, 2000);
    },
}

document.addEventListener('DOMContentLoaded', app.init);
