<?php
/* Smarty version 3.1.29, created on 2022-06-13 17:41:45
  from "/var/www/html/eccadmin_dev/templates/teacherCourseDetailAssignment.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_62a6f8497a5762_02067037',
  'file_dependency' => 
  array (
    'c650520328ab0c4d7cf1ae6682c2c1a324395762' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/teacherCourseDetailAssignment.html',
      1 => 1545797420,
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
function content_62a6f8497a5762_02067037 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
	<head>
		<title>コース詳細割当</title>
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
		<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('HOME_DIR');?>
js/datables_select_box.js"><?php echo '</script'; ?>
>
		
		<link href="<?php echo @constant('HOME_DIR');?>
css/jquery-ui.css" rel="stylesheet">
		<link href="<?php echo @constant('HOME_DIR');?>
css/style.css" rel="stylesheet">
		<link href="<?php echo @constant('HOME_DIR');?>
css/datatables.min.css" rel="stylesheet">
		<link href="<?php echo @constant('HOME_DIR');?>
css/datatables_select.min.css" rel="stylesheet">
		<link href="<?php echo @constant('HOME_DIR');?>
css/default.css" rel="stylesheet">
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

			$('#teacher_course_detail_list').DataTable( {
				"scrollY": 300,
				"scrollX": true,
				"bFilter": false,
				"ordering": false,
				select : true,
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
								"first":      "First",
								"last":       "Last",
								"next":       "次",
								"previous":   "前"
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

					 $("#teacher_course_detail_list_filter label input").on('keyup', function(){
						$(".select-info").remove();
						getTotalRowCount();
					});

					 $("#teacher_course_detail_list_filter label input").on('click', function(){
						$(".select-info").remove();
						getTotalRowCount();
					});

					$("#teacher_course_detail_list_length label select option").change(function() {
						$(".select-info").remove();
						getTotalRowCount();
					 });
				},
				order: [[ 1, 'asc' ]]
			});
		});
	<?php echo '</script'; ?>
>
	</head>
	<body class="pushmenu-push">
		<form autocomplete="off" id="main_form" action="<?php echo @constant('HOME_DIR');?>
TeacherCourseDetailAssignment/Save" method="post">
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
						><span class="title">講師/コース詳細割当</span>
					</p>
					<p style="text-align:right"><input type="button" title="戻る" value="" class="btn_back" onclick="javascript:doBack('<?php echo @constant('HOME_DIR');?>
TeacherCourseDetailAssignment/back')"></p>

					<input type="hidden" id="teacher_no" name="teacher_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->teacher_no;?>
" />
					<input type="hidden" id="login_id" name="login_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->login_id;?>
" />
					<input type="hidden" id="nick_name" name="nick_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->nick_name;?>
" />
					<input type="hidden" id="t_name" name="t_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->t_name;?>
" />
					<input type="hidden" id="display_name" name="display_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->display_name;?>
" />
					<input type="hidden" id="search_test_kbn" name="search_test_kbn" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_test_kbn;?>
" />
					<input type="hidden" id="search_course_level" name="search_course_level" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_course_level;?>
" />
					<input type="hidden" id="entryList" name="entryList" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->entryList;?>
"/>
					<input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
"/>
					<input type="hidden" id="search_name" name="search_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_name;?>
" />
					<input type="hidden" id="back_flg" name="back_flg" value="1" />
					<input type="hidden" id="search_end_period" name="search_end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_end_period;?>
"/>
					<input type="hidden" id="search_start_period" name="search_start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_start_period;?>
"/>
					<input type="hidden" id="search_school_kbn" name="search_school_kbn" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_school_kbn;?>
" />

					<table>
						<tr>
							<td style="width:150px;">講師名</td>
							<td>
								<span><?php echo $_smarty_tpl->tpl_vars['form']->value->login_id;?>
</span>&nbsp;
								<span><?php echo $_smarty_tpl->tpl_vars['form']->value->t_name;?>
</span>&nbsp;
								<span><?php echo $_smarty_tpl->tpl_vars['form']->value->nick_name;?>
&nbsp;</span>
								<span><?php echo $_smarty_tpl->tpl_vars['form']->value->display_name;?>
</span>
							</td>
						</tr>
						<tr>
							<td style="width:150px;">レベル</td>
							<td>
								<?php if (!empty($_smarty_tpl->tpl_vars['course_level']->value)) {?>
									<?php
$_from = $_smarty_tpl->tpl_vars['course_level']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_item_0_saved_item = isset($_smarty_tpl->tpl_vars['item']) ? $_smarty_tpl->tpl_vars['item'] : false;
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['item']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$__foreach_item_0_saved_local_item = $_smarty_tpl->tpl_vars['item'];
?>
										<?php if ((in_array($_smarty_tpl->tpl_vars['item']->value->type,$_smarty_tpl->tpl_vars['search_course_level']->value))) {?>
											<label><input type="checkbox" class="course_level" name="course_level" value='<?php echo $_smarty_tpl->tpl_vars['item']->value->type;?>
' checked><?php echo $_smarty_tpl->tpl_vars['item']->value->name;?>
</label>
										<?php } else { ?>
											<label><input type="checkbox" class="course_level" name="course_level" value='<?php echo $_smarty_tpl->tpl_vars['item']->value->type;?>
' ><?php echo $_smarty_tpl->tpl_vars['item']->value->name;?>
</label>
										<?php }?>
									<?php
$_smarty_tpl->tpl_vars['item'] = $__foreach_item_0_saved_local_item;
}
if ($__foreach_item_0_saved_item) {
$_smarty_tpl->tpl_vars['item'] = $__foreach_item_0_saved_item;
}
?>
								<?php }?>
							</td>
						</tr>
						<tr>
							<td style="width:150px;">SW</td>
							<td>
								<?php if (!empty($_smarty_tpl->tpl_vars['test_kbn']->value)) {?>
									<?php
$_from = $_smarty_tpl->tpl_vars['test_kbn']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_item_1_saved_item = isset($_smarty_tpl->tpl_vars['item']) ? $_smarty_tpl->tpl_vars['item'] : false;
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['item']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$__foreach_item_1_saved_local_item = $_smarty_tpl->tpl_vars['item'];
?>
										<?php if ((in_array($_smarty_tpl->tpl_vars['item']->value->type,$_smarty_tpl->tpl_vars['search_test_kbn']->value))) {?>
											<label><input type="checkbox" class="test_kbn" name="test_kbn" value='<?php echo $_smarty_tpl->tpl_vars['item']->value->type;?>
' checked><?php echo $_smarty_tpl->tpl_vars['item']->value->name;?>
</label>
										<?php } else { ?>
											<label><input type="checkbox" class="test_kbn" name="test_kbn" value='<?php echo $_smarty_tpl->tpl_vars['item']->value->type;?>
' ><?php echo $_smarty_tpl->tpl_vars['item']->value->name;?>
</label>
										<?php }?>
									<?php
$_smarty_tpl->tpl_vars['item'] = $__foreach_item_1_saved_local_item;
}
if ($__foreach_item_1_saved_item) {
$_smarty_tpl->tpl_vars['item'] = $__foreach_item_1_saved_item;
}
?>
								<?php }?>
							</td>
						</tr>
					</table>
					<div align="right">
						<input type="button" class="btn_search" onclick="trans('<?php echo @constant('HOME_DIR');?>
TeacherCourseDetailAssignment/search')" title="検索" style="padding-right:50px;">
					</div>
					<?php if (count($_smarty_tpl->tpl_vars['courseDetailList']->value) > 0) {?>
						<table id="teacher_course_detail_list" class="display" style="border-collapse: collapse; font-size: 1.0em;" style="display:none;">
							<thead>
					            <tr>
					                <th></th>
					                <th>コース詳細名</th>
					                <th>Detail　Name</th>
					                <th>SW</th>
					                <th>Level</th>
					            </tr>
        					</thead>
        					<tbody>
	        					<?php
$_from = $_smarty_tpl->tpl_vars['courseDetailList']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_result_2_saved_item = isset($_smarty_tpl->tpl_vars['result']) ? $_smarty_tpl->tpl_vars['result'] : false;
$_smarty_tpl->tpl_vars['result'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['result']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['result']->value) {
$_smarty_tpl->tpl_vars['result']->_loop = true;
$__foreach_result_2_saved_local_item = $_smarty_tpl->tpl_vars['result'];
?>
	        						<?php if ((in_array($_smarty_tpl->tpl_vars['result']->value->course_detail_no,$_smarty_tpl->tpl_vars['data_list']->value))) {?>
	        							<?php $_smarty_tpl->tpl_vars["selected"] = new Smarty_Variable("selected", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "selected", 0);?>
	        						<?php } else { ?>
	 									<?php $_smarty_tpl->tpl_vars["selected"] = new Smarty_Variable('', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "selected", 0);?>
	        						<?php }?>
	        						<tr id="course_detail_no_<?php echo $_smarty_tpl->tpl_vars['result']->value->course_detail_no;?>
" class="<?php echo $_smarty_tpl->tpl_vars['selected']->value;?>
">
			        					<td></td>
										<td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->course_detail_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
										<td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->course_detail_romaji, ENT_QUOTES, 'UTF-8', true);?>
</td>
										<td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->test_kbn, ENT_QUOTES, 'UTF-8', true);?>
</td>
										<td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->course_level, ENT_QUOTES, 'UTF-8', true);?>
</td>
									</tr>
								<?php
$_smarty_tpl->tpl_vars['result'] = $__foreach_result_2_saved_local_item;
}
if ($__foreach_result_2_saved_item) {
$_smarty_tpl->tpl_vars['result'] = $__foreach_result_2_saved_item;
}
?>
        					</tbody>
						</table>
						<div align="right">
							<input type="submit" name="insert" value="" id="btn_insert" class="btn_insert" title="登録" />
						</div>
					<?php }?>
				</section>
			</div>
		</form>
		<?php echo '<script'; ?>
>

			function trans(action){

				prepareCheckboxData();

				$("#main_form").attr("action", action);
				$("#main_form").submit();
			}

			function prepareCheckboxData(){

				var test_kbn_list = '';
				var test_kbn_count = $("input.test_kbn:checked").length;
				var count = 0;
				$("#search_test_kbn").val("");
				$("#search_course_level").val("");

				$('input.test_kbn:checked').each(function() {
					count++;
					test_kbn_list += $(this).val();

					if ( count < test_kbn_count ){
						test_kbn_list += ",";
					}
				});
				$("#search_test_kbn").val(test_kbn_list);

				count = 0;
				var course_level_count = $("input.course_level:checked").length;
				var course_level_list = '';

				$('input.course_level:checked').each(function() {
					count++;
					course_level_list += $(this).val();

					if ( count < course_level_count ){
						course_level_list += ",";
					}
				});
				$("#search_course_level").val(course_level_list);
			}

			$(function(){
				var entryList = [];
				$('#teacher_course_detail_list tbody tr').each(function() {

					var course_detail_no = $(this).attr('id');
					course_detail_no = course_detail_no.split("course_detail_no_")[1];

					entryList = $("#entryList").val();
					entryList = entryList.split(",");

					var flag = $.inArray( course_detail_no, entryList);

					if(flag != -1){
						$(this).addClass('selected');
					}
				});
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

			$('#teacher_course_detail_list tbody tr').on('click', function(){

				var course_detail_selected_list = $("#entryList").val();
	 			var course_detail_no = $(this).attr('id');
	 			course_detail_no = course_detail_no.split("course_detail_no_")[1];
	 			var selected_class = $(this).attr('class');
	 			selected_class = selected_class.split(" ");
	 			var table = $('#teacher_course_detail_list').DataTable();

	 			if(selected_class.length > 1){

	 				var course_detail_list = course_detail_selected_list.split(",");
	 				var temp = $.inArray( course_detail_no, course_detail_list );
	 				if(temp != -1){
	 					course_detail_selected_list = course_detail_selected_list.replace(course_detail_no + ",", "");
	 				}
	 				$("#entryList").val(course_detail_selected_list);
	 				$(this).toggleClass('selected');
	 			}else{

	 				if(course_detail_selected_list == ""){

	 					course_detail_selected_list += course_detail_no + ",";
	 				}else{

	 					var course_detail_list = course_detail_selected_list.split(",");
	 					var temp = $.inArray( course_detail_no, course_detail_list );
	 					if(temp == -1){
	 						course_detail_selected_list += course_detail_no + ",";
	 					}
	 				}
	 				$(this).toggleClass('selected');
	 				$("#entryList").val(course_detail_selected_list);
	 			}

	 			$(".select-info").remove();
	 			getTotalRowCount();
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
