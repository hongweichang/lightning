<p><label>信用项标题</label></p>
<input type="text" name = "title" class="text-input" value="<?php echo $Creditmodel->verification_name;?>" />

<p><label>信用项简介</label></p>
<textarea name = "description" class="text-input textarea"/><?php echo $Creditmodel->description;?></textarea>

<p><label>信用积分</label></p>
<input type="text" name = "grade" class="text-input"/>

<p><label>网店店主</label></p>
<select name="wddz">
	<option value=" ">不填</option>
	<option value="1">选填</option>
	<option value="0">必填</option>
</select>

<p><label>企业主</label></p>
<select name="qyz">
	<option value=" ">不填</option>
	<option value="1">选填</option>
	<option value="0">必填</option>
</select>

<p><label>工薪阶层</label></p>
<select name="gxjc">
	<option value=" ">不填</option>
	<option value="1">选填</option>
	<option value="0">必填</option>
</select>
<br/>
<br/>
<input type="submit" name="submit" class="button" />

