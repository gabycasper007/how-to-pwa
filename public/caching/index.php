<?php require_once("../header.php") ?>
<div class="container">
    <div class="row">
    <div class="col">
        <h2>4. Cache</h2>

        <p>Un avantaj principal al <a href="https://developer.mozilla.org/en-US/docs/Web/API/Cache" target="_blank">Cache API</a> este ca ofera mai mult control asupra fisierelor salvate in cache decat cache-ul standard al browserelor. De exemplu, un Service Worker poate adauga in cache mai multe resurse atunci cand utilizatorul porneste pentru prima oara aplicatia PWA, inclusiv pagini nevizitate inca.</p>
        <p>Aceasta va mari viteza de incarcare a aplicatiei la urmatoarele folosiri. Putem de asemenea sa implementam propriul cod pentru manipularea cache-ului, asigurandu-ne ca resursele importante sunt pastrate in cache, in timp ce resursele mai putin importante pot fi sterse din cache.</p>

        <p>Fisierele salvate in cache pot fi vazute in Google Chrome folosind Developer Tools si intrand la Application -> Cache -> Cache Storage</p>

        <figure class="figure">
          <img src="<?php echo ROOT ?>img/cached-files.png" class="figure-img img-fluid rounded" alt="Fisiere adaugate in cache">
          <figcaption class="figure-caption">Fisiere adaugate in cache</figcaption>
        </figure>

        <p>Cache API este o tehnologie inca in stadiu experimental. Suportul in diferite browsere poate fi vizualizat aici: <a href="https://developer.mozilla.org/en-US/docs/Web/API/Cache#Browser_compatibility" target="_blank">Suportul browserelor pentru Cache API</a></p>

        <figure class="figure">
          <a href="https://developer.mozilla.org/en-US/docs/Web/API/Cache#Browser_compatibility" target="_blank">
            <img src="<?php echo ROOT ?>img/cache-api-browser-support.png" class="figure-img img-fluid rounded" alt="cache api browser support">
          </a>
          <figcaption class="figure-caption">Suportul browserelor pentru Cache API</figcaption>
        </figure>

        <p>Stergerea manuala a fisierelor din cache poate fi facuta in Google Chrome folosind Developer Tools si mergand la Application -> Clear Storage -> Clear side data</p>

        <figure class="figure">
          <img src="<?php echo ROOT ?>img/deleting-cached-files.png" class="figure-img img-fluid rounded" alt="clear site data">
          <figcaption class="figure-caption">Stergere cache</figcaption>
        </figure>

        <p>Pentru a folosi fisierele din cache, trebuie sa specificam in fisierul Service Worker cum si cand sa le accesam. Mai jos sunt cateva tipare pentru manipularea solicitarilor de resurse web:</p>

        <h4>Servirea fisierelor doar din cache</h4>
        <p>Ideal pentru: toate fisiere statice principale in afisarea aspectului aplicatiei. Aceste fisiere au fost adaugate in cache in momentul intalarii aplicatiei folosind evenimentul "install" <em>(vezi <a href="<?php echo ROOT ?>service-workers/#install-a-service-worker">Cum instalam un Service Worker</a>)</em>.</p>

        <pre><code class="language-javascript">
self.addEventListener('fetch', (event) => {
  event.respondWith(caches.match(event.request));
});        
        </code></pre>

        <h4>Servirea fisierelor doar de pe server</h4>
        <p>Ideal pentru: Solicitari care nu au alternativa offline, ca trimiterea unui formular (solicitare POST), pinguri analytics, etc.</p>

        <pre><code class="language-javascript">
self.addEventListener('fetch', (event) => {
  event.respondWith(fetch(event.request));
});      
        </code></pre>

        <h4>Cache, apoi server daca nu exista in cache</h4>
        <p>Ideal pentru: daca vrei ca aplicatia sa functioneze offline, aceasta va fi metoda cea mai folosita. Celelalte tipare vor fi doar exceptii in functie de cerere.</p>

        <pre><code class="language-javascript">
self.addEventListener('fetch', (event) => {
  event.respondWith(async function() {
    const response = await caches.match(event.request);
    return response || fetch(event.request);
  }());
});
        </code></pre>

        <h4>Competitie intre cache si server</h4>
        <p>Ideal pentru: resurse mici servite pe dispozitive care acceseaza greu dispozitivul principal de stocare al datelor.</p>

        <pre><code class="language-javascript">
