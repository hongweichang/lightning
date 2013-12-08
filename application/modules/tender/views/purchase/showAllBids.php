<?php 
$this->cs->registerCssFile($this->cssUrl.'lend.css');
$this->cs->registerScriptFile($this->scriptUrl.'lend.js',CClientScript::POS_END);
//echo Yii::app()->getModule('credit')->getComponent('userCreditManager')->getUserCreditLevel($val['user_id']);

//echo "<pre>";
//print_r( $dataProvider->getCriteria());
//print_r($dataProvider->getData());
?>
<div class="wd1002">
    		<div class="breadcrumb">
    			<ul>
    				<li class="breadcrumb-item">
    					<a href="#">我要投资</a>
    				</li>
    				<li class="breadcrumb-separator"> 
    				</li>
    				<li class="breadcrumb-item active">
    					<a href="#">投资中心</a>
    				</li>
    			</ul>
    		</div>
    		<div class="loan-filter clearfix">
    			<div class="filter">
    				<div class="filter-header clearfix">
    					<h4>筛选投资项目</h4>
    					<!--<span id="filter-switch">多选</span>
    				--></div>
    				<ul>
    					<li>
    						<ul>
    							<li class="filter-item">月&nbsp;利&nbsp;率&nbsp;</li>
    							<li class="filter-item filter-choice active">
    								<input type="checkbox" name="monthRate" value="all" checked="checked" />
    								<span>不限</span>
    							</li>
    							<!-- 月利率条件循环开始 -->
    							<?php foreach ($monthRate as $key => $val) {?>
    							<li class="filter-item filter-choice">
    								<input type="checkbox" name="monthRate" value="<?php echo $val; ?>" />
    								<span><?php echo $val; ?></span>
    							</li>
    							<?php }?><!-- 月利率条件循环结束 -->
    						</ul>
    					</li>
    					<li>
    						<ul>
    							<li class="filter-item">借款期限</li>
    							<li class="filter-item filter-choice active">
    								<input type="checkbox" name="deadline" value="all" checked="checked" />
    								<span>不限</span>
    							</li>
    							<!-- 借款期限条件列表开始 -->
    							<?php foreach ($deadline as $key => $val) {?>
    							<li class="filter-item filter-choice">
    								<input type="checkbox" name="deadline" value="<?php echo $val; ?>" />
    								<span><?php echo $val; ?>个月</span>
    							</li>
    							<?php }?><!-- 借款期限条件列表结束 -->
    						</ul>
    					</li>
    					<li>
    						<ul>
    							<li class="filter-item">认证等级</li>
    							<li class="filter-item filter-choice active">
    								<input type="checkbox" name="authenGrade" value="all" checked="checked" />
    								<span>不限</span>
    							</li>
    							<!-- 认证等级条件列表开始 -->
    							<?php foreach ($authenGrade as $key => $val) {?>
    							<li class="filter-item filter-choice">
    								<input type="checkbox" name="authenGrade" value="<?php echo $val; ?>" />
    								<span><?php echo $val; ?></span>
    							</li>
    							<?php }?><!-- 认证等级条件列表结束 -->
    						</ul>
    					</li>
    				</ul>
    			</div>
    			<div class="guide">
    				<h4>投标注意</h4>
    				<p>确认投标信息，不要盲目投标</p>
    				<p>不要听从旁人指导，自己确认</p>
    				<p>投标有风险，请用户须知</p>
    				<p>如有问题，可以询问客服</p>
    			</div>
    		</div>
    		<div class="loan">
                <div class="title">投资推荐</div>
                <div class="list-head">
                    <span>借款人</span>
                    <span>借款标题</span>
                    <span>年利率</span>
                    <span>信用等级</span>
                    <span>金额</span>
                    <span>期限</span>
                    <span>进度</span>
                </div>
                <ul>
                <!-- 标段信息列表开始 默认显示2条 -->
                <?php foreach ($dataProvider->getData() as $key => $val) {?>
                    <li class="loan-list">
                        <div class="loan-avatar">
                            <img src="<?php echo $this->imageUrl;?>intro-pic_1.png" />
                            <span>信</span>
                        </div>
                        <div class="loan-title"><a href="<?php 
                        	echo $this->createUrl($purchaseUrl,array(
                        		 'bidId'=>$val['id'],
                        		 'userId'=>$val['user_id'])
                        	);?>">
                        <?php echo $val['title'];?></a></div>
                        <div class="loan-rate loan-num"><?php echo $val['month_rate'];?>%</div>
                        <div class="loan-rank">
                        	<?php $rank = Yii::app()->getModule('credit')->
                        			getComponent('userCreditManager')->getUserCreditLevel($val['user_id']);?>
                        	<div class="rank<?php echo $rank;?>"><?php echo $rank;?></div>
                        </div>

                        <div class="loan-amount loan-num">￥<?php echo $val['sum'] / 100;?>元</div>
                        <div class="loan-time loan-num"><?php echo $val['deadline'];?>个月</div>
                        <!-- 进度这个要作关联查询 累加总计的sum  -->
                        <!-- 自己写了半天，原来数据库里面就有个字段是progress来表示进度。。。。吐血啊~~~ -->
                        <?php 
                       				/*$bidInfo = $val->bidMeta;
                                    $sum = 0;
                                    foreach ($bidInfo as $valIn){
                                    $sum += $valIn->sum;
                                    }
                                    $percent = ($sum / $val['sum']) * 100;*/
                        ?>
                        <div class="loan-progress">
                            <div class="bar-out">
                                <div class="bar-in">
                                    <span class="bar-complete" style="width:<?php echo $val['progress'];?>%"></span>
                                    <span class="bar-num"><?php echo $val['progress'];?>%</span>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php }?> <!-- 标段信息列表结束 -->
                </ul>
                <!-- 这个Ajax请求在哪？？ -->
                <div id="viewMore">
                	<img src="<?php echo $this->imageUrl;?>more_ico.png" />
                	<span>查看更多</span>
                </div>
            </div>
    	</div>