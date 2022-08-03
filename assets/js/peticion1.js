function Hola(curso) {
    var parametros = {
        "curso": curso
    };
    $.ajax({
        data: parametros,
        url: 'http://localhost/db_escuela/template/agregarCurso.php',
        type: 'post',
        beforeSend: function() {
            $("#resultado").html("Procesando, espere por favor");
        },
        success: function(response) {
            $("#resultado").html(response);
        }
    });
}
