<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        echo 'Tämä ön etysivy!';
    }

  public static function sandbox(){
    $aihe = Aihe::find(1);
    $aiheet = Aihe::all();
    // Kint-luokan dump-metodi tulostaa muuttujan arvon
    Kint::dump($aiheet);
    Kint::dump($aihe);
  }

    public static function aiheet() {
        View::make('suunnitelmat/aiheet.html');
    }

    public static function aihe() {
        View::make('suunnitelmat/aihe.html');
    }

    public static function muokkaus() {
        View::make('suunnitelmat/muokkaus.html');
    }
    
    public static function etusivu() {
        View::make('suunnitelmat/home.html');
    }
    
    public static function tapahtuma() {
        View::make('suunnitelmat/tapahtuma.html');
    }    

}
