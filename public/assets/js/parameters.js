var appParam = {

    init: () => {

        /**
        * *****************************
        * L I S T E N E R S
        * *****************************
        */
        //$('.custom-btn').on('click', appParam.loadingAnim);
        $('.btn-visibility').on('click', appParam.changeVisibility);
        $('#trigger-modal-pseudo-user').on('click', appParam.changeUserPseudo);
    },

    /**
     * *****************************
     * F U N C T I O N S
     * *****************************
    */
    changeVisibility: (e) => {

        let objectToChange = e.currentTarget.dataset.type;
        console.log(objectToChange)

        const envType = $('.env').data('envtype');
        if (envType === "prod") {
            envUrl = '/mydiary/public/visibilite';
        } else {
            envUrl = '/visibilite'
        }

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

    changeUserPseudo: () => {
        let elems = document.querySelectorAll('.modal');
        let instances = M.Modal.init(elems);
        let instance = M.Modal.getInstance(document.getElementById('modal-pseudo-user'));

        instance.open()
    },
}

document.addEventListener('DOMContentLoaded', appParam.init);