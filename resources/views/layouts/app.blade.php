<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/styles/global.css" />
    @yield('css')

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <a class="navbar-brand px-2" href="{{ url('/addresses') }}">
                            Addresses
                        </a>
                        <a class="navbar-brand px-2" href="{{ url('/companies') }}">
                            Companies
                        </a>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" id="drop-user" aria-labelledby="navbarDropdown">
                                    <a id="logout" class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    {{-- MODAIS --}}
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

    <!-- Scripts -->
    <script src="/js/libs/jquery-3.6.0.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
    <script src="/js/app.js"></script>

    <script>
        window.user = {!! json_encode(auth()->user()) !!};
    </script>
    @yield('js')

</body>
</html>
