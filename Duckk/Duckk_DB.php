<?
    class Duckk_DB
    {
        private $userName;
        private $password;
        private $host;
        private $dbName;
        private $mysqli;
        private static $queryMaps = array ();
        
        function __construct ($dbName, $userName = 'root', $password = '', $host = 'localhost')
        {
            $this->userName = $userName;
            $this->password = $password;
            $this->dbName = $dbName;     
            $this->host = $host;
            
            $this->mysqli = new mysqli (
            					$this->host, 
            					$this->userName, 
            					$this->password, 
            					$this->dbName);
        }
        
        private function qry ($qryKey, $data = array ())
        {
			global $DB_QUERIES;
            $rawQry = $DB_QUERIES['test'];
            $qry = $this->makeQryString ($rawQry, $data);
            $res = $this->execute ($qry);
            return $res;        
        }
        
        private function execute ($qry)
        {
            return $this->mysqli->query ($qry);
        }
        
        public function insert ($qryKey, $data = array ())
        {
            $res = $this->qry ($qryKey, $data);
            $insertId = mysql_insert_id ($this->connection);
            
            if ($insertId === 0) return true;
            if ($insertId > 0) return $insertId;
            
            return false;   
        }
        
        private function getFoundRows ()
        {
        	$res = $this->execute ('SELECT FOUND_ROWS()');
        	$row = $res->fetch_array (MYSQLI_NUM);
        	return $row[0];
        }
        
        private function getQueryMapping ($qryKey)
        {
        	$queryMapType = 'common';
        	$objectType = null;
        	
        	if (preg_match ('/^(\w*)_/', $qryKey, $matches))
        	{
        		$queryMapType = $matches[1];
        		$objectType = ucfirst ($queryMapType);
        	}
        	
        	if (! isset ($this->queryMaps[$queryMapType]))
        	{
	        	$QUERIES = array ();
				require "conf/query/query-{$queryMapType}.php";
				$this->queryMaps[$queryMapType] = $QUERIES;
        		
        		if ($objectType)
        		{
        			foreach ($this->queryMaps[$queryMapType] as $k => $v) 
        			{
        				$this->queryMaps[$queryMapType][$k]['type'] = $objectType;
        			}
        		}
        	}
        	
        	return $this->queryMaps[$queryMapType][$qryKey];
        }
        
        public function selectSingle ($qryKey, $data = array ())
        {
        	return $this->select ($qryKey, $data, true);
        }

        public function selectMulti ($qryKey, $data = array (), $offset = null, $limit = null, $orderBy = null)
		{
			return $this->select ($qryKey, $data, $offset, $limit, $orderBy, false);
		}
        
        private function select ($qryKey, $data = array (), $offset = null, 
        						$limit = null, $orderBy = null, $single = false)
        {
			global $DB_QUERIES;
			
			$queryMapping = $this->getQueryMapping ($qryKey);
            $query = $this->prepareSelectQuery ($this->makeQryString ($queryMapping['query'], $data), $orderBy, $offset, $limit);
            $res = $this->mysqli->query ($query);
			
			$objects = array ();
			while ($o = $res->fetch_object ($queryMapping['type'])) $objects[] = $o;
			
			if ($single) return $objects[0];
			
			return new Duckk_Collection ($objects, $offset, $limit, $this->getFoundRows (), $queryMapping['type']);
        }        
        
        private function prepareSelectQuery ($qry, $orderBy = null, $offset = null, $limit = null)
        {
        	return preg_replace ('/^select /i', 'select SQL_CALC_FOUND_ROWS ', $qry)
        			. (($orderBy !== null) ? " ORDER BY $orderBy " : '')
        			. (($limit !== null) ? " LIMIT $limit " : '')
        			. (($offset !== null) ? " OFFSET $offset " : '');
        }
        
        public function update ($qryKey, $data = array ())
        {
            $res = $this->qry ($qryKey, $data);
            return mysql_affected_rows ($this->connection);
        }
        
        public function delete ($qryKey, $data = array ())
        {
            return $this->update ($qryKey, $data);
        }
        
        // TODO: build in support for assoc arrays
        private function escape ($var, $varName)
        {
            if ($var !== 0 && ! $var)
            {
                $var = 'NULL';    
            }
            else if (is_array ($var))
            {
                $tmp = array ();
                foreach ($var as $v) $tmp[] = $this->escape ($v);
                $var = '(' . implode (',', $tmp) . ')';  
            }
            else if (is_string ($var))
            {
    			$var = '\'' . $this->mysqli->real_escape_string ($var) . '\'';
            }
            else if (is_object ($var))
            {
            	$var = clone $var;
            	foreach (get_object_vars ($var) as $k => $v) $var->$k = $this->escape ($v, $k);
            }
                        	
    		return $var;
        }
        
        public function makeQryString ($rawQry, $data = array ())
        {
            foreach ($data as $k => $v)
            {               
                $$k = $this->escape ($v, $k); 
            }                       
            
            $newQry = null;
            eval ("\$newQry = \"$rawQry\";");
            return $newQry;     
        }           
        
        private function connect ()
        {
            if ($this->connection) return;
            
            $this->connection = mysqli_connect (
            					$this->host, 
            					$this->userName, 
            					$this->password, 
            					$this->dbName) or die (mysql_error());
        }   
    }

?>