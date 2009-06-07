<?
	class DBUtil extends Duckk_DB
	{
		private static $dbh;		
		const DEFAULT_DB = 'dealfeedr';
		
		/**
		 * Get a DB object to use
		 *
		 * @param array $connectionInfo
		 * @return DB
		 */
		public static function getDB ($connectionInfo = array ())
		{
			if (! empty ($connectionInfo))
			{
				
			}
			else
			{
				if (empty (self::$dbh)) 
				{
					self::$dbh = new Duckk_DB (self::DEFAULT_DB);
				}
				
				return self::$dbh;
			}
		}
	}
?>