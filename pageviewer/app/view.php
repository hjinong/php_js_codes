<?php
class PageViewerView{
	private $PageViewer;
	
	public $output;
	
	public function __construct(PageViewer $PageViewer)
	{
		$this->PageViewer=$PageViewer;

		if(!empty($this->PageViewer->target))
		{
			$this->output=$this->page_output();
		}
		else {
			$this->output=$this->form_output();
		}
	}
	
	public function form_output(){
		$form_html='
			<fieldset>
				<form method="GET">
					<label>Enter a filename:</label>
					<input name="action" type="hidden" value="getPage" />
					<input name="target" type="text" value="'.$_GET['target'].'"/>
					<input name="Submit" value="Submit" type="submit" />
				</form>
			</fieldset>';
		
		return $form_html;
	}
	
	public function page_output(){
		$page_html='
			<!DOCTYPE html>
			<html>
				<head>
					<meta charset="UTF-8">
					<title>'.$this->PageViewer->title.'</title>
				</head>
			
				<body>
					<fieldset>
						<form method="GET">
							<label>Enter a filename:</label>
							<input name="action" type="hidden" value="getPage" />
							<input name="target" type="text" value="'.$_GET['target'].'"/>
							<input name="Submit" value="Submit" type="submit" />
						</form>
					</fieldset>
					<div style="margin-top:2em">'.$this->PageViewer->text.'</div>
					
				</body>
			
			</html>';

		return $page_html;
	}
}
?>
