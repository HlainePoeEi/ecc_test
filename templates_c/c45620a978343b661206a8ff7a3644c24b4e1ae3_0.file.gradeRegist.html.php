<?php
/* Smarty version 3.1.29, created on 2022-06-13 17:02:08
  from "/var/www/html/eccadmin_dev/templates/gradeRegist.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_62a6ef00f25311_82750695',
  'file_dependency' => 
  array (
    'c45620a978343b661206a8ff7a3644c24b4e1ae3' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/gradeRegist.html',
      1 => 1547458228,
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
function content_62a6ef00f25311_82750695 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
	<head>
		<title>学年設定</title>
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
				if ( $(".error_msg").html() != "" ){

					$(".error_section").slideToggle('slow')
				}

				$(".close_icon").on('click', function(){

					$(".error_section").slideToggle('slow')
					$('#err_dis').slideToggle('slow')
				});

				/* ラジオボタンのチェック変更イベント */
				$('#main_form input').on('change', function() {

					var status_val = $('input[name=chk_status]:checked', '#main_form').val();
					$("#status").val(status_val);
					$("#answer_flg").val(status_val);
				});
			});
		<?php echo '</script'; ?>
>
	</head>
	<body class="pushmenu-push">
		<form id="main_form" action="<?php echo @constant('HOME_DIR');?>
GradeRegist/save" method="post">
			<input type="hidden" id="admin_no" name="admin_no"/>
			<input type="hidden" id="org_no" name="org_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
"/>
			<input type="hidden" id="page" name="page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->page;?>
" />
			<input type="hidden" id="grade_no" name="grade_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->grade_no;?>
" />
			<input type="hidden" id="screen_mode" name="screen_mode" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->screen_mode;?>
">
			<input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
"/>
			<input type="hidden" id="search_start_period" name="search_start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_start_period;?>
"/>
			<input type="hidden" id="search_end_period" name="search_end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_end_period;?>
"/>
			<input type="hidden" id="search_org_name" name="search_org_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_org_name;?>
"/>
			<input type="hidden" id="search_chk_status" name="search_chk_status" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_chk_status;?>
"/>
			<input type="hidden" id="search_chk_status1" name="search_chk_status1" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_chk_status1;?>
"/>
			<input type="hidden" id="search_chk_status2" name="search_chk_status2" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_chk_status2;?>
"/>
			<input type="hidden" id="search_chk_status3" name="search_chk_status3" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_chk_status3;?>
"/>
			<input type="hidden" id="btn_flag" name="btn_flag" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->btn_flag;?>
"/>
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
			<input type="hidden" id="screen_value" name="screen_value" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->screen_value;?>
" />
			<input type="hidden" id="grade_cnt" value="<?php echo $_smarty_tpl->tpl_vars['grade_cnt']->value;?>
" />
			<input type="hidden" id="initial_disp_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->disp_no;?>
">
			<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:leftMenu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<div class="divHeader">
				<!--header-->
					<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

				<!--header-->
			</div>
			<div class="divBody">
				<div id="err_dis" tabindex="1">
					<section class="error_section">
						<img src="<?php echo @constant('HOME_DIR');?>
image/close_icon.png" style="width:15px;float:right" class="close_icon">
						<?php if (!empty($_smarty_tpl->tpl_vars['error_msg']->value)) {?>
							<div class="error_msg"><?php echo $_smarty_tpl->tpl_vars['error_msg']->value;?>
</div>
						<?php } elseif (!empty($_smarty_tpl->tpl_vars['info_msg']->value)) {?>
							<div class="error_msg"><?php echo $_smarty_tpl->tpl_vars['info_msg']->value;?>
</div>
						<?php } else { ?>
							<div class="error_msg"></div>
						<?php }?>
					</section>
				</div>
				<section class="content">
					<p>
						><span class="title">組織登録 / 組織学年設定</span>
					</p>
					<p style="text-align:right;width:100%;">
						<input type="button" title="戻る" value="" class="btn_back" onclick="javascript:doBack('<?php echo @constant('HOME_DIR');?>
GradeRegist/back')">
					</p>
					<table style="width: 50%; margin-top: -30px;">
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td><label><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['org_name']->value, ENT_QUOTES, 'UTF-8', true);?>
</label></td>
						</tr>
						<tr>
							<td>組織ID</td>
							<td><label><?php echo $_smarty_tpl->tpl_vars['org_id']->value;?>
</label></td>
							<td>組織名</td>
							<td><label><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['org_name_kana']->value, ENT_QUOTES, 'UTF-8', true);?>
