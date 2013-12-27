<?php 
$this->cs->registerCssFile($this->cssUrl.'lend.css');
$this->cs->registerScriptFile($this->scriptUrl.'lend.js',CClientScript::POS_END);
?>
<div class="wd1002">
    		<div class="breadcrumb">
    			<ul>
    				<li class="breadcrumb-item">
    					<a href="<?php echo $this->createUrl('/site'); ?>">首页</a> > 
    				</li>
    				<li class="breadcrumb-item">
    				我要投资
    				</li>
    			</ul>
    		</div>
    		<div class="loan-filter clearfix">
    			<div class="filter">
    				<div class="filter-header clearfix">
    					<h4>筛选投资项目</h4>
    					</div>
    				<ul>
    					<li>
    						<ul>
    							<li class="filter-item">年&nbsp;利&nbsp;率&nbsp;</li>
    							<?php foreach ($monthRate as $key => $val):?>
    							<li class="filter-item filter-choice<?php echo $key==='不限' ? ' active' : ''?>">
    								<input type="checkbox" name="monthRate" value="<?php echo $key; ?>" />
    								<span><?php echo $key; ?></span>
    							</li>
    							<?php endforeach?>
    						</ul>
    					</li>
    					<li>
    						<ul>
    							<li class="filter-item">借款期限</li>
    							<?php foreach ($deadline as $key => $val): ?>
    							<li class="filter-item filter-choice<?php echo $key==='不限' ? ' active' : ''?>">
    								<input type="checkbox" name="deadline" value="<?php echo $key; ?>" />
    								<span><?php echo $key==='不限' ? $key : $key.'个月';; ?></span>
    							</li>
    							<?php endforeach?>
    						</ul>
    					</li>
    					<li>
    						<ul>
    							<li class="filter-item">认证等级</li>
    							<?php foreach ($authenGrade as $key => $val):?>
    							<li class="filter-item filter-choice<?php echo $key==='不限' ? ' active' : ''?>">
    								<input type="checkbox" name="authenGrade" value="<?php echo $key; ?>" />
    								<span><?php echo $key; ?></span>
    							</li>
    							<?php endforeach;?>
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
                <div class="title">最新标段</div>
                <div class="list-head">
                    <span>借款人</span>
                    <span>借款标题</span>
                    <span>年利率</span>
                    <span>信用等级</span>
                    <span>金额</span>
                    <span>期限</span>
                    <span>进度</span>
                </div>
				<?php $this->widget('zii.widgets.CListView',array(
					'dataProvider' => $data,
					'itemView' => '_bidList',
					'template' => '{items}',
					'itemsTagName' => 'ul',
					'emptyText' => '',
					'ajaxUpdate' => false,
					'cssFile' => false,
					'baseScriptUrl' => null,
				)); ?>
                <div id="viewMore">
                <?php $this->renderPartial('//common/pager',array('pager'=>$pager))?>
                </div>
            </div>
    	</div>