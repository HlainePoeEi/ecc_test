<?php
/* Smarty version 3.1.29, created on 2022-08-09 14:56:44
  from "/var/www/html/eccadmin_dev/templates/testInfoCopy.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_62f1f71c4a4b00_31942442',
  'file_dependency' => 
  array (
    'f700db0aea68ccb67c62895b4771fe818abe9014' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/testInfoCopy.html',
      1 => 1660014743,
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
function content_62f1f71c4a4b00_31942442 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
<title>試験コピー</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta name="robots" content="noindex, nofollow">
<meta name="googlebot" content="noindex, nofollow">

<?php echo '<script'; ?>
 type="text/javascript"
	src="<?php echo @constant('HOME_DIR');?>
js/jquery.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript"
	src="<?php echo @constant('HOME_DIR');?>
js/jquery-ui.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript"
	src="<?php echo @constant('HOME_DIR');?>
js/common.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript"
	src="<?php echo @constant('HOME_DIR');?>
js/nicEdit-latest.js"><?php echo '</script'; ?>
>

<link href="<?php echo @constant('HOME_DIR');?>
css/jquery-ui.css" rel="stylesheet">
<link href="<?php echo @constant('HOME_DIR');?>
css/default.css" rel="stylesheet">
<link href="<?php echo @constant('HOME_DIR');?>
css/style.css" rel="stylesheet">

<?php echo '<script'; ?>
 type="text/javascript">
		
		bkLib.onDomLoaded(function() {
				new nicEditor({buttonList : ['fontSize','forecolor','bold','italic','underline','strikeThrough','subscript','superscript','html','upload', 'xhtml'],
			 uploadURI :'<?php echo @constant('HOME_DIR');?>
files/image_upload.php'
			 }).panelInstance('long_description');
		});
		

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
				var date_flg = document.getElementById('date_flg').value;
				// console.log(date_flg);
				if ( date_flg == 1 || date_flg == "1" ){

					$('#start_period').datepicker("disable");
					//console.log("date picker is disabled");
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

				// MSGのあるなし
				if ( $(".error_msg").html() != "" ) {

					$(".error_section").slideToggle('slow')
				}

				$(".close_icon").on('click',function(){

					$(".error_section").slideToggle('slow')

				});

				$(".btn_insert").on('click',function(){

					$(".error_section").hide();

					var org_id = document.getElementById('org_id').value;
					var test_info_name = document.getElementById('test_info_name').value;
					var test_time = document.getElementById('test_time').value;
					var nicE = new nicEditors.findEditor('long_description');
					var long_description = nicE.getContent();
					var end_period = document.getElementById('end_period').value;
					var date_flg = document.getElementById('date_flg').value;
					var start_period = document.getElementById('start_period').value;
					var remarks = document.getElementById('remarks').value;
					var status = $('input[name=status]:checked').val();
					var show_flg = $('input[name=show_flg]:checked').val();
					var drill_flg = $('input[name=drill_flg]:checked').val();
					
					// コース名の必須チェック
					if ( org_id == "" ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("組織ログインIDを入力してください。");
						return false;
					}
					
					// 試験名の必須チェック
					if ( test_info_name == "" ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("試験名を入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					// 試験名の文字数チェック
					if ( test_info_name.length > 32 ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("試験名を32字で入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}
					

					// 試験名チェック
					if ( (err_msg = characterCheck(test_info_name)) != null ){

						error_msg = "試験名"+ err_msg;
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

					// 試験説明の必須チェック
					if (long_description == "<br>" || long_description == ""){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("説明を入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					// 試験説明の文字数チェック
					if ( long_description.length > 2048 ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("説明を2048字で入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}
					
					//受講時間の必須チェック
					if ( test_time == "" || test_time == 0 ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("受講時間を入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					// 受講時間の文字数チェック
					if ( test_time.length > 4 ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("受講時間を4字で入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}
					
					// 受講時間チェック
					if ( (err_msg = characterCheck(test_time)) != null ){

						error_msg = "受講時間"+ err_msg;
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html(error_msg);
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

					// ドリルフラグの必須チェック
					if(drill_flg == "") {
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("反復ドリルを選択してください。");
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
<body class="pushmenu-push">
	<form id="main_form"
		action="<?php echo @constant('HOME_DIR');?>
TestInfoCopy/save" method="post">
		<!-- 戻るの場合リストか登録かの画面を分けるため -->
		<input type="hidden" id="btn_flg_type" name="btn_flg_type" /> 
		<input type="hidden" id="status" name="status" /> 
		<input type="hidden" id="show_flg" name="show_flg" />
		<input type="hidden" id="drill_flg" name="drill_flg" />
		<input type="hidden" id="test_info_start_period" name="test_info_start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_info_start_period;?>
" /> 
		<input type="hidden" id="test_info_end_period" name="test_info_end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_info_end_period;?>
" /> 
		<input type="hidden" id="test_info_remarks" name="test_info_remarks" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->test_info_remarks, ENT_QUOTES, 'UTF-8', true);?>
" /> 
		<input type="hidden" id="test_info_btn_flg" name="test_info_btn_flg" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_info_btn_flg;?>
" /> 
		<input type="hidden" id="test_info_date_flg" name="test_info_date_flg" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_info_date_flg;?>
" /> 
		<input type="hidden" id="test_info_test_info_name" name="test_info_test_info_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->test_info_test_info_name, ENT_QUOTES, 'UTF-8', true);?>
" /> 
		<input type="hidden" id="test_info_test_time" name="test_info_test_time" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->test_info_test_time, ENT_QUOTES, 'UTF-8', true);?>
" />  
		
		<input type="hidden" id="search_page_row_til" name="search_page_row_til" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_row_til;?>
" />
		<input type="hidden" id="search_page_order_column_til" name="search_page_order_column_til" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_column_til;?>
" />
		<input type="hidden" id="search_page_order_dir_til" name="search_page_order_dir_til" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_dir_til;?>
" />
		<input type="hidden" id="search_page_til" name="search_page_til" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_til;?>
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
			<div class="main">
				<section class="error_section">
					<img src="<?php echo @constant('HOME_DIR');?>
image/close_icon.png"
						style="width: 15px; float: right" class="close_icon"> <?php if (!empty($_smarty_tpl->tpl_vars['msg']->value)) {?>
					<div class="error_msg"><?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
</div>
					<?php } else { ?>
					<div class="error_msg"></div>
					<?php }?>
				</section>
				<section class="content">
					<p>
						<span class="title">試験 / 試験登録</span>
					</p>
					<p style="text-align: right; width: 100%;">
						<input type="button" title="戻る" value="" class="btn_back"
							onclick="javascript:doBack('<?php echo @constant('HOME_DIR');?>
TestInfoCopy/back')">
					</p>
					<input type="hidden" id="home_dir" value="<?php echo @constant('HOME_DIR');?>
" />
					<input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
" /> <input type="hidden" id="search_start_period" name="search_start_period"
						value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_start_period;?>
" /> 
					<input type="hidden" id="search_end_period" name="search_end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_end_period;?>
" /> <input type="hidden"
						id="search_test_info_name" name="search_test_info_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->search_test_info_name, ENT_QUOTES, 'UTF-8', true);?>
" />
					<input type="hidden" id="search_remark" name="search_remark" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->search_remark, ENT_QUOTES, 'UTF-8', true);?>
" /> <input type="hidden"
						id="search_rd_status1" name="search_rd_status1" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_rd_status1;?>
" /> 
					<input type="hidden" id="search_rd_status2" name="search_rd_status2" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_rd_status2;?>
" /> 
					<input type="hidden" id="search_rdstatus" name="search_rdstatus" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_rdstatus;?>
" /> 
					<input type="hidden" id="search_chk_status1" name="search_chk_status1" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_chk_status1;?>
" /> 
					<input type="hidden" id="search_chk_status2" name="search_chk_status2" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_chk_status2;?>
" /> 
					<input type="hidden" id="search_status" name="search_status" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_status;?>
" /> 
					<input type="hidden" id="date_flg" name="date_flg" value="<?php echo $_smarty_tpl->tpl_vars['date_flg']->value;?>
" />
					<input type="hidden" id="search_org_id" name="search_org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_org_id;?>
" /> 

					<input type="hidden" id="new_org_no" name="new_org_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->new_org_no;?>
"/>
					<input type="hidden" id="org_name" name="org_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_name;?>
"/>
					<input type="hidden" id="org_name_official" name="org_name_official" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_name_official;?>
"/>
			
					<div class="task_div" style="width: 100%;">
						<table style="width: 100%;">
							<tr>
								<td><input type="hidden" id="test_info_no" name="test_info_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_info_no;?>
">
								</td>
								<td ><input type="hidden" id="screen_mode" name="screen_mode" value="<?php echo $_smarty_tpl->tpl_vars['screen_mode']->value;?>
"> 
								<input type="hidden" id="btn_flg" name="btn_flg" value="<?php echo $_smarty_tpl->tpl_vars['btn_flg']->value;?>
">
									<?php if ($_smarty_tpl->tpl_vars['screen_mode']->value != 'new') {?>
									<input type="hidden" id="radio_temp" name="radio_temp">
									<?php }?></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>
									組織ログインID<span class="required">※</span>
								</td>
								<td width="150px">
									<input id="org_id" name="org_id" type="text" class="text" maxlength="10" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_id;?>
" >
								</td>
								<td style="width:70px;">
									<input type="button" class="btn_qa_assign" name="btn_qa_assign" id="org_display" onclick="javascript:showOrg('<?php echo @constant('HOME_DIR');?>
TestInfoCopy/orgShow')" >
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
								<td style="width: 240px">試験名<span class="required">※</span></td>
								<td  colspan="4"><input type="text" class="text"
									id="test_info_name" name="test_info_name"
									value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->test_info_name, ENT_QUOTES, 'UTF-8', true);?>
" maxlength="32" size="30"></td>
							</tr>
							<tr style="height: 20px;">
							<tr style="border: 1px solid #dddddd;">
								<td>説明<span class="required">※</span></td>
								<td colspan="4"><textarea name="long_description" id="long_description"
										rows="2" class="imgtxtarea"  style="width:500px;height:100px"><?php echo $_smarty_tpl->tpl_vars['form']->value->long_description;?>
</textarea></td>
							</tr>
							<tr>
								<td>受講時間（秒）<span class="required">※</span></td>
								<td width="820px" colspan="4">
									<input type="number" class="text"
									id="test_time" name="test_time"
									value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->test_time, ENT_QUOTES, 'UTF-8', true);?>
" maxlength="4" oninput="javascript: if (this.value.length > this.maxLength) this.value = Math.abs(this.value.slice(0, this.maxLength)); else this.value = Math.abs(this.value);">
								</td>
							</tr>
							<tr>
								<td>結果表示</td>
								<td colspan="4"><?php if ($_smarty_tpl->tpl_vars['form']->value->show_flg != 1) {?> <input type="radio"
									name="show_flg" value="0" id="show_flg1" checked /> <label
									for="show_flg1">しない </label><input type="radio" name="show_flg"
									value="1" id="show_flg2" /> <label for="show_flg2">する</label><?php } else { ?>
									<input type="radio" name="show_flg" value="0" id="show_flg1" />
									<label for="show_flg1">しない </label><input type="radio"
									name="show_flg" value="1" id="show_flg2" checked /> <label
									for="show_flg2">する</label> <?php }?>
								</td>
							</tr>
							<tr>
								<td>反復ドリル</td>
								<td>
									<?php if ($_smarty_tpl->tpl_vars['form']->value->drill_flg != 1) {?> 
										<input type="radio" name="drill_flg" value="0" id="drill_flg1" checked /> 
										<label for="drill_flg1">しない </label>
										<input type="radio" name="drill_flg" value="1" id="drill_flg2" /> 
										<label for="drill_flg2">する</label>
									<?php } else { ?>
										<input type="radio" name="drill_flg" value="0" id="drill_flg1" />
										<label for="drill_flg1">しない </label>
										<input type="radio" name="drill_flg" value="1" id="drill_flg2" checked /> 
										<label for="drill_flg2">する</label> 
									<?php }?>
								</td>
							</tr>
							<tr>
								<td>公開<span class="required">※</span></td>
								<td colspan="4"><?php if ($_smarty_tpl->tpl_vars['form']->value->status != 1) {?> <input type="radio"
									name="status" value="0" id="status1" checked /> <label
									for="status1">しない </label><input type="radio" name="status"
									value="1" id="status2" /> <label for="status2">する</label>
									<?php } else { ?> <input type="radio" name="status" value="0" id="status1" />
									<label for="status1">しない </label><input type="radio"
									name="status" value="1" id="status2" checked /> <label
									for="status2">する</label> <?php }?>
								</td>
							</tr>
							<tr>
								<td>利用開始<span class="required">※</span></td>
								<td colspan="4"><?php if (($_smarty_tpl->tpl_vars['date_flg']->value == 1)) {?> <input type="text"
									id="start_period" name="start_period"
									value="<?php echo $_smarty_tpl->tpl_vars['form']->value->start_period;?>
" maxlength="10" readonly>
									<?php } else { ?> <input type="text" id="start_period" name="start_period"
									value="<?php echo $_smarty_tpl->tpl_vars['form']->value->start_period;?>
" maxlength="10"
									onchange="changeDateFormat(this)"> <?php }?>
								</td>
							</tr>
							<tr>
								<td>利用終了<span class="required">※</span></td>
								<td colspan="4"><input type="text" id="end_period" name="end_period"
									value="<?php echo $_smarty_tpl->tpl_vars['form']->value->end_period;?>
" maxlength="10"
									onchange="changeDateFormat(this)">
							</tr>
							<tr>
								<td>備考</td>
								<td colspan="4"><input type="text" class="text" id="remarks"
									name="remarks" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->remarks, ENT_QUOTES, 'UTF-8', true);?>
" size="30" maxlength="512"></td>
							</tr>
							<tr>
								<td colspan="2"></td>
							</tr>
						</table>

					</div>
					<div style="width: 100%; height: 50px;">
						<div style="width: 100%">
							<?php if ($_smarty_tpl->tpl_vars['screen_mode']->value == 'update') {?> <input type="button"
								name="quiz_btn" value="" class="quiz_btn"
								onclick="trans1('<?php echo $_smarty_tpl->tpl_vars['form']->value->test_info_no;?>
','<?php echo @constant('HOME_DIR');?>
QuizInfoAssign/index')">
							<?php } else { ?> <?php if ($_smarty_tpl->tpl_vars['btn_flg']->value == '1') {?> <input type="button" name="quiz_btn"
								value="" class="quiz_btn"
								onclick="trans1('<?php echo $_smarty_tpl->tpl_vars['form']->value->test_info_no;?>
','<?php echo @constant('HOME_DIR');?>
QuizInfoAssign/index')">
							<?php }?> <?php }?>
						</div>
						<div class="pagging" style="width: 100%; text-align: right;">
							<input type="submit" name="insert" value="" class="btn_insert">
						</div>
					</div>
				</section>
				<!-- End Content -->
			</div>
			<!-- End Main -->
			<input type="hidden" id="org_no" name="org_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
" />
			<input type="hidden" id="gamen_name" name="gamen_name" value="testinfo" />
			<input type="hidden" id="ori_test_info_no" name="ori_test_info_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->ori_test_info_no;?>
" />
			<div id="demo"></div>
		</div>
		<!-- End divBody -->
		<!--footer-->
		<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

		<!--footer-->
	</form>
	<?php echo '<script'; ?>
>
		
		//更新ボタン処理
		function trans1(test_info_no,action){
			var start_period = document.getElementById('start_period').value;
			var end_period = document.getElementById('end_period').value;
			var btn_flg = document.getElementById('btn_flg').value;
			var date_flg = document.getElementById('date_flg').value;
			var test_info_name = document.getElementById('test_info_name').value;
			var test_time = document.getElementById('test_time').value;
			var remarks=document.getElementById('remarks').value;
			var nicE = new nicEditors.findEditor('long_description');
			var long_description = nicE.getContent();
			var status = $('input[name=status]:checked').val();
			var show_flg = $('input[name=show_flg]:checked').val();
			var drill_flg = $('input[name=drill_flg]:checked').val();
			var menuOpen = document.getElementById('menuOpen').value;
			var menuStatus = document.getElementById('menuStatus').value;
			$("#main_form").attr("action", action);
			$("#test_info_no").val(test_info_no);
			//戻るの場合リストか登録かの画面を分けるため
			$("#test_info_start_period").val(start_period);
			$("#test_info_end_period").val(end_period);
			$("#test_info_btn_flg").val(btn_flg);
			$("#test_info_date_flg").val(date_flg);
			$("#test_info_test_info_name").val(test_info_name);
			$("#test_info_test_time").val(test_time);
			$("#long_description").val(long_description);
			$("#status").val(status);
			$("#show_flg").val(show_flg);
			$("#drill_flg").val(drill_flg);
			$("#test_info_remarks").val(remarks);
			$("#btn_flg_type").val("2");
			$("#menuOpen").val(menuOpen);
			$("#menuStatus").val(menuStatus);
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
		
	<?php echo '</script'; ?>
>
</body>
</html><?php }
}
