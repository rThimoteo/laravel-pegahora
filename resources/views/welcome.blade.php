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
            {{-- <br>
            <span class="hora">{{dia}}<br>{{hora}}</span>
            <br> --}}
            <br>
            <p id="dados-cep"></p>
        </div>

        <div class="row">
            <div class="col-4">
                <h4>Users List</h4>
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
                        <th>
                            <button id="order-name" class="btn-order py-2">
                                <div class="container">
                                    <div class="row">
                                        <div class="col align-self-center">
                                            Name
                                        </div>
                                        <div class="col">
                                            <div class="row order-up"><i id="btn-name-za" class="fas ml-1 fa-sort-up fa-lg"></i></div>
                                            <div class="row order-down"><i id="btn-name-az" class="fas ml-1 fa-sort-down fa-lg icon-order-active"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </button>
                        </th>
                        <th>
                            <button id="order-username" class="btn-order py-2">
                                <div class="container">
                                    <div class="row">
                                        <div class="col align-self-center">
                                            Username
                                        </div>
                                        <div class="col">
                                            <div class="row order-up"><i id="btn-username-za" class="fas ml-1 fa-sort-up fa-lg"></i></div>
                                            <div class="row order-down"><i id="btn-username-az" class="fas ml-1 fa-sort-down fa-lg"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </button>
                        </th>
                        <th>
                            <button id="order-email" class="btn-order py-2">
                                <div class="container">
                                    <div class="row">
                                        <div class="col align-self-center">
                                            Email
                                        </div>
                                        <div class="col">
                                            <div class="row order-up"><i id="btn-email-za" class="fas ml-1 fa-sort-up fa-lg"></i></div>
                                            <div class="row order-down"><i id="btn-email-az" class="fas ml-1 fa-sort-down fa-lg"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </button>
                        </th>
                        <th class="align-middle"><div class="aling-center">Actions</div></th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <div class="container text-center">
                <div id="pagination" class="pagination">

                </div>
            </div>
        </div>
    </div>

@endsection
