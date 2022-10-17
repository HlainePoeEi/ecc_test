<?php
/* Smarty version 3.1.29, created on 2022-05-20 10:25:47
  from "/var/www/html/eccadmin_dev/templates/quizAssignmentCheckbox.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_6286ee1b14d4a6_77672253',
  'file_dependency' => 
  array (
    '0885de10ba6974610a09d856b92d05405910108f' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/quizAssignmentCheckbox.html',
      1 => 1629777220,
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
function content_6286ee1b14d4a6_77672253 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
	<title>クイズ割当</title>
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
 src="<?php echo @constant('HOME_DIR');?>
js/jquery-1.11.0.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('HOME_DIR');?>
js/escape.js"><?php echo '</script'; ?>
>
    <!-- <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('HOME_DIR');?>
js/datatables.js"><?php echo '</script'; ?>
> -->
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
css/groupstudentregist.css"	rel="stylesheet">
    <link href="<?php echo @constant('HOME_DIR');?>
css/datatables.css" rel="stylesheet">
	<link href="<?php echo @constant('HOME_DIR');?>
css/datatables_select.min.css" rel="stylesheet">
    <?php echo '<script'; ?>
>
		$(document).ready(function() {

			// MSGのあるなし
			if ( $(".error_msg").html() != "" ) {

				$(".error_section").slideDown('slow');
			}

			$(".close_icon").on('click',function(){

				$(".error_section").slideUp('slow');

			});

			//データテーブルを表示する
			var dataArray = $("#list").val();
			if (dataArray != "") {
				$('#quiz_assign_tbl_cb').DataTable( {
					"scrollY": 300,
					"scrollX": true,
					"bFilter": false,
					"ordering": false,
					 columnDefs: [ {
						"searchable": false,
						orderable: false,
						className: 'select-checkbox', targets:   0,
					} ],
					select: {
						style:    'multi',
						selector: 'td:first-child',
						info: false
					},
					"language": {
						"info":" _TOTAL_ 件中 _START_ から _END_ まで表示",
						 "paginate": {
							"first":	"First",
							"last": 	"Last",
							"next": 	"次",
							"previous": 	"前"
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
		});
	<?php echo '</script'; ?>
>
	</head>
	<body class="pushmenu-push">
	<form id="main_form" action="<?php echo @constant('HOME_DIR');?>
QuizAssignment/save" method="post">
	     <input type="hidden" id ="manager_no" name="manager_no"/>
	     <!-- 戻るの場合リストか登録かの画面を分けるため -->
		<input type="hidden" id="btn_flg_type" name="btn_flg_type" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->btn_flg_type;?>
" />
		<input type="hidden" id="test_test_name" name="test_test_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_test_name;?>
"/>
		<input type="hidden" id="test_type" name="test_type" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_type;?>
"/>
		<input type="hidden" id="ori_test_no" name="ori_test_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->ori_test_no;?>
"/>
		<input type="hidden" id="test_quiz_count" name="test_quiz_count" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_quiz_count;?>
"/>
		<input type="hidden" id="status" name="status" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->status;?>
" />
		<input type="hidden" id="description" name="description" value='<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->description, ENT_QUOTES, 'UTF-8', true);?>
' />
		<input type="hidden" id="test_start_period" name="test_start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_start_period;?>
" />
		<input type="hidden" id="test_end_period" name="test_end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_end_period;?>
" />
		<input type="hidden" id="test_remarks" name="test_remarks" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_remarks;?>
" />
		<input type="hidden" id="btn_value" name="btn_value" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->btn_value;?>
" />
		<input type="hidden" id="screen_mode" name="screen_mode" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->screen_mode;?>
"/>
		<input type="hidden" id="hd_test_type" name="hd_test_type" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->hd_test_type;?>
"/>
		<input type="hidden" id="test_btn_flg" name="test_btn_flg" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_btn_flg;?>
" />
		<input type="hidden" id="test_date_flg" name="test_date_flg" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_date_flg;?>
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

				<section class="error_section">
					<img src="<?php echo @constant('HOME_DIR');?>
image/close_icon.png" style="width:15px;float:right" class="close_icon">
					    <?php if (!empty($_smarty_tpl->tpl_vars['err_msg']->value)) {?>
						<div class="error_msg"><?php echo $_smarty_tpl->tpl_vars['err_msg']->value;?>
</div>
						<?php } else { ?>
						<div class="error_msg"></div>
						<?php }?>
				</section>
				<section class="content">
						<p>
							><span class="title">テスト / クイズ割当</span>
						</p>
						<p style="text-align:right;width:100%;">
							<input type="button" title="戻る" value="" class="btn_back" onclick="javascript:doBack('<?php echo @constant('HOME_DIR');?>
TestRegist/back')">
						</p>
						<input type="hidden" id="page" name="page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->page;?>
" />
						<input type="hidden" id="home_dir" value="<?php echo @constant('HOME_DIR');?>
" />
						<input type="hidden" id="entryList" name="entryList" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->entryList;?>
"/>
						<input type="hidden" name="test_no" id="test_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_no;?>
"/>
						<input type="hidden" name="org_no" id="org_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
"/>
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

						<table class="testAss_tbl">
							<tr>
								<td class="td_two">テスト名</td>
								<td class="td_input" ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->test_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
								<td class="td_two" style="padding-left: 100px">クイズ名</td>
								<td class="td_input"><input class="text" type="text"  name="quiz_name" id="quiz_name" maxlength="32" size="30" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->quiz_name;?>
"></td>
							</tr>
							<tr>
								<td class="td_two">テストタイプ</td>
								<?php if (($_smarty_tpl->tpl_vars['form']->value->test_type == '001')) {?>
				 					<td class="td_input">反復(SRS)</td>
				 				<?php } elseif (($_smarty_tpl->tpl_vars['form']->value->test_type == '002')) {?>
				 					<td class="td_input">通常</td>
								<?php } else { ?>
								    <td class="td_input">一回のみ</td>
								 <?php }?>
								 <td class="td_two" style="padding-left: 100px">備考</td>
								<td class="td_input"><input class="text" type="text"  name="remarks" id="remarks"
									 maxlength="32" size="30" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->remarks;?>
" /></td>
							</tr>
							<tr>
								<td class="td_two">利用期間</td>
								<td class="td_input"><?php echo $_smarty_tpl->tpl_vars['form']->value->start_period;?>
~<?php echo $_smarty_tpl->tpl_vars['form']->value->end_period;?>
</td>
								<td class="td_two" style="padding-left: 100px">最終担当者</td>
								<td class="input">
								<?php if (($_smarty_tpl->tpl_vars['form']->value->rd_status == 1)) {?>
									<label><input type="radio" id="rd_status1" name="rd_status1" value='0'>すべて</label>
				 					<label><input type="radio" id="rd_status1" name="rd_status1" value='1' checked="checked">自分のみ</label>
								<?php } else { ?>
				 					<label><input type="radio" id="rd_status1" name="rd_status1" value='0' checked="checked">すべて</label>
				 					<label><input type="radio" id="rd_status1" name="rd_status1" value='1'>自分のみ</label>
				 				<?php }?>
				 				</td>
							</tr>
						</table>
						<input class="text" type="hidden"  name="rd_status" id="rd_status" >
						<div class="pagging">
							<input type="button" value="" class="btn_search" onclick="doSearch('<?php echo @constant('HOME_DIR');?>
QuizAssignmentCheckbox/search');" />
						</div>
						 <?php if (!empty($_smarty_tpl->tpl_vars['list']->value)) {?>
						<table id="quiz_assign_tbl_cb" class="tbl_search" style="border-collapse: collapse; font-size: 1.0em;width:100%" style="display:none;">
							<thead>
					            <tr>
					                <th width="5%"></th>
					                <th width="25%">クイズ名</th>
					                <th width="35%">問題</th>
					                <th width="15%">タイプ</th>
					                <th>備考</th>
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
	        						<?php if ((in_array($_smarty_tpl->tpl_vars['result']->value->quiz_no,$_smarty_tpl->tpl_vars['data_list']->value))) {?>
	        							<?php $_smarty_tpl->tpl_vars["selected"] = new Smarty_Variable("selected", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "selected", 0);?>
	        						<?php } else { ?>
	 									<?php $_smarty_tpl->tpl_vars["selected"] = new Smarty_Variable('', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "selected", 0);?>
	        						<?php }?>
	        						<tr id="quiz_no_<?php echo $_smarty_tpl->tpl_vars['result']->value->quiz_no;?>
" class="<?php echo $_smarty_tpl->tpl_vars['selected']->value;?>
">
			        					<td></td>
										<td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->quiz_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
										<td><?php echo $_smarty_tpl->tpl_vars['result']->value->quiz_content;?>
</td>
										<td><?php echo $_smarty_tpl->tpl_vars['result']->value->quiz_type;?>
</td>
										<td><?php echo $_smarty_tpl->tpl_vars['result']->value->remarks;?>
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
						<table class="btn_div">
							<tr>
								<td>
								<input type="button" value="" class="btn_resetbtn" title="リセット"
								onclick="cancel('<?php echo @constant('HOME_DIR');?>
QuizAssignmentCheckbox/reset');">
								<input type="button" name="insert" value="" id="btn_insert" class="btn_insert" title="登録" onclick="productDisable('<?php echo @constant('HOME_DIR');?>
QuizAssignmentCheckbox/save');" />
								</td>
							</tr>
						</table>
						<?php }?>
				</section>
			</div>
			<!--footer-->
				<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<!--footer-->
	</form>

	<?php echo '<script'; ?>
>
		

		//検索ボタン
		function doSearch(action) {

			var status =$('input[name="rd_status1"]:checked', '#main_form').val();

			$('#rd_status').val(status);
			$("#main_form").attr("action", action);
			$("#main_form").submit();
		}

		function cancel(action) {

			$(".select-info").remove();
			getTotalRowCount();

			$("#main_form").attr("action", action);
			$("#main_form").submit();
		}

		function productDisable(action) {

			$("#main_form").attr("action", action);
			$("#main_form").submit();
		}

		$(function(){
			var entryList = [];
			$('#quiz_assign_tbl_cb tbody tr').each(function() {

				var quiz_no = $(this).attr('id');
				quiz_no = quiz_no.split("quiz_no_")[1];

				entryList = $("#entryList").val();
				entryList = entryList.split(",");

				var flag = $.inArray( quiz_no, entryList);

				if(flag != -1){
					$(this).addClass('selected');
				}
			});
			$("#quiz_assign_tbl_cb").show();
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

	      $('#quiz_assign_tbl_cb tbody tr').on('click', function(){

	        	var quiz_selected_list = $("#entryList").val();
	 			var quiz_no = $(this).attr('id');
	 			quiz_no = quiz_no.split("quiz_no_")[1];
	 			var selected_class = $(this).attr('class');
	 			selected_class = selected_class.split(" ");
	 			var table = $('#quiz_assign_tbl_cb').DataTable();

	 			if(selected_class.length > 1){

	 				var quiz_list = quiz_selected_list.split(",");
	 				var temp = $.inArray( quiz_no, quiz_list );
	 				if(temp != -1){
	 					quiz_selected_list = quiz_selected_list.replace(quiz_no+",", "");
	 				}
	 				$("#entryList").val(quiz_selected_list);
	 				$(this).toggleClass('selected');
	 			}else{

	 				if(quiz_selected_list == ""){

	 					quiz_selected_list += quiz_no + ",";
	 				}else{

	 					var quiz_list = quiz_selected_list.split(",");
	 					var temp = $.inArray( quiz_no, quiz_list );
	 					if(temp == -1){
	 						quiz_selected_list += quiz_no + ",";
	 					}
	 				}
	 				$(this).toggleClass('selected');
	 				$("#entryList").val(quiz_selected_list);
	 			}
	 			$(".select-info").remove();
	 			getTotalRowCount();
	      });

		
	<?php echo '</script'; ?>
>

	<!--footer-->
	<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

	<!--footer-->

	</body>
</html><?php }
}
