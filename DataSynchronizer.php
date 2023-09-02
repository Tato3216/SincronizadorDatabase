<?php
class DataSynchronizer {
    private $file = 'sync.json';
    private $transaccionesPendientes = [];
    private $conex; 
    private $conexion; 

    public function __construct($conex, $conexion) {
        $this->conex = $conex;
        $this->conexion = $conexion;
    }

    public function agregarTransaccion($conexion, $query) {
        $this->cargarTransacciones();
        $this->transaccionesPendientes[] = [
            'conexionsync' => $conexion,
            'querysync' => $query
        ];
        $this->guardarTransacciones();
    }
    private function cargarTransacciones() {
        if (file_exists($this->file)) {
            $this->transaccionesPendientes = json_decode(file_get_contents($this->file), true);
        }
    }

    private function guardarTransacciones() {
        file_put_contents($this->file, json_encode($this->transaccionesPendientes, JSON_PRETTY_PRINT));
    }
    public function limpiarTransacciones() {
        $this->transaccionesPendientes = [];
        $this->guardarTransacciones();
    }

    public function getTransaccionesPendientes() {
        return $this->transaccionesPendientes;
    }

    public function sincronizar() {
        if (file_exists($this->file)) {
            $this->transaccionesPendientes = json_decode(file_get_contents($this->file), true);

            foreach ($this->transaccionesPendientes as $transaccion) {
                $conexionSincronizacion = $transaccion['conexionsync'];
                $query = $transaccion['querysync'];

                // Determina la conexión según el valor de 'conexionsync'
                $conexion = ($conexionSincronizacion === 'mysql') ? $this->conex : $this->conexion;

                // Ejecuta el query en la conexión correspondiente
                if ($conexionSincronizacion === 'mysql') {
                    $resultado = mysqli_query($conexion, $query);
                } else {
                    $resultado = pg_query($conexion, $query);
                }
                if ($resultado) {
                    echo "<h3>Registro Sincronizado</h3>";
                } else {
                    echo "<h3>Error:</h3>";
                }
            }
        } else {
            echo "<h3>No hay transacciones pendientes</h3>";
        }
    }
}
?>
