<?php
include '../../models/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['idJugador'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $fecha_registro = $_POST['fecha_registro'];

    $sql = "UPDATE JUGADORES SET nombre=?, apellido=?, email=?, password=?, fecha_registro=? WHERE idJugador=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssssi", $nombre, $apellido, $email, $password, $fecha_registro, $id);

    if ($stmt->execute()) {
        $success = "Jugador actualizado correctamente.";
        // Redirigir después de un breve retraso
        header("refresh:2;url=../../views/jugadores.php");
    } else {
        $error = "Error al actualizar: " . $stmt->error;
    }

    $stmt->close();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta SQL para obtener los datos del jugador por su ID
    $sql = "SELECT * FROM JUGADORES WHERE idJugador=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró el jugador
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $nombre = $row['nombre'];
        $apellido = $row['apellido'];
        $email = $row['email'];
        $password = $row['password'];
        $fecha_registro = $row['fecha_registro'];
    } else {
        $error = "Jugador no encontrado";
    }

    $stmt->close();
} else {
    $error = "ID de jugador no especificado";
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Prenda</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5">Editar prenda</h1>

    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $id); ?>" class="space-y-4">
        <input type="hidden" name="idJugador" value="<?php echo htmlspecialchars($id); ?>">


        <div class="form-control">
            <label for="nombre" class="label">Nombre:</label>
            <input type="text" class="input input-bordered" id="nombre" name="nombre"
                   value="<?php echo htmlspecialchars($nombre); ?>" required>
        </div>

        <div class="form-control">
            <label for="apellido" class="label">apellido:</label>
            <input type="text" class="input input-bordered" id="apellido" name="apellido"
                   value="<?php echo htmlspecialchars($apellido); ?>" required>
        </div>

        <div class="form-control">
            <label for="email" class="label">email:</label>
            <input type="text" class="input input-bordered" id="email" name="email"
                   value="<?php echo htmlspecialchars($email); ?>" required>
        </div>

        <div class="form-control">
            <label for="password" class="label">password:</label>
            <input type="password" class="input input-bordered" id="password" name="password"
                   value="<?php echo htmlspecialchars($password); ?>" required>
        </div>

        <div class="form-control">
            <label for="fecha_registro" class="label">fecha_registro:</label>
            <input type="datetime-local" class="input input-bordered" id="fecha_registro" name="fecha_registro"
                   value="<?php echo htmlspecialchars($fecha_registro); ?>" required>
        </div>



        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>

<script src="https://cdn.tailwindcss.com"></script>
</body>
</html>
