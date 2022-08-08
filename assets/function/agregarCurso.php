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
    }
}

echo "<table>
<tr>
    <th>Cursos</th>
</tr>
<tr>
    <th>
        <?php
        $query = $mysqli->query('SELECT * FROM curso');
        while ($valores = mysqli_fetch_assoc($query)) {
            echo '<br/>' . '<a href='./agregarCurso.php?id=$valores[id]'>' . $valores[nombre] . '</a>';
            echo  '<a id='borrarCurso'  'href='./agregarCurso.php?id_borrado=$valores[id]' '</a>' . ' borrar' . '</a>';
        }
        ?>
        <div id='contenido'></div>

    </th>
</tr>
</table>";
