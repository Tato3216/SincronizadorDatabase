
<!DOCTYPE html>
<html>
<head>
<style>
  body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
  }
  .container {
    text-align: center;
    }
  .column-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
  }
</style>
</head>
<body>
  <div class="container">
    <h1>Guardar Datos</h1>
    <form method="post">
      <div class="column-container">
        <div>
          <!-- <label for="id">id_tabla:</label>
          <input type="text" id="id_tabla" name="id_tabla" value="<?php echo htmlspecialchars($generatedUuid); ?>"><br><br> -->
          <label for="dpin">No DPI:</label>
          <input type="text" id="dpi" name="dpi"><br><br>
          <label for="primernombre">Primer Nombre:</label>
          <input type="text" id="first_name" name="first_name"><br><br>
          <label for="segundonombre">Segundo Nombre:</label>
          <input type="text" id="second_name" name="second_name"><br><br>
          <label for="primerapellido">Primer Apellido:</label>
          <input type="text" id="first_last" name="first_last"><br><br>
          <label for="segundoapellido">Segundo Apellido:</label>
          <input type="text" id="second_last" name="second_last"><br><br>
        </div>
        <div>  
          <label for="direccion">Direccion:</label>
          <input type="text" id="adress" name="adress"><br><br> 
          <label for="telefono">Telefono:</label>
          <input type="text" id="tel" name="tel"><br><br>
          <label for="celular">Celular:</label>
          <input type="text" id="cel" name="cel"><br><br>
          <label for="salario">Salario Base:</label>
          <input type="text" id="salario_b" name="salario_b"><br><br>
          <label for="bonificacion">Bonificacion:</label>
          <input type="text" id="bono" name="bono"><br><br>
        </div>
      </div>  
      <input type="submit" name="guardar" value="Agregar nuevo">
      <input type="submit" name="actualizar" value="Actualizar">
      <input type="submit" name="eliminar" value="Eliminar"><br><br>
      <label for="conexion">Selecciona la conexión:</label>
      <select id="conexion" name="conexion">
      <option value="mysql">MySQL</option>
      <option value="postgres">PostgreSQL</option>
      <option value="ambas">Ambas</option>
      </select><br><br>
      <input type="submit" name="sincronizar" value="Sincronizar">
    </form>
    
    <?php
    include("conexion.php");
    include ("DataSynchronizer.php");
    $dataSynchronizer = new DataSynchronizer($conex,$conexion);
    include ("transactions.php");
    
    if (isset($_POST['sincronizar'])) {
      $dataSynchronizer->sincronizar();
      
      if (empty($dataSynchronizer->getTransaccionesPendientes())) {
        echo "<h3>No hay pendientes para sincronizar</h3>";
      } else {
        echo "<h3>Sincronización completada</h3>";
    }
      $dataSynchronizer->limpiarTransacciones();
    }
    ?>
  </div>
</body>
</html>
