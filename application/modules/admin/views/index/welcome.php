<?php
/**
 * @name welcome.php UTF-8
 * @author ChenJunAn<lancelot1215@gmail.com>
 * 
 * Date 2013-10-2
 * Encoding UTF-8
 */
?>
			<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td colspan="2" valign="top">&nbsp;</td>
					<td>&nbsp;</td>
					<td valign="top">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" valign="top">
						<span class="left_bt left_ts">感谢您使用 社区宝管理系统</span><br> <br>
						<span class="left_txt">
							&nbsp;<img src="<?php echo $this->imageUrl;?>ts.gif" width="16" height="16" />说明
						</span>
						<span class="left_txt"><br>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Enjoy! <br>
					</span></td>
					<td width="7%">&nbsp;</td>
					<td width="40%" valign="top"><table width="100%" height="144"
							border="0" cellpadding="0" cellspacing="0" class="line_table">
							<tr>
								<td width="7%" height="27" background="<?php echo $this->imageUrl;?>news-title-bg.gif"><img
									src="<?php echo $this->imageUrl;?>news-title-bg.gif" width="2" height="27"></td>
								<td width="93%" background="<?php echo $this->imageUrl;?>news-title-bg.gif"
									class="left_bt2">最新动态</td>
							</tr>
							<tr>
								<td height="102" valign="top">&nbsp;</td>
								<td height="102" valign="top"><span class="left_txt">暂无 </span></td>
							</tr>
							<tr>
								<td height="5" colspan="2">&nbsp;</td>
							</tr>
						</table></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" valign="top">
						<table class=main_tab id=mainTable cellSpacing=0 cellPadding=0 width=100% border=0>
							<tbody >
								<tr>
									<td vAlign=top align=middle>
										<table width=98% height="133" border=0 align="center" cellPadding=0 cellSpacing=0>
											<tbody>
												<tr>
													<td height="5" colspan="3"></td>
												</tr>
												<tr>
													<td width="4%" height="28"
														background="<?php echo $this->imageUrl;?>news-title-bg.gif"></td>
													<td height="25" colspan="2"
														background="<?php echo $this->imageUrl;?>news-title-bg.gif" class="left_txt">亲爱的 <?php echo $this->user->getName()?>：
														<font color="#FFFFFF" class="left_ts"><b></b>
													
													</td>
												</tr>
												<tr>
													<td bgcolor="#FAFBFC">&nbsp;</td>
													<td width="42%" height="25" bgcolor="#FAFBFC">
														<span class="left_txt">上次登录时间： </span>
														<span class="left_ts"><?php 
															$time = $this->user->getState('last_login_time');
															if ( $time !== null )
																echo date('Y 年 m 月 d 日',$time);
														?></span></td>
													<td width="54%" height="25" bgcolor="#FAFBFC">
														<span class="left_txt">上次登录IP： </span>
														<span class="left_ts"><?php 
															$ip = $this->user->getState('last_login_ip');
															if ( $ip !== null )
																echo $ip;
														?>
														</span></td>
												</tr>
												<tr>
													<td height="5" colspan="3"></td>
												</tr>
											</tbody>
										</table></td>
								</tr>
							</tbody>
						</table>
					</td>
					<td>&nbsp;</td>
					<td valign="top"><table width="100%" height="144" border="0"
							cellpadding="0" cellspacing="0" class="line_table">
							<tr>
								<td width="7%" height="27" background="<?php echo $this->imageUrl;?>news-title-bg.gif"><img
									src="<?php echo $this->imageUrl;?>news-title-bg.gif" width="2" height="27"></td>
								<td width="93%" background="<?php echo $this->imageUrl;?>news-title-bg.gif"
									class="left_bt2">系统功能</td>
							</tr>
							<tr>
								<td height="102" valign="top">&nbsp;</td>
								<td height="102" valign="top"><label></label>
								<textarea disabled="true" name="textarea" cols="68" rows="8" class="left_txt"></textarea>
								</td>
							</tr>
							<tr>
								<td height="5" colspan="2">&nbsp;</td>
							</tr>
						</table></td>
				</tr>
				<tr>
					<td height="40" colspan="4"><table width="100%" height="1"
							border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
							<tr>
								<td></td>
							</tr>
						</table></td>
				</tr>
				
			</table>
		