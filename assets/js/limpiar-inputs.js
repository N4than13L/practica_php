function limpiarFormulaio() {
  $("form select").each(function () {
    this.selectedIndex = 0;
  });

  $("form input[type=text]").each(function () {
    this.value = "";
  });

  $("form input[type=number]").each(function () {
    this.value = "";
  });

  var url = window.location.toString();
  if (url.indexOf("?") > 0) {
    var clean_url = url.substring(0, url.indexOf("?"));
    window.history.replaceState({}, document.title, clean_url);
  }
}
