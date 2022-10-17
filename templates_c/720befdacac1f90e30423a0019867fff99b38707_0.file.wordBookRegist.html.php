<?php
/* Smarty version 3.1.29, created on 2022-10-13 11:41:38
  from "/var/www/html/eccadmin_dev/templates/wordBookRegist.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_63477ae2c030c1_18674363',
  'file_dependency' => 
  array (
    '720befdacac1f90e30423a0019867fff99b38707' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/wordBookRegist.html',
      1 => 1646806122,
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
function content_63477ae2c030c1_18674363 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
	<head>
	<title>単語帳登録</title>
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
	<link href="<?php echo @constant('HOME_DIR');?>
css/quizlist.css" rel="stylesheet">
	<?php echo '<script'; ?>
 type="text/javascript">

				// inputにエンターキー押下時のsubmitを無効化
				$(document).on("keypress", "input:not(.allow_submit)", function(event) {
					return event.which !== 13;
				});
				// selectにエンターキー押下時のsubmitを無効化
				$(document).on("keypress", "select:not(.allow_submit)", function(event) {
					return event.which !== 13;
				});
				$(document).ready(function() {
					// MSGのあるなし
					if ( $(".error_msg").html() != "" ){
								$(".error_section").slideDown('slow')}
								$(".close_icon").on('click', function(){
								$(".error_section").slideUp('slow')
					});
						$(".btn_insert").on('click',function() {
							$(".error_section").hide();
							var word_book_name = $('#word_book_name').val();
							var word_lang_type =  $('#word_lang_type').val();
							var trans_lang_type =  $('#trans_lang_type').val();
							var org=$('#org_id').val();
							if (org == "" ) {
									$('#err_dis').show();
									$(".error_section").slideToggle('slow');
									$(".error_msg").html(" 組織を入力してください。");
									$(".divBody").scrollTop(0);
										return false;
							}
							if ( word_book_name == "" ) {
								$('#err_dis').show();
								$(".error_section").slideToggle('slow');
								$(".error_msg").html("単語帳名を入力してください。");
								$(".divBody").scrollTop(0);
							return false;
							}
							if ( word_lang_type == "" ) {
								$('#err_dis').show();
								$(".error_section").slideToggle('slow');
								$(".error_msg").html("単語言語を選んでください。");
								$(".divBody").scrollTop(0);
							return false;
							}
							if ( trans_lang_type == "" ) {
								$('#err_dis').show();
								$(".error_section").slideToggle('slow');
								$(".error_msg").html("訳言語を選んでください。");
								$(".divBody").scrollTop(0);
							return false;
							}
					});
				});

			//戻るボタン処理
			function doBack(action){
				$("#main_form").attr("action", action);
				$("#main_form").submit();
			}
	<?php echo '</script'; ?>
>
	</head>
	<body class="pushmenu-push">
		<form id="main_form" action="<?php echo @constant('HOME_DIR');?>
WordBookRegist/Save" method="post">
			<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:leftMenu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<div class="divHeader">
				<!--header-->
					<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

				<!--header-->
			</div>
			<input type="hidden" id="back_flg" name="back_flg" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->back_flg;?>
" />
			<input type="hidden" id="home_dir" value="<?php echo @constant('HOME_DIR');?>
" />
			<input type="hidden" id="wordbook_id" name="wordbook_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->wordbook_id;?>
"/>
			<input type="hidden" id="copy_wordbook_id" name="copy_wordbook_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->copy_wordbook_id;?>
"/>
			<input type="hidden" id="copy_org_no" name="copy_org_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->copy_org_no;?>
"/>
			<input type="hidden" id="org_no" name="org_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
"/>
			<input type="hidden" id="org_name" name="org_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_name;?>
"/>
			<input type="hidden" id="org_name_official" name="org_name_official" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_name_official;?>
"/>
			<input type="hidden" id="search_name" name="search_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_name;?>
"/>
			<input type="hidden" id="search_org_id" name="search_org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_org_id;?>
"/>
			<input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
"/>
			<input type="hidden" id="search_page_row" name="search_page_row" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_row;?>
" />
			<input type="hidden" id="search_page_order_column" name="search_page_order_column" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_column;?>
" />
			<input type="hidden" id="search_page_order_dir" name="search_page_order_dir" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_dir;?>
" />
			<input type="hidden" id="screen_name" name="screen_name" />
			<input type="hidden" id="screen_mode" name="screen_mode" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->screen_mode;?>
"/>
			<div class="divBody">
				<div class="main">
					<section class="error_section">
						<img src="<?php echo @constant('HOME_DIR');?>
image/close_icon.png" style="width:15px;float:right" class="close_icon">
							<?php if (!empty($_smarty_tpl->tpl_vars['msg']->value)) {?>
							<div class="error_msg"><?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
</div>
							<?php } elseif (!empty($_smarty_tpl->tpl_vars['info_msg']->value)) {?>
							<div class="error_msg"><?php echo $_smarty_tpl->tpl_vars['info_msg']->value;?>
</div>
							<?php } elseif (!empty($_smarty_tpl->tpl_vars['err_msg']->value)) {?>
							<div class="error_msg"><?php echo $_smarty_tpl->tpl_vars['err_msg']->value;?>
</div>
							<?php } else { ?>
							 <div class="error_msg"></div>
							<?php }?>
					</section>
					<section class="content">
						<p>
							>> <span class="title">単語 / 単語帳登録</span>
						</p>
						<p style="text-align:right;width:100%;">
							<input type="button" title="戻る" value="" class="btn_back" onclick="javascript:doBack('<?php echo @constant('HOME_DIR');?>
WordBookRegist/back')">
						</p>
						<div width="100%">
							<table style="width:auto;">
								<!-- change width and add tr open tag and delete td between org id and btn-->
								<tr>
									<td style="width:240px;">
										<label class="lbl_name" >組織<span class="required">※</span></label>
									</td>
									<td>
										<?php if ($_smarty_tpl->tpl_vars['form']->value->screen_mode != 'update') {?> 
											<input id="org_id" name="org_id" type="text" class="text" maxlength="10" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_id;?>
">
											<input type="button" style="margin-left: 20px;" class="btn_quiz_assign_list" name="btn_qa_assign" id="org_display" onclick="javascript:showOrg('<?php echo @constant('HOME_DIR');?>
WordBookRegist/orgShow')">
										 <?php } else { ?>
											<input id="org_id" name="org_id" type="text" class="text" maxlength="10" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_id;?>
" readonly>
										<?php }?> 
									</td>
									<td id="abc" style="width: 170px;">
										<label class="lbl_name" ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->org_name, ENT_QUOTES, 'UTF-8', true);?>
</label>
									</td>
									<td id="abc" style="width: 170px;">
										<label class="lbl_name" ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->org_name_official, ENT_QUOTES, 'UTF-8', true);?>
</label>
									</td>
								</tr>
								<tr><td></td></tr>
									<tr>
										<!-- remove required check and remove if condition in Dao -->
										<td style="width:240px;">単語帳名<span class="required">※</span></td>
										<td><input type="text" class="text" id="word_book_name" name="word_book_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->word_book_name;?>
" maxlength = "32" size="30"></td>
									</tr>
									<tr><td></td></tr>
									<tr>
										<td style="width:240px;">タグ</td>
										<td><input type="text" class="text" id="tag" name="tag" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->tag;?>
" maxlength = "32" size="30"></td>
									</tr>
									<tr><td></td></tr>
									<tr>
										<td  style="width:240px;">
											<label>単語言語</label><span class="required">※</span>
										</td>
										<td>
											<select name="word_lang_type" id="word_lang_type" style="width:189px;">
												<?php if (!empty($_smarty_tpl->tpl_vars['word_category']->value)) {?>
														<?php ob_start();
echo ($_smarty_tpl->tpl_vars['form']->value->word_lang_type);
$_tmp1=ob_get_clean();
if ($_tmp1 == '') {?>
																<option value=""　selected> 選択してください。</option>
															<?php
$_from = $_smarty_tpl->tpl_vars['word_category']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_word_0_saved_item = isset($_smarty_tpl->tpl_vars['word']) ? $_smarty_tpl->tpl_vars['word'] : false;
$_smarty_tpl->tpl_vars['word'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['word']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['word']->value) {
$_smarty_tpl->tpl_vars['word']->_loop = true;
$__foreach_word_0_saved_local_item = $_smarty_tpl->tpl_vars['word'];
?>
																<option value= <?php echo $_smarty_tpl->tpl_vars['word']->value->type;?>
> <?php echo $_smarty_tpl->tpl_vars['word']->value->name;?>
 </option>
															<?php
$_smarty_tpl->tpl_vars['word'] = $__foreach_word_0_saved_local_item;
}
if ($__foreach_word_0_saved_item) {
$_smarty_tpl->tpl_vars['word'] = $__foreach_word_0_saved_item;
}
?>
														<?php } else { ?>
															<?php
$_from = $_smarty_tpl->tpl_vars['word_category']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_word_1_saved_item = isset($_smarty_tpl->tpl_vars['word']) ? $_smarty_tpl->tpl_vars['word'] : false;
$_smarty_tpl->tpl_vars['word'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['word']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['word']->value) {
$_smarty_tpl->tpl_vars['word']->_loop = true;
$__foreach_word_1_saved_local_item = $_smarty_tpl->tpl_vars['word'];
?>
																<?php ob_start();
echo ($_smarty_tpl->tpl_vars['form']->value->word_lang_type);
$_tmp2=ob_get_clean();
ob_start();
echo $_smarty_tpl->tpl_vars['word']->value->type;
$_tmp3=ob_get_clean();
if ($_tmp2 == $_tmp3) {?>
																	<option value=<?php echo $_smarty_tpl->tpl_vars['word']->value->type;?>
 selected><?php echo $_smarty_tpl->tpl_vars['word']->value->name;?>
 </option>
																<?php } else { ?>
																	<option value=<?php echo $_smarty_tpl->tpl_vars['word']->value->type;?>
><?php echo $_smarty_tpl->tpl_vars['word']->value->name;?>
 </option>
																<?php }?>
															<?php
$_smarty_tpl->tpl_vars['word'] = $__foreach_word_1_saved_local_item;
}
if ($__foreach_word_1_saved_item) {
$_smarty_tpl->tpl_vars['word'] = $__foreach_word_1_saved_item;
}
?>
														<?php }?>
												<?php }?>
											</select>
										</td>
									</tr>
									<tr><td></td></tr>
									<tr>
										<td style="width:240px;">
											<label>訳言語</label><span class="required">※</span>
										</td>
										<td>
											<input type="hidden" name="trans_lang_type" value=<?php echo $_smarty_tpl->tpl_vars['form']->value->trans_lang_type;?>
>
											<select name="trans_lang_type" id="trans_lang_type" style="width:189px;">
												<?php if (!empty($_smarty_tpl->tpl_vars['trans_category']->value)) {?>
														<?php ob_start();
echo ($_smarty_tpl->tpl_vars['form']->value->trans_lang_type);
$_tmp4=ob_get_clean();
if ($_tmp4 == '') {?>
																<option value=""　selected> 選択してください。</option>
															<?php
$_from = $_smarty_tpl->tpl_vars['trans_category']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_tran_2_saved_item = isset($_smarty_tpl->tpl_vars['tran']) ? $_smarty_tpl->tpl_vars['tran'] : false;
$_smarty_tpl->tpl_vars['tran'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['tran']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['tran']->value) {
$_smarty_tpl->tpl_vars['tran']->_loop = true;
$__foreach_tran_2_saved_local_item = $_smarty_tpl->tpl_vars['tran'];
?>
																<option value=<?php echo $_smarty_tpl->tpl_vars['tran']->value->type;?>
 > <?php echo $_smarty_tpl->tpl_vars['tran']->value->name;?>
 </option>
															<?php
$_smarty_tpl->tpl_vars['tran'] = $__foreach_tran_2_saved_local_item;
}
if ($__foreach_tran_2_saved_item) {
$_smarty_tpl->tpl_vars['tran'] = $__foreach_tran_2_saved_item;
}
?>
														<?php } else { ?>
															<?php
$_from = $_smarty_tpl->tpl_vars['trans_category']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_tran_3_saved_item = isset($_smarty_tpl->tpl_vars['tran']) ? $_smarty_tpl->tpl_vars['tran'] : false;
$_smarty_tpl->tpl_vars['tran'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['tran']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['tran']->value) {
$_smarty_tpl->tpl_vars['tran']->_loop = true;
$__foreach_tran_3_saved_local_item = $_smarty_tpl->tpl_vars['tran'];
?>
																<?php ob_start();
echo ($_smarty_tpl->tpl_vars['form']->value->trans_lang_type);
$_tmp5=ob_get_clean();
ob_start();
echo $_smarty_tpl->tpl_vars['tran']->value->type;
$_tmp6=ob_get_clean();
if ($_tmp5 == $_tmp6) {?>
																	<option value=<?php echo $_smarty_tpl->tpl_vars['tran']->value->type;?>
 selected><?php echo $_smarty_tpl->tpl_vars['tran']->value->name;?>
</option>
																<?php } else { ?>
																	<option value=<?php echo $_smarty_tpl->tpl_vars['tran']->value->type;?>
 ><?php echo $_smarty_tpl->tpl_vars['tran']->value->name;?>
</option>
																<?php }?>
															<?php
$_smarty_tpl->tpl_vars['tran'] = $__foreach_tran_3_saved_local_item;
}
if ($__foreach_tran_3_saved_item) {
$_smarty_tpl->tpl_vars['tran'] = $__foreach_tran_3_saved_item;
}
?>
														<?php }?>
												<?php }?>
											</select>
										</td>
									</tr>
                                <tr><td></td></tr>
                                <tr>
									<td>公開</td>
									<td>
									<!-- <?php if ($_smarty_tpl->tpl_vars['form']->value->status != '1') {?> -->
									<input type="radio" name="status" value="0" id="status1" checked />
									<label for="status1">しない  </label></input>
									<input type="radio" name="status" value="1" id="status2" />
									<label for="status2"> する</label></input>
									<!-- <?php } else { ?> -->
									<input type="radio" name="status" value="0" id="status1" />
									<label for="status1">しない  </label></input>
									<input type="radio" name="status" value="1" id="status2" checked />
									<label for="status2"> する</label>
									</input>
									<!-- <?php }?> -->
									</td>
								</tr>
								<tr><td></td></tr>
							</table>
							<br/>
                            <table>
								<tr class="rb_row1">
									<!-- <?php if ($_smarty_tpl->tpl_vars['form']->value->screen_mode == 'update' || $_smarty_tpl->tpl_vars['form']->value->screen_mode == 'copied') {?> -->
									<td style="text-align:right">
										<input type="button" value="" title="追加" id="btn_add_1" onclick="javascript:goWBWInsert('<?php echo $_smarty_tpl->tpl_vars['form']->value->wordbook_id;?>
','<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
','<?php echo @constant('HOME_DIR');?>
WordBookWord/index')" class="btn_add">
									</td>
                          			<!-- <?php }?> -->
									<td></td>
                                    <td width = "75px;"></td>
                                    <td colspan="2"></td>
                                    <td width="100px;"></td>
                                    <td width="400px;"></td>
									<!-- <?php if ($_smarty_tpl->tpl_vars['form']->value->screen_mode == 'update' || $_smarty_tpl->tpl_vars['form']->value->screen_mode == 'copied') {?> -->
                                    <td style="text-align:right">
											<!--20220309_事業部担当者対応-->
											<?php if ($_smarty_tpl->tpl_vars['admin_kbn']->value != "005") {?>
                                    			<input type="button" value="" title="削除" id="btn_remove_1" onclick="javascript:deleteWB('<?php echo $_smarty_tpl->tpl_vars['form']->value->wordbook_id;?>
','<?php echo @constant('HOME_DIR');?>
WordBookRegist/delete')" class="btn_delete">
                                    		<?php }?>
                                    	</td>
                          			<!-- <?php }?> -->
                                </tr>
                                <tr>
								<input type="submit" name="insert" id="insert"  value="" class="btn_insert" style="padding-right:20px;float: right;">
							</tr>
                            </table>
						</div>
					</section><!-- End Content -->
				</div><!-- End Main -->
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
				
				//削除 ボタン押下処理
				function deleteWB(wordbook_id, action){
					alertDialog = confirm('Are you sure to delete this wordbook?');
					if ( alertDialog == false ) {
						return false;
					}else {
						var menuOpen = document.getElementById('menuOpen').value;
						var menuStatus = document.getElementById('menuStatus').value;
						$("#main_form").attr("action", action);
						$("#wordbook_id").val(wordbook_id);
						$("#menuOpen").val(menuOpen);
						$("#menuStatus").val(menuStatus);
						$("#main_form").submit();
					}
				}

			// 組織情報表示ボタン
			function showOrg(action){
					var org_id = document.getElementById('org_id').value;
					if ( org_id == "" ) {
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("組織を入力してください。");
						return false;
					}else{
						var menuOpen = document.getElementById('menuOpen').value;
						var menuStatus = document.getElementById('menuStatus').value;
						$("#main_form").attr("action", action);
						$("#menuOpen").val(menuOpen);
						$("#menuStatus").val(menuStatus);
						$("#main_form").submit();
					}
				}

			function goWBWInsert(wordbook_id, org_no, action){
					var menuOpen = document.getElementById('menuOpen').value;
					var menuStatus = document.getElementById('menuStatus').value;
					var screen_mode=document.getElementById('screen_mode').value;
					var copy_wordbook_id=document.getElementById('copy_wordbook_id').value;
					var copy_org_no=document.getElementById('copy_org_no').value;
					$("#main_form").attr("action", action);
					if(screen_mode=="copied"){
						$("#wordbook_id").val(copy_wordbook_id);
						$("#copy_wordbook_id").val(wordbook_id);
						$("#org_no").val(copy_org_no);
						$("#copy_org_no").val(org_no);
					}else{
						$("#wordbook_id").val(wordbook_id);
						$("#org_no").val(org_no);
					}
					$("#screen_mode").val(screen_mode);
					$("#screen_name").val("regist");
					$("#menuOpen").val(menuOpen);
					$("#menuStatus").val(menuStatus);
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
