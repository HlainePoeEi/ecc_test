<?php
/* Smarty version 3.1.29, created on 2022-10-17 05:24:57
  from "D:\xampp\htdocs\eccadmin_dev\templates\testRegist.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_634ccb096023d9_89466228',
  'file_dependency' => 
  array (
    '4058eeb882a2f4e28415b0fd2425d5aa8b28cb97' => 
    array (
      0 => 'D:\\xampp\\htdocs\\eccadmin_dev\\templates\\testRegist.html',
      1 => 1646806540,
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
function content_634ccb096023d9_89466228 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
	<title>テスト登録</title>
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
js/nicEdit-latest.js"><?php echo '</script'; ?>
>
	
	<link href="<?php echo @constant('HOME_DIR');?>
css/jquery-ui.css" rel="stylesheet">
	<link href="<?php echo @constant('HOME_DIR');?>
css/default.css" rel="stylesheet">

	<?php echo '<script'; ?>
 type="text/javascript">
		
		bkLib.onDomLoaded(function() {
			new nicEditor({buttonList : ['fontSize','forecolor','bold','italic','underline','strikeThrough','subscript','superscript','html','upload', 'xhtml']}).panelInstance('description');
		});
		
	<?php echo '</script'; ?>
>
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

				var test_type = $("#test_type5").val();
				if ( test_type == "001" ){
					$("#td_visible").show();
				}else {
					$("#td_visible").hide();
				}

				var date_flg = document.getElementById('date_flg').value;
				console.log(date_flg);
				if ( date_flg == 1 || date_flg == "1" ){

					$('#start_period').datepicker("disable");
					console.log("date picker is disabled");
				}else {

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
										left: leftWidth
									});
								}, 0);
							}
						});
					});
				}

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

				$(function(){

					$('input:radio[name="test_type"]').change(

						function(){

							$("#test_type5").val($(this).val());

							if ($(this).is(':checked') && $(this).val() == '001') {

								$("#td_visible").show();
							} else{
								$("#td_visible").hide();
								$("#test_quiz_count").val('0'); //テストタイプ【通常、一回のみ】の場合-20190605
							}
					});
				});

				// MSGのあるなし
				if ( $(".error_msg").html() != "" ) {

					$(".error_section").slideToggle('slow')
				}

				$(".close_icon").on('click',function(){

					$(".error_section").slideToggle('slow')

				});

				$(".btn_insert").on('click',function(){

					$(".error_section").hide();

					var test_name = document.getElementById('test_name').value;
					var nicE = new nicEditors.findEditor('description');
					var description = nicE.getContent();
					var end_period = document.getElementById('end_period').value;
					var test_quiz_count = document.getElementById('test_quiz_count').value;
					var date_flg = document.getElementById('date_flg').value;
					var start_period = document.getElementById('start_period').value;
					var remarks = document.getElementById('remarks').value;
					var status = $('input[name=status]:checked').val();

					if ( document.getElementById('test_type1').checked ) {
  						rate_value = document.getElementById('test_type1').value;
					}
					if ( document.getElementById('test_type2').checked ) {
  						rate_value = document.getElementById('test_type2').value;
					}
					if ( document.getElementById('test_type3').checked ) {
  						rate_value = document.getElementById('test_type3').value;
					}

					// テスト名の必須チェック
					if ( test_name == "" ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("テスト名を入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					// テスト名の文字数チェック
					if ( test_name.length > 32 ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("テスト名を32字で入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					// テスト名チェック
					if ( (err_msg = characterCheck(test_name)) != null ){

						error_msg = "テスト名"+ err_msg;
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html(error_msg);
						$(".divBody").scrollTop(0);
						return false;
					}

					if ( (err_msg = characterCheck(remarks)) != null ){

						error_msg = "備考"+ err_msg;
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html(error_msg);
						$(".divBody").scrollTop(0);
						return false;
					}

					if ( rate_value == '001' ){

						if ( test_quiz_count == "" ){

							 $('#err_dis').show();
							 $(".error_section").slideToggle('slow');
							 $(".error_msg").html("出題数を入力してください。");
							 $(".divBody").scrollTop(0);
							 return false;
						 }

						if ( test_quiz_count == 0 ){

							 $('#err_dis').show();
							 $(".error_section").slideToggle('slow');
							 $(".error_msg").html("出題数を０以上入力してください。");
							 $(".divBody").scrollTop(0);
							 return false;
						}

						// 問題数の数字チェック
						if ( isNaN(test_quiz_count) ){

							$('#err_dis').show();
							$(".error_section").slideToggle('slow');
							$(".error_msg").html("出題数を数字で入力してください。");
							$(".divBody").scrollTop(0);
							return false;
						}
					}

					// テスト内容の必須チェック
					if ( description == "<br>" || description == "" ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("説明を入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					// テスト内容の文字数チェック
					if ( description.length > 1024 ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("説明を1024字で入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					// 公開の必須チェック
					if(status == "") {
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("状態を入力してください。");
						$(".divBody").scrollTop(0);
						return false;
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

					if ( $('#screen_mode').val() == 'update' ){

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

					//フィルタ
					if ( !document.getElementById("filter") ){
						$("body").append("<div id=\"filter\"></div>");
					}else {
						$("#filter").show();
					}

					return true;
				});
			});

			//戻るボタン処理
			function doBack(action){

				$("#main_form").attr("action", action);
				$("#main_form").submit();
			}

		<?php echo '</script'; ?>
>
	</head>
	<body class="pushmenu-push" >
		<form id="main_form" action="<?php echo @constant('HOME_DIR');?>
TestRegist/save" method="post" >
			<!-- 戻るの場合リストか登録かの画面を分けるため -->
			<input type="hidden" id="btn_flg_type" name="btn_flg_type"/>
			<input type="hidden" id="status" name="status"/>
			<input type="hidden" id="test_start_period" name="test_start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_start_period;?>
" />
			<input type="hidden" id="test_end_period" name="test_end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_end_period;?>
" />
			<input type="hidden" id="test_remarks" name="test_remarks" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->test_remarks, ENT_QUOTES, 'UTF-8', true);?>
" />
			<input type="hidden" id="test_btn_flg" name="test_btn_flg" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_btn_flg;?>
" />
			<input type="hidden" id="test_date_flg" name="test_date_flg" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_date_flg;?>
" />
			<input type="hidden" id="test_test_name" name="test_test_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->test_test_name, ENT_QUOTES, 'UTF-8', true);?>
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
				<div class="main" >
					<section class="error_section">
					<img src="<?php echo @constant('HOME_DIR');?>
image/close_icon.png" style="width:15px;float:right" class="close_icon">
						<?php if (!empty($_smarty_tpl->tpl_vars['msg']->value)) {?>
						<div class="error_msg"><?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
</div>
						<?php } else { ?>
						 <div class="error_msg"></div>
						<?php }?>
					</section>
					<section class="content">
						<p>
							><span class="title">テスト / テスト登録</span>
						</p>
						<p style="text-align:right;width:100%;">
							<input type="button" title="戻る" value="" class="btn_back" onclick="javascript:doBack('<?php echo @constant('HOME_DIR');?>
TestRegist/back')">
						</p>
						<input type="hidden" id="home_dir" value="<?php echo @constant('HOME_DIR');?>
" />
						<input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
"/>
						<input type="hidden" id="search_start_period" name="search_start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_start_period;?>
"/>
						<input type="hidden" id="search_end_period" name="search_end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_end_period;?>
"/>
						<input type="hidden" id="search_test_name" name="search_test_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->search_test_name, ENT_QUOTES, 'UTF-8', true);?>
"/>
						<input type="hidden" id="search_remark" name="search_remark" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->search_remark, ENT_QUOTES, 'UTF-8', true);?>
"/>
						<input type="hidden" id="search_rd_status1" name="search_rd_status1" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_rd_status1;?>
"/>
						<input type="hidden" id="search_rd_status2" name="search_rd_status2" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_rd_status2;?>
"/>
						<input type="hidden" id="search_rdstatus" name="search_rdstatus" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_rdstatus;?>
"/>
						<input type="hidden" id="search_chk_status1" name="search_chk_status1" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_chk_status1;?>
"/>
						<input type="hidden" id="search_chk_status2" name="search_chk_status2" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_chk_status2;?>
"/>
						<input type="hidden" id="search_status" name="search_status" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_status;?>
"/>
						<input type="hidden" id="search_org_id" name="search_org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_org_id;?>
"/>
						<input type="hidden" id="date_flg" name="date_flg" value="<?php echo $_smarty_tpl->tpl_vars['date_flg']->value;?>
"/>
						<input type="hidden" id="org_no" name="org_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
"/>
						
						<input type="hidden" id="search_page_row" name="search_page_row" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_row;?>
" />
						<input type="hidden" id="search_page_order_column" name="search_page_order_column" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_column;?>
" />
						<input type="hidden" id="search_page_order_dir" name="search_page_order_dir" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_dir;?>
" />

						<div class="task_div" style="width:100%;">
							<table style="width:100%;">
								<tr>
									<td><input type="hidden" id="test_no" name="test_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_no;?>
">
									<input type="hidden" id="test_type5" name="test_type5" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_type;?>
">
									</td>
									<td><input type="hidden" id="screen_mode" name="screen_mode" value="<?php echo $_smarty_tpl->tpl_vars['screen_mode']->value;?>
">
									<input type="hidden" id="btn_flg" name="btn_flg" value="<?php echo $_smarty_tpl->tpl_vars['btn_flg']->value;?>
">
									 <?php if ($_smarty_tpl->tpl_vars['screen_mode']->value != 'new') {?>
									<input type="hidden" id="hd_test_type" name="hd_test_type" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_type;?>
">
									<input type="hidden" id="radio_temp" name="radio_temp">
									<?php }?>
									</td>
								</tr>
								<tr>
									<td style="width:240px">テスト名<span class="required">※</span></td>
									<td width="820px"><input type="text" class="text" id="test_name" name="test_name"  value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->test_name, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "32" size="30"></td>
								</tr>
								<tr style="height:50px;">

									<td>テストタイプ</td>
									<td>
									<?php if ($_smarty_tpl->tpl_vars['screen_mode']->value == 'copy' || $_smarty_tpl->tpl_vars['screen_mode']->value == 'update') {?>
										<?php if ($_smarty_tpl->tpl_vars['form']->value->test_type == '001') {?>
											<input type="radio" name="test_type" value="001" id="test_type1" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_type;?>
" checked disabled="disabled" /><label for="test_type1">反復(SRS)</label></input>
											<input type="radio" name="test_type" value="002" id="test_type2" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_type;?>
" disabled="disabled" /><label for="test_type2">通常</label></input>
											<input type="radio" name="test_type" value="003" id="test_type3" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_type;?>
" disabled="disabled" /><label for="test_type3">一回のみ</label></input>
										<?php } elseif (($_smarty_tpl->tpl_vars['form']->value->test_type == '002')) {?>
											<input type="radio" name="test_type" value="001" id="test_type1" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_type;?>
" disabled="disabled"/><label for="test_type1">反復(SRS)</label></input>
											<input type="radio" name="test_type" value="002" id="test_type2" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_type;?>
" checked disabled="disabled"/><label for="test_type2">通常</label></input>
											<input type="radio" name="test_type" value="003" id="test_type3" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_type;?>
" disabled="disabled"/><label for="test_type3">一回のみ</label></input>
										<?php } elseif (($_smarty_tpl->tpl_vars['form']->value->test_type == '003')) {?>
											<input type="radio" name="test_type" value="001" id="test_type1" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_type;?>
" disabled="disabled"/><label for="test_type1">反復(SRS)</label></input>
											<input type="radio" name="test_type" value="002" id="test_type2" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_type;?>
" disabled="disabled"/><label for="test_type2">通常</label></input>
											<input type="radio" name="test_type" value="003" id="test_type3" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_type;?>
" checked disabled="disabled"/><label for="test_type3">一回のみ</label></input>
										<?php }?>
									<?php } else { ?>
										<input type="radio" name="test_type" value="001" id="test_type1" checked="checked"/>
										<label for="test_type1">反復(SRS)</label></input>
										<input type="radio" name="test_type" value="002" id="test_type2" />
										<label for="test_type2">通常</label></input>
										<input type="radio" name="test_type" value="003" id="test_type3" />
										<label for="test_type3">一回のみ</label></input>
									 <?php }?>
								</td>
								</tr>
								<tr id="td_visible" style="height:50px;">
									<td>出題数<span class="required">※</span></td>
									<td><input type="text" class="text" id="test_quiz_count" name="test_quiz_count"  value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_quiz_count;?>
" maxlength = "2" size="30"></td>
								</tr>
								 <tr style="border: 1px solid #dddddd;">
									<td>説明<span class="required">※</span></td>
									<td><textarea name="description" id="description" rows="2" class="imgtxtarea"><?php echo $_smarty_tpl->tpl_vars['form']->value->description;?>
</textarea></td>
								</tr>
								<tr>
									<td>公開</td>
									<td>
									<?php if ($_smarty_tpl->tpl_vars['form']->value->status != '1') {?>
									<input type="radio" name="status" value="0" id="status1" checked />
									<label for="status1">しない </label></input>
									<input type="radio" name="status" value="1" id="status2" />
									<label for="status2">する</label></input>
									<?php } else { ?>
									<input type="radio" name="status" value="0" id="status1" />
									<label for="status1">しない </label></input>
									<input type="radio" name="status" value="1" id="status2" checked />
									<label for="status2">する</label>
									</input>
									<?php }?>
									</td>
								</tr>
								<tr>
									<td>利用開始<span class="required">※</span></td>
									<td>
										<?php if (($_smarty_tpl->tpl_vars['date_flg']->value == 1)) {?>
											<input type="text" id="start_period" name="start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->start_period;?>
" maxlength="10"  readonly>
										<?php } else { ?>
											<input type="text" id="start_period" name="start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->start_period;?>
" maxlength="10"
											onchange="changeDateFormat(this)">
										<?php }?>
									</td>
								</tr>
								 <tr>
									<td>利用終了<span class="required">※</span></td>
									<td><input type="text" id="end_period" name="end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->end_period;?>
" maxlength="10" onchange="changeDateFormat(this)"></td>
								</tr>
								<tr>
									<td>備考</td>
									<td><input type="text" class="text" id="remarks" name="remarks"  value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->remarks, ENT_QUOTES, 'UTF-8', true);?>
" size="30"></td>
								</tr>
								<tr>
									<td colspan="2">
									</td>
								</tr>
							</table>

						</div>
						<div width="100%" height="50px">
							<div style="width:100%">
								<?php if ($_smarty_tpl->tpl_vars['screen_mode']->value == 'update') {?>
									<input type="button" name="quiz_btn" value="" class="quiz_btn" onclick="trans1('<?php echo $_smarty_tpl->tpl_vars['form']->value->test_no;?>
','<?php echo @constant('HOME_DIR');?>
QuizAssignmentCheckbox/index')">
								<?php } else { ?>
									<?php if ($_smarty_tpl->tpl_vars['btn_flg']->value == '1') {?>
										<input type="button" name="quiz_btn" value="" class="quiz_btn" onclick="trans1('<?php echo $_smarty_tpl->tpl_vars['form']->value->test_no;?>
','<?php echo @constant('HOME_DIR');?>
QuizAssignmentCheckbox/index')">
									<?php }?>
								<?php }?>
							</div>
							<div class="pagging" style="width:100%;text-align:right;">
								<input type="submit" name="insert" value="" class="btn_insert" >
							</div>
						</div>
					</section><!-- End Content -->
				</div><!-- End Main -->
				<input type="hidden" id="orgNo" name="orgNo" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
"/>
				<input type="hidden" id="gamen_name" name="gamen_name" value="test"/>
				<input type="hidden" id="ori_test_no" name="ori_test_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->ori_test_no;?>
"/>
				<div id="demo"></div>
			</div><!-- End divBody -->
			<!--footer-->
				<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<!--footer-->
		</form>
		<?php echo '<script'; ?>
>
		
		//更新ボタン処理
		function trans1(test_no,action){
			var start_period = document.getElementById('start_period').value;
			var end_period = document.getElementById('end_period').value;
			var btn_flg = document.getElementById('btn_flg').value;
			var date_flg = document.getElementById('date_flg').value;
			var test_name = document.getElementById('test_name').value;
			var remarks=document.getElementById('remarks').value;
			var nicE = new nicEditors.findEditor('description');
			var description = nicE.getContent();
			var status = $('input[name=status]:checked').val();
			var end_period = document.getElementById('end_period').value;
			var menuOpen = document.getElementById('menuOpen').value;
			var menuStatus = document.getElementById('menuStatus').value;
			$("#main_form").attr("action", action);
			$("#test_no").val(test_no);
			//戻るの場合リストか登録かの画面を分けるため
			$("#test_start_period").val(start_period);
			$("#test_end_period").val(end_period);
			$("#test_btn_flg").val(btn_flg);
			$("#test_date_flg").val(date_flg);
			$("#test_test_name").val(test_name);
			$("#description").val(description);
			$("#status").val(status);
			$("#test_remarks").val(remarks);
			$("#btn_flg_type").val("2");
			$("#menuOpen").val(menuOpen);
			$("#menuStatus").val(menuStatus);
			$("#main_form").submit();
		}
		
	<?php echo '</script'; ?>
>
	</body>
	</div>
</html><?php }
}
