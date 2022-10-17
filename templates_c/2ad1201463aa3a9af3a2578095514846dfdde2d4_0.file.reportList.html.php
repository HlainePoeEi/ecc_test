<?php
/* Smarty version 3.1.29, created on 2022-10-13 11:45:44
  from "/var/www/html/eccadmin_dev/templates/reportList.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_63477bd8482d69_54600284',
  'file_dependency' => 
  array (
    '2ad1201463aa3a9af3a2578095514846dfdde2d4' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/reportList.html',
      1 => 1651911197,
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
function content_63477bd8482d69_54600284 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
	<title>レポート一覧</title>
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
    <form id="main_form"  action="<?php echo @constant('HOME_DIR');?>
ReportList/Search" method="post">
        <input type="hidden" id="report_no" name="report_no"/>
        <input type="hidden" id="org_no" name="org_no"/>
        <input type="hidden" id="test_info_no" name="test_info_no"/>
        <input type="hidden" id ="screen_mode" name="screen_mode"  value="<?php echo $_smarty_tpl->tpl_vars['form']->value->screen_mode;?>
"/>
        <input type="hidden" id="page" name="page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->page;?>
" />
        <input type="hidden" id="back_flg" name="back_flg" />
        <input type="hidden" id="home_dir" value="<?php echo @constant('HOME_DIR');?>
" />
        <input type="hidden" id="search_org_id" name="search_org_id" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->search_org_id, ENT_QUOTES, 'UTF-8', true);?>
"/>
        <input type="hidden" id="search_report_name" name="search_report_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->search_report_name, ENT_QUOTES, 'UTF-8', true);?>
"/>
        <input type="hidden" id="search_test_info_name" name="search_test_info_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->search_test_info_name, ENT_QUOTES, 'UTF-8', true);?>
"/>
        <input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
"/>
        <input type="hidden" id="search_page_row" name="search_page_row" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_row;?>
" />
		<input type="hidden" id="search_page_order_column" name="search_page_order_column" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_column;?>
" />
		<input type="hidden" id="search_page_order_dir" name="search_page_order_dir" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_dir;?>
" />

        <!-- 戻るの場合リストか登録かの画面を分けるため -->
            
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
                                >> <span class="title">レポート一覧</span>
                            </p>
                            <table class="main_tbl" style="width:100%">
                    
                                <tr>
                                    <br><br>
                                    <td>レポート名</td>
                                    <td class="input"><input class="text" type="text"
                                        name="report_name" id="report_name"
                                        value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->report_name, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "32" size="30"></td>
                                    <td>組織ID</td>
                                    <td><input class="text" type="text" name="org_id" id="org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_id;?>
" maxlength="32" size="30"></td>
                                   
                                </tr>
                               
                                <tr>
                                    <td>試験名</td>
                                    <td class="input"><input class="text" type="text"
                                        name="test_info_name" id="test_info_name"
                                        value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->test_info_name, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "32" size="30"></td>
                                </tr>
                            </table>
                            <br/>
                            <div align="right" style="width:100%">
                                <input type="submit" id="btn_search" name="search" title="検索" class="btn_search" alt="search" value="" style="padding-right:50px;">
                                <input type="button" id="add" name="add_test" class="btn_add" value="" title="新規登録" onclick="javascript:doInsert('<?php echo @constant('HOME_DIR');?>
ReportRegist/index')">
                            </div>

                            
                            <?php if (!empty($_smarty_tpl->tpl_vars['list']->value)) {?>
                            <table class="tbl_search" id="tbl_search" width="100%">
                                <thead width="100%">
                                    <tr width="100%">
                                        <th width="100px">組織ログインID</th>
                                        <th width="200px">組織</th>
                                        <th width="100px">レポート名</th>
                                        <th width="400px">試験</th>
                                        <th width="100px">テンプレート</th>
                                        <th width="50px">詳細</th>
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
                                        <td width="100px"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->org_id, ENT_QUOTES, 'UTF-8', true);?>
</td>
                                        <td width="200px"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->org_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
                                        <td width="100px" ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->report_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
                                        <td width="400px"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->test_info_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
										<td width="100px">
											<?php if ($_smarty_tpl->tpl_vars['result']->value->file_name != '') {?>
												<a href="<?php echo @constant('ADMIN_HOME_DIR');?>
files/<?php echo $_smarty_tpl->tpl_vars['result']->value->org_no;?>
/Report/<?php echo $_smarty_tpl->tpl_vars['result']->value->file_name;?>
" download> Template</a>
											<?php }?>
										</td>
                                        <td width="50px">
                                            <input type="button" class="btn_edit" name="edit" title="編集" onclick="trans('<?php echo $_smarty_tpl->tpl_vars['result']->value->org_no;?>
','<?php echo $_smarty_tpl->tpl_vars['result']->value->report_no;?>
','<?php echo @constant('HOME_DIR');?>
ReportRegist/index')">
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
        </div><!-- End divBody -->
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
            
			function doInsert(action){
              
            //slpp
                var menuOpen = document.getElementById('menuOpen').value;
                var menuStatus = document.getElementById('menuStatus').value;

                setDataTableData();

                $("#search_report_name").val($("#report_name").val());
                $("#search_test_info_name").val($("#test_info_name").val());
                $("#search_org_id").val($("#org_id").val());


                $("#main_form").attr("action", action);
                $("#screen_mode").val("new");
                $("#menuOpen").val(menuOpen);
                $("#menuStatus").val(menuStatus);
                $("#main_form").submit();
                
              
            }

            // 更新ボタン処理
            function trans(org_no,report_no,action){
                 //slpp
				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;

                setDataTableData();
                
				$("#search_report_name").val($("#report_name").val());
				$("#search_test_info_name").val($("#test_info_name").val());
                $("#search_org_id").val($("#org_id").val());
				
				
				$("#main_form").attr("action", action);
				$("#screen_mode").val("update");
				$("#report_no").val(report_no);
                $("#org_no").val(org_no);
		        $("#menuOpen").val(menuOpen);
		        $("#menuStatus").val(menuStatus);
				$("#main_form").submit();
			}

            function setDataTableData(){
            
                var page = 0;
                var page_row = 10;
                var order;
                var page_order_column = 1;
                var page_order_dir = true;
                    
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
	</body>
</html><?php }
}
