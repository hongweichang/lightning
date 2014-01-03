<?php 
$compelete = false;
if ( $bid->verify_progress == 31 ){
	$compelete = true;
}
?>
<?php $this->cs->registerCssFile($this->cssUrl.'lend.css');?>
<?php $this->cs->registerScriptFile($this->scriptUrl.'jquery.validate.min.js',CClientScript::POS_END);?>
<?php $this->cs->registerScriptFile($this->scriptUrl.'calculator.js',CClientScript::POS_END);?>
<?php $this->cs->registerScriptFile($this->scriptUrl.'lend.js',CClientScript::POS_END);?>
<div class="wd1002">
        <div class="breadcrumb">
          <ul>
            <li class="breadcrumb-item">
              <a href="<?php echo $this->createUrl('purchase/index'); ?>">我要投资</a>
            </li>
            <li class="breadcrumb-separator"> >
            </li>
            <li class="breadcrumb-item active">
              <a>标段详情</a>
            </li>
          </ul>
        </div>
        <div id="lend-details" class="clearfix">
          <div class="details-head clearfix">
            <div class="return"></div>
            <div class="name">标段详情</div>
            <div class="balance">
            <?php if ( $user !== null) :?>
              <a href="<?php echo $this->app->createUrl('user/userCenter') ?>">
				账户余额¥<span><?php echo number_format($user->getAttribute('balance') / 100,2);?></span><img src="<?php echo $this->imageUrl;?>topup_ico.png" />
              </a>
           <?php endif;?>
            </div>
          </div>
          <div class="details-info">
            <div class="info-title"><?php echo $bid->getAttribute('title');?></div>
            <div class="info-content clearfix">
              <div class="info-content-l">
                <p>借款金额</p>
                <p class="info-content-val"><span>¥</span><?php echo number_format($bid->getAttribute('sum') / 100,2);?></p>
              </div>
              <div class="info-content-r">
                <p>信用等级</p>
                <div class="rank<?php echo $authGrade;?> info-content-rank"><?php echo $authGrade;?></div>
              </div>
              <div class="info-content-l small">
                <p>标段期限</p>
                <p class="info-content-val"><?php echo $bid->getAttribute('deadline');?><span>个月</span></p>
              </div>
              <div class="info-content-l small">
                <p>年利率</p>
                <p class="info-content-val"><?php echo $bid->getAttribute('month_rate') / 100;?><span>%</span></p>
              </div>
              <div class="info-content-r">
                <div class="info-content-term">
                  <div class="term-start">
                    <div class="term-ico">始</div>
                    <p><?php echo date('Y年n月j日',$bid->getAttribute('start'));?></p>
                  </div>
                  <div class="term-end">
                    <div class="term-ico">终</div>
                    <p><?php echo date('Y年n月j日',$bid->getAttribute('end'));?></p>
                  </div>  
                </div>
              </div>
            </div>
            <div class="info-progress">
              <div class="loan-progress">
                  <div class="bar-in">
                    <span class="bar-complete" style="width:<?php echo $bid->getAttribute('progress') / 100;?>%"></span>
                  </div>
                  <span><?php echo number_format($bid->getAttribute('progress_sum') / 100,2);?>元</span>
              </div>
              <div class="loan-progress"><span class="tick">√</span><span>100%安全认证，确保交易有效</span></div>
            </div>
          </div>
          <div class="details-lend">
            <div class="info-title">投资金额<span class="info-subtitle">投资有风险，请谨慎考虑</span></div>
            <form method="post" id="lend-form" action="<?php echo $this->createUrl('purchase/info',array('id' => $bid->getAttribute('id')));?>">
              <input type="text" name="sum" id="lend-num"<?php echo $compelete===true ? ' disabled="disabled" ' : ' '?>data-info="<?php 
              	echo $bid->getAttribute('sum').";".$bid->getAttribute('deadline').";".$bid->getAttribute('month_rate').";".($bid->getAttribute('progress_sum'));
              ?>" /><span>元</span>
              <p>到期总收益 ¥<span id="lend-income">0.00元</span></p>
