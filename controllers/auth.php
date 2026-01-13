<?php

session_start();
require_once '../config/db.php'; // Subimos un nivel para buscar la config

$accion = $_POST['accion'] ?? '';

// ==========================================
// 1. REGISTRO DE USUARIO (Con Intereses)
// ==========================================
if ($accion === 'registro') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $rol = 'estudiante'; // Por defecto
    
    // Convertimos el array de checkbox a texto: "Deportes, Tecnología"
    $intereses = isset($_POST['intereses']) ? implode(", ", $_POST['intereses']) : "";

    // Insertar en la tabla USUARIOS
    $sql = "INSERT INTO usuarios (nombre, correo, password, rol, intereses) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssss", $nombre, $correo, $password, $rol, $intereses);

    if ($stmt->execute()) {
        // Auto-login: Iniciar sesión inmediatamente después de registrarse
        $_SESSION['id_usuario'] = $conexion->insert_id;
        $_SESSION['nombre'] = $nombre;
        $_SESSION['rol'] = $rol;
        $_SESSION['intereses'] = $intereses; // ¡Guardamos esto en sesión para filtrar Netflix!

        // Redirigir al Home
        header("Location: /proyecto_final/index.php");
        exit;
    } else {
        // Si el correo ya existe (error de duplicado)
        echo "<script>alert('Error: El correo ya está registrado.'); window.history.back();</script>";
    }
}

// ==========================================
// 2. INICIO DE SESIÓN
// ==========================================
if ($accion === 'login') {
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE correo = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($usuario = $resultado->fetch_assoc()) {
        if (password_verify($password, $usuario['password'])) {
            // Login correcto
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];
            $_SESSION['intereses'] = $usuario['intereses'];

            header("Location: /proyecto_final/index.php");
            exit;
        }
    }

    // Login fallido
    echo "<script>alert('Correo o contraseña incorrectos.'); window.history.back();</script>";
}

// ==========================================
// 3. CERRAR SESIÓN
// ==========================================
if ($accion === 'logout') {
    session_destroy();
    header("Location: /proyecto_final/views/auth/login.php");
    exit;
}
?>