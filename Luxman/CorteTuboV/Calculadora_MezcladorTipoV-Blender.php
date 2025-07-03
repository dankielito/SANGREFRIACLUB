<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Calculadora de Corte de Tubo - LUXMAN</title>
  <link rel="stylesheet" href="Calculadora_CorteTuboV.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    #fichaTecnica {
      display: none;
      margin-top: 15px;
      border: 1px solid #ccc;
      padding: 15px;
      border-radius: 6px;
      background: #fafafa;
    }
    button:disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }
    .fila-adicional {
      margin-top: 10px;
      display: flex;
      gap: 8px;
      align-items: center;
    }
    .fila-adicional input {
      flex: 1;
      padding: 5px;
    }
    .campo-ficha {
      margin-bottom: 10px;
    }
    .campo-ficha label {
      display: block;
      margin-bottom: 3px;
    }
    .botones-inline {
      margin-top: 3px;
      margin-bottom: 10px;
      display: flex;
      gap: 6px;
      align-items: center;
    }
  </style>
</head>
<body>

<div class="form-section">
  <h1>LUXMAN <img class="logo-luxman" src="img/Logo.PNG" alt="Logo LUXMAN" /></h1>
  <h2>Calculadora - <br>Mezclador Tipo V-Blender</h2>

  <label>Ángulo total entre tubos (°):</label>
  <input type="number" id="angulo" placeholder="Ingresa el ángulo total (Obligatorio)" required />

  <label>Diámetro exterior del tubo (cm):</label>
  <input type="number" id="diametro" placeholder="Opcional" />

  <hr />
  <h3>Ficha Técnica</h3>

  <!-- Botón para activar ficha técnica, inicialmente deshabilitado -->
  <button id="activarFichaBtn" onclick="activarFichaTecnica()" disabled>
    Usar Ficha Técnica
  </button>

  <!-- Ficha técnica oculta inicialmente -->
  <div id="fichaTecnica">

    <div class="campo-ficha" id="altura-field">
      <label>Altura total (cm):</label>
      <input type="number" id="altura" placeholder="Ingresa la altura total" />
      <div class="botones-inline">
        <button type="button" onclick="ocultarCampo('altura-field')">Ocultar</button>
      </div>
    </div>

    <div class="campo-ficha" id="capacidad-field">
      <label>Capacidad total (lts):</label>
      <input type="text" id="capacidad" placeholder="Ingresa la capacidad total" />
      <div class="botones-inline">
        <button type="button" onclick="ocultarCampo('capacidad-field')">Ocultar</button>
      </div>
    </div>

    <div class="campo-ficha" id="espesor-field">
      <label>Espesor (mm):</label>
      <input type="text" id="espesor" placeholder="Ingresa el espesor" />
      <div class="botones-inline">
        <button type="button" onclick="ocultarCampo('espesor-field')">Ocultar</button>
      </div>
    </div>

    <div class="campo-ficha" id="material-field">
      <label>Material:</label>
      <select id="material">
        <option value="AISI 304">AISI 304</option>
        <option value="AISI 316">AISI 316</option>
        <option value="Acero al carbón">Acero al carbón</option>
        <option value="PVC">PVC</option>
        <option value="Polipropileno">Polipropileno</option>
        <option value="PEAD">PEAD</option>
        <option value="Acero galvanizado">Acero galvanizado</option>
        <option value="Aluminio">Aluminio</option>
        <option value="Titanio">Titanio</option>
      </select>
      <input type="text" id="materialManual" placeholder="Escribir material" disabled />
      <div class="botones-inline">
        <button type="button" onclick="ocultarCampo('material-field')">Ocultar</button>
        <button type="button" id="toggleManualBtn" onclick="toggleModoMaterial()">Manual</button>
      </div>
    </div>

    <div class="campo-ficha" id="litrosUtiles-field">
      <label>Litros útiles:</label>
      <input type="text" id="litrosUtiles" placeholder="Ingresa los litros útiles" />
      <div class="botones-inline">
        <button type="button" onclick="ocultarCampo('litrosUtiles-field')">Ocultar</button>
      </div>
    </div>

    <div class="campo-ficha" id="terminacion-field">
      <label>Terminación:</label>
      <input type="text" id="terminacion" placeholder="Ingresa la terminación" />
      <div class="botones-inline">
        <button type="button" onclick="ocultarCampo('terminacion-field')">Ocultar</button>
      </div>
    </div>

    <div id="campos-adicionales"></div>

    <button type="button" onclick="agregarCampo()">Agregar</button>

    <button onclick="toggleFichaTecnica()" id="toggleFichaBtn" style="margin-top: 15px;">
      Ocultar Ficha Técnica
    </button>
  </div>

  <button onclick="calcular()">Calcular y Dibujar</button>
  <button onclick="mostrarProceso()">Mostrar proceso</button>
