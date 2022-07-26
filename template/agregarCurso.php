<?php
require("../assets/function/conexion.php");
$mysqli = call_mysqli();


// Hacer la peticion de los registos.
if (!empty($_GET["id"])) {

    $mysqli = call_mysqli();
    $sql = "SELECT nombre FROM curso WHERE id = " . $_GET["id"];
    $resPerfil = $mysqli->query($sql);
    $rowPerfil = $resPerfil->fetch_assoc();
    //$valor = implode(" ", $rowPerfil);
}

// Cuando se elimina un registo de una tabla 
if (!empty($_GET["id_borrado"])) {
    $mysqli = call_mysqli();
    $sql = "DELETE  FROM curso WHERE id = " . $_GET["id_borrado"];
    $resPerfil = $mysqli->query($sql);
    header("location: ./agregarCurso.php");
}

// Cuando se actualiza un registo de una tabla 
if (isset($_POST["btnActualizar"])) {

    $idActualizar = $_GET["id"];
    $curso = $_POST["txtCurso"];

    if (!empty($curso)) {
        $mysqli = call_mysqli();
        $sql = "UPDATE curso SET nombre = '$curso' WHERE id = '$idActualizar'";
        $resPerfil = $mysqli->query($sql);

        echo $curso;
        header("location: ./agregarCurso.php");
    }
}

// Enviar los registos a la tabla .
if (!empty($_POST["btnEnviar"])) {
    //echo $_POST["txtCurso"];

    $curso = $_POST["txtCurso"];
    if (!empty($curso)) {
        $sql = "INSERT INTO curso (nombre) VALUE('$curso')";
        $result = $mysqli->query($sql);
        //or trigger_error($mysqli->error . " [$sql]");
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agrega Curso</title>
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

    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
        <h3>Agregar Curso</h3>
        <!-- TODO: DEBES AGREGAR EL INPUT QUE HICE EN PADRE TUTOR Y ARREGLAR LA CONDICION DE UNA SOLA LINEA -->

        <label for="txtPAdre">Código:</label>
        <input type="text" name="txtCodigo" id="txtCodigo" value="<?php echo (isset($_GET['codigo']) ? $row['id'] : '') ?>" readonly />
        <br />
        <br />

        <label for="txtCurso">Nombre:</label>
        <input type="text" name="txtCurso" value="<?php ?>" id="txtCurso" placeholder="agrega el nombre" />
        <br />
        <br />
        <input type="submit" value="Enviar" name="btnEnviar" />
        <input type="submit" value="Actualizar" name="btnActualizar" />

    </form>

    <br />


    <!-- <form action="" method="POST"> -->
    <table style="border: 1px;">
        <tr>
            <th>Cursos</th>
        </tr>
        <tr>
            <th>
                <?php
                $query = $mysqli->query("SELECT * FROM curso");
                while ($valores = mysqli_fetch_assoc($query)) {
                    echo "<br/>" . "<a href='./agregarCurso.php?id=$valores[id]'>" . $valores['nombre'] . "</a>";
                    echo " " . "<a  href='./agregarCurso.php?id_borrado=$valores[id]' </a>" . " borrar" . "</a>";
                    //echo " " . "<a  href='./agregarCurso.php?id=$valores[id]' </a>" . " actualizar" . "</a>";
                }

                ?>

            </th>
        </tr>
    </table>
    <!-- </form> -->

</body>

</html>