<?php
    if(session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "chein";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $agregados = 0;
    $exis = 0;

    if (isset($_SESSION['id']) && isset($_POST['restarCarrito'])) {
        $id_usuario = $_SESSION['id'];
        $id_producto = $_POST['ID_Producto'];

        $sql = "SELECT Existencias_P FROM producto WHERE ID_Producto = $id_producto;";
        $result = $conn->query($sql);
        if ($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $exis = $row['Existencias_P'];
        }

        $sql = "SELECT SUM(Cantidad) AS suma FROM carrito WHERE ID_Usuario = $id_usuario AND ID_Producto = $id_producto;";
        $result = $conn->query($sql);
        if ($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $agregados = $row['suma'];
        }

        if ($agregados != null && $agregados > 0){
            $sql = "UPDATE carrito SET Cantidad = $agregados-1 WHERE ID_Usuario = $id_usuario AND ID_Producto = $id_producto;";
            if ($conn->query($sql) === TRUE) {
                if ($conn->affected_rows > 0) {
                    //echo '<script>console.log("Producto agregado al carrito");</script>';
                } else {
                    //echo '<script>console.log("Producto NO agregado al carrito");</script>';
                }
            } else {
                //echo '<script>console.log("Error al insertar registro al carrito");</script>';
            }
        }

        $sql = "SELECT SUM(Cantidad) AS suma FROM carrito WHERE ID_Usuario = $id_usuario AND ID_Producto = $id_producto;";
        $result = $conn->query($sql);
        if ($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $agregados = $row['suma'];
            echo $agregados;
        }
    }
    $conn->close();
?>