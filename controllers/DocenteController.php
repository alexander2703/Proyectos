<?php 
    Class DocenteController{
        protected $docente;
        protected $validaciones;
        protected $errores;
    
        public function __construct()
        {
    
            session_start(); // esto es una función de PHP para iniciar una sesión 
    
            require_once "models/DocenteModel.php";
            require_once "controllers/ValController.php";
            $this->docente = new DocenteModel();
            $this->validaciones = new ValController();
            $this->errores = array();
        }
        //deben tener la funcion index();
        public function index()
        {
            $data["titulo"] = "GESTIÓN DE DOCENTES";
            $data["resultado"] = $this->docente->getDocente();
            $data["contenido"] = "views/docente/docente.php";
            require_once TEMPLATE;
        }
        public function nuevo()
        {
            $data["titulo"] = "FORMULARIO DE REGISTRO DE DOCENTE";
            $data["contenido"] = "views/docente/docente_nuevo.php";
            require_once TEMPLATE;
        }
        // funcion para registrar datos de nuevos usuarios
        public function registrar()
        {
            //variables reciben mediante el metodo POST
            $nombres = $_POST["txtNombres"];
            $apellidos = $_POST["txtApellidos"];
            $email = $_POST["txtEmail"];
            $dni = $_POST["txtDNI"];
            $contrato = $_POST["txtTipoContrato"];


            if (isset($_POST["btnEnviar"])) {

                // $this->validarNombres($nombres);
                // $this->validarApellidos($apellidos);
                // $this->validarEmail($id = null, $email);
                // $this->validarDNI($dni);
                // $this->validarcarrera($carrera);
                // $this->validarfacultad($facultad);

                if ($this->errores) {
                    $data["errores"] = $this->errores;
                    $data["titulo"] = "FORMULARIO DE REGISTRO DE DOCENTE";
                    $data["contenido"] = "views/docente/docente_nuevo.php";
                    require_once TEMPLATE;
                } else {

                    $data = array(
                        "nombres" => $_POST["txtNombres"],
                        "apellidos" => $_POST["txtApellidos"],
                        "email" => $_POST["txtEmail"],
                        "dni" => $_POST["txtDNI"],
                        "contrato" => $_POST["txtTipoContrato"],
                        "fechaRegistro" => date("Y-m-d H:i:s")
                    );

                    $this->docente->save($data);

                    /**
                     * Cramos una variable "mensaje" de tipo sesión el cual se utilizará para mostrar el mensaje en la vista usuario
                     */
                    $_SESSION['mensaje'] = "Datos registrados correctamente";

                    header("Location: index.php?c=DocenteController");
                }
            } else {
                require_once ERROR404;
            }
        }
        public function verDocente($id)
        {
            $data["titulo"] = "ACTUALIZAR DATOS DE DOCENTE";
            $data["consulta"] = $this->docente->getDocenteID($id); // obtiene los datos de un usuario por ID.
            $data["contenido"] = "views/docente/docente_actualizar.php";
            require_once TEMPLATE;
        }

        public function actualizar()
        {
            // Variables reciben mediante el método POST
            $id = $_POST["txtPersona"];
            $nombres = $_POST["txtNombres"];
            $apellidos = $_POST["txtApellidos"];
            $email = $_POST["txtEmail"];
            $dni = $_POST["txtDNI"];
            $carrera = $_POST["txtContrato"];
            if (isset($_POST["btnEnviar"])) {


                $this->validarNombres($nombres);
                $this->validarApellidos($apellidos);


                if ($this->errores) {
                    $data["errores"] = $this->errores;
                    $data["consulta"] = $this->alumnos->getUsuarioID($id);
                    $data["titulo"] = "FORMULARIO PARA ACTUALIZAR DOCENTE";
                    $data["contenido"] = "../views/docente/docente_actualizar.php";
                    require_once TEMPLATE;
                } else {

                    $data = array(
                        "nombres" =>  $nombres,
                        "apellidos" => $_POST["txtApellidos"],
                        "email" => $_POST["txtEmail"],
                        "dni" => $_POST["txtDNI"],
                        "contrato" => $_POST["txtContrato"],
                        "fecha_registro" => $_POST["txtFechRegistro"],
                        "fecha_edicion" => date("Y-m-d H:i:s"),
                    );

                    echo var_dump($data);

                    $this->docente->update($id, $data);
                    // /**
                    //  * Cramos una variable "mensaje" de tipo sesión el cual se utilizará para mostrar el mensaje en la vista usuario
                    //  */
                    $_SESSION['mensaje'] = "Datos actualizados correctamente";
                    header("Location: index.php?c=DocenteController");
                }
            } else {
                require_once ERROR404;
            }
        }
        public function eliminar($id)
        {
            $user = $this->docente->getDocenteID($id);
            $this->docente->delete($id);

            $_SESSION['mensaje'] = "Datos eliminados correctamente";
            header("Location: index.php?c=DocenteController"); // funcion para regresar a la funcion index del controlador
        }
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


    }
?>