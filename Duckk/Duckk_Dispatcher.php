<?
	abstract class Duckk_Dispatcher
	{
		abstract protected function translatePath ();
		abstract protected function getAction ();
		abstract protected function dispatch (Duckk_Action $action);		
	}
?>