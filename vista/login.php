<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Iniciar sesión</title>
    <style>
        body {
            background: url('../assets/imagenes/backGroundLogin.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #007bff;
            width: 100%;
            padding: 10px 15px; /* Ajuste del padding */
        }

        .navbar-dark .navbar-toggler-icon {
            background-color: #ffffff;
        }

        .container {
            max-width: 800px;
            width: 100%;
            padding: 20px 15px; /* Ajuste del padding */
            display: grid;
            place-items: center;
            margin: auto;
            margin-top: 20px; /* Mover el formulario hacia abajo */
        }

        form {
            background-color: rgba(255, 255, 255, 0.8);
            border: 1px solid #87ceeb;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #007bff;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 10px;
        }

        button:hover {
            background-color: #0056b3;
        }

        #btnRegistro {
            background-color: #28a745;
            color: #fff;
        }

        #btnRegistro:hover {
            background-color: #218838;
        }

        .btn-volver {
            background-color: #e63946;
            color: #fff;
            border-color: #e63946;
            border-radius: 10px;
            padding: 8px 16px;
            margin-left: 10px;
        }

        .btn-volver:hover {
            background-color: #cf303e;
            border-color: #cf303e;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="../administrador/menuAdministrador.php">Centro Odontológico</a>
        <div class="navbar-collapse justify-content-end">
            <button class="btn rounded mr-2 btn-volver" type="button" onclick="window.history.back()">Volver</button>
        </div>
    </nav>
    <div class="container">
        <form action="../modelo/modeloLogin.php" method="post">
            <h2>Iniciar sesión</h2>
            <label for="documento">Documento:</label>
            <input type="text" id="documento" name="documento" required>
            <br>
            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required>
            <br>
            <button type="submit">Iniciar sesión</button>
            <br>
            <button id="btnRegistro" type="button" onclick="window.location.href='../vista/registro.php';">Registrarse</button>
        </form>
    </div>
</body>
</html>
