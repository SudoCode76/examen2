<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../style/dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="navbar bg-base-100">
    <div class="navbar-start">
        <a class="btn btn-ghost text-xl">daisyUI</a>
    </div>
    <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal px-1">

            <li><a href="../views/jugadores.php">Jugadores</a></li>
            <li><a href="../views/partidas.php">Partidas</a></li>
            <li><a href="../views/prendas.php">Puntuaciones</a></li>
        </ul>
    </div>
    <div class="navbar-end">
        <a class="btn" href="../views/login.php">Logout</a>
    </div>
</div>

<script src="https://cdn.tailwindcss.com"></script>
</body>
</html>
