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
        $.ajax({
            url: '/mydiary/public/contacts/envoyer/invitation',
            //url: '/contacts/envoyer/invitation', 
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

    searchContact: function (evt) {
        evt.preventDefault();
        let userInput = $('.search-input').val();

        $('.custom-row').hide();
        $('.custom-row:contains("' + userInput + '")').show();

        $(window).keydown((event) => {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        })
    },
}

document.addEventListener('DOMContentLoaded', appContact.init);