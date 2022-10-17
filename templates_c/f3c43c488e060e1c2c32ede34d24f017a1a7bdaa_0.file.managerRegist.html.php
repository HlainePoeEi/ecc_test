<?php
/* Smarty version 3.1.29, created on 2022-06-10 12:04:51
  from "/var/www/html/eccadmin_dev/templates/managerRegist.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_62a2b4d305f133_10437870',
  'file_dependency' => 
  array (
    'f3c43c488e060e1c2c32ede34d24f017a1a7bdaa' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/managerRegist.html',
      1 => 1574654729,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:leftMenu.html' => 1,
    'file:header.html' => 1,
    'file:footer.html' => 2,
  ),
),false)) {
function content_62a2b4d305f133_10437870 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
	<title>組織管理者登録</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta name="robots" content="noindex, nofollow">
	<meta name="googlebot" content="noindex, nofollow">
	 
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('HOME_DIR');?>
js/jquery.min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('HOME_DIR');?>
js/jquery-ui.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('HOME_DIR');?>
js/common.js"><?php echo '</script'; ?>
>
	
	<link href="<?php echo @constant('HOME_DIR');?>
css/jquery-ui.css" rel="stylesheet">
	<link href="<?php echo @constant('HOME_DIR');?>
css/default.css" rel="stylesheet">
		<?php echo '<script'; ?>
 type="text/javascript">
		// エンターキー押下時のsubmitを無効化
		$(document).on("keypress", "input:not(.allow_submit)", function(event) {
			return event.which !== 13;
		});
		// エンターキー押下時のsubmitを無効化
		$(document).on("keypress", "select:not(.allow_submit)", function(event) {
			return event.which !== 13;
		});
		$(document).ready(function() {
			$(function() {
				$('#start_period').datepicker({
					showOn : "button",
					buttonImage : "<?php echo @constant('HOME_DIR');?>
image/calendar.svg",
					dateFormat: 'yy/mm/dd',
					buttonImageOnly : true,
					beforeShow: function (input, inst) {
						setTimeout(function () {
							var leftWidth=($('.pushmenu-open').length>0)?$('#start_period').offset().left-$('.pushmenu-open')[0].offsetWidth
	                                :$('#start_period').offset().left;
							inst.dpDiv.css({
								left: leftWidth
							});
						}, 0);
					}
				});
			});

			$(function() {
				$('#end_period').datepicker({
					showOn : "button",
					buttonImage : "<?php echo @constant('HOME_DIR');?>
image/calendar.svg",
					dateFormat: 'yy/mm/dd',
					buttonImageOnly : true,
					beforeShow: function (input, inst) {
						setTimeout(function () {
							var leftWidth=($('.pushmenu-open').length>0)?$('#end_period').offset().left-$('.pushmenu-open')[0].offsetWidth
									:$('#end_period').offset().left;
							inst.dpDiv.css({
								left: leftWidth
							});
						}, 0);
					}
				});
			});
			// MSGのあるなし
			if ( $(".error_msg").html() != "" ){

				$(".error_section").slideToggle('slow');
			}
			$(".close_icon").on('click', function() {

				$(".error_section").slideToggle('slow');
				$('#err_dis').slideToggle('slow');
			});

			/**
			*
			*  登録ボタン押下、必須チェック処理
			*
			**/
			$(".btn_insert").on('click', function() {

				$(".error_section").hide();
				$('#err_dis').hide();

				var manager_name = document.getElementById('manager_name').value;
				var manager_name_kana = document.getElementById('manager_name_kana').value;
				var login_id = document.getElementById('login_id').value;
				var password = document.getElementById('password').value;
				var confirm_password = document.getElementById('confirm_password').value;
				var start_period = document.getElementById('start_period').value;
				var end_period = document.getElementById('end_period').value;
				var screen_mode = document.getElementById('screen_mode').value;

				// 管理者名の必須チェック
				if ( manager_name == "" ){

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("管理者名を入力してください。");
					$(".divBody").scrollTop(0);
					return false;
				}

				// 管理者名の文字数チェック
				if ( manager_name.length > 32 ){

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("管理者名は32字で入力してください。");
					$(".divBody").scrollTop(0);
					return false;
				}

				// 管理者名ふりがなの文字数チェック
				if ( manager_name_kana.length > 32 ){

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("読みは32字で入力してください。");
					$(".divBody").scrollTop(0);
					return false;
				}

				// ログインIDの必須チェック
				if ( login_id == "" ){

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("ログインIDを入力してください。");
					$(".divBody").scrollTop(0);
					return false;
				}

				// ログインIDのの文字数チェック
				if ( login_id.length > 20 ){

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("ログインIDは20字で入力してください。");
					$(".divBody").scrollTop(0);
					return false;
				}

				if ( login_id.match(/[^0-9a-zA-Z]/) ) {

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html('ログインIDに半角英数字以外の文字が含まれています。');
					$(".divBody").scrollTop(0);
					return false;
				}

				//パスワードの最小長
                var min_passwordLength = document.getElementById('min_passwordLength').value;
                //パスワードの最高長
                var max_passwordLength = document.getElementById('max_passwordLength').value;

                if ( screen_mode === '1' ){
                    // パスワードの必須チェック
                    if ( password == "" ){

                        $('#err_dis').show();
                        $(".error_section").slideToggle('slow');
                        $(".error_msg").html("パスワードを入力してください。");
                        $(".divBody").scrollTop(0);
                        return false;
                    }

                    // パスワード（確認）の必須チェック
                    if ( confirm_password == "" ){

                        $('#err_dis').show();
                        $(".error_section").slideToggle('slow');
                        $(".error_msg").html("パスワード（確認）を入力してください。");
                        $(".divBody").scrollTop(0);
                        return false;
                    }

                    if ( !password.match(/^(?! )[A-Za-z0-9-_]+(?<! )$/) ){

                        $('#err_dis').show();
                        $(".error_section").slideToggle('slow');
                        $(".error_msg").html('パスワードに半角英数字以外の文字が含まれています。');
                        $(".divBody").scrollTop(0);
                        return false;
                    }

                    if ( !confirm_password.match(/^(?! )[A-Za-z0-9-_]+(?<! )$/) ){

                        $('#err_dis').show();
                        $(".error_section").slideToggle('slow');
                        $(".error_msg").html('パスワード（確認）に半角英数字以外の文字が含まれています。');
                        $(".divBody").scrollTop(0);
                        return false;
                    }

                    // パスワードの長さ最低のチェック
                    if ( password.length < min_passwordLength ){

                        $('#err_dis').show();
                        $(".error_section").slideToggle('slow');
                        $(".error_msg").html("パスワードは最低"+min_passwordLength+"字で入力してください。");
                        $(".divBody").scrollTop(0);
                        return false;
                    }

                    // パスワード（確認）の文字数チェック
                    if ( confirm_password.length < min_passwordLength ){

                        $('#err_dis').show();
                        $(".error_section").slideToggle('slow');
                        $(".error_msg").html("パスワードは最低"+min_passwordLength+"字で入力してください。");
                        $(".divBody").scrollTop(0);
                        return false;
                    }

                    // パスワードの文字数チェック
                    if ( password.length > max_passwordLength ){

                        $('#err_dis').show();
                        $(".error_section").slideToggle('slow');
                        $(".error_msg").html("パスワードは最高"+max_passwordLength+"字で入力してください。");
                        $(".divBody").scrollTop(0);
                        return false;
                    }

                    // パスワード（確認）の文字数チェック
                    if ( confirm_password.length > max_passwordLength ){

                        $('#err_dis').show();
                        $(".error_section").slideToggle('slow');
                        $(".error_msg").html("パスワード（確認）は最高"+max_passwordLength+"字で入力してください。");
                        $(".divBody").scrollTop(0);
                        return false;
                    }
                }
                else if (screen_mode==='2'){

                     if ( password!="" || confirm_password!=""){

                    	// パスワードの必須チェック
                         if ( password == "" ){

                             $('#err_dis').show();
                             $(".error_section").slideToggle('slow');
                             $(".error_msg").html("パスワードを入力してください。");
                             $(".divBody").scrollTop(0);
                             return false;
                         }

                         // パスワード（確認）の必須チェック
                         if ( confirm_password == "" ){

                             $('#err_dis').show();
                             $(".error_section").slideToggle('slow');
                             $(".error_msg").html("パスワード（確認）を入力してください。");
                             $(".divBody").scrollTop(0);
                             return false;
                         }

                         if ( !password.match(/^(?! )[A-Za-z0-9-_]+(?<! )$/) ){

                             $('#err_dis').show();
                             $(".error_section").slideToggle('slow');
                             $(".error_msg").html('パスワードに半角英数字以外の文字が含まれています。');
                             $(".divBody").scrollTop(0);
                             return false;
                         }

                         if ( !confirm_password.match(/^(?! )[A-Za-z0-9-_]+(?<! )$/) ){

                             $('#err_dis').show();
                             $(".error_section").slideToggle('slow');
                             $(".error_msg").html('パスワード（確認）に半角英数字以外の文字が含まれています。');
                             $(".divBody").scrollTop(0);
                             return false;
                         }

                        // パスワードの長さ最低のチェック
                         if ( password.length < min_passwordLength ){

                             $('#err_dis').show();
                             $(".error_section").slideToggle('slow');
                             $(".error_msg").html("パスワードは最低"+min_passwordLength+"字で入力してください。");
                             $(".divBody").scrollTop(0);
                             return false;
                         }

                         // パスワード（確認）の文字数チェック
                         if ( confirm_password.length < min_passwordLength ){

                             $('#err_dis').show();
                             $(".error_section").slideToggle('slow');
                             $(".error_msg").html("パスワード（確認）は最低"+min_passwordLength+"字で入力してください。");
                             $(".divBody").scrollTop(0);
                             return false;
                         }

                         // パスワードの文字数チェック
                         if ( password.length > max_passwordLength ){

                             $('#err_dis').show();
                             $(".error_section").slideToggle('slow');
                             $(".error_msg").html("パスワードは最高"+max_passwordLength+"字で入力してください。");
                             $(".divBody").scrollTop(0);
                             return false;
                         }

                         // パスワード（確認）の文字数チェック
                         if ( confirm_password.length > max_passwordLength ){

                             $('#err_dis').show();
                             $(".error_section").slideToggle('slow');
                             $(".error_msg").html("パスワード（確認）は最高"+max_passwordLength+"字で入力してください。");
                             $(".divBody").scrollTop(0);
                             return false;
                         }
                     }
                }

				// 利用開始の必須チェック
				if ( start_period == "" ){

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("利用開始を入力してください。");
					$(".divBody").scrollTop(0);
					return false;
				}

				// 利用終了の必須チェック
				if ( end_period == "" ){

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("利用終了を入力してください。");
					$(".divBody").scrollTop(0);
					return false;
				}

				// パスワードとパスワード（確認）をチェックする
                if ( password != confirm_password ){

                    $('#err_dis').show();
                    $(".error_section").slideToggle('slow');
                    $(".error_msg").html("<?php echo @constant('E024');?>
");
                    $(".divBody").scrollTop(0);
                    return false;
                }

				if ( start_period > end_period ){

				 	$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("<?php echo @constant('W004');?>
");
					$(".divBody").scrollTop(0);
					return false;
				}

				if ( Date.parse(end_period) < Date.parse(todayDate) ){

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("利用終了日は今日までで過去の日付は登録できません。");
					$(".divBody").scrollTop(0);
					return false;
				}

				return true;
			});
			//戻るボタン処理
			function doBack(action) {

				$("#main_form").attr("action", action);
				$("#main_form").submit();
			}
		});
		<?php echo '</script'; ?>
