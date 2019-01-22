<?php require_once("../header.php") ?>

<div class="container">
    <div class="row">
    <div class="col">
        <h2>2. Web App Manifest</h2>
        <p>
        The <strong>web app manifest</strong> provides information about an application 
        <em>(such as its name, author, icon, and description)</em> in a JSON text file. 
        </p>
        <p>
            <div class="alert alert-primary" role="alert">
            <i class="material-icons"> info </i>
            The manifest informs details for websites installed on the homescreen of a device, providing users with quicker access and a richer experience
            </div>  
        </p>
        <hr>
        <h4>Linking the manifest file</h4>
        <p>Web app manifests are deployed in your HTML pages using a <link> element in the <head> of a document:</p>
        <pre><code class="language-html">
&lt;link rel="manifest" href="/manifest.json">
            </code></pre>
        <h4>Example manifest</h4>    
        <pre><code class="language-javascript">{
    "name": "HackerWeb", // App name
    "short_name": "HackerWeb", // App short name
    "start_url": ".", // The URL that loads when a user launches the application
    "display": "standalone",
    "background_color": "#fff",
    "description": "A simply readable Hacker News app.",
    "icons": [
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
    "related_applications": [{
        "platform": "play",
        "url": "https://play.google.com/store/apps/details?id=cheeaun.hackerweb"
    }]
}</code></pre>
        <h4>Members</h4>

        <div id="accordion">
            <div class="card">
                <div class="card-header" id="heading1"  data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                    Background Color
                    <span>+</span>
                </div>

                <div id="collapse1" class="collapse show" aria-labelledby="heading1" data-parent="#accordion">
                    <div class="card-body">
                        <pre><code class="language-javascript">
"background_color": "red"
                        </code></pre>
                        <p>Defines the expected “background color” for the website. This creates a smooth transition between launching the web application and loading the site's content.</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="heading2"  data-toggle="collapse" data-target="#collapse2" aria-controls="collapse2">
                    Description
                    <span>+</span>
                </div>

                <div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#accordion">
                    <div class="card-body">
                        <pre><code class="language-javascript">
"description": "The app that helps you find the best food in town!"
                        </code></pre>
                        <p>Provides a general description of what the pinned website does.</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="heading3"  data-toggle="collapse" data-target="#collapse3" aria-controls="collapse3">
                    Direction
                    <span>+</span>
                </div>

                <div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#accordion">
                    <div class="card-body">
                        <pre><code class="language-javascript">
"dir": "rtl",
"lang": "ar",
"short_name": "أنا من التطبيق!"
                        </code></pre>
                        <p>Specifies the primary text direction for the name, short_name, and description members. Together with the lang member, it helps the correct display of right-to-left languages.</p>

                        <p>It may be one of the following values:</p>

                        <ul>
                            <li>ltr (left-to-right)</li>
                            <li>rtl (right-to-left)</li>
                            <li>auto</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="heading4"  data-toggle="collapse" data-target="#collapse4" aria-controls="collapse4">
                    Display
                    <span>+</span>
                </div>

                <div id="collapse4" class="collapse" aria-labelledby="heading4" data-parent="#accordion">
                    <div class="card-body">
                        <pre><code class="language-javascript">
"display": "standalone"
                        </code></pre>
                        <p>Defines the developers’ preferred display mode for the website.</p>

                        <p>It may be one of the following values:</p>

                        <ul class="listWithPadding">
                            <li><strong>fullscreen</strong> <div><em>All of the available display area is used and no user agent chrome is shown.</em></div></li>
                            <li><strong>standalone</strong> <div><em>The application will look and feel like a standalone application. This can include the application having a different window, its own icon in the application launcher, etc. In this mode, the user agent will exclude UI elements for controlling navigation, but can include other UI elements such as a status bar.</em></div></li>
                            <li><strong>minimal-ui</strong> <div><em>The application will look and feel like a standalone application, but will have a minimal set of UI elements for controlling navigation. The elements will vary by browser.	</em></div></li>
                            <li><strong>browser</strong> <div><em>The application opens in a conventional browser tab or new window, depending on the browser and platform. This is the default. </em></div></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="heading5"  data-toggle="collapse" data-target="#collapse5" aria-controls="collapse5">
                    Icons
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
                        <p>Specifies an array of image files that can serve as application icons, depending on context. For example, they can be used to represent the web application amongst a list of other applications, or to integrate the web application with an OS's task switcher and/or system preferences.</p>
                        <p>Image objects may contain the following values:</p>

                        <ul class="listWithPadding">
                            <li><strong>sizes</strong> <div><em>A string containing space-separated image dimensions.</em></div></li>
                            <li><strong>src</strong> <div><em>The path to the image file. If src is a relative URL, the base URL will be the URL of the manifest.</em></div></li>
                            <li><strong>type</strong> <div><em>A hint as to the media type of the image. The purpose of this member is to allow a user agent to quickly ignore images of media types it does not support.</em></div></li>
                            <li>
                                <strong>purpose</strong> <div><em>Defines the purpose of the image, for example that the image is intended to serve some special purpose in the context of the host OS (i.e., for better integration).</em></div>
                                <br>
                                <p>The purpose member can have the following values:</p>
                                <ul>
                                    <li><strong>"badge"</strong> <div><em> A user agent can present this icon where space constraints and/or color requirements differ from those of the application icon.</em></div></li>
                                    <li><strong>"maskable"</strong> <div><em> The image is designed with icon masks and safe zone in mind, such that any part of the image that is outside the safe zone can safely be ignored and masked away by the user agent.</em></div></li>
                                    <li><strong>"any"</strong> <div><em> The user agent is free to display the icon in any context (this is the default value).</em></div></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="heading6"  data-toggle="collapse" data-target="#collapse6" aria-controls="collapse6">
                    Language
                    <span>+</span>
                </div>

                <div id="collapse6" class="collapse" aria-labelledby="heading6" data-parent="#accordion">
                    <div class="card-body">
                        <pre><code class="language-javascript">
"lang": "en-US"
                        </code></pre>
                        <p>Specifies the primary language for the values in the name and short_name members. This value is a string containing a single language tag.</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="heading7"  data-toggle="collapse" data-target="#collapse7" aria-controls="collapse7">
                    Name
                    <span>+</span>
                </div>

                <div id="collapse7" class="collapse" aria-labelledby="heading7" data-parent="#accordion">
                    <div class="card-body">
                        <pre><code class="language-javascript">
"name": "Google I/O 2017"
                        </code></pre>
                        <p>Provides a human-readable name for the site when displayed to the user. For example, among a list of other applications or as a label for an icon.</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="heading8"  data-toggle="collapse" data-target="#collapse8" aria-controls="collapse8">
                    Orientation
                    <span>+</span>
                </div>

                <div id="collapse8" class="collapse" aria-labelledby="heading8" data-parent="#accordion">
                    <div class="card-body">
                        <pre><code class="language-javascript">
​​"orientation": "portrait-primary"
                        </code></pre>
                        <p>Defines the default orientation for all the website's top level browsing contexts.</p>

                        <p>It may be one of the following values:</p>

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
                    Prefer Related Applications
                    <span>+</span>
                </div>

                <div id="collapse9" class="collapse" aria-labelledby="heading9" data-parent="#accordion">
                    <div class="card-body">
                        <pre><code class="language-javascript">
"prefer_related_applications": false
                        </code></pre>
                        <p>Specifies a boolean value that hints for the user agent to indicate to the user that the specified native applications are recommended over the website. This should only be used if the related native apps really do offer something that the website can't.</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="heading10"  data-toggle="collapse" data-target="#collapse10" aria-controls="collapse10">
                    Related Applications
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
                        <p>An array of native applications that are installable by, or accessible to, the underlying platform — for example, a native Android application obtainable through the Google Play Store. Such applications are intended to be alternatives to the website that provides similar/equivalent functionality — like the native app version of the website.</p>
                        <p>Application objects may contain the following values:</p>

                        <ul class="listWithPadding">
                            <li><strong>platform</strong> <div><em>The platform on which the application can be found.</em></div></li>
                            <li><strong>url</strong> <div><em>The URL at which the application can be found.</em></div></li>
                            <li><strong>id</strong> <div><em>The ID used to represent the application on the specified platform.</em></div></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="heading11"  data-toggle="collapse" data-target="#collapse11" aria-controls="collapse11">
                    Scope
                    <span>+</span>
                </div>

                <div id="collapse11" class="collapse" aria-labelledby="heading11" data-parent="#accordion">
                    <div class="card-body">
                        <pre><code class="language-javascript">
"scope": "/myapp/"
                        </code></pre>
                        <p>Defines the navigation scope of this website's context. This restricts what web pages can be viewed while the manifest is applied. If the user navigates outside the scope, it returns to a normal web page inside a browser tab/window.</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="heading12"  data-toggle="collapse" data-target="#collapse12" aria-controls="collapse12">
                    Short Name
                    <span>+</span>
                </div>

                <div id="collapse12" class="collapse" aria-labelledby="heading12" data-parent="#accordion">
                    <div class="card-body">
                        <pre><code class="language-javascript">
"short_name": "I/O 2017"
                        </code></pre>
                        <p>Provides a short human-readable name for the application. This is intended for when there is insufficient space to display the full name of the web application, like device homescreens.</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="heading13"  data-toggle="collapse" data-target="#collapse13" aria-controls="collapse13">
                    Start URL
                    <span>+</span>
                </div>

                <div id="collapse13" class="collapse" aria-labelledby="heading13" data-parent="#accordion">
                    <div class="card-body">
                        <pre><code class="language-javascript">
"start_url": "/pwa-examples/a2hs/index.html"
                        </code></pre>
                        <p>The URL that loads when a user launches the application (e.g. when added to home screen), typically the index. Note that this has to be a relative URL, relative to the manifest url.</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="heading14"  data-toggle="collapse" data-target="#collapse14" aria-controls="collapse14">
                    Theme Color
                    <span>+</span>
                </div>

                <div id="collapse14" class="collapse" aria-labelledby="heading14" data-parent="#accordion">
                <div class="card-body">
                    <pre><code class="language-javascript">
"theme_color": "aliceblue"
                    </code></pre>
                    <p>Defines the default theme color for an application. This sometimes affects how the OS displays the site (e.g., on Android's task switcher, the theme color surrounds the site).</p>
                </div>
            </div>
        </div>

        <h4>Splash Screens</h4>
        <p>In Chrome 47 and later, a splash screen is displayed for sites launched from a homescreen. This splashscreen is auto-generated from properties in the web app manifest, specifically:</p>

        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item backward">
                    <a class="page-link" href="<?php echo ROOT ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="paginationDesc">Introduction</span>
                    </a>
                </li>
                <li class="page-item forward">
                    <a class="page-link" href="<?php echo ROOT ?>service-workers/" aria-label="Next">
                        <span class="paginationDesc">Service Workers</span>
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    </div>
</div>

<?php require_once("../footer.php") ?>
