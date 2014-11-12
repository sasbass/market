<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define("__SLOGAN", "Simple market");
define('__FONT_INVOICE_SIZE', 10);

/*
 * TABLES DEFINE
 */
define("__TBL_PRODUCTS", "products");
define("__TBL_PRODUCTS_LOG", "products_log");
define("__TBL_USERS", "users");
define("__TBL_SETTINGS", "settings");
define("__TBL_SALES", "sales");
define("__TBL_INVOICES", "invoices");
define("__TBL_INVOICE_SALES", "invoice_sales");
define("__TBL_INVOICE_PRODUCTS", "invoice_products");
define("__TBL_INVOICE_NUMBER", "invoice_number");
define("__TBL_INVOICE_COMPANY_DATA", "invoice_company_data");
define("__TBL_CITY", "city");
define("__TBL_COMPANIES", "campanies");
define("__TBL_PAGES", "pages");
define("__TBL_INVOICE_BUFER","invoice_bufer");


/*
 * DATE FORMATS
 */

define("__DATE_PRODUCT","Y-m-d H:i:s");

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
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */