<?php
/* Smarty version 3.1.29, created on 2022-09-21 15:52:35
  from "/var/www/html/eccadmin_dev/templates/courseContractRegist.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_632ab4b3b43d27_91347924',
  'file_dependency' => 
  array (
    '8dffba210c65e318f5799449d15fb7426556e664' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/courseContractRegist.html',
      1 => 1654753220,
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
function content_632ab4b3b43d27_91347924 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
	<head>
		<title>コース契約登録</title>
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
					$('#start_period').datepicker({
						showOn : "button",
						buttonImage : "<?php echo @constant('HOME_DIR');?>
image/calendar.svg",
						dateFormat: 'yy/mm/dd',
						buttonImageOnly : true,
						beforeShow: function (input, inst) {
							var leftWidth=($('.pushmenu-open').length>0)?$('#start_period').offset().left-$('.pushmenu-open')[0].offsetWidth
									:$('#start_period').offset().left;
							setTimeout(function () {
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
							var leftWidth=($('.pushmenu-open').length>0)?$('#end_period').offset().left-$('.pushmenu-open')[0].offsetWidth
									:$('#end_period').offset().left;
							setTimeout(function () {
								inst.dpDiv.css({
									top: $('#end_period').offset().top + 35,
									left: leftWidth
								});
							}, 0);
						}
					});
				});

				$(".btn_insert").on('click', function() {

					var today = moment().format('Y/MM/DD');
					$(".error_section").hide();
					$('#err_dis').hide();

					var org_id = document.getElementById('org_id').value;
					var se_course_id = document.getElementById('se_course_id').value;
					var course_id = document.getElementById('course_id').value;
					var start_period = document.getElementById('start_period').value;
					var dt_st = new Date(start_period);
					dt_st.setFullYear(dt_st.getFullYear()+1);
					var oneyear = moment(dt_st).format('Y/MM/DD');
					var end_period = document.getElementById('end_period').value;
					var remarks = document.getElementById('remarks').value;
					var show_flg = $('input[name=show_flg]:checked').val();
					
					$('#fb_show_flg').val(show_flg);

					var isDisabled = $("#start_period").prop('disabled');

					// コース名の必須チェック
					if ( org_id == "" ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("組織ログインIDを入力してください。");
						return false;
					}

					// 読みの必須チェック
					if ( course_id == "" ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("コースIDを入力してください。");
						return false;
					}

					// 利用開始の必須チェック
					if ( start_period == "" ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("コース期間開始日を入力してください。");
						return false;
					}

					if ( !isDisabled ){

						if ( start_period < today ){

							$('#err_dis').show();
							$(".error_section").slideToggle('slow');
							$(".error_msg").html("コース期間開始日は今日より以前の日付になっています。");
							return false;
						}
					}

					// 利用終了の必須チェック
					if ( end_period == "" ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("コース期間終了日を入力してください。");
						return false;
					}
					// 一年以内のチェックを外す 2022/04/04 Cherry
				/* 	if ( end_period > oneyear ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("コース期間終了日は開始日より１年以内の日付を入力してください。");
						return false;
					} */

					// 利用開始 < 利用終了 をチェック
					if ( start_period > end_period ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("コース期間開始日 ≦ コース期間終了日 を正しく入力してください。");
						return false;
					}

					if ( remarks == "" ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("申込番号等（備考）を入力してください。");
						return false;
					}
					
					if ( show_flg == "" ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("結果表示を選択してください。");
						return false;
					}
					
					$("#start_period").datepicker( "option", "disabled", false );
					$("#org_id").attr( "disabled", false );
					$("#course_id").attr( "disabled", false );
					return true;
				});

				// MSGのあるなし
				if ( $(".error_msg").html() != "" ){

					$(".error_section").slideToggle('slow')
				}

				$(".close_icon").on('click', function(){

					$(".error_section").slideToggle('slow')

					$('#err_dis').slideToggle('slow')

				});

				$('#org_display').on('click',function(){

					var org_id = document.getElementById('org_id').value;
					if ( org_id != "" ) {

						$(this).val('').attr('disabled','disabled');
						return true;
					}
				});

				$('#course_display').on('click',function(){

					var course_id = document.getElementById('course_id').value;
					if ( course_id != "" ) {

						$(this).val('').attr('disabled','disabled');
						return true;
					}
				});

				$('#btn_courseStudentRegist').on('click',function(){

					$(this).val('').attr('disabled','disabled');
					return true;
				});
			});
		<?php echo '</script'; ?>
