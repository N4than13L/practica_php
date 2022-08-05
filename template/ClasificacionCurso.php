<?php
require("../assets/function/conexion.php");
$mysqli = call_mysqli();

// DECLADO UNA VARIABLE PARA ALMACENAR EL ID
$codigo = 0;
// PREGUNTO SI ME ESTAN ENVIANDO EL ID POR EL METODO GET
// EN CASO DE SER ASI ENTONCES SIGNIFICA QUE 
// ESTAN SELECCIONANDO UN REGISTRO - (CLASIFICACION DEL CURSO EN ESTE CASO)
if (isset($_GET['id'])) {
    // AQUI EXTRAIGO LA VARIABLE DE LA URL
    // AL FINAL LE ASIGNO + 0 POR SEGURIDAD EN CASO DE QUE ESTEN ENVIANDO
    // UN CARACTER Y NO UN VALOR NUMERICO COMO DEBERIA SER
    $codigo = $_GET['id'] + 0;
    // PROCEDO A BUSCAR EL CODIGO QUE ME EVIARON, EN LA BASE DE DATOS
    $sql = "SELECT * FROM curso_clasificacion WHERE id='$codigo'";
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
    $sql = "DELETE  FROM curso_clasificacion WHERE id = " . $_GET["id_borrado"];
    $resPerfil = $mysqli->query($sql);
    //header("location: ./ClasificacionCurso.php");
}


// Agregar y/o actuaizar registro de la tabla. 
if (!empty($_POST)) {
    $idActualizar = $_GET["id"];
    $curso = $_POST["txtCursoClas"];

    if (!empty($curso)) {
        $mysqli = call_mysqli();
        if ($idActualizar > 0) {
            $sql = "UPDATE curso_clasificacion SET nombre = '$curso' WHERE id = '$idActualizar'";
        } else {
            $sql = "INSERT INTO curso_clasificacion (nombre) VALUE('$curso')";
        }
        $resPerfil = $mysqli->query($sql);


        //header("location: ./ClasificacionCurso.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Clasificacion de curso</title>
    <script src="../assets/js/peticion.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <script src="../assets/js/jquery-3.6.0.min.js"></script>
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

    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" id="frmClasCurso">
        <h3>Agregar clasificacion de curso</h3>

        <label for="txtCursoClas">Código</label>
        <input type="text" name="txtCodigo" id="txtCodigo" value="<?php echo (isset($_GET['id']) ? $row['id'] : '') ?>" readonly />
        <br />
        <br />

        <label for="txtCursoClas">Nombre:</label>
        <input type="text" placeholder="agrega el nombre" value="<?php echo (isset($_GET['id']) ? $row['nombre'] : '') ?>" name="txtCursoClas" id="txtCursoClas" />
        <br />
        <br />

        <input type="submit" value="Guardar" name="btnEnviar" id="btnEnviar" />

        <input type="button" onclick="resetform()" value="Nuevo">
    </form>

    <table style="border: 1px;">
        <tr>
            <th>Cusros</th>
        </tr>
        <tr>
            <th>
                <?php
                $query = $mysqli->query("SELECT * FROM curso_clasificacion");
                while ($valores = mysqli_fetch_array($query)) {
                    echo "<br/>" . "<a href='./ClasificacionCurso.php?id=$valores[id]'>" . $valores['nombre'] . "</a>";
                    echo " " . "<a href='./ClasificacionCurso.php?id_borrado=$valores[id]' </a>" . " borrar" . "</a>";
                }
                ?>
                <div id="contenido"></div>
            </th>
        </tr>
    </table>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#btnEnviar').click(function() {
                var datos = $('#frmClasCurso').serialize()

                $.ajax({
                    type: "POST",
                    url: "ClasificacionCurso.php",
                    data: datos,
                    sucess: function(r) {
                        if (r == 1) {
                            alert("agregado con exito")
                        } else {
                            alert("upps algo anda mal")
                        }
                    }
                })

                var CursoClasificacion = $('#txtCursoClas')
                $('#contenido').append("<a href='ClasificacionCurso.php?'>" + CursoClasificacion.val() + "</a>" + "<br/>")

                alert("padre agregado con exito " +
                    CursoClasificacion.val())

                resetform()

                return false

            })
        })
    </script>
</body>

</html>