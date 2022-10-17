<?php
/* Smarty version 3.1.29, created on 2022-03-09 10:46:32
  from "/var/www/html/eccadmin_dev/templates/adminRegist.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_622806f8515a74_14689333',
  'file_dependency' => 
  array (
    '64fae343214694c1b2e32692eb394686d207421b' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/adminRegist.html',
      1 => 1574654082,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:leftMenu.html' => 1,
    'file:header.html' => 1,
    'file:footer.html' => 1,
  ),
),false)) {
function content_622806f8515a74_14689333 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
	<head>
	<title>管理者登録</title>
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
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('HOME_DIR');?>
js/moment.js"><?php echo '</script'; ?>
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

			//表示再現
			$(document).ready(function() {

				var date = new Date();
				var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();

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
									top: $('#start_period').offset().top + 35,
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
									top: $('#end_period').offset().top + 35,
									left: leftWidth
								});
							}, 0);
						}
					});
				});

				// MSGのあるなし
				if ( $(".error_msg").html() != "" ) {

					$(".error_section").slideToggle('slow');
				}
				$(".close_icon").on('click',function(){

					$(".error_section").slideToggle('slow');

 					$('#err_dis').slideToggle('slow');

				});

				//戻るボタン
				function doBack(action){

					var menuOpen = document.getElementById('menuOpen').value;
					var menuStatus = document.getElementById('menuStatus').value;
					$("#main_form").attr("action", action);
					$("#menuOpen").val(menuOpen);
					$("#menuStatus").val(menuStatus);
					$("#back_flg").val(true);
					$("#main_form").submit();
				}

				/**
				 *
				 *  登録ボタン押下、必須チェック処理
				 *
				 **/
				  $(".btn_insert").on('click',function(){

					$(".error_section").hide();
					$('#err_dis').hide();

					var admin_name = document.getElementById('admin_name').value;
					var romaji_name = document.getElementById('romaji_name').value;
					var end_period = document.getElementById('end_period').value;
					var login_id = document.getElementById('login_id').value;
					var password = document.getElementById('password').value;
					var confirm_password = document.getElementById('confirm_password').value;
					var start_period = document.getElementById('start_period').value;
					var mail_address = document.getElementById('mail_address').value;

					var admin_kbn = $('#selAdminKbn').val();
					$("#txt_admin_kbn").val(admin_kbn);
					var btn_value = document.getElementById('btn_value').value;

					//パスワードの最小長
	                var min_passwordLength = document.getElementById('min_passwordLength').value;
	                //パスワードの最高長
	                var max_passwordLength = document.getElementById('max_passwordLength').value;

					// 運用管理者名の必須チェック
					if ( admin_name == "" ) {

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("運用管理者名を入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					// 運用管理者名の文字数チェック
					if ( admin_name.length > 32 ) {

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("運用管理者名は32字で入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}
					
					// 読みの文字数チェック
					if ( romaji_name.trim() == ""　) {

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("読みを入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					// 読みの文字数チェック
					if ( romaji_name.length > 32　) {

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("読みは32字以内で入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					// ログインIDの必須チェック
					if ( login_id == "" ) {

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("ログインIDを入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					// ログインIDのの文字数チェック
					if ( login_id.length > 20 ) {

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

					if ( btn_value === '2' ) {

						// パスワードの必須チェック
						if ( password == "" ) {

							$('#err_dis').show();
							$(".error_section").slideToggle('slow');
							$(".error_msg").html("パスワードを入力してください。");
							$(".divBody").scrollTop(0);
							return false;
						}

						// パスワード（確認）の必須チェック
                        if ( confirm_password == "" ) {

                            $('#err_dis').show();
                            $(".error_section").slideToggle('slow');
                            $(".error_msg").html("パスワード（確認）を入力してください。");
                            $(".divBody").scrollTop(0);
                            return false;
                        }

                     // 利用開始の必須チェック
                        if ( start_period == "" ) {

                            $('#err_dis').show();
                            $(".error_section").slideToggle('slow');
                            $(".error_msg").html("利用開始を入力してください。");
                            $(".divBody").scrollTop(0);
                            return false;
                        }

                        // 利用終了の必須チェック
                        if ( end_period == "" ) {

                            $('#err_dis').show();
                            $(".error_section").slideToggle('slow');
                            $(".error_msg").html("利用終了を入力してください。");
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

						// パスワードの文字数チェック
						if ( password.length < min_passwordLength ){

	                        $('#err_dis').show();
	                        $(".error_section").slideToggle('slow');
	                        $(".error_msg").html("パスワードは最低"+min_passwordLength+"字で入力してください。");
	                        $(".divBody").scrollTop(0);
	                        return false;
	                    }

						if ( password.length > max_passwordLength ) {

							$('#err_dis').show();
							$(".error_section").slideToggle('slow');
							$(".error_msg").html("パスワードは最大"+max_passwordLength+"字で入力してください。");
							$(".divBody").scrollTop(0);
							return false;
						}

						// パスワード（確認）の文字数チェック
						if ( confirm_password.length < min_passwordLength ){

                            $('#err_dis').show();
                            $(".error_section").slideToggle('slow');
                            $(".error_msg").html("パスワード（確認）は最大"+min_passwordLength+"字で入力してください。");
                            $(".divBody").scrollTop(0);
                            return false;
                        }

						if ( confirm_password.length > max_passwordLength ) {

							$('#err_dis').show();
							$(".error_section").slideToggle('slow');
							$(".error_msg").html("パスワード（確認）は最高"+max_passwordLength+"字で入力してください。");
							$(".divBody").scrollTop(0);
							return false;
						}
					}
					else if ( btn_value == '1' ) {

						if ( password!="" || confirm_password!=""){

                            // パスワードの必須チェック
                            if ( password == "" ) {

                                $('#err_dis').show();
                                $(".error_section").slideToggle('slow');
                                $(".error_msg").html("パスワードを入力してください。");
                                $(".divBody").scrollTop(0);
                                return false;
                            }

                            // パスワード（確認）の必須チェック
                            if ( confirm_password == "" ) {

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

                             // パスワードの文字数チェック
                             if ( password.length < min_passwordLength ){

                                 $('#err_dis').show();
                                 $(".error_section").slideToggle('slow');
                                 $(".error_msg").html("パスワードは最低"+min_passwordLength+"字で入力してください。");
                                 $(".divBody").scrollTop(0);
                                 return false;
                             }

                             if ( password.length > max_passwordLength ){

                                 $('#err_dis').show();
                                 $(".error_section").slideToggle('slow');
                                 $(".error_msg").html("パスワードは最高"+max_passwordLength+"字で入力してください。");
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

                             if ( confirm_password.length > max_passwordLength ){

                                 $('#err_dis').show();
                                 $(".error_section").slideToggle('slow');
                                 $(".error_msg").html("パスワード（確認）は最高"+max_passwordLength+"字で入力してください。");
                                 $(".divBody").scrollTop(0);
                                 return false;
                             }
                         }

                        var d = new Date();
                        var todayDate = d.getFullYear() + "/" + (d.getMonth()+1) + "/" + d.getDate();
                        if ( Date.parse(start_period) < Date.parse(todayDate) && date_flg == 0 ) {

                            $('#err_dis').show();
                            $(".error_section").slideToggle('slow');
                            $(".error_msg").html("利用開始日は今日までで過去の日付は登録できません。");
                            $(".divBody").scrollTop(0);
                            return false;
                        }

                        if ( Date.parse(end_period) < Date.parse(todayDate) ) {

                            $('#err_dis').show();
                            $(".error_section").slideToggle('slow');
                            $(".error_msg").html("利用終了日は今日までで過去の日付は登録できません。");
                            $(".divBody").scrollTop(0);
                            return false;
                        }
                    }

					 // パスワードとパスワード（確認）をチェックする
                    if ( password != confirm_password ) {

                        $('#err_dis').show();
                        $(".error_section").slideToggle('slow');
                        $(".error_msg").html("<?php echo @constant('E024');?>
");
                        $(".divBody").scrollTop(0);
                        return false;
                    }

					if ( start_period > end_period ) {

					 $('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("<?php echo @constant('W004');?>
");
						$(".divBody").scrollTop(0);
						return false;
					}

					var isDisabled = $("#start_period").prop('disabled');
					var today_date = moment().format('Y/MM/DD');

					if ( isDisabled == false ){

						if ( start_period < today_date ){
							$('#err_dis').show();
							$(".error_section").slideToggle('slow');
							$(".error_msg").html('利用開始日は今日より以前の日付になっています。');
							$(".divBody").scrollTop(0);
							return false;
						}
					}

					if ( end_period < today_date ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html('利用終了日は今日より以前の日付になっています。');
						$(".divBody").scrollTop(0);
						return false;
					}

                    //メールアドレスのフォーマットチェック
                    if(mail_address != ""){
                        if(!isEmail(mail_address)) {
                            $('#err_dis').show();
                            $(".error_section").slideToggle('slow');
                            $(".error_msg").html("メールアドレスのフォーマットは間違えています。");
                            $(".divBody").scrollTop(0);
                            return false;
                        }
                    }

					$("#start_period").datepicker( "option", "disabled", false );
					return true;
				});
			});

		<?php echo '</script'; ?>
>
	</head>
	<body class="pushmenu-push">
		<form id="main_form" action="<?php echo @constant('HOME_DIR');?>
AdminRegist/Save" method="post">
			<input type="hidden" id ="min_passwordLength" name="min_passwordLength" value="<?php echo @constant('MIN_PASSWORDLENGTH');?>
" >
            <input type="hidden" id ="max_passwordLength" name="max_passwordLength" value="<?php echo @constant('MAX_PASSWORDLENGTH');?>
" >
			<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:leftMenu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<div class="divHeader">
				<!--header-->
					<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

				<!--header-->
			</div>
			<div class="divBody">
				<div class="main" >
					<input type="hidden" id="err_msg" name="err_msg" value="<?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
"/>
					<div id="err_dis">
						<section class="error_section" id = "err">
							<img src="<?php echo @constant('HOME_DIR');?>
image/close_icon.png" style="width:15px;float:right" class="close_icon">
							<?php if (!empty($_smarty_tpl->tpl_vars['msg']->value)) {?>
								<div class="error_msg" id = "error_msg"><?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
</div>
							<?php } else { ?>
								<div class="error_msg" id = "error_msg"></div>
							<?php }?>
						</section>
					</div>
					<section class="content">
						<p>
							&gt;<span class="title">設定 / 運用管理者登録</span>
						</p>
						<input type="hidden" id="search_start_period" name="search_start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_start_period;?>
">
						<input type="hidden" id="search_end_period" name="search_end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_end_period;?>
">
						<input type="hidden" id="search_admin_name" name="search_admin_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->search_admin_name, ENT_QUOTES, 'UTF-8', true);?>
">
						<input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
">
						<div align="right" style="width:auto; margin-right: 100px; float: right;">
							<input type="button" id="back" title="戻る" value="" class="btn_back" onclick="javascript:doBack('<?php echo @constant('HOME_DIR');?>
AdminRegist/back')">
						</div>
						<input type="hidden" id="admin_no" name="admin_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->admin_no;?>
">
						<input type="hidden" id="txt_admin_kbn" name="txt_admin_kbn" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->txt_admin_kbn;?>
" >
						<input type="hidden" id="btn_value" name="btn_value" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->btn_value;?>
">
						<input type="hidden" id="date_flg" name="date_flg" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->date_flg;?>
">
						<!--  <input type="hidden" class="text" id="admin_kbn" name="admin_kbn" value="" maxlength = "20" size="30">-->
						<div class="">
						<br>
							<table>
								<tr>
									<td style="width:240px;">運用管理者名<span class="required">※</span></td>
									<td><input type="text" class="text" id="admin_name" name="admin_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->admin_name, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "32" size="30"></td>
								</tr>
								<tr>
									<td>読み</td>
									<td><input type="text" class="text" id="romaji_name" name="romaji_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->romaji_name, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "32" size="30"></td>
								</tr>
								<tr>
									<td>ログインID<span class="required">※</span></td>
									<td><input type="text" class="text" id="login_id" name="login_id" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->login_id, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "20" size="30"></td>
								</tr>
								<tr>
									<td>運用管理者権限<span class="required">※</span></td>
									<td>
										<select name="selAdminKbn" id="selAdminKbn">
											<option value="">選択してください。</option>
											<?php if (!empty($_smarty_tpl->tpl_vars['adminKbn']->value)) {?>
												<?php
$_from = $_smarty_tpl->tpl_vars['adminKbn']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_value_0_saved_item = isset($_smarty_tpl->tpl_vars['value']) ? $_smarty_tpl->tpl_vars['value'] : false;
$_smarty_tpl->tpl_vars['value'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['value']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
$__foreach_value_0_saved_local_item = $_smarty_tpl->tpl_vars['value'];
?>
													<?php if ($_smarty_tpl->tpl_vars['value']->value->type == $_smarty_tpl->tpl_vars['form']->value->admin_kbn) {?>
														<option value="<?php echo $_smarty_tpl->tpl_vars['value']->value->type;?>
" selected><?php echo $_smarty_tpl->tpl_vars['value']->value->name;?>
 </option>
													<?php } else { ?>
														<option value="<?php echo $_smarty_tpl->tpl_vars['value']->value->type;?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value->name, ENT_QUOTES, 'UTF-8', true);?>
 </option>
													<?php }?>
												<?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_0_saved_local_item;
}
if ($__foreach_value_0_saved_item) {
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_0_saved_item;
}
?>
											<?php }?>
										</select>

									</td>
								</tr>
								<tr>
									<td>パスワード<span class="required">※</span></td>
									<td><input type="password" class="text" id="password" name="password" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->password, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "20" size="30" autocomplete="new-password"></td>
								</tr>
								<tr>
									<td>パスワード（確認）<span class="required">※</span></td>
									<td><input type="password" class="text" id="confirm_password" name="confirm_password" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->password, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "20" size="30"></td>
								</tr>
								<tr>
									<td>利用開始<span class="required">※</span></td>
									<td>
										<input type="text" class="text" id="start_period" name="start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->start_period;?>
" maxlength="10" onchange="changeDateFormat(this)">
									</td>
								</tr>
								<tr>
									<td>利用終了<span class="required">※</span></td>
									<td><input type="text" class="text" id="end_period" name="end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->end_period;?>
" maxlength="10" onchange="changeDateFormat(this)">
									</td>
								</tr>
								<tr>
									<td>メールアドレス</td>
									<td><input type="text" class="text" id="mail_address" name="mail_address" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->mail_address, ENT_QUOTES, 'UTF-8', true);?>
" size="30">
								</tr>
								<tr>
									<td>備考</td>
									<td><input type="text" class="text" id="remarks" name="remarks" maxlength = "255" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->remarks, ENT_QUOTES, 'UTF-8', true);?>
" size="30"></td>
								</tr>
							</table>
							<br>
							<div style="width:100%; text-align:right">
								<input type="submit" name="insert" class="btn_insert" style="margin-right: 100px;" value="">
							</div>
						</div>
					</section><!-- End Content -->
				</div><!-- End Main -->
			</div><!-- End divBody -->
			<div class="divFooter">
				<!--footer-->
					<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

				<!--footer-->
			</div>
		</form>
		<?php echo '<script'; ?>
>
			
			/*datepickerを無効にする*/
			window.onload = function init() {

				var admin_no = document.getElementById('admin_no').value;
				if ( admin_no != "" ) {

					var today = moment().format('Y/MM/DD');
					var start_period = document.getElementById('start_period').value;

					if ( start_period < today ){

						$("#start_period").datepicker( "option", "disabled", true );
					}
				}
			}
			
		<?php echo '</script'; ?>
>
	</body>
</html><?php }
}