>
	</head>
	<body class="pushmenu-push">
		<form id="main_form" action="<?php echo @constant('HOME_DIR');?>
ManagerRegist/save" method="post">
			<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:leftMenu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<div class="divHeader">
				<!--header-->
					<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

				<!--header-->
			</div>
			<div class="divBody">
			        <input type="hidden" id ="min_passwordLength" name="min_passwordLength" value="<?php echo @constant('MIN_PASSWORDLENGTH');?>
" >
                    <input type="hidden" id ="max_passwordLength" name="max_passwordLength" value="<?php echo @constant('MAX_PASSWORDLENGTH');?>
" >

					<input type="hidden" id="manager_no" name="manager_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->manager_no;?>
">
					<input type="hidden" id="screen_value" name="screen_value" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->screen_value;?>
" />
					<input type="hidden" id="organization_no" name="organization_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->organization_no;?>
">
					<input type="hidden" id="organization_id" name="organization_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->organization_id;?>
">
					<input type="hidden" id="organization_name" name="organization_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->organization_name, ENT_QUOTES, 'UTF-8', true);?>
">
					<input type="hidden" id="organization_name_kana" name="organization_name_kana" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->organization_name_kana, ENT_QUOTES, 'UTF-8', true);?>
"/>
					<input type="hidden" id="organization_official" name="organization_official" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->organization_official, ENT_QUOTES, 'UTF-8', true);?>
