<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Explorador de Población Mundial</title>

<!-- Importamos 3 tipografías desde Google Fonts:
     - Fraunces: para el título principal 
     - IBM Plex Sans: para los textos normales
     - IBM Plex Mono: para los números de población (estilo "de datos") -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,560;0,9..144,680;1,9..144,560&family=IBM+Plex+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@500;600&display=swap" rel="stylesheet">

<style>
/* ============================================
   VARIABLES DE COLOR (paleta de diseño)
   Se definen una sola vez aquí y se reutilizan
   en todo el CSS con var(--nombre). Si se quiere
   cambiar un color, solo se edita en este bloque.
   ============================================ */
:root{
  --bg:#F3EEFB;          /* fondo general (lila muy claro) */
  --surface:#FFFFFF;     /* fondo de tarjetas/paneles */
  --ink:#241B3A;         /* color principal del texto */
  --ink-soft:#6B5C8C;    /* texto secundario, más suave */
  --violet:#7C3AED;      /* morado principal (acento) */
  --violet-deep:#4C1D95; /* morado oscuro (para contrastes) */
  --violet-pale:#EDE4FB; /* morado muy claro (fondos suaves) */
  --gold:#E8A33D;        /* dorado, color secundario de acento */
  --line:#E1D4F7;        /* color de bordes y líneas divisorias */
}

/* Quita los márgenes/rellenos por defecto que trae
   cada navegador, para que el diseño sea predecible */
*{box-sizing:border-box;}

body{
  margin:0;
  background:var(--bg);
  /* Dos degradados circulares y difusos en las esquinas,
     para darle profundidad al fondo sin que sea un color plano */
  background-image: radial-gradient(circle at 12% -10%, rgba(124,58,237,.16), transparent 45%),
                     radial-gradient(circle at 100% 0%, rgba(232,163,61,.14), transparent 40%);
  color:var(--ink);
  font-family:'IBM Plex Sans', sans-serif;
  -webkit-font-smoothing:antialiased; /* suaviza el renderizado del texto */
}

/* Contenedor central: limita el ancho máximo y centra
   todo el contenido de la página */
.page{max-width:920px;margin:0 auto;padding:64px 24px 96px;}

/* Texto pequeño arriba del título ("Consulta en vivo") */
.eyebrow{
  font-family:'IBM Plex Mono',monospace;
  font-size:.78rem;
  letter-spacing:.14em;       /* separa las letras */
  text-transform:uppercase;   /* fuerza mayúsculas */
  color:var(--violet-deep);
  margin:0 0 18px;
}

/* Título principal */
h1{
  font-family:'Fraunces', serif;
  font-weight:680;
  font-size:clamp(2.1rem,5vw,3.4rem); /* tamaño responsive: mínimo, ideal, máximo */
  line-height:1.05;
  margin:0 0 18px;
}
h1 em{
  font-style:italic;
  font-weight:560;
  color:var(--violet); /* la parte en cursiva del título se pinta de morado */
}

/* Párrafo de introducción debajo del título */
.lede{
  font-size:1.05rem;
  color:var(--ink-soft);
  max-width:52ch;     /* limita el ancho a ~52 caracteres para que sea fácil de leer */
  line-height:1.55;
  margin:0 0 48px;
}

/* ============================================
   PANEL DEL SELECTOR DE PAÍS
   ============================================ */
.selector-panel{
  display:flex;           /* pone el sello y el selector uno al lado del otro */
  align-items:center;
  gap:24px;
  background:var(--surface);
  border:1px solid var(--line);
  border-radius:20px;
  padding:22px 26px;
  /* sombra suave hacia abajo, con tinte morado en vez de negro plano */
  box-shadow:0 20px 40px -28px rgba(76,29,149,.35);
}

