<?php
include('config.php');  // Incluir la configuración de la base de datos

// Procesar el formulario para agregar un comentario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $comentario = $_POST['comentario'];

    // Insertar el comentario en la base de datos
    $sql = "INSERT INTO comentarios (nombre, comentario) VALUES ('$nombre', '$comentario')";

    if ($conn->query($sql) === TRUE) {
        echo "Comentario agregado exitosamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Obtener todos los comentarios
$sql = "SELECT nombre, comentario, fecha FROM comentarios ORDER BY fecha DESC";
$result = $conn->query($sql);
?>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "comentarios_db";  // Cambia esto por el nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentarios</title>
</head>
<body>
    <h2>Deja tu comentario</h2>
    
    <!-- Formulario para agregar un comentario -->
    <form action="comentarios.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="comentario">Comentario:</label><br>
        <textarea id="comentario" name="comentario" rows="4" cols="50" required></textarea><br><br>

        <input type="submit" value="Enviar Comentario">
    </form>

    <h3>Comentarios Recientes:</h3>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div><strong>" . $row["nombre"] . "</strong> dijo: <p>" . $row["comentario"] . "</p><small>Publicado el " . $row["fecha"] . "</small></div><hr>";
        }
    } else {
        echo "No hay comentarios aún.";
    }
    ?>

</body>
</html>

<?php
$conn->close();
?>