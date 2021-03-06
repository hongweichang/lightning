<?php
$this->cs->registerCssFile($this->cssUrl.'help.css'); 
?>
	<div class="wd1002">
	<div class="breadcrumb">
    			<ul>
    				<li class="breadcrumb-item">
    					<a href="<?php echo $this->createUrl('/site'); ?>">首页</a> > 
    				</li>
    				<li class="breadcrumb-item">
    					<a href="<?php echo $this->createUrl('/content/aboutus'); ?>">关于我们</a> > 
    				</li>
    				<li class="breadcrumb-item">
    					<?php echo $this->activeCategory->category_name;?>
    				</li>
    			</ul>
    		</div>
	</div>
    <div class="wd1002 outer">	
         <div class="wd1002 hc clearfix">
            <div id="container1">
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
                <div id="hc-content" class="about">
                    <div id="contentInner">
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
            </div>
        </div>
    </div>
