<?php
include "../models/conexion.php";
include 'menu.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css"/>
    <title>Crud Puntuaciones</title>
</head>
<body>
<div class="container mx-auto">
    <div class="mb-3 text-right">
        <a href="../controllers/pointsControllers/anadir.php" class="btn btn-outline btn-accent">Añadir Puntuaciones</a>
    </div>

    <?php
    if (isset($_GET['error']) && $_GET['error'] == 1) {
        echo '<div class="alert alert-error shadow-lg relative" id="error-alert">
                <div class="flex-1">
                    <span>Error: registro depende de esta informacion.</span>
                </div>
                <div class="absolute top-0 right-0 mt-2 mr-2">
                    <button class="btn btn-sm btn-ghost" onclick="closeAlert()">✕</button>
                </div>
              </div>';
    }
    ?>

    <!-- TEST TABLA -->
    <div class="overflow-x-auto">
        <table class="table">
            <!-- head -->
            <thead>
            <tr>
                <th>Tipo Puntuacion</th>
                <th>Puntos</th>
                <th>Id Partida</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sql = "SELECT * FROM PUNTUACIONES";
            $result = $conexion->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row["tipo_puntuacion"]) . "</td>
                            <td>" . htmlspecialchars($row["puntos"]) . "</td>
                            <td>" . htmlspecialchars($row["idPartidas"]) . "</td>
                            <td>
                                <a href='../controllers/pointsControllers/editar.php?id=" . urlencode($row["idPuntuaciones"]) . "' class='btn btn-outline'>Editar</a>
                                <a href='../controllers/pointsControllers/eliminar.php?id=" . urlencode($row["idPuntuaciones"]) . "' class='btn btn-outline btn-accent'>Eliminar</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>No hay Puntuaciones</td></tr>";
            }
            $conexion->close();
            ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.tailwindcss.com"></script>
<script>
    function closeAlert() {
        document.getElementById('error-alert').style.display = 'none';
    }
</script>
</body>
</html>
