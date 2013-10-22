<?php
/**
 * 888888ba                 dP  .88888.                    dP                
 * 88    `8b                88 d8'   `88                   88                
 * 88aaaa8P' .d8888b. .d888b88 88        .d8888b. .d8888b. 88  .dP  .d8888b. 
 * 88   `8b. 88ooood8 88'  `88 88   YP88 88ooood8 88'  `"" 88888"   88'  `88 
 * 88     88 88.  ... 88.  .88 Y8.   .88 88.  ... 88.  ... 88  `8b. 88.  .88 
 * dP     dP `88888P' `88888P8  `88888'  `88888P' `88888P' dP   `YP `88888P' 
 *
 *                          m a g n a l i s t e r
 *                                      boost your Online-Shop
 *
 * -----------------------------------------------------------------------------
 * $Id: MagnaDB.php 1607 2012-04-11 10:00:46Z derpapst $
 *
 * (c) 2010 - 2011 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the GNU General Public License v2 or later
 * -----------------------------------------------------------------------------
 */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

define('TABLE_MAGNA_CONFIG', 'magnalister_config');
define('TABLE_MAGNA_SESSION', 'magnalister_session');
define('TABLE_MAGNA_SELECTION', 'magnalister_selection');
define('TABLE_MAGNA_SELECTION_TEMPLATES', 'magnalister_selection_templates');
define('TABLE_MAGNA_SELECTION_TEMPLATE_ENTRIES', 'magnalister_selection_template_entries');
define('TABLE_MAGNA_ORDERS', 'magnalister_orders');
define('TABLE_MAGNA_VARIATIONS', 'magnalister_variations');
define('TABLE_MAGNA_AMAZON_PROPERTIES', 'magnalister_amazon_properties');
define('TABLE_MAGNA_AMAZON_ERRORLOG', 'magnalister_amazon_errorlog');
define('TABLE_MAGNA_AMAZON_APPLY', 'magnalister_amazon_apply');
define('TABLE_MAGNA_CS_ERRORLOG', 'magnalister_cs_errorlog');
define('TABLE_MAGNA_CS_DELETEDLOG', 'magnalister_cs_deletedlog');
define('TABLE_MAGNA_YATEGO_CATEGORIES', 'magnalister_yatego_categories');
define('TABLE_MAGNA_YATEGO_CUSTOM_CATEGORIES', 'magnalister_yatego_custom_categories');
define('TABLE_MAGNA_YATEGO_CATEGORYMATCHING', 'magnalister_yatego_categorymatching');
define('TABLE_MAGNA_EBAY_CATEGORIES', 'magnalister_ebay_categories');
define('TABLE_MAGNA_EBAY_PROPERTIES', 'magnalister_ebay_properties');
define('TABLE_MAGNA_EBAY_LISTINGS', 'magnalister_ebay_listings');
define('TABLE_MAGNA_EBAY_ERRORLOG', 'magnalister_ebay_errorlog');
define('TABLE_MAGNA_EBAY_DELETEDLOG', 'magnalister_ebay_deletedlog');
define('TABLE_MAGNA_TECDOC', 'magnalister_tecdoc');
define('TABLE_MAGNA_API_REQUESTS', 'magnalister_api_requests');
define('TABLE_MAGNA_MEINPAKET_CATEGORYMATCHING', 'magnalister_meinpaket_categorymatching');
define('TABLE_MAGNA_MEINPAKET_CATEGORIES', 'magnalister_meinpaket_categories');
define('TABLE_MAGNA_MEINPAKET_ERRORLOG', 'magnalister_meinpaket_errorlog');
define('TABLE_MAGNA_COMPAT_CATEGORYMATCHING', 'magnalister_magnacompat_categorymatching');
define('TABLE_MAGNA_COMPAT_CATEGORIES', 'magnalister_magnacompat_categories');
define('TABLE_MAGNA_COMPAT_ERRORLOG', 'magnalister_magnacompat_errorlog');
define('TABLE_MAGNA_COMPAT_DELETEDLOG', 'magnalister_magnacompat_deletedlog');

define('MAGNADB_ENABLE_LOGGING', MAGNA_DEBUG && false);

