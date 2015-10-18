<?php

class BaseController {
    
    public static $rekisterointiTunnus = "virallinenohjaaja";
    public static $language = '/home/mkahri/htdocs/tsoha/vendor/vlucas/valitron/lang';

    public static function get_user_logged_in() {

        if (isset($_SESSION['user'])) {
            $user_id = $_SESSION['user'];
            $user = Supervisor::find($user_id);

            return $user;
        }

        return null;
    }

    public static function check_logged_in() {
        if (!isset($_SESSION['user'])) {
            Redirect::to('/login', array('message' => 'Kirjaudu ensin sisään!'));
        }
    }

}
