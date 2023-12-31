<!DOCTYPE html>
<html>
<head>

    <title>Veste-me</title>
    <link rel="icon" type="image/x-icon" href="associate/img/Logo Veste-me - Círculo - Preta.png">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

   <!-- CSS -->
   <link rel="stylesheet" href="public/associate/css/login.css">

   <!-- Fonte -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

   <!-- icons -->
   <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined">
   <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp">

</head>
<body>

<div class="login">
    <div class="image">
        <img src="public/associate/img/Logo Veste-me - Círculo - Preta.png" alt="">
    </div>

    <form method="POST" action="{{ route('admin.loginpost') }}">
        @csrf

        <div class="row">
            <i class="material-icons-sharp">person</i>
            <input type="email" name="email" placeholder="E-mail" required>
        </div>

        <div class="row">
            <i class="material-icons-sharp">lock</i>
            <input type="password" name="senha" placeholder="Senha" required>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="color: black;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <button type="submit">Entrar</button>
            <a href="#">Esqueceu sua senha?</a>
        </div>
    </form>
</div>

</body>

</html>