/* Fallback functions, xtc-like */
function mmysql_error($query, $errno, $error) {
	die(
		'<span style="color:#000000;font-weight:bold;">
			' . $errno . ' - ' . $error . '<br /><br />
			<pre>' . $query . '</pre><br /><br />
			<pre style="font-weight:normal">'.print_r(array_slice(debug_backtrace(true), 4), true).'</pre><br /><br />
			<small style="color:#ff0000;font-weight:bold;">[SQL Error]</small>
		</span>'
	);
}

function mmysql_query($query, $link = 'db_link') {
    global $$link;
    $i = 8;
    $errno = 0;

    do {
        $result = mysql_query($query, $$link) or $errno = mysql_errno();
        if ($i-- < 1) break;
    } while (2006 == $errno); # retry if '2006 MySQL server has gone away'

    if (0 != $errno) {
        mmysql_error($query, $errno, mysql_error());
    }

    return $result;
}

function mmysql_num_rows($db_query) {
	return mysql_num_rows($db_query);
}

function mmysql_fetch_array($db_query) {
    return mysql_fetch_array($db_query, MYSQL_ASSOC);
}

function mmysql_insert_id() {
    return mysql_insert_id();
}

function mmysql_affected_rows() {
	return mysql_affected_rows();
}

class MagnaDB {
	private static $instance = NULL;
	private $link;
	private $resourcelink;
	private $selfConnected = false;
	private $destructed = false;

	private $query;
	private $error;
	private $result;

	private $start;
	protected $count;
	private $querytime;
	private $timePerQuery = array();

	private $availabeTables = array();

	private $escapeStrings;

	private $sessionLifetime;
	
	private $sqlFunc = array();

	private $showDebugOutput = MAGNA_DEBUG;

	/**
	 * Class constructor
	 */
	private function __construct($link = 'db_link') {
		global $$link, $_MagnaSession, $_MagnaShopSession;

		$this->link          = &$link;
		$this->resourcelink  = &$$link;
		$this->start         = microtime(true);
		$this->count         = 0;
		$this->querytime     = 0;
		$this->escapeStrings = get_magic_quotes_gpc();

		if (function_exists('xtc_db_query')) {
			$this->sqlFunc = array(
				'query' => 'mmysql_query',
				'num_rows' => 'xtc_db_num_rows',
				'affected_rows' => 'xtc_db_affected_rows',
				'fetch_array' => 'xtc_db_fetch_array',
				'insert_id' => 'xtc_db_insert_id',
			);
		} else if (function_exists('tep_db_query')) {
			$this->sqlFunc = array(
				'query' => 'mmysql_query',
				'num_rows' => 'tep_db_num_rows',
				'affected_rows' => 'tep_db_affected_rows',
				'fetch_array' => 'tep_db_fetch_array',
				'insert_id' => 'tep_db_insert_id',
			);
		} else {
			$this->sqlFunc = array(
				'query' => 'mmysql_query',
				'num_rows' => 'mmysql_num_rows',
				'affected_rows' => 'mmysql_affected_rows',
				'fetch_array' => 'mmysql_fetch_array',
				'insert_id' => 'mmysql_insert_id',
			);
		}
		foreach ($this->sqlFunc as $id => &$fnName) {
			if (!function_exists($fnName)) {
				$fnName = 'mmysql_'.$id;
			}
		}
		# Wenn keine Verbindung im klassischen Sinne besteht, selbst eine herstellen.
		if (!is_resource($this->resourcelink)) {
			$this->sqlFunc = array(
				'query' => 'mmysql_query',
				'num_rows' => 'mmysql_num_rows',
				'affected_rows' => 'mmysql_affected_rows',
				'fetch_array' => 'mmysql_fetch_array',
				'insert_id' => 'mmysql_insert_id',
			);
			$this->resourcelink = mysql_connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD) or die(__METHOD__.': '.mysql_error());
			mysql_select_db(DB_DATABASE, $this->resourcelink) or die(__METHOD__.': '.mysql_error());
		}

		$this->availabeTables = $this->fetchArray('SHOW TABLES', true);

