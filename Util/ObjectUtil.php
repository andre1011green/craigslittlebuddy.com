<?
	class ObjectUtil
	{
		public static function init ($object, $assoc)
		{
			foreach ($assoc as $k => $v)
			{
				$object->$k = $v; 
			}
		}
	}
?>