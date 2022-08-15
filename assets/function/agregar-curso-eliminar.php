<?php
require("./conexion.php");
$mysqli = call_mysqli();
if (!empty($_POST)) {
}

$idActualizar = $_POST["codigo"];

if ($idActualizar > 0) {
    $sql = "DELETE FROM curso WHERE id = '$idActualizar'";
    $mysqli->query($sql) or trigger_error($mysqli->error . " [$sql]");
}


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

            <input type="button" onclick="borrar(' . $row['id'] . ')" value="Quitar" />

        </td>
    </tr>';
}

echo '</tbody>
</table>';
