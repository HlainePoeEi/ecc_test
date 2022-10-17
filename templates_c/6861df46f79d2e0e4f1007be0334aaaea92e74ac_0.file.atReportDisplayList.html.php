<?php
/* Smarty version 3.1.29, created on 2022-08-30 10:04:16
  from "/var/www/html/eccadmin_dev/templates/atReportDisplayList.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_630d6210eb23d6_45178649',
  'file_dependency' => 
  array (
    '6861df46f79d2e0e4f1007be0334aaaea92e74ac' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/atReportDisplayList.html',
      1 => 1647234395,
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
function content_630d6210eb23d6_45178649 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
	<title>Online Practice 並び順設定</title>
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
js/atReportDisplayList.js"><?php echo '</script'; ?>
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
AtReportDisplayList/save" method="post">
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
							><span class="title"> Online Practice 並び順設定</span>
						</p>
						<p style="text-align:right;width:100%;">
							<input type="button" title="戻る" value="" class="btn_back" onclick="javascript:doBack('<?php echo @constant('HOME_DIR');?>
AtReportDisplayList/back')">
						</p>

						<input type="hidden" id="home_dir" value="<?php echo @constant('HOME_DIR');?>
" />
						<input type="hidden" id="org_no" name="org_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
"/>
						<input type="hidden" id="at_report_no" name="at_report_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->at_report_no;?>
"/>
						<input type="hidden" id="entryList" name="entryList" value=""/>
						<input type="hidden" id="err_msg" name="err_msg" value="<?php echo $_smarty_tpl->tpl_vars['err_msg']->value;?>
"/>
						<input type="hidden" id="addlist" name="addlist" value="<?php echo $_smarty_tpl->tpl_vars['addlist']->value;?>
"/>
						
						<input type="hidden" id="search_org_id" name="search_org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_org_id;?>
" />
						<input type="hidden" id="search_at_report_name" name="search_at_report_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->search_at_report_name, ENT_QUOTES, 'UTF-8', true);?>
"/>
						<input type="hidden" id="search_test_info_name" name="search_test_info_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->search_test_info_name, ENT_QUOTES, 'UTF-8', true);?>
"/>
						<input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
" />
						<input type="hidden" id="search_page_row" name="search_page_row" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_row;?>
" />
						<input type="hidden" id="search_page_order_column" name="search_page_order_column" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_column;?>
" />
						<input type="hidden" id="search_page_order_dir" name="search_page_order_dir" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_dir;?>
" />
						<table class="testAss_tbl">
							<tr>
								<td class="td_two">レポート名</td>
								<td class="td_input"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['at_report_name']->value, ENT_QUOTES, 'UTF-8', true);?>
</td>
							</tr>
							<tr>
								<td class="td_two"></td>
								<td class="td_input"></td>
							</tr>
						</table>
						<br>
						<table id="testAss_lowertbl1" class="myTable join_header_border_quiz">
							<thead>
								<tr>
									<th style="width:150px; ">番号</th>
									<th style="width:300px; ">試験名</th>
									<th style="width:700px; "></th>
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
									<td style="width:150px;">1</td>
									<td style="width:300px;"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->test_info_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
									<td style="width:700px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->at_type_name;?>
</td>
									<td style="width:100px; text-align:center;">
										 <button style="background-color:#fff;border:0px;" disabled="disabled" onClick="MoveUp.call(this);return false;"><img src="<?php echo @constant('HOME_DIR');?>
image/up.svg" style="width: 25px;height:25px;"/></button>
										<button style="background-color:#fff;border:0px;"  disabled="disabled" onClick="MoveDown.call(this);return false;"><img src="<?php echo @constant('HOME_DIR');?>
image/down.svg"  style="width: 25px;height:25px;"/></button>
									</td>
									<td><?php echo $_smarty_tpl->tpl_vars['result']->value->at_type;?>
-<?php echo $_smarty_tpl->tpl_vars['result']->value->at_no;?>
-<?php echo $_smarty_tpl->tpl_vars['result']->value->offer_no;?>
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
									<td style="width:150px;"><?php echo $_smarty_tpl->tpl_vars['key']->value+1;?>
</td>
									<td style="width:300px;"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->test_info_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
									<td style="width:700px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->at_type_name;?>
</td>
									<td style="width:100px; text-align:center;">
										 <button style="background-color:#fff;border:0px;" disabled="disabled" onClick="MoveUp.call(this);return false;"><img src="<?php echo @constant('HOME_DIR');?>
image/up.svg" style="width: 25px;height:25px;"/></button>
										 <button style="background-color:#fff;border:0px;" onClick="MoveDown.call(this);return false;"><img src="<?php echo @constant('HOME_DIR');?>
image/down.svg"  style="width: 25px;height:25px;"/></button>
									</td>
									<td><?php echo $_smarty_tpl->tpl_vars['result']->value->at_type;?>
-<?php echo $_smarty_tpl->tpl_vars['result']->value->at_no;?>
-<?php echo $_smarty_tpl->tpl_vars['result']->value->offer_no;?>
</td>
									</tr>
								<?php } elseif ($_smarty_tpl->tpl_vars['key']->value == count($_smarty_tpl->tpl_vars['addlist']->value)-1) {?>
									<tr style="width:100%;">
									<td style="width:150px;"><?php echo $_smarty_tpl->tpl_vars['key']->value+1;?>
</td>
									<td style="width:300px;"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->test_info_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
									<td style="width:700px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->at_type_name;?>
</td>
									<td style="width:100px; text-align:center;">
										 <button style="background-color:#fff;border:0px;" onClick="MoveUp.call(this);return false;"><img src="<?php echo @constant('HOME_DIR');?>
image/up.svg" style="width: 25px;height:25px;"/></button>
										 <button style="background-color:#fff;border:0px;" disabled="disabled"  onClick="MoveDown.call(this);return false;"><img src="<?php echo @constant('HOME_DIR');?>
image/down.svg"  style="width: 25px;height:25px;"/></button>
									</td>
									<td><?php echo $_smarty_tpl->tpl_vars['result']->value->at_type;?>
-<?php echo $_smarty_tpl->tpl_vars['result']->value->at_no;?>
-<?php echo $_smarty_tpl->tpl_vars['result']->value->offer_no;?>
</td>
									</tr>
								<?php } else { ?>
								<tr style="width:100%;">
									<td style="width:150px;"><?php echo $_smarty_tpl->tpl_vars['key']->value+1;?>
</td>
									<td style="width:300px;"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->test_info_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
									<td style="width:700px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->at_type_name;?>
</td>
									<td style="width:100px; text-align:center;">
										 <button style="background-color:#fff;border:0px;" onClick="MoveUp.call(this);return false;"><img src="<?php echo @constant('HOME_DIR');?>
image/up.svg" style="width: 25px;height:25px;"/></button>
										 <button style="background-color:#fff;border:0px;" onClick="MoveDown.call(this);return false;"><img src="<?php echo @constant('HOME_DIR');?>
image/down.svg"  style="width: 25px;height:25px;"/></button>
									</td>
									<td><?php echo $_smarty_tpl->tpl_vars['result']->value->at_type;?>
-<?php echo $_smarty_tpl->tpl_vars['result']->value->at_no;?>
-<?php echo $_smarty_tpl->tpl_vars['result']->value->offer_no;?>
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
					onclick="javascript:cancel('<?php echo $_smarty_tpl->tpl_vars['form']->value->at_report_no;?>
','<?php echo @constant('HOME_DIR');?>
AtReportDisplayList/index');">
					<input type="button" name="insert" value="" class="btn_insert" title="登録"
					onclick="javascript:insertData();" />
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
			function cancel(at_report_no, action){

				var menuOpen = document.getElementById('menuOpen').value;
			    var menuStatus = document.getElementById('menuStatus').value;

				$("#main_form").attr("action", action);
				$("#at_report_no").val(at_report_no);
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
