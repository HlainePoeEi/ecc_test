<?php
/* Smarty version 3.1.29, created on 2022-06-08 15:10:12
  from "/var/www/html/eccadmin_dev/templates/atReportTestRegist.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_62a03d443f6ef0_03735742',
  'file_dependency' => 
  array (
    'f5757014f011c89979c1ee8510ef4b406e8ff4d5' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/atReportTestRegist.html',
      1 => 1647234715,
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
function content_62a03d443f6ef0_03735742 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate')) require_once '/var/www/html/eccadmin_dev/libs/smarty/libs/plugins/modifier.truncate.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>Online Practice 試験設定</title>
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
js/datatables.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('HOME_DIR');?>
js/datables_select_box.js"><?php echo '</script'; ?>
>

<link href="<?php echo @constant('HOME_DIR');?>
css/jquery-ui.css" rel="stylesheet">
<link href="<?php echo @constant('HOME_DIR');?>
css/default.css" rel="stylesheet">
<link href="<?php echo @constant('HOME_DIR');?>
css/datatables.css" rel="stylesheet">
<link href="<?php echo @constant('HOME_DIR');?>
css/datatables_select.min.css" rel="stylesheet">
<link href="<?php echo @constant('HOME_DIR');?>
css/groupstudentregist.css"	rel="stylesheet">
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

				//データテーブルを表示する
			var dataArray = $("#list").val();
			if (dataArray != "") {
				$('#test_assign_tbl_cb').DataTable( {
					"scrollY": 300,
					"scrollX": true,
					"bFilter": false,
					"ordering": false,
					 columnDefs: [ {
						"searchable": false,
						orderable: false,
						className: 'select-checkbox', targets:	 0,
					} ],
					select: {
						style:	  'multi',
						selector: 'td:first-child',
						info: false
					},
					"language": {
						"info":" _TOTAL_ 件中 _START_ から _END_ まで表示",
						 "paginate": {
							"first":	"First",
							"last":		"Last",
							"next":		"次",
							"previous":		"前"
						},
						"lengthMenu":" _MENU_ 件表示"
					},
					"initComplete": function () {
						getTotalRowCount();
					},
					drawCallback: function(){

						$('.paginate_button', this.api().table().container()).on('click', function(){
							$(".select-info").remove();
							getTotalRowCount();
						});

						 $("#quiz_assign_tbl_cb_filter label input").on('keyup', function(){
							$(".select-info").remove();
							getTotalRowCount();
						});

						 $("#quiz_assign_tbl_cb_filter label input").on('click', function(){
							$(".select-info").remove();
							getTotalRowCount();
						});

						$("#quiz_assign_tbl_cb_length label select option").change(function() {
							$(".select-info").remove();
							getTotalRowCount();
						 });
					},
					order: [[ 1, 'asc' ]]
				});
			}

				/**
				 *
				 *	検索ボタン押下、必須チェック処理
				 *
				 **/
				$("#btn_search").on('click',function(){

					$(".error_section").hide();

					var $new_subject_area_no = "";

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
			var current_page = parseInt($("#search_page_til").val());
			var current_page_row = parseInt($("#search_page_row_til").val());
			var current_order_column = $("#search_page_order_column_til").val();
			var current_order_dir = $("#search_page_order_dir_til").val();
			
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
							"first":	  "First",
							"last":		  "Last",
							"next":		  "次",
							"previous":	  "前"
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
	<form id="main_form"
		action="<?php echo @constant('HOME_DIR');?>
AtReportTestRegist/Search" method="post">
		<input type="hidden" id="org_no" name="org_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
"/> 
		<input type="hidden" id="org_id" name="org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_id;?>
"/> 
		<input type="hidden" id="at_report_no" name="at_report_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->at_report_no;?>
"/>
		<input type="hidden" id="entryList" name="entryList" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->entryList;?>
"/>
		<input type="hidden" id="test_info_no" name="test_info_no" /> 
		<input type="hidden" id="screen_mode" name="screen_mode" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->screen_mode;?>
" /> 
		<input type="hidden" id="search_start_period" name="search_start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_start_period;?>
" /> 
		<input type="hidden" id="search_end_period" name="search_end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_end_period;?>
" /> 
		<input type="hidden" id="search_at_report_name" name="search_at_report_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->search_at_report_name, ENT_QUOTES, 'UTF-8', true);?>
" /> 
		<input type="hidden" id="search_test_info_name" name="search_test_info_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->search_test_info_name, ENT_QUOTES, 'UTF-8', true);?>
" /> 
		<input type="hidden" id="search_page_row_til" name="search_page_row_til" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_row_til;?>
" />
		<input type="hidden" id="search_page_order_column_til" name="search_page_order_column_til" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_column_til;?>
" />
		<input type="hidden" id="search_page_order_dir_til" name="search_page_order_dir_til" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_dir_til;?>
" />
		<input type="hidden" id="search_page_til" name="search_page_til" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_til;?>
" />

		<input type="hidden" id="search_org_id" name="search_org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_org_id;?>
" />
		<!-- 戻るの場合リストか登録かの画面を分けるため -->
		<input type="hidden" id="btn_flg_type" name="btn_flg_type" />
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
image/close_icon.png" style="width: 15px; float: right" class="close_icon"> 
						<?php if (!empty($_smarty_tpl->tpl_vars['err_msg']->value)) {?>
						<div class="error_msg"><?php echo $_smarty_tpl->tpl_vars['err_msg']->value;?>
</div>
						<?php } else { ?>
						<div class="error_msg"></div>
						<?php }?>
					</section>
					<section class="content">
						<p>
							><span class="title">Online Practice 試験設定</span>
						</p>
						<p style="text-align:right;width:100%;">
							<input type="button" title="戻る" value="" class="btn_back" onclick="javascript:doBack('<?php echo @constant('HOME_DIR');?>
AtReportTestRegist/back')">
						</p>
						<input type="hidden" id="status" name="status"
							value="<?php echo $_smarty_tpl->tpl_vars['form']->value->status;?>
">
						<table class="main_tbl" style="width: 100%">
							<tr>
								<td class="st_col">日付 (From)<span class="required">※</span></td>
								<td class="input"><input class="" type="text"
									name="start_period" id="start_period"
									value="<?php echo $_smarty_tpl->tpl_vars['form']->value->start_period;?>
" maxlength="10"
									onchange="changeDateFormat(this)"></td>
								<td width="10px"></td>
								<td class="st_col">日付 (To)<span class="required">※</span></td>
								<td class="input"><input class="" type="text"
									name="end_period" id="end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->end_period;?>
"
									maxlength="10" onchange="changeDateFormat(this)"></td>
							</tr>
							<tr>
								<td>試験名</td>
								<td class="input"><input class="text" type="text"
									name="test_info_name" id="test_info_name"
									value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->test_info_name, ENT_QUOTES, 'UTF-8', true);?>
" maxlength="32" size="30"></td>
								<td width="10px"></td>
								<td class="st_col"></td>
								<td class="input"></td>
							</tr>
							
							
						</table>
						<br>
						<div align="right" style="width:100%">
								<input type="button" id="btn_search" name="search" title="検索" class="btn_search" alt="search" value="" style="padding-right:50px;" onclick="javascript:doSearch('<?php echo @constant('HOME_DIR');?>
AtReportTestRegist/Search')">
						</div>

						<input type="hidden" id="page" name="page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->page;?>
" />
						<input type="hidden" id="home_dir"
							value="<?php echo @constant('HOME_DIR');?>
" />
						<?php if (!empty($_smarty_tpl->tpl_vars['list']->value)) {?>
						<table id="test_assign_tbl_cb" class="tbl_search" style="border-collapse: collapse; font-size: 1.0em;width:100%" style="display:none;">
							<thead>
								<tr>
									<th width="100px"></th>
									<th width="100px">組織ID</th>
									<th style="width:300px;!important">試験名</th>
									<th style="width:100px;!important">備考</th>
									<th width="100px">利用期間</th>
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
									<?php if ((in_array($_smarty_tpl->tpl_vars['result']->value->test_info_no,$_smarty_tpl->tpl_vars['data_list']->value))) {?>
										<?php $_smarty_tpl->tpl_vars["selected"] = new Smarty_Variable("selected", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "selected", 0);?>
									<?php } else { ?>
										<?php $_smarty_tpl->tpl_vars["selected"] = new Smarty_Variable('', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "selected", 0);?>
									<?php }?>
								<tr id="test_info_no_<?php echo $_smarty_tpl->tpl_vars['result']->value->test_info_no;?>
" class="<?php echo $_smarty_tpl->tpl_vars['selected']->value;?>
">
									<td></td>
									<td width="100px"><?php echo $_smarty_tpl->tpl_vars['result']->value->org_id;?>
</td>
									<td style="width:300px;!important"><?php echo smarty_modifier_truncate(htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->test_info_name, ENT_QUOTES, 'UTF-8', true),40,'...');?>
</td>
									<td style="width:100px;!important"><?php echo smarty_modifier_truncate(htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->remarks, ENT_QUOTES, 'UTF-8', true),20,'...');?>
