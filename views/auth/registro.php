<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="auth-container">
    <div class="form-box">
        <h2 style="color:white; text-align:center;">Crear Cuenta</h2>
        
        <form action="/proyecto_final/controllers/auth.php" method="POST">
            <input type="hidden" name="accion" value="registro">

            <label style="color:#bbb;">Nombre Completo</label>
            <input type="text" name="nombre" required placeholder="Ej. Ana Pérez">

            <label style="color:#bbb;">Correo Institucional</label>
            <input type="email" name="correo" required placeholder="alumno@ipn.mx">

            <label style="color:#bbb;">Contraseña</label>
            <input type="password" name="password" required>

            <label style="color: var(--primary); font-weight: bold; margin-top:15px; display:block;">
                Selecciona tus intereses:
            </label>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin: 10px 0 20px 0; color: white;">
                <label><input type="checkbox" name="intereses[]" value="Tecnología" style="width:auto;"> Tecnología</label>
                <label><input type="checkbox" name="intereses[]" value="Deportes" style="width:auto;"> Deportes</label>
                <label><input type="checkbox" name="intereses[]" value="Cultural" style="width:auto;"> Cultural</label>
                <label><input type="checkbox" name="intereses[]" value="Ciencia" style="width:auto;"> Ciencia</label>
                <label><input type="checkbox" name="intereses[]" value="Hackathons" style="width:auto;"> Hackathons</label>
                <label><input type="checkbox" name="intereses[]" value="Social" style="width:auto;"> Social</label>
            </div>

            <button type="submit" class="submit-btn">Registrarme</button>
        </form>

        <p style="text-align:center; margin-top:20px; color:#bbb;">
            ¿Ya tienes cuenta? <a href="login.php" style="color:white; font-weight:bold;">Inicia Sesión</a>
        </p>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>