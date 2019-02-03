<?php require_once("header.php") ?>
  <div class="container">
    <div class="row">
      <div class="col">
        <h2>1. Introducere</h2>
        <p>
          <strong>Aplicatiile progresive, numite in engleza "Progressive Web Apps" sau PWAs</strong> sunt website-uri ce pot fi instalate pe pagina principala a dispozitivului folosit fara descarcarea de pe un magazin de aplicatii (app store). Acestea pot primi notificari de tip push si functioneaza in mare proportie si fara acces la internet.
        </p>
        <p>Aplicatiile progresive folosesc API-uri moderne si strategii de imbunatatire progresiva pentru a creea aplicatii web ce funtioneaza indiferent de dispozitiv. Aceste aplicatii funtioneaza oriunde si ofera mai multe caracteristici pentru a oferi aceeasi experienta utilizatorilor ca si aplicatiile mobile native. </p>
        <div class="alert alert-info" role="alert">
            <i class="material-icons"> done </i>
            
            Folosind cache-ul, o aplicatie PWA se incarca rapid chiar si cand accesul la internet este limitat, trimite notificari push relevante, poate fi accesata rapid de pe pagina principala a dispozitivului (fara a accesa browserul), si acopera intreg ecranul, asemenea aplicatiilor mobile native.
        </div>

        <h4>Avantajele aplicatiilor PWA</h4>

        <p>Aplicatiile PWAs sunt construite folosind o insiruire de tehnologii specifice si tipare standard pentru a le permite sa profite atat de beneficiile web cat si de cele ale aplicatiilor mobile native. De exemplu, site-uri web sunt mai usor de descoperit si indexat de motoarele de cautare — este mult mai la indemana sa vizitam un website decat sa instalam o aplicatie, si de asemenea poti distribui usor paginile web folosind o ancora (link).</p>
        <p>Pe de alta parte, aplicatiile mobile native sunt mai usor de integrat cu sistemul de operare al dispozitivului si ca atare ofera o experienta mai cursiva pentru utilizatori. Poti instala o aplicatie nativa iar aceasta va putea funtiona si fara acces la internet. Utilizatorilor le este mai la indemana sa acceseze aplicatiile deja instalate pe propriul dispozitiv, decat sa navigheze in pagina unui website folosind browserul.</p>
        <p>Aplicatiile PWA ofera insa avantaje similare aplicatiilor mobile native.</p>

        <h4>Aplicatiile PWA trebuie sa fie:</h4>
        <ul>
          <li>Progresive, adica sa funtioneze ca un PWA pe dispozitive si browsere moderne, dar functionalitatile de baza sa poata fi folosite si pe dispozive si browsere vechi care nu permit functionalitatile moderne PWA.</li>
          <li>Sensibile la rezolutia folosita (responsive), pentru a puta fi folosite la orice rezolutie si pe orice dispozitiv — telefoane mobile, tablete, laptopuri, calculatoare, TV-uri, etc.</li>
          <li>Sa funtioneze indiferent daca accesul la internet este limitat sau inexistent.</li>
          <li>Sa aibe un aspect asemanator cu aplicatiile</li>
          <li>Sa prezinte informatii curente, la zi</li>
          <li>Sa fie sigure, iar conexiunea dintre utilizator si aplicatie sa fie securizata prin protocolul HTTPS. De aceea, aspectele PWA vor functiona doar de pe o conexiune sigura de tip HTTPS sau pe localhost (pentru depanare). </li>
          <li>Detectabile usor, in asa fel incat continutul sa poata fi indexat de catre motoarele de cautare asemenea website-urilor.</li>
          <li>Angrenante, trimitand notificari push in momentul in care aplicatia prezinta continut nou, asemenea aplicatiilor mobile native.</li>
          <li>Instalabile, in asa fel incat sa fie accesibile de pe ecranul principal al dispozitivului, asemenea aplicatiilor mobile native.</li>
          <li>Distribuibile, in asa fel incat sa permita distribuirea prin ancore (link) asemenea website-urilor.</li>
        </ul>

        <h4>Ce este necesar pentru un website sa fie considerat aplicatie PWA?</h4>

        <p>Aplicatiile PWA nu sunt create cu o singura tehnologie ci reprezinta o noua filozofie pentru crearea aplicatiilor web, implicand mai multe modele specifice si API-uri moderne. La prima vedere, nu este evident daca un website este sau nu o aplicatie PWA. </p>
        <p>Un website poate fi considerat aplicatie PWA cand indeplineste anumite cerinte specifice si implementeaza un set de funtionalitati ca: funtioneaza fara internet, este instalabil, sincronizeaza informatia, poate alerta utilizatorii chiar si atunci cand telefonul este in buzunar, etc.</p>

        <div class="alert alert-info" role="alert">
            <i class="material-icons"> done </i>
            
            Exista instrumente de masura pentru a verifica procentual cat de completa este o aplicatie (<a href="https://developers.google.com/web/tools/lighthouse/" target="_blank" rel="noopener" aria-label="Lighthouse">Lighthouse</a>). Implementand diverse avantaje tehnologice, putem face o aplicatie mai progresiva, in asa fel incat scorul din instrumentul Lighthouse va creste.
        </div>

        <h4>Beneficiile tehnologiilor necesare pentru aplicatiile PWA</h4>

        <ul>
          <li>O scadere a timpilor de incarcare dupa ce aplicatia a fost instalata, datorata salvarii resurselor in cache folosind lucratori de servicii (Service Workers), salvand timp si latime de banda utilizatorilor.</li>
          <li>Abilitatea de a actualiza <strong>doar continutul modificat</strong> atunci cand o actualizare a aplicatiei este disponibila. In contrast la o aplicatie mobila nativa, utilizatorul este obligat pentru fiecare mica modificare sa descarce noua varianta a aplicatiei.</li>
          <li>Un aspect integrat cu platforma dispozitivului — aplicatia are iconita pe ecranul principal si ruleaza pe intreg ecranul.</li>
          <li>Aduce utilizatorii inapoi folosind notificari push iar asta conduce la utilizatori mai captivati si la rate de conversii marite (ex: un magazin online vinde mai multe produse).</li>
        </ul>

        <h4>Povesti de succes</h4>
        <p><a href="https://stories.flipkart.com/" rel="noopener" aria-label="Flipkart" target="_blank">Flipkart Lite</a> — Cel mai mare magazin online din India a fost reconstruit ca PWA in 2015, iar asta le-au adus 70% mai multi clienti.</p>
        <p><a href="https://m.aliexpress.com/AliExpress" rel="noopener" aria-label="AliExpress" target="_blank">AliExpress</a> Aplicatia PWA a avut rezultate mai bune atat decat site-ul web cat si decat aplicatia mobila nativa, cu o crestere a vanzarilor de 104% in randul utilizatorilor noi.</p>

        <h4>Suportul in browsere</h4>

        <p>Ingredientul principal necesar pentru aplicatiile PWA este suportul lucratorilor de servicii (Service Worker). Din fericire acestia sunt acum suportati de catre majoritatea browserelor principale atat pe mobil cat si pe desktop.</p>

        <p>
            <div class="alert alert-danger" role="alert">
            <i class="material-icons"> warning </i>
            Cu toate acestea, unele functionalitati ale aplicatiilor PWA sunt in stare experimentala si nu sunt accesibile de pe orice browser.  <br><br>
            De exemplu, va mai dura pana toate browserele vor permite funtionalitatea de sincronizare in fundal (Background Sync), mai ales avand in vedere ca Safari si Edge inca nu suporta lucratorii de servicii (Service Workers). <br><br>
            Majoritatea functionalitatilor specifice aplicatiilor PWA sunt insa accesibile folosind browserul <a href="https://www.google.com/chrome/" rel="noopener" target="_blank" aria-label="Google Chrome">Google Chrome</a>.
            </div>  
        </p>
        
        <p>Alte functionalitati ca: manifestarea aplicatiei (Web App Manifest), notificari fortate (Push Notifications), si adaugarea pe ecranul principal al dispozitivului (Add to Home Screen) au suport destul de larg. In momentul de fata Safari are suport limitat pentru functionalitatile "Web App Manifest" si "Add to Home Screen" si nu are suport pentru "Push Notifications".</p>
        <p>
          <div class="alert alert-info" role="alert">
            <i class="material-icons"> done </i>
            Suportul browserelor poate fi verificat folosind website-ul <a href="https://caniuse.com" rel="noopener" aria-label="Can I Use" target="_blank">Can I use</a>. Exemplu mai jos.
            </div>  
        </p>


        <figure class="figure">
          <a href="https://caniuse.com/#feat=web-app-manifest" rel="noopener" aria-label="Can I Use" target="_blank">
              <img src="<?php echo ROOT ?>img/web-app-manifest.png" class="figure-img img-fluid rounded" alt="web app manifest browser support">
          <figcaption class="figure-caption"><a href="https://caniuse.com/#feat=web-app-manifest" rel="noopener" aria-label="Can I Use" target="_blank">Suportul browserelor pentru "Web App Manifest"</a></figcaption>
        </figure>

        <p>Chiar daca multe functionalitati nu sunt suportate inca de toate browserele, pas cu pas modele de succes din Android/iOS sunt aduse in aplicatiile web PWA, pastrand in acelasi timp beneficiile site-urilor web!</p>

        <h4>Metodologie</h4>

        <p>O aplicatie PWA imbunatateste experienta utilizatorului incarcand mai intai o interfata minimala pe care o adauga in cache pentru a o putea accesa ulterior si fara acces la internet, dupa care descarca restul continutului aplicatiei.</p>

        <p>
          <div class="alert alert-info" role="alert">
            <i class="material-icons"> done </i>
            Astfel, data viitoare cand utilizatorul acceseaza aplicatia, interfata este incarcata rapid din cache iar continutul nou este ulterior descarcat de pe server (daca nu este deja disponibil in cache).
            </div>  
        </p>

        <p>Folosind aceasta metodologie, aplicatia pare mai rapida deoarece utilizatorul vede instant interfata ei in loc sa vada o pagina goala. De asemenea, permite site-ului sa fie folosit fara acces la internet.</p>
        <p>Putem controla ce este cerut din server si ce este luat din cache folosind un lucrator de serviciu (Service Worker). Acesta adauga in cache resursele statice, interfata aplicatiei si administreaza continutul dinamic pentru a imbunatati performanta aplicatiei.</p>

        <nav aria-label="Page navigation example">
              <ul class="pagination clearfix">
                  <li class="page-item forward">
                      <a class="page-link" href="<?php echo ROOT ?>web-app-manifest/" aria-label="Next">
                          <span class="paginationDesc">Manifestarea aplicatiei</span>
                          <span aria-hidden="true">&raquo;</span>
                      </a>
                  </li>
              </ul>
          </nav>
      </div>
    </div>
  </div>
<?php require_once("footer.php") ?>
