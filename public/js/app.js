//Funções em JQuery
$(function(){

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    //Inserir dados no dropdown de usuário
    $([
        '<a class="dropdown-item" data-toggle="modal" data-target="#user-detail-modal" href="#" data-id='+window.user.id+'>View Profile</a>',
        '<a class="dropdown-item" data-toggle="modal" data-target="#address-add-modal" href="#" data-id='+window.user.id+'>Add Address</a>',
        '<a class="dropdown-item" data-toggle="modal" data-target="#company-add-modal" href="#" data-id='+window.user.id+'>Add Company</a>',
        '<a class="dropdown-item" data-toggle="modal" data-target="#user-edit-modal" href="#" data-id='+window.user.id+'>Edit Profile</a>'
    ].join('')).insertBefore('#logout');

    //Pesquisa de CEP
    $('#formcep').on('submit', async (ev) => {
        ev.preventDefault();
        var cep = $('#cep').val();
        $.ajax({
            url: '/viacep/'+cep,
            success: function(data){
                $('#cep').val('');
                $('#cep').blur();
                $('#dados-cep').append([
                    '<div class="container text-left">',
                        '<div class="row">',
                            '<div class="col-2 label-cep text-right">',
                                '<label id="lb-cep">CEP: </label>',
                            '</div>',
                            '<div class="col text-left">',
                                '<span class="resp" id="cep-resp">',data.cep,'</span>',
                            '</div>',
                        '</div>',
                        '<div class="row">',
                            '<div class="col-2 label-cep text-right">',
                                '<label id="lb-estado">Estado: </label>',
                            '</div>',
                            '<div class="col text-left">',
                                '<span class="resp" id="uf">',data.uf,'</span>',
                            '</div>',
                        '</div>',
                        '<div class="row">',
                            '<div class="col-2 label-cep text-right">',
                                '<label  id="lb-cidade">Cidade: </label>',
                            '</div>',
                            '<div class="col text-left">',
                                '<span class="resp" id="cidade">',data.localidade,'</span>',
                            '</div>',
                        '</div>',
                        '<div class="row">',
                            '<div class="col-2 label-cep text-right">',
                                '<label id="lb-bairro">Bairro: </label>',
                            '</div>',
                            '<div class="col text-left">',
                                '<span class="resp" id="bairro">',data.bairro,'</span>',
                            '</div>',
                        '</div>',
                        '<div class="row">',
                            '<div class="col-2 label-cep text-right">',
                                '<label id="lb-rua">Logradouro: </label>',
                            '</div>',
                            '<div class="col text-left">',
                                '<span class="resp" id="rua">',data.logradouro,'</span>',
                            '</div>',
                        '</div>',
                    '</div>'
                ].join(''));
            },
            error: function(response, textStatus, errorThrown){
                alert('Problema na Requisição');
                console.error(response, textStatus, errorThrown);
            }
        });
    });

    //Apagar a linha do cep ao clicar
    $('#cep').on('focusin', (ev) => {
        $('#dados-cep').html('');
    });

    //Definição de váriaveis constantes
    const usersApiEndpoint = '/user';
    const userApi = '/user/';
    const companyApi = '/company/';
    const addressApi = '/address/';
    globalUserID = "";
    const loadingDataRow = [
        '<tr id="loading">',
            '<td colspan="6" class="text-center">Carregando...</td>',
        '<tr>'
    ];
    orderAsc = true;
    order = 'name';

    //Carregar usuários para tabela
    function getUsersList(filter) {

        var data = {
            orderBy : 'name',
            direction : 'asc',
            page : 1
        };

        filter = filter || {};
        data = Object.assign(data, filter);

        $.ajax({
            url: usersApiEndpoint,
            data,
            beforeSend: function() {
                $('#users-table').find('tbody').append(loadingDataRow.join(''));
            },
            complete: function() {
                $('#loading').remove();
            },
            success: function(data) {
                listUsers(data);
            },
            error: function(error) {
                console.error(error);
            }
        });
    }


    //Função para listar users
    function listUsers(users){
        $('#users-table').find('tbody').html('');

        $.each(users.data, function(index, userApi) {
            var adminActions = [];
            if (window.user.is_admin){
                adminActions.push([
                    '<button class="btn btn-sm btn-success mr-2 btn-edit" data-toggle="modal" data-target="#user-edit-modal" data-id="'+userApi.id+'">'+
                        '<i class="fas fa-edit"></i>'+
                    '</button>'+
                    '<button class="btn btn-sm btn-danger btn-delete" data-id="'+userApi.id+'">'+
                        '<i class="fas fa-trash-alt"></i>'+
                    '</button>'
                ]);
            }
            $('#users-table').find('tbody').append([
                '<tr>',
                    '<td>',userApi.name,'</td>',
                    '<td>',userApi.username,'</td>',
                    '<td>',userApi.email,'</td>',
                    '<td>',
                        '<button class="btn btn-sm btn-primary mr-2 btn-view" data-toggle="modal" data-target="#user-detail-modal" data-id="'+userApi.id+'">',
                            '<i class="fas fa-eye" ></i>',
                        '</button>',
                        adminActions,
                    '</td>',
                '</tr>'
            ].join(''));
        });

        //Paginação da lista
        $('#pagination').html('');
        $('.active').removeClass('active');
        $.each(users.links, function(index, pageLink) {

            namePage = pageLink.label;

            if(pageLink.label.includes("Previous")){
                let pagina = users.current_page - 1;
                pageLink.label = pagina.toString();
            }
            if(pageLink.label.includes("Next")){
                if(users.current_page == users.last_page){
                    pageLink.label = users.last_page;
                }else{
                    let pagina = users.current_page + 1;
                    pageLink.label = pagina.toString();
                }
            }

            $('#pagination').append([
                '<button type="button" class="btn-pages" id="',pageLink.label,'" data-id="',pageLink.label,'">',namePage,'</button>'
            ].join(''));

            if(pageLink.active && !namePage.includes("Previous") && !namePage.includes("Next")){
                $('#'+pageLink.label).addClass('active');
            }

        });

        rebindButtons();
    }


    //Mudando ação do Delete
    function rebindButtons (){
        $('.btn-delete').off('click');

        $('.btn-delete').on('click', function() {
            var userId = $(this).data('id');
            var userRow = $(this).parent().parent();
            var response = confirm('Deseja mesmo excluir o usuário?');
            if (response){
                $.ajax({
                    url: userApi + userId,
                    type:'delete',
                    success:function(data){
                        userRow.remove();
                        alert('Usuário Excluído com sucesso.');
                    },
                    error:function(error){
                        alert('Ocorreu um erro inesperado.');
                        console.error(error);
                    }
                });
            }
        });

        $('.btn-pages').off('click');

        $('.btn-pages').on('click', function() {
            var page = $(this).data('id');

            var direct = 'asc';
            if(!orderAsc){
                direct = 'desc';
            }

            var data = {
                orderBy : order,
                direction : direct,
                page : page
            };

            $.ajax({
                url:usersApiEndpoint,

                data,

                beforeSend: function() {
                    $('#users-table').find('tbody').append(loadingDataRow.join(''));
                },
                complete: function() {
                    $('#loading').remove();
                },
                success: function(data) {
                    listUsers(data);
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });
    }

    //Mudando botão de Delete do Address e Company
    function rebindDeleteButtons() {
        $('.btn-delete-address').off('click');
        $('.btn-delete-address').on('click', function() {
            var addressId = $(this).data('id');
            var addressDiv = $(this).parent().parent().parent();
            var response = confirm('Deseja mesmo excluir este endereço?');
            if (response){
                $.ajax({
                    url: addressApi+addressId,
                    type:'delete',
                    success:function(data){
                        addressDiv.remove();
                        alert('Address Deleted!');
                    },
                    error:function(error){
                        alert('Ocorreu um erro inesperado.');
                        console.error(error);
                    }
                });
            }
        });

        $('.btn-delete-company').off('click');
        $('.btn-delete-company').on('click', function() {
            var companyId = $(this).data('id');
            var companyDiv = $(this).parent().parent().parent();
            var response = confirm('Deseja mesmo excluir a compania?');
            if (response){
                $.ajax({
                    url: companyApi+companyId,
                    type:'delete',
                    success:function(data){
                        companyDiv.remove();
                        alert('Company Deleted!');
                    },
                    error:function(error){
                        alert('Ocorreu um erro inesperado.');
                        console.error(error);
                    }
                });
            }
        });
    }

    getUsersList();

    //MODAL DE DETALHES DE USUÁRIO
    $('#user-detail-modal').on('show.bs.modal', function (event) {
        var userId = $(event.relatedTarget).data('id');
        var adminActions = [];
        $.ajax({
            url: userApi+userId,
            beforeSend: function() {
                $('#user-detail-modal-title').text('Loading...');
                $('#user-detail-modal-body').html('<p class="text-center"> Loading... </p>');
            },
            success: function(data) {
                $('#user-detail-modal-title').text(data.name);
                $('#user-detail-modal-body').html('');

                $('#user-detail-modal-body').append([
                    '<dl class="row">',
                        '<dt class="col-sm-3">Name:</dt>',
                        '<dd class="col-sm-9 mb-3">',data.name,'</dd>',
                        '<dt class="col-sm-3">E-mail:</dt>',
                        '<dd class="col-sm-9 mb-3">',data.email,'</dd>',
                        '<dt class="col-sm-3">Username:</dt>',
                        '<dd class="col-sm-9 mb-3">',data.username,'</dd>',
                        '<dt class="col-sm-3">Phone:</dt>',
                        '<dd class="col-sm-9 mb-3">',data.phone,'</dd>',
                        '<dt class="col-sm-3">Website:</dt>',
                        '<dd class="col-sm-9 mb-3" id="break-adm">',data.website,'</dd>',
                    '</dl>',
                    '<hr>'
                ].join(''));

                adminActions=[];
                if (window.user.is_admin){
                    adminActions.push([
                        '<div class="col text-right">'+
                        '<button type="button" class="mb-2 btn btn-success" id="btn-address" data-dismiss="modal" data-toggle="modal" data-target="#address-add-modal">Add Address</button>'+
                        '</div>'
                    ]);
                    $([
                        '<div class="custom-control custom-checkbox ml-3">',
                            '<input type="checkbox" class="custom-control-input" id="cb-adm">',
                            '<label class="custom-control-label" for="cb-adm">Administrador</label>',
                        '</div>'
                    ].join('')).insertAfter('#break-adm');
                }
                $('#user-detail-modal-body').append([
                    '<div class="container">',
                        '<div class="row">',
                            '<div class="col">',
                                '<h5>Addresses</h5>',
                            '</div>',
                            adminActions,
                        '</div>'
                ].join(''));

                $.each(data.addresses, function (index, address){
                    adminActions=[];
                    if (window.user.is_admin){
                        adminActions.push([
                            '<div class="col-2 flex-column d-flex">'+
                            '<button type="button" class="mb-2 btn btn-warning btn-edit-address" data-dismiss="modal" data-toggle="modal" data-target="#address-edit-modal" data-id="'+address.id+'"><i class="fas fa-pen"></i></button>'+
                            '<br>'+
                            '<button type="button" class="btn btn-danger btn-delete-address" data-id="'+address.id+'"><i class="fas fa-times"></i></button>'+
                        '</div>'
                        ]);
                    }
                    $('#user-detail-modal-body').append([
                        '<div class="container">',
                            '<div class="mb-2 px-1 py-3 row border rounded">',
                                '<div class="col ">',
                                    '<div class="col d-flex flex-column w-70">',
                                        '<h5 class="mb-1">',address.street,'</h5>',
                                        '<p class="mb-1">',address.zipcode,'</p>',
                                        '<p class="mb-1">',address.suite,'</p>',
                                        '<p class="mb-1">Lat: ',address.lat ?? 'n/a','</p>',
                                        '<p class="mb-1">Lng: ',address.lng ?? 'n/a','</p>',
                                    '</div>',
                                '</div>',
                                adminActions,
                            '</div>',
                        '</div>'
                    ].join(''));
                });

                adminActions=[];
                if (window.user.is_admin){
                    adminActions.push([
                        '<div class="col text-right">'+
                            '<button type="button" class="mb-2 btn btn-success" id="btn-company" data-dismiss="modal" data-toggle="modal" data-target="#company-add-modal">Add Company</button>'+
                        '</div>'
                    ]);
                }
                $('#user-detail-modal-body').append([
                    '<hr>',
                    '<div class="container">',
                        '<div class="row">',
                            '<div class="col">',
                                '<h5>Companies</h5>',
                            '</div>',
                            adminActions,
                        '</div>'
                ].join(''));

                $.each(data.companies, function (index, company){
                    adminActions=[];
                    if (window.user.is_admin){
                        adminActions.push([
                        '<div class="col-2 flex-column d-flex">'+
                            '<button type="button" class="mb-2 btn btn-warning btn-edit-company" data-dismiss="modal" data-toggle="modal" data-target="#company-edit-modal" data-id="'+company.id+'"><i class="fas fa-pen"></i></button>'+
                            '<br>'+
                            '<button type="button" class="btn btn-danger btn-delete-company" data-id="'+company.id+'"><i class="fas fa-times"></i></button>'+
                        '</div>'
                        ]);
                    }
                    $('#user-detail-modal-body').append([
                        '<div class="container">',
                            '<div class="mb-2 px-1 py-3 row border rounded">',
                                '<div class="col ">',
                                    '<div class="col d-flex flex-column w-70">',
                                        '<h5 class="mb-1">',company.name,'</h5>',
                                        '<p class="mb-1">BS: ',company.bs ?? 'n/a','</p>',
                                        '<p class="mb-1">Catch Phrase: ',company.catch_phrase ?? 'n/a','</p>',
                                    '</div>',
                                '</div>',
                                adminActions,
                            '</div>',
                        '</div>'
                    ].join(''));
                });

                rebindDeleteButtons();
                globalUserID = data.id;
                globalUserName = data.name;

                if(data.is_admin){
                    $( "#cb-adm" ).prop( "checked", true );
                }

                if(!data.is_admin){
                    $( "#cb-adm" ).prop( "checked", false );
                }
            },
            error: function(error) {
            }
        });

    });

    // CheckBox Administrador
    $(document).on('change', '#cb-adm', function() {

        //Checkbox admin check
        if(this.checked) {
            var resp = confirm('Tornar '+globalUserName+' administrador?');
            if (resp){
                var url = userApi+globalUserID;
                var data = {
                    'is_admin' : 1
                }
                $.ajax({
                    url,

                    data,

                    type: 'PUT',

                    beforeSend: function() {

                    },

                    success: function() {
                        alert('Permissão de administrador atualizada!');
                        $( "#cb-adm" ).prop( "checked", true );
                    },

                    error: function(error) {
                        console.log(error);
                        alert('Ocorreu um erro inesperado.');
                        $( "#cb-adm" ).prop( "checked", false );
                    }
                });
            }
            else{
                $( "#cb-adm" ).prop( "checked", false );
                return;
            }
        }

        //Checkbox admin uncheck
        else {
            var resp = confirm('Tirar permissão de Administrador?');
            if (resp){
                var url = userApi+globalUserID;
                var data = {
                    'is_admin' : 0
                }
                $.ajax({
                    url,

                    data,

                    type: 'PUT',

                    beforeSend: function() {

                    },

                    success: function() {
                        alert('Permissão de administrador retirada!');
                        $( "#cb-adm" ).prop( "checked", false );
                    },

                    error: function(error) {
                        console.log(error);
                        alert('Ocorreu um erro inesperado.');
                        $( "#cb-adm" ).prop( "checked", true );

                    }
                });
            }
            else{
                $( "#cb-adm" ).prop( "checked", true );
            }
        };
    });

    $('#user-edit-modal').on('show.bs.modal', function (event) {
        var userId = $(event.relatedTarget).data('id');
        $('#form-edit-id').val(userId);
        var modal = $(this);
        $.ajax({
            url: userApi+userId,
            beforeSend: function() {
                $('#user-edit-modal-title').text('Loading...');
                $('#user-edit-modal-body').html('<p class="text-center"> Loading... </p>');
            },
            success: function(data) {

                if(data.website == null){
                    data.website = "";
                }

                $('#user-edit-modal-title').text('Edit - '+data.name);
                $('#user-edit-modal-body').html('');

                $('#user-edit-modal-body').append([
                    '<dl class="row px-4">',
                        '<dt class="col-sm-3">Name:</dt>',
                        '<input id="user-edit-name" class="col-sm-9 mb-3 form-control" value="'+data.name+'">',
                        '<dt class="col-sm-3">E-mail:</dt>',
                        '<input id="user-edit-email" class="col-sm-9 mb-3 form-control" value="'+data.email+'">',
                        '<dt class="col-sm-3">Username:</dt>',
                        '<input id="user-edit-username" class="col-sm-9 mb-3 form-control" value="'+data.username+'">',
                        '<dt class="col-sm-3">Phone:</dt>',
                        '<input id="user-edit-phone" class="col-sm-9 mb-3 form-control" value="'+data.phone+'">',
                        '<dt class="col-sm-3">Website:</dt>',
                        '<input id="user-edit-website" class="col-sm-9 mb-3 form-control" value="'+data.website+'">',
                    '</dl>'
                ].join(''));

            },
            error: function(error) {
            }
        });
    });

    $('#company-edit-modal').on('show.bs.modal', function (event) {
        var companyId = $(event.relatedTarget).data('id');
        $('#form-edit-company-id').val(companyId);
        $.ajax({
            url: companyApi+companyId,
            beforeSend: function() {
                $('#company-edit-modal-title').text('Loading...');
                $('#company-edit-modal-body').html('<p class="text-center"> Loading... </p>');
            },
            success: function(company) {
                if(company.bs == null){
                    company.bs = "";
                }
                if(company.catch_phrase == null){
                    company.catch_phrase = "";
                }

                $('#company-edit-modal-title').text('Edit - '+company.name);
                $('#company-edit-modal-body').html('');

                $('#company-edit-modal-body').append([
                    '<dl class="row">',
                        '<dt class="col-sm-3">Company Name:</dt>',
                        '<input id="company-edit-name" class="col-sm-9 mb-3 form-control" value="'+company.name+'">',
                        '<dt class="col-sm-3">BS:</dt>',
                        '<input id="company-edit-bs" class="col-sm-9 mb-3 form-control" value="'+company.bs+'">',
                        '<dt class="col-sm-3">Catch Phrase:</dt>',
                        '<input id="company-edit-phrase" class="col-sm-9 mb-3 form-control" value="'+company.catch_phrase+'">',
                    '</dl>'
                ].join(''));
            },
            error: function(error) {
                console.log(error);
            }
        });

        $('#company-edit-modal-footer').html(
            '<button type="button" class="btn btn-secondary btn-back-to-user" data-dismiss="modal" data-toggle="modal" data-target="#user-detail-modal" data-id="'+globalUserID+'">Back</button>'
            +'<button type="submit" class="btn btn-success" data-id="'+globalUserID+'">Edit Company</button>'
        );
    });

    $('#address-edit-modal').on('show.bs.modal', function (event) {
        var addressId = $(event.relatedTarget).data('id');
        $('#form-edit-address-id').val(addressId);
        $.ajax({
            url: addressApi+addressId,
            beforeSend: function() {
                $('#address-edit-modal-title').text('Loading...');
                $('#address-edit-modal-body').html('<p class="text-center"> Loading... </p>');
            },
            success: function(address) {
                if(address.suite == null){
                    address.suite = "";
                }
                if(address.lat == null){
                    address.lat = "";
                }
                if(address.lng == null){
                    address.lng = "";
                }

                $('#address-edit-modal-title').text('Edit Address');
                $('#address-edit-modal-body').html('');

                $('#address-edit-modal-body').append([
                    '<dl class="row">',
                        '<dt class="col-sm-3">Street Name:</dt>',
                        '<input id="address-edit-street" class="col-sm-9 mb-3 form-control" value="'+address.street+'">',
                        '<dt class="col-sm-3">Zipcode:</dt>',
                        '<input id="address-edit-zipcode" class="col-sm-9 mb-3 form-control" value="'+address.zipcode+'">',
                        '<dt class="col-sm-3">Suite:</dt>',
                        '<input id="address-edit-suite" class="col-sm-9 mb-3 form-control" value="'+address.suite+'">',
                        '<dt class="col-sm-3">Latitude:</dt>',
                        '<input id="address-edit-lat" class="col-sm-9 mb-3 form-control" value="'+address.lat+'">',
                        '<dt class="col-sm-3">Longitude:</dt>',
                        '<input id="address-edit-lng" class="col-sm-9 mb-3 form-control" value="'+address.lng+'">',
                    '</dl>'
                ].join(''));
            },
            error: function(error) {
                console.log(error);
            }
        });

        $('#address-edit-modal-footer').html(
            '<button type="button" class="btn btn-secondary btn-back-to-user" data-dismiss="modal" data-toggle="modal" data-target="#user-detail-modal" data-id="'+globalUserID+'"">Back</button>'
            +'<button type="submit" class="btn btn-success">Edit address</button>'
        );
    });

    $('#user-add-modal').on('show.bs.modal', function () {
        $('.form-control').val('');
    });

    $('#company-add-modal').on('show.bs.modal', function () {
        $('#add-company-modal-title').text(globalUserName + ' - Add Company');
        $('#footer-modal-company').html(
            '<button type="button" class="btn btn-secondary btn-back-to-user" data-dismiss="modal" data-toggle="modal" data-target="#user-detail-modal" data-id="'+globalUserID+'"">Back</button>'
            +'<button type="submit" class="btn btn-success">Add Company</button>'
        );
        $('.form-control').val('');
    });

    $('#address-add-modal').on('show.bs.modal', function () {
        $('#add-address-modal-title').text(globalUserName + ' - Add Address');
        $('#footer-modal-address').html(
            '<button type="button" class="btn btn-secondary btn-back-to-user" data-dismiss="modal" data-toggle="modal" data-target="#user-detail-modal" data-id="'+globalUserID+'"">Back</button>'
            +'<button type="submit" class="btn btn-success">Add Address</button>'
        );
        $('.form-control').val('');
    });

    //Form de adicionar novo usuário
    $('#form-user').on('submit', (ev) => {
        ev.preventDefault();
        var url = $('#form-user').data('action');
        var data = {
            'name' : $('#form-user-name').val(),
            'email' : $('#form-user-email').val(),
            'username' : $('#form-user-username').val(),
            'phone' : $('#form-user-phone').val(),
            'website' : $('#form-user-website').val(),
            'password' : $('#form-user-password').val()
        };
        if ($('#form-user-password').val() != $('#form-user-confirm-password').val()){
            alert('As senhas não confirmam');
            return;
        }

        $.ajax({

            url,

            data,

            type: 'POST',

            beforeSend: function() {

            },

            success: function(data) {
                alert('Usuário Criado!');
                $("#user-add-modal").modal('hide');
                getUsersList();
            },

            error: function(error) {
                console.log(error);
                alert('Erro ao criar usuário');
            }
        });

    });

    //Form para adicionar compania
    $('#form-company').on('submit', (ev) => {
        ev.preventDefault();
        var url = $('#form-company').data('action');

        if ($('#form-company-name').val() == '') {
            if (!$('#form-company-name').hasClass('is-invalid')) {
                $('#form-company-name').addClass('is-invalid');
            }
            alert('Preencha o campo Name');
            return;
        }

        var data = {
            'name' : $('#form-company-name').val(),
            'bs' : $('#form-company-bs').val(),
            'catch_phrase' : $('#form-company-catch_phrase').val(),
            'user_id' : globalUserID
        };

        $.ajax({
            url,

            data,

            type: 'POST',

            beforeSend: function() {

            },

            success: function(data) {
                alert('Company '+data.name+' added!');
                $('.form-control').val('');

            },

            error: function(error) {
                console.log(error);
            }
        });

    });

    //Form para adicionar endereço
    $('#form-address').on('submit', (ev) => {
        ev.preventDefault();
        var url = $('#form-address').data('action');

        if ($('#form-address-street').val() == '' ) {
            $('#form-address-street').toggleClass('is-invalid');
            alert('Preencha o campo Name');
            return;
        }

        var data = {
            'street' : $('#form-address-street').val() ,
            'zipcode' : $('#form-address-zipcode').val(),
            'suite' : $('#form-address-suite').val(),
            'lat' : $('#form-address-lat').val(),
            'lng' : $('#form-address-lng').val(),
            'user_id' : globalUserID
        };

        $.ajax({
            url,

            data,

            type: 'POST',

            beforeSend: function() {

            },

            success: function(data) {
                alert('Address added!');
                $('.form-control').val('');

            },

            error: function(error) {
                console.log(error);
            }
        });

    });

    $('#form-edit').on('submit', (ev) => {
        ev.preventDefault();
        var url = $('#form-edit').data('action')+'/'+$('#form-edit-id').val();
        var data = {
            'name' : $('#user-edit-name').val(),
            'email' : $('#user-edit-email').val(),
            'username' : $('#user-edit-username').val(),
            'phone' : $('#user-edit-phone').val(),
            'website' : $('#user-edit-website').val()
        };
        $.ajax({
            url,

            data,

            type: 'PUT',

            beforeSend: function() {

            },

            success: function(data) {
                alert('Usuário atualizado!');
                $("#user-edit-modal").modal('hide');
                getUsersList();
            },

            error: function(error) {
                console.log(error);
            }
        });

    });

    $('#form-edit-company').on('submit', (ev) => {
        ev.preventDefault();
        var url = $('#form-edit-company').data('action')+'/'+$('#form-edit-company-id').val();
        var data = {
            'name' : $('#company-edit-name').val(),
            'bs' : $('#company-edit-bs').val(),
            'catch_phrase' : $('#company-edit-phrase').val()
        };
        $.ajax({
            url,

            data,

            type: 'PUT',

            beforeSend: function() {

            },

            success: function(data) {
                alert('Compania editada!');
                $("#company-edit-modal").modal('hide');
                $("#user-detail-modal").modal('show');
            },

            error: function(error) {
                console.log(error);
            }
        });

    });

    $('#form-edit-address').on('submit', (ev) => {
        ev.preventDefault();
        var url = $('#form-edit-address').data('action')+'/'+$('#form-edit-address-id').val();
        var data = {
            'street' : $('#address-edit-street').val(),
            'suite' : $('#address-edit-suite').val(),
            'zipcode' : $('#address-edit-zipcode').val(),
            'lat' : $('#address-edit-lat').val(),
            'lng' : $('#address-edit-lng').val()
        };

        $.ajax({
            url,

            data,

            type: 'PUT',

            beforeSend: function() {

            },

            success: function(data) {
                alert('Endereço editado!');
                $("#address-edit-modal").modal('hide');
                $("#user-detail-modal").modal('show');
            },

            error: function(error) {
                console.log(error);
            }
        });

    });

    //Ordenar usuários por nome
    $("#order-name").on('click', function(){
        if(orderAsc && order=='name'){
            getUsersList({orderBy : 'name', direction : 'desc'});
            orderAsc = false;
            $('.icon-order-active').removeClass("icon-order-active");
            $('#btn-name-za').addClass("icon-order-active");
        }else{
            getUsersList({orderBy : 'name', direction : 'asc'});
            order='name';
            orderAsc = true;
            $('.icon-order-active').removeClass("icon-order-active");
            $('#btn-name-az').addClass("icon-order-active");
        }
    });

    //Ordenar usuários por username
    $("#order-username").on('click', function(){
        if(orderAsc && order=='username'){
            getUsersList({orderBy : 'username', direction : 'desc'});
            orderAsc = false;
            $('.icon-order-active').removeClass("icon-order-active");
            $('#btn-username-za').addClass("icon-order-active");
        }else{
            getUsersList({orderBy : 'username', direction : 'asc'});
            order='username';
            orderAsc = true;
            $('.icon-order-active').removeClass("icon-order-active");
            $('#btn-username-az').addClass("icon-order-active");
        }
    });

    //Ordenar usuários por e-mail
    $("#order-email").on('click', function(){
        if(orderAsc && order=='email'){
            getUsersList({orderBy : 'email', direction : 'desc'});
            orderAsc = false;
            $('.icon-order-active').removeClass("icon-order-active");
            $('#btn-email-za').addClass("icon-order-active");
        }else{
            getUsersList({orderBy : 'email', direction : 'asc'});
            order="email";
            orderAsc = true;
            $('.icon-order-active').removeClass("icon-order-active");
            $('#btn-email-az').addClass("icon-order-active");
        }
    });

});
