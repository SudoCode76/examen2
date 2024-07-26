<?php
include '../../models/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha_partida = $_POST['fecha_partida'];
    $fecha_partida = date("Y-m-d H:i:s", strtotime($fecha_partida));

    $puntuacion = $_POST["puntuacion"];
    $nivel = $_POST["nivel"];
    $idJugador  = $_POST["idJugador"];



    $sql = "INSERT INTO PARTIDAS (fecha_partida, puntuacion, nivel, idJugador) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssss", $fecha_partida, $puntuacion, $nivel, $idJugador);
    if ($stmt->execute()) {
        echo "Nueva partida añadido correctamente";
        header("Location: ../../views/partidas.php");
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
    <h1 class="text-2xl font-bold mb-5">Añadir nueva Partida</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="space-y-4">

        <div class="form-control">
            <label for="fecha_partida" class="label">fecha_partida:</label>
            <input type="datetime-local" class="input input-bordered" id="fecha_partida" name="fecha_partida" required>
        </div>

        <div class="form-control">
            <label for="puntuacion" class="label">puntuacion</label>
            <input type="number" class="input input-bordered" id="puntuacion" name="puntuacion" required>
        </div>

        <div class="form-control">
            <label for="nivel" class="label">nivel</label>
            <input type="number" class="input input-bordered" id="nivel" name="nivel" required>
        </div>

        <div class="form-control">
            <label for="idJugador" class="label">Jugador:</label>
            <select class="select select-bordered" id="idJugador" name="idJugador" required>
                <?php
                $sql = "SELECT idJugador, nombre, apellido FROM JUGADORES";
                $result = $conexion->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row["idJugador"]) . "'>" .
                            htmlspecialchars($row["nombre"]) . " " .
                            htmlspecialchars($row["apellido"]) . "</option>";
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