</div>

<div id="canvas-section">
  <canvas id="moldeCanvas" width="1000" height="600"></canvas>
  <div style="margin-top: 10px;">
    <button
      onclick="descargarPDF()"
      style="padding: 10px 20px; background-color: #04aef0; color: white; border: none; border-radius: 5px;"
    >
      Descargar PDF
    </button>
  </div>
  <div id="resultado"></div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
let mostrarFicha = true; // Cuando se despliega ficha técnica, true
let formulasRef = [];
let formulasProceso = [];

function ocultarCampo(idCampo) {
  const campo = document.getElementById(idCampo);
  if (campo) {
    campo.style.display = 'none';
  }
}

// Alternar modo manual / select en Material
function toggleModoMaterial() {
  const select = document.getElementById('material');
  const inputManual = document.getElementById('materialManual');
  const btn = document.getElementById('toggleManualBtn');

  if (btn.innerText === 'Manual') {
    // Pasar a modo manual
    select.disabled = true;
    inputManual.disabled = false;
    inputManual.focus();
    btn.innerText = 'Opciones';
  } else {
    // Volver a modo opciones
    select.disabled = false;
    inputManual.disabled = true;
    inputManual.value = '';
    btn.innerText = 'Manual';
  }
}

function activarFichaTecnica() {
  const ficha = document.getElementById('fichaTecnica');
  ficha.style.display = 'block';

  // Deshabilitar el botón "Usar Ficha Técnica"
  document.getElementById('activarFichaBtn').disabled = true;

  mostrarFicha = true;
  Swal.fire({
    icon: 'success',
    title: 'Ficha Técnica activada',
    text: 'Ahora puedes rellenar los campos técnicos del tubo.',
    confirmButtonText: 'Entendido'
  });
  calcular();
}

function toggleFichaTecnica() {
  const ficha = document.getElementById('fichaTecnica');
  mostrarFicha = !mostrarFicha;
  ficha.style.display = mostrarFicha ? 'block' : 'none';
  document.getElementById('toggleFichaBtn').innerText = mostrarFicha ? 'Ocultar Ficha Técnica' : 'Mostrar Ficha Técnica';
}

function mostrarProceso() {
  for (let i = 0; i < formulasProceso.length; i++) {
    const celda = document.getElementById(`formula-${i}`);
    if (celda) celda.innerText = formulasProceso[i];
  }
}