"/>
					<input type="hidden" id="organization_kbn" name="organization_kbn" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->organization_kbn;?>
"/>
					<input type="hidden" id="organization_type" name="organization_type" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->organization_type;?>
"/>
					<input type="hidden" id="org_function_type" name="org_function_type" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_function_type;?>
"/>
					<input type="hidden" id="organization_start_date" name="organization_start_date" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->organization_start_date;?>
"/>
					<input type="hidden" id="org_start_period" name="org_start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_start_period;?>
"/>
					<input type="hidden" id="org_end_period" name="org_end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_end_period;?>
"/>
					<input type="hidden" id="contract_start_date" name="contract_start_date" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->contract_start_date;?>
"/>
					<input type="hidden" id="contract_end_date" name="contract_end_date" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->contract_end_date;?>
"/>
					<input type="hidden" id="organization_admin" name="organization_admin" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->organization_admin;?>
"/>
					<input type="hidden" id="org_phone_no" name="org_phone_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_phone_no;?>
"/>
					<input type="hidden" id="organization_mail" name="organization_mail" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->organization_mail;?>
"/>
					<input type="hidden" id="org_contract_no" name="org_contract_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_contract_no;?>
"/>
					<input type="hidden" id="org_manager_nm" name="org_manager_nm" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_manager_nm;?>