/* El círculo tipo "sello de pasaporte" que muestra el código del país */
.stamp{
  flex:0 0 auto;           /* no se estira ni se encoge, mantiene su tamaño */
  width:64px;height:64px;
  border-radius:50%;       /* lo convierte en círculo */
  border:2px dashed var(--violet); /* borde punteado, como un sello real */
  display:flex;align-items:center;justify-content:center;
  font-family:'IBM Plex Mono',monospace;
  font-weight:600;
  font-size:.85rem;
  color:var(--violet-deep);
  transform:rotate(-8deg); /* lo inclina un poco para que no se vea "perfecto" */
  transition:transform .35s ease, color .35s ease, border-color .35s ease;
}
/* Estado "activo": se aplica con JavaScript cuando el usuario ya eligió un país  */
.stamp.active{
  color:var(--gold);
  border-color:var(--gold);
  transform:rotate(-4deg) scale(1.06); /* se endereza un poco y crece levemente */
}

.selector-field{flex:1;min-width:0;} /* ocupa todo el espacio restante del panel */
.selector-field label{
  display:block;
  font-size:.82rem;
  font-weight:600;
  color:var(--ink-soft);
  margin-bottom:6px;
}

/* Estilos del <select> nativo, "disfrazado" para que no se vea
   como el selector feo por defecto del navegador */
select{
  width:100%;
  appearance:none; /* quita el estilo nativo del navegador */
  /* Fondo morado claro + una flechita dibujada directamente en código
     (SVG en formato texto) puesta como imagen de fondo a la derecha */
  background:var(--violet-pale) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='9'%3E%3Cpath d='M1 1l6 6 6-6' stroke='%234C1D95' stroke-width='2' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E") no-repeat right 18px center;
  border:1.5px solid transparent;
  border-radius:12px;
  padding:14px 44px 14px 16px; /* más espacio a la derecha para que no choque con la flecha */
  font-family:'IBM Plex Sans',sans-serif;
  font-size:1rem;
  font-weight:500;
  color:var(--ink);
  cursor:pointer;
  transition:border-color .2s ease, background-color .2s ease;
}
select:hover{border-color:var(--violet);}
/* Estilo de foco visible (accesibilidad): resalta el selector
   cuando se navega con teclado (tecla Tab) */
select:focus-visible{outline:3px solid var(--gold);outline-offset:2px;}

/* ============================================
   SECCIÓN DE RESULTADOS (las 2 columnas de ciudades)
   ============================================ */
.results{
  display:grid;
  grid-template-columns:1fr 1fr; /* 2 columnas de igual ancho */
  gap:36px;
  margin-top:52px;
  animation:rise .5s ease both; /* animación de aparición al mostrarse */
}
/* Define cómo se ve la animación "rise": empieza transparente
   y un poco más abajo, termina visible y en su posición normal */
@keyframes rise{from{opacity:0;transform:translateY(10px);}to{opacity:1;transform:translateY(0);}}
/* Si el usuario tiene activado "reducir movimiento" en su sistema
   (accesibilidad), se desactiva la animación por respeto a esa preferencia */
@media (prefers-reduced-motion: reduce){.results{animation:none;}}

.results h2{margin:0 0 18px;font-size:1rem;font-weight:500;}

/* Las "etiquetas" moradas/moradas-claras que dicen
   "Más pobladas" / "Menos pobladas" */
