<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">.
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Log In - Pegahora</title>
    <link rel="stylesheet" href="/styles/global.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="text-center div-login">
        <form class="form-signin">
            <h1 class="h3 mb-3 font-weight-normal">Login</h1>
            <label for="inputEmail" class="sr-only">Name</label>
            <input type="text" id="input-name" class="form-control" placeholder="Name" required="" autofocus="">
            <label for="inputEmail" class="sr-only">Username</label>
            <input type="text" id="input-username" class="form-control" placeholder="Username" required="">
            <label for="inputEmail" class="sr-only">E-mail</label>
            <input type="text" id="input-email" class="form-control" placeholder="E-mail" required="">
            <label for="inputEmail" class="sr-only">Phone</label>
            <input type="text" id="input-phone" class="form-control" placeholder="Phone Number" required="">
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="input-password" class="form-control" placeholder="Password" required="">
            <label for="inputPassword" class="sr-only">Confirm Password</label>
            <input type="password" id="input-confirm-password" class="form-control" placeholder="Confirm Password" required="">
            <label for="inputEmail" class="sr-only">Website</label>
            <input type="text" id="input-website" class="form-control" placeholder="Website (Optional)" >
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        </form>
    </div>

    <script src="/js/libs/jquery-3.6.0.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
    <script src="/js/login.js"></script>
</body>

</html>
