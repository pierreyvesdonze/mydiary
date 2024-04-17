var appContact = {

    init: () => {

        /**
        * *****************************
        * L I S T E N E R S
        * *****************************
        */
        //$('.custom-btn').on('click', appContact.loadingAnim);
        $('.friend-request-btn').on('click', appContact.sendFriendshipRequest);
        $('.search-input').on('keyup', appContact.searchContact);
    },

    /**
    * *****************************
    * F U N C T I O N S
    * *****************************
    */
    sendFriendshipRequest: (e) => {

        let currentTarget = $(e.currentTarget);
        let targetId = currentTarget.data('targetid');

       /*  const envType = $('.env').data('envtype');

        if (envType === "prod") {
            envUrl = '/public/contacts/envoyer/invitation';
        } else {
            envUrl = '/contacts/envoyer/invitation'
        }
 */
        envUrl = '/contacts/envoyer/invitation';

        $.ajax({
            url: envUrl,
            type: 'POST',
            data: JSON.stringify(targetId),
            success: function (response) {
                currentTarget.removeClass('friend-request-btn');
                currentTarget.addClass('disabled');
                currentTarget.text('Demande envoyée')
                console.log(response)

                M.toast({
                    html: 'Demande envoyée !',
                    classes: 'rounded',
                    displayLength: 2000
                });
            },
            error: function (xhr, status, error) {
                console.error('Erreur lors de la requête :', error);
            }
        });
    },

    searchContact: function (evt) {
        evt.preventDefault();
        let userInput = $('.search-input').val().toLowerCase();
    
        // Fonction de normalisation Unicode pour traiter les caractères spéciaux
        const normalize = (str) => {
            return str.normalize('NFD').replace(/[\u0300-\u036f]/g, "");
        };
    
        // Fonction pour comparer les chaînes de caractères normalisées
        const containsNormalized = (str, term) => {
            return normalize(str).includes(normalize(term));
        };
    
        $('.search-contact-container').hide();
        // Convertir le contenu en minuscules et comparer avec la version normalisée
        $('.search-contact-container').filter(function() {
            return containsNormalized($(this).text().toLowerCase(), userInput);
        }).show();
    
        $(window).keydown((event) => {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
    }
    
}

document.addEventListener('DOMContentLoaded', appContact.init);