function calcular() {
  const anguloInput = document.getElementById('angulo');
  if (!anguloInput.value || isNaN(parseFloat(anguloInput.value))) {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Por favor ingresa un ángulo válido antes de calcular.',
    });
    return;
  }

  // Habilitar botón "Usar Ficha Técnica"
  document.getElementById('activarFichaBtn').disabled = false;

  const angulo = parseFloat(anguloInput.value);
  const diametro = parseFloat(document.getElementById('diametro').value) ||'No especificado';
  const espesor = document.getElementById('espesor').value || 'No especificado';
  const altura = parseFloat(document.getElementById('altura').value) || 'No especificado';
  const capacidad = document.getElementById('capacidad').value || 'No especificado';

  let material = document.getElementById('material').value;
  // Si está en modo manual toma input manual
  const inputManual = document.getElementById('materialManual');
  if (!inputManual.disabled && inputManual.value.trim() !== '') {
    material = inputManual.value.trim();
  }

  const litros = document.getElementById('litrosUtiles').value || 'No especificado';
  const terminacion = document.getElementById('terminacion').value || 'No especificado';

  const hideEspesor = document.getElementById('espesor-field').style.display === 'none';
  const hideMaterial = document.getElementById('material-field').style.display === 'none';
  const hideLitros = document.getElementById('litrosUtiles-field').style.display === 'none';
  const hideTerminacion = document.getElementById('terminacion-field').style.display === 'none';

  const radio = diametro / 2;
  const anguloCorte = angulo / 2;
  const longitudTubo = 240;
  const volumen = Math.PI * Math.pow(diametro, 2) / 4 * longitudTubo / 1000;
  const longitudProyectada = longitudTubo * Math.cos(anguloCorte * Math.PI / 180);
  const distanciaBocas = 2 * longitudTubo * Math.sin(anguloCorte * Math.PI / 180);
  const trazo = 2 * Math.PI * radio;

  formulasRef = [
    'ángulo / 2',
    'Fórmula trigonométrica (curva)',
    '2πR',
    'L * cos(ángulo / 2)',
    'π·D²/4 * L',
    'Trigonometría',
    'Integración curva'
  ];
  formulasProceso = [
    `${angulo} / 2 = ${anguloCorte.toFixed(2)}°`,
    `Perfil = sin(t) * sin(${anguloCorte.toFixed(2)}°)`,
    `2π * ${radio.toFixed(2)} = ${trazo.toFixed(2)} cm`,
    `${longitudTubo} * cos(${anguloCorte.toFixed(2)}°) = ${longitudProyectada.toFixed(2)} cm`,
    `π * ${diametro}² / 4 * ${longitudTubo} / 1000 = ${volumen.toFixed(2)} L`,
    `2 * ${longitudTubo} * sin(${anguloCorte.toFixed(2)}°) = ${distanciaBocas.toFixed(2)} cm`,
    `Área definida por curva en corte - requiere integración`
  ];

  const valores = [
    `${anguloCorte.toFixed(2)}°`,
    'Curva senoidal',
    `${trazo.toFixed(2)} cm`,
    `${longitudProyectada.toFixed(2)} cm`,
    `${volumen.toFixed(2)} L`,
    `${distanciaBocas.toFixed(2)} cm`,
    'Dependiente de integración'
  ];
  const usos = [
    'Ajuste del bisel de corte',
    'Plantilla de corte',
    'Tamaño de plantilla',
    'Diseño estructural',
    'Capacidad por tubo',
    'Diseño general',
    'Estimación de soldadura'
  ];

  let html = `<h2>📊 Resultados:</h2>`;
  html += `<p><strong>Diámetro:</strong> ${diametro} cm &nbsp;&nbsp; <strong>Espesor:</strong> ${espesor}</p>`;
  html += `<table><tr><th>Dato</th><th>Cálculo final</th><th>Fórmula / Referencia</th><th>Uso</th></tr>`;
  for (let i = 0; i < valores.length; i++) {
    html += `<tr><td>${usos[i]}</td><td>${valores[i]}</td><td id='formula-${i}'>${formulasRef[i]}</td><td>${usos[i]}</td></tr>`;
  }
  html += `</table>`;
  document.getElementById('resultado').innerHTML = html;

  const canvas = document.getElementById('moldeCanvas');
  const ctx = canvas.getContext('2d');
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  const centroX = canvas.width / 2;
  const centroY = canvas.height / 2 + 50;

  ctx.font = '12px Arial';
  for (let i = 0; i <= 10; i++) {
    let x = 100 + i * 80;
    ctx.beginPath();
    ctx.moveTo(x, 40);
    ctx.lineTo(x, canvas.height - 20);
    ctx.strokeStyle = '#eee';
    ctx.stroke();
    ctx.fillStyle = '#000';
    ctx.fillText(i + 1, x - 4, 30);
  }
  for (let j = 0; j <= 6; j++) {
    let y = 80 + j * 70;
    ctx.beginPath();
    ctx.moveTo(60, y);
    ctx.lineTo(canvas.width - 60, y);
    ctx.strokeStyle = '#eee';
    ctx.stroke();
    ctx.fillText(String.fromCharCode(65 + j), 30, y + 4);
  }

  ctx.save();
  ctx.translate(centroX, centroY);
  ctx.rotate((-anguloCorte * Math.PI) / 180);
  ctx.fillStyle = '#aaa';
  ctx.fillRect(-diametro / 4, 0, diametro / 2, longitudTubo);
  ctx.restore();

  ctx.save();
  ctx.translate(centroX, centroY);
  ctx.rotate((anguloCorte * Math.PI) / 180);
  ctx.fillStyle = '#aaa';
  ctx.fillRect(-diametro / 4, 0, diametro / 2, longitudTubo);
  ctx.restore();

  ctx.fillStyle = '#888';
  ctx.beginPath();
  ctx.moveTo(centroX - 200, centroY + longitudTubo);
  ctx.lineTo(centroX - 60, centroY + 50);
  ctx.lineTo(centroX - 30, centroY + 50);
  ctx.lineTo(centroX - 170, centroY + longitudTubo);
  ctx.closePath();
  ctx.fill();

  ctx.beginPath();
  ctx.moveTo(centroX + 200, centroY + longitudTubo);
  ctx.lineTo(centroX + 60, centroY + 50);
  ctx.lineTo(centroX + 30, centroY + 50);
  ctx.lineTo(centroX + 170, centroY + longitudTubo);
  ctx.closePath();
  ctx.fill();

  ctx.fillStyle = '#666';
  ctx.fillRect(centroX - 220, centroY + longitudTubo, 440, 20);

  ctx.fillStyle = '#999';
  ctx.fillRect(centroX - 270, centroY + 20, 50, 100);

  ctx.beginPath();
  ctx.arc(centroX - 105, centroY + 10, 20, 0, 2 * Math.PI);
  ctx.fillStyle = '#555';
  ctx.fill();
  ctx.stroke();

  ctx.beginPath();
  ctx.arc(centroX + 105, centroY + 10, 20, 0, 2 * Math.PI);
  ctx.fill();
  ctx.stroke();

  ctx.font = '18px Arial';
  ctx.fillStyle = '#000';
  ctx.fillText(`Capacidad total: ${capacidad} lts`, centroX - 120, centroY - longitudTubo - 10);

  ctx.setLineDash([5, 3]);
  ctx.beginPath();
  ctx.moveTo(centroX + 230, centroY + longitudTubo);
  ctx.lineTo(centroX + 230, centroY - 100);
  ctx.strokeStyle = 'green';
  ctx.stroke();
  ctx.setLineDash([]);
  ctx.fillStyle = 'green';
  ctx.fillText(`Altura: ${altura} cm`, centroX + 235, centroY);

  if (mostrarFicha) {
    ctx.fillStyle = '#000';
    ctx.font = '12px Courier';
    ctx.fillText('Ficha Técnica:', centroX + 300, 100);
    let y = 120;

    if (document.getElementById('espesor-field').style.display !== 'none') {
      ctx.fillText(`Espesor: ${espesor} mm`, centroX + 300, y);
      y += 15;
    }
    if (document.getElementById('material-field').style.display !== 'none') {
      ctx.fillText(`Material: ${material}`, centroX + 300, y);
      y += 15;
    }
    if (document.getElementById('litrosUtiles-field').style.display !== 'none') {
      ctx.fillText(`Litros útiles: ${litros}`, centroX + 300, y);
      y += 15;
    }
    if (document.getElementById('terminacion-field').style.display !== 'none') {
      ctx.fillText(`Terminación: ${terminacion}`, centroX + 300, y);
      y += 15;
    }

    // Dibujar campos adicionales
    const contAdicional = document.getElementById('campos-adicionales');
    if (contAdicional) {
      const filas = contAdicional.querySelectorAll('.fila-adicional');
      filas.forEach((fila, idx) => {
        const titulo = fila.querySelector('.titulo-adicional').value.trim();
        const dato = fila.querySelector('.dato-adicional').value.trim();
        if (titulo && dato) {
          ctx.fillText(`${titulo}: ${dato}`, centroX + 300, y);
          y += 15;
        }
      });
    }
  }
}

