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


// Cuando se elimina un registo de una tabla 
if (!empty($_GET["id_borrado"])) {
    $mysqli = call_mysqli();
    $sql = "DELETE  FROM padre_clasificacion WHERE id = " . $_GET["id_borrado"];
    $resPerfil = $mysqli->query($sql);
}

// Agregar y/o actuaizar registro de la tabla.
if (!empty($_POST)) {

    $idActualizar = $_GET["id"];
    $curso = $_POST["txtPadreClas"];

    if (!empty($curso)) {
        $mysqli = call_mysqli();
        if ($idActualizar > 0) {
            $sql = "UPDATE padre_clasificacion SET nombre = '$curso' WHERE id = '$idActualizar'";
        } else {
            $sql = "INSERT INTO padre_clasificacion (nombre) VALUE('$curso')";
        }
        $resPerfil = $mysqli->query($sql);
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Clasificacion del Padre</title>

    <script type="text/javascript" src="../assets/js/limpiar-inputs.js"></script>

    <script src="../assets/js/jquery-3.6.0.min.js"></script>
</head>

<body>
    <nav>
        <ul>
            <a href="../index.php">Inicio</a>
        </ul>
        <ul>
            <a href="./agregarAlumno.php">Agregar Alumno</a>
        </ul>
        <ul>
            <a href="./agregarCurso.php">Agregar Curso</a>
        </ul>
        <ul>
            <a href="./agregarPadre.php">Agregar Padre o tutor</a>
        </ul>
        <ul>
            <a href="./clasificacionCurso.php">Agregar Clasificacion del curso</a>
        </ul>
        <ul>
            <a href="./clasificacionPadre.php">Agregar Clasificacion del Padre o tutor</a>
        </ul>
    </nav>

    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" name="fileinfo" role="form">

        <h3>Clasificacion del Padre</h3>
        <!-- TODO: DEBES AGREGAR EL INPUT QUE HICE EN PADRE TUTOR Y ARREGLAR LA CONDICION DE UNA SOLA LINEA -->

        <label for="txtCodigo">Código:</label>
        <input type="text" name="txtCodigo" id="txtCodigo" value="<?php echo (isset($_GET['id']) ? $row['id'] : '') ?>" readonly />

        <br />
        <br />

        <label for="txtPadreClas">Nombre:</label>
        <input type="text" name="txtPadreClas" id="txtPadreClas" placeholder="agrega el nombre" value="<?php echo (isset($_GET['id']) ? $row['nombre'] : '') ?>" />

        <br />
        <br />

        <input type="button" onclick="guardar()" class="enviar" id="btnEnviar" name="btnEnviar" value="Guadar" />

        <input type="button" onclick="limpiarFormulaio()" value="Nuevo" />

        <script>
            function guardar() {
                let data = new FormData(document.forms.namedItem("fileinfo"));
                fetch('../assets/function/clasificacion-padre.php', {
                        method: 'POST',
                        body: data
                    })
                    .then(function(response) {
                        if (response.ok) {
                            return response.text();
                        } else {
                            throw "Error en la llamada";
                        }
                    })
                    .then(function(texto) {
                        if (texto == "redirect") {
                            window.location.href = "?p=inicio";
                        } else {
                            document.getElementById("contenido").innerHTML = texto;
                        }
                    })
                    .catch(function(error) {
                        console.log(error);
                    });

                limpiarFormulaio()
            }

            function borrar(codigo) {
                let data = new FormData(document.forms.namedItem("fileinfo"));

                data.append('codigo', codigo);

                fetch('../assets/function/clasificacion-padre-eliminar.php', {
                        method: 'POST',
                        body: data
                    })
                    .then(function(response) {
                        if (response.ok) {
                            return response.text();
                        } else {
                            throw "Error en la llamada";
                        }
                    })
                    .then(function(texto) {
                        if (texto == "redirect") {
                            window.location.href = "?p=inicio";
                        } else {
                            document.getElementById("contenido").innerHTML = texto;
                        }
                    })
                    .catch(function(error) {
                        console.log(error);
                    });

                limpiarFormulaio()
            }
        </script>

        <div id='contenido'>
            <?php
            $sql = "SELECT * FROM padre_clasificacion";
            $result = $mysqli->query($sql) or trigger_error($mysqli->error . " [$sql]");
            $i = 0;
            echo '
      <table>
          <thead>
              <tr>
                  <th>Orden</th>
                  <th>Cursos</th>
                  <th>accion</th>
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
              
                  <a href=clasificaionPadre?id=' . $row['id'] . ' >                    
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

            ?>
        </div>
    </form>


</body>

</html>