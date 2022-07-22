<?php
foreach (['Access-Control-Allow-Origin: "*" always', 'Access-Control-Allow-Methods: "POST,GET,OPTIONS" always', 'Access-Control-Allow-Credentials: true always', 'Access-Control-Allow-Headers: "Origin,Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With,Access-Control-Allow-Credentials" always', 'Cache-Control: "max-age=36000000" always'] as $head) header($head);//Setting the headers for the response.
if (!defined('YXORP_HTTP_HOST')) {//Initialise minimum definable varibles
    define('YXORP_HTTP_HOST', $_SERVER['HTTP_HOST']);
    define('YXORP_REQUEST_URI', $_SERVER['REQUEST_URI']);
    define('CHAR_PERIOD', '.');
    define('VAR_TMP', 'tmp');
    define('FILE_TMP', CHAR_PERIOD . VAR_TMP);
    define('DIR_TMP', VAR_TMP . DIRECTORY_SEPARATOR . urlencode(YXORP_HTTP_HOST) . DIRECTORY_SEPARATOR);
    define('CACHE_KEY', rtrim(strtr(base64_encode(YXORP_REQUEST_URI), '+/=', '._-')));
    define('PATH_TMP_DIR', __DIR__ . DIRECTORY_SEPARATOR . DIR_TMP);
    define('PATH_TMP_FILE', __DIR__ . DIRECTORY_SEPARATOR . DIR_TMP . CACHE_KEY . FILE_TMP);
    if ($cacheExits = file_exists(PATH_TMP_FILE)) @include PATH_TMP_FILE; //Render Cache if Exits: Including the file `/tmp` + `base64_encode(YXORP_HTTP_HOST . YXORP_REQUEST_URI)` + `.tmp`.
}
/* Checking if we must clear the cache */
if (isset($_GET["CLECHE"])) foreach (glob(PATH_TMP_DIR . '*') as $file) unlink($file);
if ($cacheExits) exit(die());
/* It defines constants and sets the value of the constants to the value of the arguments passed to the class.  Defining constants. Creating a class called constants.  Defining a constant named `CHAR_SLASH` with the value `/`. */

