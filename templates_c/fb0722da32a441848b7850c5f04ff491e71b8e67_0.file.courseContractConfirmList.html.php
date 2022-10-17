<?php
/* Smarty version 3.1.29, created on 2022-10-17 05:26:49
  from "D:\xampp\htdocs\eccadmin_dev\templates\courseContractConfirmList.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_634ccb79935df1_44203131',
  'file_dependency' => 
  array (
    'fb0722da32a441848b7850c5f04ff491e71b8e67' => 
    array (
      0 => 'D:\\xampp\\htdocs\\eccadmin_dev\\templates\\courseContractConfirmList.html',
      1 => 1647423718,
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
function content_634ccb79935df1_44203131 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
	<head>
		<title>コース契約確認</title>
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
js/datatables.min.js"><?php echo '</script'; ?>
>
		
		<link href="<?php echo @constant('HOME_DIR');?>
css/jquery-ui.css" rel="stylesheet">
		<link href="<?php echo @constant('HOME_DIR');?>
css/default.css" rel="stylesheet">
		<link href="<?php echo @constant('HOME_DIR');?>
css/datatables.min.css" rel="stylesheet">

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

				$('#data_table tr').each(function() {

					var id = $(this).find("#login_id").text();
					if(id == ""){
						$(this).find(".btn_edit").css("display", "none");
					}
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

				 /**
				 *
				 *  検索ボタン押下、必須チェック処理
				 *
				 **/
				$("#btn_search").on('click', function(){

					$("#page").val(1);
					$(".error_section").hide();

					var start_period = document.getElementById('start_period').value;
					var end_period = document.getElementById('end_period').value;
					
					/** 組織の必須チェック 2019.07.12
					var org_id = document.getElementById('org_id').value;
					if ( org_id == "" ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("組織IDを入力してください。");
						return false;
					}*/

					// 利用開始の必須チェック
					if ( start_period == "" ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("利用開始日を入力してください。");
						return false;
					}

					// 利用終了の必須チェック
					if ( end_period == "" ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("利用終了日を入力してください。");
						return false;
					}

					// 利用開始 < 利用終了チェック
					if ( start_period > end_period ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("<?php echo @constant('W004');?>
");
						return false;
					}
					return true;
				});

				$('.btn_edit').on('click',function(){

					$(this).val('').attr('disabled','disabled');
					return true;
				});
				

				var current_order_column = $("#page_order_column_cccl").val();
				var current_order_dir = $("#page_order_dir_cccl").val();
				var current_page = parseInt($("#page_cccl").val()) || 0;
				var current_page_row = parseInt($("#page_row_cccl").val()) || 10;

				if ( current_order_column == ''){
					current_order_column = '1' ;
				}
				if ( current_order_dir == ''){
					current_order_dir = 'desc' ;
				}

				$('#data_table').DataTable( {
					"scrollY": 350,
					"scrollX": true,
					"bFilter": false,
					"ordering": true,
					"pageLength": current_page_row,
					"searching": true,
						"columns": [
							{ "searchable": false },
							{ "searchable": false },
							{ "searchable": true },
							{ "searchable": true },
							{ "searchable": true },
							{ "searchable": false },
							{ "searchable": true },
							{ "searchable": false },
							{ "searchable": true },
							{ "searchable": true },
							{ "searchable": false }
						],
					"aaSorting": [[current_order_column, current_order_dir]],
						columnDefs: [{
						orderable: false,
						targets: "th_img"}
					],
					"language": {
						"info":" _TOTAL_ 件中 _START_ から _END_ まで表示",
						"paginate": {
							"first":      "First",
							"last":       "Last",
							"next":       "次",
							"previous":   "前"
						},
						"lengthMenu":" _MENU_ 件表示",
						"sEmptyTable": "データがありません。",
						"infoEmpty": "0 件中 0 から 0 まで表示"
					 },
					 "createdRow": function( row, data, dataIndex ) {

					}
				});
				
				var table = $('#data_table').dataTable();
				table.fnPageChange(current_page);
				
			});
		<?php echo '</script'; ?>
