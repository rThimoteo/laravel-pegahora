@extends('layouts.app')

@section('content')
    <div class="container mt-2">
        <h4>Consulta de CEP</h4>
        <form id="formcep">
            <div class="row">
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="cep" id="cep">
                </div>
                <div class="col-sm-2">
                    <button type="submit" class="btn-success btn">
                        <i class="fas fa-check mr-1"></i>Enviar
                    </button>
                </div>
                <br>
            </div>
        </form>
        <div>
            <!-- IMPRIMIR DATA E HORA QUE VEM DA LIB DateTime -->
            <br>
            {{-- <span class="hora">{{dia}}<br>{{hora}}</span> --}}
            <br>
            <br>
            <p id="dados-cep"></p>
        </div>

        <div class="row">
            <div class="col-4">
                <h4>Lista de Usuários</h4>
            </div>
            @if(auth()->user()->is_admin)
                <div class="col text-right">
                    <button type="button" class="btn btn-success mb-2 mr-3" data-toggle="modal" data-target="#user-add-modal"
                        id="add-user">Add User</button>
                </div>
            @endif
        </div>

        <!-- TABELA PARA LISTAR USUÁRIOS -->
        <div class="table-responsive">
            <table id="users-table" class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>E-mail</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL PARA VER DETALHES DE USUÁRIO -->
    <div class="modal" tabindex="-1" role="dialog" id="user-detail-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="user-detail-modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="user-detail-modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PARA ADICIONAR USUÁRIOS -->
    <div class="modal" tabindex="-1" role="dialog" id="user-add-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="form-user" data-action="{{route('users.store')}}">
                    <div class="modal-header bg-primary text-white">Add User
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="user-add-modal-body">
                        <div class="form-group">
                            <label for="formGroupExampleInput">Name</label>
                            <input type="text" class="form-control" name="name" id="form-user-name" placeholder="Your Name">
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput2">E-mail</label>
                            <input type="text" class="form-control" name="email" id="form-user-email" placeholder="Your E-mail">
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput2">Username</label>
                            <input type="text" class="form-control" name="username" id="form-user-username" placeholder="Your Username">
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput2">Password</label>
                            <input type="password" class="form-control" name="password" id="form-user-password">
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput2">Confirm Password</label>
                            <input type="password" class="form-control" name="confirm-password" id="form-user-confirm-password">
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput2">Phone</label>
                            <input type="text" class="form-control" name="phone" id="form-user-phone" placeholder="Your Phone Number">
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput2">Website (Optional)</label>
                            <input type="text" class="form-control" name="website" id="form-user-website" placeholder="Your Website">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL PARA ADICIONAR COMPANIAS -->
    <div class="modal" tabindex="-1" role="dialog" id="company-add-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="form-company" data-action="{{route('companies.store')}}">
                    <input type="hidden" value="" id="form-add-company-user-id">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="add-company-modal-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="company-add-modal-body">
                        <div class="form-group">
                            <label for="formGroupExampleInput">Name</label>
                            <input type="text" class="form-control" name="name" id="form-company-name" placeholder="Company Name">
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput2">BS</label>
                            <input type="text" class="form-control" name="bs" id="form-company-bs" placeholder="Company BS (Optional)">
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput2">Catch Phrase</label>
                            <input type="text" class="form-control" name="catch_phrase" id="form-company-catch_phrase" placeholder="Catch Phrase (Optional)">
                        </div>
                    </div>
                    <div class="modal-footer " id="footer-modal-company"></div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL PARA ADICIONAR ENDEREÇO -->
    <div class="modal" tabindex="-1" role="dialog" id="address-add-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="form-address" data-action="{{route('addresses.store')}}">
                    <input type="hidden" value="" id="form-add-address-user-id">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="add-address-modal-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="address-add-modal-body">
                        <div class="form-group">
                            <label for="formGroupExampleInput">Street</label>
                            <input type="text" class="form-control" name="street" id="form-address-street" placeholder="Street Name">
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput2">Zipcode</label>
                            <input type="text" class="form-control" name="zipcode" id="form-address-zipcode" placeholder="Zipcode">
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput2">Suite</label>
                            <input type="text" class="form-control" name="suite" id="form-address-suite" placeholder="Suite (Optional)">
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput2">Latitude</label>
                            <input type="text" class="form-control" name="lat" id="form-address-lat" placeholder="Latitude (Optional)">
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput2">Longitude</label>
                            <input type="text" class="form-control" name="lng" id="form-address-lng" placeholder="Longitude (Optional)">
                        </div>
                    </div>
                    <div class="modal-footer " id="footer-modal-address"></div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL PARA EDITAR COMPANIA -->
    <div class="modal" tabindex="-1" role="dialog" id="company-edit-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="form-edit-company" data-action="{{route('companies.get')}}">
                <input type="hidden" id="form-edit-company-id" value="">
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title" id="company-edit-modal-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="company-edit-modal-body">
                    </div>
                    <div class="modal-footer" id="company-edit-modal-footer">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL PARA EDITAR ENDEREÇO -->
    <div class="modal" tabindex="-1" role="dialog" id="address-edit-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="form-edit-address" data-action="{{route('addresses.get')}}">
                <input type="hidden" id="form-edit-address-id" value="">
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title" id="address-edit-modal-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="address-edit-modal-body">
                    </div>
                    <div class="modal-footer" id="address-edit-modal-footer">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL PARA EDITAR USUÁRIO -->
    <div class="modal" tabindex="-1" role="dialog" id="user-edit-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="form-edit" data-action="{{route('users.get')}}">
                    <input type="hidden" id="form-edit-id" value="">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="user-edit-modal-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="user-edit-modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Edit User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    window.user = {!! json_encode(auth()->user()) !!};
</script>
@endsection
