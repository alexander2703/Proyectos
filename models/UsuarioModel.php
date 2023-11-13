<?php

class UsuarioModel
{

    protected $db;
    protected $usuario;

    public function __construct()
    {
        $this->db = Conexion::Conexion();
        $this->usuario = array();
    }

    public function getUsuarios()
    {

        $sql = "SELECT * FROM usuario";
        $resultado = $this->db->query($sql);

        while ($row = $resultado->fetch_assoc()) {
            $this->usuario[] = $row;
        }
        return $this->usuario;
    }


    public function save($data)
    {
        $sql = "INSERT INTO usuario (nombres, apellidos, email, password, imagen, estado, tipo, fecha_registro)
                            VALUES('" . $data["nombres"] . "',
                                   '" . $data["apellidos"] . "',
                                   '" . $data["email"] . "',
                                   '" . $data["pass"] . "',
                                   '" . $data["imagen"] . "',
                                   '" . $data["estado"] . "',
                                   '" . $data["tipo"] . "',
                                   '" . $data["fechaRegistro"] . "') ";
        $this->db->query($sql);

    }


    public function getUsuarioID($id)
    {
        $sql = "SELECT * FROM usuario where id_usuario = $id limit 1";
        $resultado = $this->db->query($sql);
        $row = $resultado->fetch_assoc();
        return $row;
    }

    public function update($id, $data)
    {
        $consulta = "UPDATE  usuario  set nombres ='" . $data['nombres'] . "', 
                                          apellidos='" . $data['apellidos'] . "', 
                                          email='" . $data['email'] . "',
                                          password='" . $data['pass'] . "',
                                          imagen='" . $data['imagen'] . "',
                                          estado='" . $data['estado'] . "',
                                          tipo='" . $data['tipo'] . "',
                                          fecha_registro='" . $data['fecha_registro'] . "',
                                          fecha_edicion='" . $data['fecha_edicion'] . "'
                                          where id_usuario = '$id'";
        $this->db->query($consulta);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM usuario where id_usuario = '$id'";
        $this->db->query($sql);
    }


    // esta función es valida siempre y cuando se realize solo la acción de registrar.
    public function correoUnico($valor)
    {
        $sql = "SELECT*FROM usuario where email = '$valor' limit 1";
        $resultado = $this->db->query($sql);
        $row = $resultado->fetch_assoc();
        if ($row) {
            return true;
        } else {
            return false;
        }
    }

    //esta función valida un correo tanto para registrar como para actualizar.
    public function correoUnicoUsuario($id = null, $valor)
    {
        if ($id == null) {
            $sql = "SELECT*FROM usuario where email = '$valor' limit 1";
            $resultado = $this->db->query($sql);
            $row = $resultado->fetch_assoc();
            if ($row) {
                return true;
            } else {
                return false;
            }
        } else {
            $sql = "SELECT*FROM usuario where email = '$valor' and id_usuario='$id'";
            $resultado = $this->db->query($sql);
            $row = $resultado->fetch_assoc();
            if ($row == 1) {
                return false;
            } else {
                $sql = "SELECT*FROM usuario where email = '$valor' and not(id_usuario= '$id') limit 1";
                $resultado = $this->db->query($sql);
                $row = $resultado->fetch_assoc();
                if ($row) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }
}
