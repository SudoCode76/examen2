<?php
include '../../models/conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql_check = "SELECT COUNT(*) as numJugador FROM PUNTUACIONES WHERE idPartida=?";
    $stmt_check = $conexion->prepare($sql_check);
    $stmt_check->bind_param("i", $id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row_check = $result_check->fetch_assoc();

    if ($row_check['numPartidos'] > 0) {
        header("Location: ../../views/partidas.php?error=1");
        exit();
    } else {
        $sql = "DELETE FROM PARTIDAS WHERE idPartidas=?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            // Redirigir de vuelta a la página principal después de eliminar
            header("Location: ../../views/partidas.php");
            exit();
        } else {
            // Manejar el error si la consulta no se ejecuta correctamente
            echo "Error al intentar eliminar: " . $stmt->error;
        }

        $stmt->close();
    }

    $stmt_check->close();
} else {
    // Manejar caso de que no se haya proporcionado ID
    echo "ID no especificado";
    exit();
}

$conexion->close();
?>