>
	</head>
	<body class="pushmenu-push">
		<form id="main_form" action="<?php echo @constant('HOME_DIR');?>
CourseContractConfirmList/Search" method="post">
			<input type="hidden" id="course_id" name="course_id" />
			<input type="hidden" id="course_detail_no" name="course_detail_no" />
			<input type="hidden" id="org_no" name="org_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
" />
			<input type="hidden" id="offer_no" name="offer_no"/>
			<input type="hidden" id="student_no" name="student_no"/>
			<input type="hidden" id="home_dir" value="<?php echo @constant('HOME_DIR');?>
" />
			<input type="hidden" id="page" name="page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->page;?>
" />
			<input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
"/>
			<input type="hidden" id="search_org_id" name="search_org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_org_id;?>
"/>
			<input type="hidden" id="search_end_period" name="search_end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_end_period;?>
"/>
			<input type="hidden" id="search_start_period" name="search_start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_start_period;?>
"/>
			<input type="hidden" id="search_course_id_from" name="search_course_id_from" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_course_id_from;?>
"/>
			<input type="hidden" id="search_course_id_to" name="search_course_id_to" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_course_id_to;?>
"/>
			<input type="hidden" id="search_login_id_from" name="search_login_id_from" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_login_id_from;?>
"/>
			<input type="hidden" id="search_login_id_to" name="search_login_id_to" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_login_id_to;?>
"/>
			
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
						><span class="title">SW 状況 / コース契約確認</span>
					</p>
					<table style="width: 70%;">
						<tr>
							<td>組織ID</td>
							<td><input class="text" type="text" name="org_id" id="org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_id;?>
" maxlength = "32" size="30"></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>コースID</td>
							<td><input class="text" type="text" name="course_id_from" id="course_id_from" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->course_id_from;?>
" maxlength = "32" size="30"></td>
							<td style="padding-right: 40px;">～</td>
							<td><input class="text" type="text" name="course_id_to" id="course_id_to" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->course_id_to;?>
" maxlength = "32" size="30"></td>
						</tr>
						<tr>
							<td>コース期間<span class="required">※</span></td>
							<td><input class="" type="text" name="start_period" id="start_period"
							value="<?php echo $_smarty_tpl->tpl_vars['form']->value->start_period;?>
" maxlength="10" onchange="changeDateFormat(this)"></td>
							<td style="padding-right: 40px;">～</td>
							<td><input class="" type="text" name="end_period" id="end_period"
							value="<?php echo $_smarty_tpl->tpl_vars['form']->value->end_period;?>
" maxlength="10" onchange="changeDateFormat(this)"></td>
						</tr>
						<tr>
							<td>受講生ログインID</td>
							<td><input class="text" type="text" name="login_id_from" id="login_id_from" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->login_id_from;?>
" maxlength = "32" size="30"></td>
							<td style="padding-right: 40px;">～</td>
							<td><input class="text" type="text" name="login_id_to" id="login_id_to" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->login_id_to;?>
" maxlength = "32" size="30"></td>
						</tr>
					</table>
					<div align="right" style="width:100%">
						<input type="submit" id="btn_search" name="search" title="検索" class="btn_search" alt="search" value="" style="padding-right:50px;">
						<input class="btn_csv_dl" name="csv" type="button" value="" title="抽出" onclick="javascript:csvDownload('<?php echo @constant('HOME_DIR');?>
