<?php
define('IP2C_MAX_INT',0x7fffffff);
class ip2country 
{
	var $m_active = false;
	var $m_file;
	var $m_firstTableOffset;
	var $m_numRangesFirstTable;
	var $m_secondTableOffset;
	var $m_numRangesSecondTable;
	var $m_countriesOffset;
	var $m_numCountries;

	function ip2country() 
	{
		$bin_file = TEMPLATEPATH.'/inc/ip-to-country.bin';
		$this->m_file = fopen($bin_file, "rb");
		if (!$this->m_file) die('Error loading '.$bin_file);
		$f = $this->m_file;
		$sig = fread($f, 4);
		if ($sig != 'ip2c')
		{
			trigger_error("file $bin_file has incorrect signature");
			return;
		}
		$v = $this->readInt();
		if ($v != 2)
		{
			trigger_error("file $bin_file has incorrect format version ($v)");
			return;
		}

		$this->m_firstTableOffset = $this->readInt();
		$this->m_numRangesFirstTable = $this->readInt();
		$this->m_secondTableOffset = $this->readInt();
		$this->m_numRangesSecondTable = $this->readInt();
		$this->m_countriesOffset = $this->readInt();
		$this->m_numCountries = $this->readInt();
		$this->m_active = true;
	}


	function get_country($ip)
	{
		if (!$this->m_active) return false;

		$int_ip =  ip2long($ip);

		// happens on 64bit systems	
		if ($int_ip > IP2C_MAX_INT)
		{
			// shift to signed int32 value
			$int_ip -= IP2C_MAX_INT;
			$int_ip -= IP2C_MAX_INT;
			$int_ip -= 2;
		}

		if ($int_ip >= 0)
		{
			$key = $this->find_country_code($int_ip, 0, $this->m_numRangesFirstTable, true);
		}
		else
		{
			$nip = (int)($int_ip + IP2C_MAX_INT + 2); // the + 2 is a bit wierd, but required.
			$key = $this->find_country_code($nip, 0, $this->m_numRangesSecondTable, false);
		}
		if ($key == false || $key == 0)
		{
			return false;
		}
		else
		{
			return $this->find_country_key($key);	
		}
	}

	function find_country_code($ip, $startIndex, $endIndex, $firstTable, $d = 0) 
	{
		$middle = (int)(($startIndex + $endIndex) / 2);
		$mp = $this->getPair($middle, $firstTable);
		$mip = $mp['ip'];
		//echo "#$d find_country_code : [code=$ip, start=$startIndex, middle=$middle, end=$endIndex, mip=$mip]<br/>";

		if ($ip < $mip)
		{
			if ($startIndex + 1 == $endIndex) return false; // not found
			return $this->find_country_code($ip, $startIndex, $middle, $firstTable, ++$d);
		}
		else 
			if ($ip > $mip)
			{
				$np = $this->getPair($middle+1, $firstTable);
				if ($ip < $np['ip'])
				{
					return $mp['key'];
				}
				else
				{
					if ($startIndex + 1 == $endIndex) return false; // not found
					return $this->find_country_code($ip, $middle, $endIndex, $firstTable, ++$d);
				}
			}
			else // ip == mip
			{
				return $mp['key'];
			}
	}

	function find_country($code)
	{
		if (!$this->m_active) return false;
		$c = strtoupper($code);
		$c1 = $c[0];
		$c2 = $c[1];
		$key = ord($c1) * 256 + ord($c2);
		return $this->find_country_impl($key, 0, $this->m_numCountries);	
	}

	function find_country_key($key)
	{
		return $this->find_country_impl($key, 0, $this->m_numCountries);	
	}

	function find_country_impl($code, $startIndex, $endIndex, $d = 0) 
	{
		if ($d > 20)
		{
			trigger_error("IP2Country : Internal error - endless recursion detected, code = $code");
			return false;
		}

		$middle = (int)(($startIndex + $endIndex) / 2);
		$mc = $this->get_country_code($middle);
		//echo "#$d find_country : [$startIndex, $endIndex, mc=$mc, code=$code]<br/>";

		if ($mc == $code)
		{
			// found.
			return $this->load_country($middle);
		}
		else
			if ($code > $mc)
			{
				if ($middle + 1 == $endIndex)
				{
					$nc = $this->get_country_code($middle);
					if ($nc == $code) return $this->load_country($middle);
					else return false;
				}
				return $this->find_country_impl($code, $middle, $endIndex, ++$d);
			}
			else // $code < $mc
			{
				if ($startIndex + 1 == $middle)
				{
					$nc = $this->get_country_code($startIndex);
					if ($nc == $code) return $this->load_country($startIndex);
					else return false;
				}
				return $this->find_country_impl($code, $startIndex, $middle, ++$d);
			}
	}


	function load_country($index)
	{
		$offset = $this->m_countriesOffset + $index * 10;
		$this->seek($offset);
		$id2c = $this->readCountryKey();
		$id3c = $this->read3cCode();
		$nameOffset = $this->readInt();
		$this->seek($nameOffset);
		$len = $this->readShort();
		if ($len == 0)
		{ 
			$name = '';
		}
		else
		{
			$name = fread($this->m_file, $len);
		}
		return array("id2"=>$id2c,"id3"=>$id3c,"name"=>$name);
	}

	function get_country_code($index)
	{
		$offset = $this->m_countriesOffset + $index * 10;
		$this->seek($offset);
		return $this->readShort();
	}



	function getPair($index, $firstTable) 
	{
		$offset = 0;
		if ($firstTable)
		{
			if ($index > $this->m_numRangesFirstTable) 
			{
				return array('key'=>false,'ip'=>0);
			}
			$offset = $this->m_firstTableOffset + $index * 6;
		}
		else
		{
			if ($index > $this->m_numRangesSecondTable) 
			{
				return array('key'=>false,'ip'=>0);
			}
			$offset = $this->m_secondTableOffset + $index * 6;

		}
		$this->seek($offset);
		$p = array();
		$p['ip'] = $this->readInt();
		$p['key'] = $this->readShort();
		return $p;

	}	

	function readByte() 
	{
		$a = unpack('C', fread($this->m_file, 1));
		return $a[1];
	}

	function readShort() 
	{
		$a = unpack('n', fread($this->m_file, 2));
		return $a[1];
	}

	function read3cCode()
	{
		fread($this->m_file, 1);
		$d = fread($this->m_file, 3);
		return $d != '   ' ? $d : '';
	}

	function readCountryKey() 
	{
		return fread($this->m_file, 2);
	}	

	function readInt() 
	{
		$a =unpack('N', fread($this->m_file, 4));
		return $a[1];
	}

	function seek($offset)
	{
		fseek($this->m_file, $offset);
	}
}
?>
