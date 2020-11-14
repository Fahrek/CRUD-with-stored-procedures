<!DOCTYPE html>
<html lang="es">
<head>
	<?php require_once "dependencias.php"; ?>
    <title>Crud stores</title>
</head>
<body>
<div class="container">
    <br>
    <h1>CRUD con store procedures y PHP</h1>
    <hr>
    <div class="row">
        <div class="col-sm-12">
            <div id="tablastores"></div>
        </div>
    </div>
</div>

<!--************************************************* AGREGAR DATOSMODAL ********************************************-->
<div class="modal fade" id="addmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar nuevo juego</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmAgrega">
                    <input type="text" class="form-control form-control-sm" name="nombrej"
                           id="nombrej" placeholder="Nombre"><br>
                    <input type="text" class="form-control form-control-sm" name="anioj" id="anioj"
                           placeholder="Año"><br>
                    <input type="text" class="form-control form-control-sm" name="empresaj"
                           id="empresaj" placeholder="Empresa"><br>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-raised btn-primary" id="btnAgregarJuego">Agregar
                </button>
            </div>
        </div>
    </div>
</div>
<!--************************************************* FIN AGREGAR DATOSMODAL ****************************************-->

<!--************************************************* UPDATEMODAL ***************************************************-->
<div class="modal fade" id="updatemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualiza Juego</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmactualiza">
                    <input type="hidden" name="id_juego" id="id_juego">
                    <input type="text" class="form-control form-control-sm" name="nombrejU"
                           id="nombrejU" placeholder="Nombre"><br>
                    <input type="text" class="form-control form-control-sm" name="aniojU"
                           id="aniojU" placeholder="Año"><br>
                    <input type="text" class="form-control form-control-sm" name="empresajU"
                           id="empresajU" placeholder="Empresa"><br>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-raised btn-warning" id="btnactualizar">Actualizar
                </button>
            </div>
        </div>
    </div>
</div>
<!--************************************************* FIN UPDATEMODAL ***********************************************-->
</body>
</html>

<script type="text/javascript">
    $(document).ready(function () {
        $('#tablastores').load('tabla.php');
        $('#btnAgregarJuego').click(function () {
            if (validarFormVacio('frmAgrega') > 0) {
                alertify.alert('Debes rellenar todos los campos.');
                return false;
            }
            const datos = $('#frmAgrega').serialize();
            $.ajax({
                type: "POST",
                data: datos,
                url: "php/insertar.php",
                success: function (r) {
                    if (r == 1) {
                        $('#frmAgrega')[0].reset(); /* Limpiar formulario */
                        $('#tablastores').load('tabla.php');
                        alertify.success("Agregado con éxito :)");
                    } else {
                        alertify.error("No se pudo agregar :(");
                    }
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#btnactualizar').click(function () {
            const datos = $('#frmactualiza').serialize();
            $.ajax({
                type: "POST",
                data: datos,
                url: "php/actualizar.php",
                success: function (r) {
                    if (r == 1) {
                        $('#tablastores').load('tabla.php');
                        alertify.success("Actualizado con éxito :)");
                    } else {
                        alertify.error("No se pudo actualizar :(");
                    }
                }
            });
        });
    });
</script>

<script type="text/javascript">
    function obtenDatos(idjuego) {
        $.ajax({
            type: "POST",
            data: "idjuego=" + idjuego,
            url: "php/obtenerRegistro.php",
            success: function (r) {
                datos = jQuery.parseJSON(r);

                $('#id_juego').val(datos['id_juego']);
                $('#nombrejU').val(datos['nombrejU']);
                $('#aniojU').val(datos['aniojU']);
                $('#empresajU').val(datos['empresajU']);
            }
        });
    }

    function validarFormVacio(formulario) {
        const datos = $('#' + formulario).serialize();
        const d = datos.split('&');
        let vacios = 0;
        let controles;
        for (let i = 0; i < d.length; i++) {
            controles = d[i].split("=");
            if (controles[1] == "A" || controles[1] == "") {
                vacios++;
            }
        }
        return vacios;
    }

    function elimina(idjuego) {
        alertify.confirm('Eliminar juego', '¿Desea eliminar este registro?', function () {
                $.ajax({
                    type: "POST",
                    data: "idjuego=" + idjuego,
                    url: "php/eliminar.php",
                    success: function (r) {
                        if (r == 1) {
                            $('#tablastores').load('tabla.php');
                            alertify.success("Eliminado con éxito :)");
                        } else {
                            alertify.error("No se pudo eliminar :(");
                        }
                    }
                });
            }
            , function () {
                alertify.error('Canceló')
            });

    }
</script>