$(function (){

    const userApi = '/user/';
    const addressApiEndpoint = '/address';
    const loadingDataRow = [
        '<tr id="loading">',
            '<td colspan="6" class="text-center">Carregando...</td>',
        '<tr>'
    ];

    //Carregar dados de addresses
    function getAddressesList() {
        $.ajax({
            url: addressApiEndpoint,

            beforeSend: function() {
                $('#addresses-table').find('tbody').append(loadingDataRow.join(''));
            },

            complete: function() {
                $('#loading').remove();
            },
            success: function(addressAPI) {

                $('#addresses-table').find('tbody').html('');

                $.each(addressAPI, function(index, address) {
                    $.ajax({
                        url: userApi+address.user_id,

                        beforeSend: function() {
                        },

                        success: function(user) {
                            $('#addresses-table').find('tbody').append([
                                '<tr>',
                                    '<td>',address.zipcode,'</td>',
                                    '<td>',address.street,'</td>',
                                    '<td>',address.suite,'</td>',
                                    '<td>',user.name,'</td>',
                                '</tr>'
                            ].join(''));
                        },
                        error: function(error) {
                        }
                    });
                });
            },
            error: function(error) {
            }
        });
    }

    getAddressesList();

});
