<?php
/**
 * @name list.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-26 
 * Encoding UTF-8
 */
$this->cs->registerCssFile($this->cssUrl.'help.css');
?>

<div class="wd1002">
		<div class="breadcrumb">
    			<ul>
    				<li class="breadcrumb-item">
    					<a href="<?php echo $this->createUrl('/site'); ?>">首页</a> > 
    				</li>
    				<li class="breadcrumb-item">
    					公告列表
    				</li>
    			</ul>
    		</div>
	</div>

<div class="wd1002 hc clearfix">
	<div class="news clearfix">
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
                            <div class="subText text-overflow"><?php echo $content?></div>
                            <?php if ( $addTime >= $today ):?>
                            <div class="news-tips"></div>
                            <?php endif;?>
                        </div>
                    </li>
               <?php endforeach;?>
                </ul>
            </div>
</div>