function promiseAny(promises) {
  return new Promise((resolve, reject) => {
    // ne asiguram ca toate sunt promisiuni
    promises = promises.map(p => Promise.resolve(p));
    // rezolvam aceasta functie in momentul in care oricare dintre promisiuni a fost indeplinita
    promises.forEach(p => p.then(resolve));
    // afisam eroare daca nicio promisiune nu a fost indeplinita
    promises.reduce((a, b) => a.catch(() => b))
      .catch(() => reject(Error("All failed")));
  });
};

self.addEventListener('fetch', (event) => {
  event.respondWith(
    promiseAny([
      caches.match(event.request),
      fetch(event.request)
    ])
  );
});
        </code></pre>

        <h4>Server, apoi cache daca suntem offline</h4>
        <p>Ideal pentru: resurse care se actualizeaza frecvent ca articole, avatare, cronologii social media (timeline), lista cu numarul de puncte intr-un joc, etc.</p>

        <p>
            <div class="alert alert-danger" role="alert">
            <i class="material-icons"> warning </i>
            Atentie! Daca utilizatorul are conexiune lenta sau intermitenta la internet va fi nevoie sa astepte mai intai ca accesul la acele resurse sa esueze inainte sa vada continutul din cache. Aceasta poate dura foarte mult si este o experienta frustranta pentru utilizatori. Tiparul urmatori reprezinta o solutie mai eficienta.
            </div>  
        </p>

        <pre><code class="language-javascript">
self.addEventListener('fetch', (event) => {
  event.respondWith(async function() {
    try {
      return await fetch(event.request);
    } catch (err) {
      return caches.match(event.request);
    }
  }());
});
        </code></pre>
        
        <h4>Cache apoi server</h4>
        <p>Ideal pentru: resurse care se actualizeaza frecvent ca articole, avatare, cronologii social media (timeline), lista cu numarul de puncte intr-un joc. Acest tipar face doua cereri, una catre cache, una catre server. Afisam mai intai datele din cache, apoi actualizam pagina cand si daca datele de pe server pot fi accesate.</p>

        <pre><code class="language-javascript">
async function update() {
  // Efectuam cererea catre server
  const networkPromise = fetch('/data.json');

  startSpinner();

  const cachedResponse = await caches.match('/data.json');
  if (cachedResponse) await displayUpdate(cachedResponse);

  try {
    const networkResponse = await networkPromise;
    const cache = await caches.open('mysite-dynamic');
    cache.put('/data.json', networkResponse.clone());
    await displayUpdate(networkResponse);
  } catch (err) {
    // Aici putem anunta utilizatorul ca are acces limitat la internet
  }

  stopSpinner();

  const networkResponse = await networkPromise;

}

async function displayUpdate(response) {
  const data = await response.json();
  updatePage(data);
}
        </code></pre>
        
        <h4>Pagina de rezerva</h4>
        <p>Daca nu gasim un fisier nici in cache, nici pe server atunci afisam pagina de rezerva in care anuntam utilizatorul ca are acces limitat la internet, iar pagina ceruta nu este disponibila in cache. Ideal pentru: imagini secundare ca avatare si pagini care anunta ca resursele nu sunt disponibile offline.</p>

        <pre><code class="language-javascript">
self.addEventListener('fetch', (event) => {
  event.respondWith(async function() {
    // Cautam mai intai in cache
    const cachedResponse = await caches.match(event.request);
    if (cachedResponse) return cachedResponse;

    try {
      // Cautam ulterior pe server
      return await fetch(event.request);
    } catch (err) {
      // Daca ambele metode esueaza, afisam o pagina de rezerva:
      return caches.match('/offline.html');
    }
  }());
});

        </code></pre>
        
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item backward">
                    <a class="page-link" href="<?php echo ROOT ?>service-workers/" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="paginationDesc">Lucratori de servicii</span>
                    </a>
                </li>
                <li class="page-item forward">
                    <a class="page-link" href="<?php echo ROOT ?>indexed-db/" aria-label="Next">
                        <span class="paginationDesc">IndexedDB</span>
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    </div>
</div>
<?php require_once("../footer.php") ?>
