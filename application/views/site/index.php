<?php
/**
 * @name index.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-1 
 * Encoding UTF-8
 */
$bannerFiles = json_decode($banner->file_names,true);
$bannerAddTime = $banner->add_time;
$bidProgressCssClassMap = $this->app['bidProgressCssClassMap'];
?>
	<div id="banner">
        <ul>
        <?php foreach ( $bannerFiles as $file ):?>
            <li style="background:url('<?php echo $this->app->getPartedUrl('siteBanner',$bannerAddTime).$file['filename']?>') 50% 50% no-repeat">
                <a href="javascript:void(0);"></a>
            </li>
       <?php endforeach;?>
       </ul>
    </div>
    <div class="wd1002">
        <div class="intro clearfix">
            <a href="#">
                <span class="intro-pic intro-pic-1"></span>
                <span class="intro-title">安全保障</span>
                <span class="intro-text">拥有金融精英团队，对客户资格严格审核、有效监控、跟踪服务，以确保资金安全；拥有网络专业团队，对您的信息加密保护，通过第三方支付平台交易，确保您账户安全。</span>
            </a>
            <a href="#">
                <span class="intro-pic intro-pic-2"></span>
                <span class="intro-title">快速成交</span>
                <span class="intro-text">申请、交易过程步骤少、操作简单；专业团队对信息进行及时反应、快速处理，使您享受犹如闪电般的投融资服务。</span>
            </a>
            <a href="#">
                <span class="intro-pic intro-pic-3"></span>
                <span class="intro-title">诚信服务</span>
                <span class="intro-text">平台交易内容及过程真实可信；本着长期经营，诚信为本的宗旨，为您提供真实、透明的真诚服务。</span>
            </a>
        </div>
            <div class="news clearfix">
                <div class="title">
                <h1>最新公告</h1>
                <a href="<?php echo $this->createUrl('/content/article')?>">更多</a>
                </div>
                <ul>
                <?php 
           	    $today = mktime(0,0,0);     
                foreach ( $articles as $article ):
                $addTime = $article->add_time;
                $content = $article->content;;  
           ?>
                    <li>
                        <p class="news-time"><?php echo date('Y-m-d',$addTime)?></p>
                        <p class="news-liststyle"></p>
                        <div class="news-list">
                            <a href="<?php echo $this->createUrl('content/article/view',array('id'=>$article->id))?>">
                   	    <?php echo $article->title?>        
                            </a>
                            <!-- <div class="subText text-overflow"><?php echo $content?></div> -->
                            <?php if ( $addTime >= $today ):?>
                            <div class="news-tips"></div>
                            <?php endif;?>
                        </div>
                    </li>
               <?php endforeach;?>
                </ul>
            </div>
            <div class="loan">
                <div class="title">最新投资</div>
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
                <?php foreach ( $bids as $bid ):
                $progressClass = '';
                foreach ( $bidProgressCssClassMap as $key => $bidProgressCssClass ){
					if ( $bid['progress'] <= $key ){
							$progressClass = $bidProgressCssClass;
					}
			}
           ?>
                    <li class="loan-list">
                        <div class="loan-avatar">
                            <img src="<?php echo $bid['userIcon']?>" />
                            <span>信</span>
                        </div>
                        <div class="loan-title">
                        	<a href="<?php echo $this->createUrl('tender/purchase/info',array('id'=>$bid['id']))?>" target="_blank">
                        	<?php echo $bid['title']?>
                        	</a>
                        </div>
                        <div class="loan-rate loan-num"><?php echo $bid['monthRate']?></div>
                        <div class="loan-rank"><div class="rank<?php echo $bid['rank']?>"><?php echo $bid['rank']?></div></div>
                        <div class="loan-amount loan-num"><?php echo $bid['sum']?></div>
                        <div class="loan-time loan-num"><?php echo $bid['deadline']?></div>
                        <div class="loan-progress">
                            <div class="bar-out">
                                <div class="bar-in">
                                    <span class="bar-complete <?php echo $progressClass?>" style="width:<?php echo $bid['progress']?>%"></span>
                                    <span class="bar-num"><?php echo $bid['progress']?>%</span>
                                </div>
                            </div>
                        </div>
                    <a href="<?php echo $this->createUrl('tender/purchase/info',array('id'=>$bid['id']))?>" target="_blank" class="invest">投标</a>
                </li>
            <?php endforeach;?>
            </ul>
        </div>
        <div class="platform">
            <div class="title">传播平台</div>
            <a href="#"><img src="<?php echo $this->imageUrl;?>android.png" id="android" /></a>
            <a href="#"><img src="<?php echo $this->imageUrl;?>ios.png" id="ios"/></a>
            <a href="#"><img src="<?php echo $this->imageUrl;?>wx.png" id="wx"/></a>
        </div>
    <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=574891711&site=qq&menu=yes" class="online_service" title="点击给我发送消息"></a>