</label></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td><label><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['org_name_official']->value, ENT_QUOTES, 'UTF-8', true);?>
</label></td>
						</tr>
					</table>
					<br>
					<table class="main_tbl">
						<tr>
							<td>学年名<span class="required">※</span></td>
							<td class="input">
								<input class="text" type="text" name="grade_name" id="grade_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->grade_name, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "32" size="30">
							</td>
							<td class="st_col">学年名ふりがな<span class="required">※</span></td>
							<td><input class="text" type="text" name="grade_name_kana" id="grade_name_kana" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->grade_name_kana, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "32" size="30"></td>
						</tr>
						<tr>
							<td>表示順<span class="required">※</span></td>
							<td class="input">
								<input class="text" type="text" name="disp_no" id="disp_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->disp_no;?>
" maxlength = "3" size="30">
							</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td class="st_col">利用開始日<span class="required">※</span></td>
							<td class="input" style="width:250px;"><input class="" type="text" name="start_period" id="start_period"
									value="<?php echo $_smarty_tpl->tpl_vars['form']->value->start_period;?>
" maxlength="10" onchange="changeDateFormat(this)"></td>
							<td class="st_col">利用終了日<span class="required">※</span></td>
							<td class="input"><input class="" type="text" name="end_period" id="end_period"
							 value="<?php echo $_smarty_tpl->tpl_vars['form']->value->end_period;?>
" maxlength="10" onchange="changeDateFormat(this)"></td>
						</tr>
						<tr>
							<td class="st_col">備考<span class="required">※</span></td>
							<td class="st_col" colspan="2"><input class="text" type="text" name="remarks" id="remarks" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->remarks, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "512" size="30" style="width: 100%;"></td>
							<td></td>
						</tr>
					</table>
					<p style="text-align:right;">
						<input type="submit" name="btn_insert" title="登録" value="" class="btn_insert"  style="padding-right: 50px;">
						<input type="button" title="キャンセル" value="" class="btn_close" onclick="javascript:doClear()"  id="cancel" style="display:none">
					</p>
					<table class="tbl_search">
						<thead>
							<tr>
								<th width="150px">学年名</th>
								<th width="150px">学年名ふりがな</th>
								<th width="70px">表示順</th>
								<th width="200px">利用期間</th>
								<th width="200px">備考</th>
								<th class="td_img">編集</th>
								<th class="td_img">削除</th>
							</tr>
						</thead>
						<tbody>
						<?php if (!empty($_smarty_tpl->tpl_vars['list']->value)) {?>
							<?php
$_from = $_smarty_tpl->tpl_vars['list']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_result_0_saved_item = isset($_smarty_tpl->tpl_vars['result']) ? $_smarty_tpl->tpl_vars['result'] : false;
$_smarty_tpl->tpl_vars['result'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['result']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['result']->value) {
$_smarty_tpl->tpl_vars['result']->_loop = true;
$__foreach_result_0_saved_local_item = $_smarty_tpl->tpl_vars['result'];
?>
							<tr>
								<td width="150px"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->grade_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
								<td width="150px"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->grade_name_kana, ENT_QUOTES, 'UTF-8', true);?>
</td>
								<td width="70px"><?php echo $_smarty_tpl->tpl_vars['result']->value->disp_no;?>
</td>
								<td width="200px"><?php echo $_smarty_tpl->tpl_vars['result']->value->start_period;?>
～<?php echo $_smarty_tpl->tpl_vars['result']->value->end_period;?>
</td>
								<td width="200px"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->remarks, ENT_QUOTES, 'UTF-8', true);?>
</td>
								<td width="td_img">
									<input type="button" class="btn_edit" title="編集" onclick="edit_trans('<?php echo $_smarty_tpl->tpl_vars['result']->value->grade_no;?>
','<?php echo @constant('HOME_DIR');?>
GradeRegist/index')">
								</td>
								<td class="td_edit">
									<input type="button" class="btn_delete" title="削除" name="delete" onclick="del_trans('<?php echo $_smarty_tpl->tpl_vars['result']->value->grade_no;?>
','<?php echo @constant('HOME_DIR');?>
GradeRegist/delete')">
								</td>
							</tr>
							<?php
$_smarty_tpl->tpl_vars['result'] = $__foreach_result_0_saved_local_item;
}
if ($__foreach_result_0_saved_item) {
$_smarty_tpl->tpl_vars['result'] = $__foreach_result_0_saved_item;
}
?>
						<?php }?>
						</tbody>
					</table>
				</section>
			</div>
			<!--footer-->
				<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<!--footer-->
		</form>

		<?php echo '<script'; ?>
>
			

			var arr = [];
			<?php
