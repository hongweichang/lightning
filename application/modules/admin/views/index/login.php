<?php
/**
 * file: login.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-11-28
 * desc: 
 */
?>
    <div class="center_wd1002">
        <div class="login_text">
            <img src="<?php echo $this->imageUrl; ?>login_logo.png" />
            <h1>后台管理系统</h1>
            <p>你可以管理你所有网站的操作流程等一系列的措施，简单易用，
                让您不用担心你的投资。
            </p>
        </div>
        <form class="login" method="post" action="">
            <fieldset>
                <h1>登陆</h1>
                <div class="login_box">
                    <label for="user_account"></label>
                    <input type="text" id="user_account" name="user_account" placeholder="请输入管理员账号" />
                    <label for="user_password"></label>
                    <input type="text" id="user_password" name="user_password" placeholder="请输入密码" />
                    <input type="submit" value="登陆" />
                </div>
            </fieldset>
        </form>
    </div>