CourseContractConfirmList/csvWoc')">
					</div>
				<!-- 	<div class="pagging" align="right">
						<?php if (!empty($_smarty_tpl->tpl_vars['list']->value)) {?>
							<?php if ($_smarty_tpl->tpl_vars['form']->value->max_page >= 4) {?>
								<?php if ($_smarty_tpl->tpl_vars['form']->value->page > 1) {?>
									<a href="javascript:doPage(1);">&lt;&lt;</a>
									<a href="javascript:doPage(<?php echo $_smarty_tpl->tpl_vars['form']->value->page-1;?>
);">&lt;</a>
								<?php }?>
								<?php if ((($_smarty_tpl->tpl_vars['form']->value->page+3) == $_smarty_tpl->tpl_vars['form']->value->max_page) || (($_smarty_tpl->tpl_vars['form']->value->page+3) >= $_smarty_tpl->tpl_vars['form']->value->max_page)) {?>
								<?php
$__section_i_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_i']) ? $_smarty_tpl->tpl_vars['__smarty_section_i'] : false;
$__section_i_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['form']->value->max_page+1) ? count($_loop) : max(0, (int) $_loop));
$__section_i_0_start = (int)@$_smarty_tpl->tpl_vars['form']->value->max_page-3 < 0 ? max(0, (int)@$_smarty_tpl->tpl_vars['form']->value->max_page-3 + $__section_i_0_loop) : min((int)@$_smarty_tpl->tpl_vars['form']->value->max_page-3, $__section_i_0_loop);
$__section_i_0_total = min(($__section_i_0_loop - $__section_i_0_start), $__section_i_0_loop);
$_smarty_tpl->tpl_vars['__smarty_section_i'] = new Smarty_Variable(array());
if ($__section_i_0_total != 0) {
for ($__section_i_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] = $__section_i_0_start; $__section_i_0_iteration <= $__section_i_0_total; $__section_i_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']++){
?>
										<?php if ($_smarty_tpl->tpl_vars['form']->value->page == (isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)) {?>
											<label><?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null);?>
</label>
										<?php } else { ?>
											<a href="javascript:doPage(<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null);?>
);"><?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null);?>
</a>
										<?php }?>
									<?php
}
}
if ($__section_i_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_i'] = $__section_i_0_saved;
}
?>
								<?php } else { ?>
									<?php
$__section_i_1_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_i']) ? $_smarty_tpl->tpl_vars['__smarty_section_i'] : false;
$__section_i_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['form']->value->page+4) ? count($_loop) : max(0, (int) $_loop));
$__section_i_1_start = (int)@$_smarty_tpl->tpl_vars['form']->value->page < 0 ? max(0, (int)@$_smarty_tpl->tpl_vars['form']->value->page + $__section_i_1_loop) : min((int)@$_smarty_tpl->tpl_vars['form']->value->page, $__section_i_1_loop);
$__section_i_1_total = min(($__section_i_1_loop - $__section_i_1_start), $__section_i_1_loop);
$_smarty_tpl->tpl_vars['__smarty_section_i'] = new Smarty_Variable(array());
if ($__section_i_1_total != 0) {
for ($__section_i_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] = $__section_i_1_start; $__section_i_1_iteration <= $__section_i_1_total; $__section_i_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']++){
?>
										<?php if ($_smarty_tpl->tpl_vars['form']->value->page == (isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)) {?>
											<label><?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null);?>
</label>
										<?php } else { ?>
											<a href="javascript:doPage(<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null);?>
);"><?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null);?>
</a>
										<?php }?>
									<?php
}
}
if ($__section_i_1_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_i'] = $__section_i_1_saved;
}
?>
								<?php }?>
								<?php if ($_smarty_tpl->tpl_vars['form']->value->page <= $_smarty_tpl->tpl_vars['form']->value->max_page-1) {?>
									<a href="javascript:doPage(<?php echo $_smarty_tpl->tpl_vars['form']->value->page+1;?>
);">&gt;</a>
									<a href="javascript:doPage(<?php echo $_smarty_tpl->tpl_vars['form']->value->max_page;?>
);">&gt;&gt;</a>
								<?php }?>
							<?php } else { ?>
								<?php if ($_smarty_tpl->tpl_vars['form']->value->page > 1) {?>
									<a href="javascript:doPage(1);">&lt;&lt;</a>
									<a href="javascript:doPage(<?php echo $_smarty_tpl->tpl_vars['form']->value->page-1;?>
);">&lt;</a>
								<?php } else { ?>
									<a class="disable_link">&lt;</a>
								<?php }?>
									<?php
