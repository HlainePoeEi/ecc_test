<?php
/* Smarty version 3.1.29, created on 2022-10-13 11:48:24
  from "/var/www/html/eccadmin_dev/templates/passwordChange.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_63477c78a49521_50998538',
  'file_dependency' => 
  array (
    '4d0e94f69e05f914c7677802b29a1ce7961b3fe6' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/passwordChange.html',
      1 => 1547026358,
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
function content_63477c78a49521_50998538 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
	<title>パスワード変更</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta name="robots" content="noindex, nofollow">
	<meta name="googlebot" content="noindex, nofollow">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
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
js/datatables.min.js"><?php echo '</script'; ?>
>
	
	<link rel="stylesheet" href="<?php echo @constant('HOME_DIR');?>
css/jquery-ui.css">
	<link href="<?php echo @constant('HOME_DIR');?>
css/default.css" rel="stylesheet">
	<link href="<?php echo @constant('HOME_DIR');?>
css/style.css" rel="stylesheet">
	<?php echo '<script'; ?>
>
		    $(document).ready(function() {
				// MSGのあるなし
				if ( $(".error_msg").html() != "" ) {
					$(".error_section").slideToggle('slow')
				}
				$(".close_icon").on('click',function() {
					$(".error_section").slideToggle('slow')
					$("#err_dis").slideToggle('slow')
				});
			    $("#btn_insert").on('click', function(){
					var old_psw = document.getElementById('old_psw').value;
					var new_psw = document.getElementById('new_psw').value;
					var new_psw_confirm = document.getElementById('new_psw_confirm').value;
					// 旧パスワードの必須チェック
					if ( old_psw == "" ){
						$('#err_dis').show();
						$(".error_section").slideDown('slow');
						$(".error_msg").html("旧パスワードを入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}
					// 新パスワードの必須チェック
					if ( new_psw == "" ){
						$('#err_dis').show();
						$(".error_section").slideDown('slow');
						$(".error_msg").html("新パスワードを入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}
					// 新パスワード（確認）の必須チェック
					if ( new_psw_confirm == "" ){
						$('#err_dis').show();
						$(".error_section").slideDown('slow');
						$(".error_msg").html("新パスワード（確認）を入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}
					 if ( !new_psw.match(/^(?! )[A-Za-z0-9-_]+(?<! )$/) ){

	                     $('#err_dis').show();
	                     $(".error_section").slideDown('slow');
	                     $(".error_msg").html('パスワードに半角英数字以外の文字が含まれています。');
	                     $(".divBody").scrollTop(0);
	                     return false;
	                 }
	                if ( !new_psw_confirm.match(/^(?! )[A-Za-z0-9-_]+(?<! )$/) ){

	                     $('#err_dis').show();
	                     $(".error_section").slideDown('slow');
	                     $(".error_msg").html('パスワード（確認）に半角英数字以外の文字が含まれています。');
	                     $(".divBody").scrollTop(0);
	                     return false;
	                }
					//パスワードの最小長
	                var min_passwordLength = document.getElementById('min_passwordLength').value;
					if ( new_psw.length < min_passwordLength ){
						$('#err_dis').show();
						$(".error_section").slideDown('slow');
						$(".error_msg").html("新パスワードは最低"+min_passwordLength+"字で入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}
					if ( new_psw_confirm.length < min_passwordLength ){
						$('#err_dis').show();
						$(".error_section").slideDown('slow');
						$(".error_msg").html("新パスワード（確認）は最低"+min_passwordLength+"字で入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}
					//パスワードの最高長
	                var max_passwordLength = document.getElementById('max_passwordLength').value;
					if ( new_psw.length > max_passwordLength ){
						$('#err_dis').show();
						$(".error_section").slideDown('slow');
						$(".error_msg").html("新パスワードは最高"+max_passwordLength+"字で入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}
					if ( new_psw_confirm.length > max_passwordLength ){
						$('#err_dis').show();
						$(".error_section").slideDown('slow');
						$(".error_msg").html("新パスワード（確認）は最高"+max_passwordLength+"字で入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}
					if ( new_psw != new_psw_confirm ){
                        $('#err_dis').show();
                        $(".error_section").slideDown('slow');
                        $(".error_msg").html("<?php echo @constant('E025');?>
");
                        $(".divBody").scrollTop(0);
                        return false;
                    }
				return true;
			});

			//ブラウザの戻るボタンを押すと、前の画面が表示される
			if (window.history && window.history.pushState){
				$(window).on('popstate', function(){
					var referrer =  document.referrer;
					var hashLocation = location.hash;
					var hashSplit = hashLocation.split("#!/");
					var hashName = hashSplit[1];
					if(hashName !== ''){
						var hash = window.location.hash;
						if(hash === ''){
							window.location.assign("<?php echo @constant('HOME_DIR');?>
Menu/index");
						}
					}
				});
				window.history.pushState(null,null,'');
			}
		});

	<?php echo '</script'; ?>
>
</head>
<body class="pushmenu-push">
	<form id="main_form" action="<?php echo @constant('HOME_DIR');?>
PasswordChange/update" method="post">
		<input type="hidden" id ="min_passwordLength" name="min_passwordLength" value="<?php echo @constant('MIN_PASSWORDLENGTH');?>
" >
        <input type="hidden" id ="max_passwordLength" name="max_passwordLength" value="<?php echo @constant('MAX_PASSWORDLENGTH');?>
" >

		<input type="hidden" id="login_id" name="login_id" value ="<?php echo $_smarty_tpl->tpl_vars['form']->value->login_id;?>
"/>
		<input type="hidden" id="admin_no" name="admin_no" value ="<?php echo $_smarty_tpl->tpl_vars['form']->value->admin_no;?>
"/>

		<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:leftMenu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

		<div class="divHeader">
			<!--header-->
				<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<!--header-->
		</div>
		<div class="divBody">
			<div class="main">
			    <!-- error message session start -->
				<div id="err_dis">
					<section class="error_section" id="err">
						<img src="<?php echo @constant('HOME_DIR');?>
image/close_icon.png" style="width: 15px; float: right" class="close_icon">
						<?php if (!empty($_smarty_tpl->tpl_vars['err_msg']->value)) {?>
							<div class="error_msg"><?php echo $_smarty_tpl->tpl_vars['err_msg']->value;?>
</div>
						<?php } else { ?>
							<div class="error_msg"></div>
						<?php }?>
					</section>
				</div>
				<!-- error message session end -->
				<section class="content">
				<p> >
					<span class="title">設定 / パスワード変更</span>
				</p>
				<div id="pswChange" style="padding-top:50px;">
					<table class="main_tbl">
						<tr>
							<tr>
								<td style="width:230px;height:50px;">旧パスワード<span class="required">※</span></td>
								<td colspan="3"><input type="password" class="text" style="width:300px;"  id="old_psw" name="old_psw" value ="<?php echo $_smarty_tpl->tpl_vars['form']->value->old_psw;?>
"></td>
							</tr>
							<tr>
								<td style="width:230px;height:50px;">新パスワード<span class="required">※</span></td>
								<td colspan="3"><input type="password" class="text" style="width:300px;" id="new_psw" name="new_psw" value ="<?php echo $_smarty_tpl->tpl_vars['form']->value->new_psw;?>
" maxlength = "20" ></td>
							</tr>
							<tr>
								<td style="width:230px;height:50px;">新パスワード（確認）<span class="required">※</span></td>
								<td colspan="3"><input type="password" class="text" style="width:300px;" id="new_psw_confirm" name="new_psw_confirm" value ="<?php echo $_smarty_tpl->tpl_vars['form']->value->new_psw_confirm;?>
" maxlength = "20" ></td>
							</tr>
					</table>
					<div style=" padding-top:30px;padding-left:515px;">
						<input id="btn_insert" type="submit" class="btn_insert" name="btn_insert" title="登録"  value="" >
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
</html><?php }
}
