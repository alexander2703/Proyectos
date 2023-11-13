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
                        <li class="breadcrumb-item"><a href="index.php?c=CursoController&a=nuevo" class="btn btn-success">NUEVO REGISTRO</a></li>
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
                                            <th>nombre curso</th>
                                            <th>docente</th>
                                            <th>Horas</th>
                                            <th>Creditos</th>
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
                                                <td> <?php echo $row["nombre_curso"]; ?></td>
                                                <td> <?php echo $row["nombres"]." ".$row["apellidos"];?></td>
                                                <td> <?php echo $row["horas"]; ?></td>
                                                <td> <?php echo $row["creditos"]; ?></td>
                                                <td> <?php echo $row["fecha_registro"]; ?></td>
                                                <td> <?php echo $row["fecha_actualización"]; ?></td>
                                                <td> <a href="#" class="btn btn-xs btn-warning"><i class="fas fa-user-edit"></i></a>
                                                <a href="#" class="btn btn-xs btn-danger deleteBtn" data-toggle="modal" data-target="#deleteModal" data-recordid="<?php echo $row["id_curso"]; ?>"><i class="fas fa-trash"></i></a>
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
            var deleteUrl = 'index.php?c=CursoController&a=eliminar&id=' + userId;
            $('#deleteRecordBtn').attr('href', deleteUrl);
        });
    });
</script>