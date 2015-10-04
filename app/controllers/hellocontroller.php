<?php

class HelloController extends BaseController {

    public static function frontpage() {
        View::make('/home.html');
    }

  public static function sandbox(){
    $aihe = Topic::find(1);
    $aiheet = Topic::all();
    Kint::dump($aiheet);
    Kint::dump($aihe);
    }
}
