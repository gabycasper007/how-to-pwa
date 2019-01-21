<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />

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

    <link rel="stylesheet" href="css/style.css" />

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
            <li class="nav-item"><h1 class="primaryTitle">How to PWA</h1></li>
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
        <header><a class="navbar-brand">How to PWA</a></header>
        <ul class="list-group">
          <a class="list-group-item">1. Introduction</a>
          <a class="list-group-item">2. Web App Manifest</a>
          <a class="list-group-item">3. Service Workers</a>
          <a class="list-group-item">4. Caching</a>
          <a class="list-group-item">5. IndexedDB</a>
          <a class="list-group-item">6. Background Sync</a>
          <a class="list-group-item">7. Push Notifications</a>
          <a class="list-group-item">8. Native Device Features</a>
        </ul>
      </div>