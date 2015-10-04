<?php

  $routes->get('/', function() {
    HelloWorldController::etusivu();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
  
  $routes->get('/aiheet', function() {
    Aihekontrolleri::index();
  });
  
  $routes->get('/aiheet/haku', function() {
    Aihekontrolleri::search();
  });

  $routes->get('/aiheet/uusi', function() {
    Aihekontrolleri::uusiAihe();
  }); 
  
   $routes->get('/ohjaajat', function() {
    Ohjaajakontrolleri::ohjaajalista();
  }); 
  
   $routes->get('/alat', function() {
    Alakontrolleri::tutkimusalalista();
  }); 
  
  $routes->post('/aiheet/uusi', function() {
    Aihekontrolleri::tallenna();
  }); 
    
  $routes->get('/aihe/muokkaus', function() {
    HelloWorldController::muokkaus();
  });
  
  $routes->get('/aihe/tapahtuma', function() {
    HelloWorldController::tapahtuma();
  });  
  

  $routes->get('/aihe/:id', function($id) {
    Aihekontrolleri::show($id);
  });
  
  $routes->get('/aihe/:id/muokkaus', function($id) {
    Aihekontrolleri::edit($id);
  });
  
  $routes->post('/aihe/:id/muokkaus', function($id) {
    Aihekontrolleri::muokkaa($id);
  });
  
  $routes->post('/aihe/:id/lisaa_ohjaaja', function($id) {
    Ohjaajakontrolleri::lisaa_aiheen_ohjaaja($id);
  });
  
  $routes->post('/aihe/:aihe/poista_ohjaaja/:ohjaaja', function($aihe, $ohjaaja) {
    Ohjaajakontrolleri::poista_aiheen_ohjaaja($aihe, $ohjaaja);
  });
  
  $routes->post('/aihe/:aihe/poista_ala/:ala', function($aihe, $ala) {
    Alakontrolleri::poista_aiheen_luokitus($aihe, $ala);
});

$routes->post('/aihe/:id/lisaa_tapahtumatyyppi', function($id) {
    Aihekontrolleri::lisaa_tapahtumatyyppi($id);
});

$routes->post('/aihe/:id/lisaa_tutkimusala', function($id) {
    Alakontrolleri::lisaa_aiheen_luokitus($id);
});

$routes->post('/aihe/:id/poista', function($id) {
    Aihekontrolleri::poista($id);
});

$routes->get('/aihe/:id/aiheen_tiedot', function($id) {
    Aihekontrolleri::edit_gradu($id);
});

$routes->get('/login', function() {
    Ohjaajakontrolleri::login();
});

$routes->post('/login', function() {
    Ohjaajakontrolleri::handle_login();
});

$routes->post('/logout', function() {
    Ohjaajakontrolleri::logout();
});


