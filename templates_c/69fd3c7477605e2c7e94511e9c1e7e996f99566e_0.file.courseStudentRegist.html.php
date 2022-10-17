<?php
/* Smarty version 3.1.29, created on 2022-09-21 15:52:19
  from "/var/www/html/eccadmin_dev/templates/courseStudentRegist.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_632ab4a3d8b734_10521661',
  'file_dependency' => 
  array (
    '69fd3c7477605e2c7e94511e9c1e7e996f99566e' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/courseStudentRegist.html',
      1 => 1656988615,
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
function content_632ab4a3d8b734_10521661 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
	<head>
		<title>コース受講生登録</title>
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

			var date = new Date();
			var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();

			$(function() {
				$('.course_detail_start_period').datepicker({
					showOn : "button",
					buttonImage : "<?php echo @constant('HOME_DIR');?>
image/calendar.svg",
					dateFormat: 'yy/mm/dd',
					buttonImageOnly : true,
					beforeShow: function (input, inst) {
                         var id = $(this).attr("id");
						 id = id.split("course_detail_start_period")[1];
						 //開始日時二つの中で最初の date Picker の設定
						 if ( id == "0"){
							 setTimeout(function () {
								 var leftWidth=($('.pushmenu-open').length>0)?$('.course_detail_start_period').offset().left-$('.pushmenu-open')[0].offsetWidth
										 :$('.course_detail_start_period').offset().left;
								inst.dpDiv.css({
									top: $('.course_detail_start_period').offset().top + 35,
									left: leftWidth
								});
							 }, 0);
						 }else {
							//次の date Picker の設定
							 setTimeout(function () {
									 var leftWidth=($('.pushmenu-open').length>0)?$('.course_detail_start_period').offset().left-$('.pushmenu-open')[0].offsetWidth
											 :$('.course_detail_start_period').offset().left;
									inst.dpDiv.css({
										top: $("#course_detail_start_period"+id).offset().top + 35,
										left: leftWidth
									});
								 }, 0);
						 }
                     }
				});
			});

			$(function() {
				$('.course_detail_end_period').datepicker({
					showOn : "button",
					buttonImage : "<?php echo @constant('HOME_DIR');?>
image/calendar.svg",
					dateFormat: 'yy/mm/dd',
					buttonImageOnly : true,
					beforeShow: function (input, inst) {
                        var id = $(this).attr("id");
						id = id.split("course_detail_end_period")[1];
						//終了日時二つの中で最初の date Picker の設定
						if ( id == "0" ){
							 setTimeout(function () {
								 var leftWidth=($('.pushmenu-open').length>0)?$('.course_detail_end_period').offset().left-$('.pushmenu-open')[0].offsetWidth
										 :$('.course_detail_end_period').offset().left;
								inst.dpDiv.css({
									top: $('.course_detail_end_period').offset().top + 35,
									left: leftWidth
								});
							 }, 0);
						 }else{
							 setTimeout(function () {
								 var leftWidth=($('.pushmenu-open').length>0)?$('.course_detail_end_period').offset().left-$('.pushmenu-open')[0].offsetWidth
										 :$('.course_detail_end_period').offset().left;
								inst.dpDiv.css({
									top: $("#course_detail_end_period"+id).offset().top + 35,
									left: leftWidth
								});
							}, 0);
						 }
                     }
				});
			});

			var spacesToAdd = 5;
			var biggestLength = 0;
			$("#left_student_list option").each(function(){
			var len = $(this).text().length;
				if ( len > biggestLength ){

					biggestLength = len;
				}
			});
			var padLength = biggestLength + spacesToAdd;
			padLength = 26;
			$("#left_student_list option").each(function(){
				var parts = $(this).text().split('-');
				var strLength = parts[0].length;
				for ( var x=0; x<(padLength-strLength); x++ ){
					parts[0] = parts[0]+' ';
				}
				$(this).text(parts[0].replace(/ /g, '\u00a0')+''+parts[1]).text;
			});

			// MSGのあるなし
			if ( $(".error_msg").html() != "" ) {

				$(".error_section").slideToggle('slow');
			}

			$(".close_icon").on('click', function(){

				$(".error_section").slideToggle('slow')
			});

			$('.btn_search').on('click',function(){

				$(this).val('').attr('disabled','disabled');
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
		<form autocomplete="off" id="main_form" action="<?php echo @constant('HOME_DIR');?>
CourseStudentRegist/Save" method="post">
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
						><span class="title">コース契約登録/受講生登録</span>
					</p>
					<p style="text-align:right"><input type="button" title="戻る" value="" class="btn_back" onclick="javascript:doBack('<?php echo @constant('HOME_DIR');?>
CourseContractRegist/index')"></p>
					<input type="hidden" id="home_dir" value="<?php echo @constant('HOME_DIR');?>
" />
					<input type="hidden" id="search_group" name="search_group"/>
					<input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
" />
					<input type="hidden" id="search_login_id" name="search_login_id" />
					<input type="hidden" id="search_org_id" name="search_org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_org_id;?>
" />
					<input type="hidden" id="search_org_name" name="search_org_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_org_name;?>
" />
					<input type="hidden" id="search_test_kbn" name="search_test_kbn" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_test_kbn;?>
" />
					<input type="hidden" id="search_course_level" name="search_course_level" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_course_level;?>
" />
					<input type="hidden" id="search_course_name" name="search_course_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_course_name;?>
" />
					<input type="hidden" name="student_noString" id="student_noString" value="" />
					<input type="hidden" name="course_noString" id="course_noString" value="" />
					<input type="hidden" name="course_dt_start_period" id="course_dt_start_period" value="" />
					<input type="hidden" name="course_dt_end_period" id="course_dt_end_period" value="" />
					<input type="hidden" name="se_course_id" id="se_course_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->course_id;?>
" />
					<input type="hidden" name="org_id" id="org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_id;?>
" />
					<input type="hidden" name="offer_no" id="offer_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->offer_no;?>
" />
					<input type="hidden" name="remarks" id="remarks" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->remarks;?>
" />
					<input type="hidden" name="contract_start_period" id="contract_start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->contract_start_period;?>
" />
					<input type="hidden" name="contract_end_period" id="contract_end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->contract_end_period;?>
" />
					<input type="hidden" name="contract_list_start_period" id="contract_list_start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->contract_list_start_period;?>
" />
					<input type="hidden" name="contract_list_end_period" id="contract_list_end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->contract_list_end_period;?>
" />
					<input type="hidden" name="btn_flg" id="btn_flg" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->btn_flag;?>
" />
					<input type="hidden" name="course_dt_list" id="course_dt_list" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->course_dt_list;?>
" />
					
					<input type="hidden" id="page_row_ccl" name="page_row_ccl" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->page_row_ccl;?>
" />
					<input type="hidden" id="page_order_column_ccl" name="page_order_column_ccl" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->page_order_column_ccl;?>
" />
					<input type="hidden" id="page_order_dir_ccl" name="page_order_dir_ccl" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->page_order_dir_ccl;?>
" />
					<input type="hidden" id="page_ccl" name="page_ccl" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->page_ccl;?>
" />

					<table>
						<tr>
							<td style="width:200px;">組織ログインID</td>
							<td style="width:150px;"><?php echo $_smarty_tpl->tpl_vars['form']->value->org_id;?>
</td>
							<td style="width:250px;"><?php echo $_smarty_tpl->tpl_vars['form']->value->org_name;?>
</td>
							<td style="width:300px;"><?php echo $_smarty_tpl->tpl_vars['form']->value->org_name_official;?>
</td>
						</tr>
						<tr>
							<td style="width:200px;">コースID</td>
							<td style="width:150px;"><?php echo $_smarty_tpl->tpl_vars['form']->value->course_id;?>
</td>
							<td style="width:250px;"><?php echo $_smarty_tpl->tpl_vars['form']->value->course_name;?>
</td>
							<td style="width:300px;"><?php echo $_smarty_tpl->tpl_vars['form']->value->course_name_romaji;?>
</td>
						</tr>
					</table>
					<br>
					<table>
						<tr>
							<td style="width:200px;">コース期間</td>
							<td style="width:100px;" class="course_start_period"><?php echo $_smarty_tpl->tpl_vars['form']->value->start_period;?>
</td>
							<td style="width:40px;">~</td>
							<td style="width:100px;" class="course_end_period"><?php echo $_smarty_tpl->tpl_vars['form']->value->end_period;?>
</td>
						</tr>
					</table>
					<?php if (!empty($_smarty_tpl->tpl_vars['course_detail_list']->value)) {?>
					<hr>
					<table>
						<td style="width:200px;">コース詳細受講日設定</td>
						<td>
							<table class="course_list"><?php $_smarty_tpl->tpl_vars['flag'] = new Smarty_Variable(false, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'flag', 0);?>
								<?php
$_from = $_smarty_tpl->tpl_vars['course_detail_list']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_course_detail_0_saved_item = isset($_smarty_tpl->tpl_vars['course_detail']) ? $_smarty_tpl->tpl_vars['course_detail'] : false;
$__foreach_course_detail_0_saved_key = isset($_smarty_tpl->tpl_vars['key']) ? $_smarty_tpl->tpl_vars['key'] : false;
$_smarty_tpl->tpl_vars['course_detail'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['key'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['course_detail']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['course_detail']->value) {
$_smarty_tpl->tpl_vars['course_detail']->_loop = true;
$__foreach_course_detail_0_saved_local_item = $_smarty_tpl->tpl_vars['course_detail'];
?>
									<tr>
										<td style="padding:0 10px;" class="course_detail_no"><?php echo $_smarty_tpl->tpl_vars['course_detail']->value->course_detail_no;?>
</td>
										<td style="padding:0 30px;" class="course_detail_name"><?php echo $_smarty_tpl->tpl_vars['course_detail']->value->course_detail_name;?>
</td>
										<td style="padding:0 30px;">
											<input type="text" class="course_detail_start_period" id="course_detail_start_period<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" name="course_detail_start_period" value="<?php echo $_smarty_tpl->tpl_vars['course_detail']->value->start_period;?>
" maxlength="10" onchange="changeDateFormat(this)">
										</td>
										<td style="padding:0 30px;">~</td>
										<td>
										<input type="text" class="course_detail_end_period" id="course_detail_end_period<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" name="course_detail_end_period" value="<?php echo $_smarty_tpl->tpl_vars['course_detail']->value->end_period;?>
" maxlength="10" onchange="changeDateFormat(this)">
										</td>
										<td style="align:right;padding-left:30px">
										<?php if (empty($_smarty_tpl->tpl_vars['course_detail']->value->teacher_no)) {?>
											<?php $_smarty_tpl->tpl_vars['flag'] = new Smarty_Variable(true, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'flag', 0);?>
										 <span style="color:red;">※採点講師未設定</span>
										<?php }?>
										</td>
									</tr>
								<?php
$_smarty_tpl->tpl_vars['course_detail'] = $__foreach_course_detail_0_saved_local_item;
}
if ($__foreach_course_detail_0_saved_item) {
$_smarty_tpl->tpl_vars['course_detail'] = $__foreach_course_detail_0_saved_item;
}
if ($__foreach_course_detail_0_saved_key) {
$_smarty_tpl->tpl_vars['key'] = $__foreach_course_detail_0_saved_key;
}
?>
							</table>
						</td>
					</table>
					<hr>
					<table>
						<tr>
							<td style="width:200px;">受講生選択</td>
							<td>
								<table>
									<td>グループ</td>
									<td style="padding:0 30px;">
										<input class="text" type="text" name="group_name" id="group_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->group_name;?>
" maxlength = "32" size="30">
									</td>
									<td>ログインID</td>
									<td style="padding:0 30px;">
										<input class="text" type="text" name="login_id"" id="login_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->login_id;?>
" maxlength = "32" size="30">
									</td>
									<td>
										<input type="button" class="btn_search" onclick="trans('<?php echo @constant('HOME_DIR');?>
CourseStudentRegist/search')" title="検索" style="padding-right:50px;">
									</td>
								</table>
							</td>
						</tr>
					</table>
					<table style="margin:50px auto;">
						<tr>
							<td>
								<select multiple name="left_student_list" id = "left_student_list" class="left_student_list">
									<?php if (!empty($_smarty_tpl->tpl_vars['studentList']->value)) {?>
										<?php
$_from = $_smarty_tpl->tpl_vars['studentList']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_student_1_saved_item = isset($_smarty_tpl->tpl_vars['student']) ? $_smarty_tpl->tpl_vars['student'] : false;
$_smarty_tpl->tpl_vars['student'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['student']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['student']->value) {
$_smarty_tpl->tpl_vars['student']->_loop = true;
$__foreach_student_1_saved_local_item = $_smarty_tpl->tpl_vars['student'];
?>
											<option value="<?php echo $_smarty_tpl->tpl_vars['student']->value->student_no;?>
">
											<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['student']->value->login_id, ENT_QUOTES, 'UTF-8', true);?>
-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['student']->value->student_name, ENT_QUOTES, 'UTF-8', true);?>
</option>
										<?php
$_smarty_tpl->tpl_vars['student'] = $__foreach_student_1_saved_local_item;
}
if ($__foreach_student_1_saved_item) {
$_smarty_tpl->tpl_vars['student'] = $__foreach_student_1_saved_item;
}
?>
									<?php }?>
								</select>
							</td>
							<td style="text-align: center;padding:0 60px;">
								<a href="javascript:moveToRight()">
								<img src="<?php echo @constant('HOME_DIR');?>
image/add.svg" style="width:25px;height:25px;"/></a>
								<br/>
								<a href="javascript:moveToLeft()">
								<img src="<?php echo @constant('HOME_DIR');?>
image/minus.svg" style="width:25px;height:25px;"/></a>
							</td>
							<td>
								<select multiple name="right_student_list" id ="right_student_list" class="right_student_list">
								</select>
							</td>
						</tr>
					</table>
					<p style="text-align:right;">
						<?php if ($_smarty_tpl->tpl_vars['flag']->value == false) {?>
						<input type="submit" name="btn_insert" title="登録" value="" class="btn_insert"  style="padding-right: 50px;">
						<?php }?>
					</p>
					<?php }?>
				</section>
			</div>
		</form>

		<?php echo '<script'; ?>
 type="text/javascript">
		

			//戻るボタン
			function doBack(action) {

				$("#main_form").attr("action", action);
				$("#main_form").submit();
			}

			function trans(action){

				addDataForDate();

				$("#search_group").val($("#group_name").val());
				$("#search_login_id").val($("#login_id").val());
				$("#main_form").attr("action", action);
				$("#main_form").submit();
			}

			function addDataForDate(){

				var courseDt = "";
				var count = 0, tableLength = $('.course_list tr').length;
				$('.course_list tr').each(function() {
					var courseDetailNo = $(this).find(".course_detail_no").text();
					var startPeriod = $(this).find(".course_detail_start_period").val();
					var endPeriod = $(this).find(".course_detail_end_period").val();

					courseDt += courseDetailNo + "," + startPeriod + "," + endPeriod;
					count++;

					if(count < tableLength){
						courseDt += "|";
					}
				});
				$("#course_dt_list").val(courseDt);
			}

			function moveToRight() {

				$(".error_section").hide();
				$('#err_dis').hide();

				var left_student_list = $('#left_student_list option:selected');
				var right_student_list = $('#right_student_list option');
				var right_student_value = "";
				var right_student_name = "";

				var element = document.getElementById("left_student_list");
				if ( element.selectedIndex == '-1' ){

					$('#err_dis').show();
					$(".error_section").slideDown('slow');
					$(".divBody").scrollTop(0);
					$(".error_msg").html("左のリスト受講生を一つ選択してください。");
					return false;

				} else{
					left_student_list.each(function() {

						var isSame = false;
						right_student_value = $(this).val();
						right_student_name = $(this).text();

						right_student_list.each(function() {

							if ( right_student_value == $(this).val() ) {
								isSame = true;
								return;
							}
						});
						if ( !isSame ) {
							$('#right_student_list').append(
								'<option value="' + right_student_value + '">'+ right_student_name + '</option>');
							$('#left_student_list :selected').remove();
						}
					});
				}
			}

			function moveToLeft() {

				$(".error_section").hide();
				$('#err_dis').hide();

				var element = document.getElementById("right_student_list");

				if ( element.selectedIndex == '-1' ){

					$('#err_dis').show();
					$(".error_section").slideDown('slow');
					$(".divBody").scrollTop(0);
					$(".error_msg").html("右のリスト受講生を一つ選択してください。");
					return false;
				}else{
					var right_student_list = $('#right_student_list option:selected');

					right_student_list.each(function(){
						var option_value = $(this).val();
						var option_text = $(this).text();
						$("#left_student_list").append('<option value="'+option_value+'">'+option_text+'</option>');
						$('#right_student_list :selected').remove();
					});
				}
			}

			$(".btn_insert").on('click', function() {

				$(".error_section").hide();
				$('#err_dis').hide();

				var course_start_period = $(".course_start_period").text();
				var course_end_period = $(".course_end_period").text();
				var date_error_msg = '';
				var courseList = '';
				var studentList = '';
				var date = new Date();

				var m = date.getMonth()+1;
				if( m < 10){
					month = "0" + m;
				}else{
					month = m;
				}

				var d = date.getDate();
				if( d < 10){
					day = "0" + d;
				}else{
					day = d;
				}

				var year = date.getFullYear();
				var today_date = year+"/"+month+"/"+day;

				 $('.course_list tr').each(function() {
					var start_period = $(this).find("input.course_detail_start_period").val();
					var end_period = $(this).find("input.course_detail_end_period").val();
					var course_detail_no = $(this).find(".course_detail_no").text();

					if ( start_period == "" ){
						date_error_msg = 'コース詳細№”'+course_detail_no+'"の利用開始日を入力してください。';
						return false;
					}

					if ( end_period == "" ){
						date_error_msg = 'コース詳細№”'+course_detail_no+'"の利用終了日を入力してください。';
						return false;
					}

					if ( start_period < today_date ){
						date_error_msg = 'コース詳細№”'+course_detail_no+'"の利用開始日は今日より以前の日付になっています。';
						return false;
					}

					if ( end_period < today_date ){
						date_error_msg = 'コース詳細№”'+course_detail_no+'"の利用終了日は今日より以前の日付になっています。';
						return false;
					}

					if ( start_period > end_period ){
						date_error_msg = 'コース詳細№”'+course_detail_no+'"の利用開始日 ≦ 利用終了日 を正しく入力ください。';
						return false;
					}

					if ( course_start_period > start_period ){

						if ( course_start_period > end_period ){

							date_error_msg = 'コース詳細№”'+course_detail_no+'"の利用開始日と利用終了日がコース期間に入っていません。';
						}else {

							date_error_msg = 'コース詳細№”'+course_detail_no+'"の利用開始日がコース期間に入っていません。';
						}
						return false;
					}

					if ( course_end_period < end_period ){

						if ( course_end_period < start_period ){

							date_error_msg = 'コース詳細№”'+course_detail_no+'"の利用開始日と利用終了日がコース期間に入っていません。';
						}else {

							date_error_msg = 'コース詳細№”'+course_detail_no+'"の利用終了日がコース期間に入っていません。';
						}
						return false;
					}
				});
				if ( date_error_msg != "" ){

					$('#err_dis').show();
					$(".error_section").slideDown('slow');
					$(".divBody").scrollTop(0);
					$(".error_msg").html(date_error_msg);
					return false;
				}
				if ( $('#right_student_list option').size() < 1 ){

					$('#err_dis').show();
					$(".error_section").slideDown('slow');
					$(".divBody").scrollTop(0);
					$(".error_msg").html("登録する受講者情報を選択してください。");
					return false;
				}

				$('#right_student_list option').each(function(){
					studentList += $(this).val() + ",";
				});

				$("#student_noString").val(studentList);

				$('.course_list tr').each(function() {
					courseList += $(this).find(".course_detail_no").text() + ",";
					courseList += $(this).find("input.course_detail_start_period").val() + ",";
					courseList += $(this).find("input.course_detail_end_period").val();
					courseList += "}";
				});
				$("#course_noString").val(courseList);

				$("#course_dt_start_period").val(course_start_period);
				$("#course_dt_end_period").val(course_end_period);

				return true;
			});
			
		<?php echo '</script'; ?>
>
		<!--footer-->
		<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

		<!--footer-->
	</body>
</html><?php }
}
