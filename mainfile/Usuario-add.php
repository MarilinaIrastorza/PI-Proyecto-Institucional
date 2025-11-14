<?php
// Inicia la sesión y verifica si el usuario tiene rol de administrador
session_start();
require_once "header.php";

// Validación de acceso: solo rol 1 (admin) puede ver el formulario
if (!isset($_SESSION["id_rol"]) || $_SESSION["id_rol"] != 1) {
    echo "<div style='color:red; font-weight:bold;'>Acceso denegado. Esta sección es solo para administradores.</div>";
    exit;
}

// Procesamiento del formulario si se envió
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["add"])) {
    if ($_SESSION["id_rol"] != 1) {
        echo "<div style='color:red;'>No tenés permisos para agregar usuarios.</div>";
        exit;
    }

    // Aquí iría la lógica para insertar el nuevo usuario en la base de datos
    // Ejemplo:
    // $usuario = $_POST["usuario"];
    // $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    // $rol = $_POST["id_rol"];
    // INSERT INTO usuarios (usuario, password, id_rol) VALUES (...)

    echo "<div style='color:green;'>Usuario agregado correctamente.</div>";
}
?>

<!-- Formulario para agregar un nuevo usuario al sistema -->
<form name="frmAdd" method="post" action="" id="frmAdd" onSubmit="return validate();">
    <!-- Contenedor para mostrar mensajes de estado del envío -->
    <div id="mail-status"></div>

    <!-- Campo de entrada para el nombre de usuario -->
    <div>
        <label style="padding-top: 20px;">Usuario</label>
        <span id="usuario-info" class="info"></span><br />
        <input type="text" name="usuario" id="usuario" class="demoInputBox">
    </div>

    <!-- Campo de entrada para la contraseña -->
    <div>
        <label>Contraseña</label>
        <span id="password-info" class="info"></span><br />
        <input type="password" name="password" id="password" class="demoInputBox">
    </div>

    <!-- Selector desplegable para elegir el rol del usuario -->
    <div>
        <label>Rol</label>
        <span id="rol-info" class="info"></span><br />
        <select name="id_rol" id="id_rol">
            <?php
            /**
             * @var array $result1 Lista de roles obtenida previamente desde la base de datos.
             * Itera sobre cada fila y genera una opción en el <select>.
             */
            foreach ($result1 as $fila) {
                echo "<option value='" . $fila["id"] . "'>" . $fila["rol"] . "</option>";
            }
            ?>
        </select>
    </div>

    <!-- Botón para enviar el formulario -->
    <div>
        <input type="submit" name="add" id="btnSubmit" value="Agregar" />
    </div>
</form>

<!-- Inclusión de jQuery para facilitar la manipulación del DOM -->
<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>

<script>
/**
 * Función de validación del formulario antes del envío.
 * Verifica que los campos 'usuario' y 'password' no estén vacíos.
 * Verifica que el rol seleccionado sea 1 (admin).
 * @returns {boolean} true si el formulario es válido, false si hay errores.
 */
function validate() {
    var valid = true;

    // Resetea estilos y mensajes previos
    $(".demoInputBox").css('background-color', '');
    $(".info").html('');

    // Validación del campo 'usuario'
    if (!$("#usuario").val()) {
        $("#usuario-info").html("(requerido)");
        $("#usuario").css('background-color', '#FFFFDF');
        valid = false;
    }

    // Validación del campo 'password'
    if (!$("#password").val()) {
        $("#password-info").html("(requerido)");
        $("#password").css('background-color', '#FFFFDF');
        valid = false;
    }

    // Validación del rol: solo se permite si el rol seleccionado es 1
    if ($("#id_rol").val() !== "1") {
        $("#rol-info").html("(solo permitido para rol Admin)");
        $("#id_rol").css('background-color', '#FFFFDF');
        valid = false;
    }

    return valid;
}
</script>

</body>
</html>