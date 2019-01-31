<?php require_once("../header.php") ?>

<div class="container">
    <div class="row">
    <div class="col">
        <h2>2. Manifestarea aplicatiei (Web App Manifest)</h2>
        <p>
        Prin <strong>web app manifest</strong> oferim informatii despre aplicatie. 
        <em>(ca numele aplicatiei, autorul, iconita si descriere)</em> intr-un fisier de tip JSON. 
        </p>
        <p>
            <div class="alert alert-info" role="alert">
            <i class="material-icons"> done </i>
            Fisierul manifest ofera utilizatorilor o experienta imbuntatita prin acces mai rapid la aplicatie si detalii pentru aplicatia instalata pe ecranul principal al dispozitivului.
            </div>  
        </p>

        <p>Fisierul manifest poate fi verificat in Google Chrome folosind Developer Tools si intrand la Application -> Manifest</p>

        <figure class="figure">
          <img src="<?php echo ROOT ?>img/manifest-file.png" class="figure-img img-fluid rounded" alt="manifest file">
          <figcaption class="figure-caption">Fisierul Manifest</figcaption>
        </figure>

        <p>
            Suportul browserelor pentru Web App Manifest poate fi verificat aici: <a href="https://caniuse.com/#feat=web-app-manifest" target="_blank">Web App Manifest</a>.
        </p>

        <figure class="figure">
          <a href="https://caniuse.com/#feat=web-app-manifest" target="_blank">
              <img src="<?php echo ROOT ?>img/web-app-manifest.png" class="figure-img img-fluid rounded" alt="web app manifest browser support">
          <figcaption class="figure-caption"><a href="https://caniuse.com/#feat=web-app-manifest" target="_blank">Suportul browserelor pentru Web App Manifest</a></figcaption>
        </figure>

        <hr>
        <h4>Incarcarea fisierului manifest</h4>
        <p>Fisierul manifest poate fi legat de paginile HTML folosind un element de tip &lt;link> in sectiunea &lt;head> a documentului HTML:</p>
        <pre><code class="language-html">
&lt;link rel="manifest" href="/pwa.webmanifest">
            </code></pre>
        <h4>Exemplu de fisier manifest</h4>    
        <pre><code class="language-javascript">{
    "name": "HackerWeb", // Numele aplicatiei
    "short_name": "HackerWeb", // Numele prescurtat al aplicatiei
    "start_url": ".", // Pagina de pornire a aplicatiei
    "display": "standalone", // Modul de afisare al aplicatiei
    "background_color": "#fff", // Culoarea de fundal
    "description": "A simply readable Hacker News app.", // Scurta descriere a aplicatiei
    "icons": [ // Iconitele aplicatiei
        {
            "src": "images/touch/homescreen48.png",
            "sizes": "48x48",
            "type": "image/png"
        }, 
        {
            "src": "images/touch/homescreen72.png",
            "sizes": "72x72",
            "type": "image/png"
        }, 
        {
            "src": "images/touch/homescreen96.png",
            "sizes": "96x96",
            "type": "image/png"
        }, 
        {
            "src": "images/touch/homescreen144.png",
            "sizes": "144x144",
            "type": "image/png"
        }, 
        {
            "src": "images/touch/homescreen168.png",
            "sizes": "168x168",
            "type": "image/png"
        }, 
        {
            "src": "images/touch/homescreen192.png",
            "sizes": "192x192",
            "type": "image/png"
        }
    ],
    "related_applications": [{ // Aplicatii native asociate2
        "platform": "play",
        "url": "https://play.google.com/store/apps/details?id=cheeaun.hackerweb"
    }]
}</code></pre>
        <h4>Elemente</h4>

        <div id="accordion">
            <div class="card">
                <div class="card-header" id="heading1"  data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                    Culoare de fundal
                    <span>+</span>
                </div>

                <div id="collapse1" class="collapse show" aria-labelledby="heading1" data-parent="#accordion">
                    <div class="card-body">
                        <pre><code class="language-javascript">
