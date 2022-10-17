<?php
/* Smarty version 3.1.29, created on 2022-09-21 17:03:56
  from "/var/www/html/eccadmin_dev/templates/studentCourseDetailEdit.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_632ac56c8455c2_48186003',
  'file_dependency' => 
  array (
    '3227e76710c35f6a32187587cbf66e577631064e' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/studentCourseDetailEdit.html',
      1 => 1647423905,
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
function content_632ac56c8455c2_48186003 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate')) require_once '/var/www/html/eccadmin_dev/libs/smarty/libs/plugins/modifier.truncate.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<title>受講生コース詳細編集</title>
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
		<link href="<?php echo @constant('HOME_DIR');?>
css/style.css" rel="stylesheet">

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
					$('#stu_course_start_period').datepicker({
						showOn : "button",
						buttonImage : "<?php echo @constant('HOME_DIR');?>
image/calendar.svg",
						dateFormat: 'yy/mm/dd',
						buttonImageOnly : true,
						beforeShow: function (input, inst) {
							setTimeout(function () {
								var leftWidth=($('.pushmenu-open').length>0)?$('#stu_course_start_period').offset().left-$('.pushmenu-open')[0].offsetWidth
										:$('#stu_course_start_period').offset().left;
								inst.dpDiv.css({
									left: leftWidth
								});
							}, 0);
						}
					});
				});

				$(function() {
					$('#stu_course_end_period').datepicker({
						showOn : "button",
						buttonImage : "<?php echo @constant('HOME_DIR');?>
image/calendar.svg",
						dateFormat: 'yy/mm/dd',
						buttonImageOnly : true,
						beforeShow: function (input, inst) {
							setTimeout(function () {
								var leftWidth=($('.pushmenu-open').length>0)?$('#stu_course_end_period').offset().left-$('.pushmenu-open')[0].offsetWidth
										:$('#stu_course_end_period').offset().left;
								inst.dpDiv.css({
									left: leftWidth
								});
							}, 0);
						}
					});
				});

				// MSGのあるなし
				if ( $(".error_msg").html() != "" ) {

					$(".error_section").slideToggle('slow')
				}

				$(".close_icon").on('click',function(){

					$(".error_section").slideToggle('slow')

					$('#err_dis').slideToggle('slow')

				});
				/**
				*
				*  検索ボタン押下、必須チェック処理
				*
				**/
				$("#btn_insert").on('click',function(){

					$(".error_section").hide();

					var stu_course_start_period = document.getElementById('stu_course_start_period').value;
					var stu_course_end_period = document.getElementById('stu_course_end_period').value;
					var start_period = document.getElementById('start_period').value;
					var end_period = document.getElementById('end_period').value;

					// 利用開始の必須チェック
					if ( stu_course_start_period == "" ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("利用開始日を入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}
					// 利用開始日と利用終了日を更新する
					$("#course_start_period").val(document.getElementById('stu_course_start_period').value);
					$("#course_end_period").val(document.getElementById('stu_course_end_period').value);

					var isDisabled = $("#stu_course_start_period").prop('disabled');
					var today = new Date();
					var dd = today.getDate();
					var mm = today.getMonth()+1; //January is 0!
					var yyyy = today.getFullYear();
					if ( dd < 10 ){
						dd = '0' + dd
					}
					if ( mm < 10 ){
						mm = '0' + mm
					}
					today = yyyy + '/' + mm + '/' + dd;
					if ( !isDisabled ){

						if ( stu_course_start_period < today ){

							$('#err_dis').show();
							$(".error_section").slideToggle('slow');
							$(".error_msg").html("利用開始日は今日より以前の日付になっています。");
							$(".divBody").scrollTop(0);
							return false;
						}
					}

					if ( stu_course_end_period < today ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("利用終了日は今日より以前の日付になっています。");
						$(".divBody").scrollTop(0);
						return false;
					}

					// 利用終了の必須チェック
					if ( stu_course_end_period == "" ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("利用終了日を入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					// 利用開始 < 利用終了チェック
					if ( stu_course_start_period > stu_course_end_period ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("<?php echo @constant('W004');?>
");
						$(".divBody").scrollTop(0);
						return false;
					}

					if ( start_period > stu_course_start_period ){

						if ( start_period > stu_course_end_period ){

							$('#err_dis').show();
							$(".error_section").slideToggle('slow');
							$(".error_msg").html("利用開始日と利用終了日がコース期間に入っていません。");
							$(".divBody").scrollTop(0);
						}else {

							$('#err_dis').show();
							$(".error_section").slideToggle('slow');
							$(".error_msg").html("利用開始日がコース期間に入っていません。");
							$(".divBody").scrollTop(0);
						}
						return false;
					}

					if ( end_period < stu_course_end_period ){

						if ( end_period < stu_course_start_period ){

							$('#err_dis').show();
							$(".error_section").slideToggle('slow');
							$(".error_msg").html("利用開始日と利用終了日がコース期間に入っていません。");
							$(".divBody").scrollTop(0);
						}else {

							$('#err_dis').show();
							$(".error_section").slideToggle('slow');
							$(".error_msg").html("利用終了日がコース期間に入っていません。");
							$(".divBody").scrollTop(0);
						}
						return false;
					}

					return true;
				});

				$('.btn_back').on('click',function(){

					$(this).val('').attr('disabled','disabled');
					return true;
				});

				$('#main_form').submit(function(){
					$("input[type='submit']", this)
						.val("")
						.attr('disabled', 'disabled');
					return true;
				});
			});
		<?php echo '</script'; ?>
>
	</head>
	<body class="pushmenu-push">
		<form id="main_form" action="<?php echo @constant('HOME_DIR');?>
StudentCourseDetailEdit/Save" method="post">
			<input type="hidden" id="admin_no" name="admin_no"/>
			<input type="hidden" id="home_dir" value="<?php echo @constant('HOME_DIR');?>
" />
			<input type="hidden" id="page" name="page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->page;?>
" />
			<input type="hidden" id="org_no" name="org_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
" />
			<input type="hidden" id="offer_no" name="offer_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->offer_no;?>
" />
			<input type="hidden" id="org_id" name="org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_id;?>
" />
			<input type="hidden" id="course_id" name="course_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->course_id;?>
" />
			<input type="hidden" id="course_detail_no" name="course_detail_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->course_detail_no;?>
" />
			<input type="hidden" id="reset_start_period" name="reset_start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->stu_course_start_period;?>
" />
			<input type="hidden" id="reset_end_period" name="reset_end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->stu_course_end_period;?>
" />
			<input type="hidden" id="student_no" name="student_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->student_no;?>
" />
			<input type="hidden" id="course_start_period" name="course_start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->stu_course_start_period;?>
" />
			<input type="hidden" id="course_end_period" name="course_end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->stu_course_end_period;?>
" />
			<input type="hidden" id="start_period" name="start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->start_period;?>
" />
			<input type="hidden" id="end_period" name="end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->end_period;?>
" />

			<input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
" />
			<input type="hidden" id="search_org_id" name="search_org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_org_id;?>
" />
			<input type="hidden" id="search_start_period" name="search_start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_start_period;?>
" />
			<input type="hidden" id="search_end_period" name="search_end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_end_period;?>
" />
			<input type="hidden" id="search_course_id_from" name="search_course_id_from" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_course_id_from;?>
" />
			<input type="hidden" id="search_course_id_to" name="search_course_id_to" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_course_id_to;?>
" />
			<input type="hidden" id="search_login_id_from" name="search_login_id_from" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_login_id_from;?>
" />
			<input type="hidden" id="search_login_id_to" name="search_login_id_to" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_login_id_to;?>
" />
			<input type="hidden" id="back_flg" name="back_flg" />
			
			<input type="hidden" id="page_row_cccl" name="page_row_cccl" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->page_row_cccl;?>
" />
			<input type="hidden" id="page_order_column_cccl" name="page_order_column_cccl" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->page_order_column_cccl;?>
" />
			<input type="hidden" id="page_order_dir_cccl" name="page_order_dir_cccl" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->page_order_dir_cccl;?>
" />
			<input type="hidden" id="page_cccl" name="page_cccl" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->page_cccl;?>
" />
			<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:leftMenu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<div class="divHeader">
				<!--header-->
					<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

				<!--header-->
			</div>
			<div class="divBody">
				<div id="err_dis">
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
						><span class="title">SW 状況 / 受講生コース詳細編集</span>
					</p>
					<p style="text-align:right"><input type="button" title="戻る" value="" class="btn_back" onclick="javascript:doBack('<?php echo @constant('HOME_DIR');?>
CourseContractConfirmList/search')"></p>
					<table class="stu_cd_edit margin_btm20">
						<tr>
							<td><b>組織ID</b></td>
							<td><b>表示名</b></td>
							<td><b>正式名</b></td>
						</tr>
						<tr>
							<td class="input">
								<label><?php echo $_smarty_tpl->tpl_vars['form']->value->org_id;?>
</label>
							</td>
							<td class="input">
								<label><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->org_name, ENT_QUOTES, 'UTF-8', true);?>
</label>
							</td>
							<td class="input">
								<label><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->org_name_official, ENT_QUOTES, 'UTF-8', true);?>
</label>
							</td>
						</tr>
					</table>
					<div class="div_stucd_edit">
						<table class="stu_cd_edit">
							<tr>
								<td><b>コースID</b></td>
								<td><b>コース名</b></td>
								<td><b>コース期間</b></td>
							</tr>
							<tr>
								<td class="input">
									<label><?php echo $_smarty_tpl->tpl_vars['form']->value->course_id;?>
</label>
								</td>
								<td class="input">
									<label><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->course_name, ENT_QUOTES, 'UTF-8', true);?>
