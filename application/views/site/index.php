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
    <div id="container">
        <div class="wd1002">
            <div class="intro clearfix">
                <a href="#">
                    <span class="intro-pic intro-pic-1"></span>
                    <span class="intro-title">安全保障</span>
                    <span class="intro-text">成为理财人，通过主动投标或加入优选理财计划将资金进行出借投资，可获得预期1214%的稳定年化收益。我们会教会你所有网站的操作流程等一系列的措施。</span>
                </a>
                <a href="#">
                    <span class="intro-pic intro-pic-2"></span>
                    <span class="intro-title">快速成交</span>
                    <span class="intro-text">优化系统结构，控制访问路径，将非法访问禁止在外。系统文件比对，防止伪装木马。高强度加密方式防破解，每套程序都有自已唯一的key，保障数据安全</span>
                </a>
                <a href="#">
                    <span class="intro-pic intro-pic-3"></span>
                    <span class="intro-title">诚信服务</span>
                    <span class="intro-text">我手上有闲钱，想要拿出来理财，我要借出的具体细节。我急需要用钱，想要借款，我要借入的的具体细节。管理我的的账户，近期参与活动，账户安全管理，收益及余额查询等。</span>
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
        </div>
    </div>
