function soloLetras(e) {
	key = e.keyCode || e.which;
	tecla = String.fromCharCode(key).toString();
	letras = " áéíóúabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
	especiales = [8, 37, 39, 46, 6];
	tecla_especial = false
	for (var i in especiales) {
		if (key == especiales[i]) {
			tecla_especial = true;
			break;
		}
	}
	if (letras.indexOf(tecla) == -1 && !tecla_especial) return false;
}

function SoloNumeros(evt) {
	if (window.event) {
		keynum = evt.keyCode;
	} else {
		keynum = evt.which;
	} if ((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6) {
		return true;
	} else {
		return false;
	}
}
function nobackbutton(){

   window.location.hash="no-back-button";
   window.location.hash="Again-No-back-button" //chrome
   window.onhashchange=function(){window.location.hash="no-back-button";}	

}