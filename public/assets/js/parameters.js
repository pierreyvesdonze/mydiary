var appParam = {

    init: () => {

        /**
        * *****************************
        * L I S T E N E R S
        * *****************************
        */
        $('.btn-visibility').on('click', appParam.changeVisibility);
        $('#trigger-modal-pseudo-user').on('click', appParam.triggerUserChangeModal);
        $('#confirm-change-user-pseudo').on('click', appParam.changeUserPseudo);
        $('#trigger-modal-mantra-user').on('click', appParam.triggerUserChangeMantraModal);  // Ajout du listener pour la modale changement mantra
        $('#confirm-change-user-mantra').on('click', appParam.changeUserMantra);  // Ajout du listener pour valider le changement de mantra
    },

    /**
     * *****************************
     * F U N C T I O N S
     * *****************************
    */
    changeVisibility: (e) => {
        let objectToChange = e.currentTarget.dataset.type;

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

    /* Modal trigger pour le pseudo */
    triggerUserChangeModal: () => {
        // Initialise et stocke l'instance de la modale pseudo
        let modal = M.Modal.init($('#modal-pseudo-user'));
        modal.open();
    },

    /* Modal trigger pour le mantra */
    triggerUserChangeMantraModal: () => {
        // Initialise et stocke l'instance de la modale mantra
        let modal = M.Modal.init($('#modal-mantra-user'));
        modal.open();
    },

    /* Changement du pseudo */
    changeUserPseudo: () => {
        envUrl = '/changer/pseudo/utilisateur'

        let newPseudo         = $('#change-pseudo-input').val();
        let modalTitle        = $('.modal-content-title');
        let userAccountPseudo = $('#user-account-pseudo');
        let modal             = M.Modal.getInstance($('#modal-pseudo-user'));  // Modale pseudo
  
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

    /* Changement du mantra */
    changeUserMantra: () => {
        const envUrl = '/changer/mantra/utilisateur';

        let newMantra         = $('#change-mantra-input').val();
        let userAccountMantra = $('#user-account-mantra');
        let modal             = M.Modal.getInstance($('#modal-mantra-user'));
  
        $.ajax({
            url: envUrl,
            type: 'POST',
            data: { mantra: newMantra },  // Envoi le mantra dans un objet pour plus de clarté
            success: function (response) {
                // Peu importe la réponse, on met à jour le mantra de l'utilisateur
                userAccountMantra.text('Mon mantra : ' + newMantra);
                modal.close();
                M.toast({
                    html: 'Mantra confirmé !',
                    classes: 'rounded',
                    displayLength: 2000
                });
            },
            error: function (xhr, status, error) {
                console.error('Erreur lors de la requête :', error);
            }
        });
    },
}

document.addEventListener('DOMContentLoaded', appParam.init);
