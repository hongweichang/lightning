<?php $this->cs->registerCssFile($this->cssUrl.'help.css'); 
$this->cs->registerScriptFile($this->scriptUrl.'help.js',CClientScript::POS_END);
?>
         <div class="wd1002 hc clearfix">
            <div class="hc-side">
                <ul>
                	<?php 
                	$cid = $activeCategory->id;
                	foreach ($category as $val):
                		$name = $val->category_name;
                		if ( mb_strlen($name,'UTF-8') > 5 ){
                			$name = mb_substr($name,0,5,'UTF-8').'...';
                		}
                	?>
                    <li class="hc-side-item" title="<?php echo $val->category_name?>">
                    	<a href="<?php echo $this->createUrl('',array('cid'=>$val->id))?>" <?php if($val->id == $cid) echo ' class="active"';?>>
                    	<?php echo $name?><span>>></span>
                    	</a>
                    </li>
                    
                    <?php endforeach;?>
                </ul>
            </div>
            <div id="hc-content">
                <h2><?php echo $activeCategory->category_name;?></h2>
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
