function agregarALista() {
    const infoSeleccionada = document.getElementById('imagenSeleccionada');
    const comentarioInput = document.getElementById('comentario');
    const listaAgregadosUl = document.getElementById('listaAgregadosUl');

    const imagenID = infoSeleccionada.value;
    const comentario = comentarioInput.value.trim();

    if (comentario !== '' && imagenID !== '') {
        const listItem = document.createElement('li');
        listItem.classList.add('lista-item');

        const itemHeader = document.createElement('div');
        itemHeader.classList.add('item-header');

        const nombreDiente = document.createElement('span');
        nombreDiente.classList.add('nombre-diente');
        nombreDiente.textContent = imagenID;

        const eliminarBtn = document.createElement('button');
        eliminarBtn.classList.add('eliminar-btn');
        eliminarBtn.textContent = 'Eliminar';
        eliminarBtn.addEventListener('click', function () {
            listItem.remove();
        });

        itemHeader.appendChild(nombreDiente);
        itemHeader.appendChild(eliminarBtn);

        listItem.appendChild(itemHeader);

        const comentarioDiv = document.createElement('div');
        comentarioDiv.classList.add('comentario');
        comentarioDiv.textContent = comentario;

        listItem.appendChild(comentarioDiv);

        listaAgregadosUl.appendChild(listItem);

        infoSeleccionada.value = '';
        comentarioInput.value = '';

        // Agregar los datos al objeto odontograma y enviarlos al servidor
        const odontogramaData = {
            nombreDiente: imagenID,
            comentario: comentario
        };

        enviarOdontogramaAlServidor(odontogramaData);
    } else {
        alert('Por favor, seleccione una imagen y agregue un comentario antes de añadir.');
    }
}

function enviarOdontogramaAlServidor(data) {
    // Obtener el objeto documentoPaciente capturado previamente
    const urlParams = new URLSearchParams(window.location.search);
    const documentoPaciente = urlParams.get('documentoPaciente');

    if (!documentoPaciente) {
        console.error('No se encontró el parámetro documentoPaciente en la URL');
        return;
    }

    // Agregar el documentoPaciente al objeto de datos
    data.documentoPaciente = documentoPaciente;

    // Enviar los datos al servidor usando fetch y el método POST
    fetch('../../controladores/controlHistorial.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
    .then(response => response.json())
    .then(data => {
        // Manejar la respuesta del servidor (puedes mostrar una alerta u otra acción)
        alert(data.message);

        // Redirigir a otra página después de que el usuario haga clic en "Aceptar"
        window.location.href = '../../../vista/odontologo/menuOdontologo.php'; // Reemplaza 'nueva_pagina.php' con la URL de la página a la que deseas redirigir
    })
    .catch(error => {
        console.error('Error al enviar el odontograma:', error);
    });
}



document.addEventListener('DOMContentLoaded', function () {
    // Capturar el parámetro documentoPaciente de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const documentoPaciente = urlParams.get('documentoPaciente');

    // Verificar si se obtuvo el valor del parámetro
    if (documentoPaciente) {
        console.log('Documento del paciente:', documentoPaciente);
    } else {
        console.error('No se encontró el parámetro documentoPaciente en la URL');
    }

    const seccionesImagenesDientes = [
        // Seccion 1/2
        ['seccion 1/18.png', 'seccion 1/17.png', 'seccion 1/16.png', 'seccion 1/15.png', 'seccion 1/14.png', 'seccion 1/13.png', 'seccion 1/12.png', 'seccion 1/1122.png', 'seccion 2/21.png', 'seccion 2/22.png', 'seccion 2/23.png', 'seccion 2/24.png', 'seccion 2/25.png', 'seccion 2/26.png', 'seccion 2/27.png', 'seccion 2/28.png'],
        // Carpeta 2
        ['seccion 4/48.png', 'seccion 4/47.png', 'seccion 4/46.png', 'seccion 4/45.png', 'seccion 4/44.png', 'seccion 4/43.png', 'seccion 4/42.png', 'seccion 4/41.png', 'seccion 3/31.png', 'seccion 3/32.png', 'seccion 3/33.png', 'seccion 3/34.png', 'seccion 3/35.png', 'seccion 3/36.png', 'seccion 3/37.png', 'seccion 3/38.png']
    ];

    const infoSeleccionada = document.getElementById('imagenSeleccionada');

    for (let i = 0; i < seccionesImagenesDientes.length; i++) {
        const seccion = document.getElementById(`seccion${i + 1}`);

        seccionesImagenesDientes[i].forEach((nombreImagen, index) => {
            const diente = document.createElement('div');
            diente.classList.add('diente');

            const imagenDiente = document.createElement('img');
            const imagenID = `diente-${i + 1}-${index + 1}`;
            imagenDiente.id = imagenID;
            imagenDiente.src = `../../assets/imagenes/odontograma/${nombreImagen}`;

            diente.appendChild(imagenDiente);

            diente.addEventListener('click', function () {
                document.querySelectorAll('.diente').forEach(el => el.classList.remove('diente-seleccionado'));

                diente.classList.add('diente-seleccionado');

                infoSeleccionada.value = imagenID;

                // Agrega un console.log para mostrar la información seleccionada
                console.log('Imagen Seleccionada:', imagenID);
            });

            seccion.appendChild(diente);
        });
    }
});

function enviarOdontograma() {
    // Obtener el valor del documentoPaciente capturado previamente
    const urlParams = new URLSearchParams(window.location.search);
    const documentoPaciente = urlParams.get('documentoPaciente');

    if (!documentoPaciente) {
        console.error('No se encontró el parámetro documentoPaciente en la URL');
        return;
    }

    const listaAgregadosUl = document.getElementById('listaAgregadosUl');

    // Obtener los datos del odontograma desde la lista de agregados
    const odontograma = [];
    const listaItems = listaAgregadosUl.getElementsByClassName('lista-item');

    for (let i = 0; i < listaItems.length; i++) {
        const comentario = listaItems[i].getElementsByClassName('comentario')[0].textContent;

        // Obtener la fecha actual en formato YYYY-MM-DD
        const fechaActual = new Date().toISOString().slice(0, 10);

        // Agregar tanto el comentario como la fecha al objeto odontograma
        odontograma.push({ comentario, fecha: fechaActual });
    }

    // Mostrar el contenido JSON antes de enviarlo
    const jsonToSend = JSON.stringify({ documentoPaciente, odontograma });
    console.log('Datos a enviar (JSON):', jsonToSend);

    // Enviar los datos al servidor usando fetch y el método POST
    fetch('../../controladores/controlHistorial.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: jsonToSend,
    })
    .then(response => response.json())
    .then(data => {
        // Manejar la respuesta del servidor (puedes mostrar una alerta u otra acción)
        alert(data.message);
    })
    .catch(error => {
        console.error('Error al enviar el odontograma:', error);
    });
}



function goBack() {
    window.history.back();
}
