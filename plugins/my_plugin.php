<?php

/**
 * Example hooks for a Pico plugin
 *
 * @author Gilbert Pellegrom
 * @link http://picocms.org
 * @license http://opensource.org/licenses/MIT
 */
class my_Plugin {

private $myjob = false;
private $username;
	public function plugins_loaded()
	{
		
	}

	public function config_loaded(&$settings)
	{
		$this->username=$settings["username"];
	}
	
	public function request_url(&$url)
	{
	echo "$url \n";
		if($url == 'open-job-portal/index.php/jobs') {
		$this->myjob = true;
		}
	}
	
	public function before_load_content(&$file)
	{
		
	}
	
	public function after_load_content(&$file, &$content)
	{
		
	}
	
	public function before_404_load_content(&$file)
	{
		
	}
	
	public function after_404_load_content(&$file, &$content)
	{
		
	}
	
	public function before_read_file_meta(&$headers)
	{
		
	}
	
	public function file_meta(&$meta)
	{
		
	}

	public function after_parse_content(&$content)
	{
	
	}
	
	public function before_parse_content(&$content)
	{
	global $username;
#				if($this->myjob)
				{		
	$content=null;
	
			 $location = 'http://rss.springrole.com/rss/jobs.rss?userid='.$this->username;
	$html = file_get_contents($location);

 
            
			
#	 $content =  $html ; 
	 
	 $doc = new SimpleXmlElement($html, LIBXML_NOCDATA);
#	 print_r($doc);

	if(isset($doc->channel))
	{
    $this->parseRSS($doc);
	}
	if(isset($doc->entry))
	{
	
    $this->parseAtom($doc);
	}

}
	}

public function parseRSS($xml)
{
   # echo "<strong>".$xml->channel->title."</strong>";
    $cnt = count($xml->channel->item);
	echo "<div class='content'>";	
    for($i=0; $i<$cnt; $i++)
		{
	$url 	= $xml->channel->item[$i]->link;
	$title 	= $xml->channel->item[$i]->title;
	$desc =  $xml->channel->item[$i]->description;
	$url1 = str_replace($this->username,$this->username."&utm_source=php-training-club&utm_medium=open-job-portal&utm_term=jobs&utm_content=job-portal&utm_campaign=open-job-portal",$url);
	$desc1 = str_replace($this->username,$this->username."&utm_source=php-training-club&utm_medium=open-job-portal&utm_term=jobs&utm_content=job-portal&utm_campaign=open-job-portal",$desc);	
	#$city = $xml->channel->item[$i]->city;
	#$country = $xml->channel->item[$i]->country;
	echo '<a href="'.$url1.'">'.$title.'</a>'.$desc1.'</br>'.'';
    echo '<br><hr></hr></br>';
  # echo '<a href="'.$url.'">'.$title.'</a>'.'</br>'.'';
  # echo '<a>$city</a>';

    }
    echo "</div>";
}

public function parseAtom($xml)
{
    echo "<strong>".$xml->author->name."</strong>";
    $cnt = count($xml->entry);
	
    for($i=0; $i<$cnt; $i++)
    {
	$urlAtt = $xml->entry->link[$i]->attributes();
	$url	= $urlAtt['href'];
	$title 	= $xml->entry->title;
	$desc	=  strip_tags($xml->entry->content);
 
	#echo '<a href="'.$url.'">'.$title.'</a>'.$desc.'';
    }
}


	
	public function get_page_data(&$data, $page_meta)
	{
		
	}
	
	public function get_pages(&$pages, &$current_page, &$prev_page, &$next_page)
	{
		
	}
	
	public function before_twig_register()
	{
		
	}
	
	public function before_render(&$twig_vars, &$twig, &$template)
	{

		$twig_vars['my_custom_var'] = 'Hello World';
		
			
		
	}
	
	public function after_render(&$output)
	{
		
	}
	

}

?>

<?php

?>
