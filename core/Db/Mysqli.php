<?php
/**
 * Piwik - Open source web analytics
 * 
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html Gpl v3 or later
 * @version $Id: Mysqli.php 1484 2009-09-24 16:51:30Z vipsoft $
 * 
 * @category Piwik
 * @package Piwik
 */

/**
 * @package Piwik
 */
class Piwik_Db_Mysqli extends Zend_Db_Adapter_Mysqli implements Piwik_Db_iAdapter
{
	public function __construct($config)
	{
		parent::__construct($config);
	}

	/**
	 * Reset the configuration variables in this adapter.
	 */
	public function resetConfig()
	{
		$this->_config = array();
	}

	/**
	 * Return default port.
	 *
	 * @return int
	 */
	public static function getDefaultPort()
	{
		return 3306;
	}

	/**
	 * Check MySQL version
	 */
	public function checkServerVersion()
	{
		$databaseVersion = $this->getServerVersion();
                $requiredVersion = Zend_Registry::get('config')->General->minimum_mysql_version;
                if(version_compare($databaseVersion, $requiredVersion) === -1)
                {
                        throw new Exception(Piwik_TranslateException('Core_ExceptionDatabaseVersion', array('MySQL', $databaseVersion, $requiredVersion)));
                }
	}

	/**
	 * Returns true if this adapter's required extensions are enabled
	 *
	 * @return bool
	 */
	public static function isEnabled()
	{
		$extensions = @get_loaded_extensions();
		return in_array('mysqli', $extensions) && function_exists('mysqli_set_charset');
	}

	/**
	 * Returns true if this adapter supports blobs as fields
	 *
	 * @return bool
	 */
	public function hasBlobDataType()
	{
		return true;
	}

	/**
	 * Test error number
	 *
	 * @param Exception $e
	 * @param string $errno
	 * @return bool
	 */
	public function isErrNo($e, $errno)
	{
		return mysqli_errno($this->_connection) == $errno;
	}

	/**
	 * Execute unprepared SQL query and throw away the result
	 *
	 * Workaround some SQL statements not compatible with prepare().
	 * See http://framework.zend.com/issues/browse/ZF-1398
	 *
	 * @param string $sqlQuery
	 * @return int Number of rows affected (SELECT/INSERT/UPDATE/DELETE)
	 */
	public function exec( $sqlQuery )
	{
		$rc = mysqli_query($this->_connection, $sqlQuery);
		$rowsAffected = mysqli_affected_rows($this->_connection);
		if(!is_bool($rc))
		{
			mysqli_free_result($rc);
		}
		return $rowsAffected;
	}

	/**
	 * Is the connection character set equal to utf8?
	 *
	 * @return bool
	 */
	public function isConnectionUTF8()
	{
		$charset = mysqli_character_set_name($this->_connection);
		return $charset === 'utf8';
	}
}
