<?php
/* Smarty version 3.1.29, created on 2022-10-17 05:26:54
  from "D:\xampp\htdocs\eccadmin_dev\templates\testList.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_634ccb7e76e046_99729618',
  'file_dependency' => 
  array (
    '17431296511f1a4c5638230007f8c45f7100b062' => 
    array (
      0 => 'D:\\xampp\\htdocs\\eccadmin_dev\\templates\\testList.html',
      1 => 1646806478,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:leftMenu.html' => 1,
    'file:header.html' => 1,
    'file:footer.html' => 2,
  ),
),false)) {
function content_634ccb7e76e046_99729618 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate')) require_once 'D:\\xampp\\htdocs\\eccadmin_dev\\libs\\smarty\\libs\\plugins\\modifier.truncate.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>テスト一覧</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta name="robots" content="noindex, nofollow">
	<meta name="googlebot" content="noindex, nofollow">
	
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('HOME_DIR');?>
js/groupregist.js"><?php echo '</script'; ?>
>
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
js/escape.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('HOME_DIR');?>
js/datatables.min.js"><?php echo '</script'; ?>
>
    
	<link href="<?php echo @constant('HOME_DIR');?>
css/jquery-ui.css" rel="stylesheet">
	<link href="<?php echo @constant('HOME_DIR');?>
css/default.css" rel="stylesheet">
	<link href="<?php echo @constant('HOME_DIR');?>
css/testlist.css" rel="stylesheet">
	<link href="<?php echo @constant('HOME_DIR');?>
css/datatables.css" rel="stylesheet">
		<?php echo '<script'; ?>
 type="text/javascript">
			function check(){

				if ($('#chk_status1').is(':checked')) {

			             $('#chk_status1').prop('checked', true);  // checked
			          }
			          else{
			             $('#chk_status1').prop('checked', false);
			          }
			          if($('#chk_status2').is(':checked')){
			             $('#chk_status2').prop('checked', true);  // checked
			          }
			          else{
			             $('#chk_status2').prop('checked', false);
			          }
			}

			//表示再現
			$(document).ready(function() {
					check();
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

					$(".error_section").slideToggle('slow')
				}

				$(".close_icon").on('click',function(){

					$(".error_section").slideToggle('slow')

				});


			    /**
		         *
		         *  検索ボタン押下、必須チェック処理
		         *
		         **/
		        $("#btn_search").on('click',function(){

		        	$(".error_section").hide();

		        	var $new_subject_area_no = "";

					if($('#chk_status1').prop('checked') === true){

						if($new_subject_area_no == "")

							$new_subject_area_no = $('#chk_status1').attr('value');
						else

							$new_subject_area_no += $('#chk_status1').attr('value');
				    }

					if($('#chk_status2').prop('checked') === true){

						if($new_subject_area_no == "")

						    $new_subject_area_no = $('#chk_status2').attr('value');
						else

							$new_subject_area_no += ',' + $('#chk_status2').attr('value');
				    }

					 $('#status').val($new_subject_area_no);

					var start_period = document.getElementById('start_period').value;
		            var end_period = document.getElementById('end_period').value;

					// 利用開始の必須チェック
					if(start_period == "") {
					    $('#err_dis').show();
					    $(".error_section").slideToggle('slow');
					    $(".error_msg").html("利用開始を入力してください。");
					    return false;
					}

					// 利用終了の必須チェック
					if(end_period == "") {
					    $('#err_dis').show();
					    $(".error_section").slideToggle('slow');
					    $(".error_msg").html("利用終了を入力してください。");
					    return false;
					}

					// 利用開始 < 利用終了チェック
					if(start_period > end_period){
						$('#err_dis').show();
					    $(".error_section").slideToggle('slow');
					    $(".error_msg").html("<?php echo @constant('W004');?>
");
					    return false;
					}

					$('#page').val(1);

					return true;
				});
				
				//データテーブルを表示する
				var dataArray = $("#list").val();
				var current_page = parseInt($("#search_page").val());
				var current_page_row = parseInt($("#search_page_row").val());
				var current_order_column = $("#search_page_order_column").val();
				var current_order_dir = $("#search_page_order_dir").val();
				
				console.log("current_page : " + current_page );
				console.log("current_page_row : " + current_page_row );
				console.log("current_order_column : " + current_order_column );
				console.log("current_order_dir : " + current_order_dir );

				if(dataArray != ""){
					$('#tbl_search').DataTable( {
						"scrollY": 300,
						"scrollX": true,
						"bFilter": false,
						"ordering": true,
						"pageLength": current_page_row,
						"aaSorting": [[current_order_column, current_order_dir]],
						columnDefs: [{
							orderable: false,
							targets: "td_img"}
						],
						"language": {
							"info":" _TOTAL_ 件中 _START_ から _END_ まで表示",
							 "paginate": {
								"first":      "First",
								"last":       "Last",
								"next":       "次",
								"previous":   "前"
							},
							"lengthMenu":" _MENU_ 件表示"
						}
					});
				}
				
				var table = $('#tbl_search').dataTable();
				table.fnPageChange(current_page);
			});
		<?php echo '</script'; ?>
