<?php
/* Smarty version 3.1.29, created on 2022-10-17 05:24:59
  from "D:\xampp\htdocs\eccadmin_dev\templates\quizList.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_634ccb0ba920e5_18396696',
  'file_dependency' => 
  array (
    '26450715049faa0fcc76a5c5aff782c881b4619f' => 
    array (
      0 => 'D:\\xampp\\htdocs\\eccadmin_dev\\templates\\quizList.html',
      1 => 1630402329,
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
function content_634ccb0ba920e5_18396696 ($_smarty_tpl) {
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
css/jquery-ui.css" rel="stylesheet"/>
	<link href="<?php echo @constant('HOME_DIR');?>
css/default.css" rel="stylesheet">
	<link href="<?php echo @constant('HOME_DIR');?>
css/datatables.css" rel="stylesheet">
	<link href="<?php echo @constant('HOME_DIR');?>
css/quizlist.css" rel="stylesheet">

		<?php echo '<script'; ?>
 type="text/javascript">

			//表示再現
			$(document).ready(function() {

				// MSGのあるなし
				if ( $(".error_msg").html() != "" ) {

					$(".error_section").slideToggle('slow')
				}

				$(".close_icon").on('click',function(){

					$(".error_section").slideToggle('slow')

				});

				/**
				*
				*  検索ボタン押下、必須チェック処理
				*
				**/
				$(".btn_search").on('click',function(){

					$("#page").val(1);
					// MSGのあるなし
 					if ( $(".error_msg").html() != "" ) {

						$(".error_section").slideToggle('slow')
					}

					return true;
				});
				
				
				//データテーブルを表示する
				var dataArray = $("#list").val();
				var current_page = parseInt($("#search_page").val());
				var current_page_row = parseInt($("#search_page_row").val());
				var current_order_column = $("#search_page_order_column").val();
				var current_order_dir = $("#search_page_order_dir").val();
				
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
QuizList/Search" method="post">
			<input type="hidden" id ="screen_mode" name="screen_mode"/>
			<input type="hidden" id ="quiz_no" name="quiz_no"/>
			<input type="hidden" id ="org_no" name="org_no"/>
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
					<section class="error_section">
						<img src="<?php echo @constant('HOME_DIR');?>
image/close_icon.png" style="width:15px;float:right" class="close_icon">
						    <?php if (!empty($_smarty_tpl->tpl_vars['err_msg']->value)) {?>
							    <div class="error_msg"><?php echo $_smarty_tpl->tpl_vars['err_msg']->value;?>
</div>
							<?php } else { ?>
							    <div  class="error_msg"></div>
							<?php }?>
					</section>
					<section class="content">
							<p>
								><span class="title">テスト / クイズ一覧</span>
							</p>
							 <!--  <input type="hidden" id="status" name="status" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->status;?>
"> -->
							<table class="main_tbl">
								<tr>
									<td>クイズ名</td>
									<td class="input"><input class="text" type="text"
										name="quiz_name" id="quiz_name"
										value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->quiz_name, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "32" size="30"></td>
									<td width="10px"></td>
									<td>備考</td>
									<td class="input"><input class="text" type="text"
										name="remark" id="remark"
										value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->remark, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "32" size="30"></td>
								</tr>
								<tr>
									<td>問題</td>
									<td class="input"><input class="text" type="text"
										name="quiz_content" id="quiz_content"
										value="<?php echo $_smarty_tpl->tpl_vars['form']->value->quiz_content;?>
" maxlength = "32" size="30"></td>
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
									<td>組織ログインID</td>
										<td><input class="text" type="text"
											name="search_org_id" id="search_org_id"
											maxlength = "32" size="30" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_org_id;?>
"></td>
								</tr>
							</table>
							<input type="hidden" id="page" name="page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->page;?>
" />
							<input type="hidden" id="home_dir" value="<?php echo @constant('HOME_DIR');?>
