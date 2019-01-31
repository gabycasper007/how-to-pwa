<?php require_once("../header.php") ?>
<div class="container">
  <div class="row">
    <div class="col">
      <h2>3. Lucratori de servicii (Service Workers)</h2>
      <p>Functionalitati care pana acum existau doar in aplicatiile mobile native sunt acum accesibile si pentru website-uri. Aceste functionalitati includ: sincronizare pe fundal, notificari push si utilizarea site-ului chiar si cand nu mai ai acces la internet. Fisierele de tip Service Worker ofera fundatia tehnica pe care aceste functionalitati se bazeaza.</p>
      <p>Folosind un service worker aplicatia web poate functiona 100% offline, se poate incarca multa mai repede si poate avea un aspect asemanator unei aplicatii mobile native.</p>
      <ul>
          <li><a href="#what-is-a-service-worker">Ce reprezinta un Service Worker</a></li>
          <li><a href="#register-a-service-worker">Cum inregistram un Service Worker</a></li>
          <li><a href="#install-a-service-worker">Cum instalam un Service Worker</a></li>
          <li><a href="#cache-and-return-requests">Cum salvam resursele in cache</a></li>
          <li><a href="#dynamic-caching">Cache dinamic</a></li>
          <li><a href="#delete-old-caches">Cum stergem cache-ul vechi</a></li>
      </ul>

      <p>Fisierele de tip Service Worker pot fi vizualizate si administrate in Google Chrome folosind Developer Tools si accesand Application -> Service Workers</p>

      <figure class="figure">
        <img src="<?php echo ROOT ?>img/service-workers-file.png" class="figure-img img-fluid rounded" alt="service workers file">
        <figcaption class="figure-caption">Service Worker</figcaption>
      </figure>

      <p>
          Suportul browserelor pentru fisierele de tip Service Worker poate fi vizualizat aici: <a href="https://caniuse.com/#search=service%20workers" target="_blank">Suport pt Service Workers</a>.
      </p>

      <figure class="figure">
        <a href="https://caniuse.com/#search=service%20workers" target="_blank">
            <img src="<?php echo ROOT ?>img/service-workers.png" class="figure-img img-fluid rounded" alt="Suport pt Service Workers">
        <figcaption class="figure-caption"><a href="https://caniuse.com/#search=service%20workers" target="_blank">Suport pt Service Workers</a></figcaption>
      </figure>
      
      <h4 id="what-is-a-service-worker">Ce este un Service Worker</h4>
      <p>Un Service Worker este un fisier Javascript pe care browserul il ruleaza pe fundal, separat de pagina web, ce poate fi folosit pentru functionalitati care nu necesita pagina web sa fie deschisa. Astazi aceste functionalitati includ notificari push si sincronizare pe fundal. </p>
      <p>Fisierele de tip Service Worker ruleaza pe un fir (thread) separat de celelalte fisiere JavaScript ale aplicatiei, si nu au access la nodurile HTML (DOM). Din aceste motive, fisierele de tip Service Worker nu blocheaza cursul aplicatiei si poate trimite si primi comunicari cu diferite contexte.</p>
      <div class="alert alert-info" role="alert">
            <i class="material-icons"> done </i>
            Motivul pentru care aceste fisiere sunt interesante este pentru ca ofera aplicatiilor posibilitatea de a functiona offline si ofera programatorilor control detaliat asupra modalitatii de folosire a cache-ului si a resurselor.
      </div>
      <p>Un Service Worker poate insa face mai mult decat sa ofere functionalitati offline. Acesta poate  including manevra notificari si poate face calcule costisitoare pe un thread separat. De asemenea pot manipula solicitarile de resurse din retea, le poate modifica, poate servi raspunsuri personalizate luate din cache si poate sintetiza raspunsuri noi.</p>

      <h4 id="register-a-service-worker">Cum inregistram un Service Worker</h4>

      <p>Urmatorul cod verifica mai intai daca browserul suport functionalitatea Service Worker, si daca da, fisierul Service Worker denumit /sw.js este inregistrat de indata ce pagina a fost incarcata.</p>
      <pre><code class="language-javascript">
if ('serviceWorker' in navigator) {
  window.addEventListener('load', function() {
    navigator.serviceWorker.register('/sw.js').then(
        function(reg) {
            console.log('SW Inregistrat', reg.scope);
        }, 
        function(err) {
            console.log('SW a esuat: ', err);
        }
    );
  });
}

</code></pre>

        <h4 id="install-a-service-worker">Cum instalam un Service Worker</h4>

        <p>Pentru a instala un Service Worker, trebuie sa definim o functie care sa fie apelata atunci cand evenimentul "install" este declansat. In acest moment putem adauga fisierele statice in cache.</p>
        <div>In interiorului functiei ce va fi apelata, vom face urmatoarele:</div>
        <ul>
            <li>Deschidem cache-ul.</li>
            <li>Salvam fisierele in cache.</li>
            <li>Confirmam daca toate fisierele au fost adaugate in cache.</li>
        </ul>

        <pre><code class="language-javascript">
const STATIC_CACHE_NAME = 'my-site-cache-v1';
var urlsToCache = [
  '/',
  '/styles/main.css',
  '/script/main.js'
];

