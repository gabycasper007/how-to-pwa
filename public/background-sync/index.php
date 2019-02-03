<?php require_once("../header.php") ?>
<div class="container">
    <div class="row">
    <div class="col">
        <h2>6. Sincronizare pe fundal (Background Sync)</h2>

        <p>Background Sync este un API nou ce permite amanarea actiunilor pana cand utilizatorul are acces stabil la internet. Aceasta functionalitate ajuta aplicatia sa functioneze cursiv, iar ceea ce doreste sa posteze utilizatorul chiar sa ajunga pe server. Utilizatorul poate inchide accesul la internet si chiar browserul, iar ceea ce a dorit sa posteze se va trimite catre server cand dispozitivul va avea din nou acces la internet.</p>
        <p>Fisierele de tip Service Worker ofera functionalitate offline si cresc dramatic viteza de incarcare a aplicatiei folosind cache-ul. Chiar daca aceasta functionalitate este foarte utila, pana la API-ul Background Sync nu a existat o posibilitate ca pagina sa trimita ceva catre server fara conexiune la internet, insa noul API Background Sync tocmai pentru aceasta a fost creeat.</p>

        <p>Suportul browserelor pentu API-ul Background Sync poate fi verificat aici: <a href="https://caniuse.com/#search=background%20sync%20api" target="_blank">Suport browsere Background Sync</a></p>

        <figure class="figure">
          <a href="https://caniuse.com/#search=background%20sync%20api" target="_blank">
            <img src="<?php echo ROOT ?>img/background-sync-api.png" class="figure-img img-fluid rounded" alt="Suport browsere Background Sync">
          </a>
          <figcaption class="figure-caption">Suport browsere Background Sync</figcaption>
        </figure>

        <p>Cand scriem un email, un mesaj pe Facebook, WhatsApp, Twitter, etc., aplicatia are nevoie sa trimita mesajul catre server. Daca nu poate face asta din cauza lipsei conexiunii la internet, aplicatia poate salva mesajul intr-o sectiune numita "outbox" pentru a incerca mai tarziu.</p>

        <p>
            <div class="alert alert-info" role="alert">
            <i class="material-icons"> info </i>
            Din nefericire, in browser sectiuna "outbox" poate fi procesata doar in timp ce website-ul este afisat in contextul unui browser. Aceasta situatie este problematica in mod special pe dispozitivele mobile, unde utilizatorii inchid deseori browserele pentru a elibera memoria dispozitivului.
            </div>  
        </p>

        <p>Platformele aplicatiilor mobile native ofera API-uri care pot programa sarcini. Aceste API-uri permit programatorilor sa colaboreze cu sistemul de operare pentru procesari in fundal. API-ul Background Sync a fost creat pentru a oferi calitati similare pentru website-uri.</p>

        <h4>Pentru ce putem folosi API-ul Background Sync?</h4>

        <p>In mod ideal, il putem folosi pentru a programa trimiterea datelor care nu dorim sa se piarda atunci cand dispozitivul folosit nu mai are acces la internet ca de exemplu mesaje, email-uri, documente incarcate, setari salvate, poze... orice dorim sa ne asiguram ca ajunge pe server chiar daca utilizatorul inchide aplicatia sau nu mai are acces la internet. Aplicatia le poate salva folosind indexedDB, iar fisierul Service Worker le va accesa si le va trimite catre server.</p>

        <p>
            <div class="alert alert-danger" role="alert">
            <i class="material-icons"> warning </i>
            API-url Background Sync nu este disponibil pentru toate aplicatiile, chiar daca acestea folosesc SSL. Browserele pot alege sa limiteze aplicatiiile care pot folosi aceasta functionalitate in functie de anumite semnale legate de calitatea aplicatiei.
            </div>  
        </p>
    
        <h4>Solicitarea unei sincronizari</h4>
        <pre><code class="language-javascript">
navigator.serviceWorker.ready.then(function(registration) {
  registration.sync.register('outbox').then(function() {
    // Inregistrarea a fost facuta cu succes
  }, function() {
    // Inregistrarea a esuat
  });
});
        </code></pre>

        <h4>Interceptarea unei cereri de sincronizare</h4>
        <pre><code class="language-javascript">
self.addEventListener('sync', function(event) {
  if (event.tag == 'outbox') {
    event.waitUntil(sendEverythingInTheOutbox());
  }
});
        </code></pre>

        <p>Evenimentul "sync" va fi declansat in momentul in care browserul considera ca dispozitivul are acces la internet.</p>

        <h4>Sincronizare periodica (in lucru)</h4>

        <p>Unele aplicatii mobile native de stiri sau social media (ex. Twitter) ofera continut actualizat fara ca utilizatorul sa ceara explicit.</p>
        <p>Folosind sincronizarea periodica, vor putea si website-uri sa ofere aceasta functionalitate. De exemplu daca telefonul mobil are setata o alarma, fisierul Service Worker poate solicita prin API-ul Background Sync actualizarea aplicatiei PWA la un minut inainte, pentru a oferi utilizatorului informatii actualizate de la website-ul preferat.</p>

        <h4>Solicitarea unei sincronizari periodice</h4>
        <pre><code class="language-javascript">
navigator.serviceWorker.ready.then(function(registration) {
  registration.periodicSync.register({
    tag: 'get-latest-news',         
    minPeriod: 12 * 60 * 60 * 1000, 
    powerState: 'avoid-draining',   
    networkState: 'avoid-cellular' 
  }).then(function(periodicSyncReg) {
    // Succes
  }, function() {
    // Eroare
  })
});
        </code></pre>

        <h4>Interceptarea unei cereri de sincronizare periodica</h4>
        <pre><code class="language-javascript">
self.addEventListener('periodicsync', function(event) {
  if (event.registration.tag == 'get-latest-news') {
    event.waitUntil(fetchAndCacheLatestNews());
  }
  else {
    // asa putem sterge cererea de sincronizare
    event.registration.unregister();
  }
});
        </code></pre>

        <p>Functia de tip promisiune pasata functiei waitUntil reprezinta un semnal pentru browser ca evenimentul de sincronizare este in lucru si cere ca fisierul Service Worker sa fie activ. Respingerea evenimentului semnaleaza browserului ca evenimentul de sincronizare a esuat.</p>
        
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item backward">
                    <a class="page-link" href="<?php echo ROOT ?>indexed-db/" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="paginationDesc">IndexedDB</span>
                    </a>
                </li>
                <li class="page-item forward">
                    <a class="page-link" href="<?php echo ROOT ?>push-notifications/" aria-label="Next">
                        <span class="paginationDesc">Notificari Push</span>
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    </div>
</div>
<?php require_once("../footer.php") ?>
