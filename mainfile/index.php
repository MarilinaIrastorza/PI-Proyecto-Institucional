<?php include_once('../php/includes/variables_globales.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="../mainfile/css/estilos_de_contenido.css">
  <link rel="stylesheet" href="../mainfile/css/estilos_de_maquetas.css">
  
</head>
<body>
  <header>
    <h1 class="nombre_sitio"><?= $nombre_sitio ?></h1>
    <h2 class="nombre_secundario"><?= $nombre_secundario ?></h2>
  </header>

  <nav class="nav"><?= $nav_menu ?></nav>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inclusión de modelos con rutas absolutas seguras
require_once(__DIR__ . '/../Modelo/DBController.php');
require_once(__DIR__ . '/../Modelo/Student.php');
require_once(__DIR__ . '/../Modelo/Attendance.php');
require_once(__DIR__ . '/../Modelo/Usuario.php');
require_once(__DIR__ . '/../Modelo/Rol.php');

$db_handle = new DBController();

$action = "login";
if (!empty($_GET["action"]) && isset($_SESSION["usuario"])) {
    $action = $_GET["action"];
}
switch ($action) {
    case "attendance-add":
        if (isset($_POST['add'])) {
            $attendance = new Attendance();
            
            $attendance_timestamp = strtotime($_POST["attendance_date"]);
            $attendance_date = date("Y-m-d", $attendance_timestamp);
            
            if(!empty($_POST["student_id"])) {
                $attendance->deleteAttendanceByDate($attendance_date);
                foreach($_POST["student_id"] as $k=> $student_id) {
                    $present = 0;
                    $absent = 0;
                    
                    if($_POST["attendance-$student_id"] == "present") {
                        $present = 1;
                    }
                    else if($_POST["attendance-$student_id"] == "absent") {
                        $absent = 1;
                    }
                    
                    $attendance->addAttendance($attendance_date, $student_id, $present, $absent);
                }
            }
            header("Location: index.php?action=attendance");
        }
        $student = new Student();
        $studentResult = $student->getAllStudent();
        require_once "attendance-add.php";
        break;
    
    case "attendance-edit":
        $attendance_date = $_GET["date"];
        $attendance = new Attendance();
        if (isset($_POST['add'])) {
            $attendance->deleteAttendanceByDate($attendance_date);
            if(!empty($_POST["student_id"])) {
                foreach($_POST["student_id"] as $k=> $student_id) {
                    $present = 0;
                    $absent = 0;
                    
                    if($_POST["attendance-$student_id"] == "present") {
                        $present = 1;
                    }
                    else if($_POST["attendance-$student_id"] == "absent") {
                        $absent = 1;
                    }
                    
                    $attendance->addAttendance($attendance_date, $student_id, $present, $absent);
                }
            }
            header("Location: index.php?action=attendance");
        }
        
        $result = $attendance->getAttendanceByDate($attendance_date);
        
        $student = new Student();
        $studentResult = $student->getAllStudent();
        require_once "attendance-edit.php";
        break;
    
    case "attendance-delete":
        $attendance_date = $_GET["date"];
        $attendance = new Attendance();
        $attendance->deleteAttendanceByDate($attendance_date);
        
        $result = $attendance->getAttendance();
        require_once "attendance.php";
        break;
    
    case "attendance":
        $attendance = new Attendance();
        $result = $attendance->getAttendance();
        require_once "attendance.php";
        break;
    
    case "student-add":
        if (isset($_POST['add'])) {
            $name = $_POST['name'];
            $roll_number = $_POST['roll_number'];
            $dob = "";
            if ($_POST["dob"]) {
                $dob_timestamp = strtotime($_POST["dob"]);
                $dob = date("Y-m-d", $dob_timestamp);
            }
            $class = $_POST['class'];
            
            $student = new Student();
            $insertId = $student->addStudent($name, $roll_number, $dob, $class);
            if (empty($insertId)) {
                $response = array(
                    "message" => "Problema al agregar un nuevo registro",
                    "type" => "error"
                );
            } else {
                header("Location: index.php?action=student");
            }
        }
    
        require_once "student-add.php";
        break;
    
    case "student-edit":
        $student_id = $_GET["id"];
        $student = new Student();
        
        if (isset($_POST['add'])) {
            $name = $_POST['name'];
            $roll_number = $_POST['roll_number'];
            $dob = "";
            if ($_POST["dob"]) {
                $dob_timestamp = strtotime($_POST["dob"]);
                $dob = date("Y-m-d", $dob_timestamp);
            }
            $class = $_POST['class'];
            
            $student->editStudent($name, $roll_number, $dob, $class, $student_id);
            
            header("Location: index.php?action=student");
        }
        
        $result = $student->getStudentById($student_id);
        require_once "student-edit.php";
        break;

    case "student-delete":
        $student_id = $_GET["id"];
        $student = new Student();
        
        $student->deleteStudent($student_id);
        
        $result = $student->getAllStudent();
        require_once "student.php?action=student";
        break;

    case "login":
        if (isset($_GET['logout'])) {
            session_unset();
            session_destroy();
            header("Location: index.php");
            exit;
        }
        if (isset($_POST['ingresar'])) {
            $name = $_POST['usuario'];
            $password = $_POST['password'];

            $usuario = new Usuario();
            $result = $usuario->pwdVerify($name, $password);
            if (!isset($result) || !$result) {
                $response = array(
                    "message" => "Usuario o contraseña inexistente.",
                    "type" => "error"
                );
            } else {
                header("Location: index.php");
            }
        }
       require_once(__DIR__ . '/login.php');
        break;

    case "usuario":
        $usuario = new Usuario();
        $result = $usuario->getAllUsuario();
     
        require_once "usuario.php";
        break;

    case "usuario-add":
        if (isset($_POST['add'])) {
            $name = $_POST['usuario'];
            $password = $_POST['password'];
            $id_rol = $_POST['id_rol'];

            $usuario = new Usuario();
            $insertId = $usuario->addUsuario($name, $password, $id_rol);
            if (empty($insertId)) {
                $response = array(
                    "message" => "Problema al agregar un nuevo registro",
                    "type" => "error"
                );
            } else {
                header("Location: index.php?action=usuario");
            }
        }
        $rol = new Rol();
        $result1 = $rol->getAllRol();
        require_once "usuario-add.php";
        
        break;

    case "usuario-edit":
        $usuario_id = $_GET["id"];
        $usuario = new Usuario();

        if (isset($_POST['add'])) {
            $name = $_POST['usuario'];
            $password = $_POST['password'];
            $id_rol = $_POST['id_rol'];

            $usuario->editUsuario($name, $password, $id_rol, $usuario_id);

            header("Location: index.php?action=usuario");
        }
        $rol = new Rol();
        $result1 = $rol->getAllRol();
        $result = $usuario->getUsuarioById($usuario_id);
        require_once "usuario-edit.php";
        break;

    case "usuario-delete":
        $usuario_id = $_GET["id"];
        $usuario = new Usuario();

        $usuario->deleteUsuario($usuario_id);

        $result = $usuario->getAllUsuario();
        require_once "usuario.php";
        break;

    case "rol":
        $rol = new Rol();
        $result = $rol->getAllRol();
        require_once "rol.php";
        break;

    case "rol-add":
        if (isset($_POST['add'])) {
            $name = $_POST['rol'];

            $rol = new Rol();
            $insertId = $rol->addRol($name);
            if (empty($insertId)) {
                $response = array(
                    "message" => "Problema al agregar un nuevo registro",
                    "type" => "error"
                );
            } else {
                header("Location: index.php?action=rol");
            }
        }
        require_once "rol-add.php";
        break;

    case "rol-edit":
        $rol_id = $_GET["id"];
        $rol = new Rol();

        if (isset($_POST['add'])) {
            $name = $_POST['rol'];
            $rol->editRol($name, $rol_id);

            header("Location: index.php?action=rol");
        }

        $result = $rol->getRolById($rol_id);
        require_once "rol-edit.php";
        break;

    case "rol-delete":
        $rol_id = $_GET["id"];
        $rol = new Rol();

        $rol->deleteRol($rol_id);

        $result = $rol->getAllRol();
        require_once "rol.php";
        break;

    default:
        $student = new Student();
        $result = $student->getAllStudent();
        require_once "student.php";
        break;
}
?>
 <footer><?= $footer ?></footer>
</body>
</html>