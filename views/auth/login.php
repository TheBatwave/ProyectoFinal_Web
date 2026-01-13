<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="auth-container">
    <div class="form-box">
        <h2 style="color:white; text-align:center;">Bienvenido</h2>
        
        <form action="/proyecto_final/controllers/auth.php" method="POST">
            <input type="hidden" name="accion" value="login">

            <label style="color:#bbb;">Correo</label>
            <input type="email" name="correo" required>

            <label style="color:#bbb;">Contraseña</label>
            <input type="password" name="password" required>

            <button type="submit" class="submit-btn">Entrar</button>
        </form>

        <p style="text-align:center; margin-top:20px; color:#bbb;">
            ¿Nuevo por aquí? <a href="registro.php" style="color:white; font-weight:bold;">Regístrate</a>
        </p>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>