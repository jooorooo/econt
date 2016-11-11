<?php
namespace Simexis\Econt\Helpers;

use App;

class Locale {

    public static function __callStatic($method, $args = []) {
        $postfix = 'bg' !== App::getLocale() ? '_en' : '';

        return $method . $postfix;
    }

}