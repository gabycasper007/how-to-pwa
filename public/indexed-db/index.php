<?php require_once("../header.php") ?>
<div class="container">
    <div class="row">
    <div class="col">
        <h2>5. IndexedDB</h2>

        <p>IndexedDB este un API pentru pastrarea in browser de cantitati semnificative de date structurate sub forma unei baze de date. Acest API foloseste indici pentru a permite cautari rapide de date. In timp ce API-ul <a href="https://developer.mozilla.org/en-US/docs/Web/API/Web_Storage_API" target="_blank">Web Storage</a> este util pentru a pastra cantitati mici de date, nu este deloc util pentru pastrarea de cantitati mari de date structurate.</p>
        <p>IndexedDB ofera posibilitatea de a salva persistent date in browserul utilizatorilor. Deoarece permite crearea aplicatiilor web cu abilitati importante de interogare indiferent de accesul la internet, aplicatiile care folosesc IndexedDB vor functiona atat online, cat si offline.</p>

        <p>Datele salvate in IndexedDB pot fi vazute in Google Chrome folosind Developer Tools si accesand Application -> Storage -> IndexedDB</p>

        <figure class="figure">
          <img src="<?php echo ROOT ?>img/indexedDB-storage.png" class="figure-img img-fluid rounded" alt="IndexedDB">
          <figcaption class="figure-caption">Datele din IndexedDB</figcaption>
        </figure>

        <p>Suportul browserelor pentru IndexedDB poate fi verificat la adresa: <a href="https://caniuse.com/#search=indexedDB" target="_blank">Suportul browserelor pentru IndexedDB</a></p>

        <figure class="figure">
          <a href="https://caniuse.com/#search=indexedDB" target="_blank">
            <img src="<?php echo ROOT ?>img/indexedDB-browser-support.png" class="figure-img img-fluid rounded" alt="Suportul browserelor pentru IndexedDB">
          </a>
          <figcaption class="figure-caption">Suportul browserelor pentru IndexedDB</figcaption>
        </figure>

        <p>Stergerea manuala a datelor din IndexedDB poate fi facuta in Google Chrome folosind Developer Tools si accesand Application -> Clear Storage -> Clear side data</p>

        <figure class="figure">
          <img src="<?php echo ROOT ?>img/deleting-cached-files.png" class="figure-img img-fluid rounded" alt="clear site data">
          <figcaption class="figure-caption">Stergerea datelor din IndexedDB</figcaption>
        </figure>

        <p>IndexedDB este un sistem de baze de date orientate obiect in JavaScript. IndexedDB permite salvarea si accesarea de obiecte, date, ce sunt indexate cu o cheie. </p>
        <p>Trebuie specificat structura bazei de date, deschisa o conexiune la baza de date, si apoi se pot accesa, salva, si actualiza date printr-o serie de tranzactii.</p>
        <p>Documentatia detaliata pentru IndexedDB poate fi gasita aici: <a href="https://developer.mozilla.org/en-US/docs/Web/API/IndexedDB_API" target="_blank">IndexedDB</a></p>

        <p>API-ul IndexedDB este puternic, insa este prea complicat pentru cazuri simple. Mai simplu este sa folosim o librarie Javascript ca <a href="https://localforage.github.io/localForage/" target="_blank">localForage</a> pentru simplificare.</p>
        <p>LocalForage includes a localStorage-backed fallback store for browsers with no IndexedDB or WebSQL support.</p>

        <h4>Cum instalam libraria localForage</h4>
        <p>Cea mai simpla metoda de a folosi localForage este de a include libraria in aplicatia noastra prin</p>
        <pre><code class="language-html">
&lt;script src="localforage.js"></script>
            </code></pre>

        <h4>Configurarea librariei localForage</h4>
        <p>Setam si persistam optiunile localForage. Acest cod trebuie sa fie inaintea oricarui alt cod ce foloseste libraria localForage:</p>
        <pre><code class="language-javascript">
// Redenumim baza de date din "localforage"
// in "Ghid PWA".
localforage.config({
    name: 'Ghid PWA'
});
            </code></pre>

        <h4>Adaugarea unui element in baza de date</h4>
        <p>Salvam date folosind codul:</p>
        <pre><code class="language-javascript">
localforage.setItem('cheie', 'valoare').then(function (value) {
    // Aici valoarea este salvata si putem executa alte instructiuni
    console.log(value);
}).catch(function(error) {
    // Acest cod va rula daca exista erori
    console.log(error);
});
            </code></pre>

        <h4>Accesarea unui element din baza de date</h4>
        <p>Daca elementul nu exista in baza de date, functia getItem() va intoarce valoarea null.</p>
        <pre><code class="language-javascript">
localforage.getItem('cheie').then(function(value) {
    // Aici valoarea este preluata
    console.log(value);
}).catch(function(err) {
    // Acest cod va rula daca exista erori
    console.log(err);
});
            </code></pre>

        <h4>Accesarea tuturor elementelor din baza de date</h4>
        <p>Itereaza peste toate perechile din baza de date.</p>
        <pre><code class="language-javascript">
localforage.iterate(function(value, key, iterationNumber) {
    // Codul de aici va fi executat pentru fiecare element din baza de date
    console.log([key, value]);
}).then(function() {
    console.log('Iteratia s-a terminat');
}).catch(function(err) {
    // Acest cod va rula daca exista erori
    console.log(err);
});
            </code></pre>

        <h4>Stergerea unui element din baza de date</h4>
        <pre><code class="language-javascript">
localforage.removeItem('cheie').then(function() {
    // Codul de aici ruleaza cand elementul a fost sters
    console.log('Elementul a fost sters!');
}).catch(function(err) {
    // Acest cod va rula daca exista erori
    console.log(err);
});
            </code></pre>

        <h4>Stergerea tuturor elementelor din baza de date</h4>
        <pre><code class="language-javascript">
localforage.clear().then(function() {
    // Codul de aici va rula dupa ce baza de date a fost golita.
    console.log('Baza de date este acum goala.');
}).catch(function(err) {
    // Acest cod va rula daca exista erori
    console.log(err);
});
            </code></pre>
        
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item backward">
                    <a class="page-link" href="<?php echo ROOT ?>caching/" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="paginationDesc">Cache</span>
                    </a>
                </li>
                <li class="page-item forward">
                    <a class="page-link" href="<?php echo ROOT ?>background-sync/" aria-label="Next">
                        <span class="paginationDesc">Sincronizare pe fundal</span>
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    </div>
</div>
<?php require_once("../footer.php") ?>
