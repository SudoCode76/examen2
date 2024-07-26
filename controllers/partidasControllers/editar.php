<?php
include '../../models/conexion.php';

$error = $success = '';
$fecha_partida = $puntuacion = $nivel = $idJugador = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idPartidas = $_POST['idPartidas'];
    $fecha_partida = $_POST['fecha_partida'];
    $puntuacion = $_POST['puntuacion'];
    $nivel = $_POST['nivel'];
    $idJugador = $_POST['idJugador'] === "none" ? NULL : $_POST['idJugador'];

    if (empty($fecha_partida) || !is_numeric($puntuacion) || !is_numeric($nivel)) {
        $error = "Por favor, complete todos los campos correctamente.";
    } else {
        $sql = "UPDATE PARTIDAS SET fecha_partida=?, puntuacion=?, nivel=?, idJugador=? WHERE idPartidas=?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("siiis", $fecha_partida, $puntuacion, $nivel, $idJugador, $idPartidas);

        if ($stmt->execute()) {
            $success = "Partida actualizada correctamente.";
            header("refresh:2;url=../../views/partidas.php");
        } else {
            $error = "Error al actualizar: " . $stmt->error;
        }

        $stmt->close();
    }
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM PARTIDAS WHERE idPartidas=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $fecha_partida = $row['fecha_partida'];
        $puntuacion = $row['puntuacion'];
        $nivel = $row['nivel'];
        $idJugador = $row['idJugador'] ? $row['idJugador'] : "none";
    } else {
        $error = "Partida no encontrada";
    }

    $stmt->close();
} else {
    $error = "ID de partida no especificado";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Partida</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5">Editar Partida</h1>

    <?php if ($error): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <?php if (!$error || $error === "Por favor, complete todos los campos correctamente."): ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $id); ?>" class="space-y-4">
            <input type="hidden" name="idPartidas" value="<?php echo htmlspecialchars($id); ?>">

            <div class="form-control">
                <label for="fecha_partida" class="label">Fecha de partida:</label>
                <input type="datetime-local" class="input input-bordered" id="fecha_partida" name="fecha_partida"
                       value="<?php echo htmlspecialchars($fecha_partida); ?>" required>
            </div>

            <div class="form-control">
                <label for="puntuacion" class="label">Puntuación:</label>
                <input type="number" class="input input-bordered" id="puntuacion" name="puntuacion"
                       value="<?php echo htmlspecialchars($puntuacion); ?>" required>
            </div>

            <div class="form-control">
                <label for="nivel" class="label">Nivel:</label>
                <input type="number" class="input input-bordered" id="nivel" name="nivel"
                       value="<?php echo htmlspecialchars($nivel); ?>" required>
            </div>

            <div class="form-control">
                <label for="idJugador" class="label">Jugador:</label>
                <select class="select select-bordered" id="idJugador" name="idJugador" required>
                    <option value="none" <?php echo $idJugador === "none" ? "selected" : ""; ?>>Ninguno</option>
                    <?php
                    $sql = "SELECT idJugador, nombre FROM JUGADORES";
                    $result = $conexion->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . htmlspecialchars($row["idJugador"]) . "' " . ($idJugador == $row["idJugador"] ? "selected" : "") . ">" . htmlspecialchars($row["nombre"]) . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
    <?php endif; ?>
</div>

<script src="https://cdn.tailwindcss.com"></script>
</body>
</html>