self.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open(STATIC_CACHE_NAME)
      .then(function(cache) {
        console.log('Opened cache');
        return cache.addAll(urlsToCache);
      })
  );
});

</code></pre>
      <p>Acesta este un lant de promisiuni (caches.open() si cache.addAll()). Functia event.waitUntil() preia o promisiune si o foloseste pentru a afla cat dureaza instalarea si daca aceasta s-a efectuat cu succes.</p>
      
      <p>
        <div>Pentru mai multe detalii despre promisiuni, accesati <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Promise">Promise API</a></div>
        <div>Pentru mai multe detalii despre interfata Cache, accesati <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/API/Cache">Cache API</a></div>
        <div>Pentru mai multe detalii despre interfata Fetch, accesati <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API">Fetch API</a></div>
      </p>
      <div class="alert alert-danger" role="alert">
            <i class="material-icons"> warning </i>
            Daca toate fisierele sunt adaugate cu succes in cache, atunci fisierul service worker va fi instalat. Daca vreunul dintre fisiere nu a putut fi accesat pentru a putea fi adaugat in cache, atunci instalarea va esua.
      </div>
      <h4 id="cache-and-return-requests">Cum salvam resursele in cache</h4>
      <p>Dupa ce un Service Worker este instalat si utilizatorul navigheaza la o alta pagina sau reincarca aplicatia (refresh), fisierul Service Worker va incepe sa primeasca evenimente de tip fetch.</p>
      <pre><code class="language-javascript">
self.addEventListener('fetch', function(event) {
  event.respondWith( // Cu ce raspundem in momentul in care este cerut un fisier 
    caches.match(event.request)
      .then(function(response) {
        // Am gasit fisierul in cache, intoarcem raspunsul
        if (response) {
          return response;
        }
        // Nu am gasit fisierul in cache, incercam sa il obtinem de pe server
        return fetch(event.request);
      }
    )
  );
});
</code></pre>

    <p>Acest cod urmareste evenimentele de tip fetch (atunci cand browserul cere un fisier) si raspunde prin fisierul gasit in cache daca exista (prin caches.match()). Daca fisierul nu este in cache, va incerca sa il obtina de pe server.</p>

    <div class="alert alert-info" role="alert">
        <i class="material-icons"> done </i>
        Prin aceasta metoda practic folosim resursele salvate in cache in timpul instalarii fisierului Service Worker.
    </div>

    <h4 id="dynamic-caching">Cache dinamic</h4>
    <p>Daca vrem sa adaugam in cache noi cereri de resurse, putem face asta adaugand in cache raspunsul unei cereri de tip fetch.</p>
    <pre><code class="language-javascript">
self.addEventListener('fetch', function(event) {
  event.respondWith( // Cu ce raspundem in momentul in care este cerut un fisier 
    caches.match(event.request)
      .then(function(response) {
        // Am gasit fisierul in cache, intoarcem raspunsul
        if (response) {
          return response;
        }

        return fetch(event.request).then(
          function(response) {
            // Verificam daca raspunsul este valid
            if(!response || response.status !== 200 || response.type === "error") {
              return response;
            }

            // IMPORTANT: Clonam responsul pentru a-l putea consuma si browserul si cache-ul
            var responseToCache = response.clone();

            // Adaugam resursa in cache-ul dinamic
            caches.open(DYNAMIC_CACHE_NAME)
              .then(function(cache) {
                cache.put(event.request, responseToCache);
              });

            return response;
          }
        );
      })
    );
});

</code></pre>

    <p>Indata ce am primit un raspuns, efectuam urmatoarele verificari:
    <ul>
        <li>Verificam daca raspunsul este valid.</li>
        <li>Verificam daca statusul raspunsului este 200.</li>
        <li>Verificam daca tipul raspunsului este de baza (ceea ce indica ca fisierul este de pe website-ul nostru). Cererile de resurse catre alte site-uri nu vor fi adaugate in cache.</p></li>
    </ul>
    <p>Daca toate verificarile sunt in regula, clonam respunsul pentru a putea trimite unul catre browser si unul catre cache.</p>

    <h4 id="delete-old-caches">Cum stergem cache-ul vechi</h4>

    <p>Urmatorul cod va verifica in toate cache-urile aplicatiei si va sterge toate cache-urile care nu se afla in variabila "cacheWhitelist".</p>
    <pre><code class="language-javascript">
// Efectuam aceasta actualizare a cache-urilor in momentul in care fisierul Service Worker este activat, adica preia controlul paginii.
self.addEventListener('activate', function(event) {

  var cacheWhitelist = ['pages-cache-v1', 'blog-posts-cache-v1'];

  event.waitUntil(
    caches.keys().then(function(cacheNames) {
      return Promise.all(
        cacheNames.map(function(cacheName) {
          if (cacheWhitelist.indexOf(cacheName) === -1) {
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
});        
    </code></pre>
    
      <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item backward">
                <a class="page-link" href="<?php echo ROOT ?>web-app-manifest/" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="paginationDesc">Manifestarea aplicatiei</span>
                </a>
            </li>
            <li class="page-item forward">
                <a class="page-link" href="<?php echo ROOT ?>caching/" aria-label="Next">
                    <span class="paginationDesc">Cache</span>
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
      </nav>
    </div>
  </div>
</div>
<?php require_once("../footer.php") ?>