" />
							
							<input type="hidden" id="search_quiz_name" name="search_quiz_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->search_quiz_name, ENT_QUOTES, 'UTF-8', true);?>
" />
							<input type="hidden" id="search_quiz_content" name="search_quiz_content" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_quiz_content;?>
" />
							<input type="hidden" id="search_remark" name="search_remark" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_remark;?>
" />
							<input type="hidden" id="search_rd_status1" name="search_rd_status1" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_rd_status1;?>
" />
							
							<input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
" />
							<input type="hidden" id="search_page_row" name="search_page_row" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_row;?>
" />
							<input type="hidden" id="search_page_order_column" name="search_page_order_column" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_column;?>
" />
							<input type="hidden" id="search_page_order_dir" name="search_page_order_dir" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_dir;?>
" />
							
							<br />
							<div align="right" style="width:100%">
								<input type="submit" name="submit_search" id="btn_search" name="btn_search" title="検索" class="btn_search" alt="search" value="" style="padding-right:50px;">
								<input type="button" id="add" name="add_quiz" class="btn_add" value="" title="新規追加" onclick="javascript:doInsert( '99999' , '<?php echo @constant('HOME_DIR');?>
QuizRegist/index')">
							</div>
							<?php if (!empty($_smarty_tpl->tpl_vars['list']->value)) {?>
							<table class="tbl_search" id="tbl_search">
								<thead>
									<tr>
										<th class="qz_type_name">組織ID</th>
										<th class="qz_name">クイズ名</th>
										<th class="qz_content">問題</th>
										<th class="qz_type_name">タイプ</th>
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
										<td class="qz_content"><?php echo $_smarty_tpl->tpl_vars['result']->value->quiz_content;?>
</td>
										<td class="qz_type_name"><?php echo $_smarty_tpl->tpl_vars['result']->value->name;?>
</td>
										<td class="td_img">
											<input type="button" class="btn_edit" name="edit" onclick="trans('<?php echo $_smarty_tpl->tpl_vars['result']->value->org_no;?>
','<?php echo $_smarty_tpl->tpl_vars['result']->value->quiz_no;?>
','<?php echo @constant('HOME_DIR');?>
QuizRegist/index')">
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
			<div class="divFooter">
				<!--footer-->
					<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

				<!--footer-->
			</div>
		</form>
	<?php echo '<script'; ?>
>
		
			// ページング
			function doPage(pageNo){
				$("#page").val(pageNo);
				$("#main_form").submit();
			}

			// 登録ボタン処理
			function doInsert(org_no,action){

				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;

				$("#search_quiz_name").val($("#quiz_name").val());
				$("#search_quiz_content").val($("#quiz_content").val());
				$("#search_remark").val($("#remark").val());
				$("#search_rd_status1").val($('input[name=rd_status1]:checked').val());
				$("#search_org_id").val($("#search_org_id").val());
				
				setDataTableData();

				$("#org_no").val(org_no);
				$("#menuOpen").val(menuOpen);
				$("#main_form").attr("action", action);
				$("#screen_mode").val('new');
				$("#menuStatus").val(menuStatus);
				$("#main_form").submit();
			}

			// 更新ボタン処理
			function trans(org_no,quiz_no,action){
				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;
				
				setDataTableData();

				$("#org_no").val(org_no);
				$("#search_quiz_name").val($("#quiz_name").val());
				$("#search_quiz_content").val($("#quiz_content").val());
				$("#search_remark").val($("#remark").val());
				$("#search_rd_status1").val($('input[name=rd_status1]:checked').val());
				$("#search_org_id").val($("#search_org_id").val());
				
				$("#main_form").attr("action", action);
				$("#screen_mode").val('update');
				$("#quiz_no").val(quiz_no);
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

				$("#search_page").val(page);
				$("#search_page_row").val(page_row);
				$("#search_page_order_column").val(page_order_column);
				$("#search_page_order_dir").val(page_order_dir);

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
