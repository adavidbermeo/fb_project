var btnAbrirPopup = document.querySelectorAll('.btn-abrir-popup'),
	overlay = document.getElementById('overlay'),
	popup = document.getElementById('popup'),
	btnCerrarPopup = document.getElementById('btn-cerrar-popup');


for (var i = 0; i < btnAbrirPopup.length; i++) {
	btnAbrirPopup[i].addEventListener('click', function () {
		overlay.classList.add('active');
		popup.classList.add('active');
	});
}

btnCerrarPopup.addEventListener('click', function (e) {
	e.preventDefault();
	overlay.classList.remove('active');
	popup.classList.remove('active');
});


