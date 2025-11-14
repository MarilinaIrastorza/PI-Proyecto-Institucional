<?php 
if (isset($result) && $result) {
    $_SESSION["usuario"]=$result[0]["usuario"];
    $_SESSION["rol"] = $result[0]["id_rol"];
    header("Location: Usuario.php?action=student");
    exit;
}
if (isset($response)){
    echo $response["type"].": ". $response["message"];
}
?>
<style>
  /* Fondo general */
body {
  background: linear-gradient(to right, #e7c7a3ff, #dfb6a4ff);
  font-family: 'Segoe UI', sans-serif;
  margin: 0;
  padding: 0;
}

/* Contenedor del login */
.login-container {
  max-width: 400px;
  margin: 80px auto;
  padding: 30px;
  background-color: #ffffff;
  border-radius: 12px;
  box-shadow: 0 0 15px rgba(0,0,0,0.2);
}

/* Título */
.login-container h2 {
  text-align: center;
  font-size: 28px;
  margin-bottom: 20px;
  color: #333;
}

/* Campos */
.login-container input[type="text"],
.login-container input[type="password"] {
  width: 100%;
  padding: 12px;
  margin: 10px 0;
  font-size: 18px;
  border: 1px solid #ccc;
  border-radius: 8px;
}

/* Botón */
.login-container input[type="submit"] {
  width: 100%;
  padding: 12px;
  font-size: 18px;
  background-color: #4e54c8;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.login-container input[type="submit"]:hover {
  background-color: #3b3fc1;
}
</style>

<div class="login-container">
  <h2>Iniciar sesión</h2>
  <?php 
  if (isset($result) && $result) {
      $_SESSION["usuario"] = $result[0]["usuario"];
      $_SESSION["rol"] = $result[0]["id_rol"];
      header("Location: Usuario.php?action=student");
      exit;
  }
  if (isset($response)) {
      echo "<div class='mensaje-error'>" . $response["type"] . ": " . $response["message"] . "</div>";
  }
  ?>

  <form name="frmAdd" method="post" action="index.php?action=login" id="frmAdd" onsubmit="return validate();">
    <label>Usuario</label>
    <span id="usuario-info" class="info"></span><br />
    <input type="text" name="usuario" id="usuario" class="demoInputBox">

    <label>Contraseña</label>
    <span id="password-info" class="info"></span><br />
    <input type="password" name="password" id="password" class="demoInputBox">

    <input type="submit" name="ingresar" id="btnSubmit" value="Ingresar" />
  </form>
</div>


<script src="https://code.jquery.com/jquery-2.1.1.min.js"
    type="text/javascript"></script>
<script>
    function validate() {
        var valid = true;
        $(".demoInputBox").css('background-color', '');
        $(".info").html('');

        if (!$("#usuario").val()) {
            $("#usuario-info").html("(requerido)");
            $("#usuario").css('background-color', '#FFFFDF');
            valid = false;
        }
        if (!$("#password").val()) {
            $("#password-info").html("(requerido)");
            $("#password").css('background-color', '#FFFFDF');
            valid = false;
        }
        return valid;
    }
</script>
</body>

</html>