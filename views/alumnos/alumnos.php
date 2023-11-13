<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <h1 class="m-0"><?php echo $data["titulo"]; ?></h1>
                </div><!-- /.col -->

                <div class="col-sm-4">
                    <?php
                    if (isset($_SESSION["mensaje"])) : // validamos si la variable mensaje de tipo sessión existe con el metodo isset()
                    ?>

                        <div id="alert-msj" class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong><?php echo $_SESSION["mensaje"]; ?></strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <script>
                            setTimeout(function() {
                                $('#alert-msj').fadeOut('fast');
                            }, 3000); // duración del alert. En este caso dura solo 3 segundos.
                        </script>
                    <?php unset($_SESSION["mensaje"]);
                    endif;   // con unset limipamos los datos de las variables de tipo session
                    ?>
                </div>
                <div class="col-sm-4">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php?c=AlumnoController&a=nuevo" class="btn btn-success">NUEVO REGISTRO</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-text">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover " id="tbl-Alumnos">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>nombres</th>
                                            <th>apellidos</th>
                                            <th>DNI</th>
                                            <th>Correo</th>
                                            <th>Carrera</th>
                                            <th>Facultad</th>
                                            <th>fecha_registro</th>
                                            <th>fecha_edicion</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $cont = 1;
                                            foreach ($data["resultado"] as $row) : ?>
                                            <tr>
                                                <td> <?php echo $cont++; ?></td>
                                                <td> <?php echo $row["nombres"]; ?></td>
                                                <td> <?php echo $row["apellidos"]; ?></td>
                                                <td> <?php echo $row["dni"]; ?></td>
                                                <td> <?php echo $row["correo"]; ?></td>
                                                <td> <?php echo $row["carrera"]; ?></td>
                                                <td> <?php echo $row["facultad"]; ?></td>
                                                <td> <?php echo $row["fecha_registro"]; ?></td>
                                                <td> <?php echo $row["fecha_actualizacion"]; ?></td>
                                                <td> <a href="index.php?c=AlumnoController&a=verAlumno&id=<?php echo $row["id_persona"]; ?>" class="btn btn-xs btn-warning"><i class="fas fa-user-edit"></i></a>
                                                <a href="#" class="btn btn-xs btn-danger deleteBtn" data-toggle="modal" data-target="#deleteModal" data-recordid="<?php echo $row["id_persona"]; ?>"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>

                                    </tbody>

                                </table>
                                </p>
                            </div>
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

<!-- Modal para la confirmación -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar este registro?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <a id="deleteRecordBtn" href="#" class="btn btn-danger">Eliminar</a>
            </div>
        </div>
    </div>
</div>

<!-- jQuery y Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        $('.deleteBtn').on('click', function() {
            var userId = $(this).data('recordid');
            var deleteUrl = 'index.php?c=AlumnoController&a=eliminar&id=' + userId;
            $('#deleteRecordBtn').attr('href', deleteUrl);
        });
    });
</script>