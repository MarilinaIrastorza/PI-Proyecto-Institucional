<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Materia e inscripciones</title>
    <style>
        /* 🎨 Estilos básicos para desktop y móvil */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .Asignaturas {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        @media (max-width: 600px) {
            .Asignaturas {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <h1>Listado de Materia</h1>

    <?php if (!empty($Materia)): ?>
        <?php foreach ($Materia as $m): ?>
            <div class="Materia">
                <h2><?= htmlspecialchars($m["nombre"]) ?></h2>
                <p>Inscriptos: <?= $m["inscriptos"] ?></p>
                <p>Vacantes disponibles: <?= $m["cuposTotales"] - $m["inscriptos"] ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay Materia registradas.</p>
    <?php endif; ?>
</body>
</html>