.tag{
  display:inline-flex;
  align-items:center;
  gap:8px;
  font-family:'IBM Plex Mono',monospace;
  font-size:.78rem;
  letter-spacing:.06em;
  text-transform:uppercase;
  padding:6px 12px;
  border-radius:999px; /* número muy alto = bordes totalmente redondeados (forma de píldora) */
}
.tag-high{background:var(--violet);color:#fff;}
.tag-low{background:var(--violet-pale);color:var(--violet-deep);}

/* Lista de ciudades (contenedor) */
.bar-list{list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:14px;}

/* Cada fila individual: nombre de ciudad + población + barra */
.bar-row{
  display:grid;
  grid-template-columns:1fr auto; /* col 1: se estira, col 2: se ajusta al contenido */
  gap:3px 12px;
  align-items:center;
}
.bar-row .city-name{font-size:.9rem;font-weight:500;}
.bar-row .city-pop{
  font-family:'IBM Plex Mono',monospace; /* números en fuente monoespaciada, se ven más "de datos" */
  font-size:.8rem;
  color:var(--ink-soft);
  white-space:nowrap; /* evita que el número se corte en dos líneas */
}

/* El "carril" gris de la barra (el fondo, siempre al 100%) */
.bar-track{
  grid-column:1/-1; /* ocupa las 2 columnas del grid (todo el ancho), queda debajo del nombre/número */
  height:8px;
  background:var(--violet-pale);
  border-radius:999px;
  overflow:hidden; /* recorta el relleno para que no se salga del carril redondeado */
}

/* El relleno de la barra: empieza en 0% de ancho y JavaScript
   luego le pone su ancho real (ver función playBars más abajo) */
.bar-fill{
  height:100%;
  border-radius:999px;
  width:0;
  transition:width .7s cubic-bezier(.16,1,.3,1); /* animación suave al crecer */
}
.bar-fill.high{background:linear-gradient(90deg,var(--violet),var(--gold));} /* barras de "más pobladas": degradado morado a dorado */
.bar-fill.low{background:var(--violet-deep);opacity:.55;}                    /* barras de "menos pobladas": morado oscuro, más apagado */

/* Mensaje que aparece si el país seleccionado no tiene ciudades */
.empty-state{
  margin-top:52px;
  padding:28px;
  border:1.5px dashed var(--line);
  border-radius:16px;
  text-align:center;
  color:var(--ink-soft);
  font-size:.95rem;
}

/* Ajustes para pantallas pequeñas (celulares):
   las 2 columnas de resultados pasan a 1 sola columna,
   y el panel del selector pasa de horizontal a vertical */
@media (max-width:640px){
  .results{grid-template-columns:1fr;}
  .selector-panel{flex-direction:column;align-items:flex-start;}
}
</style>
</head>
<body>
<main class="page">
  <p class="eyebrow">Consulta en vivo</p>
  <h1>Explorador de<br><em>población mundial</em></h1>
  <p class="lede">Elige un país y descubre cuáles son hoy sus ciudades con mayor y menor número de habitantes.</p>

  <section class="selector-panel">
    <!-- El sello circular: arranca en "??" y JavaScript le pone
         el código del país cuando el usuario elige uno -->
    <div class="stamp" id="stamp" aria-hidden="true"><span id="stamp-code">??</span></div>

    <div class="selector-field">
      <label for="country">País de destino</label>
      <select id="country" required>
        <option value="">Selecciona un país…</option>

        <!-- Esto es código Blade (motor de plantillas de Laravel), no HTML normal.
             La directiva @@foreach recorre uno por uno todos los países que el
             controlador CityController envió a esta vista (la variable $countries
             viene de la base de datos), y genera un <option> por cada país. -->
        @foreach ($countries as $country)
          <option value="{{ $country->Code }}">{{ $country->Name }}</option>
        @endforeach
      </select>
    </div>
  </section>

  <!-- Esta sección empieza oculta (hidden) y JavaScript la muestra
       solo después de que el usuario elige un país con ciudades -->
  <section id="results" class="results" hidden>
    <div>
      <h2><span class="tag tag-high">Más pobladas</span></h2>
      <ol id="top-cities" class="bar-list"></ol>
    </div>
    <div>
      <h2><span class="tag tag-low">Menos pobladas</span></h2>
      <ol id="bottom-cities" class="bar-list"></ol>
    </div>
  </section>

  <p id="no-data" class="empty-state" hidden>Este país todavía no tiene ciudades registradas en la base de datos.</p>
</main>

<script>
/* ============================================
   Referencias a los elementos del HTML que
   vamos a necesitar leer o modificar con JS
   ============================================ */
const select = document.getElementById('country');
const resultsSection = document.getElementById('results');
const noData = document.getElementById('no-data');
const stamp = document.getElementById('stamp');
const stampCode = document.getElementById('stamp-code');
const topList = document.getElementById('top-cities');
const bottomList = document.getElementById('bottom-cities');

/**
 * Recibe una lista de ciudades y devuelve el HTML de las filas
 * (una <li> por ciudad), calculando qué tan ancha debe ser
 * cada barra según la población.
 *
 * @param {Array} cities  - lista de ciudades [{Name, Population}, ...]
 * @param {string} variant - 'high' o 'low', para pintar la barra
 *                            de un color u otro (ver CSS .bar-fill.high / .low)
 */
function buildBars(cities, variant){
  // Busca la población más alta del grupo: será nuestro 100%
  const max = Math.max(...cities.map(c => c.Population));

  return cities.map(c => {
    // Regla de 3: population / max * 100 = qué % representa esta ciudad.
    // El Math.max(..., 4) asegura un mínimo de 4% de ancho,
    // para que ninguna barra quede invisible aunque la ciudad sea muy pequeña.
    const pct = max > 0 ? Math.max((c.Population / max) * 100, 4) : 4;

    return `<li class="bar-row">
      <span class="city-name">${c.Name}</span>
      <span class="city-pop">${c.Population.toLocaleString('es-CO')}</span>
      <span class="bar-track"><span class="bar-fill ${variant}" style="width:0%" data-target="${pct}%"></span></span>
    </li>`;
  }).join(''); // une todas las filas en un solo bloque de texto HTML
}

/**
 * Hace que las barras "crezcan" con animación en vez de aparecer
 * ya llenas de golpe. Las barras se crean con width:0% (ver arriba)
 * y aquí, un instante después, se les asigna su ancho real guardado
 * en data-target — el navegador anima ese cambio automáticamente
 * gracias al "transition: width" que está definido en el CSS.
 */
function playBars(container){
  const fills = container.querySelectorAll('.bar-fill');
  // requestAnimationFrame (doble, para asegurar que el navegador
  // ya "pintó" el ancho en 0% antes de cambiarlo) programa el
  // cambio para el siguiente frame de animación del navegador
  requestAnimationFrame(() => {
    requestAnimationFrame(() => {
      fills.forEach(f => { f.style.width = f.dataset.target; });
    });
  });
}

/* ============================================
   EVENTO PRINCIPAL: se ejecuta cada vez que el
   usuario elige un país distinto en el <select>
   ============================================ */
select.addEventListener('change', function () {
  const code = this.value; // código del país elegido (ej: "COL")

  // Si el usuario vuelve a la opción vacía ("Selecciona un país…"),
  // ocultamos todo y reseteamos el sello
  if (!code) {
    resultsSection.hidden = true;
    noData.hidden = true;
    stamp.classList.remove('active');
    stampCode.textContent = '??';
    return;
  }

  // Actualiza el sello con el código del país y lo activa (color dorado)
  stampCode.textContent = code;
  stamp.classList.add('active');

  // Le pide al servidor (Laravel) las ciudades de ese país.
  // Esta ruta la maneja CityController@byCountry, definida en web.php
  fetch(`/cities/${code}`)
    .then(response => response.json()) // convierte la respuesta a un objeto JS
    .then(cities => {
      // Si el país no tiene ciudades en la base de datos, mostramos el aviso
      if (!cities.length) {
        resultsSection.hidden = true;
        noData.hidden = false;
        return;
      }

      noData.hidden = true;
      resultsSection.hidden = false;

      // Como el backend ya nos manda las ciudades ordenadas de mayor a
      // menor población, tomamos las primeras 10 (las más grandes)...
      const topCities = cities.slice(0, 10);
      // ...y las últimas 10 (las más pequeñas), invirtiendo el orden
      // para que se lean de menor a mayor dentro de esa lista
      const bottomCities = cities.slice(-10).reverse();

      // Genera el HTML de cada lista y lo inserta en la página
      topList.innerHTML = buildBars(topCities, 'high');
      bottomList.innerHTML = buildBars(bottomCities, 'low');

      // Dispara la animación de crecimiento de las barras
      playBars(topList);
      playBars(bottomList);
    })
    .catch(err => console.error('Error al consultar ciudades:', err));
});
</script>
</body>
</html>
