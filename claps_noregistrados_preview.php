
    <script src="assets/js/jquery.min.js"></script>


      <script>
$(document).ready(function(){
    $('#myTable').dataTable();
});
</script>

<?php
//SECCIÓN DE CARGA DE LIBRERIAS Y MODELOS
require('autoload.php');
use DB\Eloquent;
use Models\Cargo;
use Models\Clap2;
use Models\Jefe;
use Models\Municipio;
use Models\Parroquia;
new Eloquent();

extract($_GET);
extract($_POST);

$integrantes = Clap2::where('registrado',0)->get();
?>
                <div class="page-body">
                    <div class="row">
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <h5 class="row-title before-darkorange"><i class="fa fa-list-alt darkorange"></i>Busquedas segun municipio, parroquia y bodega</h5>
                            </div>
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                            <a class="btn btn-danger btn-lg pull-right" href="solo_pdf.php?municipio=<?php echo $municipio ?>&parroquia=<?php echo "asd" ?>"><i class="fa fa-download" aria-hidden="true"></i> Descargar PDF</a>
                            <hr>
                            <h3 align="center">Integrantes no registrados</h3>
                    
                              

                            </div>
                        </div>


                    <div class="row">
                        <div class="col-xs-12 col-md-12">
                            <div class="widget">
                                <div class="widget-header ">
                                    <span class="widget-caption">No registrados</span>
                                    <div class="widget-buttons">
                                        <a href="#" data-toggle="maximize">
                                            <i class="fa fa-expand"></i>
                                        </a>
                                        <a href="#" data-toggle="collapse">
                                            <i class="fa fa-minus"></i>
                                        </a>
                                        <a href="#" data-toggle="dispose">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="widget-body">
                                    <table class="table table-striped table-bordered table-hover" id="simpledatatable">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Codigo Clap
                                                </th>
                                                <th>
                                                    Nombre
                                                </th>
                                                <th>
                                                    Cedula
                                                </th>
                                                <th>
                                                    telefono
                                                </th>
                                                <th>
                                                    cargo
                                                </th>
                                                <th>
                                                    Municipio
                                                </th>
                                                <th>
                                                    Parroquia
                                                </th>
                                                <th>
                                                    Comunidad
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $num = 1; ?>
                                            <?php foreach ($integrantes as $integrante): ?>
                                            <tr>
                                                <td>
                                                <?php echo $integrante->clap_codigo ?>
                                                </td>
                                                <td>
                                                    <?php echo $integrante->nombre_apellido ?>
                                                </td>
                                                <td>
                                                   <?php echo $integrante->tipo ?>-<?php echo $integrante->cedula ?>
                                                </td>
                                                <td>
                                                    <?php echo $integrante->telefono ?>
                                                </td>
                                                <td>
                                                <?php 
                                                $cargo = Cargo::find($integrante->cargo_id);
                                                ?>
                                                    <?php echo $cargo->cargo ?>
                                                </td>
                                                <td>
                                                <?php 
                                                $municipio = Municipio::find($integrante->municipio_id);
                                                ?>
                                                    <?php echo $municipio->nombre_municipio ?>
                                                </td>
                                                <td>
                                                <?php 
                                                $parroquia = Parroquia::find($integrante->parroquia_id);
                                                ?>
                                                    <?php echo $parroquia->nombre_parroquia ?>
                                                </td>
                                                <td>
                                                    <?php echo $integrante->comunidad ?>
                                                </td>
                                            </tr>
                                            <?php $num = $num + 1 ?>
                                        <?php endforeach ?>
                                        </tbody>
                                    </table>
                                <div class="horizontal-space"></div>
                                  <pre>Número: <?php echo $integrantes->count() ?></pre>
                                </div>
                            </div>
                        </div>
                    </div>

                    </div>
               


    <!--Basic Scripts-->

    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/slimscroll/jquery.slimscroll.min.js"></script>

    <!--Beyond Scripts-->
    <script src="assets/js/beyond.js"></script>

    <!--Page Related Scripts-->
    <script src="assets/js/datatable/jquery.dataTables.min.js"></script>
    <script src="assets/js/datatable/ZeroClipboard.js"></script>
   <!-- <script src="assets/js/datatable/dataTables.tableTools.min.js"></script> -->
    <script src="assets/js/datatable/dataTables.bootstrap.min.js"></script>
    <script src="assets/js/datatable/datatables-init.js"></script>
    <script>
        InitiateSimpleDataTable.init();
    </script>