</td>
									<td width="100px"><?php echo $_smarty_tpl->tpl_vars['result']->value->start_period;?>
 ~ <br />
										<?php echo $_smarty_tpl->tpl_vars['result']->value->end_period;?>

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
						<div style="width:100%; ">
							<table style="float:right;">
								<tr>
									<td style="width:70px;height:60px;">
										<input type="submit" name="insert" value="" id="btn_insert" class="btn_insert" title="登録" onclick="reporttestsave('<?php echo $_smarty_tpl->tpl_vars['result']->value->org_no;?>
','<?php echo $_smarty_tpl->tpl_vars['form']->value->at_report_no;?>
','<?php echo @constant('HOME_DIR');?>
AtReportTestRegist/save');">
									</td>
									
									
								</tr>
							</table>
						</div>
						<?php }?>
					</section>
				</div>
			</div>
		</div>
		<!-- End divBody -->
		<div class="divFooter">
			<!--footer-->
			<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<!--footer-->
		</div>
	</form>
	<?php echo '<script'; ?>
>
		

			function reporttestsave(org_no,report_no,action) {
			
				var array = [];
				var test_info_no = document.querySelectorAll('input[type=checkbox]:checked')

				for (var i = 0; i < test_info_no.length; i++) {
				
					array.push(test_info_no[i].value);
					
				}
				$("#checked_test").val(array);
				$("#org_no").val(org_no);
				$("#at_report_no").val(report_no);
				$("#main_form").attr("action", action);
				$("#main_form").submit();
			}
			
			$(function(){
				var entryList = [];
				$('#test_assign_tbl_cb tbody tr').each(function() {
	
					var test_info_no = $(this).attr('id');
					test_info_no = test_info_no.split("quiz_no_")[1];
	
					entryList = $("#entryList").val();
					entryList = entryList.split(",");
	
					var flag = $.inArray( test_info_no, entryList);
	
					if(flag != -1){
						$(this).addClass('selected');
					}
				});
				$("#test_assign_tbl_cb").show();
			});

			function getTotalRowCount(){

				var rowsCount = $("#entryList").val();
				rowsCount = rowsCount.split(",");
	
				 if(rowsCount.length > 0){
					 $(".dataTables_info").append("<span class=select-info>"+
								"<span class=select-item>"+ (rowsCount.length - 1) +" 行 選ばれた。</span>"+
								"<span class=select-item></span>"+
								"<span class=select-item></span>"+
							"</span>");
				 }
			}

			$('#test_assign_tbl_cb tbody tr').on('click', function(){

				var test_selected_list = $("#entryList").val();
				var test_info_no = $(this).attr('id');
				test_info_no = test_info_no.split("test_info_no_")[1];
				var selected_class = $(this).attr('class');
				selected_class = selected_class.split(" ");
				var table = $('#test_assign_tbl_cb').DataTable();

				if(selected_class.length > 1){

					var quiz_list = test_selected_list.split(",");
					var temp = $.inArray( test_info_no, quiz_list );
					if(temp != -1){
						test_selected_list = test_selected_list.replace(test_info_no+",", "");
					}
					$("#entryList").val(test_selected_list);
					$(this).toggleClass('selected');
				}else{

					if(test_selected_list == ""){

						test_selected_list += test_info_no + ",";
					}else{

						var quiz_list = test_selected_list.split(",");
						var temp = $.inArray( test_info_no, quiz_list );
						if(temp == -1){
							test_selected_list += test_info_no + ",";
						}
					}
					$(this).toggleClass('selected');
					$("#entryList").val(test_selected_list);
				}
				$(".select-info").remove();
				getTotalRowCount();
		  });
		
			function doBack(action){

				$("#main_form").attr("action", action);
				$("#main_form").submit();
			}
			
			function doSearch(action){

				$("#main_form").attr("action", action);
				$("#main_form").submit();
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
