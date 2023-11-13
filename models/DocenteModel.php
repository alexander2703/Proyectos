<?php 
    class DocenteModel{
        protected $db;
        protected $docente;

        public function __construct()
        {
            $this->db = Conexion::Conexion();
            $this->docente = array();
        }

        public function getDocente()
        {

            $sql = "SELECT per.*, doc.* FROM docentes doc INNER JOIN personas per ON doc.id_persona = per.id_persona";
            $resultado = $this->db->query($sql);

            while ($row = $resultado->fetch_assoc()) {
                $this->docente[] = $row;
            }

            return $this->docente;
        }
        public function save($data)
        {
            $sql = "INSERT INTO personas (nombres, apellidos, dni, correo)
                    VALUES('" . $data["nombres"] . "',
                        '" . $data["apellidos"] . "',
                        '" . $data["dni"] . "',
                        '" . $data["email"] . "') ";
            $this->db->query($sql);
            require "config/Conectar.php"; // Asegúrate de que esta ruta sea correcta
            $sql2 = "SELECT id_persona FROM `personas` WHERE dni = '" . $data["dni"] . "'";
            $resultado2 = $mysqli->query($sql2);
            $datos1 = $resultado2->fetch_object();
            $idPersona = $datos1->id_persona;
            $sql1 = "INSERT INTO docentes (id_persona, tipoContrato, fecha_registro)
                    VALUES('" . $idPersona . "',
                            '" . $data["contrato"] . "',
                            '" . $data["fechaRegistro"] . "') ";

            $this->db->query($sql1);

        }
        public function getDocenteID($idPersona)
        {
            $idPersona = $this->db->real_escape_string($idPersona); // Escapar el valor para prevenir inyección SQL
            $sql = "SELECT doc.*, per.* FROM docentes doc INNER JOIN personas per ON doc.id_persona = per.id_persona WHERE per.id_persona  = '$idPersona'";
            $resultado = $this->db->query($sql);

            if ($resultado) {
                $row = $resultado->fetch_assoc();
                return $row;
            } else {
                return null; // Manejo de errores si la consulta no se ejecuta correctamente
            }

        }
        public function update($id, $data)
        {
            // Código para actualizar la tabla 'personas'
            $sql = "UPDATE personas
                    SET nombres = '" . $data["nombres"] . "',
                        apellidos = '" . $data["apellidos"] . "',
                        dni = '" . $data["dni"] . "',
                        correo = '" . $data["email"] . "'
                    WHERE id_persona = " . $id;
        
            $this->db->query($sql);
        
            // Código para obtener el ID de persona
            require "config/Conectar.php"; // Asegúrate de que esta ruta sea correcta
            $sql2 = "SELECT id_persona FROM `personas` WHERE dni = '" . $data["dni"] . "'";
            $resultado2 = $mysqli->query($sql2);
            $datos1 = $resultado2->fetch_object();
            $idPersona = $datos1->id_persona;
        
            // Código para actualizar la tabla 'alumnos'
            $sqlUpdate = "UPDATE docentes
                        SET tipoContrato = '" . $data["contrato"] . "',
                            fecha_registro = '" . $data["fecha_registro"] . "',
                            fecha_actualizacion = '" . $data["fecha_edicion"] . "'
                        WHERE id_persona = " . $idPersona;
        
            $this->db->query($sqlUpdate);
        }
        public function delete($idPersona)
        {
            $sql = "DELETE FROM docentes where id_persona = '$idPersona'";
            $this->db->query($sql);
            $sql = "DELETE FROM personas where id_persona = '$idPersona'";
            $this->db->query($sql);
        }

    }
    

?> 