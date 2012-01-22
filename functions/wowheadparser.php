<?php
class wowheadparser
{
	private $_imageName;
	private $_htmlTooltip;
	public function __construct($itemid)
	{
		$filename = 'wowheadparser/xmlcache/item_'.$itemid.'.xml';
		if(!file_exists($filename)){
			$this->_download($filename);
		}
		$this->_parse_xml();
	}
	
	private function _download($filename){
		$ch = curl_init();
		$file = fopen($filename,'w+');
		curl_setopt($ch, CURLOPT_URL, "http://www.wowhead.com/item=".$this->itemid."&xml");
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_FILE, $file);
		curl_exec($ch);
		curl_close($ch);
		fclose($file);
		return true;
	}
		
	private function _parse_xml($filename){
		$file = fopen($filename,'r+');
		$parser = xml_parser_create();
		xml_parse_into_struct($parser,fgets($file),$values);
		xml_parser_free($parser);
		fclose($file);
		$this->_imageName = $values[8];
		$this->_htmlTooltip = $values[10];
	}
    
	public function getItemImage()
	{
		return '<img src="http://static.wowhead.com/images/wow/icons/large/'.$this->_imageName.'.jpg" alt=""/>';
	}
	
	public function getHtmlTooltp()
	{
		return $this->_htmlTooltip;
	}
}
?>