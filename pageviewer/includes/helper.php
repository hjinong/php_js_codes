<?php
class helper{

	public static function convUrl($text)
	{
		$regexUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
		if(preg_match($regexUrl, $text, $url)) {
		        return preg_replace($regexUrl, '<a href="'.$url[0].'">'.$url[0].'</a>', $text);		
		} else {
		       return $text;		
		}		
	}
	
	public static function convEmail($text)
	{
		$regexEmail="/([a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4})/";
		if(preg_match($regexEmail, $text, $email)) {
		        return preg_replace($regexEmail, '<a href="mailto:'.$email[0].'">'.$email[0].'</a>', $text);		
		} else {
		       return $text;		
		}		
	}
	
	public static function convNewline($text)
	{
		$text=preg_replace('/(\s*\n){2}/', "</p><p>", '<p>'.$text.'</p>');
		return $text;
	}
	
	public static function convH1($text)
	{
		$regexH1="/(<p>.+\n+=+<\/p>|<p>.+\n+-+<\/p>)/";
		if(preg_match($regexH1,$text,$h1)){
		        $replace=str_replace('p>','h1>',$h1[0]);	
				$replace=str_replace('-','',$replace);	
				$replace=str_replace('=','',$replace);				
		       	return preg_replace($regexH1, $replace, $text);
		} else {
		       return $text;		
		}		
	}
	
	public static function convNum($text)
	{
		$regexNum='/##+(.*?)p>/';
		if(preg_match_all($regexNum,$text,$num))
		{
			for($i=0;$i<sizeof($num[0]);$i++)
			{
				$count=substr_count($num[0][$i],'#'); 
				$replace=str_replace('#','',$num[0][$i]); 
				$replace=$replace.'</h'.$count.'>';
				$replace='<h'.$count.'>'.$replace; 
				$replace=str_replace('</p>', '', $replace); 
				$text=str_replace($num[0][$i],$replace,$text);
			}
			return $text;
		}
		else {
			return $text;
		}
	}
	
	public static function convAst($text)
	{
		$regexAst='/\*\s(.*?)(\n|p>)/';
		if(preg_match_all($regexAst,$text,$ast))
		{
			$size=sizeof($ast[0]);
			for($i=0;$i<$size;$i++)
			{
				$replace=str_replace('*','<li>',$ast[0][$i]).'</li>';
				$replace=str_replace('</p>','',$replace);
				if($i==0)
				{
					$replace='<ul>'.$replace;
				}
				if($i==($size-1))
				{
					$replace=$replace.'</ul>';
				}
				$text=str_replace($ast[0][$i],$replace,$text);
			}
			return $text;
		}
		else {
			return $text;
		}
	}	
}
?>
