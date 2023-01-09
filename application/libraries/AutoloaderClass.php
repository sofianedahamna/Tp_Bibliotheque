<?php

/**
 * Description of Autoloader
 *
 * @author GRICOLAT Didier
 */
class Autoloader {

    static function register() {
        spl_autoload_register([CLASS, "autoloader_class"]);
    }

    static function autoloader_class($className) {

        if (file_exists("application/controllers/$className.php"))
            require_once "application/controllers/$className.php";

        if (file_exists("application/config/$className.php"))
            require_once "application/config/$className.php";


        if (file_exists("application/entities/$className.php"))
            require_once "application/entities/$className.php";

        if (file_exists("application/libraries/$className.php"))
            require_once "application/libraries/$className.php";

        if (file_exists("application/models/$className.php"))
            require_once "application/models/$className.php";
    }

}