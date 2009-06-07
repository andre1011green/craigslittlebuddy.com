<?
	class DebugUtil
	{
		public function pre ($var)
		{
			echo '<pre>' . print_r ($var, true) . '</pre>';
		}
	}
?>