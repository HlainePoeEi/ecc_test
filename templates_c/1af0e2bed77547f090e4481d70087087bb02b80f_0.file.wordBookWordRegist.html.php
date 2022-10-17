<?php
/* Smarty version 3.1.29, created on 2022-07-13 13:19:41
  from "/var/www/html/eccadmin_dev/templates/wordBookWordRegist.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_62ce47ddf21076_62147418',
  'file_dependency' => 
  array (
    '1af0e2bed77547f090e4481d70087087bb02b80f' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/wordBookWordRegist.html',
      1 => 1640334691,
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
function content_62ce47ddf21076_62147418 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate')) require_once '/var/www/html/eccadmin_dev/libs/smarty/libs/plugins/modifier.truncate.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>単語追加</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta name="robots" content="noindex, nofollow">
<meta name="googlebot" content="noindex, nofollow">

<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('HOME_DIR');?>
js/groupregist.js"><?php echo '</script'; ?>
>
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
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('HOME_DIR');?>
js/datables_select_box.js"><?php echo '</script'; ?>
>

<link href="<?php echo @constant('HOME_DIR');?>
css/jquery-ui.css" rel="stylesheet">
<link href="<?php echo @constant('HOME_DIR');?>
css/default.css" rel="stylesheet">
<link href="<?php echo @constant('HOME_DIR');?>
css/datatables.css" rel="stylesheet">
<link href="<?php echo @constant('HOME_DIR');?>
css/datatables_select.min.css" rel="stylesheet">
<link href="<?php echo @constant('HOME_DIR');?>
css/groupstudentregist.css"	rel="stylesheet">
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

				//データテーブルを表示する
			var dataArray = $("#list").val();
			if (dataArray != "") {
				$('#word_assign_tbl_cb').DataTable( {
					"scrollY": 300,
					"scrollX": true,
					"bFilter": false,
					"ordering": false,
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
							"first":	"First",
							"last": 	"Last",
							"next": 	"次",
							"previous": 	"前"
						},
						"lengthMenu":" _MENU_ 件表示"
					},
					"initComplete": function () {
						getTotalRowCount();
					},
					order: [[ 1, 'asc' ]]
				});
			}

			//データテーブルを表示する
			var dataArray = $("#list").val();
			var current_page = parseInt($("#search_page").val());
			var current_page_row = parseInt($("#search_page_row").val());
			var current_order_column = $("#search_page_order_column").val();
			var current_order_dir = $("#search_page_order_dir").val();

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
	<form id="main_form"
		action="<?php echo @constant('HOME_DIR');?>
WordBookWord/Search" method="post">
		<input type="hidden" id="org_no" name="org_no" value ="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
"/>
		<input type="hidden" id="wordbook_id" name="wordbook_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->wordbook_id;?>
"/>
		<input type="hidden" id="copy_org_no" name="copy_org_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->copy_org_no;?>
"/>
		<input type="hidden" id="copy_wordbook_id" name="copy_wordbook_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->copy_wordbook_id;?>
"/>
		<input type="hidden" id="word_book_name" name="word_book_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->word_book_name;?>
" />
		<input type="hidden" id="tag" name="tag" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->tag;?>
"/>
		<input type="hidden" id="word_lang_type" name="word_lang_type" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->word_lang_type;?>
" />
		<input type="hidden" id="trans_lang_type" name="trans_lang_type" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->trans_lang_type;?>
" />
		<input type="hidden" id="status" name="status" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->status;?>
" />
		<input type="hidden" id="entryList" name="entryList" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->entryList;?>
" />
		<input type="hidden" id="initialList" name="initialList" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->initialList;?>
" />
		<input type="hidden" id="screen_name" name="screen_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->screen_name;?>
"/>
		<input type="hidden" id="screen_mode" name="screen_mode" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->screen_mode;?>
"/>
		<input type="hidden" id="back_flg" name="back_flg" value="false" />
		<input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
" />
		<input type="hidden" id="search_name" name="search_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_name;?>
" />
		<input type="hidden" id="search_org_id " name="search_org_id " value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_org_id;?>
" />
		<input type="hidden" id="search_page_row" name="search_page_row" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_row;?>
" />
		<input type="hidden" id="search_page_order_column" name="search_page_order_column" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_column;?>
" />
		<input type="hidden" id="search_page_order_dir" name="search_page_order_dir" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_dir;?>
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
			<div class="container">
				<div class="main">
					<section class="error_section">
						<img src="<?php echo @constant('HOME_DIR');?>
image/close_icon.png" style="width: 15px; float: right" class="close_icon"> 
						<?php if (!empty($_smarty_tpl->tpl_vars['err_msg']->value)) {?>
						<div class="error_msg"><?php echo $_smarty_tpl->tpl_vars['err_msg']->value;?>
</div>
						<?php } else { ?>
						<div class="error_msg"></div>
						<?php }?>
					</section>
					<section class="content">
						<p>
							>> <span class="title">単語 / 単語追加</span>
						</p>
						<p style="text-align:right;width:100%;">
							<input type="button" title="戻る" value="" class="btn_back" onclick="javascript:doBack('<?php echo @constant('HOME_DIR');?>
WordBookWord/back')">
						</p>
						<div id="pswChange" style="padding-top:30px;">
							<table class="main_tbl" style="width:100%">
								<tr>
									<td style="width:120px;">単語</td>
									<td class="input"><input class="text" type="text" name="word" id="word" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->word, ENT_QUOTES, 'UTF-8', true);?>
" ></td>
								</tr>
							</table>
						</div>
	
						<div align="right" style="width:100%">
							<input type="submit" id="btn_search" name="search" title="検索" class="btn_search" alt="search" value="" style="padding-right:0px;">
						</div>

						<input type="hidden" id="page" name="page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->page;?>
" />
						<input type="hidden" id="home_dir"
							value="<?php echo @constant('HOME_DIR');?>
" />

						<table id="word_assign_tbl_cb" class="tbl_search" style="border-collapse: collapse; font-size: 1.0em;width:100%" style="display:none;">
							<thead>
								<tr>
									<th width="100px;"></th>
									<th width="300px">単語</th>
									<th width="100px">意味</th>
									<th></th>
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
									<?php if ((in_array($_smarty_tpl->tpl_vars['result']->value->word_id,$_smarty_tpl->tpl_vars['data_list']->value))) {?>
	        							<?php $_smarty_tpl->tpl_vars["selected"] = new Smarty_Variable("selected", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "selected", 0);?>
	        						<?php } else { ?>
	 									<?php $_smarty_tpl->tpl_vars["selected"] = new Smarty_Variable('', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "selected", 0);?>
	        						<?php }?>
								<tr id="word_id_<?php echo $_smarty_tpl->tpl_vars['result']->value->word_id;?>
" class="<?php echo $_smarty_tpl->tpl_vars['selected']->value;?>
">
									<td></td>
									<td width="100px"><?php echo $_smarty_tpl->tpl_vars['result']->value->word;?>
</td>
									<td style="width:300px;!important"><?php echo smarty_modifier_truncate(htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->translation, ENT_QUOTES, 'UTF-8', true),40,'...');?>
</td>
								
									<td width="100px">
										
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
						<div style="width:100%; ">
							<table style="float:right;">
								<tr>
									<td style="width:70px;height:60px;">
										<input id="btn_insert" type="button" class="btn_insert" name="btn_insert" title="登録"  value="" onclick="javascript:doRegist('<?php echo $_smarty_tpl->tpl_vars['form']->value->wordbook_id;?>
','<?php echo @constant('HOME_DIR');?>
WordBookWord/vocubRegist')">
									</td>
								</tr>
							</table>
						</div>

					</section>
				</div>
			</div>
		</div>
		<!-- End divBody -->
		<div class="divFooter">
			<!--footer-->
			<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<!--footer-->
		</div>
	</form>
	<?php echo '<script'; ?>
>
		

			function doRegist(wordbook_id,action) {
			
				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;
				var array = [];
				var word_id = document.querySelectorAll('input[type=checkbox]:checked')

				for (var i = 0; i < word_id.length; i++) {
					array.push(word_id[i].value);
				}
				$("#checked_word").val(array);
				$("#wordbook_id").val(wordbook_id);
				$("#menuOpen").val(menuOpen);
				$("#menuStatus").val(menuStatus);
				$("#back_flg").val(true);
				$("#main_form").attr("action", action);
				$("#main_form").submit();
			}

			//戻るボタン
			function doBack(action){
				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;
				$("#main_form").attr("action", action);
				$("#menuOpen").val(menuOpen);
				$("#menuStatus").val(menuStatus);
				$("#back_flg").val(true);
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

			$(function(){
				var entryList = [];
				$('#word_assign_tbl_cb tbody tr').each(function() {
	
					var word_id = $(this).attr('id');
					word_id = word_id.split("word_id_")[1];
	
					entryList = $("#entryList").val();
					entryList = entryList.split(",");
	
					var flag = $.inArray( word_id, entryList);
	
					if(flag != -1){
						$(this).addClass('selected');
					}
				});
				$("#word_assign_tbl_cb").show();
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

			$('#word_assign_tbl_cb tbody tr').on('click', function(){

	        	var word_selected_list = $("#entryList").val();
	 			var word_id = $(this).attr('id');
	 			word_id = word_id.split("word_id_")[1];
	 			var selected_class = $(this).attr('class');
	 			selected_class = selected_class.split(" ");
	 			var table = $('#word_assign_tbl_cb').DataTable();

	 			if(selected_class.length > 1){

	 				var word_list = word_selected_list.split(",");
	 				var temp = $.inArray( word_id, word_list );
	 				if(temp != -1){
	 					word_selected_list = word_selected_list.replace(word_id+",", "");
	 				}
	 				$("#entryList").val(word_selected_list);
	 				$(this).toggleClass('selected');
	 			}else{

	 				if(word_selected_list == ""){
	 					word_selected_list += word_id + ",";
	 				}else{
	 					var word_list = word_selected_list.split(",");
	 					var temp = $.inArray( word_id, word_list );
	 					if(temp == -1){
	 						word_selected_list += word_id + ",";
	 					}
	 				}
	 				$(this).toggleClass('selected');
	 				$("#entryList").val(word_selected_list);
	 			}
	 			$(".select-info").remove();
	 			getTotalRowCount();
			});

		
	<?php echo '</script'; ?>
>

	<!--footer-->
	<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

	<!--footer-->

</body>
</html><?php }
}
