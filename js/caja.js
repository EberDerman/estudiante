const idColumn = 0;
const codigoColumn = 1;
const descripcionColumn = 2;
const cantidadColumn = 3;
const unitarioColumn = 4;
const importeColumn = 5;
var selectedRow;
var importeTemp;
var descripcionTemp;

function toggleFullScreen() {
	var icono = document.getElementById('btn-pantallaCompleta');
	if (!document.fullscreenElement) {
		document.documentElement.requestFullscreen();
		icono.classList.remove("ico-pantallacompleta");
		icono.classList.add("ico-salirpantallacompleta");
		icono.title = "Salir de pantalla completa";
		mainContent.classList.add('p-2');
		header.hidden = true;
	} else {
		if (document.exitFullscreen) {
			mainContent.classList.remove('p-2');
			header.hidden = false;
			icono.classList.remove("ico-salirpantallacompleta");
			icono.classList.add("ico-pantallacompleta");
			icono.title = "Ir a pantalla completa";
			document.exitFullscreen();
		}
	}
}

function addRows(articulos) {
	tableBusquedaDescripcion.tHead.innerHTML = "";
	tableBusquedaDescripcion.tBodies[0].innerHTML = "";
	let theadRow = tableBusquedaDescripcion.tHead.insertRow(-1);
	if (articulos['Info']) {
		theadRow.classList.add('bg-warning');
		let newCell = theadRow.insertCell(0);
		newCell.classList.add('font-weight-bold');
		let newText = document.createTextNode('Artículo no encontrado');
		newCell.appendChild(newText);
	} else {
		theadRow.classList.add('bg-success');
		let newCell = theadRow.insertCell(-1);
		newCell.classList.add('font-weight-bold');
		let newText = document.createTextNode('Código');
		newCell.appendChild(newText);
		newCell = theadRow.insertCell(-1);
		newCell.classList.add('font-weight-bold');
		newText = document.createTextNode('Descripción');
		newCell.appendChild(newText);
		newCell = theadRow.insertCell(-1);
		newCell.classList.add('font-weight-bold');
		newText = document.createTextNode('Precio Minorista');
		newCell.appendChild(newText);
		newCell = theadRow.insertCell(-1);
		newCell.classList.add('font-weight-bold');
		newText = document.createTextNode('Precio Mayorista');
		newCell.appendChild(newText);
		tBody = tableBusquedaDescripcion.tBodies[0];
		for (articulo of articulos) {
			newRow = tBody.insertRow(-1);
			newRow.addEventListener('click', addArticulo.bind(this, articulo));
			newRow.title = "Agregar";
			newCell = newRow.insertCell(-1);
			newText = document.createTextNode(articulo['codArticulo']);
			newCell.appendChild(newText);
			newCell.classList.add('pt-3-half');
			newCell = newRow.insertCell(-1);
			newText = document.createTextNode(articulo['descripcion']);
			newCell.appendChild(newText);
			newCell.classList.add('pt-3-half');
			newCell = newRow.insertCell(-1);
			newText = document.createTextNode(articulo['precioVentaMin']);
			newCell.appendChild(newText);
			newCell.classList.add('pt-3-half');
			newCell = newRow.insertCell(-1);
			newText = document.createTextNode(articulo['precioVentaMay']);
			newCell.appendChild(newText);
			newCell.classList.add('pt-3-half');
		}
	}
}

function addArticulo(articulo) {
	articulo.precio = articulo['precioVenta' + precioListaArticuloBusqueda.value];
	articulo.cantidad = cantidadArticuloBusqueda.value;
	addRow(articulo);
	$('#modalBuscarPorDescripcion').modal('hide');
}

