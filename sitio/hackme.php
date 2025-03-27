<?php
$db = new mysqli('ip_base_datos', 'hack', 'H4ck1ng', 'hacking_class');
$db->set_charset("utf8");

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $comment = $db->real_escape_string($_POST['comment']);
    $db->query("INSERT INTO comments (comment) VALUES ('$comment')");
    header("Location: hackme.php");
    exit();
}

$comments = $db->query("SELECT * FROM comments ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XSS Lab - UNIMINUTO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Source+Code+Pro:wght@400;600&display=swap" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <!-- Header común -->
    <header class="header text-center">
        <div class="container">
            <h1 class="course-title mb-3">Seguridad en el Desarrollo de Software</h1>
            <p class="lead mt-3">Laboratorio de Cross-Site Scripting (XSS)</p>
        </div>
    </header>

    <!-- Contenido principal -->
    <main class="container mb-5">
        <a href="index.html" class="btn btn-outline-primary mb-3"><i class="fas fa-arrow-left"></i> Regresar</a>
        <div class="vulnerability-form shadow">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Ingresa tu comentario (o payload XSS):</label>
                    <textarea name="comment" class="form-control" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-danger">Publicar Comentario</button>
            </form>

            <div class="mt-5">
                <h4 class="border-bottom pb-2">Comentarios Publicados:</h4>
                <?php if ($comments && $comments->num_rows > 0): ?>
                    <?php while ($row = $comments->fetch_assoc()): ?>
                        <div class="comment-box">
                            <div class="comment-content"><?= $row['comment'] ?></div>
                            <small class="text-muted"><?= $row['created_at'] ?? 'Fecha reciente' ?></small>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-muted">No hay comentarios aún.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

     <!-- Footer -->
     <footer class="footer text-center">
        <div class="container">
            <p class="mb-1">© 2025 wpadilla - Todos los derechos reservados</p>
            <p class="mb-0">Curso - Seguridad en el Desarrollo de Software</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
