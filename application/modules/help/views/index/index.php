<?php $this->cs->registerCssFile($this->cssUrl.'help.css'); 
$this->cs->registerScriptFile($this->scriptUrl.'help.js',CClientScript::POS_END);
?>
         <div class="wd1002 hc clearfix">
            <div class="hc-side">
                <ul>
                    <li class="hc-side-item"><a href="#" class="active">名词解释<span>>></span></a></li>
                    <li class="hc-side-item"><a href="#">平台介绍<span>>></span></a></li>
                    <li class="hc-side-item"><a href="#">利息和费用<span>>></span></a></li>
                    <li class="hc-side-item"><a href="#">我要借款<span>>></span></a></li>
                    <li class="hc-side-item"><a href="#">我要理财<span>>></span></a></li>
                    <li class="hc-side-item"><a href="#">闪电贷账户<span>>></span></a></li>
                </ul>
            </div>
            <div id="hc-content">
                <h2>名词解释</h2>
                <ul>
                    <?php
                    	$i = 1; 
//                    	$this->wxweven($helpInfo[0]);
						//分类内容还不知道怎么确定，暂时定名次解释为category最小的
                    	foreach ($helpInfo[0] as $val){
                    ?>
                    <li>
                        <div class="hc-title"><?php echo $i.".".$val->title;?></div>
                        <p><?php echo $val->content;?></p>
                    </li>
                   <?php
                   		$i++; 
                    }
                   ?>
                </ul>
            </div>
        </div>
