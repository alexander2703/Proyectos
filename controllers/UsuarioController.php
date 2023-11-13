<?php

class UsuarioController
{

    protected $usuarios;
    protected $validaciones;
    protected $errores;

    public function __construct()
    {

        session_start(); // esto es una función de PHP para iniciar una sesión 

        require_once "models/UsuarioModel.php";
        require_once "controllers/ValController.php";
        $this->usuarios = new UsuarioModel();
        $this->validaciones = new ValController();
        $this->errores = array();
    }

    //deben tener la funcion index();
    public function index()
    {
        $data["titulo"] = "GESTIÓN DE USUARIOS";
        $data["resultado"] = $this->usuarios->getUsuarios();
        $data["contenido"] = "views/usuarios/usuario.php";
        require_once TEMPLATE;
    }

    //function para abrir formulario de registro de usuarios
    public function nuevo()
    {
        $data["titulo"] = "FORMULARIO DE REGISTRO DE USUARIOS";
        $data["contenido"] = "views/usuarios/usuario_nuevo.php";
        require_once TEMPLATE;
    }


    // funcion para registrar datos de nuevos usuarios
    public function registrar()
    {
        //variables reciben mediante el metodo POST
        $nombres = $_POST["txtNombres"];
        $apellidos = $_POST["txtApellidos"];
        $email = $_POST["txtEmail"];
        $pass = $_POST["txtPassword"];
        $estado = $_POST["cboEstado"];
        $tipo = $_POST["cboTipo"];


        if (isset($_POST["btnEnviar"])) {

            $nomArchivo = $_FILES["imagen"]["name"];
            $nomTemporal = $_FILES["imagen"]["tmp_name"];
            $fileSize = $_FILES["imagen"]["size"];
            $extension =  pathinfo($nomArchivo, PATHINFO_EXTENSION);
            $nomArchivo = substr(md5(time()), 0, 10) . "." . $extension;

            $this->validarNombres($nombres);
            $this->validarApellidos($apellidos);
            $this->validarEmail($id = null, $email);
            $this->validarpass($pass);
            $this->validarImagen($extension, $fileSize);
            $this->validarEstado($estado);
            $this->validarTipo($tipo);

            echo "peso:" . $fileSize;

            if ($this->errores) {
                $data["errores"] = $this->errores;
                $data["titulo"] = "FORMULARIO DE REGISTRO DE USUARIOS";
                $data["contenido"] = "views/usuarios/usuario_nuevo.php";
                require_once TEMPLATE;
            } else {

                move_uploaded_file($nomTemporal, "public/users/" . $nomArchivo);

                $data = array(
                    "nombres" => $_POST["txtNombres"],
                    "apellidos" => $_POST["txtApellidos"],
                    "email" => $_POST["txtEmail"],
                    "pass" => $_POST["txtPassword"],
                    "imagen" => $nomArchivo,
                    "estado" => $_POST["cboEstado"],
                    "tipo" => $_POST["cboTipo"],
                    "fechaRegistro" => date("Y-m-d H:i:s")
                );

                $this->usuarios->save($data);

                /**
                 * Cramos una variable "mensaje" de tipo sesión el cual se utilizará para mostrar el mensaje en la vista usuario
                 */
                $_SESSION['mensaje'] = "Datos registrados correctamente";

                header("Location: index.php?c=UsuarioController");
            }
        } else {
            require_once ERROR404;
        }
    }


    // funcion para obtener vista con datos de usuario mediante id
    public function verUsuario($id)
    {
        $data["titulo"] = "ACTUALIZAR DATOS DE USUARIO";
        $data["consulta"] = $this->usuarios->getUsuarioID($id); // obtiene los datos de un usuario por ID.
        $data["contenido"] = "views/usuarios/usuario_actualizar.php";
        require_once TEMPLATE;
    }


    public function actualizar()
    {
        //variables reciben mediante el metodo POST
        $id = $_POST["txtIdUsuario"];
        $nombres = $_POST["txtNombres"];
        $apellidos = $_POST["txtApellidos"];
        $email = $_POST["txtEmail"];
        $pass = $_POST["txtPassword"];
        $estado = $_POST["cboEstado"];
        $tipo = $_POST["cboTipo"];

        if (isset($_POST["btnEnviar"])) {

            $nomArchivo = $_FILES["imagen"]["name"];
            $nomTemporal = $_FILES["imagen"]["tmp_name"];
            $fileSize = $_FILES["imagen"]["size"];
            $extension =  pathinfo($nomArchivo, PATHINFO_EXTENSION);
            $nomArchivo = substr(md5(time()), 0, 10) . "." . $extension;

            $this->validarNombres($nombres);
            $this->validarApellidos($apellidos);
            $this->validarEmail($id, $email);
            $this->validarpass($pass);
            $this->validarImagen($extension, $fileSize);
            $this->validarEstado($estado);
            $this->validarTipo($tipo);


            if ($this->errores) {
                $data["errores"] = $this->errores;
                $data["consulta"] = $this->usuarios->getUsuarioID($id);
                $data["titulo"] = "FORMULARIO PARA ACTUALIZAR USUARIO";
                $data["contenido"] = "views/usuarios/usuario_actualizar.php";
                require_once TEMPLATE;
            } else {

                if ($nomTemporal != "") { // verifica si hay imagen a enviar
                    unlink("public/users/" . $_POST["txtFile"]); //se tiene que eliminar la imagen asociada al usuario
                    move_uploaded_file($nomTemporal, "public/users/" . $nomArchivo); // movemos la nueva imagen con el nuevo nombre
                } else { // si no se esta enviando imagen
                    $nomArchivo = $_POST["txtFile"]; // se asigna el mismo nombre de la imagen que tenia registrado anteriormente.
                }


                $data = array(
                    "nombres" => ($_POST["txtNombres"]),
                    "apellidos" => $_POST["txtApellidos"],
                    "email" => $_POST["txtEmail"],
                    "pass" => $_POST["txtPassword"],
                    "imagen" => $nomArchivo,
                    "estado" => $_POST["cboEstado"],
                    "tipo" => $_POST["cboTipo"],
                    "fecha_registro" => $_POST["txtFechRegistro"],
                    "fecha_edicion" => date("Y-m-d H:i:s"),
                );

                $this->usuarios->update($id, $data);
                /**
                 * Cramos una variable "mensaje" de tipo sesión el cual se utilizará para mostrar el mensaje en la vista usuario
                 */
                $_SESSION['mensaje'] = "Datos actualizados correctamente";
                header("Location: index.php?c=UsuarioController");
            }
        } else {
            require_once ERROR404;
        }
    }


