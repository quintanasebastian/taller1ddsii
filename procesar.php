<?php
require_once 'conexion.php';

if ($_POST) {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $curso = $_POST['curso'];

    try {
        $sql = "INSERT INTO estudiantes (nombre, email, telefono, curso) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$nombre, $email, $telefono, $curso]);
        
        $mensaje = "Estudiante matriculado exitosamente. ID: " . $conexion->lastInsertId();
        $tipo = "exito";
    } catch(PDOException $e) {
        $mensaje = "Error: " . $e->getMessage();
        $tipo = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado</title>
    <link rel="stylesheet" href="matricula.html"> <!-- Reusa el CSS -->
</head>
<body>
    <div class="form-container">
        <h1>Resultado de Matrícula</h1>
        <div class="mensaje <?php echo $tipo; ?>"><?php echo $mensaje; ?></div>
        <a href="matricula.html"><button>Volver al formulario</button></a>
    </div>
</body>
</html>
