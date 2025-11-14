<?php
require_once 'DBController.php'; // 🔗 Conexión con la base de datos

class materias {
    private $db; // Instancia de DBController

    public function __construct() {
        $this->db = new DBController(); // 🔌 Conexión activa
    }

    // 📋 Obtener todas las materias con cupos e inscriptos
    public function obtenermaterias() {
        $query = "SELECT m.id, m.nombre, m.cuposTotales, COUNT(i.id_alumno) AS inscriptos
                  FROM materias m
                  LEFT JOIN inscripciones i ON m.id = i.id_materias
                  GROUP BY m.id";
        return $this->db->runBaseQuery($query);
    }

    // ➕ Inscribir alumno si hay vacantes
    public function inscribirAlumno($idmaterias, $idAlumno) {
        // Verificar cantidad de inscriptos
        $query = "SELECT COUNT(*) AS total FROM inscripciones WHERE id_materias = ?";
        $result = $this->db->runQuery($query, "i", [$idmaterias]);
        $inscriptos = $result[0]["total"];

        // Obtener cupos
        $queryCupos = "SELECT cuposTotales FROM materias WHERE id = ?";
        $cupos = $this->db->runQuery($queryCupos, "i", [$idmaterias])[0]["cuposTotales"];

        // Validar y registrar inscripción
        if ($inscriptos < $cupos) {
            $insertQuery = "INSERT INTO inscripciones (id_materias, id_alumno) VALUES (?, ?)";
            $this->db->insert($insertQuery, "ii", [$idmaterias, $idAlumno]);
            return true;
        }
        return false; // ❌ Sin vacantes
    }

    // 🔍 Vacantes disponibles para una Asignaturas
    public function vacantesDisponibles($idmaterias) {
        $query = "SELECT m.cuposTotales - COUNT(i.id_alumno) AS vacantes
                  FROM materias m
                  LEFT JOIN inscripciones i ON m.id = i.id_materias
                  WHERE m.id = ?
                  GROUP BY m.id";
        $result = $this->db->runQuery($query, "i", [$idmaterias]);
        return $result[0]["vacantes"];
    }
}
?>