"background_color": "red"
                        </code></pre>
                        <p>Defineste culoarea de fundal a aplicatiei. Aceasta creeaza o tranzitie placuta de la pornirea aplicatiei pana la incarcarea continutului.</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="heading2"  data-toggle="collapse" data-target="#collapse2" aria-controls="collapse2">
                    Descriere
                    <span>+</span>
                </div>

                <div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#accordion">
                    <div class="card-body">
                        <pre><code class="language-javascript">
"description": "The app that helps you find the best food in town!"
                        </code></pre>
                        <p>Ofera o descriere generala a aplicatiei.</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="heading3"  data-toggle="collapse" data-target="#collapse3" aria-controls="collapse3">
                    Directie
                    <span>+</span>
                </div>

                <div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#accordion">
                    <div class="card-body">
                        <pre><code class="language-javascript">
"dir": "rtl",
"lang": "ar",
"short_name": "أنا من التطبيق!"
                        </code></pre>
                        <p>Specifica directia textului pentru numele aplicatiei, numele prescurtat si descriere. Impreuna cu elementul lang, arata corent textul pentru limbile care se de la dreapta la stanga.</p>

                        <p>Poate fi una dintre urmatoarele valori:</p>

                        <ul>
                            <li>ltr (de la stanga la dreapta)</li>
                            <li>rtl (de la dreapta la stanga)</li>
                            <li>auto</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="heading4"  data-toggle="collapse" data-target="#collapse4" aria-controls="collapse4">
                    Mod de afisare
                    <span>+</span>
                </div>

                <div id="collapse4" class="collapse" aria-labelledby="heading4" data-parent="#accordion">
                    <div class="card-body">
                        <pre><code class="language-javascript">
"display": "standalone"
                        </code></pre>
                        <p>Defineste modul preferat de afisare a aplicatiei.</p>

                        <p>Poate fi una dintre urmatoarele valori:</p>

                        <ul class="listWithPadding">
                            <li><strong>fullscreen</strong> <div><em>Tot ecranul este folosit iar browserul nu este afisat.</em></div></li>
                            <li><strong>standalone</strong> <div><em>Aplicatia va arata asemanator cu o aplicatie mobila nativa. Asta poate include ca aplicatie sa fie deschisa in fereastra separata, cu propria iconita pe ecranul principal al dispozitivului. In acest mod, browserul va exclude elementele proprii pentru navigarea aplicatiei, dar poate include alte elemente cum ar fi o bara de stare (status bar).</em></div></li>
                            <li><strong>minimal-ui</strong> <div><em>Aplicatia va arata asemanator cu o aplicatie mobila nativa, dar va avea un set minim de elemente pentru navigare. Elementele difera in functie de browser.	</em></div></li>
                            <li><strong>browser</strong> <div><em>Aplicatia se deschide in mod clasic, intr-un tab nou de browser. Aceasta optiune este cea setata in mod implicit. </em></div></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="heading5"  data-toggle="collapse" data-target="#collapse5" aria-controls="collapse5">
                    Iconite
                    <span>+</span>
                </div>

                <div id="collapse5" class="collapse" aria-labelledby="heading5" data-parent="#accordion">
                    <div class="card-body">
                        <pre><code class="language-javascript">
