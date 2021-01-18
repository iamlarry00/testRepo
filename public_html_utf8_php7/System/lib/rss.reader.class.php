<?
/**
* http://web.resource.org/rss/1.0/spec
* http://blogs.law.harvard.edu
*/
class rss
{
    private $parser = null;
    private $current_tag = null;
    private $current_attribute = null;
    private $rdf_code = null;
    private $item_count = 0;

    public $channel = array();

    public function __construct()
    {
        $this->parser = xml_parser_create();
    }
	














	###소켓방식으로 변경 2010-05-03 권오용 팀장
    public function parse($rss_file)
    {
        xml_set_object($this->parser, &$this);
        xml_set_element_handler($this->parser, "_startElement", "_endElement");
        xml_set_character_data_handler($this->parser, "_characterData");

        $info = parse_url($rss_file);
		$host = $info['host'];
		$port = $info['port'];
		if ( empty($port) ) $port = 80;

		$path = $info['path'];
		if ( !empty($info['query']) ) $path.= '?'.$info['query'];

		$out = "GET {$path} HTTP/1.0\r\nHost: {$host}\r\n\r\n";

		$fp = fsockopen($host, $port, $errno, $errstr, 30);

        if(!$fp)
        {
            //throw new Exception("Error reading RSS file : " . $rss_file);
			echo 'error';
			return;
        }
        else
        {

			fputs($fp, $out);
			$start = false;
			$ret_val = '';

			while ( !feof($fp) ) {
			
				$tmp = fgets($fp, 4096);
				if ( $start ) $ret_val = $tmp;
				if ( "\r\n" == $tmp ) $start = true;
				
				
				//echo $tmp;//오류발생시 출력

				if(xml_parse($this->parser, $ret_val, feof($fp)) == false)
                {
		
                    //throw new Exception(xml_error_string(xml_get_error_code($this->parser)) . " Line : " . xml_get_current_line_number($this->parser));
					echo 'error2 : '.$rss_file."<br>";
					return;
                }
			}
			
            fclose($fp);
            xml_parser_free($this->parser);
        }
    }
	
	/*
    public function parse($rss_file)
    {
        xml_set_object($this->parser, &$this);
        xml_set_element_handler($this->parser, "_startElement", "_endElement");
        xml_set_character_data_handler($this->parser, "_characterData");

        $fp = @fopen($rss_file, "r");

        if(!$fp)
        {
            //throw new Exception("Error reading RSS file : " . $rss_file);
			echo 'error';
			return;
        }
        else
        {
            while($rssData = fread($fp, 4096))
            {
                if(xml_parse($this->parser, $rssData, feof($fp)) == false)
                {
                    //throw new Exception(xml_error_string(xml_get_error_code($this->parser)) . " Line : " . xml_get_current_line_number($this->parser));
					echo 'error22';
					return;
                }
            }
            fclose($fp);
            xml_parser_free($this->parser);
        }
    }*/


    private function _startElement($parser, $name, $attribute = null)
    {
        $this->current_tag = $name;
        $this->current_attribute = $attribute;

        switch($this->current_tag)
        {
            case "CHANNEL" :
                $this->rdf_code = "channel";
            break;
            case "IMAGE" : 
                $this->rdf_code = "image";
            break;
            case "ITEM" :
                $this->rdf_code = "item";
            break;
            case "CLOUD" :
                $this->rdf_code = "cloud";
            break;
            case "TTL" :
                $this->rdf_code = "ttl";
            break;
            case "TEXTINPUT" :
                $this->rdf_code = "textinput";
            break;
        }
    }

    private function _endElement($parser, $name, $attribute = null)
    {
        if($name == "ITEM")
        {
            $this->item_count += 1;
        }

        $this->current_tag = null;
        $this->current_attribute = null;
    }

    private function _characterData($parser, $cdata)
    {
        $cdata = iconv(xml_parser_get_option($parser, XML_OPTION_TARGET_ENCODING), "EUC-KR", $cdata);

		//echo $this->current_tag."<br>";

        if($this->rdf_code == "channel")
        {
            switch($this->current_tag)
            {
                case "TITLE" :
                    $this->channel['channel']['title'] .= $cdata;
                break;
                case "LINK" :
                    $this->channel['channel']['link'] .= $cdata;
                break;
                case "DESCRIPTION" :
                    $this->channel['channel']['description'] .= $cdata;
                break;
                case "LANGUAGE" :
                    $this->channel['channel']['language'] .= $cdata;
                break;
                case "COPYRIGHT" :
                    $this->channel['channel']['copyright'] .= $cdata;
                break;
                case "MANAGINGEDITOR" :
                    $this->channel['channel']['managingeditor'] .= $cdata;
                break;
                case "WEBMASTER" :
                    $this->channel['channel']['webmaster'] .= $cdata;
                break;
                case "PUBDATE" :
                    $this->channel['channel']['pubdate'] .= $cdata;
                break;
                case "LASTBUILDDATE" :
                    $this->channel['channel']['lastbuilddate'] .= $cdata;
                break;
                case "DOCS" :
                    $this->channel['channel']['docs'] .= $cdata;
                break;
				case "GUID" :
                    $this->channel['channel']['guid'] .= $cdata;
                break;
				case "DC:DATE" :
                    $this->channel['channel']['dc:date'] .= $cdata;
                break;
            }
        }
        else if($this->rdf_code == "image")
        {
            switch($this->current_tag)
            {
                case "URL" :
                    $this->channel['channel']['image_url'] .= $cdata;
                break;
                case "WIDTH" :
                    $this->channel['channel']['image_width'] .= $cdata;
                break;
                case "HEIGHT" :
                    $this->channel['channel']['image_height'] .= $cdata;
                break;
                case "TITLE" :
                    $this->channel['channel']['image_title'] .= $cdata;
                break;
                case "LINK" :
                    $this->channel['channel']['image_link'] .= $cdata;
                break;
            }
        }
        else if($this->rdf_code == "item")
        {
            switch($this->current_tag)
            {
                case "LINK" :
                    $this->channel['item'][$this->item_count]['link'] .= $cdata;
                break;
                case "TITLE" :
                    $this->channel['item'][$this->item_count]['title'] .= $cdata;
                break;
                case "DESCRIPTION" :
                    $this->channel['item'][$this->item_count]['description'] .= $cdata;
                break;
                case "PUBDATE" :
                    $this->channel['item'][$this->item_count]['pubDate'] .= $cdata;
                break;
				case "DC:DATE" :
                    $this->channel['item'][$this->item_count]['dc:date'] .= $cdata;
                break;
				case "GUID" :
                    $this->channel['item'][$this->item_count]['guid'] .= $cdata;
                break;
            }
        }
    }

    public function __destruct()
    {
    }
};
?>
