<?php
$conex = mysqli_connect("localhost","root","A5000shg","project_mysql");

if($conex){
    // echo "todo correcto<br/>";
}
else{
    echo "Error de conexión.";
}

$conexion = pg_connect("host=localhost port=5432 dbname=project_postgresql user=postgres password=A5000shg");
if (!$conexion) {
    echo "Error de conexión.";
} else {
    // echo "Conexión exitosa a Postgres.";
}

?>
