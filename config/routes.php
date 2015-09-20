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

  $routes->get('/aiheet/uusi', function() {
    Aihekontrolleri::uusiAihe();
  }); 
  
  $routes->post('/aiheet/luo_uusi', function() {
    Aihekontrolleri::luoUusiAihe();
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
  
  $routes->post('/aihe/:id/lisaa_ohjaaja', function($id) {
    Aihekontrolleri::lisaa_ohjaaja($id);
  });
  
  $routes->post('/aihe/:id//lisaa_tapahtumatyyppi', function($id) {
    Aihekontrolleri::lisaa_tapahtumatyyppi($id);
  }); 
  
  $routes->post('/aihe/:id/lisaa_tutkimusala', function($id) {
    Aihekontrolleri::lisaa_tutkimusala($id);
  }); 
  
  $routes->get('/aihe/:id/aiheen_tiedot', function($id) {
    Aihekontrolleri::edit_gradu($id);
  }); 
  
  
  
  
  


  
  $routes->get('/graduaiheet', function() {
    HelloWorldController::etusivu();
  });
  
  