"/>
					<input type="hidden" id="org_remarks" name="org_remarks" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->org_remarks, ENT_QUOTES, 'UTF-8', true);?>
"/>
					<input type="hidden" id="btn_flag" name="btn_flag" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->btn_flag;?>
"/>
					<input type="hidden" id="original_password" name="original_password" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->original_password;?>
"/>
					<input type="hidden" id="original_login_id" name="original_login_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->original_login_id;?>
">
					<input type="hidden" id="screen_mode" name="screen_mode" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->screen_mode;?>
">
					<input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
"/>
					<input type="hidden" id="search_start_period" name="search_start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_start_period;?>
"/>
					<input type="hidden" id="search_end_period" name="search_end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_end_period;?>
"/>
					<input type="hidden" id="search_org_name" name="search_org_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->search_org_name, ENT_QUOTES, 'UTF-8', true);?>
"/>
					<input type="hidden" id="search_chk_status" name="search_chk_status" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_chk_status;?>
"/>
					<input type="hidden" id="search_chk_status1" name="search_chk_status1" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_chk_status1;?>
"/>
					<input type="hidden" id="search_chk_status2" name="search_chk_status2" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_chk_status2;?>
"/>
					<input type="hidden" id="search_chk_status3" name="search_chk_status3" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_chk_status3;?>
