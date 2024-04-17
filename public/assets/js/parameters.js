var appParam = {

    init: () => {

        /**
        * *****************************
        * L I S T E N E R S
        * *****************************
        */
        $('.btn-visibility').on('click', appParam.changeVisibility);
        $('#trigger-modal-pseudo-user').on('click', appParam.triggerUserChangeModal);
        $('#confirm-change-user-pseudo').on('click', appParam.changeUserPseudo)
    },

    /**
     * *****************************
     * F U N C T I O N S
     * *****************************
    */
    changeVisibility: (e) => {

        let objectToChange = e.currentTarget.dataset.type;

        /* const envType = $('.env').data('envtype');
        if (envType === "prod") {
            envUrl = '/public/visibilite';
        } else {
            envUrl = '/visibilite'
        } */
        envUrl = '/visibilite'

        $.ajax({
            url: envUrl,
            type: 'POST',
            data: objectToChange,
            success: function (response) {
                let clickedSpan = $(e.target);
                let currentText = clickedSpan.text();

                if (currentText === 'Publique') {
                    clickedSpan.text('Privé');
                    M.toast({
                        html: 'Visibilité privée !',
                        classes: 'rounded',
                        displayLength: 2000
                    });
                } else {
                    clickedSpan.text('Publique');
                    M.toast({
                        html: 'Visibilité publique !',
                        classes: 'rounded',
                        displayLength: 2000
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error('Erreur lors de la requête :', error);
            }
        });
    },

    /* Modal trigger */
    triggerUserChangeModal: () => {
        // Initialise et stocke l'instance
        let modal = M.Modal.init($('.modal'));
        modal.open();
    },

    changeUserPseudo: () => {
        const envType = $('.env').data('envtype');
        if (envType === "prod") {
            envUrl = '/mydiary/public/changer/pseudo/utilisateur';
        } else {
            envUrl = '/changer/pseudo/utilisateur'
        }

        let newPseudo         = $('#change-pseudo-input').val();
        let modalTitle        = $('.modal-content-title');
        let userAccountPseudo = $('#user-account-pseudo');
        let modal             = M.Modal.getInstance($('.modal'));  
  
        $.ajax({
            url: envUrl,
            type: 'POST',
            data: newPseudo,
            success: function (response) {
                if (response == true) {
                    modalTitle.css('color', 'red');
                    modalTitle.text('Ce pseudo est déjà pris.')
                } else {
                    userAccountPseudo.text('Mon pseudo : ' + newPseudo)
                    modal.close();
                    M.toast({
                        html: 'Pseudo confirmé !',
                        classes: 'rounded',
                        displayLength: 2000
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error('Erreur lors de la requête :', error);
            }
        });
    },
}

document.addEventListener('DOMContentLoaded', appParam.init);