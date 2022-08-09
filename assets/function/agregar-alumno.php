<?php
require("./conexion.php");
$mysqli = call_mysqli();
if (!empty($_POST)) {
}

$idActualizar = $_POST["txtCodigo"];
$nombre = $_POST["txtNombre"];
$apellido = $_POST["txtApellido"];
$edad = $_POST["txtEdad"];
$cuota = $_POST["txtCuota"];

$curso_id = $_POST["cboCurso"];
$padre_Clas = $_POST["cboPadre"];
$curso_Class = $_POST["cboCursoClass"];

if ($idActualizar > 0) {
    // Actualizamos
    $sql = "UPDATE alumno SET nombre='$nombre', apellido='$apellido', edad='$edad', cuota='$cuota', curso_id='$curso_id', curso_clasificacion_id='$curso_Class' , padre_clasificacion_id='$padre_Clas' WHERE id = '$idActualizar'";
} else {
    // Insertamos
    $sql = "INSERT INTO alumno (nombre, apellido, edad, cuota, curso_id, curso_clasificacion_id, padre_clasificacion_id) VALUE('$nombre', '$apellido', '$edad', '$cuota','$curso_id', '$curso_Class',  '$padre_Clas')";
}
$mysqli->query($sql) or trigger_error($mysqli->error . " [$sql]");

$sql = "SELECT * FROM alumno";
$result = $mysqli->query($sql) or trigger_error($mysqli->error . " [$sql]");
$i = 0;
echo '
<table>
    <thead>
        <tr>
            <th>Orden</th>
            <th>Cursos</th>
            <th> </th>
        </tr>
    </thead>
    <tbody>';
while ($row = $result->fetch_assoc()) {
    $i++;
    echo '
    <tr>
        <td>

            ' . $i . '

        </td>
        <td>

        <a href=agregarAlumno?id=' . $row['id'] . ' >                    
        ' . $row["nombre"] . ' 
         </a>

        </td>
        <td>

            <input type="button" onclick="resetform()" value="Quitar" />

        </td>
    </tr>';
}

echo '</tbody>
</table>';
