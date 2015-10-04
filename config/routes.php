<?php

// HELLOCONTROLLER (GENERAL)

$routes->get('/', function() {
    HelloController::frontpage();
});

$routes->get('/hiekkalaatikko', function() {
    HelloController::sandbox();
});

// FIELDCONTROLLER (FIELD OF STUDY)

$routes->get('/alat', function() {
    FieldController::fields();
});

$routes->post('/aihe/:aihe/poista_ala/:ala', function($aihe, $ala) {
    FieldController::removeField($aihe, $ala);
});

$routes->post('/aihe/:id/lisaa_tutkimusala', function($id) {
    FieldController::addField($id);
});

// TOPICCONTROLLER (TOPIC OF MASTERS' THESIS)

$routes->get('/aiheet/uusi', function() {
    TopicController::create();
});

$routes->post('/aiheet/uusi', function() {
    TopicController::save();
});

$routes->get('/aiheet', function() {
    TopicController::all();
});

$routes->get('/aiheet/haku', function() {
    TopicController::search();
});

$routes->get('/aihe/:id', function($id) {
    TopicController::show($id);
});

$routes->get('/aihe/:id/muokkaus', function($id) {
    TopicController::update1($id);
});

$routes->get('/aihe/:id/aiheen_tiedot', function($id) {
    TopicController::update2($id);
});

$routes->post('/aihe/:id/muokkaus', function($id) {
    TopicController::saveUpdate($id);
});

$routes->post('/aihe/:id/poista', function($id) {
    TopicController::destroy($id);
});

$routes->post('/aihe/:id/lisaa_tapahtumatyyppi', function($id) {
    TopicController::lisaa_tapahtumatyyppi($id);
});


// SUPERVISORCONTROLLER (SUPERVISOR OF MASTERS' THESIS

$routes->get('/ohjaajat', function() {
    SupervisorController::supervisors();
});

$routes->post('/aihe/:id/lisaa_ohjaaja', function($id) {
    SupervisorController::addSupervisor($id);
});

$routes->post('/aihe/:aihe/poista_ohjaaja/:ohjaaja', function($aihe, $ohjaaja) {
    SupervisorController::removeSupervisor($aihe, $ohjaaja);
});

$routes->get('/login', function() {
    SupervisorController::login();
});

$routes->post('/login', function() {
    SupervisorController::handleLogin();
});

$routes->post('/logout', function() {
    SupervisorController::logout();
});


