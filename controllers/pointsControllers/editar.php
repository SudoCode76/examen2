<?php
include '../../models/conexion.php';

$error = $success = '';
$tipo_puntuacion = $puntos = '';
$idPartidas = 'none';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idPuntuaciones = $_POST['idPuntuaciones'];
    $tipo_puntuacion = $_POST['tipo_puntuacion'];
    $puntos = $_POST['puntos'];
    $idPartidas = $_POST['idPartidas'] === "none" ? NULL : $_POST['idPartidas'];

    if (empty($tipo_puntuacion) || !is_numeric($puntos)) {
        $error = "Por favor, complete todos los campos correctamente.";
    } else {
        $sql = "UPDATE PUNTUACIONES SET tipo_puntuacion=?, puntos=?, idPartidas=? WHERE idPuntuaciones=?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("siis", $tipo_puntuacion, $puntos, $idPartidas, $idPuntuaciones);

        if ($stmt->execute()) {
            $success = "Puntuación actualizada correctamente.";
            header("refresh:2;url=../../views/puntuaciones.php");
        } else {
            $error = "Error al actualizar: " . $stmt->error;
        }

        $stmt->close();
    }
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM PUNTUACIONES WHERE idPuntuaciones=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $tipo_puntuacion = $row['tipo_puntuacion'];
        $puntos = $row['puntos'];
        $idPartidas = $row['idPartidas'] ? $row['idPartidas'] : "none";
    } else {
        $error = "Puntuación no encontrada";
    }

    $stmt->close();
} else {
    $error = "ID de puntuación no especificado";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Puntuación</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5">Editar Puntuación</h1>

    <?php if ($error): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <?php if (!$error || $error === "Por favor, complete todos los campos correctamente."): ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $id); ?>" class="space-y-4">
            <input type="hidden" name="idPuntuaciones" value="<?php echo htmlspecialchars($id); ?>">

            <div class="form-control">
                <label for="tipo_puntuacion" class="label">Tipo de puntuación:</label>
                <input type="text" class="input input-bordered" id="tipo_puntuacion" name="tipo_puntuacion"
                       value="<?php echo htmlspecialchars($tipo_puntuacion); ?>" required>
            </div>

            <div class="form-control">
                <label for="puntos" class="label">Puntos:</label>
                <input type="number" class="input input-bordered" id="puntos" name="puntos"
                       value="<?php echo htmlspecialchars($puntos); ?>" required>
            </div>

            <div class="form-control">
                <label for="idPartidas" class="label">Partida:</label>
                <select class="select select-bordered" id="idPartidas" name="idPartidas" required>
                    <option value="none" <?php echo $idPartidas === "none" ? "selected" : ""; ?>>Ninguno</option>
                    <?php
                    $sql = "SELECT idPartidas, fecha_partida FROM PARTIDAS";
                    $result = $conexion->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . htmlspecialchars($row["idPartidas"]) . "' " . ($idPartidas == $row["idPartidas"] ? "selected" : "") . ">" . htmlspecialchars($row["fecha_partida"]) . "</option>";
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