>
	</head>
	<body class="pushmenu-push">
		<form id="main_form" action="<?php echo @constant('HOME_DIR');?>
CourseContractRegist/save" method="post">
			<input type="hidden" id="back_flg" name="back_flg" value="false" />
			<input type="hidden" id="org_no" name="org_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
"/>
			<input type="hidden" id="se_course_id" name="se_course_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->se_course_id;?>
"/>
			<input type="hidden" id="org_name" name="org_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_name;?>
"/>
			<input type="hidden" id="org_name_official" name="org_name_official" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_name_official;?>
"/>
			<input type="hidden" id="course_name" name="course_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->course_name;?>
"/>
			<input type="hidden" id="offer_no" name="offer_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->offer_no;?>
"/>
			<input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
"/>
			<input type="hidden" id="search_end_period" name="search_end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_end_period;?>
"/>
			<input type="hidden" id="search_start_period" name="search_start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_start_period;?>
"/>
			<input type="hidden" id="reset_end_period" name="reset_end_period" value="<?php echo $_smarty_tpl->tpl_vars['reset_end_period']->value;?>
"/>
			<input type="hidden" id="reset_start_period" name="reset_start_period" value="<?php echo $_smarty_tpl->tpl_vars['reset_start_period']->value;?>
"/>
			<input type="hidden" id="search_course_name" name="search_course_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->search_course_name, ENT_QUOTES, 'UTF-8', true);?>
"/>
			<input type="hidden" id="search_org_id" name="search_org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_org_id;?>
"/>
			<input type="hidden" id="search_org_name" name="search_org_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_org_name;?>
"/>
			<input type="hidden" id="search_test_kbn" name="search_test_kbn" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_test_kbn;?>
"/>
			<input type="hidden" id="search_course_level" name="search_course_level" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_course_level;?>
"/>
			<input type="hidden" id="error_msg" name="error_msg" value="<?php echo $_smarty_tpl->tpl_vars['error_msg']->value;?>
"/>
			<input type="hidden" id="info_msg" name="info_msg" value="<?php echo $_smarty_tpl->tpl_vars['info_msg']->value;?>
"/>
			<input type="hidden" id="contract_start_period" name="contract_start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->contract_start_period;?>
"/>
			<input type="hidden" id="home_dir" value="<?php echo @constant('HOME_DIR');?>
" />
			<input type="hidden" id="fb_show_flg" name="fb_show_flg" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->fb_show_flg;?>
" />
			
			<input type="hidden" id="page_row_ccl" name="page_row_ccl" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->page_row_ccl;?>
" />
			<input type="hidden" id="page_order_column_ccl" name="page_order_column_ccl" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->page_order_column_ccl;?>
" />
			<input type="hidden" id="page_order_dir_ccl" name="page_order_dir_ccl" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->page_order_dir_ccl;?>
" />
			<input type="hidden" id="page_ccl" name="page_ccl" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->page_ccl;?>
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
					<p>><span class="title">コース契約登録</span></p>
					<p style="text-align:right"><input type="button" title="戻る" value="" class="btn_back" onclick="javascript:doBack('<?php echo @constant('HOME_DIR');?>
CourseContractList/search')"></p>
				<table>
					<tr>
						<td style="width:180px;">
							<label class="lbl_name" >組織ログインID<span class="required">※</span></label>
						</td>
						<td>
							<input id="org_id" name="org_id" type="text" class="text" maxlength="10" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_id;?>
" >
						</td>
						<td style="width:70px;">
							<input type="button" class="btn_qa_assign" name="btn_qa_assign" id="org_display" onclick="javascript:showOrg('<?php echo @constant('HOME_DIR');?>
