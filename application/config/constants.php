<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');
date_default_timezone_set('Asia/kolkata');
define('DATE', date('Y-m-d'));
define('DATE_TIME', date('Y-m-d H:i:s'));

defined('NO_DATA')        OR define('NO_DATA', 0); // no errors
defined('SUCCESS')          OR define('SUCCESS', 1); // generic error
defined('INACTIVE_ACCOUNT')         OR define('INACTIVE_ACCOUNT', 2); // configuration error
defined('EMAIL_EXIST')   OR define('EMAIL_EXIST', 4); // file not found
defined('FAILURE')  OR define('FAILURE', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code




define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_DATABASE', 'foodzone');
define('DOMAIN_URL', 'http://localhost/foodzone/');
define('DOMAIN_BASE_URL', $_SERVER['DOCUMENT_ROOT']. '/foodzone/');



define('SITE_URL', DOMAIN_URL );
define('BASE_URL', DOMAIN_BASE_URL);
define('PHP_PATH', 'php');
define("ADMIN_INCLUDE_PATH" ,BASE_URL.'include');  
define('UPLOAD_PATH', DOMAIN_BASE_URL. 'upload/');
define('UPLOAD_URL', DOMAIN_URL. 'upload/');


define("TBL_PREFIX", "tbl_");
define("TBL_CATEGORIES", TBL_PREFIX . "categories");
define("TBL_SUBCATEGORIES", TBL_PREFIX . "subcategories");
define("TBL_CITY", TBL_PREFIX . 'city');
define("TBL_STATE", TBL_PREFIX . 'state');
define("TBL_COUNTRY", TBL_PREFIX . 'country');
define("TBL_USERS", TBL_PREFIX . 'users');
define("TBL_DEVICE_TOKENS", TBL_PREFIX . 'device_token');
define("TBL_OWNERS", TBL_PREFIX . 'owner');
define("TBL_RESTAURANTS", TBL_PREFIX . 'restaurants');
define("TBL_ADDRESS", TBL_PREFIX . 'user_addresses');
define("TBL_ORDERS", TBL_PREFIX . 'orders');
define("TBL_ORDERDETAIL", TBL_PREFIX . 'order_details');
define("TBL_NOTIFICATIONS", TBL_PREFIX . 'notification');    
define("TBL_TRANSACTION", TBL_PREFIX . 'transaction');
define("TBL_SETTINGS", TBL_PREFIX . 'settings');
define("TBL_EARNINGS", TBL_PREFIX . 'earnings');
define("TBL_ORDER_DRIVERS", TBL_PREFIX . 'driver_orders');
define("TBL_DRIVER_REVIEW", TBL_PREFIX . 'drivers_review');
define("TBL_RESTAURANT_REVIEW", TBL_PREFIX . 'restaurants_review');
define("TBL_COUPONS", TBL_PREFIX . 'coupons');

