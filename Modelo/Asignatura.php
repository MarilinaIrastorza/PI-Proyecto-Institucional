<?php
require_once 'DBController.php'; // 🔗 Conexión con la base de datos

class Asignaturas {
    private $db; // Instancia de DBController

    public function __construct() {
        $this->db = new DBController(); // 🔌 Conexión activa
    }

    // 📋 Obtener todas las Materia con cupos e inscriptos
    public function obtenerMateria() {
        $query = "SELECT m.id, m.nombre, m.cuposTotales, COUNT(i.id_alumno) AS inscriptos
                  FROM Materia m
                  LEFT JOIN inscripciones i ON m.id = i.id_Asignaturas
                  GROUP BY m.id";
        return $this->db->runBaseQuery($query);
    }

    // ➕ Inscribir alumno si hay vacantes
    public function inscribirAlumno($idAsignaturas, $idAlumno) {
        // Verificar cantidad de inscriptos
        $query = "SELECT COUNT(*) AS total FROM inscripciones WHERE id_Asignaturas = ?";
        $result = $this->db->runQuery($query, "i", [$idAsignaturas]);
        $inscriptos = $result[0]["total"];

        // Obtener cupos
        $queryCupos = "SELECT cuposTotales FROM Materia WHERE id = ?";
        $cupos = $this->db->runQuery($queryCupos, "i", [$idAsignaturas])[0]["cuposTotales"];

        // Validar y registrar inscripción
        if ($inscriptos < $cupos) {
            $insertQuery = "INSERT INTO inscripciones (id_Asignaturas, id_alumno) VALUES (?, ?)";
            $this->db->insert($insertQuery, "ii", [$idAsignaturas, $idAlumno]);
            return true;
        }
        return false; // ❌ Sin vacantes
    }

    // 🔍 Vacantes disponibles para una Asignaturas
    public function vacantesDisponibles($idAsignaturas) {
        $query = "SELECT m.cuposTotales - COUNT(i.id_alumno) AS vacantes
                  FROM Materia m
                  LEFT JOIN inscripciones i ON m.id = i.id_Asignaturas
                  WHERE m.id = ?
                  GROUP BY m.id";
        $result = $this->db->runQuery($query, "i", [$idAsignaturas]);
        return $result[0]["vacantes"];
    }
}
?>