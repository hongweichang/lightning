<?php
/**
 * @name operation.php UTF-8
 * @author ChenJunAn<lancelot1215@gmail.com>
 * 
 * Date 2013-10-5
 * Encoding UTF-8
 */
?>
<div class="table-list">
	<form action="<?php echo $this->createUrl('assignment/permission',array('role'=>$roleId)) ?>" name="permissions" method="post">
		<table id="tree" style="width: 100%" class="treetable">
		<?php foreach ( $list as $lOne ):
			$lOneId = $lOne['parent']->primaryKey;
			$lOneOpId = $lOne['parent']->operation_id;
		?>
		<tr data-tt-id="<?php echo $lOneOpId;?>">
			<td>
			<input type="checkbox" name="value[]" value="<?php echo $lOneId?>" <?php if ( in_array($lOneId,$rolePermissions) ) echo 'checked' ?>>
			<?php echo $lOne['parent']->permission_name?>
			</td>
		</tr>
			<?php foreach ( $lOne['children'] as $lTwo ):
				$lTwoId = $lTwo['parent']->primaryKey;
				$lTwoOpId = $lTwo['parent']->operation_id;
			?>
		<tr data-tt-id="<?php echo $lTwoOpId;?>" data-tt-parent-id="<?php echo $lOneOpId?>">
			<td>
			<input type="checkbox" name="value[]" value="<?php echo $lTwoId?>" <?php if ( in_array($lTwoId,$rolePermissions) ) echo 'checked' ?>>
			<?php echo $lTwo['parent']->permission_name?>
			</td>
		</tr>
				<?php foreach ( $lTwo['children'] as $lThree ): 
					$lThreeId = $lThree->primaryKey;
					$lThreeOpId = $lThree->operation_id;
				?>
		<tr data-tt-id="<?php echo $lThreeOpId;?>" data-tt-parent-id="<?php echo $lTwoOpId?>">
			<td>
			<input type="checkbox" name="value[]" value="<?php echo $lThreeId?>" <?php if ( in_array($lThreeId,$rolePermissions) ) echo 'checked' ?>>
			<?php echo $lThree->permission_name?>
			</td>
		</tr>
				<?php endforeach;?>
			<?php endforeach;?>
		<?php endforeach;?>
		</table>
		<input name="submit" type="submit" value="确定" class="form-button form-button-submit" />
	</form>
</div>