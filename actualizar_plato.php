<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Platos</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        td {
            background-color: #fff;
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
        input[type="submit"], .btn {
            padding: 10px 15px;
            margin: 5px 0;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
        }
        .btn-update {
            background-color: #28a745;
            color: white;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
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

<h1>Gestionar Platos</h1>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Plato</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Categoría</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Conexión a la base de datos
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

            // Eliminar plato
            if (isset($_GET['delete_id'])) {
                $delete_id = $_GET['delete_id'];
                $delete_sql = "DELETE FROM platos WHERE id='$delete_id'";
                if ($conn->query($delete_sql) === TRUE) {
                    echo "<p class='success'>Plato eliminado con éxito.</p>";
                } else {
                    echo "<p class='error'>Error al eliminar el plato: " . $conn->error . "</p>";
                }
            }

            // Consulta SQL para obtener los platos
            $sql = "SELECT p.id, p.nombre_plato, p.descripcion, p.precio, c.nombre_categoria 
                    FROM platos p
                    JOIN categorias_menu c ON p.categoria_id = c.id";
            $result = $conn->query($sql);

            // Mostrar los resultados
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["nombre_plato"] . "</td>";
                    echo "<td>" . $row["descripcion"] . "</td>";
                    echo "<td>$" . number_format($row["precio"], 2) . "</td>";
                    echo "<td>" . $row["nombre_categoria"] . "</td>";
                    echo "<td>";
                    echo "<a href='?update_id=" . $row["id"] . "' class='btn btn-update'>Actualizar</a> ";
                    echo "<a href='?delete_id=" . $row["id"] . "' class='btn btn-delete' onclick='return confirm(\"¿Estás seguro de que quieres eliminar este plato?\")'>Eliminar</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No se encontraron platos.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<div class="form-container">
    <?php
    if (isset($_GET['update_id'])) {
        $update_id = $_GET['update_id'];
        $sql = "SELECT * FROM platos WHERE id='$update_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "<p class='error'>Plato no encontrado.</p>";
        }
    }

    // Verificar si se ha enviado el formulario de actualización
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_plato'])) {
        $id = $_POST['id'];
        $nombre_plato = $_POST['nombre_plato'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $categoria_id = $_POST['categoria_id'];

        // Actualizar datos en la base de datos
        $sql = "UPDATE platos SET nombre_plato='$nombre_plato', descripcion='$descripcion', precio='$precio', categoria_id='$categoria_id' WHERE id='$id'";

        if ($conn->query($sql) === TRUE) {
            echo "<p class='success'>Plato actualizado con éxito.</p>";
        } else {
            echo "<p class='error'>Error: " . $sql . "<br>" . $conn->error . "</p>";
        }
    }

    // Cerrar conexión
    $conn->close();
    ?>

    <?php if (isset($row)): ?>
    <form action="" method="POST">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <div class="form-group">
            <label for="nombre_plato">Nombre del Plato:</label>
            <input type="text" id="nombre_plato" name="nombre_plato" value="<?php echo $row['nombre_plato']; ?>" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" rows="4" required><?php echo $row['descripcion']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="precio">Precio:</label>
            <input type="text" id="precio" name="precio" value="<?php echo $row['precio']; ?>" required>
        </div>
        <div class="form-group">
            <label for="categoria_id">Categoría:</label>
            <select id="categoria_id" name="categoria_id" required>
                <option value="1" <?php echo $row['categoria_id'] == 1 ? 'selected' : ''; ?>>Entradas</option>
                <option value="2" <?php echo $row['categoria_id'] == 2 ? 'selected' : ''; ?>>Platos Principales</option>
                <option value="3" <?php echo $row['categoria_id'] == 3 ? 'selected' : ''; ?>>Postres</option>
                <option value="4" <?php echo $row['categoria_id'] == 4 ? 'selected' : ''; ?>>Bebidas</option>
            </select>
        </div>
        <input type="submit" name="update_plato" value="Actualizar Plato">
    </form>
    <?php endif; ?>
</div>

</body>
</html>
