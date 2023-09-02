<?php
    // <?php  
    require 'C:\xampp\phpMyAdmin\vendor/autoload.php';
    use Ramsey\Uuid\Uuid;
    $generatedUuid = Uuid::uuid4()->toString();
    // 
include("conexion.php");

if (isset($_POST['guardar']) || isset($_POST['actualizar']) || isset($_POST['eliminar'])) {
    $dpi = $_POST['dpi'];
    $id_tabla = $generatedUuid;
    $first_name = $_POST['first_name'];
    $second_name = $_POST['second_name'];
    $first_last = $_POST['first_last'];
    $second_last = $_POST['second_last'];
    $adress = $_POST['adress'];
    $tel = $_POST['tel'];
    $cel = $_POST['cel'];
    $salario_b = $_POST['salario_b'];
    $bono = $_POST['bono'];
    $selectedConnection = $_POST['conexion'];
    if (
        strlen($_POST['dpi']) >= 1 &&
        strlen($_POST['first_name']) >= 0 &&
        strlen($_POST['second_name']) >= 0 &&
        strlen($_POST['first_last']) >= 0 &&
        strlen($_POST['second_last']) >= 0 &&
        strlen($_POST['adress']) >= 0 &&
        strlen($_POST['tel']) >= 0 &&
        strlen($_POST['cel']) >= 0 &&
        strlen($_POST['salario_b']) >= 0 &&
        strlen($_POST['bono']) >= 0
    ) {
        if ($selectedConnection === 'mysql' || $selectedConnection === 'ambas') {
            if (isset($_POST['guardar'])) {
                $consultaMySQL = "INSERT INTO persona (id_client, dpi, first_name, second_name, first_lastname, second_lastname, adress, telefono, celular, salario_base, bonificacion) VALUES ('$id_tabla', '$dpi', '$first_name', '$second_name', '$first_last', '$second_last', '$adress', '$tel', '$cel', '$salario_b', '$bono')";
    
                $resultadoMySQL = mysqli_query($conex, $consultaMySQL);
                
                if ($resultadoMySQL) {
                    echo "<h3 class='ok'>Datos enviados a la tabla MySQL</h3>";
                    if($selectedConnection!='ambas'){
                    $dataSynchronizer->agregarTransaccion('postgres', $consultaMySQL);   
                    }
                } else {
                    echo "<h3 class='bad'>Error en MySQL</h3>";
                } 
            }

        if (isset($_POST['actualizar'])) {
            // Código para UPDATE
            $consultaUpdate = "UPDATE persona SET 
            first_name = '$first_name', 
            second_name = '$second_name', 
            first_lastname = '$first_last', 
            second_lastname = '$second_last', 
            adress = '$adress', 
            telefono = '$tel', 
            celular = '$cel', 
            salario_base = '$salario_b', 
            bonificacion = '$bono' 
            WHERE dpi = '$dpi'";
    
            $resultadoUpdateMySQL = mysqli_query($conex, $consultaUpdate);
            
            if ($resultadoUpdateMySQL) {
                echo "<h3 class='ok'>Registro actualizado en Mysql</h3>";
                if($selectedConnection!='ambas'){
                $dataSynchronizer->agregarTransaccion('postgres', $consultaUpdate); 
                } 
            } else {
                echo "<h3 class='bad'>Error al actualizar</h3>";
            }
            }

            if (isset($_POST['eliminar'])) {
                // Código para DELETE
                $consultaDelete = "DELETE FROM persona WHERE dpi = '$dpi'";
                
                $resultadoDeleteMySQL = mysqli_query($conex, $consultaDelete);
                
                if ($resultadoDeleteMySQL) {
                    echo "<h3 class='ok'>Registro eliminado de Mysql</h3>";
                    if($selectedConnection!='ambas'){
                        $dataSynchronizer->agregarTransaccion('postgres', $consultaDelete);  
                    }
                } else {
                    echo "<h3 class='bad'>Error al eliminar</h3>";
                }
            }             
        }

        if ($selectedConnection === 'postgres' || $selectedConnection === 'ambas') {
            if (isset($_POST['guardar'])) {
                $consultaPostgres = "INSERT INTO persona (id_client, dpi,first_name, second_name, first_lastname, second_lastname, adress, telefono, celular, salario_base, bonificacion) VALUES ('$id_tabla', '$dpi','$first_name', '$second_name', '$first_last', '$second_last', '$adress', '$tel', '$cel', '$salario_b', '$bono')";
                
                $resultadoPostgres = pg_query($conexion, $consultaPostgres);
                
                if ($resultadoPostgres) {
                    echo "<h3 class='ok'>Datos enviados a la tabla PostgreSQL</h3>";
                    if($selectedConnection!='ambas'){
                    $dataSynchronizer->agregarTransaccion('mysql', $consultaPostgres); 
                    } 
                } else {
                    echo "<h3 class='bad'>Error en PostgreSQL</h3>";
                }
            }      
            if (isset($_POST['actualizar'])) {
                // Código para UPDATE
                $consultaUpdatepg = "UPDATE persona SET 
                    first_name = '$first_name', 
                    second_name = '$second_name', 
                    first_lastname = '$first_last', 
                    second_lastname = '$second_last', 
                    adress = '$adress', 
                    telefono = '$tel', 
                    celular = '$cel', 
                    salario_base = '$salario_b', 
                    bonificacion = '$bono' 
                    WHERE dpi = '$dpi'";
        
                $resultadoUpdatePostgres = pg_query($conexion, $consultaUpdatepg);
                
                if ($resultadoUpdatePostgres) {
                    echo "<h3 class='ok'>Registro actualizado en Postgresql</h3>";
                    if($selectedConnection!='ambas'){
                    $dataSynchronizer->agregarTransaccion('mysql', $consultaUpdatepg);  
                    }
                } else {
                    echo "<h3 class='bad'>Error al actualizar</h3>";
                }
            } 
        }
        if (isset($_POST['eliminar'])) {
            // Código para DELETE
            $consultaDeletepg = "DELETE FROM persona WHERE dpi = '$dpi'";
            
            $resultadoDeletePostgres = pg_query($conexion, $consultaDeletepg);
            
            if ($resultadoDeletePostgres) {
                echo "<h3 class='ok'>Registro eliminado de Postgresql</h3>";
                if($selectedConnection!='ambas'){
                $dataSynchronizer->agregarTransaccion('mysql', $consultaDeletepg); 
                } 
            } else {
                echo "<h3 class='bad'>Error al eliminar</h3>";
            }
        }
    }
}
?>
