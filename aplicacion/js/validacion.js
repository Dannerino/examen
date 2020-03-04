var READY_STATE_COMPLETE = 4;
var STATUS_RIGTH = 200;
var http_request = null;
function validarTipo() {
    var valor = document.getElementById("idTipo").value;
    var $regExp = /^[1-3]{1}+$/;
    if (!$regExp.test(valor)) {
        document.getElementById('idTipo').focus();
        document.getElementById('idTipoSpan').innerHTML = "Introduzca un idTipo correcto: 1: Cultural | 2: Deportivo | 3: Trurístico";
        document.getElementById('insercion').disabled = true;
        return;
    } else
        document.getElementById('idTipoSpan').innerHTML = "";
    comprobar();
}
function comprobar() {
    http_request = new XMLHttpRequest();
    http_request.onload = success;
    http_request.open('POST', 'Requests/compruebaTipo.php', true);
    http_request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    http_request.send('idTipo=' + encodeURIComponent(idTipo.value) + '&nocache=' + Math.random());
}
function success() {
    if (http_request.readyState == READY_STATE_COMPLETE) {
        if (http_request.status == STATUS_RIGTH) {
            if (http_request.responseText.trim() == 'no') {
                document.getElementById('idTipo').focus();
                document.getElementById('idTipoSpan').innerHTML = "El idTipo no existe";
                document.getElementById('insercion').disabled = true;
            } else {
                document.getElementById('idTipoSpan').innerHTML = "";
                document.getElementById('insercion').disabled = false;
            }
        }
    }
}