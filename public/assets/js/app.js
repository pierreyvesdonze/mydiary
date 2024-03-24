var app = {

    init: () => {

        /**
        * *****************************
        * L I S T E N E R S
        * *****************************
        */
        //$('.custom-btn').on('click', app.loadingAnim);
        $('.btn-visibility').on('click', app.changeVisibility);
        $('.friend-request-btn').on('click', app.sendFriendshipRequest)

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

    sendFriendshipRequest: (e) => {

        let currentTarget = $(e.currentTarget);

        let targetId = currentTarget.data('targetid');
        $.ajax({
            url: '/mydiary/public/contacts/envoyer/invitation',
            /* url: '/contacts/envoyer/invitation', */
            type: 'POST',
            data: JSON.stringify(targetId),
            success: function (response) {
                currentTarget.removeClass('friend-request-btn');
                currentTarget.addClass('disabled');
                currentTarget.text('Demande envoyée')
                console.log(response)
            },
            error: function (xhr, status, error) {
                console.error('Erreur lors de la requête :', error);
            }
        });
    },

    changeVisibility: (e) => {
        let objectToChange = e.currentTarget.dataset.type;

        $.ajax({
            url: '/mydiary/public/visibilite',
            /* url: '/visibilite', */
            type: 'POST',
            data: objectToChange,
            success: function (response) {
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