"icons": [
    {
        "src": "icon/lowres.webp",
        "sizes": "48x48",
        "type": "image/webp"
    },
    {
        "src": "icon/lowres",
        "sizes": "48x48"
    },
    {
        "src": "icon/hd_hi.ico",
        "sizes": "72x72 96x96 128x128 256x256"
    },
    {
        "src": "icon/hd_hi.svg",
        "sizes": "72x72"
    }
]
                        </code></pre>
                        <p>Specifica o lista de imagini care pot fi folosite ca iconite ale aplicatiei in functie de context. De exemplu, pot fi folosite pentru a afisa aplicatia intr-o lista de alte aplicatii, sau pentru a integra aplicatia cu comutatorul de sarcini al sistemului de operare (task switcher).</p>
                        <p>Obiectele pentru imagini pot contine urmatoarele:</p>

                        <ul class="listWithPadding">
                            <li><strong>sizes</strong> <div><em>Un string ce contine dimensiuni separate prin spatiu.</em></div></li>
                            <li><strong>src</strong> <div><em>Calea catre fisierul imagine.</em></div></li>
                            <li><strong>type</strong> <div><em>Tipul media al imaginii. Scopul acestui element este de a permite browserului sa ignore rapid tipurile de imagini pe care nu le suporta.</em></div></li>
                            <li>
                                <strong>purpose</strong> <div><em>Defineste scopul imaginii, de exemplu ca imaginea trebuie folosita pentru un scop special in contextul sistemului de operare (pentru o integrare mai buna ).</em></div>
                                <br>
                                <p>Poate avea urmatoarele valori:</p>
                                <ul>
                                    <li><strong>"badge"</strong> <div><em> Un browser poate prezenta aceasta iconita atunci cand spatiul si culorile nu permit afisarea iconitei principale.</em></div></li>
                                    <li><strong>"maskable"</strong> <div><em> Imaginea este proiectata cu o masca, astfel incat orice zone a imaginii din interiorul mastii sa fie ignorata de catre browser.</em></div></li>
                                    <li><strong>"any"</strong> <div><em> Browserul este liber sa afiseze iconita in orice context (aceasta este valoarea implicita).</em></div></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="heading6"  data-toggle="collapse" data-target="#collapse6" aria-controls="collapse6">
                    Limba
                    <span>+</span>
                </div>

                <div id="collapse6" class="collapse" aria-labelledby="heading6" data-parent="#accordion">
                    <div class="card-body">
                        <pre><code class="language-javascript">
"lang": "ro-RO"
                        </code></pre>
                        <p>Specifica limba principala folosite in numele si numele scurt ale aplicatiei.</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="heading7"  data-toggle="collapse" data-target="#collapse7" aria-controls="collapse7">
                    Nume
                    <span>+</span>
                </div>

                <div id="collapse7" class="collapse" aria-labelledby="heading7" data-parent="#accordion">
                    <div class="card-body">
                        <pre><code class="language-javascript">
"name": "Google I/O 2017"
                        </code></pre>
                        <p>Ofera un nume aplicatiei. Acest nume este afisat utilizatorului de exemplu in lista cu celelalte aplicatii.</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="heading8"  data-toggle="collapse" data-target="#collapse8" aria-controls="collapse8">
                    Orientare
                    <span>+</span>
                </div>

                <div id="collapse8" class="collapse" aria-labelledby="heading8" data-parent="#accordion">
                    <div class="card-body">
                        <pre><code class="language-javascript">
​​"orientation": "portrait-primary"
                        </code></pre>
                        <p>Defineste orientarea principala pentru toate contextele principale ale aplicatiei.</p>

                        <p>Poate fi una dintre urmatoarele valori:</p>

                        <ul>
                            <li>any</li>
                            <li>natural</li>
                            <li>landscape</li>
                            <li>landscape-primary</li>
                            <li>landscape-secondary</li>
                            <li>portrait</li>
                            <li>portrait-primary</li>
                            <li>portrait-secondary</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="heading9"  data-toggle="collapse" data-target="#collapse9" aria-controls="collapse9">
                    Prefera Aplicatii Corelate
                    <span>+</span>
                </div>

                <div id="collapse9" class="collapse" aria-labelledby="heading9" data-parent="#accordion">
                    <div class="card-body">
                        <pre><code class="language-javascript">
"prefer_related_applications": false
                        </code></pre>
                        <p>Comunica browserului daca sa indice utilizatorului sa descarce o aplicatie mobila nativa corelata. Aceasta valoare trebuie folosita doar daca aplicatia mobila nativa ofera cu adevarat functionalitati in plus fata de aplicatia PWA.</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="heading10"  data-toggle="collapse" data-target="#collapse10" aria-controls="collapse10">
                    Aplicatii corelate
                    <span>+</span>
                </div>

                <div id="collapse10" class="collapse" aria-labelledby="heading10" data-parent="#accordion">
                    <div class="card-body">
                        <pre><code class="language-javascript">
