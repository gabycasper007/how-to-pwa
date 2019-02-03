<?php require_once("config.php") ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Meta taguri necesare -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="description" content="Ghid PWA">

    <!-- You must provide a single page application solution offering back buttons inside the UI -or use location.href instead of normal <a> links if you don’t want them to be opened in the browser instead of your app’s container-. -->
      <!-- https://medium.com/@firt/dont-use-ios-web-app-meta-tag-irresponsibly-in-your-progressive-web-apps-85d70f4438cb -->
      <!-- PWA tips: -->
      <!-- https://deanhume.com/a-big-list-of-progressive-web-app-tips/ -->
      
    <meta name=”apple-mobile-web-app-capable” content=”yes”>
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Ghid PWA">

    <link rel="apple-touch-startup-image" href="<?php echo ROOT; ?>img/icons/icon-152x152.png">
    <link rel="apple-touch-icon" href="<?php echo ROOT; ?>img/icons/icon-152x152.png">
    <link rel="apple-touch-icon" href="<?php echo ROOT; ?>img/icons/icon-72x72.png" sizes="72x72">
    <link rel="apple-touch-icon" href="<?php echo ROOT; ?>img/icons/icon-96x96.png" sizes="96x96">
    <link rel="apple-touch-icon" href="<?php echo ROOT; ?>img/icons/icon-128x128.png" sizes="128x128">
    <link rel="apple-touch-icon" href="<?php echo ROOT; ?>img/icons/icon-144x144.png" sizes="144x144">
    <link rel="apple-touch-icon" href="<?php echo ROOT; ?>img/icons/icon-152x152.png" sizes="152x152">
    <link rel="apple-touch-icon" href="<?php echo ROOT; ?>img/icons/icon-192x192.png" sizes="192x192">

    <link rel="icon" sizes="192x192" href="<?php echo ROOT; ?>img/icons/icon-192x192.png">

    <meta name="msapplication-TileImage" content="<?php echo ROOT; ?>img/icons/icon-144x144.png">
    <meta name="msapplication-TileColor" content="#9c27b0">
    <meta name="theme-color" content="#6a0080">

    <link
      rel="stylesheet"
      href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css"
      integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX"
      crossorigin="anonymous"
    />

    <link
      href="https://fonts.googleapis.com/css?family=Lato|Open+Sans|PT+Serif|Roboto:300,400,500,700|Material+Icons|Ubuntu|Vollkorn"
      rel="stylesheet"
    />
    
    <link href="<?php echo ROOT; ?>css/prism.css" rel="stylesheet" />


    <link rel="stylesheet" href="<?php echo ROOT; ?>css/style.css" />
    <link rel="manifest" href="<?php echo ROOT; ?>pwa.webmanifest">

    <title>Ghid PWA</title>
  </head>
  <body>
    <div class="bmd-layout-container bmd-drawer-f-r bmd-drawer-overlay">
      <header class="bmd-layout-header">
        <div class="navbar navbar-dark bg-primary sticky-top">
          <ul class="nav navbar-nav">
            <li class="nav-item"><h1 class="primaryTitle"><a  href="<?php echo ROOT; ?>">Ghid PWA</a></h1></li>
          </ul>
          <button
            class="navbar-toggler"
            type="button"
            data-toggle="drawer"
            data-target="#dw-s2"
          >
            <span class="sr-only">Meniu</span>
            <i class="material-icons">menu</i>
          </button>
        </div>
      </header>
      
      <div id="dw-s2" class="bmd-layout-drawer bg-faded">
        <header><a class="navbar-brand" ><h5>Ghid PWA</h5></a></header>
        <ul class="list-group">
          <li><a href="<?php echo ROOT ?>" class="list-group-item">1. Introducere</a></li>
          <li><a href="<?php echo ROOT ?>web-app-manifest/" class="list-group-item">2. Manifestearea aplicatiei</a></li>
          <li><a href="<?php echo ROOT ?>service-workers/" class="list-group-item">3. Lucratori de servicii</a></li>
          <li><a href="<?php echo ROOT ?>caching/" class="list-group-item">4. Cache</a></li>
          <li><a href="<?php echo ROOT ?>indexed-db/" class="list-group-item">5. IndexedDB</a></li>
          <li><a href="<?php echo ROOT ?>background-sync/" class="list-group-item">6. Sincronizare pe fundal</a></li>
          <li><a href="<?php echo ROOT ?>push-notifications/" class="list-group-item">7. Notificari Push</a></li>
          <li><a href="<?php echo ROOT ?>native-device-features/" class="list-group-item">8. Functionalitati native</a></li>
          <li><a href="<?php echo ROOT ?>testing-area/" class="list-group-item">9. Zona de testare</a></li>
        </ul>
      </div>
      <main class="bmd-layout-content">