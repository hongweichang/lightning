<?php
/**
 * Project OKBT
 * @name LinkPager.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-4-13 
 * Encoding UTF-8
 */
class LinkPager extends CLinkPager{
	
	public function run()
	{
		$this->registerClientScript();
		$buttons=$this->createPageButtons();
		if(empty($buttons))
			return;
		echo $this->header;
		echo implode("\n",$buttons);
		echo $this->footer;
	}
	
	protected function createPageButton($label,$page,$class,$hidden,$selected)
	{
		if($hidden || $selected)
			$class.=' '.($hidden ? $this->hiddenPageCssClass : $this->selectedPageCssClass);
		return CHtml::link($label,$this->createPageUrl($page),array('class'=>$class));
	}
}
?>