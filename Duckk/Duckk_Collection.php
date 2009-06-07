<?
	class Duckk_Collection
	{
		private $total;
		private $offset;
		private $limit;
		private $data = array ();
		private $count;
		private $type;
		
		private $currentIndex;
		private $lastIndex;
		
		public function __construct ($data, $offset, $limit, $total, $type)
		{
			$this->total = $total;
			$this->offset = $offset;
			$this->limit = $limit;
			$this->data = $data;
			$this->count = count ($data);
			$this->type = $type;
			$this->currentIndex = 0;
			$this->lastIndex = ($this->count > 0) ? $this->count - 1 : 0;
		}
		
		public function last () { return ($this->currentIndex == $this->lastIndex); }
		public function first () { return ($this->currentIndex == 0); }
		public function rewind () { if ($this->currentIndex) --$this->currentIndex; }
		public function reset () { $this->currentIndex = 0; }		
		public function hasNext () { return $this->currentIndex != $this->lastIndex; }
		public function next () { return $this->data[$this->currentIndex++]; }
		
		public function getTotal () {return $this->total;}
		public function getOffset () {return $this->offset;}
		public function getData () {return $this->data;}
		public function getLimit () {return $this->limit;}
		public function getCount () {return $this->count;}
		public function getType () {return $this->type;}
	}
?>