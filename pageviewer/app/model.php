<?php
class PageViewer{
	public $text;
	public $title;
	public $target;
	
	public function getPage($target=''){
		$this->target=$target;
		if($target)
		{
			$this->db=new PDO('mysql:host='.db_host.';dbname='.db_name, db_user, db_pw);
			$this->db->exec("SET CHARACTER SET utf8");
			
			if(!$this->getDbFile($target))
			{
				
				if(!$this->getDirFile($target))
				{
					$this->title='No Match';
					$this->text="No file matching '$target' was found.";
				}			 
			}			
		}
		else {
			$this->title='No Input';
			$this->text='Please enter a filename.';
		}
	}

	public function getDbFile($target){
		$q=$this->db->prepare("select * from page p inner join link l on l.page_id=p.id where l.link='$target'");
		$q->execute();
		if($row=$q->fetch())
		{
			$this->title=$row['title'];
			if($row['mime']=="text/plain")
			{
				$this->text=$this->convert($row['text']);
			}
			else {
				$this->text=$row['text'];
			}
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function getDirFile($target){
		if(file_exists(pagepath.$target))
		{
			$ext=pathinfo(pagepath.$target,PATHINFO_EXTENSION);
			if($ext=='html')
			{
				$this->text=file_get_contents(pagepath.$target);
			}
			else {
				$this->text=$this->convert(file_get_contents(pagepath.$target));
			}
			return true;
		}
		else {
			return false;
		}
	}
	
	public function convert($text)
	{
		$output=helper::convUrl($text);
		$output=helper::convEmail($output);
		$output=helper::convNewline($output);
		$output=helper::convH1($output);
		$output=helper::convNum($output);
		$output=helper::convAst($output);		
		return $output;
	}
}
?>