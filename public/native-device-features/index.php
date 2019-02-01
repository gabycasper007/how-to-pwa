<?php require_once("../header.php") ?>
<div class="container">
    <div class="row">
    <div class="col">
        <h2>8. Functionalitati native dispozitivelor mobile</h2>

        <h3>a) API-ul Stream</h3>

        <p>Functia getUserMedia() din API-ul Stream cere utilzatorului accesul la camera foto/video si la microfonul dispozitivului mobil.</p>
        <p>Suportul browserelor pentru API-ul Stream poate fi verificat aici: <a href="https://caniuse.com/#search=stream%20api" target="_blank">suportul pentru Stream API</a></p>

        <figure class="figure">
          <a href="https://caniuse.com/#search=stream%20api" target="_blank">
            <img src="<?php echo ROOT ?>img/stream-api.png" class="figure-img img-fluid rounded" alt="suportul pentru Stream API">
          </a>
          <figcaption class="figure-caption">suportul pentru Stream API</figcaption>
        </figure>

        <h4>Obtinerea accesului la media (camera/microfon)</h4>
        <pre><code class="language-javascript">
navigator.mediaDevices.getUserMedia(constraints)
.then(function(stream) {
  /* aici avem acces */
})
.catch(function(err) {
  /* aici avem eroare */
});
        </code></pre>

        <h4>Aplicarea de constrangeri</h4>
        <p>O aplicatie poate cere ca microfonul sau camera sa functioneze sub urmatoarele constrangeri</p>
        <pre><code class="language-javascript">
{
  audio: true, // or false
  video: { width: 1280, height: 720 }
}
        </code></pre>

        <p>Deoarece acest API implica nelinisti privind intimitatea utilizatorilor, functia getUserMedia() intotdeauna va functiona doar dupa ce obtine de la utilizator permisiunea folosirii camerei/microfonului. </p>

        <h4>Cum folosim API-ul Stream in browsere vechi</h4>
        <pre><code class="language-javascript">
// Majoritatea browserelor vechi nu au implementat obiectul mediaDevices 
// Asa ca o initializam cu un obiect gol
if (navigator.mediaDevices === undefined) {
  navigator.mediaDevices = {};
}

// Unele browsere implementeaza partial obiectul mediaDevices. 
// Asa ca vom adauga functia getUserMedia daca aceasta lipseste
if (navigator.mediaDevices.getUserMedia === undefined) {
  navigator.mediaDevices.getUserMedia = function(constraints) {

    // Mai intai vom initializa functia getUserMedia
    // cu una dintre valorile care pot exista deja in browserul curent
    var getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia;

    // Daca nicio valoare nu a fost gasita, inseamna ca browserul curent
    // Nu permite deloc accesul la media
    if (!getUserMedia) {
      return Promise.reject(new Error('getUserMedia nu este implementat in acest browser'));
    }

    // Altfel, transmitem functia existenta catre navigator.getUserMedia 
    // printr-o functie de tip promisiune
    return new Promise(function(resolve, reject) {
      getUserMedia.call(navigator, constraints, resolve, reject);
    });
  }
}

navigator.mediaDevices.getUserMedia({ audio: true, video: true })
.then(function(stream) {
  var video = document.querySelector('video');
  // Unele browsere vechi nu au implementat srcObject
  if ("srcObject" in video) {
    video.srcObject = stream;
  } else {
    video.src = window.URL.createObjectURL(stream);
  }
  video.onloadedmetadata = function(e) {
    video.play();
  };
})
.catch(function(err) {
  console.log(err.name + ": " + err.message);
});
        </code></pre>

        <br>

        <h3>b) API-ul Geolocation</h3>

        <p>Prin acest API putem obtine acces la GPS-ul dispozitivului. Din motive de securitate, utilizatorului i se cere mai intai permisiunea.</p>

        <p>Suportul browserelor pentru API-ul Geolocation poate fi verificat aici: <a href="https://caniuse.com/#search=Geolocation" target="_blank">Suport Geolocation API</a></p>

        <figure class="figure">
          <a href="https://caniuse.com/#search=Geolocation" target="_blank">
            <img src="<?php echo ROOT ?>img/geolocation-api.png" class="figure-img img-fluid rounded" alt="Suport Geolocation API">
          </a>
          <figcaption class="figure-caption">Suport Geolocation API</figcaption>
        </figure>

        <h4>Obiectul geolocation</h4>
        <p>Daca acest obiect existsa, serviciu geolocation este disponibil:</p>
        <pre><code class="language-javascript">
if ("geolocation" in navigator) {
  /* geolocation este dispobinil */
} else {
  /* geolocation NU este dispobinil */
}
        </code></pre>

        <h4>Obtinerea locatiei curente</h4>
        <p>Functia getCurrentPosition() initieaza o cerere asincron pentru a detecta pozitia utilizatorului, si cere dispozitivului mobil sa obita informatia actualizata.</p>
        <pre><code class="language-javascript">
navigator.geolocation.getCurrentPosition(function(position) {
  // Aici avem acces la coordonatele latitudine si longitudine
  do_something(position.coords.latitude, position.coords.longitude);
});
        </code></pre>

        <h4>Urmarirea locatiei curente</h4>
        <p>Daca pozitia se schimba (datorita miscarii utilizatorului sau sunt obtinute informatii actualizate), se poate apela o functie in care se transmit informatiile actualizate. </p>
        <pre><code class="language-javascript">
var watchID = navigator.geolocation.watchPosition(function(position) {
  do_something(position.coords.latitude, position.coords.longitude);
});
        </code></pre>

        <h4>Oprirea urmaririi locatiei curente</h4>
        <pre><code class="language-javascript">
navigator.geolocation.clearWatch(watchID);
        </code></pre>
        
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item backward">
                    <a class="page-link" href="<?php echo ROOT ?>push-notifications/" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="paginationDesc">Notificari Push</span>
                    </a>
                </li>
                <li class="page-item forward">
                    <a class="page-link" href="<?php echo ROOT ?>testing-area/" aria-label="Next">
                        <span class="paginationDesc">Zona de testare</span>
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    </div>
</div>
<?php require_once("../footer.php") ?>