>
	</head>
<body class="pushmenu-push">
	    <form id="main_form" action="<?php echo @constant('HOME_DIR');?>
TestList/Search" method="post">
	        <input type="hidden" id="test_no" name="test_no"/>
	        <input type="hidden" id="org_no" name="org_no"/>
			<input type="hidden" id="screen_mode" name="screen_mode"/>
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
			
			<input type="hidden" id="search_page_row" name="search_page_row" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_row;?>
" />
			<input type="hidden" id="search_page_order_column" name="search_page_order_column" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_column;?>
" />
			<input type="hidden" id="search_page_order_dir" name="search_page_order_dir" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_dir;?>
" />
			
			<!-- 戻るの場合リストか登録かの画面を分けるため -->
			<input type="hidden" id="btn_flg_type" name="btn_flg_type"/>

			<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:leftMenu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<div class="divHeader">
				<!--header-->
					<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

				<!--header-->
			</div>
			<div class="divBody">
					<div class="container">
						<div class="main">
							<section class="error_section">
								<img src="<?php echo @constant('HOME_DIR');?>
image/close_icon.png" style="width:15px;float:right" class="close_icon">
									<?php if (!empty($_smarty_tpl->tpl_vars['err_msg']->value)) {?>
										<div class="error_msg"><?php echo $_smarty_tpl->tpl_vars['err_msg']->value;?>
</div>
									<?php } else { ?>
										<div  class="error_msg"></div>
									<?php }?>
							</section>
							<section class="content">
								<p>
									><span class="title">テスト / テスト一覧</span>
								</p>
								  <input type="hidden" id="status" name="status" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->status;?>
">
								<table class="main_tbl" style="width:100%">
									<tr>
										<td class="st_col">日付 (From)<span class="required">※</span></td>
										<td class="input"><input class="" type="text" name="start_period" id="start_period"
												value="<?php echo $_smarty_tpl->tpl_vars['form']->value->start_period;?>
" maxlength="10" onchange="changeDateFormat(this)"></td>
										<td width="10px"></td>
										<td class="st_col">日付 (To)<span class="required">※</span></td>
										<td class="input"><input class="" type="text" name="end_period" id="end_period"
										 value="<?php echo $_smarty_tpl->tpl_vars['form']->value->end_period;?>
" maxlength="10" onchange="changeDateFormat(this)"></td>
									</tr>
									<tr>
										<td>テスト名</td>
										<td class="input"><input class="text" type="text"
											name="test_name" id="test_name"
											value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->test_name, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "32" size="30"></td>
										<td width="10px"></td>
										<td>最終担当者</td>
										<td class="input">
											<?php if (($_smarty_tpl->tpl_vars['form']->value->rd_status1 == 0)) {?>
											   <input type="radio" id="rd_status1" name="rd_status1" value='0' checked>
											   <label for="rd_status1">すべて</label>
											<?php } else { ?>
											  <input type="radio" id="rd_status1" name="rd_status1" value='0'>
											  <label for="rd_status1">すべて</label>
											<?php }?>
											<?php if (($_smarty_tpl->tpl_vars['form']->value->rd_status1 == 1)) {?>
												<input type="radio" id="rd_status2" name="rd_status1" value='1' checked>
												<label for="rd_status2">自分のみ</label>
											<?php } else { ?>
											   <input type="radio" id="rd_status2" name="rd_status1" value='1'>
											   <label for="rd_status2">自分のみ</label>
											<?php }?>
										</td>
									</tr>
									<tr>
										<td>備考</td>
										<td class="input"><input class="text" type="text"
											name="remark" id="remark"
											value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->remark, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "512" size="30"></td>
										<td></td>
										<td>組織ログインID</td>
										<td><input class="text" type="text"
											name="search_org_id" id="search_org_id"
											maxlength = "32" size="30" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_org_id;?>
