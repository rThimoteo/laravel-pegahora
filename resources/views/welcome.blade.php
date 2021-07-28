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

@endsection
