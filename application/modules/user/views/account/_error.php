<?php
/**
 * @name _error.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-20 
 * Encoding UTF-8
 */
	foreach ( $model->getErrors() as $errors ):
		foreach ( $errors as $error ):
?>
<div class="form-item"><label class="error"><?php echo $error?></label></div>
<?php 	endforeach;
	endforeach;?>