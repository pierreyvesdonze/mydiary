var appParam = {

    init: () => {

        /**
        * *****************************
        * L I S T E N E R S
        * *****************************
        */
        //$('.custom-btn').on('click', appParam.loadingAnim);
        $('.btn-visibility').on('click', appParam.changeVisibility);
    },

    /**
    * *****************************
    * F U N C T I O N S
    * *****************************
    */
    changeVisibility: (e) => {
        let objectToChange = e.currentTarget.dataset.type;

        $.ajax({
            url: '/mydiary/public/visibilite',
            //url: '/visibilite',
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
}

document.addEventListener('DOMContentLoaded', appParam.init);