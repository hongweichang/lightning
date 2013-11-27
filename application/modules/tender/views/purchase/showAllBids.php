<?php $this->cs->registerCssFile($this->cssUrl.'lend.css'); 
/*echo "<pre>";
print_r( $dataProvider->getCriteria());
print_r($dataProvider->getData());die;*/
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
    								<input type="checkbox" name="loanType" value="all" checked="checked" />
    								<span>不限</span>
    							</li>
    							<li class="filter-item filter-choice">
    								<input type="checkbox" name="loanType" value="" />
    								<span><?php echo $monthRate['condition1']; ?></span>
    							</li>
    							<li class="filter-item filter-choice">
    								<input type="checkbox" name="loanType" value="" />
    								<span><?php echo $monthRate['condition2']; ?></span>
    							</li>
    							<li class="filter-item filter-choice">
    								<input type="checkbox" name="loanType" value="" />
    								<span><?php echo $monthRate['condition3']; ?></span>
    							</li>
    						</ul>
    					</li>
    					<li>
    						<ul>
    							<li class="filter-item">借款期限</li>
    							<li class="filter-item filter-choice active">
    								<input type="checkbox" name="loanTime" value="all" checked="checked" />
    								<span>不限</span>
    							</li>
    							<li class="filter-item filter-choice">
    								<input type="checkbox" name="loanTime" value="term_3_6" />
    								<span><?php echo $deadline['condition1']; ?>个月</span>
    							</li>
    							<li class="filter-item filter-choice">
    								<input type="checkbox" name="loanTime" value="term_9_12" />
    								<span><?php echo $deadline['condition2']; ?>个月</span>
    							</li>
    							<li class="filter-item filter-choice">
    								<input type="checkbox" name="loanTime" value="term_9_12" />
    								<span><?php echo $deadline['condition3']; ?>个月</span>
    							</li>
    						</ul>
    					</li>
    					<li>
    						<ul>
    							<li class="filter-item">认证等级</li>
    							<li class="filter-item filter-choice active">
    								<input type="checkbox" name="rank" value="all" checked="checked" />
    								<span>不限</span>
    							</li>
    							<li class="filter-item filter-choice">
    								<input type="checkbox" name="rank" value="rank_AA" />
    								<span><?php echo $authenGrade['condition1']; ?></span>
    							</li>
    							<li class="filter-item filter-choice">
    								<input type="checkbox" name="rank" value="rank_A" />
    								<span><?php echo $authenGrade['condition2']; ?></span>
    							</li>
    							<li class="filter-item filter-choice">
    								<input type="checkbox" name="rank" value="rank_A" />
    								<span><?php echo $authenGrade['condition3']; ?></span>
    							</li>
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
                    <span>月利率</span>
                    <span>信用等级</span>
                    <span>金额</span>
                    <span>期限</span>
                    <span>进度</span>
                </div>
                <ul>
                    <li class="loan-list">
                        <div class="loan-avatar">
                            <img src="<?php echo $this->imageUrl;?>intro-pic_1.png" />
                            <span>信</span>
                        </div>
                        <div class="loan-title"><a href="#">再次支持免费充值</a></div>
                        <div class="loan-rate loan-num">10.00%</div>
                        <div class="loan-rank"><div class="rankA">A</div></div>
                        <div class="loan-amount loan-num">￥3000元</div>
                        <div class="loan-time loan-num">3个月</div>
                        <div class="loan-progress">
                            <div class="bar-out">
                                <div class="bar-in">
                                    <span class="bar-complete" style="width:30%"></span>
                                    <span class="bar-num">30%</span>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="loan-list">
                        <div class="loan-avatar">
                            <img src="<?php echo $this->imageUrl;?>intro-pic_1.png" />
                            <span>信</span>
                        </div>
                        <div class="loan-title"><a href="#">再次支持免费充值</a></div>
                        <div class="loan-rate loan-num">10.00%</div>
                        <div class="loan-rank"><div class="rankHR">HR</div></div>
                        <div class="loan-amount loan-num">￥3000元</div>
                        <div class="loan-time loan-num">3个月</div>
                        <div class="loan-progress">
                            <div class="bar-out">
                                <div class="bar-in">
                                    <span class="bar-complete" style="width:30%"></span>
                                    <span class="bar-num">30%</span>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <div id="viewMore">
                	<img src="<?php echo $this->imageUrl;?>more_ico.png" />
                	<span>查看更多</span>
                </div>
            </div>
    	</div>