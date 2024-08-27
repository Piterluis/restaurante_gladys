<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platos del Restaurante</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #343a40;
        }
        .menu {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .dish {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        .dish:last-child {
            border-bottom: none;
        }
        .dish-name {
            font-weight: bold;
            font-size: 1.2em;
            color: #007bff;
        }
        .dish-desc {
            color: #6c757d;
        }
        .dish-price {
            color: #28a745;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h1>Platos del Restaurante</h1>

<div class="menu">
    <?php
    // Datos de conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "restaurante_gladys";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("<p style='color: red;'>Conexión fallida: " . $conn->connect_error . "</p>");
    }

    // Consulta SQL para obtener los platos
    $sql = "SELECT nombre_plato, descripcion, precio FROM platos";
    $result = $conn->query($sql);

    // Mostrar los resultados
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='dish'>";
            echo "<p class='dish-name'>" . $row["nombre_plato"] . "</p>";
            echo "<p class='dish-desc'>" . $row["descripcion"] . "</p>";
            echo "<p class='dish-price'>Precio: $" . number_format($row["precio"], 2) . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No se encontraron platos.</p>";
    }

    // Cerrar conexión
    $conn->close();
    ?>
</div>

</body>
</html>
