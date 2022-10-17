<?php
/* Smarty version 3.1.29, created on 2022-03-14 15:33:16
  from "/var/www/html/eccadmin_dev/templates/quizInfoAssignment.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_622ee1ac27a309_61188645',
  'file_dependency' => 
  array (
    'f443dda4ffea695a1405c993115e92ac6a3f1a0c' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/quizInfoAssignment.html',
      1 => 1628218452,
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
function content_622ee1ac27a309_61188645 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
	<title>クイズ出題順</title>
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
js/escape.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('HOME_DIR');?>
js/quizInfoAssignment.js"><?php echo '</script'; ?>
>
    
	<link href="<?php echo @constant('HOME_DIR');?>
css/jquery-ui.css" rel="stylesheet">
	<link href="<?php echo @constant('HOME_DIR');?>
css/default.css" rel="stylesheet">
    <link href="<?php echo @constant('HOME_DIR');?>
css/quizInfoAssignment.css"	rel="stylesheet">
	</head>
<body class="pushmenu-push">
	<form id="main_form" action="<?php echo @constant('HOME_DIR');?>
QuizInfoAssignment/save" method="post">
	     <input type="hidden" id ="manager_no" name="manager_no"/>
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
							><span class="title">試験情報 / クイズ出題順</span>
						</p>
						<p style="text-align:right;width:100%;">
							<input type="button" title="戻る" value="" class="btn_back" onclick="javascript:doBack('<?php echo @constant('HOME_DIR');?>
QuizInfoAssignment/back')">
						</p>
						<input type="hidden" id="page" name="page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->page;?>
" />
						<input type="hidden" id="home_dir" value="<?php echo @constant('HOME_DIR');?>
" />
						<input type="hidden" id="entryList" name="entryList" value=""/>
						<input type="hidden" name="test_info_no" id="test_info_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_info_no;?>
"/>
						<input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
"/>
						<input type="hidden" id="search_start_period" name="search_start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_start_period;?>
"/>
						<input type="hidden" id="search_end_period" name="search_end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_end_period;?>
"/>
						<input type="hidden" id="search_test_info_name" name="search_test_info_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->search_test_info_name, ENT_QUOTES, 'UTF-8', true);?>
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
						<input type="hidden" id="org_no" name="org_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
"/>
						<table class="testAss_tbl">
							<tr>
								<td class="td_two">試験名</td>
								<td class="td_input"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->test_info_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
							</tr>
							<tr>
								<td class="td_two">利用期間</td>
								<td class="td_input"><?php echo $_smarty_tpl->tpl_vars['form']->value->start_period;?>
~<?php echo $_smarty_tpl->tpl_vars['form']->value->end_period;?>
</td>
							</tr>
						</table>
						<br>
						<table id="testAss_lowertbl1" class="myTable join_header_border_quiz">
								<thead>
									<tr>
										<th style="width:150px; ">番号</th>
										<th style="width:300px; ">クイズ名</th>
										<th style="width:700px; ">問題</th>
										<th style="width:100px; "></th>
									</tr>
								</thead>
								 <?php if (count($_smarty_tpl->tpl_vars['addlist']->value) == 1) {?>
								 <tbody>
									<?php
$_from = $_smarty_tpl->tpl_vars['addlist']->value;
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
									<tr style="width:100%;">
										<td style="width:150px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->rowno;?>
</td>
										<td style="width:300px;"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->quiz_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
										<td style="width:700px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->long_description;?>
</td>
										<td style="width:100px; text-align:center;">
											 <button style="background-color:#fff;border:0px;" disabled="disabled" onClick="MoveUp.call(this);return false;"><img src="<?php echo @constant('HOME_DIR');?>
image/up.svg" style="width: 25px;height:25px;"/></button>
											<button style="background-color:#fff;border:0px;"  disabled="disabled" onClick="MoveDown.call(this);return false;"><img src="<?php echo @constant('HOME_DIR');?>
image/down.svg"  style="width: 25px;height:25px;"/></button>
										</td>
										<td><?php echo $_smarty_tpl->tpl_vars['result']->value->quiz_info_no;?>
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
								<?php } else { ?>
								<tbody>
									<?php
$_from = $_smarty_tpl->tpl_vars['addlist']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_result_1_saved_item = isset($_smarty_tpl->tpl_vars['result']) ? $_smarty_tpl->tpl_vars['result'] : false;
$__foreach_result_1_saved_key = isset($_smarty_tpl->tpl_vars['key']) ? $_smarty_tpl->tpl_vars['key'] : false;
$_smarty_tpl->tpl_vars['result'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['key'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['result']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['result']->value) {
$_smarty_tpl->tpl_vars['result']->_loop = true;
$__foreach_result_1_saved_local_item = $_smarty_tpl->tpl_vars['result'];
?>
									<?php if ($_smarty_tpl->tpl_vars['key']->value == 0) {?>
										<tr style="width:100%;">
										<td style="width:150px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->rowno;?>
</td>
										<td style="width:300px;"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->quiz_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
										<td style="width:700px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->long_description;?>
</td>
										<td style="width:100px; text-align:center;">
											 <button style="background-color:#fff;border:0px;" disabled="disabled" onClick="MoveUp.call(this);return false;"><img src="<?php echo @constant('HOME_DIR');?>
image/up.svg" style="width: 25px;height:25px;"/></button>
		                                     <button style="background-color:#fff;border:0px;" onClick="MoveDown.call(this);return false;"><img src="<?php echo @constant('HOME_DIR');?>
image/down.svg"  style="width: 25px;height:25px;"/></button>
										</td>
										<td><?php echo $_smarty_tpl->tpl_vars['result']->value->quiz_info_no;?>
</td>
										</tr>
									<?php } elseif ($_smarty_tpl->tpl_vars['key']->value == count($_smarty_tpl->tpl_vars['addlist']->value)-1) {?>
										<tr style="width:100%;">
										<td style="width:150px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->rowno;?>
</td>
										<td style="width:300px;"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->quiz_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
										<td style="width:700px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->long_description;?>
</td>
										<td style="width:100px; text-align:center;">
											 <button style="background-color:#fff;border:0px;" onClick="MoveUp.call(this);return false;"><img src="<?php echo @constant('HOME_DIR');?>
image/up.svg" style="width: 25px;height:25px;"/></button>
		                                     <button style="background-color:#fff;border:0px;" disabled="disabled"  onClick="MoveDown.call(this);return false;"><img src="<?php echo @constant('HOME_DIR');?>
image/down.svg"  style="width: 25px;height:25px;"/></button>
										</td>
										<td><?php echo $_smarty_tpl->tpl_vars['result']->value->quiz_info_no;?>
</td>
										</tr>
									<?php } else { ?>
									<tr style="width:100%;">
										<td style="width:150px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->rowno;?>
</td>
										<td style="width:300px;"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->quiz_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
										<td style="width:700px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->long_description;?>
</td>
										<td style="width:100px; text-align:center;">
											 <button style="background-color:#fff;border:0px;" onClick="MoveUp.call(this);return false;"><img src="<?php echo @constant('HOME_DIR');?>
image/up.svg" style="width: 25px;height:25px;"/></button>
		                                     <button style="background-color:#fff;border:0px;" onClick="MoveDown.call(this);return false;"><img src="<?php echo @constant('HOME_DIR');?>
image/down.svg"  style="width: 25px;height:25px;"/></button>
										</td>
										<td><?php echo $_smarty_tpl->tpl_vars['result']->value->quiz_info_no;?>
</td>
									</tr>
									<?php }?>
									<?php
$_smarty_tpl->tpl_vars['result'] = $__foreach_result_1_saved_local_item;
}
if ($__foreach_result_1_saved_item) {
$_smarty_tpl->tpl_vars['result'] = $__foreach_result_1_saved_item;
}
if ($__foreach_result_1_saved_key) {
$_smarty_tpl->tpl_vars['key'] = $__foreach_result_1_saved_key;
}
?>
								</tbody>
								<?php }?>
							</table>
			<table class="btn_div">
				<tr>
					<td>
					<input type="button" value="" class="btn_resetbtn" title="リセット"
					onclick="javascript:cancel('<?php echo $_smarty_tpl->tpl_vars['form']->value->test_info_no;?>
','<?php echo @constant('HOME_DIR');?>
QuizInfoAssignment/index');">
					<input type="button" name="insert" value="" class="btn_insert" title="登録"
					onclick="javascript:insertQuizInfoAssignmentData();" />
					</td>
				</tr>
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

			//更新ボタン処理
			function trans(manager_no,action){

				var menuOpen = document.getElementById('menuOpen').value;
		        var menuStatus = document.getElementById('menuStatus').value;
				$("#main_form").attr("action", action);
			    $("#manager_no").val(manager_no);
			    $("#menuOpen").val(menuOpen);
			    $("#menuStatus").val(menuStatus);
			    $("#main_form").submit();
			}

			//登録ボタン処理
			function doInsert(action){

				 var menuOpen = document.getElementById('menuOpen').value;
		         var menuStatus = document.getElementById('menuStatus').value;
				 $("#main_form").attr("action", action);
			     $("#menuOpen").val(menuOpen);
			     $("#menuStatus").val(menuStatus);
			     $("#main_form").submit();
			}

			//登録ボタン処理
			function doBack(action){

				var menuOpen = document.getElementById('menuOpen').value;
		        var menuStatus = document.getElementById('menuStatus').value;
				$("#main_form").attr("action", action);
			    $("#menuOpen").val(menuOpen);
			    $("#menuStatus").val(menuStatus);
			    $("#main_form").submit();
			}

			//リセット
			function cancel(test_info_no, action){

				var menuOpen = document.getElementById('menuOpen').value;
			    var menuStatus = document.getElementById('menuStatus').value;

				$("#main_form").attr("action", action);
				$("#test_info_no").val(test_info_no);
			    $("#menuOpen").val(menuOpen);
			    $("#menuStatus").val(menuStatus);
			    $("#main_form").submit();
			}

			//戻るボタン処理
			function doBack(action){

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
