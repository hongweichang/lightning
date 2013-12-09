<?php
/**
 * @name groupRole.php UTF-8
 * @author ChenJunAn<lancelot1215@gmail.com>
 * 
 * Date 2013-10-5
 * Encoding UTF-8
 */
?>
<form name="roles" action="<?php echo $this->createUrl('assignment/groupRole',array('group'=>$groupId));?>" method="post">
<?php foreach ( $items as $key => $item ):?>
	<div class="checkbox-list-div">
		<input name="value[]" id="role-<?php echo $key?>" type="checkbox" value="<?php echo $key?>" <?php if (in_array($key,$groupRoles)) echo 'checked="checked"' ?> />
		<label for="role-<?php echo $key?>" class="checkbox-list-text">
		<?php echo $item?>
		</label>
	</div>
<?php endforeach;?>
	<input name="submit" type="submit" value="确定" class="form-button form-button-submit" />
</form>