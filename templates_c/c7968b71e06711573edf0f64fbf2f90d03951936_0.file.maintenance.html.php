<?php
/* Smarty version 3.1.29, created on 2022-10-13 11:48:17
  from "/var/www/html/eccadmin_dev/templates/maintenance.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_63477c71a34d34_21334006',
  'file_dependency' => 
  array (
    'c7968b71e06711573edf0f64fbf2f90d03951936' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/maintenance.html',
      1 => 1536079578,
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
function content_63477c71a34d34_21334006 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
	<title>システムメンテナンス</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	
	<?php echo '<script'; ?>
	src="<?php echo @constant('HOME_DIR');?>
js/jquery.min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
	src="<?php echo @constant('HOME_DIR');?>
js/common.js"><?php echo '</script'; ?>
>
	

	<link href="<?php echo @constant('HOME_DIR');?>
css/default.css" rel="stylesheet">
	<?php echo '<script'; ?>
 type="text/javascript">
		function check(){
			var status = document.getElementById('status').value;

			if(status == "0"){
				$("#msg").css("display", "block");
				$("#cmt").html("緊急停止を行います。");
				$(".main_tbl").css("display", "block");
			}else if(status == "1") {
				$("#msg").css("display", "block");
				$("#cmt").html("ただいま停止中です。解除しますか？");
				$(".main_tbl").css("display", "none");
			}else {
				$("#msg").css("display", "none");
				$(".main_tbl").css("display", "none");
			}
		}
		$(document).ready(function() {

			check();
			// MSGのあるなし
			if ( $(".error_msg").html() != "" ) {

				$(".error_section").slideToggle('slow')
			}

			$(".close_icon").on('click',function() {

				$(".error_section").slideToggle('slow')
				$("#err_dis").slideToggle('slow')

			});

			$("#select_kbn").on('change',function(e){

				var system_kbn = $(this).val();
				var homeDir = $('#home_dir').val();
				var fd = new FormData();
				fd.append('system_kbn', system_kbn);

				$.ajax({
					type : 'POST',
					url : homeDir + 'Maintenance/searchWoc',
					data : fd,
					datatype : 'JSON',
					processData : false,
					contentType : false
				}).done(
					function(data) {
						arrList = $.parseJSON(data);
						if (arrList.length > 0){
							var status = arrList[0].system_status;
							$('#status').val(status);
						}else {
							$('#status').val("");
						}
						check();
					}).fail(function(data) {
				    console.log("error");
				});
		        return false;
			});
		});
	<?php echo '</script'; ?>
>
</head>
<body class="pushmenu-push">
	<form id="main_form" action="<?php echo @constant('HOME_DIR');?>
Maintenance/Search" method="post">
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
					<input type="hidden" id="page" name="page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->page;?>
" />
					<input type="hidden" id="home_dir" value="<?php echo @constant('HOME_DIR');?>
" />
					<input type="hidden" id="admin_no" name="admin_no"/>
					<input type="hidden" id="status" name= "status" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->status;?>
" />
					<p>
						><span class="title">設定 / システムメンテナンス</span>
					</p>
					<div id="kbn">
						<label>対象<span class="required">※</span></label>
						<select id="select_kbn" name="select_kbn" style="width:220px;margin-left:120px;">
							<option value="0">選択してください。</option>
								<?php if (!empty($_smarty_tpl->tpl_vars['kbn']->value)) {?>
									<?php
$_from = $_smarty_tpl->tpl_vars['kbn']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_value_0_saved_item = isset($_smarty_tpl->tpl_vars['value']) ? $_smarty_tpl->tpl_vars['value'] : false;
$_smarty_tpl->tpl_vars['value'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['value']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
$__foreach_value_0_saved_local_item = $_smarty_tpl->tpl_vars['value'];
?>
									<?php if ($_smarty_tpl->tpl_vars['value']->value->type == $_smarty_tpl->tpl_vars['form']->value->select_kbn) {?>
											<option value="<?php echo $_smarty_tpl->tpl_vars['value']->value->type;?>
" selected><?php echo $_smarty_tpl->tpl_vars['value']->value->name;?>
 </option>
										  <?php } else { ?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['value']->value->type;?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value->name;?>
 </option>
										<?php }?>
									<?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_0_saved_local_item;
}
if ($__foreach_value_0_saved_item) {
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_0_saved_item;
}
?>
								<?php }?>
						</select>
					</div>
					 <div id="msg" style="margin-top:50px;font-size: 32px;color:red;display:none;">
						<label id="cmt"></label>
					</div>
					<table class="main_tbl" style="display:none">
						<tr>
							<td class="st_col">停止用コメント<span class="required">※</span></td>
							<td class="input">
							<!-- <input id="description" name="description" type="text" class="text" style = "width:380px;" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->description;?>
" maxlength="1024" /> -->
							<textarea name="description" id="description" cols="40" maxlength = "1024" style="width : 100%; height : 60px; margin-top : 10px;margin-left : 30px; overflow-y : scroll; resize : none;"><?php echo $_smarty_tpl->tpl_vars['form']->value->description;?>
</textarea>
							</td>
						</tr>
						<tr>
							<td></td>
							<td><label id="cmt_eg" style="margin-left:30px;">(例：ただいまご使用出来ません。しばらくお待ち下さい。)</label></td>
						</tr>
					</table>

				<div align="right" style="width:100%">
						<input type="button" id="btn_insert" name="btn_insert" class="btn_insert" title="登録" onclick="javascript:doRegist('<?php echo @constant('HOME_DIR');?>
Maintenance/save')">
				</div>
					<?php if (!empty($_smarty_tpl->tpl_vars['list']->value)) {?>
						<div class="pagging" style="width:100%">
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
						<?php }?>
						<table class="tbl_search">
							<tr>
								<th width="400px">【履歴】日付</th>
								<th width="200px">対象</th>
								<th width="200px">状態</th>
								<th width="400px">コメント</th>
								<th width="200px">運用者ID</th>
								<th width="200px">運用者名</th>

							</tr>
							<?php if (!empty($_smarty_tpl->tpl_vars['list']->value)) {?>
								<?php
$_from = $_smarty_tpl->tpl_vars['list']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_result_1_saved_item = isset($_smarty_tpl->tpl_vars['result']) ? $_smarty_tpl->tpl_vars['result'] : false;
$_smarty_tpl->tpl_vars['result'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['result']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['result']->value) {
$_smarty_tpl->tpl_vars['result']->_loop = true;
$__foreach_result_1_saved_local_item = $_smarty_tpl->tpl_vars['result'];
?>
									<tr>
										<td width="400px"><?php echo $_smarty_tpl->tpl_vars['result']->value->update_dt;?>
</td>
										<td width="400px"><?php echo $_smarty_tpl->tpl_vars['result']->value->name;?>
</td>
										<td width="400px"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->system_status, ENT_QUOTES, 'UTF-8', true);?>
</td>
										<td width="400px"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->description, ENT_QUOTES, 'UTF-8', true);?>
</td>
										<td width="300px"><?php echo $_smarty_tpl->tpl_vars['result']->value->login_id;?>
</td>
										<td width="300px"><?php echo $_smarty_tpl->tpl_vars['result']->value->admin_name;?>
</td>
									</tr>
								<?php
$_smarty_tpl->tpl_vars['result'] = $__foreach_result_1_saved_local_item;
}
if ($__foreach_result_1_saved_item) {
$_smarty_tpl->tpl_vars['result'] = $__foreach_result_1_saved_item;
}
?>
							<?php }?>
						</table>
				</section>
			</div>
		</div>
		<div class="divFooter">
			<!--footer-->
				<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<!--footer-->
		</div>
	</form>
	<?php echo '<script'; ?>
>
		

			//ページング
			function doPage(pageNo){
				$("#page").val(pageNo);
				$("#main_form").submit();
			}

			//登録ボタン処理
			function doRegist(action){

				var valid = checkValidation();
				if (valid){
					var result = confirm("登録します。よろしいでしょうか。");
					if(result){
						$("#main_form").attr("action", action);
						$("#main_form").submit();
					}
				}
			}

			function checkValidation(){

				var description = document.getElementById('description').value;
				var select_kbn = document.getElementById('select_kbn').value;
				var status = document.getElementById('status').value;

				if(select_kbn == "0"){
					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("対象を一つ選択してください。");
					$(".divBody").scrollTop(0);
					return false;
				 }

				if(status == "0"){

					if(description == ""){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("停止用コメントを入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					 }

					if(description.length > 1024){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("停止用コメントを1024字で入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					 }
				}
				return true;
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
