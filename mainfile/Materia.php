<?php
require_once '../Modelo/materias.php'; 

$materias = new materias(); // Instancia de la clase
$listado = $materias->obtenermaterias(); // Obtener datos

// Mostrar en tabla HTML
echo "<table border='1' cellpadding='8'>";
echo "<tr><th>ID</th><th>Nombre</th><th>Cupos Totales</th><th>Inscriptos</th><th>Vacantes</th></tr>";

foreach ($listado as $materias) {
    $vacantes = $materias['cuposTotales'] - $materias['inscriptos'];
    echo "<tr>
            <td>{$materias['id']}</td>
            <td>{$materias['nombre']}</td>
            <td>{$materias['cuposTotales']}</td>
            <td>{$materias['inscriptos']}</td>
            <td>{$vacantes}</td>
          </tr>";
}

echo "</table>";
?>