"/>
					<div id="err_dis">
						<section class="error_section" id = "err">
							<img src="<?php echo @constant('HOME_DIR');?>
image/close_icon.png" id="err_img" style="width:15px;float:right" class="close_icon">
							  <?php if (!empty($_smarty_tpl->tpl_vars['error']->value)) {?>
								  <div class="error_msg" id = "error_msg"><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</div>
							  <?php } else { ?>
								  <div class="error_msg" id = "error_msg"></div>
							  <?php }?>
						</section>
					</div>
					<section class="content">
						<p>
							&gt;<span class="title">組織登録 / 組織管理者登録</span>
						</p>
						<p style="text-align:right;width:100%;">
							<input type="button" title="戻る" value="" class="btn_back" onclick="javascript:doBack('<?php echo @constant('HOME_DIR');?>
ManagerRegist/back')">
						</p>
						<table style="width: 50%; margin-top: -30px;">
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td><label><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->org_name, ENT_QUOTES, 'UTF-8', true);?>
</label></td>
							</tr>
							<tr>
								<td>組織ID</td>
								<td><label><?php echo $_smarty_tpl->tpl_vars['form']->value->org_id;?>
</label></td>
								<td>組織名</td>
								<td><label><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->org_name_kana, ENT_QUOTES, 'UTF-8', true);?>
</label></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td><label><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->org_name_official, ENT_QUOTES, 'UTF-8', true);?>
</label></td>
							</tr>
						</table>
						<br>
						<table style="margin-top:30px; margin-left:150px;">
							<tr>
								<td id="tb_width" style="width:240px;">管理者名<span class="required">※</span></td>
								<td colspan="3"><input type="text" class="text" id="manager_name" name="manager_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->manager_name, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "32" size = "30"></td>
							</tr>
							<tr>
								<td>ふりがな</td>
								<td colspan="3"><input type="text" class="text" id="manager_name_kana" name="manager_name_kana" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->manager_name_kana, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "32" size = "30"></td>
							</tr>
							<tr>
								<td id="td_login_id">ログインID<span class="required">※</span></td>
								<td colspan="3" id="td_login_width"><input type="text" class="text" id="login_id" name="login_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->login_id;?>
" maxlength = "20" size = "30"></td>
							</tr>
							<tr>
								<td>パスワード<span class="required">※</span></td>
								<td colspan="3"><input type="password" class="text" id="password" name="password" value="" maxlength = "20" size = "30" autocomplete="new-password"></td>
							</tr>
							<tr>
								<td>パスワード（確認）<span class="required">※</span></td>
								<td colspan="3"><input type="password" class="text" id="confirm_password" name="confirm_password" value="" maxlength = "20" size = "30"></td>
							</tr>
							<tr>
								<td>利用開始<span class="required">※</span></td>
								<td colspan="3"><input type="text" id="start_period" name="start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->start_period;?>
" maxlength="10" onchange="changeDateFormat(this)"></td>
							</tr>
							<tr>
								<td>利用終了<span class="required">※</span></td>
								<td colspan="3"><input type="text" id="end_period" name="end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->end_period;?>
" maxlength="10" onchange="changeDateFormat(this)"></td>
							</tr>
							<tr>
								<td>備考</td>
								<td colspan="3"><input type="text" class="text" id="remarks" name="remarks" maxlength = "512" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->remarks, ENT_QUOTES, 'UTF-8', true);?>
" size = "30"></td>
							</tr>
						</table>
						<div style="width:100%;text-align:right">
							<input type="submit" title="登録" name="insert" value="" id="btn_insert" class="btn_insert">
						</div>
					</section><!-- End Content -->
			</div><!-- End divBody -->
			<div class="divFooter">
				<!--footer-->
					<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

				<!--footer-->
			</div>
		</form>
		<!--footer-->
		<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

		<!--footer-->
	</body>
</html>
<?php }
}
