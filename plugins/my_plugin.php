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
	public function plugins_loaded()
	{
		
	}

	public function config_loaded(&$settings)
	{
		
	}
	
	public function request_url(&$url)
	{
	echo "$url \n";
		if($url == 'pico-master/jobs') {
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
	
				if($this->myjob) {		
	$content=null;
	
			$location = 'http://rss.springrole.com/rss/jobs.rss?userid=gh_kar2905&sub=ravi';
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
    echo "<strong>".$xml->channel->title."</strong>";
    $cnt = count($xml->channel->item);
	
    for($i=0; $i<$cnt; $i++)
    {
	$url 	= $xml->channel->item[$i]->link;
	$title 	= $xml->channel->item[$i]->title;
	$desc =  $xml->channel->item[$i]->description;
 
#	echo '<a href="'.$url.'">'.$title.'</a>'.$desc.'</br>'.'';
	echo '<a href="'.$url.'">'.$title.'</a>'.'</br>'.'';
    }
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
 
	echo '<a href="'.$url.'">'.$title.'</a>'.$desc.'';
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
	



/**
 * @link http://keithdevens.com/weblog/archive/2002/Jun/03/RSSAuto-DiscoveryPHP
 */
public function getRSSLocation($html, $location)
{
    if(!$html or !$location){
        return false;
    }else{
        #search through the HTML, save all <link> tags
        # and store each link's attributes in an associative array
        preg_match_all('/<link\s+(.*?)\s*\/?>/si', $html, $matches);
        $links = $matches[1];
        $final_links = array();
        $link_count = count($links);
        for($n=0; $n<$link_count; $n++){
            $attributes = preg_split('/\s+/s', $links[$n]);
            foreach($attributes as $attribute){
                $att = preg_split('/\s*=\s*/s', $attribute, 2);
                if(isset($att[1])){
                    $att[1] = preg_replace('/([\'"]?)(.*)\1/', '$2', $att[1]);
                    $final_link[strtolower($att[0])] = $att[1];
                }
            }
            $final_links[$n] = $final_link;
        }
        #now figure out which one points to the RSS file
        for($n=0; $n<$link_count; $n++){
            if(strtolower($final_links[$n]['rel']) == 'alternate'){
                if(strtolower($final_links[$n]['type']) == 'application/rss+xml'){
                    $href = $final_links[$n]['href'];
                }
                if(!$href and strtolower($final_links[$n]['type']) == 'text/xml'){
                    #kludge to make the first version of this still work
                    $href = $final_links[$n]['href'];
                }
                if($href){
                    if(strstr($href, "http://") !== false){ #if it's absolute
                        $full_url = $href;
                    }else{ #otherwise, 'absolutize' it
                        $url_parts = parse_url($location);
                        #only made it work for http:// links. Any problem with this?
                        $full_url = "http://$url_parts[host]";
                        if(isset($url_parts['port'])){
                            $full_url .= ":$url_parts[port]";
                        }
                        if($href{0} != '/'){ #it's a relative link on the domain
                            $full_url .= dirname($url_parts['path']);
                            if(substr($full_url, -1) != '/'){
                                #if the last character isn't a '/', add it
                                $full_url .= '/';
                            }
                        }
                        $full_url .= $href;
                    }
                    return $full_url;
                }
            }
        }
        return false;
    }
}

}

?>

<?php

?>