$__section_i_2_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_i']) ? $_smarty_tpl->tpl_vars['__smarty_section_i'] : false;
$__section_i_2_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['form']->value->max_page+1) ? count($_loop) : max(0, (int) $_loop));
$__section_i_2_start = min(1, $__section_i_2_loop);
$__section_i_2_total = min(($__section_i_2_loop - $__section_i_2_start), $__section_i_2_loop);
$_smarty_tpl->tpl_vars['__smarty_section_i'] = new Smarty_Variable(array());
if ($__section_i_2_total != 0) {
for ($__section_i_2_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] = $__section_i_2_start; $__section_i_2_iteration <= $__section_i_2_total; $__section_i_2_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']++){
?>
										<?php if ($_smarty_tpl->tpl_vars['form']->value->page == (isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)) {?>
											<label><?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null);?>
</label>
										<?php } else { ?>
											<a href="javascript:doPage(<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null);?>
);"><?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null);?>
</a>
										<?php }?>
									<?php
}
}
if ($__section_i_2_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_i'] = $__section_i_2_saved;
}
?>
								<?php if ($_smarty_tpl->tpl_vars['form']->value->page <= $_smarty_tpl->tpl_vars['form']->value->max_page-1) {?>
									<a href="javascript:doPage(<?php echo $_smarty_tpl->tpl_vars['form']->value->page+1;?>
);">&gt;</a>
									<a href="javascript:doPage(<?php echo $_smarty_tpl->tpl_vars['form']->value->max_page;?>
);">&gt;&gt;</a>
								<?php } else { ?>
									<a class="disable_link">&gt;</a>
								<?php }?>
							<?php }?>
					</div>
						<?php }?> -->
					<table class="tbl_search" id="data_table">
						<thead>
						<tr>
							<th width="50px">組織ID</th>
							<th width="100px">組織名</th>
							<th width="60px">Offer no</th>
							<th width="60px">コースID</th>
							<th width="100px">コース名</th>
							<th class="td_period">コース期間</th>
							<th width="100px;">コース詳細名</th>
							<th class="td_period">コース詳細期間</th>
							<th width="110px;">受講生ログインID</th>
							<th width="100px;">受講生名</th>
							<th class="td_img">編集</th>
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
								<td width="130px"><?php echo $_smarty_tpl->tpl_vars['result']->value->org_id;?>
</td>
								<td width="230px"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->org_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
								<td width="130px"><?php echo $_smarty_tpl->tpl_vars['result']->value->offer_no;?>
</td>
								<td width="130px"><?php echo $_smarty_tpl->tpl_vars['result']->value->course_id;?>
</td>
								<td width="230px"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->course_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
								<td ><?php echo $_smarty_tpl->tpl_vars['result']->value->co_start_period;?>
 ~ <?php echo $_smarty_tpl->tpl_vars['result']->value->co_end_period;?>
</td>
								<td width="230px"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->course_detail_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
								<td ><?php echo $_smarty_tpl->tpl_vars['result']->value->cds_start_period;?>
 ~ <?php echo $_smarty_tpl->tpl_vars['result']->value->cds_end_period;?>
</td>
								<td width="130px" id="login_id"><?php echo $_smarty_tpl->tpl_vars['result']->value->login_id;?>
</td>
								<td width="230px"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->student_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
								<td class="td_img">
									<input type="button" class="btn_edit" title="編集" name="edit" onclick="edit_trans('<?php echo $_smarty_tpl->tpl_vars['result']->value->offer_no;?>
