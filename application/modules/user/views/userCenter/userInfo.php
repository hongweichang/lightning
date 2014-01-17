<?php
$this->cs->registerScriptFile($this->scriptUrl.'jquery.validate.min.js',CClientScript::POS_END);
$this->cs->registerCssFile($this->cssUrl.'detail.css');
if(Yii::app()->user->hasFlash('upload_success')){
    $upload_info = Yii::app()->user->getFlash('upload_success');
?>
<script>alert('<?php echo $upload_info?>');</script>
<?php }elseif(Yii::app()->user->hasFlash('upload_error')){
    $upload_info = Yii::app()->user->getFlash('upload_error');
?>
<script>alert('<?php echo $upload_info?>');</script>

<?php 
}if(Yii::app()->user->hasFlash('success')){
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
        'button_width'=>97,
        'button_height'=>25,
       // 'button_image_url'=>$IconUrl,
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
            <div class="aud-find aud-find-menu">
                <ul id="find-table-button">
                    <a href="<?php echo Yii::app()->createUrl('user/userCenter/userInfo');?>">
                        <li class="find-table-3"><div class="find-table-op-hidden">个人信息</div></li>
                    </a>
                    <a href="<?php echo Yii::app()->createUrl('user/userCenter/myBorrow');?>">
                        <li class="find-table-0"><div class="find-table-op">我的借款</div></li>
                    </a>
                    <a href="<?php echo Yii::app()->createUrl('user/userCenter/myLend');?>">
                        <li class="find-table-1"><div class="find-table-op">我的投资</div></li>
                    </a>
                    <a href="<?php echo Yii::app()->createUrl('user/userCenter/userSecurity');?>">
                        <li class="find-table-2"><div class="find-table-op">安全中心</div></li>
                    </a>
                    <a href="<?php echo $this->createUrl('userCenter/userFund')?>">
                        <li class="find-table-4"><div class="find-table-op">资金管理</div></li>
                    </a>
                </ul>
            </div>
            <div class="aud-find">
                
                <div class="tab-list">
                    <?php if(isset($upload_info)){?>
                    <ul id="find-table-detail">
                        <li>基本信息</li>
                        <li class="find-selected">信用资料</li>
                    </ul>
                    <?php }else{?>
                     <ul id="find-table-detail">
                        <li class="find-selected">基本信息</li>
                        <li>信用资料</li>
                    </ul>                   
                    <?php }?>
                </div>
                <?php if(isset($upload_info)){?>
                <div class="basic-info find-table-content">    
                <?php }else{?>
                <div class="basic-info find-table-content find-table-content-show">
                <?php }?>
                    <a href="javascript:;"  class="user-avatar">
                     <?php if(!empty($IconUrl)){?>
                        <img id="mini-icon" src="<?php echo $IconUrl;?>"/>
                    <?php }else{?>
                        <img src="<?php echo $this->imageUrl.'user-avatar.png'?>" />
                    <?php }?>
                         <div class="swfupload" style="display:inline-block"><span id="swfupload"></span>
                         </div>
                         <div id="divFileProgressContainer"></div>
                    </a>
                    <form class="show">
                        <ul class="personal-info">
                            <li class="clearfix">
                                <label class="personal-name"><span class="essential">*</span>昵称</label>
                                <div class="personal-ico personal-nick"></div>
                                <p><?php echo $userData->nickname;?></p>
                            </li>
                            <li class="clearfix">
                                <label class="personal-name"><span class="essential">*</span>真实姓名</label>
                                <div class="personal-ico personal-realname"></div>
                                <p><?php echo $userData->realname;?></p>
                                <?php if(!empty($userData->realname)){?>
                                <p class="ico-status pass">已绑定</p>
                                <?php }else{?>
                                 <p class="ico-status unpass">未绑定</p>
                                <?php }?>
                            </li>
                            <li class="clearfix">
                                <label class="personal-name"><span class="essential">*</span>身份证号</label>
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
                                <label class="personal-name"><span class="essential">*</span>手机号码</label>
                                <div class="personal-ico personal-phone"></div>
                                <p><?php echo $userData->mobile;?></p>
                                <p class="ico-status pass">已绑定</p>
                            </li>
                            <li class="clearfix">
                                <label class="personal-name"><span class="essential">*</span>邮箱地址</label>
                                <div class="personal-ico personal-mail"></div>
                                <p><?php echo $userData->email;?></p>
                                <p class="ico-status pass">已绑定</p>
                            </li>
                            <li class="clearfix">
                                <label class="personal-name"><span class="essential">*</span>性别</label>
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
                                <label class="personal-name"><span class="essential">*</span>居住地址</label>
                                <div class="personal-ico personal-address"></div>
                                <p><?php echo $userData->address?></p>
                            </li>
                            <li class="clearfix">
                                <label class="personal-name"><span class="essential">*</span>社会角色</label>
                                <div class="personal-ico personal-role"></div>
                                <p>
                                <?php
                                    if($userData->role == null){
   
                                ?>
                                <span style="display:inline;">暂未设置</span><span style="display:inline;font-size:12px;color:red;">请选择社会角色后上传信用资料</span>
                                <?php }else
                                        echo FrontUser::getRoleName($userData->role);
                                ?>
                                </p>
                            </li>
                            <li class="clearfix">
                                <label class="personal-name">会员级别</label>
                                <div class="personal-ico personal-role"></div>
                                <p>
                                <?php 
                                    echo $creditLevel;
                                    if($loanable == false){
                                ?>
                                    <span style="color:red;font-size:14px;display:inline;">当前不允许发标,请完善资料</span>
                                <?php }
                                ?>
                                </p>
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
                                <label class="personal-name"><span class="essential">*</span>昵称</label>
                                <div class="personal-ico personal-nick"></div>
                                <p><?php echo $userData->nickname;?></p>
                            </li>
                            <li class="clearfix">
                                <label class="personal-name"><span class="essential">*</span>真实姓名</label>
                                <div class="personal-ico personal-realname"></div>
                                <p>
                                <?php
                                    if(!empty($userData->realname)){
                                        echo $userData->realname;
                                    }else{
                                        echo $form->textField($userData,'realname'); 
                                    }  
                                ?>
                                </p>
                                <?php if(!empty($userData->realname)){?>
                                <p class="ico-status pass">已认证</p>
                                <?php }else{?>
                                 <p class="ico-status unpass">未认证</p>
                                <?php }?>
                            </li>
                            <li class="clearfix">
                                <label class="personal-name"><span class="essential">*</span>身份证号</label>
                                <div class="personal-ico personal-id"></div>
                                <p>
                                <?php
                                if(!empty($userData->identity_id)){
                                    echo $userData->identity_id;
                                }else{
                                    echo $form->textField($userData,'identity_id'); 
                                }
                                ?>
                                </p>
                                <p class="ico-status unpass">未认证</p>
                            </li>
                            <li class="clearfix">
                                <label class="personal-name"><span class="essential">*</span>手机号码</label>
                                <div class="personal-ico personal-phone"></div>
                                <p><?php echo $userData->mobile;?></p>
                                <p class="ico-status pass">已绑定</p>
                            </li>
                            <li class="clearfix">
                                <label class="personal-name"><span class="essential">*</span>邮箱地址</label>
                                <div class="personal-ico personal-mail"></div>
                                <p><?php echo $userData->email;?></p>
                                <p class="ico-status pass">已绑定</p>
                            </li>
                            <li class="clearfix">
                                <label class="personal-name"><span class="essential">*</span>性别</label>
                                <div class="personal-ico personal-sex"></div>
                                <?php echo $form->dropDownList($userData,'gender',array(
                                			'0'=>'女',
                                			'1'=>'男',
                                            null=>'保密'
                                			
                                ));?>
                            </li>
                            <li class="clearfix">
                                <label class="personal-name"><span class="essential">*</span>居住地址</label>
                                <div class="personal-ico personal-address"></div>
                                <?php echo $form->textField($userData,'address');?>
                            </li>
                            <li class="clearfix">
                                <label class="personal-name"><span class="essential">*</span>社会角色</label>
                                <div class="personal-ico personal-role"></div>
                                <?php 
                                      echo $form->dropDownList($userData,'role',array(
                                            'gxjc'=>'工薪阶层',
                                            'qyz'=>'企业主',
                                            'wddz'=>'网店店主'

                                     ));
                                    ?>
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

                <?php if(isset($upload_info)){?>
                <div class="find-table-content verify find-table-content-show">
                <?php }else{?>
                <div class="find-table-content verify">
                <?php }?>
                    <table>
                        <tr>
                            <td>&nbsp</td>
                            <td width="200">项目</td>
                            <td width="300"></td>
                            <td>状态</td>
                            <td class="score">信用分数</td>
                        </tr>
                        <tr>
                            <td rowspan="<?php echo $necessaryNum +1;?>">必要信息</td>
                            <td></td>
                            <td></td>
                            <td>
                                
                            </td>
                            <td class="score" rowspan="<?php echo $necessaryNum +1;?>">60分</td>
                        </tr>
                        <?php
                            if(!empty($necessaryCreditData)){ 
                            foreach($necessaryCreditData as $value){
                                $form=$this->beginWidget('CActiveForm', array(
                                            'id'=>'FrontCredit-form',
                                            'enableAjaxValidation'=>true,
                                            'action'=>$this->createUrl('/user/userCenter/verificationAdd',array('type'=>$value['id'])),
                                            'htmlOptions' => array(
                                                        //'class' => 'hidden'
                                                        'name'=>'file',
                                                        'enctype'=>'multipart/form-data',

                                                        )
                            ));
                        ?>
                        <tr>
                            <td>
                                <?php echo $value['verification_name']?>
                            </td>
                           <?php if($value['status'] != '1'){?>
                            <td>
                                <?php echo $form->FileField($model,'filename'); ?>
                                <?php if($value['status'] == '400') 
                                            echo CHtml::submitButton('提交',array(
                                                    'name'=>$value['verification_name'],
                                                    'class'=>'form-button')
                                                                    ); 
                                    elseif($value['status'] == '0' || $value['status'] == '2') 
                                            echo CHtml::submitButton('修改',array(
                                                    'name'=>$value['verification_name'],
                                                    'class'=>'form-button')
                                                                    );  
                                ?>
                            </td>
                            <?php }else{?>
                            <td></td>
                            <?php }?>
                            <td>
                            <?php
                                if($value['status'] == '400')
                                    echo "未上传";
                                elseif($value['status'] == '0')
                                    echo "等待审核";
                                elseif($value['status'] == '1')
                                    echo "审核通过";
                                elseif($value['status'] == '2')
                                    echo "未通过审核";
                            ?> 
                            </td>

                        </tr>
                        <?php
                            $this->endWidget();
                        }}else{?>
                            <p style="font-size:14px;margin-left:40px;color:red;">请在个人信息中选择角色后上传信用资料</p>
                        <?php }?> 
                        <tr>
                            <td rowspan="<?php echo $unnecessaryNum +1;?>">选填信息</td>
                            <td></td>
                            <td></td>
                            <td>
                                
                            </td>
                            <!-- <td class="score" rowspan="<?php echo $unnecessaryNum +1;?>"></td> -->
                        </tr>
                         <?php
                            if(!empty($unnecessaryCreditData)){ 
                            foreach($unnecessaryCreditData as $value){
                                $form=$this->beginWidget('CActiveForm', array(
                                            'id'=>'FrontCredit-form',
                                            'enableAjaxValidation'=>true,
                                            'action'=>$this->createUrl('/user/userCenter/verificationAdd',array('type'=>$value['id'])),
                                            'htmlOptions' => array(
                                                        //'class' => 'hidden'
                                                        'name'=>'file',
                                                        'enctype'=>'multipart/form-data',

                                                        )
                            ));
                        ?> 
                        <tr>
                            <td>
                                <?php echo $value['verification_name']?>
                            </td>
                           <?php if($value['status'] != '1'){?>
                            <td>
                                <?php echo $form->FileField($model,'filename'); ?>
                                <?php if($value['status'] == '400') 
                                            echo CHtml::submitButton('提交',array(
                                                    'name'=>$value['verification_name'],
                                                    'class'=>'form-button')
                                                                    ); 
                                    elseif($value['status'] == '0' || $value['status'] == '2') 
                                            echo CHtml::submitButton('修改',array(
                                                    'name'=>$value['verification_name'],
                                                    'class'=>'form-button')
                                                                    ); 
                                ?>
                            </td>
                            <?php }else{?>
                            <td></td>
                            <?php }?>
                            <td>
                            <?php
                                if($value['status'] == '400')
                                    echo "未上传";
                                elseif($value['status'] == '0')
                                    echo "等待审核";
                                elseif($value['status'] == '1')
                                    echo "审核通过";
                                elseif($value['status'] == '2')
                                    echo "未通过审核";
                            ?> 
                            </td>
                            <td class="score"><?php echo $value['grade'].'分'?></td>
                        </tr> 
                        <?php
                            $this->endWidget();
                        }}?>                                              
 
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php
$this->cs->registerScriptFile($this->scriptUrl.'/update.js',CClientScript::POS_END);
$this->cs->registerScriptFile($this->scriptUrl.'tableChange.js',CClientScript::POS_END);
?>