		if ($this->tableExists(TABLE_MAGNA_SESSION)) {
			$this->sessionLifetime = (int)ini_get("session.gc_maxlifetime");
			$this->sessionGarbageCollector();

			$_MagnaSession = $this->sessionRead();
			$_MagnaShopSession = $this->shopSessionRead();
		}
		if (MAGNADB_ENABLE_LOGGING) {
			$dbt = @debug_backtrace();
			if (!empty($dbt)) {
				foreach ($dbt as $step) {
					if (strpos($step['file'], 'magnaCallback') !== false) {
						$dbt = true;
						unset($step);
						break;
					}
				}
			}
			if ($dbt !== true) {
				file_put_contents(dirname(__FILE__).'/db_guery.log', "### Query Log ".date("Y-m-d H:i:s")." ###\n\n");
			}
			unset($dbt);
		}
	}
	
	/**
	 * Singleton - gets Instance
	 */
	public static function gi($link = 'db_link') {
		if (self::$instance == NULL) {
			self::$instance = new self($link);
		}
		return self::$instance;
	}

	private function __clone() {}

	public function __destruct() {
		global $_MagnaSession, $_MagnaShopSession;
		
		if (!is_object($this) || !isset($this->destructed) || $this->destructed) return;
		$this->destructed = true;

		if (!defined('MAGNALISTER_PASSPHRASE') && !defined('MAGNALISTER_PLUGIN')) {
			/* Only when this class is instantiated from magnaCallback
			   and the plugin isn't activated yet.
			*/
			return;
		}

		if ($this->tableExists(TABLE_MAGNA_SESSION)) {
			$this->sessionStore($_MagnaSession, session_id());
			$this->sessionStore($_MagnaShopSession, '0');
		}
		if ($this->tableExists(TABLE_MAGNA_SELECTION)) {
			$this->update(
				TABLE_MAGNA_SELECTION, array(
					'expires' => gmdate('Y-m-d H:i:d', (time() + $this->sessionLifetime))
				), array(
					'session_id' => session_id()
				)
			);
		}
		if (MAGNA_DEBUG && $this->showDebugOutput && function_exists('microtime2human') 
			&& (
				!defined('MAGNA_CALLBACK_MODE') || (MAGNA_CALLBACK_MODE != 'UTILITY')
			) && (stripos($_SERVER['PHP_SELF'].serialize($_GET), 'ajax') === false)
		) {
			echo '<!-- Final Stats :: QC:'.$this->getQueryCount().'; QT:'.microtime2human($this->getRealQueryTime()).'; -->';
		}
		if ($this->selfConnected) {
			mysql_close($this->resourcelink);
		}
	}

	private function prepareError() {
		if (!$this->resourcelink) {
			$errNo = mysql_errno();
			if ($errNo == 0) {
				return '';
			}
			return mysql_error().' ('.$errNo.')';
		} else {
			$errNo = mysql_errno($this->resourcelink);
			if ($errNo == 0) {
				return '';
			}
			return mysql_error($this->resourcelink).' ('.$errNo.')';
		}
	}

	/**
	 * Send a query
	 */
	public function query($query, $verbose = false) {
		/* {Hook} "MagnaDB_Query": Enables you to extend, modify or log query that goes to the database	.<br>
		   Variables that can be used: <ul><li>$query: The SQL string</li></ul>
		 */
		if (function_exists('magnaContribVerify') && (($hp = magnaContribVerify('MagnaDB_Query', 1)) !== false)) {
			require($hp);
		}

		$this->query = $query;
		if ($verbose || false) {
			echo function_exists('print_m') ? print_m($this->query)."\n" : $this->query."\n";
		}
		if (MAGNADB_ENABLE_LOGGING) {
			file_put_contents(dirname(__FILE__).'/db_guery.log', "### ".$this->count."\n".$this->query."\n\n", FILE_APPEND);
		}
		$t = microtime(true);
		$this->result = $this->sqlFunc['query']($this->query);
		$t = microtime(true) - $t;
		$this->querytime += $t;
		$this->timePerQuery[] = array (
			'query' => $this->query,
			'time' => $t
		);
		++$this->count;
		//echo print_m(debug_backtrace());
		if (!$this->result) {
			$this->error = $this->prepareError();
			return false;
		}

		return $this->result;
	}

	private function sessionGarbageCollector() {
		if ($this->tableExists(TABLE_MAGNA_SESSION)) {
			$this->query("DELETE FROM ".TABLE_MAGNA_SESSION." WHERE expire < '".(time() - $this->sessionLifetime)."' AND session_id <> '0'");
		}
		if ($this->tableExists(TABLE_MAGNA_SELECTION)) {
			$this->query("DELETE FROM ".TABLE_MAGNA_SELECTION." WHERE expires < '".gmdate('Y-m-d H:i:d', (time() - $this->sessionLifetime))."'");
		}
	}

	private function sessionRead() {
		$result = $this->fetchOne(
			"SELECT data FROM ".TABLE_MAGNA_SESSION." ".
			"WHERE session_id = '".session_id()."' AND expire > '".time()."'",
			true
		);
		if (!empty($result)) {
			return @unserialize($result);
		}
		return array();
	}

	private function shopSessionRead() {
		/* This "Session" is for all Backend users and it _never_ expires! */
		$result = $this->fetchOne(
			"SELECT data FROM ".TABLE_MAGNA_SESSION." ".
			"WHERE session_id = '0'",
			true
		);

		if (!empty($result)) {
			return @unserialize($result);
		}
		return array();
	}

	private function sessionStore($data, $sessionID) {
		if (empty($sessionID) && ($sessionID != '0')) return;
		if ($this->recordExists(TABLE_MAGNA_SESSION, array('session_id' => $sessionID))) {
			$this->update(TABLE_MAGNA_SESSION, array(
					'data' => serialize($data),
					'expire' => (time() + (($sessionID == '0') ? 0 : $this->sessionLifetime))
				), array(
					'session_id' => $sessionID
				)
			);
		} else if (!empty($data)) {
			$this->insert(TABLE_MAGNA_SESSION, array(
				'session_id' => $sessionID,
				'data' => serialize($data),
				'expire' => (time() + (($sessionID == '0') ? 0 : $this->sessionLifetime))
			), true);
		}
	}

	public function escape($object) {
		if (is_array($object)) {
			$object = array_map(array('MySQL', 'escape'), $object);
		} else if (is_string($object)) {
			if ($this->escapeStrings) {
				if ($this->resourcelink == null) {
					$object = mysql_real_escape_string(stripslashes($object));
				} else {
					$object = mysql_real_escape_string(stripslashes($object), $this->resourcelink);
				}
			} else {
				if ($this->resourcelink == null) {
					$object = mysql_real_escape_string($object);
				} else {
					$object = mysql_real_escape_string($object, $this->resourcelink);
				}
			}
		}

		return $object;
	}

	/**
	 * Get number of rows
	 */
	public function numRows($result = null) {
		if ($result === null) {
			$result = $this->result;
		}

		if ($result === false) {
			return false;
		}

		return $this->sqlFunc['num_rows']($result);
	}

	/**
	 * Get number of changed/affected rows
	 */
	public function affectedRows($result = null) {
		if ($result === null) {
			$result = $this->result;
		}

		if ($result === false) {
			return false;
		}

		return $this->sqlFunc['affected_rows']($result);
	}

	/**
	 * Get number of found rows
	 */
	public function foundRows() {
		return $this->fetchOne("SELECT FOUND_ROWS()");
	}

	/**
	 * Get a single value
	 */
	public function fetchOne($query) {
		$this->result = $this->query($query);

		if (!$this->result) {
			return false;
		}

		if ($this->numRows($this->result) > 1) {
			$this->error = __METHOD__.' can only return a single value (multiple rows returned).';
			return false;

		} else if ($this->numRows($this->result) < 1) {
			$this->error = __METHOD__.' cannot return a value (zero rows returned).';
			return false;
		}

		$return = $this->fetchNext($this->result);
		if (!is_array($return) || empty($return)) {
			return false;
		}
		$return = array_shift($return);
		return $return;
	}

	/**
	 * Get next row of a result
	 */
	public function fetchNext($result = null) {
		if ($result === null) {
			$result = $this->result;
		}

		if ($this->numRows($result) < 1) {
			return false;
		} else {
			$row = $this->sqlFunc['fetch_array']($result);
			if (!$row) {
				$this->error = $this->prepareError();
				return false;
	 		}
		}

		return $row;
	}

	/**
	 * Fetch a row
	 */
	public function fetchRow($query) {
		$this->result = $this->query($query);

		return $this->fetchNext($this->result);
	}

	public function fetchArray($query, $singleField = false) {
		if (is_resource($query)) {
			$this->result = $query;
		} else if (is_string($query)) {
			$this->result = $this->query($query);
		}

		if (!$this->result) {
			return false;
		}

		$array = array();

		while ($row = $this->fetchNext($this->result)) {
			if ($singleField && (count($row) == 1)) {
				$array[] = array_pop($row);
			} else {
				$array[] = $row;
			}
		}

		return $array;
	}

	public function tableExists($table) {
		return in_array($table, $this->availabeTables);
	}

	public function getAvailableTables($pattern = '') {
		if (empty($pattern)) return $this->availabeTables;
		$tbls = array();
		foreach ($this->availabeTables as $t) {
			if (preg_match($pattern, $t)) {
				$tbls[] = $t;
			}
		}
		return $tbls;
	}

	public function tableEmpty($table) {
		return ($this->fetchOne('SELECT * FROM '.$table.' LIMIT 1') === false);
	}

	public function mysqlVariableValue($variable) {
		$showVariablesLikeVariable = $this->fetchRow("SHOW VARIABLES LIKE '$variable'");
		if ($showVariablesLikeVariable)
			return $showVariablesLikeVariable['Value'];
		else return null;
		# nicht false zurueckgeben, denn dies koennte ein gueltiger Variablenwert sein
	}

	public function mysqlSetHigherTimeout($timeoutToSet = 3600) {
		if ($this->mysqlVariableValue('wait_timeout') < $timeoutToSet) {
			$this->query("SET wait_timeout = $timeoutToSet");
		}
		if ($this->mysqlVariableValue('interactive_timeout') < $timeoutToSet) {
			$this->query("SET interactive_timeout = $timeoutToSet");
		}
	}

	public function tableEncoding($table) {
		$showCreateTable = $this->fetchRow('SHOW CREATE TABLE `'.$table.'`');
		if (preg_match("/CHARSET=([^\s]*).*/", $showCreateTable['Create Table'], $matched)) {
			return $matched[1];
		}
		$charSet = $this->mysqlVariableValue('character_set_database');
		if (empty($charSet)) return false;
		return $charSet;
	}


	public function	columnExistsInTable($column, $table) {
		$columns = $this->fetchArray('DESC  '.$table);
		foreach($columns as $column_description) {
			if($column_description['Field'] == $column) return true;
		}
		return false;
	}

	public function	columnType($column, $table) {
		$columns = $this->fetchArray('DESC  '.$table);
		foreach($columns as $column_description) {
			if($column_description['Field'] == $column) return $column_description['Type'];
		}
		return false;
	}

	public function recordExists($table, $conditions) {
		if (!is_array($conditions) || empty($conditions))
			trigger_error(sprintf("%s: Second parameter has to be an array may not be empty!", __FUNCTION__), E_USER_WARNING);
		$fields = array();
		$values = array();
		foreach ($conditions as $f => $v) {
			$fields[] = '`'.$f.'`';
			$values[] = '`'.$f."` = '".$this->escape($v)."'";
		}
		$result = $this->query('SELECT '.implode(', ', $fields).' FROM `'.$table.'` WHERE '.implode(' AND ', $values));

		if ($result && ($this->numRows($result) > 0)) {
			return true;
		}
		return false;
	}

	public function getProductById($pID, $languages_id = false, $addQuery = '') {
		$lIDs = $this->fetchArray('
			SELECT language_id FROM '.TABLE_PRODUCTS_DESCRIPTION.' WHERE products_id=\''.$pID.'\'
		', true);

		if ($languages_id === false) {
			$languages_id = $_SESSION['languages_id'];
		}
		
		if (!empty($lIDs) && !in_array($languages_id, $lIDs)) {
			$languages_id = array_shift($lIDs);
		}

		if (is_array($pID)) {
			$where = 'p.products_id IN (\''.implode('\', \'',  $pID).'\')';
		} else {
			$where = 'p.products_id = \''.(int) $pID.'\'';
		}

		$products = $this->fetchArray('
			SELECT *, date_format(p.products_date_available, \'%Y-%m-%d\') AS products_date_available 
			  FROM '.TABLE_PRODUCTS.' p, '.TABLE_PRODUCTS_DESCRIPTION.' pd
			 WHERE '.$where.'
			   AND p.products_id = pd.products_id
			   AND pd.language_id = \''.$languages_id.'\'
			   '.$addQuery.'
		');

		if (!is_array($products) || empty($products)) return false;

		$finalProducts = array();
		foreach ($products as &$product) {
			if ($product['products_image']) {
				$product['products_allimages'] = array($product['products_image']);
			} else {
				$product['products_allimages'] = array();
			}
			if ($this->tableExists(TABLE_PRODUCTS_IMAGES)) {
				$cols = $this->getTableCols(TABLE_PRODUCTS_IMAGES);
				$orderBy = (in_array('image_nr', $cols) 
					? 'image_nr' 
					: (in_array('sort_order', $cols) 
						? 'sort_order' 
						: ''
					)
				);
				if (!empty($orderBy)) {
					$orderBy = 'ORDER BY '.$orderBy;
				}
				$colname = (in_array('image', $cols) 
					? 'image' 
					: (in_array('image_name', $cols) 
						? 'image_name' 
						: ''
					)
				);
				if (!empty($colname)) {
					$product['products_allimages'] = array_merge(
						$product['products_allimages'],
						(array)$this->fetchArray('
							SELECT '.$colname.'
							  FROM '.TABLE_PRODUCTS_IMAGES.'
							 WHERE products_id = \''.$product['products_id'].'\'
						  '.$orderBy.'
						', true)
					);
				}
			}
			if (isset($product['products_head_keywords_tag'])) {
				$product['products_meta_keywords'] = $product['products_head_keywords_tag'];
				unset($product['products_head_keywords_tag']);
			}
			if (isset($product['products_head_desc_tag'])) {
				$product['products_meta_description'] = $product['products_head_desc_tag'];
				unset($product['products_head_desc_tag']);
			}
			if (isset($product['products_vpe'])
			    && isset($product['products_vpe_value'])
			    && $this->tableExists(TABLE_PRODUCTS_VPE)
			) {
				$product['products_vpe_name'] = stringToUTF8(MagnaDB::gi()->fetchOne('
				    SELECT products_vpe_name 
				      FROM '.TABLE_PRODUCTS_VPE.'
				     WHERE products_vpe_id = \''.$product['products_vpe'].'\'
				           AND language_id = \''.$languages_id.'\'
				  ORDER BY products_vpe_id, language_id 
				     LIMIT 1
				'));
			}
			$finalProducts[$product['products_id']] = $product;
		}
		if (!is_array($pID)) {
			return $products[0];
		}
		unset($products);
		return $finalProducts;
	}
	
	public function getCategoryPath($id, $for = 'category', &$cPath = array()) {
		if ($for == 'product') {
			$cIDs = $this->fetchArray('
				SELECT categories_id FROM '.TABLE_PRODUCTS_TO_CATEGORIES.'
				 WHERE products_id=\''.$this->escape($id).'\'
			', true);
			if (empty($cIDs)) {
				return array();
			}
			$return = array();
			foreach ($cIDs as $cID) {
				if ((int)$cID == 0) {
					$return[] = array('0');
				} else {
					$cPath = $this->getCategoryPath($cID);
					array_unshift($cPath, $cID);
					$return[] = $cPath;
				}
			}
			return $return;
		} else {
			$meh = $this->fetchOne(
				'SELECT parent_id FROM '.TABLE_CATEGORIES.' WHERE categories_id=\''.$this->escape($id).'\''
			);
			$cPath[] = (int)$meh;
			if ($meh != '0') {
				$this->getCategoryPath($meh, 'category', $cPath);
			}
			return $cPath;
		}
	}

	/* xt:Commerce Nachbildung */
	public function generateCategoryPath($id, $from = 'category', $categories_array = array(), $index = 0, $callCount = 0) {
		if ($from == 'product') {
			$categories_query = $this->query('
				SELECT categories_id FROM '.TABLE_PRODUCTS_TO_CATEGORIES.'
				 WHERE products_id = \''.$id.'\'
			');
			while ($categories = $this->fetchNext($categories_query)) {
				if ($categories['categories_id'] == '0') {
					$categories_array[$index][] = array ('id' => '0', 'text' => ML_LABEL_CATEGORY_TOP);
				} else {
					$category_query = $this->query('
						SELECT cd.categories_name, c.parent_id 
						  FROM '.TABLE_CATEGORIES.' c, '.TABLE_CATEGORIES_DESCRIPTION.' cd 
						 WHERE c.categories_id = \''.$categories['categories_id'].'\' 
						       AND c.categories_id = cd.categories_id 
						       AND cd.language_id = \''.$_SESSION['languages_id'].'\'
					');
					$category = $this->fetchNext($category_query);
					$categories_array[$index][] = array (
						'id' => $categories['categories_id'],
						'text' => $category['categories_name']
					);
					if (($category['parent_id'] != '') && ($category['parent_id'] != '0')) {
						$categories_array = $this->generateCategoryPath($category['parent_id'], 'category', $categories_array, $index);
					}
				}
				++$index;
			}
		} else if ($from == 'category') {
			$category_query = $this->query('
				SELECT cd.categories_name, c.parent_id 
				  FROM '.TABLE_CATEGORIES.' c, '.TABLE_CATEGORIES_DESCRIPTION.' cd
				 WHERE c.categories_id = \''.$id.'\' 
				       AND c.categories_id = cd.categories_id
				       AND cd.language_id = \''.$_SESSION['languages_id'].'\'
			');
			$category = $this->fetchNext($category_query);
			$categories_array[$index][] = array (
				'id' => $id,
				'text' => $category['categories_name']
			);
			if (($category['parent_id'] != '') && ($category['parent_id'] != '0')) {
				$categories_array = $this->generateCategoryPath($category['parent_id'], 'category', $categories_array, $index, $callCount + 1);
			}
			if ($callCount == 0) {
				$categories_array[$index] = array_reverse($categories_array[$index]);
			}
		}
	
		return $categories_array;
	}

	/**
	 * Insert an array of values
	 */
	public function insert($tableName, $data, $replace = false) {
		if (!is_array($data)) {
			$this->error = __METHOD__.' expects an array as 2nd argument.';
			return false;
		}

		$cols = '(';
		$values = '(';
		foreach ($data as $key => $value) {
			$cols .= "`" . $key . "`, ";

			if (is_int($value) || is_float($value) || is_double($value)) {
				$values .= $value . ", ";
			} else if (strtoupper($value) == 'NULL') {
				$values .= "NULL, ";
			} else if (strtoupper($value) == 'NOW()') {
				$values .= "NOW(), ";
			} else {
				$values .= "'" . $this->escape($value) . "', ";
			}
		}
		$cols = rtrim($cols, ", ") . ")";
		$values = rtrim($values, ", ") . ")";
		#if (function_exists('print_m')) echo print_m(($replace ? 'REPLACE' : 'INSERT').' INTO `'.$tableName.'` '.$cols.' VALUES '.$values);
		return $this->query(($replace ? 'REPLACE' : 'INSERT').' INTO `'.$tableName.'` '.$cols.' VALUES '.$values);
	}

	/**
	 * Insert an array of values
	 */
	public function batchinsert($tableName, $data, $replace = false) {
		if (!is_array($data)) {
			$this->error = __METHOD__.' expects an array as 2nd argument.';
			return false;
		}
		$state = true;

		$cols = '(';
		foreach ($data[0] as $key => $val) {
			$cols .= "`" . $key . "`, ";
		}
		$cols = rtrim($cols, ", ") . ")";

		$block = array_chunk($data, 20);
		
		foreach ($block as $data) {
			$values = '';
			foreach ($data as $subset) {
				$values .= ' (';
				foreach ($subset as $value) {
					if (is_int($value) || is_float($value) || is_double($value)) {
						$values .= $value . ", ";
					} else if (strtoupper($value) == 'NULL') {
						$values .= "NULL, ";
					} else if (strtoupper($value) == 'NOW()') {
						$values .= "NOW(), ";
					} else {
						$values .= "'" . $this->escape($value) . "', ";
					}
				}
				$values = rtrim($values, ", ") . "),\n";
			}
			$values = rtrim($values, ",\n");
	
			//echo ($replace ? 'REPLACE' : 'INSERT').' INTO `'.$tableName.'` '.$cols.' VALUES '.$values;
			$state = $state && $this->query(($replace ? 'REPLACE' : 'INSERT').' INTO `'.$tableName.'` '.$cols.' VALUES '.$values);
		}
		return $state;
	}

	/**
	 * Update row(s)
	 */
	public function update($tableName, $data, $wherea, $add = '', $verbose = false) {
		if (!is_array($data) || !is_array($wherea)) {
			$this->error = __METHOD__.' expects two arrays as 2nd and 3rd arguments.';
			return false;
		}

	 	$values = "";
	 	$where = "";

		foreach ($data as $key => $value) {
			$values .= "`" . $key . "` = ";

			if (is_int($value) || is_float($value) || is_double($value)) {
				$values .= $value . ", ";
			} else if (strtoupper($value) == 'NULL') {
				$values .= "NULL, ";
			} else if (strtoupper($value) == 'NOW()') {
				$values .= "NOW(), ";
			} else {
				$values .= "'" . $this->escape($value) . "', ";
			}
		}
		$values = rtrim($values, ", ");

		if (!empty($wherea)) {
			foreach ($wherea as $key => $value) {
				$where .= "`" . $key . "` = ";
	
				if (is_int($value) || is_float($value) || is_double($value)) {
					$where .= $value . " AND ";
				} else if (strtoupper($value) == 'NULL') {
					$where .= "NULL AND ";
				} else if (strtoupper($value) == 'NOW()') {
					$where .= "NOW() AND ";
				} else {
					$where .= "'" . $this->escape($value) . "' AND ";
				}
			}
			$where = rtrim($where, "AND ");
		} else {
			$where = '1=1';
		}
		return $this->query('UPDATE `'.$tableName.'` SET '.$values.' WHERE '.$where.' '.$add, $verbose);
	}

	/**
	 * Delete row(s)
	 */
	public function delete($table, $wherea, $add = null) {
		if (!is_array($wherea)) {
			$this->error = __METHOD__.' expects an array as 2nd argument.';
			return false;
		}

		$where = "";

		foreach ($wherea as $key => $value) {
			$where .= "`" . $key . "` = ";

			if (is_int($value) || is_float($value) || is_double($value)) {
				$where .= $value . " AND ";
			} else if (strtoupper($value) == 'NULL') {
				$where .= "NULL AND ";
			} else {
				$where .= "'" . $this->escape($value) . "' AND ";
			}
		}

		$where = rtrim($where, "AND ");

		$query = "DELETE FROM `".$table."` WHERE ".$where." ".$add;

		return $this->query($query);
	}

	public function freeResult($result = null) {
		if ($result !== null) {
			mysql_free_result($result);
		} else {
			mysql_free_result($this->result);
		}
		return true;
	}

	/**
	 * Unescapes strings / arrays of strings
	 */
	public function unescape($object) {
		return is_array($object) ?
			array_map(array('MySQL', 'unescape'), $object) :
				stripslashes($object);
	}
	
	public function getTableCols($table) {
		$cols = array();
		if (!$this->tableExists($table)) {
			return $cols;
		}
		$colsQuery = $this->query('SHOW COLUMNS FROM `'.$table.'`');
		while ($row = $this->fetchNext($colsQuery))	{
			$cols[] = $row['Field'];
		}
		$this->freeResult($colsQuery);
		return $cols;
	}

	/**
	 * Get last executed query
	 */
	public function getLastQuery() {
		return $this->query;
	}

	/**
	 * Get last error
	 */
	public function getLastError() {
		return $this->error;
	}

	/**
	 * Get last auto-increment value
	 */
	public function getLastInsertID() {
		if (SHOPSYSTEM == 'oscommerce') {
			return $this->sqlFunc['insert_id']($this->link);
		}
		return $this->sqlFunc['insert_id']();
	}

	/**
	 * Get time consumed for all queries / operations (milliseconds)
	 */
	public function getQueryTime() {
		return round((microtime(true) - $this->start) * 1000, 2);
	}

	public function getTimePerQuery() {
		return $this->timePerQuery;
	}

	/**
	 * Get number of queries executed
	 */
	public function getQueryCount() {
		return $this->count;
	}
	
	public function getRealQueryTime() {
		return $this->querytime;
	}
	
	public function setShowDebugOutput($b) {
		$this->showDebugOutput = $b;
	}

}