CourseContractRegist/orgShow')" style="display: none;">
						</td>
						<td id="abc" >
							<label class="lbl_name" ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->org_name, ENT_QUOTES, 'UTF-8', true);?>
</label>
						</td>
						<td id="abc">
							<label class="lbl_name" ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->org_name_official, ENT_QUOTES, 'UTF-8', true);?>
</label>
						</td>
					</tr>
					<tr>
						<td style="width:180px;">
							<label class="lbl_name" >コースID<span class="required">※</span></label>
						</td>
						<td>
							<input id="course_id" name="course_id" type="text" class="text" maxlength="10" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->course_id;?>
" >
						</td>
						<td>
							<input type="button" class="btn_qa_assign" name="btn_quizassign" id="course_display" onclick="javascript:showCourse('<?php echo @constant('HOME_DIR');?>
CourseContractRegist/courseShow')" style="display: none;">
						</td>
						<td>
							<label class="lbl_name" ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->course_name, ENT_QUOTES, 'UTF-8', true);?>
</label>
						</td>
						<td></td>
					</tr>
				</table>
				<div id="div_rt_area" style="margin-top: 50px; padding-top: 10px;">
					<table style="width: 100%;">
						<tr>
							<td style="width:180px;">
								<label class="lbl_name" >コース期間開始日<span class="required">※</span></label>
							</td>
							<td>
								<input class="text" type="text" name="start_period" id="start_period"
								value="<?php echo $_smarty_tpl->tpl_vars['form']->value->start_period;?>
" maxlength="10" onchange="changeDateFormat(this)" style="height: 15px;">
							</td>
							<td style="width:180px;">
								<label class="lbl_name" >~　コース期間終了日<span class="required">※</span></label>
							</td>
							<td>
								<input class="" type="text" name="end_period" id="end_period"
								value="<?php echo $_smarty_tpl->tpl_vars['form']->value->end_period;?>
" maxlength="10" onchange="changeDateFormat(this)">
							</td>
						</tr>
						<tr>
							<td style="width:180px;">
								<label class="lbl_name" >申込番号等（備考）<span class="required">※</span></label>
							</td>
							<td>
								<input id="remarks" name="remarks" type="text" class="text_box" maxlength="512" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->remarks, ENT_QUOTES, 'UTF-8', true);?>
" >
							</td>
							<td style="width:180px;">
								<label class="lbl_name" >結果表示<span class="required">※</span></label>
							</td>
							<td>
								<?php if ($_smarty_tpl->tpl_vars['form']->value->fb_show_flg == 1) {?>
									<input type="radio" name="show_flg" value="1" id="show_flg1" checked />
									<label for="show_flg1">しない </label>
									<input type="radio" name="show_flg" value="0" id="show_flg2"  /> 
									<label for="show_flg2">する</label> 
								<?php } else { ?>
									<input type="radio" name="show_flg" value="1" id="show_flg1"  /> 
									<label for="show_flg1">しない </label>
									<input type="radio" name="show_flg" value="0" id="show_flg2" checked /> 
									<label for="show_flg2">する</label>
								<?php }?>
							</td>
							<td></td>
						</tr>
					</table>
				</div>
				<p style="text-align:right;">
					<input type="submit" name="insert" title="登録" value="" class="btn_insert" style="padding-right: 50px;">
					<!-- <input type="button" title="キャンセル" value="" class="btn_back" onclick="javascript:doClear()" id="cancel" style="display:none"> -->
				</p>
				<p style="text-align:left;padding-top:50px;">
					<input type="button" class="btn_qa_assign" style ="text-align:left;padding-right: 50px;"id ="btn_courseStudentRegist" title="受講生登録" name="student_regist" onclick="transfer('<?php echo @constant('HOME_DIR');?>