"></td>
									</tr>
									<tr>
										<td>状況</td>
											<td class="input">
											<?php if (!empty($_smarty_tpl->tpl_vars['form']->value->chk_status2 != '')) {?>
												<input type="checkbox" id="chk_status2" name="chk_status2" value='0' checked>
												<label for="chk_status2">非公開</label>
											<?php } else { ?>
												<input type="checkbox" id="chk_status2" name="chk_status2" value='0'>
												<label for="chk_status2">非公開</label>
											<?php }?>
											<?php if (($_smarty_tpl->tpl_vars['form']->value->chk_status1 != '')) {?>
												<input type="checkbox" id="chk_status1" name="chk_status1" value='1' checked>
												<label for="chk_status1">公開</label>
											<?php } else { ?>
												<input type="checkbox" id="chk_status1" name="chk_status1" value='1'>
												<label for="chk_status1">公開</label>
											<?php }?>

										</td>
										<td></td>
										<td></td>
									</tr>

								</table>
								<br>
								<div align="right" style="width:100%">
									<input type="submit" id="btn_search" name="search" title="検索" class="btn_search" alt="search" value="" style="padding-right:50px;">
									<!--20220309_事業部担当者対応-->
									<?php if ($_smarty_tpl->tpl_vars['admin_kbn']->value != "005") {?>
										<input type="button" id="add" name="add_test" class="btn_add" value="" title="新規追加" onclick="javascript:doInsert('<?php echo @constant('HOME_DIR');?>
TestRegist/index')">
									<?php }?>
								</div>

								<input type="hidden" id="page" name="page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->page;?>
" />
								<input type="hidden" id="home_dir" value="<?php echo @constant('HOME_DIR');?>
" />
								<?php if (!empty($_smarty_tpl->tpl_vars['list']->value)) {?>
								<table class="tbl_search" id="tbl_search" width="100%">
									<thead width="100%">
										<tr width="100%">
											<th width="100px;">組織ID</th>
											<th width="300px;">テスト名</th>
											<!-- <th width="100px">備考</th> -->
											<th width="100px">状況</th>
											<th width="200px">利用期限</th>
											<th width="100px">問題数</th>
											<th width="50px">割当</th>
											<th width="50px" >出題順</th>
											<th width="50px">複写</th>
											<th width="50px">複写</th>
											<th width="50px">確認</th>
											<th width="70px">編集</th>
										</tr>
									</thead>
									<tbody>
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
											<td width="100px"><?php echo $_smarty_tpl->tpl_vars['result']->value->org_id;?>
</td>
											<td width="300px;"><?php echo smarty_modifier_truncate(htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->test_name, ENT_QUOTES, 'UTF-8', true),40,'...');?>
 ( <?php echo $_smarty_tpl->tpl_vars['result']->value->test_type_name;?>
 )</td>
											<!-- <td width="100px"><?php echo smarty_modifier_truncate(htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->remark, ENT_QUOTES, 'UTF-8', true),20,'...');?>
</td> -->
											<td width="100px" id="td_chk_status"><?php echo $_smarty_tpl->tpl_vars['result']->value->status;?>
</td>
											<td width="200px"><?php echo $_smarty_tpl->tpl_vars['result']->value->start_period;?>
 ~ <br/> <?php echo $_smarty_tpl->tpl_vars['result']->value->end_period;?>
</td>
											<td width="100px"><?php echo $_smarty_tpl->tpl_vars['result']->value->quiz_count;?>
</td>
											<td width="50px">
												<input type="button" class="btn_quiz_assign_list" name="btn_quizassign" title="割当" onclick="assign('<?php echo $_smarty_tpl->tpl_vars['result']->value->org_no;?>
','<?php echo $_smarty_tpl->tpl_vars['result']->value->test_no;?>
','<?php echo @constant('HOME_DIR');?>
QuizAssignmentCheckbox/index')">
											</td>
											 <td width="50px">
												<input type="button" class="btn_quiz_assign_list" name="btn_quizassign" title="出題順" onclick="assign('<?php echo $_smarty_tpl->tpl_vars['result']->value->org_no;?>
