$(document).ready(function() {
    $('#btnEnviar').click(function() {
        var datos = $('#frmCurso').serialize()
        var curso = $('#txtCurso')

        $.ajax({
            type: "POST",
            url: "../assets/function/agregarCurso.php",
            data: datos,
            sucess: function(r) {
                alert("agregado con exito", r)
            }
        })

        $('#contenido').append("<a>" + curso.val() + "</a herf='agregarCurso.php?'>" + "<br/>")

        resetform()
        return false

        // Hace peticion pero con otros controladores.

    })

})

function resetform() {
    $("form select").each(function() {
        this.selectedIndex = 0
    })

    $("form input[type=text]").each(function() {
        this.value = ''
    })

    $("form input[type=number]").each(function() {
        this.value = ''
    })

    var url = window.location.toString();
    if (url.indexOf("?") > 0) {
        var clean_uri = url.substring(0, url.indexOf("?"));
        window.history.replaceState({}, document.title, clean_uri);
    }

}



