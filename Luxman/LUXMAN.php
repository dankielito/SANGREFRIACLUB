<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Calculadora de Corte de Tubo - LUXMAN</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 30px; background: #f4f4f4; display: flex; gap: 40px; }
    .form-section { width: 300px; background: #fff; padding: 20px; border: 1px solid #ccc; border-radius: 10px; }
    h1 { color: #222; margin-top: 0; }
    label { display: block; margin-top: 15px; font-weight: bold; }
    input, select { padding: 8px; width: 100%; margin-top: 5px; }
    button { padding: 10px 20px; margin-top: 20px; cursor: pointer; width: 100%; }
    .checkbox-group { display: flex; align-items: center; gap: 5px; margin-top: 5px; }
    #canvas-section { flex: 1; }
    canvas { display: block; border: 1px solid #ccc; background: white; margin-top: 20px; }
    .toggle-eye { cursor: pointer; font-size: 14px; color: blue; text-decoration: underline; margin-left: 5px; }
    table { width: 100%; margin-top: 30px; border-collapse: collapse; background: #fff; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
    th { background-color: #eee; }
  </style>
</head>
<body>

<div class="form-section">
  <h1>LUXMAN Datos</h1>

  <label>Ángulo total entre tubos (°):</label>
  <input type="number" id="angulo" placeholder="Ingresa el ángulo total (Obligatorio)" required>

  <label>Diámetro exterior del tubo (cm):</label>
  <input type="number" id="diametro" placeholder="Opcional">

  <hr>
  <h3>Ficha Técnica</h3>

  <label>Altura total (cm):</label>
  <input type="number" id="altura" placeholder="Ingresa la altura total">

  <label>Capacidad total (lts):</label>
  <input type="text" id="capacidad" placeholder="Ingresa la capacidad total">

  <label>Espesor (mm):</label>
  <input type="text" id="espesor" placeholder="Ingresa el espesor">
  <div class="checkbox-group"><input type="checkbox" id="hideEspesor"> <label for="hideEspesor">Ocultar</label></div>

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
    <option value="Otro">Otro</option>
  </select>
  <input type="text" id="materialManual" placeholder="Escribir material">
  <div class="checkbox-group"><input type="checkbox" id="hideMaterial"> <label for="hideMaterial">Ocultar</label></div>

  <label>Litros útiles:</label>
  <input type="text" id="litrosUtiles" placeholder="Ingresa los litros útiles">
  <div class="checkbox-group"><input type="checkbox" id="hideLitros"> <label for="hideLitros">Ocultar</label></div>

  <label>Terminación:</label>
  <input type="text" id="terminacion" placeholder="Ingresa la termiación">
  <div class="checkbox-group"><input type="checkbox" id="hideTerminacion"> <label for="hideTerminacion">Ocultar</label></div>

  <button onclick="calcular()">Calcular y Dibujar</button>
  <button onclick="toggleFichaTecnica()" id="toggleFichaBtn">Ocultar Ficha Técnica</button>
  <button onclick="mostrarProceso()">Mostrar proceso</button>
</div>

<div id="canvas-section">
  <canvas id="moldeCanvas" width="1000" height="600"></canvas>
  <!-- Botón para descargar PDF -->
  <div style="margin-top: 10px;">
    <button onclick="descargarPDF()" style="padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 5px;">
      Descargar PDF
    </button>
  </div>
  <div id="resultado"></div>
</div>

<!-- Librería jsPDF desde CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
let mostrarFicha = true;
let formulasRef = [];
let formulasProceso = [];

function toggleFichaTecnica() {
  mostrarFicha = !mostrarFicha;
  document.getElementById("toggleFichaBtn").innerText = mostrarFicha ? "Ocultar Ficha Técnica" : "Mostrar Ficha Técnica";
  calcular();
}

function mostrarProceso() {
  for (let i = 0; i < formulasProceso.length; i++) {
    const celda = document.getElementById(`formula-${i}`);
    if (celda) celda.innerText = formulasProceso[i];
  }
}

function calcular() {
  const angulo = parseFloat(document.getElementById("angulo").value);
  const diametro = parseFloat(document.getElementById("diametro").value) || 97;
  const espesor = document.getElementById("espesor").value || 'No especificado';
  const altura = parseFloat(document.getElementById("altura").value) || 'No especificado';
  const capacidad = document.getElementById("capacidad").value || "No especificado";

  let material = document.getElementById("material").value;
  if (material === "Otro") material = document.getElementById("materialManual").value;

  const litros = document.getElementById("litrosUtiles").value || 'No especificado';
  const terminacion = document.getElementById("terminacion").value || 'No especificado';

  const hideEspesor = document.getElementById("hideEspesor").checked;
  const hideMaterial = document.getElementById("hideMaterial").checked;
  const hideLitros = document.getElementById("hideLitros").checked;
  const hideTerminacion = document.getElementById("hideTerminacion").checked;

  const radio = diametro / 2;
  const anguloCorte = angulo / 2;
  const longitudTubo = 240;
  const volumen = Math.PI * Math.pow(diametro, 2) / 4 * longitudTubo / 1000;
  const longitudProyectada = longitudTubo * Math.cos(anguloCorte * Math.PI / 180);
  const distanciaBocas = 2 * longitudTubo * Math.sin(anguloCorte * Math.PI / 180);
  const trazo = 2 * Math.PI * radio;

  formulasRef = ["ángulo / 2", "Fórmula trigonométrica (curva)", "2πR", "L * cos(ángulo / 2)", "π·D²/4 * L", "Trigonometría", "Integración curva"];
  formulasProceso = [
    `${angulo} / 2 = ${anguloCorte.toFixed(2)}°`,
    `Perfil = sin(t) * sin(${anguloCorte.toFixed(2)}°)` ,
    `2π * ${radio.toFixed(2)} = ${trazo.toFixed(2)} cm`,
    `${longitudTubo} * cos(${anguloCorte.toFixed(2)}°) = ${longitudProyectada.toFixed(2)} cm`,
    `π * ${diametro}² / 4 * ${longitudTubo} / 1000 = ${volumen.toFixed(2)} L`,
    `2 * ${longitudTubo} * sin(${anguloCorte.toFixed(2)}°) = ${distanciaBocas.toFixed(2)} cm`,
    `Área definida por curva en corte - requiere integración`
  ];

  const valores = [
    `${anguloCorte.toFixed(2)}°`, "Curva senoidal", `${trazo.toFixed(2)} cm`, `${longitudProyectada.toFixed(2)} cm`, `${volumen.toFixed(2)} L`, `${distanciaBocas.toFixed(2)} cm`, "Dependiente de integración"];
  const usos = [
    "Ajuste del bisel de corte", "Plantilla de corte", "Tamaño de plantilla", "Diseño estructural", "Capacidad por tubo", "Diseño general", "Estimación de soldadura"];

  let html = `<h2>📊 Resultados:</h2>`;
  html += `<p><strong>Diámetro:</strong> ${diametro} cm &nbsp;&nbsp; <strong>Espesor:</strong> ${espesor}</p>`;
  html += `<table><tr><th>Dato</th><th>Cálculo final</th><th>Fórmula / Referencia</th><th>Uso</th></tr>`;
  for (let i = 0; i < valores.length; i++) {
    html += `<tr><td>${usos[i]}</td><td>${valores[i]}</td><td id='formula-${i}'>${formulasRef[i]}</td><td>${usos[i]}</td></tr>`;
  }
  html += `</table>`;
  document.getElementById("resultado").innerHTML = html;

  const canvas = document.getElementById("moldeCanvas");
  const ctx = canvas.getContext("2d");
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  const centroX = canvas.width / 2;
  const centroY = canvas.height / 2 + 50;

  ctx.font = '12px Arial';
  for (let i = 0; i <= 10; i++) {
    let x = 100 + i * 80;
    ctx.beginPath(); ctx.moveTo(x, 40); ctx.lineTo(x, canvas.height - 20);
    ctx.strokeStyle = '#eee'; ctx.stroke(); ctx.fillStyle = '#000';
    ctx.fillText(i + 1, x - 4, 30);
  }
  for (let j = 0; j <= 6; j++) {
    let y = 80 + j * 70;
    ctx.beginPath(); ctx.moveTo(60, y); ctx.lineTo(canvas.width - 60, y);
    ctx.strokeStyle = '#eee'; ctx.stroke(); ctx.fillText(String.fromCharCode(65 + j), 30, y + 4);
  }

  ctx.save(); ctx.translate(centroX, centroY);
  ctx.rotate((-anguloCorte * Math.PI) / 180);
  ctx.fillStyle = '#aaa'; ctx.fillRect(-diametro / 4, 0, diametro / 2, longitudTubo);
  ctx.restore();

  ctx.save(); ctx.translate(centroX, centroY);
  ctx.rotate((anguloCorte * Math.PI) / 180);
  ctx.fillStyle = '#aaa'; ctx.fillRect(-diametro / 4, 0, diametro / 2, longitudTubo);
  ctx.restore();

  ctx.fillStyle = '#888';
  ctx.beginPath(); ctx.moveTo(centroX - 200, centroY + longitudTubo);
  ctx.lineTo(centroX - 60, centroY + 50); ctx.lineTo(centroX - 30, centroY + 50);
  ctx.lineTo(centroX - 170, centroY + longitudTubo); ctx.closePath(); ctx.fill();

  ctx.beginPath(); ctx.moveTo(centroX + 200, centroY + longitudTubo);
  ctx.lineTo(centroX + 60, centroY + 50); ctx.lineTo(centroX + 30, centroY + 50);
  ctx.lineTo(centroX + 170, centroY + longitudTubo); ctx.closePath(); ctx.fill();

  ctx.fillStyle = '#666';
  ctx.fillRect(centroX - 220, centroY + longitudTubo, 440, 20);

  ctx.fillStyle = "#999";
  ctx.fillRect(centroX - 270, centroY + 20, 50, 100);

  ctx.beginPath(); ctx.arc(centroX - 105, centroY + 10, 20, 0, 2 * Math.PI);
  ctx.fillStyle = "#555"; ctx.fill(); ctx.stroke();

  ctx.beginPath(); ctx.arc(centroX + 105, centroY + 10, 20, 0, 2 * Math.PI);
  ctx.fill(); ctx.stroke();

  ctx.font = '18px Arial'; ctx.fillStyle = '#000';
  ctx.fillText(`Capacidad total: ${capacidad} lts`, centroX - 120, centroY - longitudTubo - 10);

  ctx.setLineDash([5, 3]);
  ctx.beginPath(); ctx.moveTo(centroX + 230, centroY + longitudTubo);
  ctx.lineTo(centroX + 230, centroY - 100); ctx.strokeStyle = "green"; ctx.stroke();
  ctx.setLineDash([]); ctx.fillStyle = "green";
  ctx.fillText(`Altura: ${altura} cm`, centroX + 235, centroY);

  if (mostrarFicha) {
    ctx.fillStyle = "#000"; ctx.font = "12px Courier";
    ctx.fillText("Ficha Técnica:", centroX + 300, 100);
    let y = 120;
    if (!hideEspesor) { ctx.fillText(`Espesor: ${espesor} mm`, centroX + 300, y); y += 15; }
    if (!hideMaterial) { ctx.fillText(`Material: ${material}`, centroX + 300, y); y += 15; }
    if (!hideLitros) { ctx.fillText(`Litros útiles: ${litros}`, centroX + 300, y); y += 15; }
    if (!hideTerminacion) { ctx.fillText(`Terminación: ${terminacion}`, centroX + 300, y); y += 15; }
  }
}

function descargarPDF() {
  const { jsPDF } = window.jspdf;
  const canvas = document.getElementById("moldeCanvas");
  const imgData = canvas.toDataURL("image/png");
  const pdf = new jsPDF({
    orientation: "landscape",
    unit: "pt",
    format: [canvas.width, canvas.height]
  });
  pdf.addImage(imgData, 'PNG', 0, 0, canvas.width, canvas.height);
  pdf.save("dibujo_luxman.pdf");
}
</script>

</body>
</html>
