<?php
session_start();
require_once 'config/db.php';

// 1. Obtener datos del usuario (si está logueado)
$nombre_usuario = $_SESSION['nombre'] ?? 'Invitado';
$rol_usuario = $_SESSION['rol'] ?? 'guest';
$intereses_usuario = $_SESSION['intereses'] ?? ''; // Ej: "Tecnología, Deportes"

// Convertimos los intereses en un array para usarlos fácil
$mis_intereses = array_map('trim', explode(',', $intereses_usuario));

// 2. Función para obtener eventos por categoría
function obtenerEventos($conexion, $categoria = null, $limite = 10) {
    if ($categoria) {
        $sql = "SELECT * FROM eventos WHERE categoria = ? ORDER BY fecha DESC LIMIT ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("si", $categoria, $limite);
    } else {
        $sql = "SELECT * FROM eventos ORDER BY fecha DESC LIMIT ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $limite);
    }
    $stmt->execute();
    return $stmt->get_result();
}

// 3. Obtener la fila "RECOMENDADOS PARA TI" 
$eventos_recomendados = null;
if (!empty($intereses_usuario)) {
    // Creamos una consulta dinámica: WHERE categoria IN ('Tecnología', 'Deportes')
    $lista_intereses = "'" . implode("','", $mis_intereses) . "'";
    $sql_rec = "SELECT * FROM eventos WHERE categoria IN ($lista_intereses) ORDER BY fecha DESC LIMIT 10";
    $eventos_recomendados = $conexion->query($sql_rec);
}
?>

<?php include 'views/layout/header.php'; ?>

<nav>
    <div class="logo">NETFLIX-ESCOM</div>
    <div class="nav-links" style="display:flex; align-items:center; gap:20px; color:white;">
        <?php if($rol_usuario !== 'guest'): ?>
            <span>Hola, <b><?= htmlspecialchars($nombre_usuario) ?></b></span>
            <?php if($rol_usuario === 'organizador' || $rol_usuario === 'admin'): ?>
                <a href="views/admin/panel.php" class="btn-primary">Gestionar Eventos</a>
            <?php endif; ?>
            <a href="controllers/auth.php?accion=logout" style="color:#ff4d4d; font-weight:bold;">Salir</a>
        <?php else: ?>
            <a href="views/auth/login.php" class="btn-primary">Iniciar Sesión</a>
        <?php endif; ?>
    </div>
</nav>

<div class="hero" style="
    height: 60vh;
    background: linear-gradient(to top, #141414, transparent), url('assets/img/hero_bg.jpg');
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: flex-end;
    padding: 50px 4%;">
    
    <div style="max-width: 600px; margin-bottom: 40px;">
        <h1 style="font-size: 3.5rem; font-weight: bold; margin-bottom: 15px;">Hackathon 2026</h1>
        <p style="font-size: 1.2rem; margin-bottom: 20px; text-shadow: 2px 2px 4px black;">
            Demuestra tus habilidades en el evento más grande del año. 48 horas de código continuo.
        </p>
        <button class="btn-primary" style="font-size: 1.2rem; padding: 10px 30px;">
            ℹ️ Más Información
        </button>
    </div>
</div>

<div class="container" style="margin-top: -50px; position: relative; z-index: 10;">

    <?php if ($eventos_recomendados && $eventos_recomendados->num_rows > 0): ?>
        <div class="category-row">
            <h3 class="category-title" style="color: #98ca3f;">🔥 Recomendado para ti (Basado en tus gustos)</h3>
            <div class="scroll-container">
                <?php while ($ev = $eventos_recomendados->fetch_assoc()): ?>
                    <?php include 'views/layout/tarjeta_evento.php'; ?>
                <?php endwhile; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="category-row">
        <h3 class="category-title">💻 Tecnología y Desarrollo</h3>
        <div class="scroll-container">
            <?php 
                $res = obtenerEventos($conexion, 'Tecnología');
                while ($ev = $res->fetch_assoc()) { include 'views/layout/tarjeta_evento.php'; }
            ?>
        </div>
    </div>

    <div class="category-row">
        <h3 class="category-title">⚽ Deportes</h3>
        <div class="scroll-container">
            <?php 
                $res = obtenerEventos($conexion, 'Deportes');
                while ($ev = $res->fetch_assoc()) { include 'views/layout/tarjeta_evento.php'; }
            ?>
        </div>
    </div>

    <div class="category-row">
        <h3 class="category-title">🎭 Actividades Culturales</h3>
        <div class="scroll-container">
            <?php 
                $res = obtenerEventos($conexion, 'Cultural');
                while ($ev = $res->fetch_assoc()) { include 'views/layout/tarjeta_evento.php'; }
            ?>
        </div>
    </div>

</div>

<?php include 'views/layout/footer.php'; ?>