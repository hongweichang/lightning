<?php
/**
 * @name contentBox.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-11 
 * Encoding UTF-8
 */
?>
<div class="content-box">
	<div class="content-box-header">
		<?php echo '<h3>'.$tabTitle.'</h3>'?>
		<ul class="content-box-tabs">
			<?php foreach ( $subTabs as $subTab ):
				echo $subTab;
			endforeach;?>
		</ul>
		<div class="clear"></div>
	</div>
	<div class="content-box-content">
		<?php foreach ( $notifications as $notification ):
				echo $notification;
			endforeach;
		echo $content;?>
	</div>
</div>