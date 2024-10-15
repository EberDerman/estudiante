var inputCuit = document.getElementById('cuit');
var feedCuit = document.getElementById('cuitFeedback');
var inputRazonSocial = document.getElementById('razonSocial');
var feedRazonSocial = document.getElementById('razonSocialFeedback');
var inputEmail = document.getElementById('email');
var feedEmail = document.getElementById('emailFeedback');
var lastKeyPressed;


function isKeyPermissed(key) {
	// Teclas permitidas
	keysPermissed = ['Backspace', 'Delete', 'ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight', '-'];
	return keysPermissed.includes(key);
}

function addUnderline() {
	if (!isKeyPermissed(lastKeyPressed) && (inputCuit.value.length == 2 || inputCuit.value.length == 11)) {
		inputCuit.value += '-';
	} else if (inputCuit.value.length == 13) {
		inputCuit.classList.add("is-valid");
		feedCuit.classList.add('valid-feedback');
		feedCuit.innerText = "El CUIT luce bien";
	}
}

function isCuitPattern(cuit) {
	let expregCuit = /^[0-9]{2}-[0-9]{8}-[0-9]{1}$/;
	return expregCuit.test(cuit);
}

function isEmailPattern(email) {
	let expregEmail = /^[A-Za-z0-9._-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;
	return expregEmail.test(email);
}


function feedbackCustomizable(aFeedbackElement, anInput, aText) {
	aFeedbackElement.classList.remove('valid-feedback');
	anInput.classList.remove("is-valid");

	anInput.classList.add("is-invalid");
	aFeedbackElement.classList.add('invalid-feedback');

	aFeedbackElement.innerText = aText;
}

function cleanFeedback(aFeedback, anInput) {
	aFeedback.innerText = "";
	aFeedback.classList.remove('invalid-feedback');
	anInput.classList.remove("is-invalid");
	aFeedback.classList.remove('valid-feedback');
	anInput.classList.remove("is-valid");
}

function cleanInputs(){
	for (let element of arguments) {
		element.value = '';
	}
}



function checkCuit(evt) {
	lastKeyPressed = evt.key;
	let char = parseInt(evt.key);
	if (isNaN(char) && !isKeyPermissed(lastKeyPressed)) {
		inputCuit.classList.add("is-invalid");
		feedCuit.classList.add('invalid-feedback');
		feedCuit.innerText = "Sólo se permiten carácteres númericos";
		evt.preventDefault();
	} else {
		cleanFeedback(feedCuit, inputCuit);
	}
}

function checkEmail() {
	if (isEmailPattern(inputEmail.value)) {
		cleanFeedback(feedEmail, inputEmail);
	}
}

function cambioEstado(label, checkBox) {
	if (checkBox.checked == true) {
		checkBox.value = 1;
		label.innerText = "Habilitada";
		label.classList.remove("text-muted");
	} else {
		label.innerText = "Deshabilitada";
		label.classList.add("text-muted");
	}
}

function onCheckChange(label, checkBox) {
	if (checkBox.checked == true) {
		checkBox.value = 1;
		label.classList.remove("text-muted");
	} else {
		label.classList.add("text-muted");
	}
}

function toggleContent(contentToShow, contentToHidden) {
	contentToShow.hidden = false;
	contentToShow.disabled = false;
	contentToHidden.hidden = true;
	contentToHidden.disabled = true;
}

function requireElements() {
	for (let element of arguments) {
		element.required = true;
	}
}

function validateFormCliente() {
	if (individuo.checked) {
		contentIndividuo.disabled = false;
		contentEmpresa.disabled = true;} 
	else {
		contentIndividuo.disabled = true;
		contentEmpresa.disabled = false;} 
	if (!myTabContentMD.checkValidity()) {
		feedbackForm.hidden = false;
	}
}

function initializeChecks(){
	onCheckChange(labelOferta,checkOferta);
	onCheckChange(labelPublicar, checkPublicar);
	onCheckChange(labelStock, checkStock);
	onCheckChange(labelVencimiento, checkVencimiento);
}

function fechaActualInput(anInput){
	anInput.value = new Date().toLocaleDateString('en-CA');
}