</label>
								</td>
								<td class="input">
									<label><?php echo $_smarty_tpl->tpl_vars['form']->value->start_period;?>
 ~ <?php echo $_smarty_tpl->tpl_vars['form']->value->end_period;?>
</label>
								</td>
							</tr>
						</table>
					</div>
					<table class="stu_cd_edit margin_btm20">
						<tr>
							<td><b>受講生ログインID</b></td>
							<td><b>受講生名</b></td>
							<td></td>
						</tr>
						<tr>
							<td class="input">
								<label><?php echo $_smarty_tpl->tpl_vars['form']->value->login_id;?>
</label>
							</td>
							<td class="input">
								<label><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->student_name, ENT_QUOTES, 'UTF-8', true);?>
</label>
							</td>
							<td>
								<label><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->student_name_romaji, ENT_QUOTES, 'UTF-8', true);?>
</label>
							</td>
						</tr>
						<!-- -->
					</table>
					<!-- コース契約一覧テーブル -->
					<table class="tbl_search">
						<tr>
							<th width="100px">回数</th>
							<th width="200px">名詳細</th>
							<th width="300px">受講期間</th>
							<th width="200px">受講日</th>
							<th class="200px">採点日</th>
						</tr>
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
								<td width="100px"><?php echo $_smarty_tpl->tpl_vars['result']->value->disp_no;?>
