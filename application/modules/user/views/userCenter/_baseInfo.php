<?php
/**
 * @name _baseInfo.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-19 
 * Encoding UTF-8
 */
$userData = $this->userData;
?>
<div class="aud-detail">
                <div class="det-per-inf">
                    <img src="<?php echo $this->user->getState('avatar')?>" class="det-img" />
                    <p>
                        <span class="aud-time">晚上好，</span>
                        <span class="aud-det-name"><?php echo Yii::app()->user->name;?> </span>
                    </p>
                    <p class="aud-st-serve">
                        <img src="<?php echo $this->imageUrl.'det-person.png'?>" />
                        <img src="<?php echo $this->imageUrl.'det-pro.png'?>" />
                        <img src="<?php echo $this->imageUrl.'det-email.png'?>" />
                        <img src="<?php echo $this->imageUrl.'det-cal.png'?>" />
                        <img src="<?php echo $this->imageUrl.'det-bank.png'?>" />
                        <span>安全等级 :  <span class="det-rank">高</span></span>
                        <span>上次登录 :  <span class="det-ip"> <?php echo $this->request->getIpLocation($userData->last_login_ip).' '.date('Y-m-d H:i:s',$userData['last_login_time'])?></span></span>
                    </p>
                </div>
                <div class="aud-money">
                    <div class="mon-show">
                        <p>
                            <span>账户余额</span>
                            <span>我的投资</span>
                            <span>我的借贷</span>
                        </p>
                        <p class="det-mon">
                            <span>
                            <?php
                            $balance = $userData['balance']/100;
                            if($balance >= 100000){
                                $highBalance = $balance/10000;
                                echo $highBalance."万元";
                            }else 
                                echo $balance."元";
                            ?>
                            </span>
                            <span>=</span>
                            <span>0.00</span>
                            <span>+</span>
                            <span class="mon-out">-0.00</span>
                        </p>
                        <div>
                            <a href="#" id="int">充值</a>
                            <a href="#" id="out">提现</a>
                        </div>
                    </div>
                </div>
            </div>
