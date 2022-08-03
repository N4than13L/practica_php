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
    $sql = "SELECT * FROM curso WHERE id='$codigo'";
    // EJECUTO EL SQL Y LO ASIGNO A UNA VARIABLE RESULTADO
    $result = $mysqli->query($sql) or trigger_error($mysqli->error . " [$sql]");
    // YA QUE TENGO TODA LA INFORMACION DEL SELECT EN LA VARIBLE RESULTADO LO BUSCO
    // Y SELECCIONO LA PRIMERA FILA CON LA FUNCION RESULT Y CON LA SUB-FUNCTION fetch_assoc
    // SELECCIONO LA PRIMERA FILA DEL SELECT
    // EN ROW YA TENGO EL ARRAY DE DATOS
    $row = $result->fetch_assoc();
}


// Cuando se elimina un registo de una tabla 
if (!empty($_GET["id_borrado"])) {
    $mysqli = call_mysqli();
    $sql = "DELETE  FROM curso WHERE id = " . $_GET["id_borrado"];
    $resPerfil = $mysqli->query($sql);
    //header("location: ./agregarCurso.php");
}

// Agregar y/o actuaizar registro de la tabla.
if (!empty($_POST)) {

    $idActualizar = $_GET["id"];
    $curso = $_POST["txtCurso"];

    if (!empty($curso)) {
        $mysqli = call_mysqli();
        if ($idActualizar > 0) {
            $sql = "UPDATE curso SET nombre = '$curso' WHERE id = '$idActualizar'";
        } else {
            $sql = "INSERT INTO curso (nombre) VALUE('$curso')";
        }
        $resPerfil = $mysqli->query($sql);
        //header("location: ./agregarCurso.php");
    }
}

//echo "Estás usando Ajax <br> " . $_POST["txtCurso"];
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agrega Curso</title>

    <script src="../assets/js/peticion1.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" id="frmCurso">
        <h3>Agregar Curso</h3>
        <!-- TODO: DEBES AGREGAR EL INPUT QUE HICE EN PADRE TUTOR Y ARREGLAR LA CONDICION DE UNA SOLA LINEA -->

        <label for="txtPAdre">Código:</label>
        <input type="text" name="txtCodigo" id="txtCodigo" value="<?php echo (isset($_GET['id']) ? $row['id'] : '') ?>" readonly />
        <br />
        <br />

        <label for="txtCurso">Nombre:</label>
        <input type="text" name="txtCurso" value="<?php echo (isset($_GET['id']) ? $row['nombre'] : '') ?>" id="TxtCurso" placeholder="agrega el nombre" />
        <br />
        <br />

        <input type="button" href="javascript:;" value="Guardar" onclick="Hola($('#TxtCurso').val())" class="enviar" name="btnEnviar" />

        <input type="button" onclick="resetform()" value="Nuevo">
    </form>

    <table id="resultado" style="border: 1px;">
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
                }

                ?>

            </th>
        </tr>
    </table>
    <script>
        function resetform() {
            $("#frmAlumno select").each(function() {
                this.selectedIndex = 0
            });
            $("form input[type=text]").each(function() {
                this.value = ''
            });
            $("#frmAlumno input[type=number]").each(function() {
                this.value = ''
            });

            var url = window.location.toString();
            if (url.indexOf("?") > 0) {
                var clean_uri = url.substring(0, url.indexOf("?"));
                window.history.replaceState({}, document.title, clean_uri);
            }
        }
    </script>


</body>

</html>