','<?php echo $_smarty_tpl->tpl_vars['result']->value->org_no;?>
','<?php echo $_smarty_tpl->tpl_vars['result']->value->student_no;?>
','<?php echo $_smarty_tpl->tpl_vars['result']->value->course_id;?>
','<?php echo $_smarty_tpl->tpl_vars['result']->value->course_detail_no;?>
','<?php echo @constant('HOME_DIR');?>
StudentCourseDetailEdit/index')">
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
			

			//ページング
			function doPage(pageNo){

				$("#page").val(pageNo);
				$("#main_form").submit();
			}

			//編集ボタン処理
			function edit_trans(offer_no,org_no,student_no,course_id,course_detail_no,action){

				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;

				$("#search_page").val($("#page").val());
				$("#search_org_id").val($("#org_id").val());
				$("#search_start_period").val($("#start_period").val());
				$("#search_end_period").val($("#end_period").val());
				$("#search_course_id_from").val($("#course_id_from").val());
				$("#search_course_id_to").val($("#course_id_to").val());
				$("#search_login_id_from").val($("#login_id_from").val());
				$("#search_login_id_to").val($("#login_id_to").val());
				
				setDataTableData();

				$("#main_form").attr("action", action);
				$("#menuOpen").val(menuOpen);
				$("#menuStatus").val(menuStatus);
				$("#offer_no").val(offer_no);
				$("#org_no").val(org_no);
				$("#student_no").val(student_no);
				$("#course_id").val(course_id);
				$("#course_detail_no").val(course_detail_no);

				$("#main_form").submit();
			}

			// csvダウンロード処理
			function csvDownload(action){

				var start_period = document.getElementById('start_period').value;
				var end_period = document.getElementById('end_period').value;
				var course_id_from = document.getElementById('course_id_from').value;
				var course_id_to = document.getElementById('course_id_to').value;
				var login_id_from = document.getElementById('login_id_from').value;
				var login_id_to = document.getElementById('login_id_to').value;
				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;
				var home_dir = document.getElementById('home_dir').value;

				$("#main_form").attr("action", action);
				$("#start_period").val(start_period);
				$("#end_period").val(end_period);
				$("#course_id_from").val(course_id_from);
				$("#course_id_to").val(course_id_to);
				$("#login_id_from").val(login_id_from);
				$("#login_id_to").val(login_id_to);
				$("#menuOpen").val(menuOpen);
				$("#menuStatus").val(menuStatus);
				$("#main_form").submit();
				$("#main_form").attr("action", home_dir+"CourseContractConfirmList/Search");
			}
			
			function setDataTableData(){
				
				//初期で登録する場合、データテーブルをチェックする
				if ( ! $.fn.DataTable.isDataTable( '#data_table' ) ){
					var page = 0;
					var page_row = 10;
				}else{

					//データテーブルがある場合、確認ボタン、複写ボタンと編集ボタンの処理
					var table = $('#data_table').DataTable();
					var info = table.page.info();
					var page = info.page;// データテーブルのページ
					var page_row = table.page.info().length;// データテーブルのドロップダウンリストの行

					var order = table.order();
					var page_order_column = order[0][0];
					var page_order_dir = order[0][1];
				}

				console.log($("#page_order_column").val);

				$("#page_cccl").val(page);
				$("#page_row_cccl").val(page_row);
				$("#page_order_column_cccl").val(page_order_column);
				$("#page_order_dir_cccl").val(page_order_dir);
				if( page_order_column == null ){
					$("#page_order_column_cccl").val(1);
				}
				if( page_order_dir == null ){
					$("#page_order_dir_cccl").val(false);
				}
				
				$("#page_cccl").val($("#page_cccl").val());
				$("#page_row_cccl").val($("#page_row_cccl").val());
				$("#page_order_column_cccl").val($("#page_order_column_cccl").val());
				$("#page_order_dir_cccl").val($("#page_order_dir_cccl").val());
			}
			
		<?php echo '</script'; ?>
>
	</body>
</html><?php }
}
