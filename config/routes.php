<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
  
  $routes->get('/aiheet', function() {
    HelloWorldController::aiheet();
  });
  
  $routes->get('/aiheet/aihe', function() {
    HelloWorldController::aihe();
  });
  
  $routes->get('/aiheet/aihe/muokkaus', function() {
    HelloWorldController::muokkaus();
  });
  
  $routes->get('/aiheet/aihe/tapahtuma', function() {
    HelloWorldController::tapahtuma();
  });
  
  $routes->get('/graduaiheet', function() {
    HelloWorldController::etusivu();
  });
  
  
