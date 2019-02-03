<?php require_once("../header.php") ?>
<div class="container">
    <div class="row">
    <div class="col">
        <h2>7. Notificari push (push notifications)</h2>

        <p>Interfata Push permite aplicatiilor web abilitatea de a primi mesaje trimise de catre server, indiferent daca aplicatia web este activa, in fundal, sau daca este inchisa. Aceasta functionalitate permite programatorilor sa ofere notificari asincron si actualizari catre utilizatorii abonati la serviciul de notificari, implicand mai des utilizatorii oferindu-le continut nou.</p>
        <p>O notificare este un mesaj care apare pe ecranul dispozitivului folosit de utilizator. Aceste notificari pot fi declansate local in aplicatie, sau pot fi "impinse" de catre server catre utilizator chiar si cand aplicatia este inchisa. Asta permite utilizatorilor sa se aboneze la actualizari periodice si permite programatorilor sa aduca din nou utilizatorii in aplicatie pri oferirea de continut nou.</p>

        <p>
            <div class="alert alert-info" role="alert">
            <i class="material-icons"> info </i>
            API-ul Push permite fiserului Service Worker sa manuiasca mesajele Push primite de la server, chiar si cand aplicatia nu este activa.
          </div>  
        </p>

        <p>Suportul browserelor pentru API-ul Push poate fi verificat aici: <a href="https://caniuse.com/#search=push%20notifications" target="_blank">Suportul browserelor pentru API-ul Push</a></p>

        <figure class="figure">
          <a href="https://caniuse.com/#search=push%20notifications" target="_blank">
            <img src="<?php echo ROOT ?>img/push-api-browser-support.png" class="figure-img img-fluid rounded" alt="Suportul browserelor pentru API-ul Push">
          </a>
          <figcaption class="figure-caption">Suportul browserelor pentru API-ul Push</figcaption>
        </figure>

        <p>Notificarile Push permit aplicatiei PWA sa se extinda dincolo de browser, si reprezinta un mod foarte eficient de a interactiona cu utilizatorii. Acestea pot alerta utilizatorii cu privire la evenimente importante si pot afisa o iconita si o descriere scurta pe care utilizatorii pot da click pentru a deschide website-ul si a vizualiza informatia respectiva.</p>
        <p>API-ul de notificari Push permite afisarea de notificari folosind acelasi mecanism pe care aplicatiile native il folosesc, oferind un aspect identic. Mai jos modul de lucru.</p>

        <h4>Verificam suportul browserului</h4>
        <p>Momentan nu toate browserele permit notificari de tip push.</p>
        <pre><code class="language-javascript">
if ('Notification' in window && navigator.serviceWorker) {
  // Aici se poate afisa un buton pe care 
  // utilizatorul sa il apese pentru a se abona la notificari
}
        </code></pre>

        <h4>Cerere permisiune</h4>
        <p>Inainte de a crea o notificare trebuie sa cerem permisiunea utilizatorului de abonare la notificari.</p>
        <pre><code class="language-javascript">
Notification.requestPermission(function(status) {
    console.log('Statusul notificarilor s-a modificat in:', status);
});
        </code></pre>

        <h4>Verificare permisiune</h4>
        <p>Statusul abonarii unui utilizator la abonari se poate schimba asa ca vom verifica de fiecare data daca utilizatorul inca este abonat.</p>
        <pre><code class="language-javascript">
if (Notification.permission === "granted") {
  /* Aici putem afisa o notificare */
} else if (Notification.permission === "blocked") {
 /* Utilizatorul nu doreste notificari si nu ii putem cere din nou permisiunea. */
} else {
  /* Aici putem cere permisiunea de abonare */
}
        </code></pre>

        <h4>Afisarea unei notificari</h4>
        <p>Putem afisa o notificare din din fisierele Javascript ale aplicatiei folosind functia "showNotification" care este apelata folosind obiectul service worker-ului inregistrat. Aceasta creeeaza o notificare in service worker-ul activ, in asa fel incat evenimentele declansate de utilizator prin interactiunea cu notificarea sa poata fi captate de service worker.</p>
        <pre><code class="language-javascript">
if (Notification.permission == 'granted') {
    navigator.serviceWorker.getRegistration().then(function(reg) {
      reg.showNotification('Hello world!'); // Afisam notificare
    });
}
        </code></pre>

        <h4>Optiuni</h4>
        <p>Functia "showNotification" are un parametru secundar ce permite configurarea notificarii.</p>
        <pre><code class="language-javascript">
if (Notification.permission == 'granted') {
    navigator.serviceWorker.getRegistration().then(function(reg) {
      var options = {
        body: 'Tocmai am postat un articol nou pe blog', // Adauga o descriere scurta notificarii
        icon: 'images/example.png', // Ataseaza o imagine pentru a face notificarea mai interesanta
        vibrate: [100, 50, 100], // Specifica un tipar de vibratii pentru notificarea curenta 
        data: {  // Ataseaza date personalizate notificarii
          dateOfArrival: Date.now(),
          primaryKey: 1
        }
      };
      reg.showNotification('Postare noua!', options);
    });
}
        </code></pre>

        <h4>Cum actionam la raspunsul utilizatorilor</h4>
        <p>Cand utilizatorul inchide notificarea evenimentul <strong>notificationclose</strong>  se declanseaza  in interiorul fisierului Service Worker.</p>
        <pre><code class="language-javascript">
self.addEventListener('notificationclose', function(e) {
  var notification = e.notification;
  var primaryKey = notification.data.primaryKey;

  console.log('Notificarea a fost inchisa: ' + primaryKey);
});
        </code></pre>
        <p>Daca utilizatorul apasa pe notificare, asta declanseaza evenimentul <strong>notificationclick</strong> in interiorul fisierului Service Worker</p>
        <pre><code class="language-javascript">
self.addEventListener('notificationclick', function(e) {
  var notification = e.notification;
  var primaryKey = notification.data.primaryKey;
  var action = e.action;

  if (action === 'close') {
    notification.close();
  } else {
    // Redirectionam utilizatorul catre pagina aferenta
    clients.openWindow('http://www.example.com');
    notification.close(); // Inchidem notificarea
  }
});
        </code></pre>
        
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item backward">
                    <a class="page-link" href="<?php echo ROOT ?>background-sync/" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="paginationDesc">Sincronizare pe fundal</span>
                    </a>
                </li>
                <li class="page-item forward">
                    <a class="page-link" href="<?php echo ROOT ?>native-device-features/" aria-label="Next">
                        <span class="paginationDesc">Functionalitati native</span>
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    </div>
</div>
<?php require_once("../footer.php") ?>