<!--               <p><a href="#" class="link">将收取一定管理费，计算方式点此</a></p>
 -->              <?php if(CCaptcha::checkRequirements()){ ?>
              <p class="lend-verify">
                <label for="verifycode">验证码</label>
                <input type="text" name="code" id="verifycode"<?php echo $compelete===true ? ' disabled="disabled" ' : ' '?> />
                <?php $this->widget('CCaptcha',array(
					'id' => 'randImage',
					'showRefreshButton' => false,
					'clickableImage' => true,
					'imageOptions' => array(
						'name' => 'randImage',
						'title' => '点击刷新验证码',
						'alt' => '验证码',
					),
				)); ?>
              </p>
              <?php } ?>
              <div>
                <input type="checkbox" checked="checked" name="protocal" id="protocal" />
                <div class="fakeCheck"><span></span></div>
                <label for="protocal" id="protocal-label">我同意<a href="#">《投资人投资协议》</a></label>
              </div>
              <?php if ( $compelete === false ):?>
              <input type="submit" value="加入" id="lend-confirm" />
              <?php else:?>
              <input type="submit" value="还款中" id="lend-confirm" disabled="disabled" class="off"/>
              <?php endif;?>
            </form>
          </div>
          <ul class="details-tab">
            <li id="tab-borrower" class="tab-on">借款人详情</li>
            <li id="tab-record">购买记录</li>
            <li id="tab-info">标段详情</li>
          </ul>
          <div class="tab-body">
            <div class="tab-content borrower-content tab-show">
              <ul>
                <li>
                  <span class="borrower-name">昵称</span>
                  <span class="borrower-val"><?php echo $bider->getAttribute('nickname');?></span>
                </li>
                <li>
                  <span class="borrower-name">真实姓名</span>
                  <span class="borrower-val"><?php echo $bider->getAttribute('realname');?></span>
                </li>
                <li>
                  <span class="borrower-name">性别</span>
                  <span class="borrower-val"><?php echo ($bider->getAttribute('gender')== 1) ? '男' : '女';?></span>
                </li>
                <li>
                  <span class="borrower-name">年龄</span>
                  <span class="borrower-val"><?php echo $bider->getAttribute('age');?></span>
                </li>
                <li>
                  <span class="borrower-name">手机号码</span>
                  <span class="borrower-val"><?php echo preg_replace('/(1[358]{1}[0-9])[0-9]{4}([0-9]{4})/i','$1****$2',$bider->getAttribute('mobile'));?></span>
                </li>
                <li>
                  <span class="borrower-name">社会角色</span>
                  <span class="borrower-val"><?php
                 if($role = $bider->getAttribute('role'))
                 	echo $this->app['roleMap'][$role];
                 else 
                 	echo "还未填写角色";
                 ?></span>
                </li>

                <li class="separator">
                  <span class="borrower-name"></span>
                  <span class="borrower-val separation">以下是选填项目</span>
                </li>
                <li>
                  <span class="borrower-name">房产证</span>
                  <span class="borrower-val"><img src="<?php echo $this->imageUrl;?>auth.png" /></span>
                </li>
                <li>
                  <span class="borrower-name">月收入证明</span>
                  <span class="borrower-val"><img src="<?php echo $this->imageUrl;?>auth.png" /></span>
                </li>
              </ul>
            </div>
            <div class="tab-content record-content">
              <table>
                <colgroup>
                  <col class="tb-col-buyer"></col>
                  <col class="tb-col-title"></col>
                  <col class="tb-col-num"></col>
                  <col class="tb-col-time"></col>
                  <col class="tb-col-status"></col>
                </colgroup>
                <thead>

                  <tr>
                    <th class="tb-col-buyer">买家</th>
                    <th class="tb-col-title">投资金额</th>
                    <th class="tb-col-num">每期获利</th>
                    <th class="tb-col-time">成交时间</th>
                   	<!--<th class="tb-col-status">状态</th>-->
                  </tr>
                </thead>

                <?php 
                $meta->pagination = false;
                $this->widget('zii.widgets.CListView',array(
					'dataProvider' => $meta,
					'itemView' => '_metaList',
					'template' => '{items}',
                	'itemsTagName' => 'tbody',
					'emptyText' => '',
                	'ajaxUpdate' => false,
                	'cssFile' => false,
                	'baseScriptUrl' => null,
				)); ?>
			</table>
            </div>
           
            <div class="tab-content info-content">
              <h1 class="adu-d-nav"><?php echo $bid->getAttribute('title');?></h1>
              <ul>
                <li>借款金额 :  <span><?php echo number_format($bid->getAttribute('sum') / 100,2);?></span>元</li>
                <li>年利率 :  <span><?php echo $bid->getAttribute('month_rate') / 100;?></span>%</li>
                <li>借款期限 :  <span><?php echo $bid->getAttribute('deadline');?></span>个月</li>
                <li>信用等级 :  <span><?php echo $authGrade;?></span></li>
              </ul>
              <ul class="adu-img-bar">
                <li>
                  <img src="<?php echo $this->imageUrl;?>id-card.png" />
                  <p>身份证正反面</p>
                </li>
                <li>
                  <img src="<?php echo $this->imageUrl;?>adu-blank.png" />
                  <p>工资卡存折/银行流水</p>
                </li>
                <li>
                  <img src="<?php echo $this->imageUrl;?>adu-believe.png" />
                  <p>个人信用报告</p>
                </li>
                <li>
                  <img src="<?php echo $this->imageUrl;?>adu-address.png" />
                  <p>常驻地址证明</p>
                </li>
              </ul>
              <div class="adu-intro">
                <h3>【标段介绍】</h3>
                <p><?php echo $bid->getAttribute('description');?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
