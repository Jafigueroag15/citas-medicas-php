<?php
require_once "config.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if (!$id) {
    die("ID de cita no válido.");
}

$stmt = $conexion->prepare("SELECT * FROM citas WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$cita = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$cita) {
    die("La cita no existe.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $documento = trim($_POST["documento"] ?? "");
    $paciente = trim($_POST["paciente"] ?? "");
    $telefono = trim($_POST["telefono"] ?? "");
    $correo = trim($_POST["correo"] ?? "");
    $medico = trim($_POST["medico"] ?? "");
    $especialidad = trim($_POST["especialidad"] ?? "");
    $fecha = $_POST["fecha"] ?? "";
    $hora = $_POST["hora"] ?? "";
    $motivo = trim($_POST["motivo"] ?? "");

    $sql = "UPDATE citas
            SET documento=?, paciente=?, telefono=?, correo=?, medico=?,
                especialidad=?, fecha=?, hora=?, motivo=?
            WHERE id=?";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param(
        "sssssssssi",
        $documento,
        $paciente,
        $telefono,
        $correo,
        $medico,
        $especialidad,
        $fecha,
        $hora,
        $motivo,
        $id
    );
    $stmt->execute();
    $stmt->close();

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar cita</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
<header class="encabezado">
    <div>
        <h1>Editar cita médica</h1>
        <p>Actualice la información registrada</p>
    </div>
</header>

<main class="contenedor">
    <section class="tarjeta">
        <form method="POST" class="formulario">
            <div>
                <label>Documento</label>
                <input type="text" name="documento" value="<?= htmlspecialchars($cita["documento"]) ?>" required>
            </div>

            <div>
                <label>Paciente</label>
                <input type="text" name="paciente" value="<?= htmlspecialchars($cita["paciente"]) ?>" required>
            </div>

            <div>
                <label>Teléfono</label>
                <input type="text" name="telefono" value="<?= htmlspecialchars($cita["telefono"]) ?>" required>
            </div>

            <div>
                <label>Correo</label>
                <input type="email" name="correo" value="<?= htmlspecialchars($cita["correo"]) ?>" required>
            </div>

            <div>
                <label>Médico</label>
                <input type="text" name="medico" value="<?= htmlspecialchars($cita["medico"]) ?>" required>
            </div>

            <div>
                <label>Especialidad</label>
                <input type="text" name="especialidad" value="<?= htmlspecialchars($cita["especialidad"]) ?>" required>
            </div>

            <div>
                <label>Fecha</label>
                <input type="date" name="fecha" value="<?= htmlspecialchars($cita["fecha"]) ?>" required>
            </div>

            <div>
                <label>Hora</label>
                <input type="time" name="hora" value="<?= htmlspecialchars(substr($cita["hora"], 0, 5)) ?>" required>
            </div>

            <div class="campo-completo">
                <label>Motivo</label>
                <textarea name="motivo" rows="3" required><?= htmlspecialchars($cita["motivo"]) ?></textarea>
            </div>

            <div class="campo-completo botones">
                <button type="submit">Guardar cambios</button>
                <a class="btn-secundario" href="index.php">Cancelar</a>
            </div>
        </form>
    </section>
</main>
</body>
</html>