<?php $this->cs->registerCssFile($this->cssUrl.'help.css'); 
$this->cs->registerScriptFile($this->scriptUrl.'help.js',CClientScript::POS_END);
?>
         <div class="wd1002 hc clearfix">
            <div class="hc-side about-side">
                <ul>
                	<?php 
                	$cid = $this->activeCategory->id;
                	foreach ($this->categories as $val):
                		$name = $val->category_name;
                		if ( mb_strlen($name,'UTF-8') > 6 ){
                			$name = mb_substr($name,0,6,'UTF-8').'...';
                		}
                	?>
                    <li class="hc-side-item" title="<?php echo $val->category_name?>">
                    	<a href="<?php echo $this->createUrl('',array('cid'=>$val->id))?>" <?php if($val->id == $cid) echo ' class="active"';?>>
                    	<?php echo $name?>
                    	</a>
                    </li>
                    
                    <?php endforeach;?>
                </ul>
            </div>
            <div id="hc-content">
            	<div class="about-title">
                    <h2><?php echo $this->activeCategory->category_name;?></h2>
                </div>
                <ul>
                    <?php
                    	foreach ($article as $i => $val):
                    ?>
                    <li>
                        <div class="hc-title"><?php echo ($i+1).".".$val->title;?></div>
                        <p><?php echo $val->content;?></p>
                    </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
