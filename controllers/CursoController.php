<?php 
    Class CursoController{
        protected $curso;
        protected $validaciones;
        protected $errores;
    
        public function __construct()
        {
    
            session_start(); // esto es una función de PHP para iniciar una sesión 
    
            require_once "models/CursoModel.php";
            require_once "controllers/ValController.php";
            $this->curso = new CursoModel();
            $this->validaciones = new ValController();
            $this->errores = array();
        }
        //deben tener la funcion index();
        public function index()
        {
            $data["titulo"] = "GESTIÓN DE CURSOS";
            $data["resultado"] = $this->curso->getCurso();
            $data["contenido"] = "views/curso/curso.php";
            require_once TEMPLATE;
        }
        public function nuevo()
        {
            $data["titulo"] = "FORMULARIO DE REGISTRO DE CURSO";
            $data["contenido"] = "views/curso/curso_nuevo.php";
            require_once TEMPLATE;
        }
        // funcion para registrar datos de nuevos usuarios
        public function registrar()
        {
            //variables reciben mediante el metodo POST
            $idAlumno = $_POST["cboDocente"];
            $curso = $_POST["txtCurso"];
            $horas = $_POST["txtHoras"];
            $creditos = $_POST["txtCreditos"];
            if (isset($_POST["btnEnviar"])) {

                

                if ($this->errores) {
                    $data["errores"] = $this->errores;
                    $data["titulo"] = "FORMULARIO DE REGISTRO DE CURSO";
                    $data["contenido"] = "views/curso/curso_nuevo.php";
                    require_once TEMPLATE;
                } else {

                    $data = array(
                        "docente" => $_POST["cboDocente"],
                        "curso" => $_POST["txtCurso"],
                        "horas" => $_POST["txtHoras"],
                        "credito" => $_POST["txtCreditos"],
                        "fechaRegistro" => date("Y-m-d H:i:s")
                    );

                    $this->curso->save($data);

                    /**
                     * Cramos una variable "mensaje" de tipo sesión el cual se utilizará para mostrar el mensaje en la vista usuario
                     */
                    $_SESSION['mensaje'] = "Datos registrados correctamente";

                    header("Location: index.php?c=CursoController");
                }
            } else {
                require_once ERROR404;
            }
        }
        public function eliminar($id)
        {
            $user = $this->curso->getCursoID($id);
            $this->curso->delete($id);

            $_SESSION['mensaje'] = "Datos eliminados correctamente";
            header("Location: index.php?c=CursoController"); // funcion para regresar a la funcion index del controlador
        }


    }
?>