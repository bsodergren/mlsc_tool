<?php
/**
 * Command like Metatag writer for video files.
 */

use MLSC\Core\EnvLoader;
use Slim\Factory\AppFactory;

define('__PROJECT_ROOT__', __ROOT_DIRECTORY__);
define('__COMPOSER_LIB__', __ROOT_DIRECTORY__.'/vendor');
define('__CONFIG_LIB__', __ROOT_DIRECTORY__.'/app/Config');
define('__JSON_SETTINGS__', __ROOT_DIRECTORY__.'/app/Settings');

const __CACHE_DIR__        = __ROOT_DIRECTORY__.'/var/cache';

const __LOGFILE_DIR__        = __ROOT_DIRECTORY__.'/var/log';

// set_include_path(get_include_path().\PATH_SEPARATOR.__COMPOSER_LIB__);
ini_set('error_log', __LOGFILE_DIR__.'/phperror.log');
require_once __COMPOSER_LIB__.'/autoload.php';
EnvLoader::LoadEnv(__ROOT_DIRECTORY__)->load();
$container                   = require __CONFIG_LIB__.'/container.php';

require_once __CONFIG_LIB__.'/constants.php';

require_once __CONFIG_LIB__.'/variables.php';

AppFactory::setContainer($container);

return AppFactory::create();
