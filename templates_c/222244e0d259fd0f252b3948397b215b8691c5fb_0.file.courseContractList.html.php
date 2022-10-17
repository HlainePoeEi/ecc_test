<?php
/* Smarty version 3.1.29, created on 2022-10-17 05:26:47
  from "D:\xampp\htdocs\eccadmin_dev\templates\courseContractList.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_634ccb77096f14_10217334',
  'file_dependency' => 
  array (
    '222244e0d259fd0f252b3948397b215b8691c5fb' => 
    array (
      0 => 'D:\\xampp\\htdocs\\eccadmin_dev\\templates\\courseContractList.html',
      1 => 1647488322,
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
function content_634ccb77096f14_10217334 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate')) require_once 'D:\\xampp\\htdocs\\eccadmin_dev\\libs\\smarty\\libs\\plugins\\modifier.truncate.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<title>コース契約一覧</title>
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

				// チェックされたテスト区分リストを取得する
				var el = document.getElementById('tk_check_div');
				var boxs = el.getElementsByTagName('input');
				var test_kbn = "";
				if($('#sc_test_kbn').val() != ''){
					test_kbn = $('#sc_test_kbn').val();
				}

				for (var i=0, len=boxs.length; i<len; i++) {
					if ( boxs[i].type === 'checkbox' ) {

						boxs[i].onclick = function() {
							// チェックボックスはチェックする場合、
							if ( this.checked ) {
								if (test_kbn == ""){
									test_kbn = this.value;
								}else {
									test_kbn += ',' + this.value;
								}
								// テスト区分リストの値をセットする
								$('#sc_test_kbn').val(test_kbn);
							}
							// チェックボックスクはチェックしない場合、
							else{
								var string = $('#sc_test_kbn').val();
								var cut1 = this.value +',';
								var cut2 = ',' + this.value;
								var cut = this.value ;
								var replace = string.search(cut) >= 0;
								var replace1 = string.search(cut1) >= 0;
								var replace2 = string.search(cut2) >= 0;
								if(replace1){
									var ret = string.replace(cut1,'');
								}else if(replace2){
									var ret = string.replace(cut2,'');
								}else if(replace){
									var ret = string.replace(cut,'');
								}
								// テスト区分リストの値をセットする
								$('#sc_test_kbn').val(ret);
								test_kbn = ret;
							}
						}
					}
				}

				// チェックされたコースレベルリストを取得する
				var el = document.getElementById('cl_check_div');
				var boxs = el.getElementsByTagName('input');
				var course_level = "";
				if ( $('#sc_course_level').val() != '' ){
					course_level = $('#sc_course_level').val();
				}

				for (var i=0, len=boxs.length; i<len; i++) {
					if ( boxs[i].type === 'checkbox' ) {

						boxs[i].onclick = function() {
							// チェックボックスはチェックする場合、
							if ( this.checked ) {
								if ( course_level == "" ){
									course_level = this.value;
								}else {
									course_level += ',' + this.value;
								}
								// コースレベルリストの値をセットする
								$('#sc_course_level').val(course_level);
							}
							// チェックボックスクはチェックしない場合、
							else {
								var string = $('#sc_course_level').val();
								var cut = this.value;
								var cut1 = this.value +',';
								var cut2 = ',' + this.value;
								var replace = string.search(cut) >= 0;
								var replace1 = string.search(cut1) >= 0;
								var replace2 = string.search(cut2) >= 0;
								if ( replace1 ){
									var ret = string.replace(cut1,'');
								}else if ( replace2 ){
									var ret = string.replace(cut2,'');
								}else if ( replace ){
									var ret = string.replace(cut,'');
								}
								// コースレベルリストの値をセットする
								$('#sc_course_level').val(ret);
								course_level = ret;
							}
						}
					}
				}
				/**
				*
				*  検索ボタン押下、必須チェック処理
				*
				**/
				$("#btn_search").on('click',function(){

					$("#page").val(1);
					$(".error_section").hide();

					var start_period = document.getElementById('start_period').value;
					var end_period = document.getElementById('end_period').value;
					// コース期間開始日の必須チェック
					if ( start_period == "" ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("コース期間開始日を入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					// コース期間終了日の必須チェック
					if ( end_period == "" ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("コース期間終了日を入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					// コース期間開始日 < コース期間終了日チェック
					if ( start_period > end_period ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("コース期間開始日 ≦ コース期間終了日を正しく入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}
					return true;
				});

				$('.btn_add').on('click',function(){

					$(this).val('').attr('disabled','disabled');
					return true;
				});

				$('.btn_edit').on('click',function(){

					$(this).val('').attr('disabled','disabled');
					return true;
				});
				
				var current_order_column = $("#page_order_column_ccl").val();
				var current_order_dir = $("#page_order_dir_ccl").val();
				var current_page = parseInt($("#page_ccl").val()) || 0;
				var current_page_row = parseInt($("#page_row_ccl").val()) || 10;

				if ( current_order_column == ''){
					current_order_column = '1' ;
				}
				if ( current_order_dir == ''){
					current_order_dir = 'desc' ;
				}
				
				$('#tbl_search').DataTable( {
					"scrollY": 350,
					"scrollX": true,
					"bFilter": false,
					"ordering": true,
					"pageLength": current_page_row,
					"searching": true,
						"columns": [
							{ "searchable": true },
							{ "searchable": true },
							{ "searchable": true },
							{ "searchable": true },
							{ "searchable": true },
							{ "searchable": true },
							{ "searchable": false },
							{ "searchable": false },
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
				
				var table = $('#tbl_search').dataTable();
				table.fnPageChange(current_page);
			});
		<?php echo '</script'; ?>
>
	</head>
	<body class="pushmenu-push">
		<form id="main_form" action="<?php echo @constant('HOME_DIR');?>
CourseContractList/Search" method="post">
			<input type="hidden" id="admin_no" name="admin_no"/>
			<input type="hidden" id="home_dir" value="<?php echo @constant('HOME_DIR');?>
" />
			<input type="hidden" id="page" name="page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->page;?>
" />
			<input type="hidden" id="org_no" name="org_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
" />
			<input type="hidden" id="se_course_id" name="se_course_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->course_id;?>
" />
			<input type="hidden" id="offer_no" name="offer_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->offer_no;?>
" />
			<input type="hidden" id="org_id" name="org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_id;?>
" />
			<input type="hidden" id="sc_test_kbn" name="sc_test_kbn" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->sc_test_kbn;?>
" />
			<input type="hidden" id="sc_course_level" name="sc_course_level" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->sc_course_level;?>
" />
			<input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
"/>
			<input type="hidden" id="search_end_period" name="search_end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_end_period;?>
"/>
			<input type="hidden" id="search_start_period" name="search_start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_start_period;?>
"/>
			<input type="hidden" id="search_course_name" name="search_course_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_course_name;?>
"/>
			<input type="hidden" id="search_test_kbn" name="search_test_kbn" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_test_kbn;?>
" />
			<input type="hidden" id="search_course_level" name="search_course_level" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_course_level;?>
" />
			<input type="hidden" id="search_org_id" name="search_org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_org_id;?>
" />
			<input type="hidden" id="search_org_name" name="search_org_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_org_name;?>
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
						<?php if (!empty($_smarty_tpl->tpl_vars['err_msg']->value)) {?>
							<div class="error_msg"><?php echo $_smarty_tpl->tpl_vars['err_msg']->value;?>
</div>
						<?php } else { ?>
							<div class="error_msg"></div>
						<?php }?>
					</section>
				</div>
				<section class="content">
					<p>
						><span class="title">SW 申込 / コース契約一覧</span>
					</p>
					<table class="main_tbl">
						<tr>
							<td>組織ID</td>
							<td class="input">
								<input class="text" type="text" name="sc_org_id" id="sc_org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->sc_org_id;?>
" maxlength = "32" size="30">
							</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>組織名</td>
							<td class="input">
								<input class="text" type="text" name="sc_org_name" id="sc_org_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->sc_org_name;?>
" maxlength = "32" size="30">
							</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>SW</td>
							<td class="input">
								<div id="tk_check_div">
									<?php if (!empty($_smarty_tpl->tpl_vars['form']->value->test_kbn_list)) {?>
										<?php
$_from = $_smarty_tpl->tpl_vars['form']->value->test_kbn_list;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_i_0_saved_item = isset($_smarty_tpl->tpl_vars['i']) ? $_smarty_tpl->tpl_vars['i'] : false;
$__foreach_i_0_saved_key = isset($_smarty_tpl->tpl_vars['value']) ? $_smarty_tpl->tpl_vars['value'] : false;
$_smarty_tpl->tpl_vars['i'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['value'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['i']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value => $_smarty_tpl->tpl_vars['i']->value) {
$_smarty_tpl->tpl_vars['i']->_loop = true;
$__foreach_i_0_saved_local_item = $_smarty_tpl->tpl_vars['i'];
?>
										<?php $_smarty_tpl->tpl_vars['temp'] = new Smarty_Variable('0', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'temp', 0);?>
											<?php if (!empty($_smarty_tpl->tpl_vars['ck_tk_list']->value)) {?>
												<?php
$_from = $_smarty_tpl->tpl_vars['ck_tk_list']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_j_1_saved_item = isset($_smarty_tpl->tpl_vars['j']) ? $_smarty_tpl->tpl_vars['j'] : false;
$__foreach_j_1_saved_key = isset($_smarty_tpl->tpl_vars['cktk']) ? $_smarty_tpl->tpl_vars['cktk'] : false;
$_smarty_tpl->tpl_vars['j'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['cktk'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['j']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['cktk']->value => $_smarty_tpl->tpl_vars['j']->value) {
$_smarty_tpl->tpl_vars['j']->_loop = true;
$__foreach_j_1_saved_local_item = $_smarty_tpl->tpl_vars['j'];
?>
													<?php if (($_smarty_tpl->tpl_vars['i']->value->type == $_smarty_tpl->tpl_vars['j']->value)) {?>
														<?php $_smarty_tpl->tpl_vars['temp'] = new Smarty_Variable('1', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'temp', 0);?>
													<?php }?>
												<?php
$_smarty_tpl->tpl_vars['j'] = $__foreach_j_1_saved_local_item;
}
if ($__foreach_j_1_saved_item) {
$_smarty_tpl->tpl_vars['j'] = $__foreach_j_1_saved_item;
}
if ($__foreach_j_1_saved_key) {
$_smarty_tpl->tpl_vars['cktk'] = $__foreach_j_1_saved_key;
}
?>
											<?php }?>
											<?php if ($_smarty_tpl->tpl_vars['temp']->value == '1') {?>
												<label><input type="checkbox" id="check_tk" name="check_tk" value='<?php echo $_smarty_tpl->tpl_vars['i']->value->type;?>
' checked><?php echo $_smarty_tpl->tpl_vars['i']->value->name;?>
</label>
											<?php } else { ?>
												<label><input type="checkbox" id="check_tk" name="check_tk" value='<?php echo $_smarty_tpl->tpl_vars['i']->value->type;?>
'><?php echo $_smarty_tpl->tpl_vars['i']->value->name;?>
</label>
											<?php }?>
										<?php
$_smarty_tpl->tpl_vars['i'] = $__foreach_i_0_saved_local_item;
}
if ($__foreach_i_0_saved_item) {
$_smarty_tpl->tpl_vars['i'] = $__foreach_i_0_saved_item;
}
if ($__foreach_i_0_saved_key) {
$_smarty_tpl->tpl_vars['value'] = $__foreach_i_0_saved_key;
}
?>
									<?php }?>
								</div>
							</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>レベル</td>
							<td class="input">
								<div id="cl_check_div">
									<?php if (!empty($_smarty_tpl->tpl_vars['form']->value->course_level_list)) {?>
										<?php
$_from = $_smarty_tpl->tpl_vars['form']->value->course_level_list;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_i_2_saved_item = isset($_smarty_tpl->tpl_vars['i']) ? $_smarty_tpl->tpl_vars['i'] : false;
$__foreach_i_2_saved_key = isset($_smarty_tpl->tpl_vars['value']) ? $_smarty_tpl->tpl_vars['value'] : false;
$_smarty_tpl->tpl_vars['i'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['value'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['i']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value => $_smarty_tpl->tpl_vars['i']->value) {
$_smarty_tpl->tpl_vars['i']->_loop = true;
$__foreach_i_2_saved_local_item = $_smarty_tpl->tpl_vars['i'];
?>
										<?php $_smarty_tpl->tpl_vars['temp'] = new Smarty_Variable('0', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'temp', 0);?>
											<?php if (!empty($_smarty_tpl->tpl_vars['ck_cl_list']->value)) {?>
												<?php
$_from = $_smarty_tpl->tpl_vars['ck_cl_list']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_j_3_saved_item = isset($_smarty_tpl->tpl_vars['j']) ? $_smarty_tpl->tpl_vars['j'] : false;
$__foreach_j_3_saved_key = isset($_smarty_tpl->tpl_vars['cktk']) ? $_smarty_tpl->tpl_vars['cktk'] : false;
$_smarty_tpl->tpl_vars['j'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['cktk'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['j']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['cktk']->value => $_smarty_tpl->tpl_vars['j']->value) {
$_smarty_tpl->tpl_vars['j']->_loop = true;
$__foreach_j_3_saved_local_item = $_smarty_tpl->tpl_vars['j'];
?>
													<?php if (($_smarty_tpl->tpl_vars['i']->value->type == $_smarty_tpl->tpl_vars['j']->value)) {?>
														<?php $_smarty_tpl->tpl_vars['temp'] = new Smarty_Variable('1', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'temp', 0);?>
													<?php }?>
												<?php
$_smarty_tpl->tpl_vars['j'] = $__foreach_j_3_saved_local_item;
}
if ($__foreach_j_3_saved_item) {
$_smarty_tpl->tpl_vars['j'] = $__foreach_j_3_saved_item;
}
if ($__foreach_j_3_saved_key) {
$_smarty_tpl->tpl_vars['cktk'] = $__foreach_j_3_saved_key;
}
?>
											<?php }?>
											<?php if ($_smarty_tpl->tpl_vars['temp']->value == '1') {?>
												<label><input type="checkbox" id="check_tk" name="check_tk" value='<?php echo $_smarty_tpl->tpl_vars['i']->value->type;?>
' checked><?php echo $_smarty_tpl->tpl_vars['i']->value->name;?>
</label>
											<?php } else { ?>
												<label><input type="checkbox" id="check_tk" name="check_tk" value='<?php echo $_smarty_tpl->tpl_vars['i']->value->type;?>
'><?php echo $_smarty_tpl->tpl_vars['i']->value->name;?>
</label>
											<?php }?>
										<?php
$_smarty_tpl->tpl_vars['i'] = $__foreach_i_2_saved_local_item;
}
if ($__foreach_i_2_saved_item) {
$_smarty_tpl->tpl_vars['i'] = $__foreach_i_2_saved_item;
}
if ($__foreach_i_2_saved_key) {
$_smarty_tpl->tpl_vars['value'] = $__foreach_i_2_saved_key;
}
?>
									<?php }?>
								</div>
							</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>コース名</td>
							<td class="input">
								<input class="text" type="text" name="sc_course_name" id="sc_course_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->sc_course_name;?>
" maxlength = "32" size="30">
							</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td class="st_col">コース期間開始日<span class="required">※</span></td>
							<td class="input" style="width:250px;"><input class="" type="text" name="start_period" id="start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->start_period;?>
" maxlength="10" onchange="changeDateFormat(this)"></td>
							<td width="10px"></td>
							<td class="st_col">コース期間終了日<span class="required">※</span></td>
							<td class="input"><input class="" type="text" name="end_period" id="end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->end_period;?>
" maxlength="10" onchange="changeDateFormat(this)"></td>
						</tr>
					</table>
					<br/>
					<div align="right" style="width:100%">
						<input type="submit" id="btn_search" name="search" title="検索" class="btn_search" alt="search" value="" style="padding-right:50px;">
						<input type="button" id="add" name="add_test" class="btn_add" value="" title="新規追加" onclick="javascript:doInsert('<?php echo @constant('HOME_DIR');?>
CourseContractRegist/index')">
					</div>

					<!-- ページングdiv -->
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
						<?php }?>
					</div> -->

					<!-- コース契約一覧テーブル -->
					<table class="tbl_search" id="tbl_search">
						<thead>
						<tr>
							<th width="100px">組織ID</th>
							<th width="200px">組織名</th>
							<th width="100px">Offer no</th>
							<th width="100px">SW</th>
							<th width="100px">レベル</th>
							<th class="200px">コース名</th>
							<th class="td_period">コース期間</th>
							<th width="100px">受講生数</th>
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
$__foreach_result_4_saved_item = isset($_smarty_tpl->tpl_vars['result']) ? $_smarty_tpl->tpl_vars['result'] : false;
$_smarty_tpl->tpl_vars['result'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['result']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['result']->value) {
$_smarty_tpl->tpl_vars['result']->_loop = true;
$__foreach_result_4_saved_local_item = $_smarty_tpl->tpl_vars['result'];
?>
							<tr>
								<td width="100px"><?php echo $_smarty_tpl->tpl_vars['result']->value->org_id;?>
</td>
								<td width="200px"><?php echo smarty_modifier_truncate(htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->org_name, ENT_QUOTES, 'UTF-8', true),15,'...');?>
</td>
								<td width="130px"><?php echo $_smarty_tpl->tpl_vars['result']->value->offer_no;?>
</td>
								<td width="100px"><?php echo $_smarty_tpl->tpl_vars['result']->value->test_kbn;?>
</td>
								<td width="100px"><?php echo $_smarty_tpl->tpl_vars['result']->value->course_level;?>
</td>
								<td width="200px"><?php echo smarty_modifier_truncate(htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->course_name, ENT_QUOTES, 'UTF-8', true),20,'...');?>
</td>
								<td class="td_period"><?php echo $_smarty_tpl->tpl_vars['result']->value->start_period;?>
 ~ <?php echo $_smarty_tpl->tpl_vars['result']->value->end_period;?>
</td>
								<td width="100px" style="padding-left: 20px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->student_count;?>
</td>
								<td class="td_img">
									<input type="button" class="btn_edit" title="編集" name="edit" onclick="edit_trans('<?php echo $_smarty_tpl->tpl_vars['result']->value->offer_no;?>
','<?php echo $_smarty_tpl->tpl_vars['result']->value->org_no;?>
','<?php echo $_smarty_tpl->tpl_vars['result']->value->course_id;?>
','<?php echo $_smarty_tpl->tpl_vars['result']->value->org_id;?>
','<?php echo @constant('HOME_DIR');?>
CourseContractRegist/index')">
								</td>
							</tr>
							<?php
$_smarty_tpl->tpl_vars['result'] = $__foreach_result_4_saved_local_item;
}
if ($__foreach_result_4_saved_item) {
$_smarty_tpl->tpl_vars['result'] = $__foreach_result_4_saved_item;
}
?>
						<?php }?>
						</tbody>
					</table>
					<br>
				</section>
			</div>
			<!--footer-->
				<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<!--footer-->
		</form>

		<?php echo '<script'; ?>
>
			

			// データテーブル変更対応、不要なのでコメントアウト
		/*	//ページング
			function doPage(pageNo){

				$("#page").val(pageNo);
				$("#main_form").submit();
			} 
		*/
		
			//編集ボタン処理
			function edit_trans(offer_no,org_no,course_id,org_id,action){
				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;

				$("#search_page").val($("#page").val());
				$("#search_start_period").val($("#start_period").val());
				$("#search_end_period").val($("#end_period").val());
				$("#search_org_id").val($("#sc_org_id").val());
				$("#search_org_name").val($("#sc_org_name").val());
				$("#search_test_kbn").val($("#sc_test_kbn").val());
				$("#search_course_level").val($("#sc_course_level").val());
				$("#search_course_name").val($("#sc_course_name").val());

				setDataTableData();

				$("#main_form").attr("action", action);
				$("#menuOpen").val(menuOpen);
				$("#menuStatus").val(menuStatus);
				$("#org_id").val(org_id);
				$("#org_no").val(org_no);
				$("#offer_no").val(offer_no);
				$("#se_course_id").val(course_id);

				$("#main_form").submit();
			}

			//登録ボタン処理
			function doInsert(action){
				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;

				$("#search_page").val($("#page").val());
				$("#search_start_period").val($("#start_period").val());
				$("#search_end_period").val($("#end_period").val());
				$("#search_org_id").val($("#sc_org_id").val());
				$("#search_org_name").val($("#sc_org_name").val());
				$("#search_test_kbn").val($("#sc_test_kbn").val());
				$("#search_course_level").val($("#sc_course_level").val());
				$("#search_course_name").val($("#sc_course_name").val());

				setDataTableData();
				
				$("#main_form").attr("action", action);
				$("#menuOpen").val(menuOpen);
				$("#menuStatus").val(menuStatus);
				$("#main_form").submit();
			}
			
			function setDataTableData(){
				
				//初期で登録する場合、データテーブルをチェックする
				if ( ! $.fn.DataTable.isDataTable( '#tbl_search' ) ){
					var page = 0;
					var page_row = 10;
				}else{

					//データテーブルがある場合、確認ボタン、複写ボタンと編集ボタンの処理
					var table = $('#tbl_search').DataTable();
					var info = table.page.info();
					var page = info.page;// データテーブルのページ
					var page_row = table.page.info().length;// データテーブルのドロップダウンリストの行

					var order = table.order();
					var page_order_column = order[0][0];
					var page_order_dir = order[0][1];
				}

				console.log($("#page_order_column").val);

				$("#page_ccl").val(page);
				$("#page_row_ccl").val(page_row);
				$("#page_order_column_ccl").val(page_order_column);
				$("#page_order_dir_ccl").val(page_order_dir);
				if( page_order_column == null ){
					$("#page_order_column_ccl").val(1);
				}
				if( page_order_dir == null ){
					$("#page_order_dir_ccl").val(false);
				}
				
				$("#page_ccl").val($("#page_ccl").val());
				$("#page_row_ccl").val($("#page_row_ccl").val());
				$("#page_order_column_ccl").val($("#page_order_column_ccl").val());
				$("#page_order_dir_ccl").val($("#page_order_dir_ccl").val());
			}
		
	<?php echo '</script'; ?>
>
	</body>
</html><?php }
}
