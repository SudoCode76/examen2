<?php
include '../../models/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo_puntuacion = $_POST['tipo_puntuacion'];
    $puntos = $_POST['puntos'];
    $idPartidas = $_POST['idPartidas'];


    $sql = "INSERT INTO PUNTUACIONES (tipo_puntuacion, puntos, idPartidas) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sii",$tipo_puntuacion, $puntos, $idPartidas);
    if ($stmt->execute()) {
        echo "Nuevos puntos añadido correctamente";
        header("Location: ../../views/puntuaciones.php");
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
    <title>Añadir Nueva Partida</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5">Añadir nueva puntuacion</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="space-y-4">

        <div class="form-control">
            <label for="tipo_puntuacion" class="label">tipo_puntuacion:</label>
            <input type="text" class="input input-bordered" id="tipo_puntuacion" name="tipo_puntuacion" required>
        </div>

        <div class="form-control">
            <label for="puntos" class="label">puntos</label>
            <input type="number" class="input input-bordered" id="puntos" name="puntos" required>
        </div>


        <div class="form-control">
            <label for="idPartidas" class="label">idPartidas:</label>
            <select class="select select-bordered" id="idPartidas" name="idPartidas" required>
                <?php
                $sql = "SELECT idPartidas, fecha_partida, puntuacion FROM PARTIDAS";
                $result = $conexion->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row["idPartidas"]) . "'>" .
                            htmlspecialchars($row["fecha_partida"]) . " " .
                            htmlspecialchars($row["puntuacion"]) . "</option>";
                    }
                }
                ?>
            </select>
        </div>






        <button type="submit" class="btn btn-primary">Añadir</button>
    </form>
</div>

<script src="https://cdn.tailwindcss.com"></script>
</body>
</html>