// Función para agregar nuevo campo en ficha técnica
function agregarCampo() {
  const cont = document.getElementById('campos-adicionales');
  const div = document.createElement('div');
  div.className = 'fila-adicional';

  const inputTitulo = document.createElement('input');
  inputTitulo.type = 'text';
  inputTitulo.placeholder = 'Título';
  inputTitulo.className = 'titulo-adicional';

  const inputDato = document.createElement('input');
  inputDato.type = 'text';
  inputDato.placeholder = 'Dato';
  inputDato.className = 'dato-adicional';

  const btnQuitar = document.createElement('button');
  btnQuitar.type = 'button';
  btnQuitar.textContent = 'Eliminar';
  btnQuitar.onclick = () => div.remove();

  div.appendChild(inputTitulo);
  div.appendChild(inputDato);
  div.appendChild(btnQuitar);

  cont.appendChild(div);
}

function descargarPDF() {
  const { jsPDF } = window.jspdf;
  const canvas = document.getElementById('moldeCanvas');
  const imgData = canvas.toDataURL('image/png');
  const pdf = new jsPDF({
    orientation: 'landscape',
    unit: 'pt',
    format: [canvas.width, canvas.height],
  });
  pdf.addImage(imgData, 'PNG', 0, 0, canvas.width, canvas.height);
  pdf.save('dibujo_luxman.pdf');
}
</script>

</body>
</html>
