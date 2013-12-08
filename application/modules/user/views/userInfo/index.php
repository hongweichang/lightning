<h1>搜索</h1>
<form>
    <fieldset>
        <label for="nick-name">昵称</label>
        <input type="text" id="nick-name" name="nick-name" />

        <label for="user-name">姓名</label>
        <input type="text" id="user-name" name="user-name" />

        <label for="mobile-number">手机</label>
        <input type="text" id="mobile-number" name="mobile-number" />

        <label for="uptime-0">上传时间</label>
        <input type="text" id="uptime-0" name="uptime-0" />
        <label for="uptime-1">---</label>
        <input type="text" id="uptime-1" name="uptime-1" />

        <input type="button" value="搜索" />
    </fieldset>
</form>
<table class="userMessage">
    <tbody>
    <tr>
        <td>昵称</td>
        <td>姓名</td>
        <td>手机号码</td>
        <td>审核内容</td>
        <td>附件</td>
        <td>上传时间</td>
        <td>操作</td>
    </tr>
<?php
if(!empty($userCreditData)){
	foreach($userCreditData as $value){
?>
    <tr>
        <td><?php echo $value['nickname'];?></td>
        <td><?php echo $value['realname'];?></td>
        <td><?php echo $value['mobile'];?></td>
        <td><?php echo $value['verificatoin_name'];?></td>
        <td><a href="<?php echo Yii::app()->createUrl('user/userInfo/download',array('id'=>$value['id']));?>">下载附件</a></td>
        <td><?php echo $value['submit_time'];?></td>
        <td>
            <a href="#" class="check" data-method="check-pass">审核</a>
        </td>
    </tr>
 <?php }
 	}?>
    </tbody>
</table>
<p>
    <span class="page">1</span>
    <span class="page">2</span>
    <span class="page">3</span>
    <span class="page">4</span>
    <span class="page">5</span>
</p>

