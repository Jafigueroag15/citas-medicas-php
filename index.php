<?php
require_once "config.php";

$mensaje = "";

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

    if ($documento && $paciente && $telefono && $correo && $medico && $especialidad && $fecha && $hora && $motivo) {
        $sql = "INSERT INTO citas
                (documento, paciente, telefono, correo, medico, especialidad, fecha, hora, motivo, estado)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Programada')";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param(
            "sssssssss",
            $documento,
            $paciente,
            $telefono,
            $correo,
            $medico,
            $especialidad,
            $fecha,
            $hora,
            $motivo
        );
        $stmt->execute();
        $stmt->close();

        header("Location: index.php?ok=1");
        exit;
    } else {
        $mensaje = "Todos los campos son obligatorios.";
    }
}

if (isset($_GET["ok"])) {
    $mensaje = "La cita médica fue registrada correctamente.";
}

$resultado = $conexion->query("SELECT * FROM citas ORDER BY fecha ASC, hora ASC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Citas Médicas</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
<header class="encabezado">
    <div>
        <h1>Sistema de Citas Médicas</h1>
        <p>Aplicación académica en PHP + MySQL + XAMPP</p>
    </div>
</header>

<main class="contenedor">
    <?php if ($mensaje): ?>
        <div class="mensaje"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <section class="tarjeta">
        <h2>Registrar nueva cita</h2>

        <form method="POST" action="index.php" class="formulario">
            <div>
                <label for="documento">Documento</label>
                <input type="text" id="documento" name="documento" required>
            </div>

            <div>
                <label for="paciente">Nombre del paciente</label>
                <input type="text" id="paciente" name="paciente" required>
            </div>

            <div>
                <label for="telefono">Teléfono</label>
                <input type="text" id="telefono" name="telefono" required>
            </div>

            <div>
                <label for="correo">Correo electrónico</label>
                <input type="email" id="correo" name="correo" required>
            </div>

            <div>
                <label for="medico">Médico</label>
                <input type="text" id="medico" name="medico" placeholder="Ej. Dra. Ana Pérez" required>
            </div>

            <div>
                <label for="especialidad">Especialidad</label>
                <select id="especialidad" name="especialidad" required>
                    <option value="">Seleccione...</option>
                    <option>Medicina General</option>
                    <option>Pediatría</option>
                    <option>Medicina Interna</option>
                    <option>Ginecología</option>
                    <option>Dermatología</option>
                    <option>Cardiología</option>
                </select>
            </div>

            <div>
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" name="fecha" required>
            </div>

            <div>
                <label for="hora">Hora</label>
                <input type="time" id="hora" name="hora" required>
            </div>

            <div class="campo-completo">
                <label for="motivo">Motivo de la consulta</label>
                <textarea id="motivo" name="motivo" rows="3" required></textarea>
            </div>

            <div class="campo-completo">
                <button type="submit">Registrar cita</button>
            </div>
        </form>
    </section>

    <section class="tarjeta">
        <h2>Citas registradas</h2>

        <div class="tabla-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Paciente</th>
                        <th>Documento</th>
                        <th>Especialidad</th>
                        <th>Médico</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($resultado->num_rows > 0): ?>
                    <?php while ($fila = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?= $fila["id"] ?></td>
                            <td><?= htmlspecialchars($fila["paciente"]) ?></td>
                            <td><?= htmlspecialchars($fila["documento"]) ?></td>
                            <td><?= htmlspecialchars($fila["especialidad"]) ?></td>
                            <td><?= htmlspecialchars($fila["medico"]) ?></td>
                            <td><?= htmlspecialchars($fila["fecha"]) ?></td>
                            <td><?= htmlspecialchars(substr($fila["hora"], 0, 5)) ?></td>
                            <td>
                                <span class="estado estado-<?= strtolower($fila["estado"]) ?>">
                                    <?= htmlspecialchars($fila["estado"]) ?>
                                </span>
                            </td>
                            <td class="acciones">
                                <a class="btn-editar" href="editar.php?id=<?= $fila["id"] ?>">Editar</a>
                                <a class="btn-estado" href="estado.php?id=<?= $fila["id"] ?>">Estado</a>
                                <a class="btn-eliminar"
                                   href="eliminar.php?id=<?= $fila["id"] ?>"
                                   onclick="return confirm('¿Está seguro de eliminar esta cita?');">
                                   Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9">No hay citas registradas.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<footer>
    Proyecto académico - PHP, MySQL y XAMPP
</footer>
</body>
</html>