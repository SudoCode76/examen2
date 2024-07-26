<?php
include '../../models/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $password = $_POST['password'];


    $fecha_registro = $_POST['fecha_registro'];
    $fecha_registro = date("Y-m-d H:i:s", strtotime($fecha_registro));

    $sql = "INSERT INTO JUGADORES (nombre, apellido, email, password, fecha_registro) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssss", $nombre, $apellido, $email, $password, $fecha_registro);
    if ($stmt->execute()) {
        echo "Nuevo jugador añadido correctamente";
        header("Location: ../../views/jugadores.php");
        exit();
    } else {
        echo "Error al registrar: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Nuevo Jugador</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5">Añadir nuevo jugador</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="space-y-4">

        <div class="form-control">
            <label for="nombre" class="label">Nombre:</label>
            <input type="text" class="input input-bordered" id="nombre" name="nombre" required>
        </div>

        <div class="form-control">
            <label for="apellido" class="label">Apellido</label>
            <input type="text" class="input input-bordered" id="apellido" name="apellido" required>
        </div>

        <div class="form-control">
            <label for="email" class="label">Email</label>
            <input type="text" class="input input-bordered" id="email" name="email" required>
        </div>

        <div class="form-control">
            <label for="password" class="label">Password</label>
            <input type="password" class="input input-bordered" id="password" name="password" required>
        </div>

        <div class="form-control">
            <label for="fecha_registro" class="label">Fecha de Registro</label>
            <input type="datetime-local" class="input input-bordered" id="fecha_registro" name="fecha_registro" required>
        </div>

        <button type="submit" class="btn btn-primary">Añadir</button>
    </form>
</div>

<script src="https://cdn.tailwindcss.com"></script>
</body>
</html>
