<?php
$this->cs->registerScriptFile($this->scriptUrl.'jquery.validate.min.js',CClientScript::POS_END);
$this->cs->registerCssFile($this->cssUrl.'detail.css');
if(Yii::app()->user->hasFlash('success')){
    $info = Yii::app()->user->getFlash('success');
?>
<script>alert('<?php echo $info?>');</script>
<?php }elseif(Yii::app()->user->hasFlash('error')){
    $info = Yii::app()->user->getFlash('error');

?>
<script>alert('<?php echo $info?>');</script>
<?php
}
$this->widget('application.extensions.swfupload.CSwfUpload', array(
    'jsHandlerUrl'=>Yii::app()->request->baseUrl."/plugins/swfupload/js/handlers.js", //配置swfupload事件的js文件
    'postParams'=>array('PHPSESSID'=>Yii::app()->session->sessionID),//由于flash上传不可以传递cookie只能将session_id用POST方式传递
     'config'=>array(
        //'debug'=>true,//是否开启调试模式
        'use_query_string'=>true,
        'upload_url'=>$this->createUrl('userCenter/iconUpload'), //对应处理图片上传的controller/action
        'file_size_limit'=>'30 MB',//文件大小限制
        'file_types'=>'*.jpg;*.png;*.gif;*.jpeg',//文件格式限制
        'file_types_description'=>'Files',
        'file_upload_limit'=>1,
        'file_queue_limit'=>0,//一次上传文件个数
        'file_queue_error_handler'=>'js:fileQueueError',
        'file_dialog_complete_handler'=>'js:fileDialogComplete',
        'upload_progress_handler'=>'js:uploadProgress',
        'upload_error_handler'=>'js:uploadError',
        'upload_success_handler'=>'js:uploadSuccess',
        'upload_complete_handler'=>'js:uploadComplete',
        'custom_settings'=>array('upload_target'=>'divFileProgressContainer'),
        'button_placeholder_id'=>'swfupload',
        'button_width'=>140,
        'button_height'=>28,
        //'button_image_url'=> $this->imageUrl.'upload_button.png',
        'button_text'=>'<span class="button">点击修改头像</span>',
        'button_text_style'=>'.button { font-family:"微软雅黑", sans-serif; font-size: 15px; text-align: center;color: #666666; }',
        'button_text_top_padding'=>0,
        'button_text_left_padding'=>0,
        'button_window_mode'=>'js:SWFUpload.WINDOW_MODE.TRANSPARENT',
        'button_cursor'=>'js:SWFUpload.CURSOR.HAND',
        ),
    )
);
?>
    <div id="container">
        <div class="wd989">
            <h1 class="aud-nav">
                <a href="#">个人中心 ></a>
                <a href="#">我的闪电贷</a>
            </h1>
            <?php $this->renderPartial('_baseInfo')?>
            <div class="aud-find">
                
                <div class="tab-list">
                    <ul id="find-table-detail">
                        <li class="find-selected">基本信息</li>
                        <li>认证信息</li>
                        <li>银行卡</li>
                    </ul>
                </div>
                <div class="basic-info find-table-content find-table-content-show">
                    <a href="javascript:;"  class="user-avatar">
                    <?php if(!empty($IconUrl)){?>
                        <img src="<?php echo $IconUrl;?>"/>
                    <?php }else{?>
                        <img src="<?php echo $this->imageUrl.'user-avatar.png'?>" />
                    <?php }?>
                         <div class="swfupload" style="display:inline-block"><span id="swfupload"></span>
                         </div>
                    </a>
                    <form class="show">
                        <ul class="personal-info">
                            <li class="clearfix">
                                <label class="personal-name">昵称</label>
                                <div class="personal-ico personal-nick"></div>
                                <p><?php echo $userData->nickname;?></p>
                            </li>
                            <li class="clearfix">
                                <label class="personal-name">真实姓名</label>
                                <div class="personal-ico personal-realname"></div>
                                <p><?php echo $userData->realname;?></p>
                                <p class="ico-status pass">已认证<p>
                            </li>
                            <li class="clearfix">
                                <label class="personal-name">身份证号</label>
                                <div class="personal-ico personal-id"></div>
                                <p>
                                <?php
                                    if(!empty($userData->identity_id)) 
                                        echo $userData->identity_id;
                                    else
                                        echo "暂未填写";

                                ?>
                                </p>
                                <p class="ico-status unpass">未认证</p>
                            </li>
                            <li class="clearfix">
                                <label class="personal-name">手机号码</label>
                                <div class="personal-ico personal-phone"></div>
                                <p><?php echo $userData->mobile;?></p>
                                <p class="ico-status pass">已绑定</p>
                            </li>
                            <li class="clearfix">
                                <label class="personal-name">邮箱地址</label>
                                <div class="personal-ico personal-mail"></div>
                                <p><?php echo $userData->email;?></p>
                                <p class="ico-status pass">已绑定</p>
                            </li>
                            <li class="clearfix">
                                <label class="personal-name">性别</label>
                                <div class="personal-ico personal-sex"></div>
                                <p><?php
                                		if($userData->gender == ''){
                                			echo "保密";                       
                                		}else{
                                            if($userData->gender == '1')
                                			  echo "男";
                                            if($userData->gender == '0')
                                              echo "女"; 
                                        }
                                	?>
                                </p>
                            </li>
                            <li class="clearfix">
                                <label class="personal-name">年龄</label>
                                <div class="personal-ico personal-birth"></div>
                                <p><?php echo $userData->age;?></p>
                            </li>
                            <li class="clearfix">
                                <label class="personal-name">居住地址</label>
                                <div class="personal-ico personal-address"></div>
                                <p><?php echo $userData->address?></p>
                            </li>
                            <li class="clearfix">
                                <label class="personal-name">社会角色</label>
                                <div class="personal-ico personal-role"></div>
                                <p><?php echo FrontUser::getRoleName($userData->role);?></p>
                            </li>
                        </ul>
                    </form>

                     <?php $form=$this->beginWidget('CActiveForm', array(
											'id'=>'FrontUser-form',
											'enableAjaxValidation'=>true,
											'htmlOptions' => array(
														'class' => 'hidden'
														)
					)); ?>
                        <ul class="personal-info">
                            <li class="clearfix">
                                <label class="personal-name">昵称</label>
                                <div class="personal-ico personal-nick"></div>
                                <p><?php echo $userData->nickname;?></p>
                            </li>
                            <li class="clearfix">
                                <label class="personal-name">真实姓名</label>
                                <div class="personal-ico personal-realname"></div>
                                <p><?php echo $userData->realname;?></p>
                                <p class="ico-status pass">已认证</p>
                            </li>
                            <li class="clearfix">
                                <label class="personal-name">身份证号</label>
                                <div class="personal-ico personal-id"></div>
                                <p>
                                <?php echo $form->textField($userData,'identity_id'); ?>
                                </p>
                                <p class="ico-status unpass">未认证</p>
                            </li>
                            <li class="clearfix">
                                <label class="personal-name">手机号码</label>
                                <div class="personal-ico personal-phone"></div>
                                <p><?php echo $userData->mobile;?></p>
                                <p class="ico-status pass">已绑定</p>
                            </li>
                            <li class="clearfix">
                                <label class="personal-name">邮箱地址</label>
                                <div class="personal-ico personal-mail"></div>
                                <p><?php echo $userData->email;?></p>
                                <p class="ico-status pass">已绑定</p>
                            </li>
                            <li class="clearfix">
                                <label class="personal-name">性别</label>
                                <div class="personal-ico personal-sex"></div>
                                <?php echo $form->dropDownList($userData,'gender',array(
                                			'0'=>'女',
                                			'1'=>'男',
                                            null=>'保密'
                                			
                                ));?>
                            </li>
                            <li class="clearfix">
                                <label class="personal-name">年龄</label>
                                <div class="personal-ico personal-birth"></div>
                               <?php echo $form->textField($userData,'age'); ?>
                            </li>
                            <li class="clearfix">
                                <label class="personal-name">居住地址</label>
                                <div class="personal-ico personal-address"></div>
                                <?php echo $form->textField($userData,'address');?>
                            </li>
                            <li class="clearfix">
                                <label class="personal-name">社会角色</label>
                                <div class="personal-ico personal-role"></div>
                                <?php echo $form->dropDownList($userData,'role',array(
                                			'gxjc'=>'工薪阶层',
                                			'qyz'=>'企业主',
                                			'wddz'=>'网店店主'

                                ));?>
                            </li>
                            <li class="clearfix">
                                	 <?php echo CHtml::submitButton('保存修改',array(
                                	 			'id'=>'reply',
                                	 			'name'=>'submit',
                                			 	'class'=>'form-button')
                                	 		); 
                                	 ?>			
                            </li>
                        </ul>
                     <?php $this->endWidget(); ?>
                    <a href="javascript:;" class="form-button" id="personal-modify">修改信息</a>
                </div>

                <div class="find-table-content verify">
               
                    <table>
                        <tr>
                            <td>&nbsp</td>
                            <td width="200">项目</td>
                            <td width="300"></td>
                            <td>状态</td>
                            <td class="score">信用分数</td>
                        </tr>
                        <tr>
                            <td rowspan="3">必要信息</td>
                            <td></td>
                            <td></td>
                            <td>
                                
                            </td>
                            <td class="score" rowspan="3">10分</td>
                        </tr>
                        <?php
                            if(!empty($creditData)){ 
                            foreach($creditData as $value){
                                $form=$this->beginWidget('CActiveForm', array(
                                            'id'=>'FrontCredit-form',
                                            'enableAjaxValidation'=>true,
                                            'action'=>'verificationAdd?type='.$value[0]->id.'',
                                            'htmlOptions' => array(
                                                        //'class' => 'hidden'
                                                        'name'=>'file',
                                                        'enctype'=>'multipart/form-data',

                                                        )
                            ));
                        ?>
                        <tr>
                            <td>
                                <?php echo $value[0]->verification_name?>
                            </td>
                            <td>
                                <?php echo $form->FileField($model,'filename'); ?>
                                <?php echo CHtml::submitButton('提交',array(
                                                'name'=>$value[0]->verification_name,
                                                'class'=>'form-button')
                                            ); 
                                     ?>
                            </td>
                            <td> 状态
                            </td>
                        </tr>
                        <?php
                            $this->endWidget();
                        }}?>  
                    </table>
                </div>

                <div class="find-table-content bankcard">
                    <a href="#" class="bankcard-box">
                        <div>
                            <img src="<?php echo $this->imageUrl.'psbc.png'?>"/>
                            <p>尾号6236</p>
                        </div>
                        <p class="bankcard-op">删除银行卡</p>
                    </a>
                    <a href="#" class="bankcard-box add">
                        <div>
                            <img src="../images/bankcard_add.png" />
                        </div>
                        <p class="bankcard-op">新增银行卡</p>
                    </a>
                    <a href="#" class="bankcard-box add last">
                        <div>
                            <img src="../images/bankcard_add.png" />
                        </div>
                        <p class="bankcard-op">新增银行卡</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php
$this->cs->registerScriptFile($this->scriptUrl.'/update.js',CClientScript::POS_END);
$this->cs->registerScriptFile($this->scriptUrl.'tableChange.js',CClientScript::POS_END);
?>

