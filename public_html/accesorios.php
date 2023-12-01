<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="estilos/estilo_productos.css">
    <title>CHEIN - Productos</title>
</head>
<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "chein";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    ?>

    <div class="contenido">
        <div class="opciones">
            <div class="informacion">
                <h2>Accesorios</h2>
            </div>
            <div class="filtros">
                <div>
                    <p>
                        <button class="btn-filtros" type="button" data-bs-toggle="collapse" data-bs-target="#filtros" aria-expanded="false" aria-controls="filtros">
                            Filtros
                        </button>
                    </p>
                    <div style="min-height: 120px;">
                        <div class="collapse collapse-horizontal" id="filtros">
                            <div class="card card-body" style="width: 300px;">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                                <label for="precio_min">Precio mínimo:</label>
                                <input type="number" name="precio_min" id="precio_min" value="0" placeholder="Precio mínimo" min="0">

                                <label for="precio_max">Precio máximo:</label>
                                <input type="number" name="precio_max" id="precio_max" value="9999" placeholder="Precio máximo" min="0">

                                <label for="existencias_min">Existencias mínimas:</label>
                                <input type="number" name="existencias_min" id="existencias_min" value="0" placeholder="Existencias mínimas" min="0">

                                <label for="descuento">Con descuento:</label>
                                <select name="descuento" id="descuento">
                                    <option value="0">No</option>
                                    <option value="1">Sí</option>
                                </select>

                                <input type="submit" value="Filtrar" name="filtrar">
                            </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="btns-categorias">
                    <a href="productos.php" role="button" class="btn-categoria">Todos</a>
                    <a href="ropa.php" role="button" class="btn-categoria">Ropa</a>
                    <a href="accesorios.php" role="button" class="btn-categoria">Accesorios</a>
                </div>

                <div class="orden">
                    <form id="formulario" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                        <label for="orden">Ordenar por precio:</label>
                        <select name="orden" id="orden">
                            <option value="asc">Precio de menor a mayor</option>
                            <option value="desc">Precio de mayor a menor</option>
                            <option value="none">Sin orden</option>
                        </select>

                        <input type="submit" value="Ordenar" name="ordenar">
                    </form>
                </div>
            </div>
        </div>
        <div class="tarjetas">
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['filtrar'])){
                    $precio_min = $_POST['precio_min'];
                    $precio_max = $_POST['precio_max'];
                    $existencias_min = $_POST['existencias_min'];
                    $descuento = $_POST['descuento'];

                    $sql = "SELECT * FROM producto WHERE Categoria_P = 'Accesorio' AND Precio_P >= $precio_min AND Precio_P <= $precio_max AND Existencias_P >= $existencias_min";

                    if ($descuento == 1) {
                        $sql .= " AND Descuento_P > 0;";
                    }else{
                        $sql .= ";";
                    }

                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        echo "Nombre: " . $row['Nombre_P'] . " - Precio: " . $row['Precio_P'] . "<br>";
                    }
                }elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ordenar'])){
                    $orden = $_POST['orden'];

                    $sql = "SELECT * FROM producto WHERE Categoria_P = 'Accesorio'";
                    
                    if ($orden == 'asc') {
                        $sql .= " ORDER BY Precio_P ASC";
                    } elseif ($orden == 'desc') {
                        $sql .= " ORDER BY Precio_P DESC";
                    } else{
                        $sql .= ";";
                    }
                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        echo "Nombre: " . $row['Nombre_P'] . " - Precio: " . $row['Precio_P'] . "<br>";
                    }
                }else{
                    $sql = "SELECT * FROM producto WHERE Categoria_P = 'Accesorio';";
                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        echo "Nombre: " . $row['Nombre_P'] . " - Precio: " . $row['Precio_P'] . "<br>";
                    }
                }
            ?>
        </div>
    </div>

    <?php $conn->close(); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>