','<?php echo $_smarty_tpl->tpl_vars['result']->value->test_no;?>
','<?php echo @constant('HOME_DIR');?>
QuizAssignment/index')">
											</td>
											<td width="50px">
												<!--20220309_事業部担当者対応-->
												<?php if ($_smarty_tpl->tpl_vars['admin_kbn']->value != "005") {?>
												<input type="button" class="btn_copy" name="edit" title="複写" onclick="copy('<?php echo $_smarty_tpl->tpl_vars['result']->value->org_no;?>
','<?php echo $_smarty_tpl->tpl_vars['result']->value->test_no;?>
','<?php echo @constant('HOME_DIR');?>
TestRegist/index')">
												<?php }?>
											</td>
											<td width="50px">
												<input type="button" class="btn_copy" name="edit" title="複写" onclick="copy('<?php echo $_smarty_tpl->tpl_vars['result']->value->org_no;?>
','<?php echo $_smarty_tpl->tpl_vars['result']->value->test_no;?>
','<?php echo @constant('HOME_DIR');?>
TestCopy/index')">
											</td>
											<td width="50px">
												<!--20220309_事業部担当者対応-->
												<?php if ($_smarty_tpl->tpl_vars['admin_kbn']->value != "005") {?>
													<input type="button" class="btn_preview_list" name="edit" title="確認" onclick="preview('<?php echo $_smarty_tpl->tpl_vars['result']->value->org_no;?>
','<?php echo $_smarty_tpl->tpl_vars['result']->value->test_no;?>
','<?php echo @constant('HOME_DIR');?>
TestPreview/index')">
												<?php }?>
											</td>
											<td width="70px">
												<input type="button" class="btn_edit" name="edit" title="編集" onclick="trans('<?php echo $_smarty_tpl->tpl_vars['result']->value->org_no;?>
','<?php echo $_smarty_tpl->tpl_vars['result']->value->test_no;?>
','<?php echo @constant('HOME_DIR');?>
TestRegist/index')">
											</td>
										</tr>
										<?php
