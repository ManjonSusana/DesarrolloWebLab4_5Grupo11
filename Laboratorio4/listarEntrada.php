


<link rel="stylesheet" href="estilos.css">

<style>
    .modal {
        display: none; 
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); 
    }

    .modal-content {
        background-color: #fff;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 500px;
        text-align: center;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="cerrarModal()">&times;</span>
        <h2>Mensaje</h2>
        <p id="mensajeContenido"></p>
    </div>
</div>



<?php
include("conexion.php");
$sql="SELECT id, bandeja, correo , asunto, mensaje, estado FROM correo";
$resultado = $con->query($sql);
?>
<table class="table table-write table-striped">
    <tr class="table-light">
        <th scope="col">Correo</th>
        <th scope="col">Asunto</th>
        <th scope="col">Estado</th>
        <th scope="col">Operación</th>
    </tr>
            
    <?php while($fila=$resultado->fetch_assoc()) 
    {
        if($fila['bandeja']=='entrada') 
        { ?>
            <tr>
            <td><?php echo $fila['correo'];?></td>
            <td><?php echo $fila['asunto'];?></td>
            <td><?php echo $fila['estado'];?></td>
            <td>
                    <button type="button" class="btn btn-info" class="ver" onclick="verMensaje(<?php echo $fila['id']; ?>)">Ver</button>
                    <button type="button" class="btn btn-danger" class="ver" onclick="eliminarCorreoSa(<?php echo $fila['id']; ?>)">Eliminar</button>

            </td>

            </tr>
        <?php
        } ?>
    
    <?php
    } ?>
 </table>
