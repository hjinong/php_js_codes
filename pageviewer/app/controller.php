<?php

class PageViewerController{
	private $PageViewer;
	
	public function __construct(PageViewer $PageViewer)
	{
		$this->PageViewer=$PageViewer;
	}

	public function getPage(){ 
		if(isset($_GET['target'])&&!empty($_GET['target']))
		{
			$this->PageViewer->getPage($_GET['target']); 
		}
		else {
			$this->PageViewer->getPage(); 
		}
	}
}
?>