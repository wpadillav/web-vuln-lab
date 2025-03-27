<?php
$db = new mysqli('ip_base_de_datos', 'hack', 'H4ck1ng', 'hacking_class');
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $db->query($query);
    
    if ($result) {
        if ($result->num_rows > 0) {
            $message = "¡Acceso concedido!";
            $alert_type = "success";
            $user = $result->fetch_assoc();
            $user_info = "<div class='mt-3 p-3 bg-light rounded'><h5>Información del usuario:</h5><pre>".print_r($user, true)."</pre></div>";
        } else {
            $message = "Credenciales incorrectas";
            $alert_type = "danger";
        }
    } else {
        $message = "Error en la consulta: ".$db->error;
        $alert_type = "danger";
    }
    
    $sql_debug = "<div class='mt-3 p-3 bg-dark text-light rounded'><h5>Consulta SQL ejecutada:</h5><code>".htmlspecialchars($query)."</code></div>";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Injection Lab - Seguridad en el Desarrollo de Software</title>
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
            <p class="lead mt-3">Laboratorio de SQL Injection</p>
        </div>
    </header>

    <!-- Contenido principal -->
    <main class="container mb-5">
        <a href="index.html" class="btn btn-outline-primary mb-3"><i class="fas fa-arrow-left"></i> Regresar</a>
        <div class="vulnerability-form shadow">
            <?php if(isset($message)): ?>
                <div class="alert alert-<?= $alert_type ?>">
                    <?= $message ?>
                    <?= $user_info ?? '' ?>
                    <?= $sql_debug ?? '' ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Usuario</label>
                    <input type="text" name="username" class="form-control" placeholder="">
                </div>
                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" placeholder="   ">
                </div>
                <button type="submit" class="btn btn-primary">Iniciar sesión</button>
            </form>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Efectos hover para las tarjetas
        $('.card-vulnerability').hover(
            function() { $(this).find('.card-icon').css('transform', 'scale(1.1)'); },
            function() { $(this).find('.card-icon').css('transform', 'scale(1)'); }
        );
    </script>
</body>
</html>
