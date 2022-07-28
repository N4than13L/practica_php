<?php
require("../assets/function/conexion.php");
$mysqli = call_mysqli();

// DECLADO UNA VARIABLE PARA ALMACENAR EL ID
$codigo = 0;
// PREGUNTO SI ME ESTAN ENVIANDO EL ID POR EL METODO GET
// EN CASO DE SER ASI ENTONCES SIGNIFICA QUE 
// ESTAN SELECCIONANDO UN REGISTRO - (PADRE TUTOR EN ESTE CASO)
if (isset($_GET['id'])) {
    // AQUI EXTRAIGO LA VARIABLE DE LA URL
    // AL FINAL LE ASIGNO + 0 POR SEGURIDAD EN CASO DE QUE ESTEN ENVIANDO
    // UN CARACTER Y NO UN VALOR NUMERICO COMO DEBERIA SER
    $codigo = $_GET['id'] + 0;
    // PROCEDO A BUSCAR EL CODIGO QUE ME EVIARON, EN LA BASE DE DATOS
    $sql = "SELECT * FROM alumno WHERE id='$codigo'";
    // EJECUTO EL SQL Y LO ASIGNO A UNA VARIABLE RESULTADO
    $result = $mysqli->query($sql) or trigger_error($mysqli->error . " [$sql]");
    // YA QUE TENGO TODA LA INFORMACION DEL SELECT EN LA VARIBLE RESULTADO LO BUSCO
    // Y SELECCIONO LA PRIMERA FILA CON LA FUNCION RESULT Y CON LA SUB-FUNCTION fetch_assoc
    // SELECCIONO LA PRIMERA FILA DEL SELECT
    // EN ROW YA TENGO EL ARRAY DE DATOS
    $row = $result->fetch_assoc();
}

// Agregar y/o actuaizar registro de la tabla.
if (!empty($_POST)) {

    $idActualizar = $_GET["id"];

    $nombre = $_POST["txtNombre"];
    $apellido = $_POST["txtApellido"];
    $edad = $_POST["txtEdad"];
    $cuota = $_POST["txtCuota"];

    if (!empty($nombre && !empty($apellido) && !empty($edad) && !empty($cuota))) {
        $mysqli = call_mysqli();
        if ($idActualizar > 0) {
            $sql = "UPDATE alumno SET nombre='$nombre', apellido='$apellido', edad='$edad', cuota='$cuota' WHERE id = '$idActualizar'";
        } else {
            $sql = "INSERT INTO alumno (nombre, apellido, edad, cuota) VALUE('$nombre', '$apellido', '$edad', '$cuota')";
        }
        $resPerfil = $mysqli->query($sql);

        header("location: ./agregarAumno.php");
    }
}

// Cuando se elimina un registo de una tabla 
if (!empty($_GET["id_borrado"])) {
    $mysqli = call_mysqli();
    $sql = "DELETE  FROM alumno WHERE id = " . $_GET["id_borrado"];
    $resPerfil = $mysqli->query($sql);
    header("location: ./agregarAumno.php");
}


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

        <label for="txtPAdre">Código:</label>
        <input type="text" name="txtCodigo" id="txtCodigo" value="<?php echo (isset($_GET['id']) ? $row['id'] : '') ?>" readonly />
        <br />
        <br />

        <label for="txtNombre">Nombre:</label>
        <input type="text" placeholder="agrega el nombre" value="<?php echo (isset($_GET['id']) ? $row['nombre'] : '') ?>" name="txtNombre" id="txtNombre" />
        <br />
        <br />
        <label for="txtApellido">Apellido:</label>
        <input type="text" placeholder="agrega el apellido" value="<?php echo (isset($_GET['id']) ? $row['apellido'] : '') ?>" name="txtApellido" id="txtApellido" />
        <br />
        <br />
        <label for="txtEdad">Edad:</label>
        <input type="number" placeholder="agrega el edad" value="<?php echo (isset($_GET['id']) ? $row['edad'] : '') ?>" name="txtEdad" id="txtEdad" />
        <br />
        <br />
        <label for="txtCouta">Cuota:</label>
        <input type="number" placeholder="agrega el cuota" value="<?php echo (isset($_GET['id']) ? $row['cuota'] : '') ?>" name="txtCuota" id="txtCuota" />
        <br />
        <br />
        <label for="optCurso">curso:</label>

        <select>
            <option value="0">Curso</option>
            <?php
            $query = $mysqli->query("SELECT * FROM curso");
            while ($valores = mysqli_fetch_array($query)) {
                echo '<option value="' . $valores['id'] . '">' . $valores['nombre'] .
                    '</option>';
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
                echo '<option value="' . $valores['id'] . '">' . $valores['nombre'] .
                    '</option>';
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

        <button onclick="window.location.href='agregarAumno.php'" type="button" name="nuevo">Nuevo</button>
    </form>


    <table style="border: 1px;">
        <tr>
            <th>Alumnos</th>
        </tr>
        <tr>
            <th>
                <?php
                $query = $mysqli->query("SELECT * FROM alumno");
                while ($valores = mysqli_fetch_array($query)) {
                    echo "<br/>" . "<a href='./agregarAumno.php?id=$valores[id]'>" . " " . $valores['nombre'] . " " . $valores["apellido"] . " " . $valores["edad"] . " años " . $valores["cuota"] . " DOP pesos " . "</a>";
                    echo " " . "<a href='././agregarAumno.php?id_borrado=$valores[id]' </a>" . " borrar" . "</a>";
                }
                ?>
            </th>
        </tr>
    </table>
</body>

</html>