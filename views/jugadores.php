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
    <title>Crud Jugadores</title>
</head>
<body>
<div class="container mx-auto">
    <div class="mb-3 text-right">
        <a href="../controllers/jugadoresControllers/anadir.php" class="btn btn-outline btn-accent">Añadir jugadores</a>
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
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Password</th>
                <th>Fecha Registro</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sql = "SELECT * FROM JUGADORES";
            $result = $conexion->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row["nombre"]) . "</td>
                            <td>" . htmlspecialchars($row["apellido"]) . "</td>
                            <td>" . htmlspecialchars($row["email"]) . "</td>
                            <td>" . htmlspecialchars($row["password"]) . "</td>
                            <td>" . htmlspecialchars($row["fecha_registro"]) . "</td>
                            <td>
                                <a href='../controllers/jugadoresControllers/editar.php?id=" . urlencode($row["idJugador"]) . "' class='btn btn-outline'>Editar</a>
                                <a href='../controllers/jugadoresControllers/eliminar.php?id=" . urlencode($row["idJugador"]) . "' class='btn btn-outline btn-accent'>Eliminar</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>No hay jugadores</td></tr>";
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
