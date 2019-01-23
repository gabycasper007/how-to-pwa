<?php define(ROOT, '/PWA/how-to-pwa/public/') ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />

    <!-- You must provide a single page application solution offering back buttons inside the UI -or use location.href instead of normal <a> links if you don’t want them to be opened in the browser instead of your app’s container-. -->
      <!-- https://medium.com/@firt/dont-use-ios-web-app-meta-tag-irresponsibly-in-your-progressive-web-apps-85d70f4438cb -->
      <!-- PWA tips: -->
      <!-- https://deanhume.com/a-big-list-of-progressive-web-app-tips/ -->
      
    <meta name=”apple-mobile-web-app-capable” content=”yes”>
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="How to PWA">
    <link rel="apple-touch-icon" href="img/icons/icon-72x72.png" sizes="72x72">
    <link rel="apple-touch-icon" href="img/icons/icon-96x96.png" sizes="96x96">
    <link rel="apple-touch-icon" href="img/icons/icon-128x128.png" sizes="128x128">
    <link rel="apple-touch-icon" href="img/icons/icon-144x144.png" sizes="144x144">
    <link rel="apple-touch-icon" href="img/icons/icon-152x152.png" sizes="152x152">
    <link rel="apple-touch-icon" href="img/icons/icon-192x192.png" sizes="192x192">

    <meta name="msapplication-TileImage" content="img/icons/icon-144x144.png">
    <meta name="msapplication-TileColor" content="#6a0080">
    <meta name="theme-color" content="#9c27b0">
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

    <title>How to PWA</title>
  </head>
  <body>
    <div class="bmd-layout-container bmd-drawer-f-l bmd-drawer-overlay">
      <header class="bmd-layout-header">
        <div class="navbar navbar-dark bg-primary sticky-top">
          <button
            class="navbar-toggler"
            type="button"
            data-toggle="drawer"
            data-target="#dw-s2"
          >
            <span class="sr-only">Toggle drawer</span>
            <i class="material-icons">menu</i>
          </button>
          <ul class="nav navbar-nav">
            <li class="nav-item"><h1 class="primaryTitle"><a  href="<?php echo ROOT; ?>">How to PWA</a></h1></li>
          </ul>

          <div class="dropdown pull-xs-right">
            <button
              class="btn bmd-btn-icon dropdown-toggle"
              type="button"
              id="lr1"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <i class="material-icons">more_vert</i>
            </button>
            <div
              class="dropdown-menu dropdown-menu-right"
              aria-labelledby="lr1"
            >
              <button class="dropdown-item" type="button">Action</button>
              <button class="dropdown-item" type="button">
                Another action
              </button>
              <button class="dropdown-item disabled" type="button">
                Disabled action
              </button>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Separated link</a>
            </div>
          </div>
        </div>
      </header>
      
      <div id="dw-s2" class="bmd-layout-drawer bg-faded">
        <header><a class="navbar-brand" ><h5>How to PWA</h5></a></header>
        <ul class="list-group">
          <a href="<?php echo ROOT ?>" class="list-group-item">1. Introduction</a>
          <a href="<?php echo ROOT ?>web-app-manifest/" class="list-group-item">2. Web App Manifest</a>
          <a href="<?php echo ROOT ?>service-workers/" class="list-group-item">3. Service Workers</a>
          <a href="<?php echo ROOT ?>caching/" class="list-group-item">4. Caching</a>
          <a href="<?php echo ROOT ?>indexed-db/" class="list-group-item">5. IndexedDB</a>
          <a href="<?php echo ROOT ?>background-sync/" class="list-group-item">6. Background Sync</a>
          <a href="<?php echo ROOT ?>push-notifications/" class="list-group-item">7. Push Notifications</a>
          <a href="<?php echo ROOT ?>native-device-features/" class="list-group-item">8. Native Device Features</a>
        </ul>
      </div>
      <main class="bmd-layout-content">