$_smarty_tpl->tpl_vars['result'] = $__foreach_result_0_saved_local_item;
}
if ($__foreach_result_0_saved_item) {
$_smarty_tpl->tpl_vars['result'] = $__foreach_result_0_saved_item;
}
?>
									</tbody>
								</table>
								<?php }?>
							</section>
						</div>
					</div>
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
		
			// ページング
			function doPage(pageNo){
				$("#page").val(pageNo);
				$("#main_form").submit();
			}

			// 登録ボタン処理
			function doInsert(action){
			
				setDataTableData();

				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;
				$("#main_form").attr("action", action);
				$("#screen_mode").val("new");
		        $("#menuOpen").val(menuOpen);
		        $("#menuStatus").val(menuStatus);
				$("#main_form").submit();
			}


			// クイズ割当ボタン処理
			function assign(org_no,test_no, action){

				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;

				$("#search_start_period").val($("#start_period").val());
				$("#search_end_period").val($("#end_period").val());
				$("#search_test_name").val($("#test_name").val());
				$("#search_remark").val($("#remark").val());
				$("#search_rd_status1").val($("#rd_status1").val());
				$("#search_rd_status2").val($("#rd_status2").val());
				$("#search_rdstatus").val($("#rdstatus").val());
				$("#search_chk_status1").val("");

				if($("#chk_status1").prop('checked')){
					$("#search_chk_status1").val(1);
				}

				$("#search_chk_status2").val("");
				if($("#chk_status2").prop('checked')){
					$("#search_chk_status2").val(1);
				}
				$("#search_status").val($("#status").val());

				$("#search_rd_status1").val($('input[name=rd_status1]:checked').val());
				
				setDataTableData();

				$("#main_form").attr("action", action);
				$("#screen_mode").val("assign");
				$("#test_no").val(test_no);
				$("#org_no").val(org_no);
				//戻るの場合リストか登録かの画面を分けるため
				$("#btn_flg_type").val("1");
		        $("#menuOpen").val(menuOpen);
		        $("#menuStatus").val(menuStatus);
				$("#main_form").submit();
			}

			// 更新ボタン処理
			function trans(org_no,test_no,action){
				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;

				$("#search_start_period").val($("#start_period").val());
				$("#search_end_period").val($("#end_period").val());
				$("#search_test_name").val($("#test_name").val());
				$("#search_remark").val($("#remark").val());
				$("#search_rd_status1").val($("#rd_status1").val());
				$("#search_rd_status2").val($("#rd_status2").val());
				$("#search_rdstatus").val($("#rdstatus").val());
				$("#search_chk_status1").val("");

				if($("#chk_status1").prop('checked')){
					$("#search_chk_status1").val(1);
				}

				$("#search_chk_status2").val("");
				if($("#chk_status2").prop('checked')){
					$("#search_chk_status2").val(1);
				}
				$("#search_status").val($("#status").val());

				$("#search_rd_status1").val($('input[name=rd_status1]:checked').val());
				
				setDataTableData();

				$("#main_form").attr("action", action);
				$("#screen_mode").val("update");
				$("#test_no").val(test_no);
				$("#org_no").val(org_no);
		        $("#menuOpen").val(menuOpen);
		        $("#menuStatus").val(menuStatus);
				$("#main_form").submit();
			}

			// 複写ボタン処理
			function copy(org_no,test_no, action){

				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;

				$("#search_start_period").val($("#start_period").val());
				$("#search_end_period").val($("#end_period").val());
				$("#search_test_name").val($("#test_name").val());
				$("#search_remark").val($("#remark").val());
				$("#search_rd_status1").val($("#rd_status1").val());
				$("#search_rd_status2").val($("#rd_status2").val());
				$("#search_rdstatus").val($("#rdstatus").val());
				$("#search_chk_status1").val("");

				if($("#chk_status1").prop('checked')){
					$("#search_chk_status1").val(1);
				}

				$("#search_chk_status2").val("");
				if($("#chk_status2").prop('checked')){
					$("#search_chk_status2").val(1);
				}
				$("#search_status").val($("#status").val());

				$("#search_rd_status1").val($('input[name=rd_status1]:checked').val());
				
				setDataTableData();

				$("#main_form").attr("action", action);
				$("#screen_mode").val("copy");
				$("#test_no").val(test_no);
				$("#org_no").val(org_no);
		        $("#menuOpen").val(menuOpen);
		        $("#menuStatus").val(menuStatus);
				$("#main_form").submit();
			}

			// プレビューボタン処理
			function preview(org_no,test_no, action){

				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;

				$("#search_start_period").val($("#start_period").val());
				$("#search_end_period").val($("#end_period").val());
				$("#search_test_name").val($("#test_name").val());
				$("#search_remark").val($("#remark").val());
				$("#search_rd_status1").val($("#rd_status1").val());
				$("#search_rd_status2").val($("#rd_status2").val());
				$("#search_rdstatus").val($("#rdstatus").val());
				$("#search_chk_status1").val("");
				
				$("#org_no").val(org_no);

				if($("#chk_status1").prop('checked')){
					$("#search_chk_status1").val(1);
				}

				$("#search_chk_status2").val("");
				if($("#chk_status2").prop('checked')){
					$("#search_chk_status2").val(1);
				}
				$("#search_status").val($("#status").val());

				$("#search_rd_status1").val($('input[name=rd_status1]:checked').val());
				
				setDataTableData();

				$("#main_form").attr("action", action);
				$("#screen_mode").val("preview");
				$("#test_no").val(test_no);
		        $("#menuOpen").val(menuOpen);
		        $("#menuStatus").val(menuStatus);
				$("#main_form").submit();
			}
			
		function setDataTableData(){
		
			var page = 0;
			var page_row = 10;
			var order;
			var page_order_column = 1;
			var page_order_dir = true;
				
			//初期で登録する場合、データテーブルをチェックする
			if ( $.fn.DataTable.isDataTable( '#tbl_search' ) ){
			
				//データテーブルがある場合、確認ボタン、複写ボタンと編集ボタンの処理
				var table = $('#tbl_search').DataTable();
				var info = table.page.info();
				page = info.page;// データテーブルのページ
				page_row = table.page.info().length;// データテーブルのドロップダウンリストの行

				order = table.order();
				page_order_column = order[0][0];
				page_order_dir = order[0][1];
			}

			$("#search_page").val(page);
			$("#search_page_row").val(page_row);
			$("#search_page_order_column").val(page_order_column);
			$("#search_page_order_dir").val(page_order_dir);

		}
		
	<?php echo '</script'; ?>
>

	<!--footer-->
	<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

	<!--footer-->

	</body>
</html><?php }
}