if (!$GLOBALS[YXORP_HTTP_HOST]) {
    define('CHAR_SLASH', '/');
    define('EXT_TEXT', 'txt');
    define('COOCKIE_JAR', 'cookie_jar');
    define('FILE_COOCKIE_JAR', COOCKIE_JAR . EXT_TEXT);
    /* Creating a global variable with the name of the server host and adding the string 'Initialised' to it. */
    $GLOBALS[YXORP_HTTP_HOST][] = 'Initialised';
    /* Defining a constant. */
    foreach (['VAR_TMP_STORE' => 'TMP_STORE', 'CHAR_UNDER' => '_', 'VAR_TEXT' => 'text', 'VAR_HTML' => 'html', 'VAR_VAR' => 'VAR', 'CHAR_DASH' => '-'] as $key => $value) define($key, $value);

    /* Creating a global variable called TMP_STORE and assigning it an array with the value 'Initialised' */
    $GLOBALS['TMP_STORE'][] = 'Initialised';
    /* Defining a constant called CACHE_FIX. */
    define('CACHE_FIX', ['GuzzleHttp\Psr7\Response::__set_state', 'ArrayObject::__set_state', 'Bugsnag\Breadcrumbs\Recorder::__set_state', 'Bugsnag\Callbacks\GlobalMetaData::__set_state', 'Bugsnag\Callbacks\RequestContext::__set_state', 'Bugsnag\Callbacks\RequestMetaData::__set_state', 'Bugsnag\Callbacks\RequestSession::__set_state', 'Bugsnag\Callbacks\RequestUser::__set_state', 'Bugsnag\Client::__set_state', 'Bugsnag\Configuration::__set_state', 'Bugsnag\HttpClient::__set_state', 'Bugsnag\Internal\FeatureFlagDelegate::__set_state', 'Bugsnag\Middleware\BreadcrumbData::__set_state', 'Bugsnag\Middleware\CallbackBridge::__set_state', 'Bugsnag\Middleware\DiscardClasses::__set_state', 'Bugsnag\Middleware\NotificationSkipper::__set_state', 'Bugsnag\Middleware\SessionData::__set_state', 'Bugsnag\Pipeline::__set_state', 'Bugsnag\Request\BasicResolver::__set_state', 'Bugsnag\SessionTracker::__set_state', 'Closure::__set_state', 'GuzzleHttp\Client::__set_state', 'GuzzleHttp\Cookie\CookieJar::__set_state', 'GuzzleHttp\HandlerStack::__set_state', 'GuzzleHttp\Psr7\Uri::__set_state', 'LimeExtra\App::__set_state', 'LimeExtra\Helper\I18n::__set_state', 'LimeExtra\Helper\SimpleAcl::__set_state', 'Lime\Helper\Cache::__set_state', 'Lime\Module::__set_state', 'Lime\Request::__set_state', 'stdClass::__set_state', 'yxorP\app\lib\http\paramStore::__set_state', 'yxorP\app\lib\http\request::__set_state', 'yxorP\app\lib\http\response::__set_state']);
    /* Defining constants. */

    foreach (['CHAR_HASH' => '#', 'CHAR_EQUALS' => '=', 'CHAR_ASTRIX' => '*', 'CHAR_EMPTY_STRING' => '', 'CHAR_PLUS' => '+', 'CHAR_SLASH_BACK' => '\\', 'CHAR_QUESTION' => '?', 'CHAR_AT' => '@', 'CHAR_CURVE' => '{', 'CHAR_CURVE_CLOSE' => '}', 'CHAR_BRACKET' => '(', 'CHAR_BRACKET_CLOSE' => ')', 'CHAR_S' => 's', 'CHAR_SQUARE' => '[', 'CHAR_SQUARE_CLOSE' => ']', 'CHAR_A' => 'a', 'CHAR_Z' => 'z', 'CHAR_0' => '0', 'CHAR_9' => '9', 'CHAR_UP' => '^', 'CHAR_USD' => '$', 'CHAR_I' => 'i', 'CHAR_COLON' => ':', 'CHAR_EXCLAMATION' => '!', 'CHAR_CAP_P' => 'P', 'CHAR_ARROW' => '<', 'CHAR_ARROW_CLOSE' => '>', 'CHAR_COMMA' => ',', 'CHAR_2' => '2', 'CHAR_1' => '1', 'CHAR_6' => '6', 'CHAR_3' => '3', 'NUM_ENV_LIMIT' => 2, 'EXT_JSON' => CHAR_PERIOD . 'json', 'EXT_PHP' => CHAR_PERIOD . 'php', 'EXT_ENV' => CHAR_PERIOD . 'env', 'EXT_PHAR' => CHAR_PERIOD . 'phar', 'VAR_USER' => 'user', 'VAR_NAME' => 'name', 'VAR_EMAIL' => 'email', 'VAR_PASSWORD' => 'password', 'VAR_GROUP' => 'group', 'VAR_ACTIVE' => 'active', 'VAR_COCKPIT' => 'cockpit', 'VAR_I18N' => 'i18n', 'VAR_CREATED' => '_created', 'VAR_MODIFIED' => '_modified', 'VAR_USER_IP' => 'user_ip', 'VAR_USER_IP_LONG' => 'user_ip_long', 'VAR_URL' => 'url', 'VAR_URL_HOST' => 'url_host', 'VAR_HTTPS' => 'https:' . CHAR_SLASH . CHAR_SLASH, 'VAR_HTTPS_ONLY' => 'https', 'VAR_ALLOW_REDIRECTS' => 'allow_redirects', 'VAR_HTTP_ERRORS' => 'http_errors', 'VAR_DECODE_CONTENT' => 'decode_content', 'VAR_VERIFY' => 'verify', 'VAR_COOKIES' => 'cookies', 'VAR_IDN_CONVERSION' => 'idn_conversion', 'VAR_APPLICATION_URLENCODED' => 'application/x-www-form-urlencoded', 'VAR_CONTENT_TYPE' => 'content-type', 'VAR_CONTENT_LENGTH' => 'content-length', 'VAR_TYPE' => 'type', 'VAR_ERROR' => 'error', 'VAR_TMP_NAME' => 'tmp_name', 'VAR_GET_URL' => 'getUrl', 'VAR_UCFIRST' => 'ucfirst', 'VAR_STRTOLOWER' => 'strtolower', 'VAR_HTTP' => 'http:', 'VAR_INTERFACE' => 'Interface', 'VAR_GETCSV' => 'str_getcsv', 'VAR_DOMAIN' => 'domain', 'VAR_PATTERN' => 'pattern', 'VAR_PATTERN_UP' => 'PATTERN', 'VAR_REPLACE' => 'replace', 'VAR_SERVER' => 'SERVER', 'VAR_GUZZLE' => 'guzzle', 'VAR_BUGSNAG' => 'bugsnag', 'VAR_RESPONSE' => 'RESPONSE', 'VAR_REQUEST' => 'REQUEST', 'VAR_COCKPIT_ACCOUNTS' => 'accounts', 'VAR_PLUGINS' => 'plugins', 'VAR_TARGET' => 'TARGET', 'VAR_TARGET_PATTERN' => 'TARGET_PATTERN', 'VAR_TARGET_REPLACE' => 'TARGET_REPLACE', 'VAR_SITE' => 'SITE', 'VAR_HOST' => 'HOST', 'VAR_COCKPIT' => 'COCKPIT', 'VAR_INSTALL' => 'INSTALL', 'VAR_INC' => 'INC', 'VAR_REPLACE_UP' => 'REPLACE', 'VAR_REWRITE' => 'REWRITE', 'VAR_SEARCH' => 'SEARCH', 'VAR_FILES' => 'files', 'VAR_PHP' => 'PHP', 'VAR_SELF' => 'SELF', 'VAR_APP' => 'APP', 'VAR_NAME_UP' => 'NAME', 'VAR_URL_UP' => 'URL', 'VAR_PARSE_UP' => 'PARSE', 'VAR_URI' => 'URI', 'VAR_SUB' => 'SUB', 'VAR_DOMAIN_UP' => 'DOMAIN', 'VAR_DIR' => 'DIR', 'VAR_FULL' => 'FULL', 'VAR_HTTPS_UP' => 'HTTPS', 'VAR_HTTP_UP' => 'HTTP', 'VAR_METHOD' => 'METHOD', 'VAR_REMOTE' => 'REMOTE', 'VAR_ADDR' => 'ADDR', 'VAR_EVENT' => 'EVENT', 'VAR_MIME' => 'mime', 'VAR_TYPES' => 'TYPES', 'VAR_LIST' => 'LIST', 'VAR_GLOBAL_UP' => 'GLOBAL', 'VAR_GLOBALS' => 'GLOBALS', 'VAR_GLOBAL' => 'global', 'VAR_VALUE' => 'value', 'TARGET_DOMAIN' => 'TARGET_DOMAIN', 'SITE_DETAILS' => 'SITE_DETAILS', 'SITE_DOMAIN' => 'SITE_DOMAIN', 'SUFFIX_LIST' => 'SUFFIX_LIST', 'VAR_DASH_LOWER' => CHAR_DASH . CHAR_UNDER, 'VAR_TEXT_HTML' => VAR_TEXT . CHAR_SLASH . VAR_HTML, 'VAR_VAR_UNDER' => CHAR_UNDER . VAR_VAR, 'VAR_VAR_UNDER_END' => CHAR_UNDER . VAR_VAR . CHAR_UNDER, 'COCKPIT_YXORP' => 'cockpit', 'COCKPIT_YXORP_DATA' => 'cockpit'] as $key => $value) define($key, $value);
    /* Defining constants. */
    foreach (['COCKPIT_ACCOUNTS' => COCKPIT_YXORP_DATA . CHAR_SLASH . VAR_COCKPIT_ACCOUNTS, 'COCKPIT_COLLECTIONS' => 'collections', 'COCKPIT_SITES' => 'sites', 'COCKPIT_HOST' => 'host', 'COCKPIT_TARGET' => 'target', 'DIR_ACTION' => 'action' . DIRECTORY_SEPARATOR, 'DIR_PARSER' => 'parser' . DIRECTORY_SEPARATOR, 'DIR_PLUGIN' => 'plugin' . DIRECTORY_SEPARATOR, 'DIR_OVERRIDE' => 'override' . DIRECTORY_SEPARATOR, 'DIR_GLOBAL' => VAR_GLOBAL . DIRECTORY_SEPARATOR, 'DIR_LIBLUDES' => 'includes' . DIRECTORY_SEPARATOR, 'DIR_INSTALL' => 'install' . DIRECTORY_SEPARATOR, 'DIR_COCKPIT' => COCKPIT_YXORP . DIRECTORY_SEPARATOR, 'DIR_ACCOUNTS' => VAR_COCKPIT_ACCOUNTS . DIRECTORY_SEPARATOR, 'DIR_LIB' => 'lib' . DIRECTORY_SEPARATOR, 'DIR_VENDOR' => 'vendor' . DIRECTORY_SEPARATOR, 'DIR_APP' => 'app' . DIRECTORY_SEPARATOR, 'DIR_DATA' => 'data' . DIRECTORY_SEPARATOR, 'DIR_STORAGE' => 'storage' . DIRECTORY_SEPARATOR, 'DIR_HTTP' => 'http' . DIRECTORY_SEPARATOR, 'DIR_MINIFY' => 'minify' . DIRECTORY_SEPARATOR, 'DIR_BUGSNAG' => 'snag' . DIRECTORY_SEPARATOR, 'DIR_GUZZLE' => 'proxy' . DIRECTORY_SEPARATOR, 'DIR_PSR' => 'psr' . DIRECTORY_SEPARATOR, 'DIR_DEBUG' => 'debug' . DIRECTORY_SEPARATOR, 'EVENT_BUILD_CACHE' => 'request' . CHAR_PERIOD . 'build_cached', 'EVENT_BUILD_CONTEXT' => 'request' . CHAR_PERIOD . 'build_context', 'EVENT_BUILD_INCLUDES' => 'request' . CHAR_PERIOD . 'build_includes', 'EVENT_BUILD_HEADERS' => 'request' . CHAR_PERIOD . 'build_headers', 'EVENT_BUILD_REQUEST' => 'request' . CHAR_PERIOD . 'build_request', 'EVENT_BEFORE_SEND' => 'request' . CHAR_PERIOD . 'before_send', 'EVENT_SEND' => 'request' . CHAR_PERIOD . 'send', 'EVENT_SENT' => 'request' . CHAR_PERIOD . 'sent', 'EVENT_COMPLETE' => 'request' . CHAR_PERIOD . 'complete', 'EVENT_FINAL' => 'request' . CHAR_PERIOD . 'final', 'EVENT_EXCEPTION' => 'request' . CHAR_PERIOD . 'build_exception', 'EVENT_WRITE' => 'curl' . CHAR_PERIOD . 'callback' . CHAR_PERIOD . 'write', 'FILE_REWRITE' => 'rewrite' . EXT_JSON, 'FILE_INDEX' => 'index' . EXT_PHP, 'FILE_WRAPPER' => 'wrapper' . EXT_PHP, 'FILE_COCKPIT_BOOTSTRAP' => 'bootstrap' . EXT_PHP, 'FILE_MIME_TYPES' => VAR_MIME . EXT_JSON, 'FILE_GUZZLE' => VAR_GUZZLE . EXT_PHAR, 'FILE_BUGSNAG' => VAR_BUGSNAG . EXT_PHAR, 'FILE_TLDS_ALPHA_BY_DOMAIN' => 'tlds-alpha-by-domain.txt', 'FILE_PUBLIC_SUFFIX_LIST' => 'public_suffix_list.dat', 'SUBSCRIBE_METHOD' => 'subscribe', 'YXORP_EVENT_LIST' => VAR_EVENT . CHAR_UNDER . VAR_LIST, 'YXORP_MIME_TYPES' => VAR_MIME . CHAR_UNDER . VAR_TYPES, 'YXORP_REWRITE' => VAR_INC . CHAR_UNDER . VAR_REWRITE, 'YXORP_COCKPIT_INSTALL' => VAR_COCKPIT . CHAR_UNDER . VAR_INSTALL, 'YXORP_COCKPIT_APP' => VAR_COCKPIT . CHAR_UNDER . VAR_APP, 'YXORP_PHP_SELF' => VAR_PHP . CHAR_UNDER . VAR_SELF, 'YXORP_REQUEST_METHOD' => VAR_REQUEST . CHAR_UNDER . VAR_METHOD, 'YXORP_HTTP_' => VAR_HTTPS_UP . CHAR_UNDER, 'YXORP_REMOTE_ADDR' => VAR_REMOTE . CHAR_UNDER . VAR_ADDR, 'YXORP_TARGET_PLUGINS' => 'TARGET_PLUGINS', 'YXORP_GLOBAL_REPLACE' => VAR_GLOBAL_UP . CHAR_UNDER . VAR_REPLACE, 'YXORP_GLOBAL_PATTERN' => VAR_GLOBAL_UP . CHAR_UNDER . VAR_PATTERN, 'REG_ONE' => CHAR_SLASH . CHAR_SLASH_BACK . CHAR_QUESTION . CHAR_PERIOD . CHAR_ASTRIX . CHAR_SLASH, 'REG_TWO' => CHAR_HASH . CHAR_PERIOD . CHAR_ASTRIX . CHAR_SLASH, 'REG_THREE' => CHAR_AT . CHAR_CURVE . CHAR_BRACKET . CHAR_SQUARE . CHAR_A . CHAR_DASH . CHAR_Z . CHAR_0 . CHAR_DASH . CHAR_9 . CHAR_UNDER . CHAR_SQUARE_CLOSE . CHAR_PLUS . CHAR_BRACKET_CLOSE . CHAR_CURVE_CLOSE . CHAR_AT . CHAR_S, 'REG_FOUR' => CHAR_SLASH_BACK . CHAR_ASTRIX, 'REG_FIVE' => CHAR_PERIOD . CHAR_ASTRIX, 'REG_SIX' => CHAR_SLASH_BACK . CHAR_QUESTION, 'REG_SEVEN' => CHAR_HASH . CHAR_UP, 'REG_EIGHT' => CHAR_HASH . CHAR_UP . VAR_HTTPS_ONLY . CHAR_QUESTION . CHAR_COLON . CHAR_HASH . CHAR_I, 'REG_NINE' => CHAR_HASH . CHAR_SLASH . CHAR_SQUARE . CHAR_UP . CHAR_SLASH . CHAR_SQUARE_CLOSE . CHAR_ASTRIX . CHAR_USD . CHAR_HASH, 'REG_TEN' => CHAR_HASH . CHAR_SLASH . CHAR_QUESTION . CHAR_EXCLAMATION . CHAR_SLASH_BACK . CHAR_PERIOD . CHAR_SLASH_BACK . CHAR_PERIOD . CHAR_BRACKET_CLOSE . CHAR_SQUARE . CHAR_UP . CHAR_SLASH . CHAR_SQUARE_CLOSE . CHAR_PLUS . CHAR_SLASH . CHAR_SLASH_BACK . CHAR_PERIOD . CHAR_SLASH_BACK . CHAR_PERIOD . CHAR_SLASH . CHAR_HASH, 'REG_ELEVEN' => CHAR_HASH . CHAR_BRACKET . CHAR_SLASH . CHAR_SLASH_BACK . CHAR_PERIOD . CHAR_QUESTION . CHAR_SLASH . CHAR_BRACKET_CLOSE . CHAR_HASH, 'REG_TWELVE' => CHAR_SLASH . CHAR_BRACKET . CHAR_QUESTION . CHAR_CAP_P . CHAR_ARROW . VAR_DOMAIN . CHAR_ARROW_CLOSE . CHAR_SQUARE . CHAR_A . CHAR_DASH . CHAR_Z . CHAR_0 . CHAR_DASH . CHAR_9 . CHAR_SQUARE_CLOSE . CHAR_SQUARE . CHAR_A . CHAR_DASH . CHAR_Z . CHAR_0 . CHAR_DASH . CHAR_9 . CHAR_SLASH_BACK . CHAR_DASH . CHAR_SQUARE_CLOSE . CHAR_CURVE . CHAR_1 . CHAR_COMMA . CHAR_6 . CHAR_3 . CHAR_CURVE_CLOSE . CHAR_SLASH_BACK . CHAR_PERIOD . CHAR_SQUARE . CHAR_A . CHAR_DASH . CHAR_Z . CHAR_PERIOD . CHAR_SQUARE_CLOSE . CHAR_CURVE . CHAR_2 . CHAR_COMMA . CHAR_6 . CHAR_CURVE_CLOSE . CHAR_BRACKET_CLOSE . CHAR_USD . CHAR_SLASH . CHAR_I, 'ENV_ADMIN_USER' => 'COCKPIT_USER' . EXT_ENV, 'ENV_ADMIN_NAME' => 'COCKPIT_NAME' . EXT_ENV, 'ENV_ADMIN_EMAIL' => 'COCKPIT_EMAIL' . EXT_ENV, 'ENV_ADMIN_PASSWORD' => 'COCKPIT_PASSWORD' . EXT_ENV, 'ENV_GA_UTM' => 'GA_UTM' . EXT_ENV, 'ENV_BUGSNAG_KEY' => 'BUGSNAG_KEY' . EXT_ENV, 'ENV_DEBUG' => 'DEBUG' . EXT_ENV, 'ENV_DEFAULT_SITE' => 'DEFAULT_SITE' . EXT_ENV, 'ENV_DEFAULT_TARGET' => 'DEFAULT_TARGET' . EXT_ENV, 'RUNTIME_EXCEPTION' => 'Directory "%s" was not created', 'ACCESS_DENIED_EXCEPTION' => 'Error: Access denied!', 'ACCESS_ALREADY_DEFINED' => 'Argument already exists and cannot be redefined!', 'CACHE_EXPIRATION' => @time() + (60 * 60 * 24 * 31 * 365)] as $key => $value) define($key, $value);
}
