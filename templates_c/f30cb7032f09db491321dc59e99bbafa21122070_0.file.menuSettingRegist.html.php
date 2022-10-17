<?php
/* Smarty version 3.1.29, created on 2022-09-29 10:13:53
  from "/var/www/html/eccadmin_dev/templates/menuSettingRegist.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_6334f1516d6775_16858870',
  'file_dependency' => 
  array (
    'f30cb7032f09db491321dc59e99bbafa21122070' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/menuSettingRegist.html',
      1 => 1654833966,
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
function content_6334f1516d6775_16858870 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
	<head>
		<title>学年設定</title>
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
css/datatables.css" rel="stylesheet">

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


				// MSGのあるなし
				if ( $(".error_msg").html() != "" ){

					$(".error_section").slideToggle('slow')
				}

				$(".close_icon").on('click', function(){

					$(".error_section").slideToggle('slow')
					$('#err_dis').slideToggle('slow')
				});
				
				$('#tbl_menu').DataTable( {
					"scrollY": '45vh',
					"lengthChange": false,
					"scrollX": true,
					"bFilter": false,
					"ordering": true,
					"pageLength": 25,
					"order": [],
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
					 "columnDefs": [
						{ "width": "80%", "targets": 0 },
						{ "width": "20%", "targets": 1 }
					  ]
				});
				
				var table = $('#tbl_menu').dataTable();
				table.fnPageChange(0);
			});
		<?php echo '</script'; ?>
>
	</head>
	<body class="pushmenu-push">
		<form id="main_form" action="<?php echo @constant('HOME_DIR');?>
MenuSettingRegist/save" method="post">
			<input type="hidden" id="admin_no" name="admin_no"/>
			<input type="hidden" id="homeDir" name="homeDir" value="<?php echo @constant('HOME_DIR');?>
"/>
			<input type="hidden" id="org_no" name="org_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
"/>
			<input type="hidden" id="strHideMenu" name="strHideMenu" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->strHideMenu;?>
"/>
			
			<input type="hidden" id="screen_mode" name="screen_mode" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->screen_mode;?>
">
			<input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
"/>
			<input type="hidden" id="search_start_period" name="search_start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_start_period;?>
"/>
			<input type="hidden" id="search_end_period" name="search_end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_end_period;?>
"/>
			<input type="hidden" id="search_org_name" name="search_org_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_org_name;?>
"/>
			<input type="hidden" id="search_chk_status" name="search_chk_status" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_chk_status;?>
"/>
			<input type="hidden" id="search_chk_status1" name="search_chk_status1" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_chk_status1;?>
"/>
			<input type="hidden" id="search_chk_status2" name="search_chk_status2" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_chk_status2;?>
"/>
			<input type="hidden" id="search_chk_status3" name="search_chk_status3" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_chk_status3;?>
"/>
			<input type="hidden" id="btn_flag" name="btn_flag" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->btn_flag;?>
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
				<div id="err_dis" tabindex="1">
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
						><span class="title">組織登録 / 組織メニュー設定</span>
					</p>
					<p style="text-align:right;width:100%;">
						<input type="button" title="戻る" value="" class="btn_back" onclick="javascript:doBack('<?php echo @constant('HOME_DIR');?>
MenuSettingRegist/back')">
					</p>
					<table style="width: 50%; margin-top: -30px;">
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td><label><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['org_name']->value, ENT_QUOTES, 'UTF-8', true);?>
</label></td>
						</tr>
						<tr>
							<td>組織ID</td>
							<td><label><?php echo $_smarty_tpl->tpl_vars['org_id']->value;?>
</label></td>
							<td>組織名</td>
							<td><label><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['org_name_kana']->value, ENT_QUOTES, 'UTF-8', true);?>
</label></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td><label><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['org_name_official']->value, ENT_QUOTES, 'UTF-8', true);?>
</label></td>
						</tr>
					</table>
					<br>
					<table class="tbl_menu" id="tbl_menu" style="width:100%">
						<thead>
							<tr>
								<th width="800px">メニュー名</th>
								<th class="50px">表示</th>
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
								<td width="800px"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->name_kana, ENT_QUOTES, 'UTF-8', true);?>
</td>
								<td width="50px">
									<?php if ($_smarty_tpl->tpl_vars['result']->value->show_flg == "1") {?>
										<label><input type="checkbox" class="test_kbn" name="chkShowFlg" value='<?php echo $_smarty_tpl->tpl_vars['result']->value->name;?>
' ></label>
									<?php } else { ?>
										<label><input type="checkbox" class="test_kbn" name="chkShowFlg" value='<?php echo $_smarty_tpl->tpl_vars['result']->value->name;?>
' checked></label>
									<?php }?>
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
					<p style="text-align:right;">
						<input type="button" name="btn_insert" title="登録" value="" class="btn_insert"  style="padding-right: 50px;" onclick="doSave()">
						<input type="button" title="キャンセル" value="" class="btn_close" onclick="javascript:doClear()"  id="cancel" style="display:none">
					</p>
				
				</section>
			</div>
			<!--footer-->
				<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<!--footer-->
		</form>

		<?php echo '<script'; ?>
>
			

			var arr = [];
			<?php
$_from = $_smarty_tpl->tpl_vars['list']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_value_1_saved_item = isset($_smarty_tpl->tpl_vars['value']) ? $_smarty_tpl->tpl_vars['value'] : false;
$_smarty_tpl->tpl_vars['value'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['value']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
$__foreach_value_1_saved_local_item = $_smarty_tpl->tpl_vars['value'];
?>
				arr.push(JSON.parse('<?php echo json_encode($_smarty_tpl->tpl_vars['value']->value);?>
'));
			<?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_1_saved_local_item;
}
if ($__foreach_value_1_saved_item) {
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_1_saved_item;
}
?>
			// 配列のインデックス
			var no = 0;

			/**
			*
			*  検索ボタン押下、必須チェック処理
			*
			**/
			function doSave(){

				$(".error_section").hide();
				
				var chkElements = document.getElementsByName("chkShowFlg");
				var arr = [];
				
				chkElements.forEach(function(element){
					if (element.checked == false) {
						arr.push(element.value);
					} 
				});
				console.log(arr);
				$('#strHideMenu').val(arr.toString());
				
				var homeDir = $('#homeDir').val();
				var action = homeDir + 'MenuSettingRegist/save';
				$("#main_form").attr("action", action);
				console.log(action);
				$("#main_form").submit();

			};


			// キャンセルボタン処理
			function doClear(){

			}

			// 戻るボタン処理
			function doBack(action){
				
				setSearchFormData();

				$("#main_form").attr("action", action);
				$("#main_form").submit();
			}

			/**
			**  検索条件セットとフォーム
			**/
			function setSearchFormData() {

				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;

				$("#menuOpen").val(menuOpen);
				$("#menuStatus").val(menuStatus);
				$("#search_page").val($("#search_page").val());
				$("#search_start_period").val($("#search_start_period").val());
				$("#search_end_period").val($("#search_end_period").val());
				$("#search_org_name").val($("#search_org_name").val());
				$("#search_chk_status").val($("#search_chk_status").val());

				$("#search_chk_status1").val("");
				if ( $("#chk_status1").prop('checked') ){
					$("#search_chk_status1").val(1);
				}

				$("#search_chk_status2").val("");
				if ( $("#chk_status2").prop('checked') ){
					$("#search_chk_status2").val(1);
				}

				$("#search_chk_status3").val("");
				if ( $("#chk_status3").prop('checked') ){
					$("#search_chk_status3").val(1);
				}
				$("#main_form").submit();
			}
			window.onload = function init() {

				
			}
		
	<?php echo '</script'; ?>
>
	</body>
</html><?php }
}
