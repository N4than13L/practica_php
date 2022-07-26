<?php
require("../assets/function/conexion.php");
$mysqli = call_mysqli();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Alumno</title>
</head>

<body>

    <nav>
        <ul><a href="../index.php">Inicio</a></ul>
        <ul><a href="./agregarAumno.php">Agregar Alumno</a></ul>
        <ul><a href="./agregarCurso.php">Agregar Curso</a></ul>
        <ul><a href="./AgregarPadre.php">Agregar Padre o tutor</a></ul>
        <ul><a href="./ClasificacionCurso.php">Agregar Clasificacion del curso</a></ul>
        <ul><a href="./ClasificacionPadre.php">Agregar Clasificacion del Padre o tutor</a></ul>
    </nav>

    <form onsubmit="enviarAlumno()" method="POST">
        <h3>Agregar Alumno</h3>
        <!-- TODO: DEBES AGREGAR EL INPUT QUE HICE EN PADRE TUTOR Y ARREGLAR LA CONDICION DE UNA SOLA LINEA -->
        <label for="txtNombre">Nombre:</label>
        <input type="text" placeholder="agrega el nombre" name="txtNombre" id="txtNombre" />
        <br />
        <br />
        <label for="txtApellido">Apellido:</label>
        <input type="text" placeholder="agrega el apellido" name="txtApellido" id="txtApellido" />
        <br />
        <br />
        <label for="txtEdad">Edad:</label>
        <input type="number" placeholder="agrega el edad" name="txtEdad" id="txtEdad" />
        <br />
        <br />
        <label for="txtCouta">Cuota:</label>
        <input type="number" placeholder="agrega el cuota" name="txtCuota" id="txtCuota" />
        <br />
        <br />
        <label for="optCurso">curso:</label>

        <select>
            <option value="0">Curso</option>
            <?php
            $query = $mysqli->query("SELECT * FROM curso");
            while ($valores = mysqli_fetch_array($query)) {
                echo '<option value="' . $valores['id'] . '">' . $valores['nombre'] . '</option>';
            }
            ?>
        </select>

        <br />
        <br />
        <label for="optPadre">padre/tutor:</label>
        <select>
            <option value="0">padre/tutor:</option>
            <?php
            $query = $mysqli->query("SELECT * FROM padre_clasificacion");
            while ($valores = mysqli_fetch_array($query)) {
                echo '<option value="' . $valores['id'] . '">' . $valores['nombre'] . '</option>';
            }
            ?>
        </select>


        <br />
        <br />
        <label for="optClasificacion">clasificacion:</label>
        <select>
            <option value="0">clasificacion del curso</option>
            <?php
            $query = $mysqli->query("SELECT * FROM curso_clasificacion");
            while ($valores = mysqli_fetch_array($query)) {
                echo '<option value="' . $valores['id'] . '">' . $valores['nombre'] . '</option>';
            }
            ?>
        </select>


        <br />
        <br />
        <input type="submit" value="Enviar" name="btnEnviar" />
    </form>
</body>

</html>