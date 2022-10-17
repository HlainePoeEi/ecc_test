<?php
/* Smarty version 3.1.29, created on 2022-10-13 11:45:14
  from "/var/www/html/eccadmin_dev/templates/quizInfoList.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_63477bba4ba398_01628013',
  'file_dependency' => 
  array (
    '1afec286441dea9a892efb2e56f3cb687622bd91' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/quizInfoList.html',
      1 => 1628216454,
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
function content_63477bba4ba398_01628013 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
<title>クイズ一覧</title>

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

<link href="<?php echo @constant('HOME_DIR');?>
css/datatables.css" rel="stylesheet">
<link href="<?php echo @constant('HOME_DIR');?>
css/jquery-ui.css" rel="stylesheet">
<link href="<?php echo @constant('HOME_DIR');?>
css/default.css" rel="stylesheet">
<link href="<?php echo @constant('HOME_DIR');?>
css/quizlist.css" rel="stylesheet">

			<?php echo '<script'; ?>
 type="text/javascript">
				//表示再現
				$(document).ready(function() {

					//MSGのあるなし
					if ( $(".error_msg").html() != "" ) {
						$(".error_section").slideToggle('slow');
						}

					$(".close_icon").on('click',function(){
						$(".error_section").slideToggle('slow')
						});

					//検索ボタン押下、必須チェック処理
					$(".btn_search").on('click',function(){
						$("#page").val(1);

						//MSGのあるなし
						if ( $(".error_msg").html() != "" ) {
							$(".error_section").slideToggle('slow')
							}
							return true;
						});
						
					//データテーブルを表示する
					var dataArray = $("#list").val();
					var current_page = parseInt($("#search_page_qil").val());
					var current_page_row = parseInt($("#search_page_row_qil").val());
					var current_order_column = $("#search_page_order_column_qil").val();
					var current_order_dir = $("#search_page_order_dir_qil").val();
					
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
									"first":      "First",
									"last":       "Last",
									"next":       "次",
									"previous":   "前"
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
	<form id="main_form" action="<?php echo @constant('HOME_DIR');?>
QuizInfoList/Search" method="post">

	<input type="hidden" id ="screen_mode" name="screen_mode"/>
	<input type="hidden" id ="quiz_info_no" name="quiz_info_no"/>
	<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:leftMenu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


	<!--header-->
	<div class="divHeader">
	<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	</div>
	<!--header-->

	<div class="divBody">
		<div class="main">

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
			<p>><span class="title">テスト情報 / クイズ一覧</span></p>

				<table class="main_tbl">

					<!-- クイズ名と備考行 -->
					<tr>
					<td>クイズ名</td>
					<td class="input">
						<input class="text" type="text" name="quiz_name" id="quiz_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->quiz_name, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "32" size="30">
					</td>
					<td width="10px"></td>
					<td>備考</td>
					<td class="input">
						<input class="text" type="text" name="remark" id="remark" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->remark, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "32" size="30">
					</td>
					</tr>

					<!-- 内容と最終担当者行 -->
					<tr>
					<td>内容</td>
					<td class="input">
						<input class="text" type="text" name="long_description" id="long_description" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->long_description, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "32" size="30">
					</td>
					<td width="10px"></td>
					<td>最終担当者</td>
					<td class="input">
						<?php if (($_smarty_tpl->tpl_vars['form']->value->rd_status1 == 0)) {?>
						<input type="radio" id="rd_status1" name="rd_status1" value='0' checked>
						<label for="rd_status1">すべて</label>
						<input type="radio" id="rd_status2" name="rd_status1" value='1'>
						<label for="rd_status2">自分のみ</label>
						<?php } else { ?>
						<input type="radio" id="rd_status1" name="rd_status1" value='0'>
						<label for="rd_status1">すべて</label>
						<input type="radio" id="rd_status2" name="rd_status1" value='1' checked>
						<label for="rd_status2">自分のみ</label>
						<?php }?>
					</td>
					</tr>
					<tr>
						<td>組織ID</td>
						<td><input class="text" type="text" name="search_org_id" id="search_org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_org_id;?>
" maxlength="32" size="30"></td>
					</tr>
				</table>
					
				<input type="hidden" id="search_page_qil" name="search_page_qil" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_qil;?>
" />
				<input type="hidden" id="search_page_row_qil" name="search_page_row_qil" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_row_qil;?>
" />
				<input type="hidden" id="search_page_order_column_qil" name="search_page_order_column_qil" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_column_qil;?>
" />
				<input type="hidden" id="search_page_order_dir_qil" name="search_page_order_dir_qil" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_dir_qil;?>
" />

				<input type="hidden" id="home_dir" value="<?php echo @constant('HOME_DIR');?>
" />
				<input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
" />
				<input type="hidden" id="search_quiz_name" name="search_quiz_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->search_quiz_name, ENT_QUOTES, 'UTF-8', true);?>
" />
				<input type="hidden" id="search_long_description" name="search_long_description" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->search_long_description, ENT_QUOTES, 'UTF-8', true);?>
" />
				<input type="hidden" id="search_remark" name="search_remark" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_remark;?>
" />
				<input type="hidden" id="search_rd_status1" name="search_rd_status1" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_rd_status1;?>
" />
				<input type="hidden" id="org_no" name="org_no" value=""/>
				<br/>

				<div align="right" style="width:100%">
				<input type="submit" name="submit_search" id="btn_search" name="btn_search" title="検索" class="btn_search" alt="search" value="" style="padding-right:50px;">
				<input type="button" id="add" name="add_quiz" class="btn_add" value="" title="新規追加" onclick="javascript:doInsert('<?php echo @constant('HOME_DIR');?>
QuizInfoRegist/index')">
				</div>
				<?php if (!empty($_smarty_tpl->tpl_vars['list']->value)) {?>
				<table class="tbl_search" id="tbl_search" style="border-collapse: collapse; font-size: 1.0em;width:100%">
					<thead>
						<tr>
							<th class="qz_type_name">組織ID</th>
							<th class="qz_name">クイズ名</th>
							<th class="qz_content">内容</th>
							<th class="qz_type_name">確認</th>
							<th class="td_img">編集</th>
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
					<tr>
					<td class="qz_type_name"><?php echo $_smarty_tpl->tpl_vars['result']->value->org_id;?>
</td>
					<td class="qz_name"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->quiz_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
					<td class="qz_content"><?php echo $_smarty_tpl->tpl_vars['result']->value->long_description;?>
</td>
					<td class="td_img">
						<input type="button" class="btn_preview_list" name="preview" title="確認" onclick="trans('<?php echo $_smarty_tpl->tpl_vars['result']->value->org_no;?>
','<?php echo $_smarty_tpl->tpl_vars['result']->value->quiz_info_no;?>
','<?php echo @constant('HOME_DIR');?>
QuizDetailsPreview/index')">
					</td>
					<td class="td_img">
						<input type="button" class="btn_edit" name="edit" title="編集" onclick="trans('<?php echo $_smarty_tpl->tpl_vars['result']->value->org_no;?>
','<?php echo $_smarty_tpl->tpl_vars['result']->value->quiz_info_no;?>
','<?php echo @constant('HOME_DIR');?>
QuizInfoRegist/index')">
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
				<?php }?>
			</section>
		</div>
	</div>

	<!--footer-->
	<div class="divFooter">
	<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	</div>
	<!--footer-->

	</form>

			<?php echo '<script'; ?>
>
				

				// 登録ボタン処理
				function doInsert(action){

					var menuOpen = document.getElementById('menuOpen').value;
					var menuStatus = document.getElementById('menuStatus').value;
					
					setDataTableData();

					$("#search_page").val($("#page").val());
					$("#search_quiz_name").val($("#quiz_name").val());
					$("#search_long_description").val($("#long_description").val());
					$("#search_remark").val($("#remark").val());
					$("#search_rd_status1").val($('input[name=rd_status1]:checked').val());
					$("#search_org_id").val($("#search_org_id").val());

					$("#menuOpen").val(menuOpen);
					$("#main_form").attr("action", action);
					$("#screen_mode").val('new');
					$("#menuOpen").val(menuOpen);
					$("#menuStatus").val(menuStatus);
					$("#main_form").submit();
				}

				// 更新ボタン処理
				function trans(org_no,quiz_info_no,action){
					var menuOpen = document.getElementById('menuOpen').value;
					var menuStatus = document.getElementById('menuStatus').value;
					
					setDataTableData();

					$("#search_page").val($("#page").val());
					$("#search_quiz_name").val($("#quiz_name").val());
					$("#search_long_description").val($("#long_description").val());
					$("#search_remark").val($("#remark").val());
					$("#search_rd_status1").val($('input[name=rd_status1]:checked').val());
					$("#search_org_id").val($("#search_org_id").val());
					$("#org_no").val(org_no);

					$("#main_form").attr("action", action);
		            $("#screen_mode").val('update');
		            $("#quiz_info_no").val(quiz_info_no);
		            $("#menuOpen").val(menuOpen);
		            $("#menuStatus").val(menuStatus);
		            $("#main_form").submit();
				}

				// プレビューボタン処理
				function preview(org_no,quiz_info_no, action){

					var menuOpen = document.getElementById('menuOpen').value;
					var menuStatus = document.getElementById('menuStatus').value;
					
					setDataTableData();

					$("#search_page").val($("#page").val());
					$("#search_quiz_name").val($("#quiz_name").val());
					$("#search_long_description").val($("#long_description").val());
					$("#search_remark").val($("#remark").val());
					$("#search_rd_status1").val($('input[name=rd_status1]:checked').val());
					$("#search_org_id").val($("#search_org_id").val());
					$("#org_no").val(org_no);

					$("#main_form").attr("action", action);
		            $("#quiz_info_no").val(quiz_info_no);
		            $("#menuOpen").val(menuOpen);
		            $("#menuStatus").val(menuStatus);
		            $("#main_form").submit();
					}
					
					// データテーブルの情報を設定
					function setDataTableData(){
					
						var page = 0;
						var page_row = 10;
						var order;
						var page_order_column = 1;
						var page_order_dir = false;
							
						//初期で登録する場合、データテーブルをチェックする
						if ( $.fn.DataTable.isDataTable( '#tbl_search' ) ){
						
							//データテーブルがある場合、確認ボタン、複写ボタンと編集ボタンの処理
							var table = $('#tbl_search').DataTable();
							var info = table.page.info();
							page = info.page;// データテーブルのページ
							page_row = table.page.info().length;// データテーブルのドロップダウンリストの行

							order = table.order();
							page_order_column = order[0][0];
							page_order_dir = order[0][1];
						}

						$("#search_page_qil").val(page);
						$("#search_page_row_qil").val(page_row);
						$("#search_page_order_column_qil").val(page_order_column);
						$("#search_page_order_dir_qil").val(page_order_dir);

					}
				
			<?php echo '</script'; ?>
>
</body>
</html><?php }
}
