<?php
require_once 'conexion.php';

$mensaje = '';
$tipo = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $curso = trim($_POST['curso']);

    if (empty($nombre) || empty($email) || empty($curso)) {
        $mensaje = "Todos los campos obligatorios deben llenarse.";
        $tipo = "error";
    } else {
        try {
            $sql = "INSERT INTO estudiantes (nombre, email, telefono, curso) VALUES (?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$nombre, $email, $telefono, $curso]);
            
            $mensaje = "¡Estudiante matriculado exitosamente! ID: " . $conexion->lastInsertId();
            $tipo = "exito";
        } catch(PDOException $e) {
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                $mensaje = "El email ya está registrado. Usa otro.";
            } else {
                $mensaje = "Error al matricular: " . $e->getMessage();
            }
            $tipo = "error";
        }
    }
} else {
    $mensaje = "Acceso directo no permitido. Usa el formulario.";
    $tipo = "error";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de Matrícula</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; background: #f4f4f4; }
        .form-container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); text-align: center; }
        h1 { color: #333; }
        .mensaje { margin: 20px 0; padding: 15px; border-radius: 5px; font-weight: bold; }
        .exito { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        button { background: #007bff; color: white; padding: 12px 24px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; text-decoration: none; display: inline-block; }
        button:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Resultado de Matrícula</h1>
        <div class="mensaje <?php echo $tipo; ?>"><?php echo htmlspecialchars($mensaje); ?></div>
        <a href="matricula.html"><button>Volver al formulario</button></a>
    </div>
</body>
</html>
