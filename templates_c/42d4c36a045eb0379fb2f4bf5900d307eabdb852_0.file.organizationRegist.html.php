<?php
/* Smarty version 3.1.29, created on 2022-10-17 05:24:23
  from "D:\xampp\htdocs\eccadmin_dev\templates\organizationRegist.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_634ccae7dd90b4_81258852',
  'file_dependency' => 
  array (
    '42d4c36a045eb0379fb2f4bf5900d307eabdb852' => 
    array (
      0 => 'D:\\xampp\\htdocs\\eccadmin_dev\\templates\\organizationRegist.html',
      1 => 1640061441,
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
function content_634ccae7dd90b4_81258852 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
	<title>組織基本情報登録</title>
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

			//表示再現
			$(document).ready(function() {

				$(function() {
					$('#org_start_date').datepicker({
						showOn : "button",
						buttonImage : "<?php echo @constant('HOME_DIR');?>
image/calendar.svg",
						dateFormat: 'yy/mm/dd',
						buttonImageOnly : true,
						beforeShow: function (input, inst) {
							setTimeout(function () {
								var leftWidth=($('.pushmenu-open').length>0)?$('#org_start_date').offset().left-$('.pushmenu-open')[0].offsetWidth
	                                    :$('#org_start_date').offset().left;
								inst.dpDiv.css({
									left: leftWidth
								});
							}, 0);
						}
					});
				});

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

				$(function() {
					$('#contract_start_dt').datepicker({
						showOn : "button",
						buttonImage : "<?php echo @constant('HOME_DIR');?>
image/calendar.svg",
						dateFormat: 'yy/mm/dd',
						buttonImageOnly : true,
						beforeShow: function (input, inst) {
							setTimeout(function () {
								var leftWidth=($('.pushmenu-open').length>0)?$('#contract_start_dt').offset().left-$('.pushmenu-open')[0].offsetWidth
	                                    :$('#contract_start_dt').offset().left;
								inst.dpDiv.css({
									left: leftWidth
								});
							}, 0);
						}
					});

				});

				$(function() {
					$('#contract_end_dt').datepicker({
						showOn : "button",
						buttonImage : "<?php echo @constant('HOME_DIR');?>
image/calendar.svg",
						dateFormat: 'yy/mm/dd',
						buttonImageOnly : true,
						beforeShow: function (input, inst) {
							setTimeout(function () {
								var leftWidth=($('.pushmenu-open').length>0)?$('#contract_end_dt').offset().left-$('.pushmenu-open')[0].offsetWidth
	                                    :$('#contract_end_dt').offset().left;
								inst.dpDiv.css({
									left: leftWidth
								});
							}, 0);
						}
					});
				});

				// MSGのあるなし
				if ( $(".error_msg").html() != "" ){

					$(".error_section").slideDown('slow')
				}

				$(".close_icon").on('click', function(){

					$(".error_section").slideUp('slow')

				});

				/**
				 *
				 *  登録ボタン押下、必須チェック処理
				 *
				 **/
				$("#btn_insert").on('click', function(){

					$(".error_section").hide();

					var org_id = document.getElementById('org_id').value;
					var org_name = document.getElementById('org_name').value;
					var org_name_kana = document.getElementById('org_name_kana').value;
					var org_name_official = document.getElementById('org_name_official').value;
					var org_kbn = document.getElementById('org_kbn').value;
					var org_type = document.getElementById('org_type').value;
					var function_type = document.getElementById('function_type').value;
					var org_start_date = document.getElementById('org_start_date').value;
					var start_period = document.getElementById('start_period').value;
					var end_period = document.getElementById('end_period').value;
					var contract_start_dt = document.getElementById('contract_start_dt').value;
					var contract_end_dt = document.getElementById('contract_end_dt').value;
					var mail_address = document.getElementById('mail_address').value;
					// Start ADD 20211102 add query  by TienHM
					var push_flg = $('#push_flg1').prop('checked') ? 1 : 0;
					var count = document.getElementById('count').value;
					console.log('count:', count);
					//  End  ADD 20211102

					// 組織IDの必須チェック
					if ( org_id == "" ){

						$('#err_dis').show();
						$(".error_section").slideDown('slow');
						$(".error_msg").html("組織IDを入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					if ( org_id.match(/[^0-9a-zA-Z-_]/) ) {

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html('組織IDに半角英数字以外の文字が含まれています。');
						$(".divBody").scrollTop(0);
						return false;
					}

					// 組織名（表示用）の必須チェック
					if ( org_name == "" ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("組織名（表示用）を入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					// 組織名（ふりがな）の必須チェック
					if ( org_name_kana == "" ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("組織名（ふりがな）を入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					// 正式組織名の必須チェック
					if ( org_name_official == "" ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("正式組織名を入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					// 有償区分の必須チェック
					if ( org_kbn == "0" ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("有償区分を一つ選択してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					// 組織種類の必須チェック
					if ( org_type == "0" ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("組織種類を一つ選択してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					// 機能区分の必須チェック
					if ( function_type == "0" ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("機能区分を一つ選択してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					// 期首日の必須チェック
					if ( org_start_date == "" ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("期首日を入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					// 利用開始日の必須チェック
					if ( start_period == "" ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("利用開始日を入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					// 利用終了日の必須チェック
					if ( end_period == "" ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("利用終了日を入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					// 利用開始日 ≦ 利用終了日チェック
					if ( start_period > end_period ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("<?php echo @constant('W004');?>
");
						$(".divBody").scrollTop(0);
						return false;
					}

					// 契約開始日の必須チェック
					if ( contract_start_dt == "" ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("契約開始日を選択してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					// 契約終了日の必須チェック
					if ( contract_end_dt == "" ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("契約終了日を入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					// 契約開始日 ≦ 契約終了日チェック
					if ( contract_start_dt > contract_end_dt ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("契約開始日 ≦ 契約終了日を正しく入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}
					//メールアドレスのフォーマットチェック
					if(mail_address != ""){

						if(!isEmail(mail_address)) {
							$('#err_dis').show();
							$(".error_section").slideToggle('slow');
							$(".error_msg").html("組織連絡先mailのフォーマットは間違えています。");
							$(".divBody").scrollTop(0);
							return false;
						}
					}

					// Start ADD 20211102 add query  by TienHM
					//メールアドレスのフォーマットチェック
					if (push_flg && (count == 0)) {
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("Push数を入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}
					//  End  ADD 20211102
					return true;
				});
			});
		<?php echo '</script'; ?>
>
	</head>
	<body class="pushmenu-push">
		<form id="main_form" action="<?php echo @constant('HOME_DIR');?>
OrganizationRegist/save" method="post">
			<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:leftMenu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<div class="divHeader">
				<!--header-->
					<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

				<!--header-->
			</div>
			<div class="divBody">
				<input type="hidden" id="org_no" name="org_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
">
				<input type="hidden" id="screen_mode" name="screen_mode" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->screen_mode;?>
" />
				<input type="hidden" id="screen_value" name="screen_value"/>
				<input type="hidden" id="organization_no" name="organization_no"/>
				<input type="hidden" id="organization_id" name="organization_id"/>
				<input type="hidden" id="organization_name" name="organization_name"/>
				<input type="hidden" id="organization_name_kana" name="organization_name_kana"/>
				<input type="hidden" id="organization_official" name="organization_official"/>
				<input type="hidden" id="organization_kbn" name="organization_kbn"/>
				<input type="hidden" id="organization_type" name="organization_type"/>
				<input type="hidden" id="org_function_type" name="org_function_type"/>
				<input type="hidden" id="organization_start_date" name="organization_start_date"/>
				<input type="hidden" id="org_start_period" name="org_start_period"/>
				<input type="hidden" id="org_end_period" name="org_end_period"/>
				<input type="hidden" id="contract_start_date" name="contract_start_date"/>
				<input type="hidden" id="contract_end_date" name="contract_end_date"/>
				<input type="hidden" id="organization_admin" name="organization_admin"/>
				<input type="hidden" id="org_phone_no" name="org_phone_no"/>
				<input type="hidden" id="organization_mail" name="organization_mail"/>
				<input type="hidden" id="org_contract_no" name="org_contract_no"/>
				<input type="hidden" id="org_manager_nm" name="org_manager_nm"/>
				<input type="hidden" id="org_remarks" name="org_remarks"/>
				<!-- Start ADD 20211102 add query  by TienHM -->
				<input type="hidden" id="hd_push_flg" name="push_flg"/>
				<input type="hidden" id="hd_org_count" name="count"/>
				<!--End  ADD 20211102-->
				<input type="hidden" id="btn_flag" name="btn_flag"/>
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
				<input type="hidden" id="show_org_id" name="show_org_id"/>
				<input type="hidden" id="show_org_name" name="show_org_name"/>
				<input type="hidden" id="show_org_kana" name="show_org_kana"/>
				<input type="hidden" id="show_org_official" name="show_org_official"/>
				<div id="err_dis">
					<section class="error_section">
						<img src="<?php echo @constant('HOME_DIR');?>
image/close_icon.png" id="err_img" class="close_icon">
						  <?php if (!empty($_smarty_tpl->tpl_vars['err_msg']->value)) {?>
							  <div class="error_msg" id = "error_msg"><?php echo $_smarty_tpl->tpl_vars['err_msg']->value;?>
</div>
						  <?php } else { ?>
							  <div class="error_msg" id = "error_msg"></div>
						  <?php }?>
					</section>
				</div>
				<section class="content">
					<p>
						&gt;<span class="title">組織 / 組織基本情報登録</span>
					</p>
					<div>
						<input type="button" class="btn_back" onclick="javascript:doBack('<?php echo @constant('HOME_DIR');?>
OrganizationRegist/back')" title="戻る" style="padding-right:50px;float:right;">
						<table style="margin-top:30px;">
							<?php if (!empty($_smarty_tpl->tpl_vars['form']->value->org_no)) {?>
							<tr>
								<td style="width:200px;">組織管理番号<span class="required">※</span></td>
								<td colspan="3"><input type="text" class="text" id="org_no" name="org_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
" disabled="disabled"></td>
							</tr>
							<?php }?>
							<tr>
								<td style="width:200px;">組織ID<span class="required">※</span></td>
								<td colspan="3"><input type="text" class="text" id="org_id" name="org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_id;?>
" maxlength = "10" size = "10"></td>
								<td style="width:150px;"></td>
								<td style="width:170px;">組織担当者名</td>
								<td> <input type="text" class="text" id="org_admin" name="org_admin" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->org_admin, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "100" size = "100"></td>
							</tr>
							<tr>
								<td>組織名（表示用）<span class="required">※</span></td>
								<td colspan="3"><input type="text" class="text" id="org_name" name="org_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->org_name, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "100" size = "100"></td>
								 <td></td>
								<td>組織連絡先TEL</td>
								<td ><input type="text" class="text" id="phone_no" name="phone_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->phone_no;?>
" maxlength = "100" size = "100"></td>
							</tr>
							<tr>
								<td id="td_login_id">組織名（ふりがな）<span class="required">※</span></td>
								<td colspan="3" id="td_login_width"><input type="text" class="text" id="org_name_kana" name="org_name_kana" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->org_name_kana, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "100" size = "100"></td>
								 <td></td>
								<td>組織連絡先mail</td>
								<td><input type="text" class="text" id="mail_address" name="mail_address" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->mail_address;?>
" maxlength = "255" size = "255"></td>
							</tr>
							<tr>
								<td>正式組織名<span class="required">※</span></td>
								<td colspan="3"><input type="text" class="text" id="org_name_official" name="org_name_official" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->org_name_official, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "100" size = "100"></td>
								 <td></td>
								<td>契約番号/申請番号</td>
								<td ><input type="text" class="text" id="contract_no" name="contract_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->contract_no;?>
" maxlength = "32" size = "32"></td>
							</tr>
							<tr>
								<td>有償区分<span class="required">※</span></td>
								<td colspan="3">

								   <select name="org_kbn" id="org_kbn"  style="width:184px;">
									  <option value="0">選択してください。</option>
									  <?php if (!empty($_smarty_tpl->tpl_vars['kbn']->value)) {?>
										<?php
$_from = $_smarty_tpl->tpl_vars['kbn']->value;
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
										  <?php if ($_smarty_tpl->tpl_vars['value']->value->type == $_smarty_tpl->tpl_vars['form']->value->org_kbn) {?>
											<option value="<?php echo $_smarty_tpl->tpl_vars['value']->value->type;?>
" selected><?php echo $_smarty_tpl->tpl_vars['value']->value->name;?>
 </option>
										  <?php } else { ?>
											<option value="<?php echo $_smarty_tpl->tpl_vars['value']->value->type;?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value->name;?>
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
								<td></td>
								<td>ECC側担当</td>
								<td ><input type="text" class="text" id="manager_name" name="manager_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->manager_name, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "32" size = "32"></td>
							</tr>
							<tr>
								<td>組織種類<span class="required">※</span></td>
								<td colspan="3">
									<select name="org_type" id="org_type"  style="width:184px;">
									  <option value="0">選択してください。</option>
									  <?php if (!empty($_smarty_tpl->tpl_vars['type']->value)) {?>
										<?php
$_from = $_smarty_tpl->tpl_vars['type']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_value_1_saved_item = isset($_smarty_tpl->tpl_vars['value']) ? $_smarty_tpl->tpl_vars['value'] : false;
$_smarty_tpl->tpl_vars['value'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['value']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
$__foreach_value_1_saved_local_item = $_smarty_tpl->tpl_vars['value'];
?>
										  <?php if ($_smarty_tpl->tpl_vars['value']->value->type == $_smarty_tpl->tpl_vars['form']->value->org_type) {?>
											<option value="<?php echo $_smarty_tpl->tpl_vars['value']->value->type;?>
" selected><?php echo $_smarty_tpl->tpl_vars['value']->value->name;?>
 </option>
										  <?php } else { ?>
											<option value="<?php echo $_smarty_tpl->tpl_vars['value']->value->type;?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value->name;?>
 </option>
										  <?php }?>
										<?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_1_saved_local_item;
}
if ($__foreach_value_1_saved_item) {
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_1_saved_item;
}
?>
									  <?php }?>
									</select>
								</td>
								<td></td>
								<td>組織備考</td>
								<td >
									<textarea name="remarks" id="remarks" cols="40" maxlength = "512" style="width : 220px; height : 60px; margin-top : 10px; overflow-y : scroll; resize : none;"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->remarks, ENT_QUOTES, 'UTF-8', true);?>
</textarea>
								</td>
							</tr>
							<tr>
								<td>機能区分<span class="required">※</span></td>
								<td colspan="3">
									<select name="function_type" id="function_type"  style="width:184px;">
									  <option value="0">選択してください。</option>
									  <?php if (!empty($_smarty_tpl->tpl_vars['fun_type']->value)) {?>
										<?php
$_from = $_smarty_tpl->tpl_vars['fun_type']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_value_2_saved_item = isset($_smarty_tpl->tpl_vars['value']) ? $_smarty_tpl->tpl_vars['value'] : false;
$_smarty_tpl->tpl_vars['value'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['value']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
$__foreach_value_2_saved_local_item = $_smarty_tpl->tpl_vars['value'];
?>
										  <?php if ($_smarty_tpl->tpl_vars['value']->value->type == $_smarty_tpl->tpl_vars['form']->value->function_type) {?>
											<option value="<?php echo $_smarty_tpl->tpl_vars['value']->value->type;?>
" selected><?php echo $_smarty_tpl->tpl_vars['value']->value->name;?>
 </option>
										  <?php } else { ?>
											<option value="<?php echo $_smarty_tpl->tpl_vars['value']->value->type;?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value->name;?>
 </option>
										  <?php }?>
										<?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_2_saved_local_item;
}
if ($__foreach_value_2_saved_item) {
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_2_saved_item;
}
?>
									  <?php }?>
									</select>
								</td>
								<!-- Start ADD 20211102 add query  by TienHM -->
								<td></td>
								<td>Push許可</td>
								<td class="input">
									<?php if (($_smarty_tpl->tpl_vars['form']->value->push_flg == 1)) {?>
									<input type="radio" id="push_flg1" name="push_flg" value='1' checked>
									<label for="push_flg1">許可する</label>
									<input type="radio" id="push_flg2" name="push_flg" value='0'>
									<label for="push_flg2">許可しない</label>
									<?php } else { ?>
									<input type="radio" id="push_flg1" name="push_flg" value='1'>
									<label for="push_flg1">許可する</label>
									<input type="radio" id="push_flg2" name="push_flg" value='0' checked>
									<label for="push_flg2">許可しない</label>
									<?php }?>
								</td>
								<!-- End  ADD 20211102 -->
							</tr>
							<tr>
								<td>期首日<span class="required">※</span></td>
								<td colspan="3">
									<input type="text" id="org_start_date" name="org_start_date" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_start_date;?>
"  maxlength="10" onchange="changeDateFormat(this)">
								</td>
								<!-- Start ADD 20211102 add query  by TienHM -->
								<td></td>
								<td>Push数</td>
								<td colspan="3">
									<input
											type="number"
											id="count"
											name="count"
											value="<?php echo $_smarty_tpl->tpl_vars['form']->value->count;?>
"
											min="0"
											maxlength="10">
								</td>
								<!-- End  ADD 20211102 -->
							</tr>
							<tr>
								<td>利用開始日<span class="required">※</span></td>
								<td colspan="3"><input type="text" id="start_period" name="start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->start_period;?>
" maxlength="10" onchange="changeDateFormat(this)"></td>
							</tr>
							<tr>
								<td>利用終了日<span class="required">※</span></td>
								<td colspan="3"><input type="text" id="end_period" name="end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->end_period;?>
" maxlength="10" onchange="changeDateFormat(this)"></td>
							</tr>
							<tr>
								<td>契約開始日<span class="required">※</span></td>
								<td colspan="3"><input type="text" id="contract_start_dt" name="contract_start_dt" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->contract_start_dt;?>
" maxlength="10" onchange="changeDateFormat(this)"></td>
							</tr>
							<tr>
								<td>契約終了日<span class="required">※</span></td>
								<td colspan="3"><input type="text" id="contract_end_dt" name="contract_end_dt" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->contract_end_dt;?>
" maxlength="10" onchange="changeDateFormat(this)"></td>
							</tr>
						</table>
						<div style="width:100%;">
							<table style="float:right;">
								<tr>
									<td style="width:70px;"><input type="submit" name="insert" value="" id="btn_insert" class="btn_insert" title="登録"></td>
									<?php if ($_smarty_tpl->tpl_vars['form']->value->screen_mode == 'update') {?>
									<td style="width:70px;"> <input type="button" class="btn_setting" style="background-size:35px 35px;width:35px;height:35px;" title="学年設定" onclick="grade('<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
','<?php echo @constant('HOME_DIR');?>
GradeRegist/index')"></td>
									<td style="width:70px;"> <input type="button" class="btn_mng_assign" title="管理者設定" onclick="admin('<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
','<?php echo $_smarty_tpl->tpl_vars['form']->value->org_id;?>
','<?php echo $_smarty_tpl->tpl_vars['form']->value->org_name;?>
','<?php echo $_smarty_tpl->tpl_vars['form']->value->org_name_kana;?>
','<?php echo $_smarty_tpl->tpl_vars['form']->value->org_name_official;?>
','<?php echo @constant('HOME_DIR');?>
ManagerRegist/index')"></td>
									<?php }?>
								</tr>
							</table>
						</div>
					</div>
				</section><!-- End Content -->
			</div><!-- End divBody -->
		</form>
		<div class="divFooter">
				<!--footer-->
					<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

				<!--footer-->
		</div>

		<?php echo '<script'; ?>
>
			
				// 管理者ボタン処理
				function admin(org_no,org_id,org_name,org_kana,org_off,action) {

					$("#main_form").attr("action", action);
					$("#organization_no").val(org_no);
					$("#show_org_id").val(org_id);
					$("#show_org_name").val(org_name);
					$("#show_org_kana").val(org_kana);
					$("#show_org_official").val(org_off);
					$("#btn_flag").val('2');

					setFormData();
			}

				// 学年設定ボタン処理
				function grade(org_no,action) {

					$("#main_form").attr("action", action);
					$("#organization_no").val(org_no);
					$("#btn_flag").val('1');

					setFormData();
				}

				//戻るボタン処理
				function doBack(action){

					$("#main_form").attr("action", action);
					$("#main_form").submit();
				}

				//戻るセットフォーム
				function setFormData() {

					var menuOpen = document.getElementById('menuOpen').value;
					var menuStatus = document.getElementById('menuStatus').value;
					var org_id = document.getElementById('org_id').value;
					var org_name = document.getElementById('org_name').value;
					var org_name_kana = document.getElementById('org_name_kana').value;
					var org_name_official = document.getElementById('org_name_official').value;
					var org_kbn = document.getElementById('org_kbn').value;
					var org_type = document.getElementById('org_type').value;
					var function_type = document.getElementById('function_type').value;
					var org_start_date = document.getElementById('org_start_date').value;
					var start_period = document.getElementById('start_period').value;
					var end_period = document.getElementById('end_period').value;
					var contract_start_dt = document.getElementById('contract_start_dt').value;
					var contract_end_dt = document.getElementById('contract_end_dt').value;
					var org_admin = document.getElementById('org_admin').value;
					var phone_no = document.getElementById('phone_no').value;
					var mail_address = document.getElementById('mail_address').value;
					var contract_no = document.getElementById('contract_no').value;
					var manager_name = document.getElementById('manager_name').value;
					var remarks = document.getElementById('remarks').value;
					// Start ADD 20211102 add query  by TienHM
					var push_flg = $('#push_flg1').prop('checked') ? 1 : 0;
					var count = document.getElementById('count').value;
					//  End  ADD 20211102
					var screen_mode = document.getElementById('screen_mode').value;

					$("#menuOpen").val(menuOpen);
					$("#menuStatus").val(menuStatus);
					$("#organization_id").val(org_id);
					$("#organization_name").val(org_name);
					$("#organization_name_kana").val(org_name_kana);
					$("#organization_official").val(org_name_official);
					$("#organization_kbn").val(org_kbn);
					$("#organization_type").val(org_type);
					$("#org_function_type").val(function_type);
					$("#organization_start_date").val(org_start_date);
					$("#org_start_period").val(start_period);
					$("#org_end_period").val(end_period);
					$("#contract_start_date").val(contract_start_dt);
					$("#contract_end_date").val(contract_end_dt);
					$("#organization_admin").val(org_admin);
					$("#org_phone_no").val(phone_no);
					$("#organization_mail").val(mail_address);
					$("#org_contract_no").val(contract_no);
					$("#org_manager_nm").val(manager_name);
					$("#org_remarks").val(remarks);
					// Start ADD 20211102 add query  by TienHM
					$("#hd_push_flg").val(push_flg);
					$("#hd_org_count").val(count);
					//  End  ADD 20211102
					$("#screen_value").val(screen_mode);
					$("#main_form").submit();
				}
			
		<?php echo '</script'; ?>
>
	</body>
</html>
<?php }
}
