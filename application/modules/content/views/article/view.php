<?php
/**
 * @name view.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-20 
 * Encoding UTF-8
 */
$this->cs->registerCssFile($this->cssUrl.'help.css');
?>
	<div class="wd1002">
		<div class="breadcrumb">
    			<ul>
    				<li class="breadcrumb-item">
    					<a href="<?php echo $this->createUrl('/site'); ?>">首页</a> > 
    				</li>
    				<li class="breadcrumb-item">
    					<a href="<?php echo $this->createUrl('/content/article'); ?>">公告列表</a> > 
    				</li>
    				<li class="breadcrumb-item">
    					<?php echo $article->title;?>
    				</li>
    			</ul>
    		</div>
	</div>

<div class="wd1002 hc clearfix">
	<div id="hc-detail-content">
                <h2 id="title"><?php echo $article->title;?></h2>
                <?php echo $article->content?>
	</div>
</div>