<?php
/**
 * @name notification.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-9 
 * Encoding UTF-8
 */
?>
<div class="notification <?php echo $type ?> png_bg">
	<?php if ( $noClose === false ):?>
	<a href="#" class="close">
	<img src="<?php echo $this->imageUrl;?>icons/cross_grey_small.png" title="Close this notification" alt="close" />
	</a>
	<?php endif;?>
	<div><?php echo $content?></div>
</div>