"related_applications": [
{
"platform": "play",
"url": "https://play.google.com/store/apps/details?id=com.example.app1",
"id": "com.example.app1"
}, {
"platform": "itunes",
"url": "https://itunes.apple.com/app/example-app1/id123456789"
}]
                        </code></pre>
                        <p>O lista de aplicatii native care pot fi instalate din magazinul de aplicatii (Google Play Store, App Store, etc.).</p>
                        <p>Poate contine urmatoarele valori:</p>

                        <ul class="listWithPadding">
                            <li><strong>platform</strong> <div><em>Platforma pe care aplicatia functioneaza.</em></div></li>
                            <li><strong>url</strong> <div><em>Adresa de unde aplicatia poate fi descarcata.</em></div></li>
                            <li><strong>id</strong> <div><em>Identificatorul numeric al aplicatiei.</em></div></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="heading11"  data-toggle="collapse" data-target="#collapse11" aria-controls="collapse11">
                    Domeniu
                    <span>+</span>
                </div>

                <div id="collapse11" class="collapse" aria-labelledby="heading11" data-parent="#accordion">
                    <div class="card-body">
                        <pre><code class="language-javascript">
"scope": "/myapp/"
                        </code></pre>
                        <p>Defineste domeniul navigarii aplicatiei. Aceasta restrictioneaza ce pagini pot fi vizualizate in aplicatia PWA. Daca utilizatorul navigheaza in afara domeniului, se intoarce in pagina web normala, din interiorul browserului.</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="heading12"  data-toggle="collapse" data-target="#collapse12" aria-controls="collapse12">
                    Nume scurt
                    <span>+</span>
                </div>

                <div id="collapse12" class="collapse" aria-labelledby="heading12" data-parent="#accordion">
                    <div class="card-body">
                        <pre><code class="language-javascript">
"short_name": "I/O 2017"
                        </code></pre>
                        <p>Ofera un nume scurt aplicatiei. Acesta este folosit atunci cand spatiul nu permite afisarea numelui intreg, ca de exemplu pe ecranul principal al dispozitivului.</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="heading13"  data-toggle="collapse" data-target="#collapse13" aria-controls="collapse13">
                    Adresa de start
                    <span>+</span>
                </div>

                <div id="collapse13" class="collapse" aria-labelledby="heading13" data-parent="#accordion">
                    <div class="card-body">
                        <pre><code class="language-javascript">
"start_url": "/pwa-examples/a2hs/index.html"
                        </code></pre>
                        <p>Adresa incarcata atunci cand utilizatorul porneste aplicatia.</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="heading14"  data-toggle="collapse" data-target="#collapse14" aria-controls="collapse14">
                    Culoarea aplicatiei
                    <span>+</span>
                </div>

                <div id="collapse14" class="collapse" aria-labelledby="heading14" data-parent="#accordion">
                    <div class="card-body">
                        <pre><code class="language-javascript">
    "theme_color": "aliceblue"
                        </code></pre>
                        <p>Defineste culoarea implicita a aplicatiei.</p>
                    </div>
                </div>
            </div>
        </div>

        <h4>Ecran de pornire</h4>
        <p>Incepand cu Chrome 47, un ecran de pornire este prezentat pentru aplicatiile PWA. Acest ecran de pornire este generated automat din detaliile gasite in fisierul manifest, in mod special folosind numele, culoarea de fundal si una dintre iconite.</p>

        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item backward">
                    <a class="page-link" href="<?php echo ROOT ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="paginationDesc">Introducere</span>
                    </a>
                </li>
                <li class="page-item forward">
                    <a class="page-link" href="<?php echo ROOT ?>service-workers/" aria-label="Next">
                        <span class="paginationDesc">Lucratori de servicii</span>
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    </div>
</div>

<?php require_once("../footer.php") ?>