    // funcion para eliminar usuarios segun id
    public function eliminar($id)
    {
        /**
         * Esta funcion no solo elimina los datos del usuario, sino tambien la imagen que tiene asociada
         * dicho usuario.
         */
        $user = $this->usuarios->getUsuarioID($id);
        $this->usuarios->delete($id);
        unlink("public/users/" . $user["imagen"]); // funcion para eliminar imagen de usuario
        /**
         * Cramos una variable "mensaje" de tipo sesión el cual se utilizará para mostrar el mensaje en la vista usuario
         */
        $_SESSION['mensaje'] = "Datos eliminados correctamente";
        header("Location: index.php?c=UsuarioController"); // funcion para regresar a la funcion index del controlador
    }

    //metodo para validar nombres
    private function validarNombres($valor)
    {
        $opciones = array(
            "options" => array(
                "min_range" => 3,
                "max_range" => 10
            )
        );

        if (!$this->validaciones->validarRequeridos($valor)) {
            $this->errores["nombres"] = "Debes ingresar un valor en el campo nombres";
        } else if (!$this->validaciones->validarLongitudes($valor, $opciones)) {
            $this->errores["nombres"] = "Longitud de caracteres inválidos para el campo nombre";
        }
        return $this->errores;
    }

    private function validarApellidos($valor)
    {
        $opciones = array(
            "options" => array(
                "min_range" => 3,
                "max_range" => 60
            )
        );
        if (!$this->validaciones->validarRequeridos($valor)) {
            $this->errores["apellidos"] = "Debes ingresar un valor en el campo apellidos";
        } else if (!$this->validaciones->validarLongitudes($valor, $opciones)) {
            $this->errores["apellidos"] = "Longitud de caracteres inválidos para el campo Apellidos";
        }
        return $this->errores;
    }

    private function validarEmail($id, $valor)
    {
        $opciones = array(
            "options" => array(
                "max_range" => 60,
            )
        );

        if (!$this->validaciones->validarRequeridos($valor)) {
            $this->errores["email"] = "Debes ingresar un valor en el campo email";
        } else if (!$this->validaciones->validarCorreo($valor)) {
            $this->errores["email"] = "Valor incorrecto en el campo email";
        } else if ($this->usuarios->correoUnicoUsuario($id, $valor)) {
            $this->errores["email"] = "Ya existe un registro con dicho valor";
        } else if (!$this->validaciones->validarLongitudes($valor, $opciones)) {
            $this->errores["email"] = "Longitud de caracteres inválidos para el campo Email";
        }
        return $this->errores;
    }


    private function validarpass($valor)
    {
        if (!$this->validaciones->validarRequeridos($valor)) {
            $this->errores["pass"] = "Debes ingresar un valor en el campo contraseña";
        } else if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{4,8}$/", $valor)) {
            //https://regexlib.com/Search.aspx?k=password&c=-1&m=-1&ps=100
            $this->errores["pass"] = "La contraseña debe tener al menos 4 caracteres, no más de 8 caracteres <br> y debe incluir al menos una letra mayúscula, una letra minúscula y un dígito numérico.";
        }
        return $this->errores;
    }


    private function validarImagen($extension, $img)
    {
        $extensionesValidas = array("jpg", "png", "jpeg", "gif");

        $max_file_size = "5000000"; // convertido a MB representaria 25MB, tener en cuenta que un 1MB = 1024KB

        if (!in_array($extension, $extensionesValidas)) {
            $this->errores["imagen"] = "Extensión de archivo invalido o no se ha subido ningun valor";
        } else if ($img > $max_file_size) {
            $this->errores["imagen"] = "La imagen debe tener un tamaño inferior a 5MB";
        }
        return $this->errores;
    }


    private function validarEstado($valor)
    {
        switch ($valor) {
            case '0':
            case '1':
            case '2':
                break;
            default:
                $this->errores["estado"] = "Valores no permitidos de campo estado";
                break;
        }
        return $this->errores;
    }

    private function validarTipo($valor)
    {
        switch ($valor) {
            case '1':
            case '2':
                break;
            default:
                $this->errores["tipo"] = "Valores no permitidos de campo Tipo";
                break;
        }
        return $this->errores;
    }
}
