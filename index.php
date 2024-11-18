<?php
// CONEXION CON LA BASE DE DATOS
    $conn = new PDO('mysql:host=localhost;dbname=bdargentina','root','');

// CREATE
if (isset($_POST["save"])) {
    $result = $conn->prepare("INSERT INTO alumnos(nombres, apellidos, email, curso, nota)
    VALUES (?,?,?,?,?)");
    $result->execute([$_POST["nombres"],$_POST["apellidos"],$_POST["email"],
    $_POST["curso"],$_POST["nota"]]);
}

// UPDATE- NO BORRAR EL ID
if (isset($_POST["update"])) {
    $result = $conn->prepare("UPDATE alumnos SET nombres=?, apellidos=?, email=?, curso=?, nota=? WHERE id=?");
    $result->execute([$_POST["nombres"],$_POST["apellidos"],$_POST["email"],
    $_POST["curso"],$_POST["nota"], $_POST["id"]]);
}   

// DELETE- NO BORRAR EL ID
if (isset($_POST["delete"])) {
    $result = $conn->prepare("DELETE FROM alumnos WHERE id=?");
    $result->execute([$_POST["id"]]);
}  
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="CRUD,PHP, PDO, MYSQL, Miguel Ramos"/>
    <meta name="author" content="Miguel Ramos Alarcon">
    <meta name="copyright" content="Miguel Ramos Alarcon" />
    <meta name="description" content="CRUD PHP con PDO y Mysql básico sin estilos 2024">
    <title>CRUD CON PDO</title>
</head>
<body style="width:100dw; display: grid; place-item:center">  
    <h1>CRUD CON PDO</h1>
    <!-- FORMULARIO PARA INSERTAR/ACTUALIZAR UN ALUMNO -->
    <form action="" method="post">
        <input type="hidden" name="id" value="<?= isset($_GET['id'])? $_GET['id']:''?>">
        <input type="text" name="nombres" placeholder="Nombres" value="<?= $_GET['nombres']??''?>">
        <input type="text" name="apellidos" placeholder="Apellidos" value="<?= $_GET['apellidos']??''?>">
        <input type="email" name="email" placeholder="Email" value="<?= $_GET['email']??''?>">
        <input type="text" name="curso" placeholder="Curso" value="<?= $_GET['curso']??''?>">
        <input type="number" name="nota" placeholder="Nota"  min="0" value="<?= $_GET['nota']??''?>">
        <button type="submit" name="<?= isset($_GET['edit'])?'update':'save'?>">Guardar</button>
        <?php if (isset($_GET['edit'])):?>
            <a href="index.php">Cancelar</a>
        <?php endif;?>
    </form>
    <br>
    <br>
    <br>
    <table style="text-align:center">
        <tr style="background-color: whitesmoke">
            <th>ID</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Email</th>
            <th>Curso</th>
            <th>Nota</th>
            <th>Acciones</th>
        </tr>
    <!-- CODIGO PHP - CON SENTENCIA SQL PARA MOSTRAR TODOS LOS REGISTROS DE MI TABLA EN LA BD -->
        <?php 
            $alumnos = $conn->query("SELECT * FROM alumnos")->fetchAll();
        ?>
    <!-- TABLA CON BUCLE FOREACH -->
        <?php foreach($alumnos as $alumno): ?>
            <tr>
                <td> <?= $alumno['id'] ?> </td>
                <td> <?= $alumno['nombres'] ?> </td>
                <td> <?= $alumno['apellidos'] ?> </td>
                <td> <?= $alumno['email'] ?> </td>
                <td> <?= $alumno['curso'] ?> </td>
                <td> <?= $alumno['nota'] ?> </td>
                <td>
                    <a href="?edit&id=<?=$alumno['id']?>
                    &nombres=<?=$alumno['nombres']?>
                    &apellidos=<?=$alumno['apellidos']?>
                    &email=<?=$alumno['email']?>
                    &curso=<?=$alumno['curso']?>
                    &nota=<?=$alumno['nota']?>
                    ">Editar</a>
                    <form action="" method="post" style="display: inline;">
                        <input type="hidden" name="id" value="<?=$alumno['id']?>">
                        <button type="submit" name="delete">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
