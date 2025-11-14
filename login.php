<?php
session_start();

// Simulación de resultado de login (reemplazar con lógica real)
if (isset($result) && $result) {
    // Guardar datos del usuario en la sesión
    $_SESSION["Usuario"] = $result[0]["usuario"];
    $_SESSION["Rol"] = $result[0]["id_rol"];

    // Redirigir al panel de usuarios
    header("Location: ../mainfile/index.php?action=usuario");
    exit;
}



// Mostrar mensaje de error si existe
if (isset($response)) {
    echo "<div class='alert {$response['type']}'>{$response['message']}</div>";
}
?>

<!-- Formulario de login -->
<form name="frmLogin" method="post" action="../mainfile/index.php?action=login" id="frmLogin" onsubmit="return validate();">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div>
        <label for="usuario" style="padding-top: 20px;">Usuario</label>
        <span id="usuario-info" class="info"></span><br />
        <input type="text" name="usuario" id="usuario" class="demoInputBox" autocomplete="username">
    </div>

    <div>
        <label for="password">Contraseña</label>
        <span id="password-info" class="info"></span><br />
        <input type="password" name="password" id="password" class="demoInputBox" autocomplete="current-password">
    </div>

    <div>
        <input type="submit" name="ingresar" id="btnSubmit" value="Ingresar">
    </div>
</form>

<!-- jQuery para validación -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Validación del formulario -->
<script>
function validate() {
    let valid = true;

    $(".demoInputBox").css('background-color', '');
    $(".info").html('');

    if (!$("#usuario").val().trim()) {
        $("#usuario-info").html("(requerido)");
        $("#usuario").css('background-color', '#FFFFDF');
        valid = false;
    }

    if (!$("#password").val().trim()) {
        $("#password-info").html("(requerido)");
        $("#password").css('background-color', '#FFFFDF');
        valid = false;
    }

    return valid;
}
</script>