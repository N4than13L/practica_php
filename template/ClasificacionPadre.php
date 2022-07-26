<?php
require("../assets/function/conexion.php");
$mysqli = call_mysqli();

if (!empty($_GET["id"])) {

    $mysqli = call_mysqli();
    $sql = "SELECT nombre FROM padre_clasificacion WHERE id = " . $_GET["id"];
    $resPerfil = $mysqli->query($sql);
    $rowPerfil = $resPerfil->fetch_assoc();

    // print_r($rowPerfil);
    $valor = implode(" ", $rowPerfil);
    //var_dump($valor);
}

// Cuando se actualiza un registo de una tabla 
if (isset($_POST["btnActualizar"])) {

    $idActualizar = $_GET["id"];
    $curso = $_POST["txtpadreClas"];

    if (!empty($curso)) {
        $mysqli = call_mysqli();
        $sql = "UPDATE padre_Clasificacion SET nombre = '$curso' WHERE id = '$idActualizar'";
        $resPerfil = $mysqli->query($sql);

        echo $curso;
        header("location: ./ClasificacionPadre.php");
    }
}

// Cuando se elimina un registo de una tabla 
if (!empty($_GET["id_borrado"])) {
    $mysqli = call_mysqli();
    $sql = "DELETE  FROM padre_Clasificacion WHERE id = " . $_GET["id_borrado"];
    $resPerfil = $mysqli->query($sql);
    header("Location: ./ClasificacionPadre.php");
}



if (!empty($_POST["btnEnviar"])) {
    $padreClasificacion = $_POST["txtpadreClas"];
    if (!empty($padreClasificacion)) {
        $sql = "INSERT INTO  padre_Clasificacion (nombre) VALUE('$padreClasificacion')";
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
    <title>Agregar Clasificacion de padre</title>
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
        <h3>Agregar clasificaion padre</h3>
        <label for="txtpadreClas">Nombre:</label>
        <input type="text" placeholder="agrega el nombre" name="txtpadreClas" id="txtpadreClas" value="<?php
                                                                                                        if ($_GET) {
                                                                                                            echo $valor;
                                                                                                        }
                                                                                                        echo "";

                                                                                                        ?>" />
        <br />
        <br />
        <input type="submit" value="btnEnviar" />
        <input type="submit" value="Actualizar" name="btnActualizar" />
    </form>

    <table style="border: 1px;">
        <tr>
            <th>Cusros</th>
        </tr>
        <tr>
            <th>
                <?php
                $query = $mysqli->query("SELECT * FROM padre_clasificacion");
                while ($valores = mysqli_fetch_array($query)) {
                    echo "<br/>" . "<a href='./ClasificacionPadre.php?id=$valores[id]'>" . $valores['nombre'] . "</a>";
                    echo " " . "<a href='./ClasificacionPadre.php?id_borrado=$valores[id]' </a>" . " borrar" . "</a>";
                }
                ?>
            </th>
        </tr>
    </table>
</body>

</html>