function addRow(articulo) {
	// Inserta una fila en la tabla
	var newRow = dtArticulos.insertRow();
	newRow.addEventListener('click', selectRow.bind(this, newRow));
	newRow.title = "Seleccionar";
	newRow.classList.add('cursor-default');
	// Inserta una celda en la fila
	let newCell = newRow.insertCell(idColumn);
	// Añade un nodo de texto a la celda
	let newText = document.createTextNode(newRow.rowIndex);
	newCell.appendChild(newText);
	newCell.classList.add('pt-3-half');

	newCell = newRow.insertCell(codigoColumn);
	newText = document.createTextNode(articulo.codArticulo);
	newCell.appendChild(newText);
	newCell.classList.add('pt-3-half');

	newCell = newRow.insertCell(descripcionColumn);
	newText = document.createTextNode(articulo.descripcion);
	newCell.appendChild(newText);
	newCell.classList.add('pt-3-half');

	newCell = newRow.insertCell(cantidadColumn);
	newText = document.createTextNode(articulo.cantidad);
	newCell.appendChild(newText);
	newCell.classList.add('pt-3-half');
	newCell.classList.add('cursor-text');
	newCell.contentEditable = true;

	newCell = newRow.insertCell(unitarioColumn);
	newText = document.createTextNode(articulo.precio);
	newCell.appendChild(newText);
	newCell.classList.add('pt-3-half');
	newCell.contentEditable = true;

	let importe = articulo.cantidad * articulo.precio;
	newCell = newRow.insertCell(importeColumn);
	newText = document.createTextNode(importe);
	newCell.appendChild(newText);
	newCell.classList.add('pt-3-half');

	subtotal.value = (parseFloat(subtotal.value) + importe).toFixed(2);
	total.value = (parseFloat(subtotal.value) + parseFloat(descuentoRecargo.value)).toFixed(2);
	totalAPagar.textContent = total.value;
	saldo.textContent = -total.value;


}

function deleteRow() {
	let imporTemp = dtArticulos.rows[selectedRow].cells[importeColumn].textContent;
	subtotal.value = parseFloat(subtotal.value) - parseFloat(imporTemp);
	total.value = parseFloat(total.value) - parseFloat(imporTemp);
	dtArticulos.deleteRow(selectedRow);
	btnQuitarText.textContent = '';
	btnQuitar.disabled = true;
	btnDescuento.disabled = true;
	btnRecargo.disabled = true;
	selectedRow = null;
}

function selectRow(row) {
	if (selectedRow != null) {
		dtArticulos.rows[selectedRow].classList.remove('bg-select-table');
	}
	selectedRow = row.rowIndex - 1;
	dtArticulos.rows[selectedRow].classList.add('bg-select-table');
	btnQuitarText.textContent = ' Fila ' + row.rowIndex;
	btnQuitar.disabled = false;
	btnDescuento.disabled = false;
	btnRecargo.disabled = false;
	importeTemp = parseFloat(dtArticulos.rows[selectedRow].cells[importeColumn].textContent.replace(',', '.')).toFixed(2);
	descripcionTemp = dtArticulos.rows[selectedRow].cells[descripcionColumn].textContent;
}

function descuento() {
	titleDescuento.textContent = descripcionTemp;
	$('#modalDescuento').modal('show');
}

function realizarDescuento() {
	descuentoRecargo.value = (parseFloat(descuentoRecargo.value) - parseFloat(montoDescuento.value)).toFixed(2);;
	total.value = (parseFloat(subtotal.value) + parseFloat(descuentoRecargo.value)).toFixed(2);
}

function actMontoDescuento() {
	montoDescuento.value = (importeTemp * parseFloat(porcentajeDescuento.value.replace(',', '.') / 100)).toFixed(2);
}

function addClassActiveForLabels(aLabel) {
	aLabel.classList.add('active');
}

function actPorcentajeOn(anInput, aValue) {
	anInput.value = ((aValue / importeTemp * 100)).toFixed(2);
}

function recargo() {
	titleRecargo.textContent = descripcionTemp;
	$('#modalRecargo').modal('show');
}

function realizarRecargo() {
	descuentoRecargo.value = (parseFloat(descuentoRecargo.value) + parseFloat(montoRecargo.value)).toFixed(2);
	total.value = (parseFloat(subtotal.value) + parseFloat(descuentoRecargo.value)).toFixed(2);
}

function actMontoRecargo() {
	montoRecargo.value = (importeTemp * parseFloat(porcentajeRecargo.value.replace(',', '.') / 100)).toFixed(2);
}

function mostrarPrecio(articulo) {
	descripcionArticulo.textContent = articulo.descripcion;
	precioArticulo.textContent = '$ ' + articulo.precio;
}

function getArticuloAsync(aButton, aFunction, aUrl) {
	xhr = new XMLHttpRequest();
	xhr.open("GET", aUrl, true);
	xhr.onreadystatechange = responseToRequest.bind(this, aButton, aFunction);
	aButton.classList.add('cursor-wait');
	xhr.send();
}

function toggleClasses(anElement, classToRemove, classToAdd) {
	anElement.classList.remove(classToRemove);
	anElement.classList.add(classToAdd);
}

function responseToRequest(aButton, aFunction) {
	if (xhr.readyState == 4) {
		if (xhr.status == 200) {
			string_json_response = xhr.responseText;
			articulo = JSON.parse(string_json_response);
			if (articulo) {
				aFunction(articulo);
			} else {
				$('#ModalWarningArticulo').modal('show');
			}
		} else alert("Algo anda mal");
	}
	aButton.classList.remove('cursor-wait');
}

