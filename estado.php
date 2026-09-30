<?php
require_once "config.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if (!$id) {
    die("ID no válido.");
}

$estados = ["Programada", "Atendida", "Cancelada"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $estado = $_POST["estado"] ?? "";

    if (in_array($estado, $estados, true)) {
        $stmt = $conexion->prepare("UPDATE citas SET estado = ? WHERE id = ?");
        $stmt->bind_param("si", $estado, $id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: index.php");
    exit;
}

$stmt = $conexion->prepare("SELECT paciente, estado FROM citas WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$cita = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$cita) {
    die("La cita no existe.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar estado</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
<header class="encabezado">
    <div>
        <h1>Cambiar estado de la cita</h1>
        <p><?= htmlspecialchars($cita["paciente"]) ?></p>
    </div>
</header>

<main class="contenedor">
    <section class="tarjeta">
        <form method="POST">
            <label for="estado">Estado</label>
            <select name="estado" id="estado" required>
                <?php foreach ($estados as $estado): ?>
                    <option value="<?= $estado ?>" <?= $cita["estado"] === $estado ? "selected" : "" ?>>
                        <?= $estado ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <div class="botones espacio-superior">
                <button type="submit">Actualizar estado</button>
                <a class="btn-secundario" href="index.php">Cancelar</a>
            </div>
        </form>
    </section>
</main>
</body>
</html>