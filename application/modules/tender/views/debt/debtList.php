<?php
$this->cs->registerScriptFile($this->scriptUrl.'jquery-1.8.2.min.js',CClientScript::POS_END);
$this->cs->registerCssFile($this->cssUrl.'common.css');
$this->cs->registerCssFile($this->cssUrl.'lend.css');  
?>
        <div class="wd1002">
            <div class="breadcrumb">
                <ul>
                    <li class="breadcrumb-item">
                        <a href="#">我要投资</a>
                    </li>
                    <li class="breadcrumb-separator"> >
                    </li>
                    <li class="breadcrumb-item active">
                        <a href="#">投资中心</a>
                    </li>
                </ul>
            </div>
            <div class="loan creditor">
                <div class="title">投资推荐</div>
                <div class="list-head">
                    <span class="creditor-head-n">转让方名称</span>
                    <span class="creditor-head-t">债权转让标题</span>
                    <span class="creditor-head-d">简要描述</span>
                </div>
                <?php foreach($DebtList as $value){?>
                <ul>
                    <li class="loan-list">
                        <div class="loan-avatar creditor-head-n">
                            <div><?php echo $value->Debt_master;?></div>
                        </div>
                        <div class="loan-title creditor-head-t"><a href="#"><?php echo $value->title;?></a></div>
                        <div class="creditor-desc creditor-head-d">
                            <?php
                                if(strlen($value->description)>84){
                                    $content = preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.'0'.'}'. 
                                       '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.'84'.'}).*#s','$1',$value->description);
                                    echo $content;  
                                }else
                                    echo $value->description; 
                                        
                            ?>
                        </div>
                        <a href="<?php echo Yii::app()->createUrl('tender/debt/debtDetail',array('id'=>$value->id));?>" class="invest">查看</a>
                    </li>
                </ul>
                <?php }?>
                <div id="viewMore">
              
<!--                 <ul id="page">
                    <li><a href="baidu.com" class="page-prev">上一页</a></li>
                    <li><a href="#" class="active">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#" class="page-next">下一页</a></li>
                </ul> -->

                </div>
            </div>
        </div>