<?php
require("./conexion.php");
$mysqli = call_mysqli();
if (!empty($_POST)) {
}

$idActualizar = $_POST["txtCodigo"];
$curso = $_POST["txtCurso"];

if ($idActualizar > 0) {
    $sql = "UPDATE curso SET nombre = '$curso' WHERE id = '$idActualizar'";
} else {
    $sql = "INSERT INTO curso (nombre) VALUE('$curso')";
}
$mysqli->query($sql) or trigger_error($mysqli->error . " [$sql]");

$sql = "SELECT * FROM curso";
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

        <a href=agregarCurso?id=' . $row['id'] . ' >                    
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
