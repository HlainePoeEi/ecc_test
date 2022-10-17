<?php
/* Smarty version 3.1.29, created on 2022-10-13 11:48:14
  from "/var/www/html/eccadmin_dev/templates/adminList.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_63477c6e7a5d67_20653699',
  'file_dependency' => 
  array (
    'ee9a12ad754902050d14d31fdc69cfcb0d048d9a' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/adminList.html',
      1 => 1547458228,
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
function content_63477c6e7a5d67_20653699 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
	<head>
	<title>管理者一覧</title>
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
	
	<link href="<?php echo @constant('HOME_DIR');?>
css/jquery-ui.css" rel="stylesheet">
	<link href="<?php echo @constant('HOME_DIR');?>
css/default.css" rel="stylesheet">

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
									top: $('#end_period').offset().top + 35,
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

					$("#err_dis").slideToggle('slow')

				});

				$("#search").on('click',function(){

					$(".error_section").hide();
					$('#err_dis').hide();

					var start_period = document.getElementById('start_period').value;
					var end_period = document.getElementById('end_period').value;
					// 利用開始の必須チェック
					if ( start_period == "" ) {

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("日付 (From)を入力してください。");
						return false;
					  }

					  // 利用終了の必須チェック
					if ( end_period == "" ) {

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("日付 (To)を入力してください。");
						return false;
					  }

					  // 利用終了の必須チェック
					if ( start_period > end_period ) {

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("<?php echo @constant('W004');?>
");
						return false;
					}
					$('#page').val(1);
					return true;
				});
			});
		<?php echo '</script'; ?>
>
	</head>
<body class="pushmenu-push">
	<form id="main_form" action="<?php echo @constant('HOME_DIR');?>
AdminList/Search" method="post">
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
					<p>
						><span class="title">設定 / 運用管理者一覧</span>
					</p>
					<table class="main_tbl">
						<tr>
							<td class="st_col">日付 (From)<span class="required">※</span></td>
							<td class="input"><input class="" type="text" name="start_period" id="start_period"
									value="<?php echo $_smarty_tpl->tpl_vars['form']->value->start_period;?>
" maxlength="10" onchange="changeDateFormat(this)" /></td>
							<td width="10px"></td>
							<td class="st_col">日付 (To)<span class="required">※</span></td>
							<td class="input"><input class="" type="text" name="end_period" id="end_period"
							 value="<?php echo $_smarty_tpl->tpl_vars['form']->value->end_period;?>
" maxlength="10" onchange="changeDateFormat(this)" /></td>
						</tr>
						<tr>
							<td>運用管理者名</td>
							<td class="input"><input class="text" type="text"  name="admin_name" id="admin_name"
								value="<?php echo $_smarty_tpl->tpl_vars['form']->value->admin_name;?>
" maxlength="32" size="30"></td>
							<td class="st_col"></td>
							<td></td>
						</tr>
					</table>

					<div align="right" style="width:100%">
						<input type="submit" id="search" name="search" title="検索" class="btn_search" alt="search" onclick="doSearch()" value="" style="padding-right:50px;">
						<input type="button" id="add" name="add_admin" class="btn_add" title="新規追加" onclick="javascript:doRegist('<?php echo @constant('HOME_DIR');?>
AdminRegist/index')">

					</div>
					<input type="hidden" id="page" name="page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->page;?>
" />
					<input type="hidden" id="home_dir" value="<?php echo @constant('HOME_DIR');?>
" />
					<input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->page;?>
"/>
					<input type="hidden" id="search_start_period" name="search_start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->start_period;?>
"/>
					<input type="hidden" id="search_end_period" name="search_end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->end_period;?>
"/>
					<input type="hidden" id="search_admin_name" name="search_admin_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->admin_name;?>
"/>
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
						<input type="hidden" id="admin_no" name="admin_no"/>
						<table class="tbl_search">
							<tr>
								<th width="400px">管理者名</th>
								<th width="400px">読み</th>
								<th width="400px">ログインＩＤ</th>
								<th width="300px">権限</th>
								<th width="300px">利用期間</th>
								<th width="70px">編集</th>
							</tr>
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
									<td width="400px"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->admin_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
									<td width="400px"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->romaji_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
									<td width="400px"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->login_id, ENT_QUOTES, 'UTF-8', true);?>
</td>
									<td width="300px"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->admin_kbn_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
									<td width="300px"><?php echo $_smarty_tpl->tpl_vars['result']->value->start_period;?>
 ~ <?php echo $_smarty_tpl->tpl_vars['result']->value->end_period;?>
</td>
									<td width="70px"><input type="button" class="btn_edit" name="edit"
										onclick="doEdit('<?php echo $_smarty_tpl->tpl_vars['result']->value->admin_no;?>
','<?php echo @constant('HOME_DIR');?>
AdminRegist/index')"></td>
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
					<!-- </div> -->
					<?php }?>
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

			//更新ボタン処理
			function doEdit(admin_no,action){

				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;

				//検索条件設定
				setSearchParam();

				$("#main_form").attr("action", action);
				$("#admin_no").val(admin_no);
				$("#menuOpen").val(menuOpen);
				$("#menuStatus").val(menuStatus);
				$("#main_form").submit();
			}

			//登録ボタン処理
			function doRegist(action){

				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;

				//検索条件設定
				setSearchParam();

				$("#main_form").attr("action", action);
				$("#menuOpen").val(menuOpen);
				$("#menuStatus").val(menuStatus);
				$("#main_form").submit();
			}

			//検索条件設定
			function setSearchParam(){
				$("#search_page").val($("#page").val());
				$("#search_start_period").val($("#start_period").val());
				$("#search_end_period").val($("#end_period").val());
				$("#search_admin_name").val($("#admin_name").val());

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
