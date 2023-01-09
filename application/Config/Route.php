<?php
class Route
{

    const DEFAULT_VIEW = "http://localhost/dossier_type_mvc/application/view/authentification.php";
    const DEFAULT_SCHEME_VIEWS = "http://localhost/dossier_type_mvc/application/view/";

    function __construct($route = "default")
    {
        if (isset($route)) :
            switch ($route):
                case "default":
                    $this->defaultRedirection();
                    break;
                case "":

                    break;
                default:

                    break;
            endswitch;
        endif;
    }

    static function defaultRedirection()
    {
        session_destroy();
        header("Location:" . self::DEFAULT_VIEW);
    }

    static function redirection($page)
    {
        header("Location:" . self::DEFAULT_SCHEME_VIEWS . $page);
    }

    function getDefaulRoad()
    {
        return $this->_defaulRoad;
    }

    function setDefaulRoad($defaulRoad): void
    {
        $this->_defaulRoad = $defaulRoad;
    }
}