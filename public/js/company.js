$(function (){

    const userApi = '/user/';
    const companyApiEndpoint = '/company';
    const loadingDataRow = [
        '<tr id="loading">',
            '<td colspan="6" class="text-center">Carregando...</td>',
        '<tr>'
    ];

    //Carregar dados de companies
    function getCompaniesList() {
        $.ajax({
            url: companyApiEndpoint,

            beforeSend: function() {
                $('#companies-table').find('tbody').append(loadingDataRow.join(''));
            },

            complete: function() {
                $('#loading').remove();
            },
            success: function(companyAPI) {

                $('#companies-table').find('tbody').html('');

                $.each(companyAPI, function(index, company) {
                    $.ajax({
                        url: userApi+company.user_id,

                        beforeSend: function() {
                        },

                        success: function(user) {
                            $('#companies-table').find('tbody').append([
                                '<tr>',
                                    '<td>',company.name,'</td>',
                                    '<td>',company.bs,'</td>',
                                    '<td>',company.catch_phrase,'</td>',
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

    getCompaniesList();

});
