<?php require_once("header.php") ?>
  <div class="container">
    <div class="row">
      <div class="col">
        <h2>1. Introduction</h2>
        <p>
          <strong>Progressive Web Apps (PWAs)</strong> are websites that can be installed to a device’s homescreen without an app store, along with other capabilities like working offline and receiving push notifications.
        </p>
        <p>Progressive web apps use modern web APIs along with traditional progressive enhancement strategy to create cross-platform web applications. These apps work everywhere and provide several features that give them the same user experience advantages as native apps. </p>
        <div class="alert alert-info" role="alert">
            <i class="material-icons"> done </i>
            
            A PWA loads quickly, even on flaky networks, sends relevant push
        notifications, has an icon on the home screen, and loads as a
        top-level, full screen experience.
        </div>

        <h4>PWA advantages</h4>

        <p>PWAs are developed using a number of specific technologies and standard patterns to allow them to take advantage of both web and native app features. For example, web apps are more discoverable — it's a lot easier and faster to visit a website than install an application, and you can also share web apps via a link.</p>
        <p>On the other hand, native apps are better integrated with the operating system and therefore offer a more seamless experience for the users. You can install a native app so that it works offline, and users love tapping their homescreen icons to easily access their favorite apps, rather than navigating to it using a browser.</p>
        <p>PWAs give us the ability to create web apps that can enjoy these same advantages.</p>

        <h4>PWAs should be:</h4>
        <ul>
          <li>Progressive, so it's still usable on a basic level on older browsers, but fully-functional on the latest ones.</li>
          <li>Responsive, so it's usable on any device with a screen and a browser — mobile phones, tablets, laptops, TVs, fridges, etc.</li>
          <li>Network independent, so it works offline or with a poor network connection.</li>
          <li>App-like feel</li>
          <li>Fresh, so it has up-to-date information</li>
          <li>Safe, so the connection between you and the app is secured against any third parties trying to get access to your sensitive data.</li>
          <li>Discoverable, so the contents can be found through search engines.</li>
          <li>Re-engageable, so it's able to send notifications whenever there's new content available.</li>
          <li>Installable, so it's available on the device's home screen.</li>
          <li>Linkable, so you can share it by simply sending a URL.</li>
        </ul>

        <h4>What makes an app a PWA?</h4>

        <p>PWAs are not created with a single technology. They represent a new philosophy for building web apps, involving some specific patterns, APIs, and other features. It's not that obvious if a web app is a PWA or not from first glance. </p>
        <p>An app could be considered a PWA when it meets certain requirements, or implements a set of given features: works offline, is installable, is easy to synchronize, can send push notifications, etc.</p>

        <div class="alert alert-info" role="alert">
            <i class="material-icons"> done </i>
            
            There are tools to measure the completeness of an app in percentages (<a href="https://developers.google.com/web/tools/lighthouse/" target="_blank">Lighthouse</a>). By implementing various technological advantages, we can make an app more progressive, thus ending up with a higher Lighthouse score.
        </div>

        <h4>PWA Benefits</h4>

        <ul>
          <li>A decrease in loading times after the app has been installed, thanks to caching with Service Workers, along with saving precious bandwidth and time.</li>
          <li>The ability to update only the content that has changed when an app update is available. In contrast, with a native app, even the slightest modification can force the user to download the entire application again.</li>
          <li>A look and feel that is more integrated with the native platform — app icons on the homescreen, apps that run fullscreen, etc.</li>
          <li>Re-engaging with users via system notifications and push messages, leading to more engaged users and better conversion rates.</li>
        </ul>

        <h4>Success Stories</h4>
        <p><a href="https://stories.flipkart.com/" target="_blank">Flipkart Lite</a> — India's largest e-commerce site rebuilt as a progressive web app in 2015, which resulted in 70% increase in conversions. </p>
        <p><a href="https://m.aliexpress.com/AliExpress" target="_blank">AliExpress</a> PWA has also seen much better results than the web or native app, with a 104% increase in conversion rates for new users. Given their profit increase, and the relatively low amount of work required for the conversion to PWAs, the advantage is clear.</p>

        <h4>Browser support</h4>

        <p>The key ingredient required for PWAs is service worker support. Thankfully service workers are now supported on all major browsers on desktop and mobile.</p>

        <p>
            <div class="alert alert-danger" role="alert">
            <i class="material-icons"> warning </i>
            It’ll be a while before all browsers support background sync, especially as Safari and Edge don’t yet support service workers. 
            </div>  
        </p>
        
        <p>Other features such as Web App Manifest, Push, Notifications, and Add to Home Screen functionality have wide support too. Currently Safari has limited support for Web App Manifest and Add to Home Screen and no support for web push notifications.</p>
        <p>
          <div class="alert alert-info" role="alert">
            <i class="material-icons"> done </i>
            Browser support for different functionalities can be checked using <a href="https://caniuse.com" target="_blank">Can I use</a> website. Example below.
            </div>  
        </p>


        <figure class="figure">
          <a href="https://caniuse.com/#feat=web-app-manifest" target="_blank">
              <img src="img/web-app-manifest.png" class="figure-img img-fluid rounded" alt="web app manifest browser support">
          <figcaption class="figure-caption"><a href="https://caniuse.com/#feat=web-app-manifest" target="_blank">Web App Manifest Browser Support</a></figcaption>
        </figure>

        <p>Even though some functionalities are not supported in all browsers yet, bit by bit successful patterns are brought from Android/iOS onto the web, while still retaining what makes the web great!</p>

        <h4>Methodology</h4>

        <p>A PWA is improving the user experiance by loading a minimal user interface as soon as possible and then caching it so it is available offline for subsequent visits before then loading all the contents of the app.</p>

        <p>
          <div class="alert alert-info" role="alert">
            <i class="material-icons"> done </i>
            That way, the next time someone visits the app from the device, the UI loads from the cache immediately and any new content is requested from the server (if it isn’t available in the cache already).
            </div>  
        </p>

        <p>This feels fast as the user sees "something" instantly, instead of a loading spinner or a blank page. It also allows the website to be accessible offline if the network connection is not available.</p>
        <p>We can control what is requested from the server and what is retrieved from the cache with a service worker. This caches the app shell and manages the dynamic content in a way that greatly improves the performance.</p>

        <nav aria-label="Page navigation example">
              <ul class="pagination clearfix">
                  <li class="page-item forward">
                      <a class="page-link" href="<?php echo ROOT ?>web-app-manifest/" aria-label="Next">
                          <span class="paginationDesc">Web App Manifest</span>
                          <span aria-hidden="true">&raquo;</span>
                      </a>
                  </li>
              </ul>
          </nav>
      </div>
    </div>
  </div>
<?php require_once("footer.php") ?>
