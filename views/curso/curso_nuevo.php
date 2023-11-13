<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo $data["titulo"]; ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">.
        <?php error_reporting(0);?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="index.php?c=CursoController&a=registrar" method="POST" autocomplete="off" enctype="multipart/form-data">
                                <div class="form-group row justify-content-center">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Nombre:</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="txtCurso" value="<?php echo $_REQUEST["txtCurso"]?>">
                                        <?php if (isset($data["errores"]["nombres"])) : ?>
                                            <div style="color:red">
                                                <?php echo $data["errores"]["nombres"]?>
                                            </div>
                                        <?php endif; ?>

                                    </div>

                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="inputMarca" class="col-sm-2 col-form-label">Docente:</label>
                                    <div class="col-sm-5">
                                        <?php
                                        require "config/Conectar.php"; // Asegúrate de que esta ruta sea correcta
                                        $sql = "SELECT * FROM  docentes doc inner join personas per on per.id_persona = doc.id_persona";
                                        $resultado = $mysqli->query($sql);

                                        // Paso 4: Generar el campo de selección
                                        if (mysqli_num_rows($resultado) > 0) {
                                            echo '<select class="form-control" name="cboDocente">'; // Agregamos la clase "form-control" para aplicar estilos Bootstrap
                                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                                echo '<option value="' . $fila["id_docente"] . '">' . $fila["nombres"] . ' ' . $fila["apellidos"] . '</option>';
                                            }
                                            echo '</select>';
                                        }
                                        ?>
                                        <?php if (isset($data["errores"]["nombres"])) : ?>
                                            <div style="color: red;">
                                                <?php echo $data["errores"]["nombres"]; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>           
                                <div class="form-group row justify-content-center">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Horas:</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="txtHoras" value="<?php echo $_REQUEST["txtHoras"]?>">
                                        <?php if (isset($data["errores"]["horas"])) : ?>
                                            <div style="color:red">
                                                <?php echo $data["errores"]["horas"]?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Creditos   : </label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="txtCreditos" value="<?php echo $_REQUEST["txtCreditos"]?>">
                                        <?php if (isset($data["errores"]["creditos"])) : ?>
                                            <div style="color:red">
                                                <?php echo $data["errores"]["creditos"]?>
                                            </div>
                                        <?php endif; ?>

                                    </div>

                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="inputPassword" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-5">
                                        <a href="index.php?c=AlumnoController" class="btn btn-secondary">CANCELAR REGISTRO</a>
                                        <input type="submit" value="REGISTRAR CURSO" class="btn btn-success" name="btnEnviar">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>