<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Alumno</title>

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

    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" id="frmAlumno">
        <h3>Agregar Alumno</h3>
        <!-- TODO: DEBES AGREGAR EL INPUT QUE HICE EN PADRE TUTOR Y ARREGLAR LA CONDICION DE UNA SOLA LINEA -->

        <label for="txtPAdre">Código:</label>
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
        <button type="submit" name="btnEnviar" id="btnEnviar">Guardar</button>


        <input type="button" onclick="resetform()" value="Nuevo">
    </form>

    <br />

    <table border="1">
        <tr>
            <!--- Ordenar columnas Principales --->
            <th> Nombre</th>
            <th> Apellido</th>
            <th> Edad </th>
            <th> Cuota </th>
            <th> Eliminar alumno</th>

        </tr>
        <tr>
            <!--- Sacar Nombre en su fila correspondiente --->
            <td>
                <?php
                $query = $mysqli->query("SELECT * FROM alumno");
                while ($valores = mysqli_fetch_array($query)) {
                    echo "<br/>" . "<a href='./agregarAumno.php?id=$valores[id]'>" . " " . $valores['nombre']  . "</a>";
                }
                ?>
                <div id="contenido"></div>
            </td>

            <!--- Sacar Apellido en su fila correspondiente --->
            <td>
                <?php
                $query = $mysqli->query("SELECT * FROM alumno");
                while ($valores = mysqli_fetch_array($query)) {
                    echo "<br/>" . "<a href='./agregarAumno.php?id=$valores[id]'>" . " " . $valores["apellido"] . "</a>";
                }
                ?>
            </td>

            <!--- Sacar Edad en su fila correspondiente --->
            <td>
                <?php
                $query = $mysqli->query("SELECT * FROM alumno");
                while ($valores = mysqli_fetch_assoc($query)) {
                    echo "<br/>" . "<a href='./agregarAumno.php?id=$valores[id]'>" . " " . $valores["edad"] . " años" . "</a>";
                }
                ?>
            </td>

            <!--- Sacar Cuota en su fila correspondiente --->
            <td>
                <?php
                $query = $mysqli->query("SELECT * FROM alumno");
                while ($valores = mysqli_fetch_array($query)) {
                    echo "<br/>" . "<a href='./agregarAumno.php?id=$valores[id]'>" . "  " . $valores["cuota"] . "</a>";
                }
                ?>
            </td>

            <!--- Sacar Accion de borrar --->
            <td>
                <?php
                $query = $mysqli->query("SELECT * FROM alumno");
                while ($valores = mysqli_fetch_array($query)) {
                    echo  "<br/> " . "<a href='././agregarAumno.php?id_borrado=$valores[id]' </a>" . " borrar" . "</a>";
                }
                ?>

            </td>
        </tr>
    </table>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#btnEnviar').click(function() {
                var datos = $('#frmAlumno').serialize()

                $.ajax({
                    type: "POST",
                    url: "agregarAumno.php",
                    data: datos,
                    sucess: function(r) {
                        if (r == 1) {
                            alert("agregado con exito")
                        } else {
                            alert("upps algo anda mal")
                        }
                    }
                })

                var nombreAlumno = $('#txtNombre')
                var apllidoAlumno = $('#txtApellido')
                //var edadAlumno = $('#txtEdad')

                $('#contenido').append("<a href='agregarAumno.php?'>" + nombreAlumno.val() + "</a>" + "<br/>")

                //alert("alumno agregado con exito " + nombreAlumno.val() + " " + apllidoAlumno.val())
                resetform()

                return false

            })
        })
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

</body>

</html>