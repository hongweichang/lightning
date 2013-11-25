<?php $this->cs->registerCssFile($this->cssUrl.'cuskind.css'); ?>
        <div class="wd1002">
            <h1 class="con-nav">闪电贷借款 - 产品介绍</h1>
            <div id="aud-check" class="aud-common">
                <div class="aud-warning">
                    <div class="adu-war-box adu-war-box-first aud-active">
                        <div class="adu-step"><span>1.填写借款申请</span></div>
                        <span class="adu-next"></span>
                        <div class="adu-bar"></div>
                    </div>
                    <div class="adu-war-box">
                        <div class="adu-step"><span>2.填写借款信息</span></div>
                        <span class="adu-next"></span>
                        <div class="adu-bar"></div>
                    </div>
                    <div class="adu-war-box">
                        <div class="adu-step"><span>3.审核</span></div>
                        <span class="adu-next"></span>
                        <div class="adu-bar"></div>
                    </div>
                    <div class="adu-war-box">
                        <div class="adu-step"><span>4.招标</span></div>
                        <span class="adu-next"></span>
                        <div class="adu-bar"></div>
                    </div>
                    <div class="adu-war-box adu-war-box-last">
                        <div class="adu-step"><span>5.提现</span></div>
                        <div class="adu-bar"></div>
                        <div class="adu-bar adu-bar-last"></div>
                    </div>
                </div>
            </div>
            <div class="con-hint">您已经选择"<?php echo $role; ?>"类型,请点击下一步</div>
            <div class="con-cuskind">
                <div class="cuskind cuskind-color-0">
                    <p>工薪族</p>
                    <img src="<?php echo $this->imageUrl;?>kind.png" />
                </div>
                <h2>适用工薪阶层</h2>
                <span>申请条件</span>
                <ul>
                    <li><span class="kind_list">22-55周岁的中国公民</span></li>
                    <li><span class="kind_list">在现单位工作满3个月</span></li>
                    <li><span class="kind_list">月收入2000以上</span></li>
                </ul>
                <a href="#">查看详细信息</a>
            </div>
            <div class="con-cuskind">
                <div class="cuskind cuskind-color-1">
                    <p>企业主</p>
                    <img src="<?php echo $this->imageUrl;?>kind.png" />
                </div>
                <h2>适用私营企业主</h2>
                <span>申请条件</span>
                <ul>
                    <li><span class="kind_list">22-55周岁的中国公民</span></li>
                    <li><span class="kind_list">企业经营时间满1年</span></li>
                </ul>
                <a href="#">查看详细信息</a>
            </div>
            <div class="con-cuskind">
                <div class="cuskind cuskind-color-2">
                    <p>网店主</p>
                    <img src="<?php echo $this->imageUrl;?>kind.png" />
                </div>
                <h2>适用电子网店商户</h2>
                <span>申请条件</span>
                <ul>
                    <li><span class="kind_list">22-55周岁的中国公民</span></li>
                    <li><span class="kind_list">在淘宝或天猫平台经营网店半年以上</span></li>
                    <li><span class="kind_list">近3个月交易总额满3万元，并且交易笔数超过50笔</span></li>
                </ul>
                <a href="#">查看详细信息</a>
            </div>
            <div class="next">
                <a href="<?php echo $this->createUrl("borrow/writeBorrowInfo"); ?>" class="borrow-button" id="borrow-next">下一步</a>
            </div>
        </div>