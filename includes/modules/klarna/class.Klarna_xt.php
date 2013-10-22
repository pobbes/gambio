<?php
/* --------------------------------------------------------------
Released under the GNU General Public License (Version 2)
[http://www.gnu.org/licenses/gpl-2.0.html]
--------------------------------------------------------------
*/
if( !defined('DIR_KLARNA')) {
    define('DIR_KLARNA', dirname(__FILE__).'/');
}
require_once(DIR_KLARNA . 'api/Klarna.php');
include_once(DIR_KLARNA . 'api/pclasses/mysqlstorage.class.php');
define('KLARNA_MODULE_VERSION', '2.0.3');

class Klarna_xt extends Klarna {

    public function __construct() {
        $this->VERSION = 'PHP:xtCommerce:'.KLARNA_MODULE_VERSION.':r67:gambio';
    }

}