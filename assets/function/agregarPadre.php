<?php
require("./conexion.php");
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
    $sql = "SELECT * FROM padre_tutor WHERE id='$codigo'";
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
    $padreTutor = $_POST["txtPadre"];

    if (!empty($padreTutor)) {
        $mysqli = call_mysqli();
        if ($idActualizar > 0) {
            $sql = "UPDATE padre_tutor SET nombre = '$padreTutor' WHERE id = '$idActualizar'";
        } else {
            $sql = "INSERT INTO padre_tutor (nombre,padre_clasificacion_id) 
        VALUES ('$padreTutor','0')";
        }

        $resPerfil = $mysqli->query($sql);

        header("location: ./AgregarPadre.php");
    }
}


// elimina de un registo.
if (isset($_GET['id_borrado'])) {
    $mysqli = call_mysqli();
    $sql = "DELETE  FROM padre_tutor WHERE id = " . $_GET["id_borrado"];
    $resPerfil = $mysqli->query($sql);
    header("Location: ./AgregarPadre.php");
}


echo "<table style='border: 1px;'>
<tr>
    <th>Cursos</th>
</tr>
<tr>
    <th>
        <?php
        $query = $mysqli->query(SELECT * FROM padre_tutor);
        while ($valores = mysqli_fetch_assoc($query)) {
            echo '<br/>' . '<a href='./AgregarPadre.php?id=$valores[id]'>' . $valores[nombre] . '</a>';

            echo '<a  href='./AgregarPadre.php?id_borrado=$valores[id]' </a>' . 'borrar' . '</a>';
        }

        ?>
        <div id='contenido'></div>

    </th>
</tr>
</table>";
