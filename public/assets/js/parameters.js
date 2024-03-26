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
                } else {
                    clickedSpan.text('Publique');
                }
            },
            error: function (xhr, status, error) {
                console.error('Erreur lors de la requête :', error);
            }
        });
    },
}

document.addEventListener('DOMContentLoaded', appParam.init);