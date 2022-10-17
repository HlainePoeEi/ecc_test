<?php
/* Smarty version 3.1.29, created on 2022-10-13 11:45:36
  from "/var/www/html/eccadmin_dev/templates/teacherRegist.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_63477bd0986cc5_62008178',
  'file_dependency' => 
  array (
    'a85703aef63ea2fd8807409eaee5d4297f2e14c8' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/teacherRegist.html',
      1 => 1574654143,
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
function content_63477bd0986cc5_62008178 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
	<head>
	<title>講師登録</title>
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

			// Enterキーを無効にする
			$(document).keypress(function (e) {
				if (e.which == 13) {
					return false;
				}
			});

			//表示再現
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

				$('#training_flg_chk').change(function() {
					if(this.checked) {
						$('#training_flg').val('1');
					}else{
						$('#training_flg').val('0');
					}
				});

				// MSGのあるなし
				if ( $(".error_msg").html() != "" ) {

					$(".error_section").slideToggle('slow');
				}
				$(".close_icon").on('click',function(){

					$(".error_section").slideToggle('slow');

					$('#err_dis').slideToggle('slow');

				});

				/**
				*
				* 登録ボタン押下、必須チェック処理
				*
				**/
				$(".btn_insert").on('click',function(){

					$(".error_section").hide();
					$('#err_dis').hide();

					var login_id = document.getElementById('login_id').value;
					var name = document.getElementById('name').value;
					var nickname = document.getElementById('nickname').value;
					var display_name = document.getElementById('display_name').value;
					var school_kbn = document.getElementById('school_kbn').value;
					var password = document.getElementById('password').value;
					var confirm_password = document.getElementById('confirm_password').value;
					var start_period = document.getElementById('start_period').value;
					var end_period = document.getElementById('end_period').value;
					var screen_mode = document.getElementById('screen_mode').value;
					if($('input[name=training_flg_chk]').prop('checked')){
						$("#training_flg").val("1");
					}else{
						$("#training_flg").val("0");
					}
					var training_flg = document.getElementById('training_flg').value;

					// グループ名の必須チェック
					if ( login_id == "" ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("講師コードを入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					// グループ名の必須チェック
					if ( name == "" ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("氏名を入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					// グループ名の文字数チェック
					if ( nickname == ""){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("ニックネームを入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					// 読みの文字数チェック
					if ( display_name == "" ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("講師表示名を入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					// ログインIDの必須チェック
					if ( school_kbn == "" ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("所属校舎入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					// ログインIDのの文字数チェック
					if ( login_id.length > 20 ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("講師コードは20字で入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					if ( login_id.match(/[^0-9a-zA-Z]/) ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html('講師コードに半角英数字以外の文字が含まれています。');
						$(".divBody").scrollTop(0);
						return false;
					}

					//パスワードの最小長
	                var min_passwordLength = document.getElementById('min_passwordLength').value;
	                //パスワードの最高長
	                var max_passwordLength = document.getElementById('max_passwordLength').value;

					//新規モッドにパスワードが必要
					if ( screen_mode == 'new' ){
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

						if ( password.length < min_passwordLength ){
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
							$(".error_msg").html("パスワードは最高"+max_passwordLength+"字以内入力してください。");
							$(".divBody").scrollTop(0);
							return false;
						}

						 if ( confirm_password.length < min_passwordLength ){
	                            $('#err_dis').show();
	                            $(".error_section").slideToggle('slow');
	                            $(".error_msg").html("パスワード（確認）は最低"+min_passwordLength+"字で入力してください。");
	                            $(".divBody").scrollTop(0);
	                            return false;
	                       }

						// パスワード（確認）の文字数チェック
						if ( confirm_password.length > max_passwordLength ){
							$('#err_dis').show();
							$(".error_section").slideToggle('slow');
							$(".error_msg").html("パスワード（確認）は最高"+max_passwordLength+"字以内入力してください。");
							$(".divBody").scrollTop(0);
							return false;
						}
					}

					//編集モッドにパスワードを入れたらフォーマットをチャック
					if ( screen_mode == 'update' ){

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

							// パスワードの文字数チェック
	                        if ( password.length < min_passwordLength && password != "" ){
	                            $('#err_dis').show();
	                            $(".error_section").slideToggle('slow');
	                            $(".error_msg").html("パスワードは最低"+min_passwordLength+"字で入力してください。");
	                            $(".divBody").scrollTop(0);
	                            return false;
	                        }

							if ( password.length > max_passwordLength ){
								$('#err_dis').show();
								$(".error_section").slideToggle('slow');
								$(".error_msg").html("パスワードは最高"+max_passwordLength+"字以内入力してください。");
								$(".divBody").scrollTop(0);
								return false;
							}

							// パスワード（確認）の文字数チェック
							if ( confirm_password.length < min_passwordLength && password != "" ){
	                            $('#err_dis').show();
	                            $(".error_section").slideToggle('slow');
	                            $(".error_msg").html("パスワード（確認）は最低"+min_passwordLength+"字で入力してください。");
	                            $(".divBody").scrollTop(0);
	                            return false;
	                        }

							if ( confirm_password.length > max_passwordLength ){
								$('#err_dis').show();
								$(".error_section").slideToggle('slow');
								$(".error_msg").html("パスワード（確認）は最高"+max_passwordLength+"字以内入力してください。");
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

					if ( start_period > end_period ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("<?php echo @constant('W004');?>
");
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

					return true;
				});
			});
			//戻るボタン
			function doBack(action) {

				$("#back_flg").val("true");
				$("#main_form").attr("action", action);
				$("#main_form").submit();
			}

		<?php echo '</script'; ?>
>
	</head>
	<body class="pushmenu-push">
		<form id="main_form" action="<?php echo @constant('HOME_DIR');?>
TeacherRegist/Save" method="post">
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
					 <input type="hidden" id="err_msg" name="err_msg" value="<?php echo $_smarty_tpl->tpl_vars['error_msg']->value;?>
"/>
					<div id="err_dis">
						<section class="error_section" id = "err">
							<img src="<?php echo @constant('HOME_DIR');?>
image/close_icon.png" style="width:15px;float:right" class="close_icon">
							<?php if (!empty($_smarty_tpl->tpl_vars['error_msg']->value)) {?>
								<div class="error_msg" id = "error_msg"><?php echo $_smarty_tpl->tpl_vars['error_msg']->value;?>
</div>
							<?php } else { ?>
								<div class="error_msg" id = "error_msg"></div>
							<?php }?>
						</section>
					</div>
					<section class="content">
						<!-- <div class="main_div">  -->
						<p>
							&gt;<span class="title">講師 / 講師登録</span>
						</p>
						<p style="text-align:right"><input type="button" title="戻る" value="" class="btn_back" onclick="javascript:doBack('<?php echo @constant('HOME_DIR');?>
TeacherRegist/back')"/></p>
						<input type="hidden" id="manager_no" name="manager_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->manager_no;?>
"/>
						<input type="hidden" id="screen_mode" name="screen_mode" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->screen_mode;?>
"/>
						<input type="hidden" id="training_flg" name="training_flg"/>
						<input type="hidden" id="teacher_no" name="teacher_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->teacher_no;?>
"/>
						<input type="hidden" id="search_end_period" name="search_end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_end_period;?>
"/>
						<input type="hidden" id="search_start_period" name="search_start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_start_period;?>
"/>
						<input type="hidden" id="search_name" name="search_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_name;?>
"/>
						<input type="hidden" id="search_school_kbn" name="search_school_kbn" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_school_kbn;?>
"/>
						<input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
"/>
						<input type="hidden" id="back_flg" name="back_flg" value="false" />
						<div class="">
						<br>
							<table>
								<tr>
									<td style="width:240px;">講師コード<span class="required">※</span></td>
									<td><input type="text" class="text" id="login_id" name="login_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->login_id;?>
" maxlength ="20" size="30"></td>
								</tr>
								<tr>
									<td>氏名<span class="required">※</span></td>
									<td><input type="text" class="text" id="name" name="name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->name, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "32" size="30"></td>
								</tr>
								<tr>
									<td>ニックネーム<span class="required">※</span></td>
									<td><input type="text" class="text" id="nickname" name="nickname" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->nickname, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "20" size="30"></td>
								</tr>
								<tr>
									<td>講師表示名<span class="required">※</span></td>
									<td><input type="text" class="text" id="display_name" name="display_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->display_name, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "20" size="30"></td>
								</tr>
								<tr>
									<td>所属校舎<span class="required">※</span></td>
									<td>
										<select name="school_kbn" id="school_kbn" style="width:200px !important;">
											<option value="">選択してください。</option>
											<?php if (!empty($_smarty_tpl->tpl_vars['form']->value->school_kbn_list)) {?>
												<?php
$_from = $_smarty_tpl->tpl_vars['form']->value->school_kbn_list;
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
												<?php if ($_smarty_tpl->tpl_vars['value']->value->type == $_smarty_tpl->tpl_vars['form']->value->school_kbn) {?>
													<option value="<?php echo $_smarty_tpl->tpl_vars['value']->value->type;?>
" selected><?php echo $_smarty_tpl->tpl_vars['value']->value->name;?>
 </option>
												<?php } else { ?>
													<option value="<?php echo $_smarty_tpl->tpl_vars['value']->value->type;?>
"> <?php echo $_smarty_tpl->tpl_vars['value']->value->name;?>
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
									<td>モード<span class="required">※</span></td>
									<td>
										<?php if ($_smarty_tpl->tpl_vars['form']->value->training_flg == '1') {?>
											<label><input type="checkbox" class="test_kbn" id="training_flg_chk" name="training_flg_chk" checked>練習中</label>
										<?php } else { ?>
											<label><input type="checkbox" class="test_kbn"  id="training_flg_chk" name="training_flg_chk"/>練習中</label>
										<?php }?>
									</td>
								</tr>
								<tr>
									<td>利用開始<span class="required">※</span></td>
									<td><input type="text" id="start_period" name="start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->start_period;?>
" maxlength="10" onchange="changeDateFormat(this)"></td>
								</tr>
								<tr>
									<td>利用終了<span class="required">※</span></td>
									<td><input type="text" id="end_period" name="end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->end_period;?>
" maxlength="10" onchange="changeDateFormat(this)"></td>
								</tr>
								<tr>
									<td>備考</td>
									<td><input type="text" class="text" id="remarks" name="remarks" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->remarks, ENT_QUOTES, 'UTF-8', true);?>
" size="30"></td>
								</tr>
								<tr>
									<td>パスワード<span class="required">※</span></td>
									<td><input type="password" class="text" id="password" name="password" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->password;?>
" maxlength="20" size="30" autocomplete="new-password"></td>
								</tr>
								<tr>
									<td>パスワード（確認)<span class="required">※</span></td>
									<td><input type="password" class="text" id="confirm_password" name="confirm_password" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->confirm_password;?>
" maxlength="20" size="30"></td>
								</tr>
							</table>
							<br>
							<div style="width:100%;text-align:right">
								<input type="submit" name="insert" title="登録" class="btn_insert" value="">
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
	</body>
</html>
<?php }
}
