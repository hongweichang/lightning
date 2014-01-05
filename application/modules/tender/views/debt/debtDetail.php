<?php
$this->cs->registerScriptFile($this->scriptUrl.'jquery-1.8.2.min.js',CClientScript::POS_END);
$this->cs->registerScriptFile($this->scriptUrl.'lend.js',CClientScript::POS_END);
$this->cs->registerCssFile($this->cssUrl.'common.css');  
$this->cs->registerCssFile($this->cssUrl.'lend.css');
if(Yii::app()->user->hasFlash('success')){
	$info = Yii::app()->user->getFlash('success');
?>
	<script type="text/javascript">alert('<?php echo $info?>');</script>
<?php
	} 
?>
 <div class="wd1002">
        <div class="breadcrumb">
          <ul>
            <li class="breadcrumb-item">
              <a href="#">债券转让</a>
            </li>
            <li class="breadcrumb-separator"> >
            </li>
            <li class="breadcrumb-item">
              <a href="#">转让中心</a>
            </li>
            <li class="breadcrumb-separator"> >
            </li>
            <li class="breadcrumb-item active">
              <a href="#">标段详情</a>
            </li>
          </ul>
        </div>
        <div id="lend-details" class="clearfix">
          <div class="details-head clearfix">
            <div class="return"><a href="<?php echo Yii::app()->createUrl('tender/debt/debtList');?>">←返回</a></div>
            <div class="name">标段详情</div>
            <div class="balance">
              <a href="#">账户余额¥<span>
              <?php
              	if(!empty($userData)){
              		echo $userData->balance/100;
              	} 
              	
              ?>元
              </span>
              <img src="<?php echo $this->imageUrl.'/topup_ico.png'?>" /></a></div>
          </div>
          <div class="details-info creditor"  id="tab-content">
            <div class="info-title">债权细节</div>
            <div class="tab-body creditor">
            <div class="tab-content borrower-content tab-show">
              <table>
                <tbody>
                  <tr>
                    <td class="t-borrower-name">债权标题</td>
                    <td class="t-borrower-val"><?php echo $debtData->title;?></td>
                  </tr>
                  <tr>
                    <td class="t-borrower-name">债权简介</td>
                    <td class="t-borrower-val"><?php echo $debtData->description;?></td>
                  </tr>
                  <tr>
                    <td class="t-borrower-name">债权人信息</td>
                    <td class="t-borrower-val"><?php echo $debtData->Debt_master;?></td>
                  </tr>
                  <tr>
                    <td class="t-borrower-name">获益方式</td>
                    <td class="t-borrower-val"><?php echo $debtData->incomeWay;?></td>
                  </tr>
                  <tr>
                    <td class="t-borrower-name">开始时间</td>
                    <td class="t-borrower-val"><?php echo $debtData->start;?></td>
                  </tr>
                  <tr>
                    <td class="t-borrower-name">结束时间</td>
                    <td class="t-borrower-val"><?php echo $debtData->end;?></td>
                  </tr>
                  <tr>
                    <td class="t-borrower-name">加入条件</td>
                    <td class="t-borrower-val"><?php echo $debtData->condition;?></td>
                  </tr>
                  <tr>
                    <td class="t-borrower-name">期限</td>
                    <td class="t-borrower-val"><?php echo $debtData->deadline;?>个月</td>
                  </tr>
                  <tr>
                    <td class="t-borrower-name">加入费用</td>
                    <td class="t-borrower-val"><?php echo $debtData->charge;?></td>
                  </tr>
                  <tr>
                    <td class="t-borrower-name">保障方式</td>
                    <td class="t-borrower-val"><?php echo $debtData->protection;?></td>
                  </tr>
                  <tr>
                    <td class="t-borrower-name">备注</td>
                    <td class="t-borrower-val"><?php echo $debtData->remark;?></td>
                  </tr>
                </tbody>
              </table>
            </div>
            </div>
          </div>
          <div class="details-lend" id="fixedRight">
            <div class="info-title">留下信息<span class="info-subtitle">线下交易，客服会与您联系</span></div>
            <form method="post" action="#" id="creditor-form">
            <?php if(!empty($userData)){?>
              <h2>确认你的信息</h2>
              <p>姓名 ：<?php echo $userData->realname;?></p>
              <p>手机号码 : <?php echo $userData->mobile;?></p>
            <?php }else{?>
            	请先登录
            <?php }?>
              <div>
                <input type="checkbox" checked="checked" name="protocal" id="protocal" />
              </div>
              <?php if(!empty($userData)){?>
              <a href="<?php echo Yii::app()->createUrl('tender/debt/joinDebt',array('id'=>$debtData->id));?>" id="creditor-confirm">留下我的信息</a>
              <?php }?>
            </form>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
        function htmlScroll()
        {
         var top = document.body.scrollTop ||  document.documentElement.scrollTop;
         if(elFix.data_top < top)
         {
          elFix.style.position = 'fixed';
          elFix.style.top = 0;
          elFix.style.left = elFix.data_left-20+"px";
         }
         else
         {
          elFix.style.position = 'static';
         }
         if(top > left_h -40)
         {
          elFix.style.position = 'absolute';
          elFix.style.top = left_h-120 + "px";
          elFix.style.left = elFix.data_left-20+"px";
         }
        }
        function htmlPosition(obj)
        {
         var o = obj;
         var t = o.offsetTop;
         var l = o.offsetLeft;
         while(o = o.offsetParent)
         {
          t += o.offsetTop;
          l += o.offsetLeft;
         }
         obj.data_top = t;
         obj.data_left = l;
        }
        var oldHtmlWidth = document.documentElement.offsetWidth;
        window.onresize = function(){
         var newHtmlWidth = document.documentElement.offsetWidth;
         if(oldHtmlWidth == newHtmlWidth)
         {
          return;
         }
         oldHtmlWidth = newHtmlWidth;
         elFix.style.position = 'static';
         htmlPosition(elFix);
         htmlScroll();
        }
        window.onscroll = htmlScroll;
        var elFix = document.getElementById('fixedRight');
        var left_h = document.getElementById('tab-content').offsetHeight;
        htmlPosition(elFix);
        </script>
