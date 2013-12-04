<?php
$this->cs->registerScriptFile($this->scriptUrl.'jquery-1.8.2.min.js',CClientScript::POS_END);
$this->cs->registerScriptFile($this->scriptUrl.'jquery.validate.min.js',CClientScript::POS_END);
$this->cs->registerCssFile($this->cssUrl.'common.css');
$this->cs->registerCssFile($this->cssUrl.'detail.css');
?>
<html>
<body>
    <div id="container">
        <div class="wd989">
            <h1 class="aud-nav">
                <a href="#">个人中心 ></a>
                <a href="#">我的闪电贷</a>
            </h1>
            <div class="aud-detail">
                <div class="det-per-inf">
                    <img src="<?php echo $this->imageUrl.'user-avatar.png'?>" class="det-img" />
                    <p>
                        <span class="aud-time">晚上好，</span>
                        <span class="aud-det-name"><?php echo Yii::app()->user->name;?> </span>
                        现在是属于你自己的时间，好好休息吧
                    </p>
                    <p class="aud-st-serve">
                        <img src="<?php echo $this->imageUrl.'det-person.png'?>" />
                        <img src="<?php echo $this->imageUrl.'det-pro.png'?>" />
                        <img src="<?php echo $this->imageUrl.'det-email.png'?>" />
                        <img src="<?php echo $this->imageUrl.'det-cal.png'?>" />
                        <img src="<?php echo $this->imageUrl.'det-bank.png'?>" />
                        <span>安全等级 :  <span class="det-rank">高</span></span>
                        <span>上次登陆 :  <span class="det-ip"> 重庆市 2013.1116.19:35:35</span></span>
                    </p>
                </div>
                <div class="aud-money">
                    <div class="mon-show">
                        <p>
                            <span>账户余额</span>
                            <span>我的投资</span>
                            <span>我的借贷</span>
                        </p>
                        <p class="det-mon">
                            <span>0.00</span>
                            <span>=</span>
                            <span>0.00</span>
                            <span>+</span>
                            <span class="mon-out">-0.00</span>
                        </p>
                        <div>
                            <a href="#" id="int">充值</a>
                            <a href="#" id="out">提现</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="aud-find">
                <ul id="find-table-button">
                    <a href="">
                        <li class="find-table-0"><div class="find-table-op find-table-op"></div>我的借款</li>
                    </a>
                    <a href="<?php echo Yii::app()->createUrl('user/userCenter/myLend');?>">
                        <li class="find-table-1"><div class="find-table-op"></div>我的投资</li>
                    </a>
                    <a href="<?php echo Yii::app()->createUrl('user/userCenter/userSecurity');?>">
                        <li class="find-table-2"><div class="find-table-op"></div>安全中心</li>
                    </a>
                    <a href="">
                        <li class="find-table-3"><div class="find-table-op-hidden"></div>个人信息</li>
                    </a>
                    <a href="">
                        <li class="find-table-4"><div class="find-table-op"></div>资金管理</li>
                    </a>
                </ul>
                <div class="tab-list">
                    <ul id="find-table-detail">
                        <li class="find-selected">基本信息</li>
                        <li>认证信息</li>
                        <li>银行卡</li>
                    </ul>
                </div>
                <div class="basic-info find-table-content find-table-content-show">
                    <a href="javascript:;"  class="user-avatar">
                        <img src="<?php echo $this->imageUrl.'user-avatar.png'?>" />
                        <p>点击修改头像</p>
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
                                <p><?php echo $userData->identity_id;?></p>
                                <p class="ico-status unpass">已认证</p>
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
                                		}else
                                			echo $userData->gender; 
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
                                <p><?php echo $userData->role;?></p>
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
                                <p>37727423</p>
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
                                <p><?php echo $userData->identity_id;?></p>
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
                                <?php echo $form->dropDownList($userData,'role',array(
                                			'0'=>'女',
                                			'1'=>'男',
                                			
                                ));?>
                            </li>
                            <li class="clearfix">
                                <label class="personal-name">年龄</label>
                                <div class="personal-ico personal-birth"></div>
                               <?php echo $form->textField($userData,'gender'); ?>
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
                                			'0'=>'个人',
                                			'1'=>'企业',
                                			'2'=>'淘宝店主'

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
                <div class="find-table-content">
                </div>
                <div class="find-table-content">
                </div>
            </div>
        </div>
    </div>
<?php
$this->cs->registerScriptFile($this->scriptUrl.'/update.js',CClientScript::POS_END);
$this->cs->registerScriptFile($this->scriptUrl.'tableChange.js',CClientScript::POS_END);
?>
</body>
</html>