<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Plato</title>
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
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], textarea, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .success {
            color: green;
            font-weight: bold;
            text-align: center;
        }
        .error {
            color: red;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>

<h1>Registrar Nuevo Plato</h1>

<div class="form-container">
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Datos de conexión a la base de datos
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "restaurante_gladys";

        // Crear conexión
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar conexión
        if ($conn->connect_error) {
            die("<p class='error'>Conexión fallida: " . $conn->connect_error . "</p>");
        }

        // Recibir datos del formulario
        $nombre_plato = $_POST['nombre_plato'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $categoria_id = $_POST['categoria_id'];

        // Insertar datos en la base de datos
        $sql = "INSERT INTO platos (nombre_plato, descripcion, precio, categoria_id) VALUES ('$nombre_plato', '$descripcion', '$precio', '$categoria_id')";

        if ($conn->query($sql) === TRUE) {
            echo "<p class='success'>Nuevo plato registrado con éxito.</p>";
        } else {
            echo "<p class='error'>Error: " . $sql . "<br>" . $conn->error . "</p>";
        }

        // Cerrar conexión
        $conn->close();
    }
    ?>

    <form action="" method="POST">
        <div class="form-group">
            <label for="nombre_plato">Nombre del Plato:</label>
            <input type="text" id="nombre_plato" name="nombre_plato" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="precio">Precio:</label>
            <input type="text" id="precio" name="precio" required>
        </div>
        <div class="form-group">
            <label for="categoria_id">Categoría:</label>
            <select id="categoria_id" name="categoria_id" required>
                <option value="1">Entradas</option>
                <option value="2">Platos Principales</option>
                <option value="3">Postres</option>
                <option value="4">Bebidas</option>
            </select>
        </div>
        <input type="submit" value="Registrar Plato">
    </form>
</div>

</body>
</html>