</td>
								<td width="200px"><?php echo smarty_modifier_truncate(htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->course_detail_name, ENT_QUOTES, 'UTF-8', true),25,'...');?>
</td>
								<td width="300px"><?php echo $_smarty_tpl->tpl_vars['result']->value->stu_course_start_period;?>
 ~ <?php echo $_smarty_tpl->tpl_vars['result']->value->stu_course_end_period;?>
</td>
								<td width="200px"><?php echo $_smarty_tpl->tpl_vars['result']->value->answer_dt;?>
</td>
								<td width="200px"><?php echo $_smarty_tpl->tpl_vars['result']->value->update_dt;?>
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
					</table>
					<br>
					<table>
						<tr>
							<td class="input" style="width:50px;"><label><?php echo $_smarty_tpl->tpl_vars['form']->value->disp_no;?>
</label></td>
							<td class="input" style="width:150px;"><label><?php echo $_smarty_tpl->tpl_vars['form']->value->course_detail_name;?>
</label></td>
							<td class="st_col">利用開始日<span class="required">※</span></td>
							<td class="input" style="width:250px;"><input class="text" type="text" name="stu_course_start_period" id="stu_course_start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->stu_course_start_period;?>
" maxlength="10" onchange="changeDateFormat(this)" style="height: 15px;"></td>
							<td width="10px"></td>
							<td class="st_col">利用終了日<span class="required">※</span></td>
							<td class="input"><input class="" type="text" name="stu_course_end_period" id="stu_course_end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->stu_course_end_period;?>
