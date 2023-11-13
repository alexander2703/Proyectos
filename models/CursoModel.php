<?php 
    class CursoModel{
        protected $db;
        protected $curso;

        public function __construct()
        {
            $this->db = Conexion::Conexion();
            $this->curso = array();
        }

        public function getCurso()
        {

            $sql = "SELECT per.*, cur.* FROM cursos cur INNER JOIN docentes doc ON cur.id_docente = doc.id_docente INNER JOIN personas per ON doc.id_persona = per.id_persona";
            $resultado = $this->db->query($sql);

            while ($row = $resultado->fetch_assoc()) {
                $this->curso[] = $row;
            }

            return $this->curso;
        }
        public function save($data)
        {
            $sql1 = "INSERT INTO cursos (id_docente, nombre_curso, horas, creditos, fecha_registro)
                    VALUES('" . $data["docente"] . "',
                            '" . $data["curso"] . "',
                            '" . $data["horas"] . "',
                            '" . $data["credito"] . "',
                            '" . $data["fechaRegistro"] . "') ";

            $this->db->query($sql1);

        }
        public function getCursoID($idCurso)
        {
            $idCurso = $this->db->real_escape_string($idCurso); // Escapar el valor para prevenir inyección SQL
            $sql = "SELECT per.*, cur.* FROM cursos cur INNER JOIN docentes doc ON cur.id_docente = doc.id_docente INNER JOIN personas per ON doc.id_persona = per.id_persona WHERE cur.id_curso  = '$idCurso'";
            $resultado = $this->db->query($sql);

            if ($resultado) {
                $row = $resultado->fetch_assoc();
                return $row;
            } else {
                return null; // Manejo de errores si la consulta no se ejecuta correctamente
            }

        }
    
        public function delete($idCurso)
        {
            $sql = "DELETE FROM cursos where id_curso = '$idCurso'";
            $this->db->query($sql);
        }

    }
    

?> 