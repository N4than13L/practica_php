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

    $curso_id = $_POST["cboCurso"];
    $padre_Clas = $_POST["cboPadre"];
    $curso_Class = $_POST["cboCursoClass"];


    if (!empty($nombre && !empty($apellido) && !empty($edad) && !empty($cuota) && !empty($curso_id) && !empty($padre_Clas) && !empty($curso_Class))) {
        $mysqli = call_mysqli();
        if ($idActualizar > 0) {
            $sql = "UPDATE alumno SET nombre='$nombre', apellido='$apellido', edad='$edad', cuota='$cuota', curso_id='$curso_id', curso_clasificacion_id='$curso_Class' , padre_clasificacion_id='$padre_Clas' WHERE id = '$idActualizar'";
        } else {
            $sql = "INSERT INTO alumno (nombre, apellido, edad, cuota, curso_id, curso_clasificacion_id, padre_clasificacion_id) VALUE('$nombre', '$apellido', '$edad', '$cuota','$curso_id', '$curso_Class',  '$padre_Clas')";
        }

        $resPerfil = $mysqli->query($sql);

        //  header("location: ./agregarAumno.php");
    }
}

// Cuando se elimina un registo de una tabla 
if (!empty($_GET["id_borrado"])) {
    $mysqli = call_mysqli();
    $sql = "DELETE  FROM alumno WHERE id = " . $_GET["id_borrado"];
    $resPerfil = $mysqli->query($sql);
    //header("location: ./agregarAumno.php");
}
