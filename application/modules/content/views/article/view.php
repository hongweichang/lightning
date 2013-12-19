<?php
/**
 * @name view.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-20 
 * Encoding UTF-8
 */
$this->cs->registerCssFile($this->cssUrl.'help.css');
?>

<div class="wd1002 hc clearfix">
	<div id="hc-content">
                <h2><?php echo $article->title;?></h2>
                <?php echo $article->content?>
	</div>
</div>