$_from = $_smarty_tpl->tpl_vars['list']->value;
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
				arr.push(JSON.parse('<?php echo json_encode($_smarty_tpl->tpl_vars['value']->value);?>
'));
			<?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_1_saved_local_item;
}
if ($__foreach_value_1_saved_item) {
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_1_saved_item;
}
?>
			// 配列のインデックス
			var no = 0;

			/**
			*
			*  検索ボタン押下、必須チェック処理
			*
			**/
			$(".btn_insert").on('click', function(){

				$("#page").val(1);
				$(".error_section").hide();

				var start_period = document.getElementById('start_period').value;
				var end_period = document.getElementById('end_period').value;
				var grade_name = document.getElementById('grade_name').value;
				var grade_name_kana = document.getElementById('grade_name_kana').value;
				var disp_no = document.getElementById('disp_no').value;
				var remarks = document.getElementById('remarks').value;
				var grade_no = document.getElementById('grade_no').value;
				var initial_disp_no = document.getElementById('initial_disp_no').value;

				// 学年名の必須チェック
				if ( grade_name == "" ){

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("学年名を入力してください。");
					$('#err_dis')[0].focus();
					return false;
				}

				// 学年名ふりがなの必須チェック
				if ( grade_name_kana == "" ){

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("学年名ふりがなを入力してください。");
					$('#err_dis')[0].focus();
					return false;
				}

				// 表示順の必須チェック
				if ( disp_no == "" ){

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("表示順を入力してください。");
					$('#err_dis')[0].focus();
					return false;
				}

				for (  no = 0; no < $("#grade_cnt").val(); no++ ) {
					if ( initial_disp_no != disp_no && disp_no == arr[no].disp_no ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("表示順が重複しています。");
						$('#err_dis')[0].focus();
						return false;
					}
				}

				// 表示順は整数かどうかチェック
				if ( isNaN(disp_no) ){

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("表示順を数字で入力してください。");
					$('#err_dis')[0].focus();
					return false;
				}

				// 利用開始日の必須チェック
				if ( start_period == "" ){

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("利用開始日を入力してください。");
					$('#err_dis')[0].focus();
					return false;
				}

				// 利用終了日の必須チェック
				if ( end_period == "" ){

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("利用終了日を入力してください。");
					$('#err_dis')[0].focus();
					return false;
				}

				// 利用開始日 < 利用終了日チェック
				if ( start_period > end_period ){

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("<?php echo @constant('W004');?>
");
					$('#err_dis')[0].focus();
					return false;
				}

				// 備考の必須チェック
				if ( remarks == "" ){

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("備考を入力してください。");
					$('#err_dis')[0].focus();
					return false;
				}
				return true;
			});

			// ページング
			function doPage(pageNo){

				$("#page").val(pageNo);
				$("#main_form").submit();
			}

			// 編集ボタン処理
			function edit_trans(grade_no ,action){

				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;

				$("#main_form").attr("action", action);
				$("#menuOpen").val(menuOpen);
				$("#menuStatus").val(menuStatus);
				$("#grade_no").val(grade_no);

				setSearchFormData();
			}

			// 削除ボタン処理
			function del_trans(grade_no,action){

				var result = confirm("削除します。よろしいでしょうか。");

				if ( result ){

					//はいを選んだときの処理
					var menuOpen = document.getElementById('menuOpen').value;
					var menuStatus = document.getElementById('menuStatus').value

					$("#main_form").attr("action", action);
					$("#menuOpen").val(menuOpen);
					$("#menuStatus").val(menuStatus);
					$("#grade_no").val(grade_no);

					$("#main_form").submit();
				}else {
				 //いいえを選んだときの処理
				}
			}

			// キャンセルボタン処理
			function doClear(){

				$("#grade_no").val("");
				$("#grade_name").val("");
				$("#grade_name_kana").val("");
				$("#disp_no").val("");
				$("#remarks").val("");
				$("#start_period").val("");
				$("#end_period").val("");
			}

			// 戻るボタン処理
			function doBack(action){

				$("#main_form").attr("action", action);
				$("#main_form").submit();
			}

			/**
			**  検索条件セットとフォーム
			**/
			function setSearchFormData() {

				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;

				$("#menuOpen").val(menuOpen);
				$("#menuStatus").val(menuStatus);
				$("#search_page").val($("#search_page").val());
				$("#search_start_period").val($("#search_start_period").val());
				$("#search_end_period").val($("#search_end_period").val());
				$("#search_org_name").val($("#search_org_name").val());
				$("#search_chk_status").val($("#search_chk_status").val());

				$("#search_chk_status1").val("");
				if ( $("#chk_status1").prop('checked') ){
					$("#search_chk_status1").val(1);
				}

				$("#search_chk_status2").val("");
				if ( $("#chk_status2").prop('checked') ){
					$("#search_chk_status2").val(1);
				}

				$("#search_chk_status3").val("");
				if ( $("#chk_status3").prop('checked') ){
					$("#search_chk_status3").val(1);
				}
				$("#main_form").submit();
			}
			window.onload = function init() {

				var grade_no = document.getElementById('grade_no').value;
				if ( grade_no != "" ){

					$("#cancel").css("display","none");
				}else {

					$("#cancel").css("display","");
				}
			}
		
	<?php echo '</script'; ?>
>
	</body>
</html><?php }
}