" maxlength="10" onchange="changeDateFormat(this)"></td>
						</tr>
					</table>
					<?php if ($_smarty_tpl->tpl_vars['form']->value->retake_flg == "1") {?>
						<input type="button" id="btn_retake" name="btn_retake" title="再受講" value="" class="btn_retake" style="padding-right: 50px;" onclick="javascript:doRetake('<?php echo @constant('HOME_DIR');?>
StudentCourseDetailEdit/retake')">
					<?php }?>
					<div align="right" style="width:100%">
						<p style="text-align:right;">
							<!-- 20190621-コース・コース詳細を削除処理で受講済みかどうかのチェック -->
							<?php if ($_smarty_tpl->tpl_vars['form']->value->answer_dt != '') {?>
								<!-- 受講済みの場合、削除ボタンを無効にする -->
								<input type="submit" id="btn_insert" name="insert" title="登録" value="" class="btn_insert" disabled="disabled" style="padding-right: 50px;">
							<?php } else { ?>
								<!-- 未受講の場合、削除ボタンを有効にする -->
								<input type="submit" id="btn_insert" name="insert" title="登録" value="" class="btn_insert" style="padding-right: 50px;">
							<?php }?>

							<input type="button" id="cancel" title="キャンセル" class="btn_close" style="padding-right: 50px;" onclick="javascript:doClear()" >

							<!-- 20190618-コース・コース詳細を削除処理で受講済みかどうかのチェック -->
							<?php if ($_smarty_tpl->tpl_vars['form']->value->answer_dt != '') {?>
								<!-- 受講済みの場合、削除ボタンを無効にする -->
								<input type="button" id="btn_delete" name="btn_delete" title="削除" class="btn_delete" disabled="disabled" onclick="javascript:doDelete('<?php echo @constant('HOME_DIR');?>
StudentCourseDetailEdit/delete')">
							<?php } else { ?>
								<!-- 未受講の場合、削除ボタンを有効にする -->
								<input type="button" id="btn_delete" name="btn_delete" title="削除" class="btn_delete" onclick="javascript:doDelete('<?php echo @constant('HOME_DIR');?>
StudentCourseDetailEdit/delete')">
							<?php }?>
						</p>
					</div>
				</section>
			</div>
			<!--footer-->
				<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<!--footer-->
		</form>

		<?php echo '<script'; ?>
>
			

			//キャンセルボタン
			function doClear() {

				$("#stu_course_start_period").val(document.getElementById("reset_start_period").value);
				$("#stu_course_end_period").val(document.getElementById("reset_end_period").value);
			}

			//戻るボタン
			function doBack(action) {
				$("#back_flg").val("true");
				$("#main_form").attr("action", action);
				$("#main_form").submit();
			}
			/*datepickerを無効にする*/
			window.onload = function init() {
				var today = new Date();
				var dd = today.getDate();
				var mm = today.getMonth()+1; //January is 0!
				var yyyy = today.getFullYear();
				if(dd<10) {
					dd = '0'+dd
				}
				if(mm<10) {
					mm = '0'+mm
				}
				today = yyyy + '/' + mm + '/' + dd;
				var stu_course_start_period = document.getElementById('stu_course_start_period').value;
				if(stu_course_start_period < today){
					$( "#stu_course_start_period" ).datepicker( "option", "disabled", true );
					document.getElementById("stu_course_start_period").disabled = true;
				}
			}

			function doDelete(action){

				var result = confirm("削除します。よろしいでしょうか。");

				if (result){
					var menuOpen = document.getElementById('menuOpen').value;
					var menuStatus = document.getElementById('menuStatus').value;

					$("#menuOpen").val(menuOpen);
					$("#menuStatus").val(menuStatus);
					$("#main_form").attr("action", action);
					$("#main_form").submit();
				}
			}
			
			function doRetake(action){

				var result = confirm("再受講の設定をします。よろしいでしょうか。") ;

				if (result){
					var menuOpen = document.getElementById('menuOpen').value;
					var menuStatus = document.getElementById('menuStatus').value;

					$("#menuOpen").val(menuOpen);
					$("#menuStatus").val(menuStatus);
					$("#main_form").attr("action", action);
					$("#main_form").submit();
				}
			}

		
	<?php echo '</script'; ?>
>
	</body>
</html><?php }
}