function getClienteAsync(aButton, aUrl) {
	xhr = new XMLHttpRequest();
	xhr.open("GET", aUrl, true);
	xhr.onreadystatechange = responseToRequestCliente.bind(this, aButton);
	aButton.classList.add('cursor-wait');
	xhr.send();
}

function responseToRequestCliente(aButton) {
	if (xhr.readyState == 4) {
		if (xhr.status == 200) {
			string_json_response = xhr.responseText;
			cliente = JSON.parse(string_json_response);
			if (cliente) {
				addRowsCliente(cliente);
			} else {

			}
		} else alert("Algo anda mal");
	}
	aButton.classList.remove('cursor-wait');
}

function addRowsCliente(clientes) {
	tableBusquedaCliente.tHead.innerHTML = "";
	tableBusquedaCliente.tBodies[0].innerHTML = "";
	let theadRow = tableBusquedaCliente.tHead.insertRow(-1);
	if (clientes['Info']) {
		theadRow.classList.add('bg-warning');
		let newCell = theadRow.insertCell(0);
		newCell.classList.add('font-weight-bold');
		let newText = document.createTextNode('Cliente no encontrado');
		newCell.appendChild(newText);
	} else {
		theadRow.classList.add('bg-success');
		let newCell = theadRow.insertCell(-1);
		newCell.classList.add('font-weight-bold');
		let newText = document.createTextNode('Nombre');
		newCell.appendChild(newText);
		newCell = theadRow.insertCell(-1);
		newCell.classList.add('font-weight-bold');
		newText = document.createTextNode('Apellido');
		newCell.appendChild(newText);
		newCell = theadRow.insertCell(-1);
		newCell.classList.add('font-weight-bold');
		newText = document.createTextNode('Razon Social');
		newCell.appendChild(newText);
		newCell = theadRow.insertCell(-1);
		newCell.classList.add('font-weight-bold');
		newText = document.createTextNode('Domicilio');
		newCell.appendChild(newText);
		newCell = theadRow.insertCell(-1);
		newCell.classList.add('font-weight-bold');
		newText = document.createTextNode('Localidad');
		newCell.appendChild(newText);
		newCell = theadRow.insertCell(-1);
		newCell.classList.add('font-weight-bold');
		newText = document.createTextNode('Telefono');
		newCell.appendChild(newText);
		newCell = theadRow.insertCell(-1);
		newCell.classList.add('font-weight-bold');
		newText = document.createTextNode('Condicion IVA');
		newCell.appendChild(newText);
		tBody = tableBusquedaCliente.tBodies[0];
		for (cliente of clientes) {
			newRow = tBody.insertRow(-1);
			newRow.addEventListener('click', agregarCliente.bind(this, cliente));
			newRow.title = "Agregar";
			newCell = newRow.insertCell(-1);
			newText = document.createTextNode(cliente['nombre']);
			newCell.appendChild(newText);
			newCell.classList.add('pt-3-half');
			newCell = newRow.insertCell(-1);
			newText = document.createTextNode(cliente['apellido']);
			newCell.appendChild(newText);
			newCell.classList.add('pt-3-half');
			newCell = newRow.insertCell(-1);
			newText = document.createTextNode(cliente['razonSocial']);
			newCell.appendChild(newText);
			newCell.classList.add('pt-3-half');
			newCell = newRow.insertCell(-1);
			newText = document.createTextNode(cliente['calle'] + ' ' + cliente['nroDomicilio']);
			newCell.appendChild(newText);
			newCell.classList.add('pt-3-half');
			newCell = newRow.insertCell(-1);
			newText = document.createTextNode(cliente['localidad']);
			newCell.appendChild(newText);
			newCell.classList.add('pt-3-half');
			newCell = newRow.insertCell(-1);
			newText = document.createTextNode(cliente['telefono']);
			newCell.appendChild(newText);
			newCell.classList.add('pt-3-half');
			newCell = newRow.insertCell(-1);
			newText = document.createTextNode(cliente['tipoCondicion']);
			newCell.appendChild(newText);
			newCell.classList.add('pt-3-half');
		}
	}
}

function agregarCliente(cliente) {
	nombreCliente.value = cliente.nombre + ' ' + cliente.apellido + ' ' + cliente.razonSocial;
	domicilio.value = cliente.calle + ' ' + cliente.nroDomicilio;
	localidad.value = cliente.localidad;
	telefono.value = cliente.telefono;
	condicionIva.value = cliente.tipoCondicion;
	$('#modalBuscarCliente').modal('hide');
}