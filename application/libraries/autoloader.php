<?php

namespace application\libraries;

function autoloader_class($className)
{

    if (file_exists("../entities/$className.php"))
        require_once "../entities/$className.php";

    if (file_exists("../libraries/$className.php"))
        require_once "../libraries/$className.php";

    if (file_exists("../models/$className.php"))
        require_once "../models/$className.php";
}

spl_autoload_register('application\libraries\autoloader_class');
