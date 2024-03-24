var app = {

    init: () => {

        /**
        * *****************************
        * L I S T E N E R S
        * *****************************
        */
        //$('.custom-btn').on('click', app.loadingAnim);
        $('.btn-visibility').on('click', app.changeVisibility);

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

    changeVisibility: (e) => {
        let objectToChange = e.currentTarget.dataset.type;

        $.ajax({
            url: '/mydiary/public/visibilite',
            /* url: '/visibilite', */
            type: 'POST',
            data: objectToChange,
            success: function (response) {
                console.log('Réponse du serveur :', response);

                console.log(process.env.ENV_VARIABLE)

                let clickedSpan = $(e.target);
                let currentText = clickedSpan.text();

                if (currentText === 'Publique') {
                    clickedSpan.text('Privé');
                } else {
                    clickedSpan.text('Publique');
                }
            },
            error: function (xhr, status, error) {
                console.error('Erreur lors de la requête :', error);
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', app.init);
