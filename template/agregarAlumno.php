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

    if (!empty($curso)) {
        $mysqli = call_mysqli();
        if ($idActualizar > 0) {
            // Actualizamos
            $sql = "UPDATE alumno SET nombre='$nombre', apellido='$apellido', edad='$edad', cuota='$cuota', curso_id='$curso_id', curso_clasificacion_id='$curso_Class' , padre_clasificacion_id='$padre_Clas' WHERE id = '$idActualizar'";
        } else {
            // Insertamos
            $sql = "INSERT INTO alumno (nombre, apellido, edad, cuota, curso_id, curso_clasificacion_id, padre_clasificacion_id) VALUE('$nombre', '$apellido', '$edad', '$cuota','$curso_id', '$curso_Class',  '$padre_Clas')";
        }

        $resPerfil = $mysqli->query($sql);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Alumno</title>

    <script src="../assets/js/limpiar-inputs.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <script src="../assets/js/jquery-3.6.0.min.js"></script>
</head>

<body>

    <nav>
        <ul><a href="../index.php">Inicio</a></ul>
        <ul><a href="./agregarAlumno.php">Agregar Alumno</a></ul>
        <ul><a href="./agregarCurso.php">Agregar Curso</a></ul>
        <ul><a href="./agregarPadre.php">Agregar Padre o tutor</a></ul>
        <ul><a href="./clasificacionCurso.php">Agregar Clasificacion del curso</a></ul>
        <ul><a href="./clasificacionPadre.php">Agregar Clasificacion del Padre o tutor</a></ul>
    </nav>

    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" name="fileinfo">
        <h3>Agregar Alumno</h3>
        <!-- TODO: DEBES AGREGAR EL INPUT QUE HICE EN PADRE TUTOR Y ARREGLAR LA CONDICION DE UNA SOLA LINEA -->

        <label for="txtCodigo">Código:</label>
        <input type="text" name="txtCodigo" id="txtCodigo" value="<?php echo (isset($_GET['id']) ? $row['id'] : '') ?>" readonly />
        <br />
        <br />

        <label for="txtNombre">Nombre:</label>
        <input type="text" placeholder="agrega el nombre" value="<?php echo (isset($_GET['id']) ? $row['nombre'] : '') ?>" name="txtNombre" id="txtNombre" />
        <br />
        <br />
        <label for="txtApellido">Apellido:</label>
        <input type="text" placeholder="agrega el apellido" value="<?php echo (isset($_GET['id']) ? $row['apellido'] : '') ?>" name="txtApellido" id="txtApellido" />
        <br />
        <br />
        <label for="txtEdad">Edad:</label>
        <input type="number" placeholder="agrega el edad" value="<?php echo (isset($_GET['id']) ? $row['edad'] : '') ?>" name="txtEdad" id="txtEdad" />
        <br />
        <br />
        <label for="txtCouta">Cuota:</label>
        <input type="number" placeholder="agrega el cuota" value="<?php echo (isset($_GET['id']) ? $row['cuota'] : '') ?>" name="txtCuota" id="txtCuota" />
        <br />
        <br />
        <label for="cboCurso">curso:</label>

        <select name="cboCurso">
            <option value="0">Curso</option>
            <?php
            $query = $mysqli->query("SELECT * FROM curso");
            while ($valores = mysqli_fetch_array($query)) {
                if (isset($_GET["id"])) {
                    if ($row["curso_id"] == $valores["id"]) {
                        echo '<option  value="' . $valores["id"] . '" selected>' . $valores["nombre"] . '</option>';
                    } else {
                        echo '<option value="' . $valores["id"] . '">' . $valores["nombre"] . '</option>';
                    }
                } else {
                    echo '<option value="' . $valores["id"] . '">' . $valores["nombre"] . '</option>';
                }
            }

            ?>
        </select>

        <br />
        <br />
        <label for="optClasificacion">clasificacion:</label>
        <select name="cboCursoClass">
            <option value="0">clasificacion del curso</option>
            <?php
            $query = $mysqli->query("SELECT * FROM curso_clasificacion");
            while ($valores = mysqli_fetch_array($query)) {
                if (isset($_GET["id"])) {
                    if ($row["curso_clasificacion_id"] == $valores["id"]) {
                        echo '<option  value="' . $valores["id"] . '" selected>' . $valores["nombre"] . '</option>';
                    } else {
                        echo '<option value="' . $valores["id"] . '">' . $valores["nombre"] . '</option>';
                    }
                } else {
                    echo '<option value="' . $valores["id"] . '">' . $valores["nombre"] . '</option>';
                }
            }
            ?>
        </select>


        <br />
        <br />
        <label for="cboPadre">padre/tutor:</label>
        <select name="cboPadre">
            <option value="0">padre/tutor:</option>
            <?php
            $query = $mysqli->query("SELECT * FROM padre_clasificacion");
            while ($valores = mysqli_fetch_array($query)) {
                if (isset($_GET["id"])) {
                    if ($row["padre_clasificacion_id"] == $valores["id"]) {
                        echo '<option  value="' . $valores["id"] . '" selected>' . $valores["nombre"] . '</option>';
                    } else {
                        echo '<option value="' . $valores["id"] . '">' . $valores["nombre"] . '</option>';
                    }
                } else {
                    echo '<option value="' . $valores["id"] . '">' . $valores["nombre"] . '</option>';
                }
            }
            ?>
        </select>

        <br />
        <br />
        <input type="button" name="btnEnviar" onclick="guardar()" id="btnEnviar" value="Guardar" />


        <input type="button" onclick="limpiarFormulaio()" value="Nuevo">

        <script>
            function guardar() {
                let data = new FormData(document.forms.namedItem("fileinfo"));
                fetch('../assets/function/agregar-alumno.php', {
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
                fetch('../assets/function/agregar-alumno-eliminar.php', {
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


        <div id="contenido">
            <?php
            $sql = "SELECT * FROM alumno";
            $result = $mysqli->query($sql) or trigger_error($mysqli->error . " [$sql]");
            $i = 0;
            echo '
                <table>
                    <thead>
                        <tr>
                            <th>Orden</th>
                            <th>Nombre</th>
                            <th>apllido</th>
                            <th>edad</th>
                            <th>cuota</th>
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
            
                    <a href=agregarAlumno?id=' . $row['id'] . ' >                    
                    ' . $row["nombre"] . ' 
                    </a>
            
                    </td>

                    <td>
            
                    <a href=agregarAlumno?id=' . $row['id'] . ' >                    
                    ' . $row["apellido"] . ' 
                    </a>
        
                        </td>

                    <td>
                
                    <a href=agregarAlumno?id=' . $row['id'] . ' >                    
                    ' . $row["edad"] . ' 
                    </a>

                    </td>

                    <td>
                
                        <a href=agregarAlumno?id=' . $row['id'] . ' >                    
                        ' . $row["cuota"] . ' 
                        </a>

                    </td>


                    <td>
            
                    <input type="button" onclick="borrar(' . $row["id"] . ')" value="Quitar" />
            
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