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
    $sql = "SELECT * FROM padre_clasificacion WHERE id='$codigo'";
    // EJECUTO EL SQL Y LO ASIGNO A UNA VARIABLE RESULTADO
    $result = $mysqli->query($sql) or trigger_error($mysqli->error . " [$sql]");
    // YA QUE TENGO TODA LA INFORMACION DEL SELECT EN LA VARIBLE RESULTADO LO BUSCO
    // Y SELECCIONO LA PRIMERA FILA CON LA FUNCION RESULT Y CON LA SUB-FUNCTION fetch_assoc
    // SELECCIONO LA PRIMERA FILA DEL SELECT
    // EN ROW YA TENGO EL ARRAY DE DATOS
    $row = $result->fetch_assoc();
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


// Agregar y/o actuaizar registro de la tabla.
if (!empty($_POST)) {

    $idActualizar = $_GET["id"];
    $curso = $_POST["txtpadreClas"];

    if (!empty($curso)) {
        $mysqli = call_mysqli();
        if ($idActualizar > 0) {
            $sql = "UPDATE padre_Clasificacion SET nombre = '$curso' WHERE id = '$idActualizar'";
        } else {
            $sql = "INSERT INTO padre_Clasificacion (nombre) VALUE('$curso')";
        }
        $resPerfil = $mysqli->query($sql);

        echo $curso;
        header("location: ./ClasificacionPadre.php");
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

        <label for="txtCursoClas">Código</label>
        <input type="text" name="txtCodigo" id="txtCodigo" value="<?php echo (isset($_GET['id']) ? $row['id'] : '') ?>" readonly />
        <br />
        <br />

        <label for="txtpadreClas">Nombre:</label>
        <input type="text" placeholder="agrega el nombre" name="txtpadreClas" id="txtpadreClas" value="<?php echo (isset($_GET['id']) ? $row['nombre'] : '') ?>" />
        <br />
        <br />
        <input type="submit" value="Guardar" name="btnEnviar" />

        <button onclick="window.location.href='ClasificacionPadre.php'" type="button" name="nuevo">Nuevo</button>

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