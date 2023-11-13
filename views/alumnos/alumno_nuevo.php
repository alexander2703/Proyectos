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
                            <form action="index.php?c=AlumnoController&a=registrar" method="POST" autocomplete="off" enctype="multipart/form-data">
                                <div class="form-group row justify-content-center">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Nombres</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="txtNombres" value="<?php echo $_REQUEST["txtNombres"]?>">
                                        <?php if (isset($data["errores"]["nombres"])) : ?>
                                            <div style="color:red">
                                                <?php echo $data["errores"]["nombres"]?>
                                            </div>
                                        <?php endif; ?>

                                    </div>

                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Apellidos:</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="txtApellidos" value="<?php echo $_REQUEST["txtApellidos"]?>">
                                        <?php if (isset($data["errores"]["apellidos"])) : ?>
                                            <div style="color:red">
                                                <?php echo $data["errores"]["apellidos"]?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Correo:</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="txtEmail" value="<?php echo $_REQUEST["txtEmail"]?>">
                                        <?php if (isset($data["errores"]["correo"])) : ?>
                                            <div style="color:red">
                                                <?php echo $data["errores"]["correo"]?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">DNI: </label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="txtDNI" value="<?php echo $_REQUEST["txtDNI"]?>">
                                        <?php if (isset($data["errores"]["dni"])) : ?>
                                            <div style="color:red">
                                                <?php echo $data["errores"]["dni"]?>
                                            </div>
                                        <?php endif; ?>

                                    </div>

                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Carrera: </label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="txtCarrera" value="<?php echo $_REQUEST["txtCarrera"]?>">
                                        <?php if (isset($data["errores"]["carrera"])) : ?>
                                            <div style="color:red">
                                                <?php echo $data["errores"]["carrera"]?>
                                            </div>
                                        <?php endif; ?>

                                    </div>

                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Facultad: </label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="txtFacultad" value="<?php echo $_REQUEST["txtFacultad"]?>">
                                        <?php if (isset($data["errores"]["facultad"])) : ?>
                                            <div style="color:red">
                                                <?php echo $data["errores"]["facultad"]?>
                                            </div>
                                        <?php endif; ?>

                                    </div>

                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="inputPassword" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-5">
                                        <a href="index.php?c=AlumnoController" class="btn btn-secondary">CANCELAR REGISTRO</a>
                                        <input type="submit" value="REGISTRAR ALUMNO" class="btn btn-success" name="btnEnviar">
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