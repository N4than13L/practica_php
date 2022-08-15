<!-- <?php
        require("assets/function/conexion.php");
        $mysqli = call_mysqli();
        $sql = "SELECT * FROM alumno  WHERE id >= 1";

        $rePress = $mysqli->query($sql);
        $rowPerfile = $rePress->fetch_assoc();

        ?> -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>alumnos</title>
</head>

<body>

    <nav>
        <ul><a href="index.php">Inicio</a></ul>
        <ul><a href="./template/agregarAlumno.php">Agregar Alumno</a></ul>
        <ul><a href="./template/agregarCurso.php">Agregar Curso</a></ul>
        <ul><a href="./template/agregarPadre.php">Agregar Padre o tutor</a></ul>
        <ul><a href="./template/clasificacionCurso.php">Agregar Clasificacion del curso</a></ul>
        <ul><a href="./template/clasificacionPadre.php">Agregar Clasificacion del Padre o tutor</a></ul>
    </nav>


    <h1 style="text-align:center;">Hola Mundo!</h1>
</body>

</html>