CourseStudentRegist/index')">
					<!--20220309_事業部担当者対応-->
					<?php if ($_smarty_tpl->tpl_vars['admin_kbn']->value != "005") {?>
						<input type="button" class="btn_delete" style="float:right;padding-right: 50px;" id ="btn_delete" title="削除" name="delete" onclick="del_trans('<?php echo @constant('HOME_DIR');?>
CourseContractRegist/delete')">
					<?php }?>
				</p>
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

				 $("#course_name").val("");
				 $("#course_name_romaji").val("");
				 $("#test_kbn").val("");
				 $("#course_level").val("");
				 $("#start_period").val(document.getElementById("reset_start_period").value);
				 $("#end_period").val(document.getElementById("reset_end_period").value);
				 document.getElementById("status2").checked = true;
			}

			//戻るボタン
			function doBack(action) {

				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;

				$("#main_form").attr("action", action);
				$("#menuOpen").val(menuOpen);
				$("#menuStatus").val(menuStatus);
				$("#search_course_name").val(document.getElementById('search_course_name').value);
				$("#search_page").val(document.getElementById('search_page').value);
				$("#back_flg").val("true");

				$("#main_form").submit();
			}

			// 組織情報表示ボタン
			function showOrg(action){

				var org_id = document.getElementById('org_id').value;
				if ( org_id == "" ) {

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("組織ログインIDを入力してください。");
					return false;
				}else{

					var menuOpen = document.getElementById('menuOpen').value;
					var menuStatus = document.getElementById('menuStatus').value;

					$("#main_form").attr("action", action);
					$("#menuOpen").val(menuOpen);
					$("#menuStatus").val(menuStatus);
					$("#main_form").submit();
				}
			}

			// コース情報表示ボタン
			function showCourse(action){

				var course_id = document.getElementById('course_id').value;
				if ( course_id == "" ) {

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("コースIDを入力してください。");
					return false;
				}else{

					var menuOpen = document.getElementById('menuOpen').value;
					var menuStatus = document.getElementById('menuStatus').value;

					$("#main_form").attr("action", action);
					$("#menuOpen").val(menuOpen);
					$("#menuStatus").val(menuStatus);
					$("#main_form").submit();
				}
			}

			// 削除ボタン
			function del_trans(action){

				var result = confirm("削除します。よろしいでしょうか。");

				if ( result ){
				  //はいを選んだときの処理
					var menuOpen = document.getElementById('menuOpen').value;
					var menuStatus = document.getElementById('menuStatus').value;

					$("#main_form").attr("action", action);
					$("#menuOpen").val(menuOpen);
					$("#menuStatus").val(menuStatus);

					$("#main_form").submit();
				}else {
				 //いいえを選んだときの処理
				}
			}

			function transfer(action){


				$("#start_period").datepicker( "option", "disabled", false );
				$("#org_id").attr( "disabled", false );
				$("#course_id").attr( "disabled", false );
				var start_period = $("#start_period").val();
				$("#contract_start_period").val(start_period);

				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;

				$("#main_form").attr("action", action);
				$("#menuOpen").val(menuOpen);
				$("#menuStatus").val(menuStatus);

				$("#main_form").submit();
			}

			window.onload = function init() {

				var course_id = document.getElementById('course_id').value;
				if ( course_id != "" ) {

					$("#cancel").css("display","none");
				}else {

					$("#cancel").css("display","");
				}
				var org_no = document.getElementById('org_no').value;
				var offer_no = document.getElementById('offer_no').value;
				if ( org_no != "" && offer_no != "" ) {

					$("#org_display").css("display","none");
					$("#btn_delete").css("display","");
					$("#btn_courseStudentRegist").css("display","");
					$("#org_id").prop("disabled",true);
					$("#course_id").prop("disabled",true);

					var today = moment().format('Y/MM/DD');
					var start_period = document.getElementById('start_period').value;

					if ( start_period < today ){

						$("#start_period").datepicker( "option", "disabled", true );
					}
				}else {

					$("#org_display").css("display","");

					$("#btn_delete").css("display","none");
					$("#btn_courseStudentRegist").css("display","none");
				}

				var se_course_id = document.getElementById('se_course_id').value;

				if ( se_course_id != "") {

					$("#course_display").css("display","none");
				}else {

					$("#course_display").css("display","");
				}
			}
			
		<?php echo '</script'; ?>
>
	</body>
</html><?php }
}
