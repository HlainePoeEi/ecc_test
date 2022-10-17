<?php
/* Smarty version 3.1.29, created on 2022-09-05 13:06:22
  from "/var/www/html/eccadmin_dev/templates/quizDetailsRegist.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_631575be958f75_25217403',
  'file_dependency' => 
  array (
    '55f196269e3a6addf0651b3e47031d177c3226aa' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/quizDetailsRegist.html',
      1 => 1628235306,
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
function content_631575be958f75_25217403 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
	<title>クイズアイテム登録</title>
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
js/quizdetailsregist.js"><?php echo '</script'; ?>
>
    
    <link href="<?php echo @constant('HOME_DIR');?>
css/default.css" rel="stylesheet">
    <link href="<?php echo @constant('HOME_DIR');?>
css/quizdetailsregist.css" rel="stylesheet">
    <?php echo '<script'; ?>
>
    $(document).ready(function() {

    	var err_msg = document.getElementById('err_msg').value;
    	if ( err_msg != "" ){
            $('#err_dis').show();
            $(".error_section").slideToggle('slow');
            $(".error_msg").html(err_msg);
        }
       else {
           $('#err_dis').hide();
      }

        // error sessionを閉じる
		$(".close_icon").on('click', function() {
			 document.getElementById('err_msg').value="";
			 $(".error_msg").html("");
	         $('#err_dis').hide();
	    });

		//新規登録の場合、
		var select_display =<?php echo $_smarty_tpl->tpl_vars['qzInfoCount']->value;?>
;
		if(select_display < 1) {

			changeSelectValue("sflag",1);
		}

    });

    function doBack(org_no , quiz_info_no,screen_mode, action,uid){
    	var menuOpen = document.getElementById('menuOpen').value;
        var menuStatus = document.getElementById('menuStatus').value;

		$("#org_no").val(org_no);
        $("#quiz_info_no").val(quiz_info_no);
        $("#screen_mode").val(screen_mode);
        $("#main_form").attr("action", action);
        $("#uid").val(uid);
        $("#menuOpen").val(menuOpen);
        $("#menuStatus").val(menuStatus);

        $("#main_form").submit();
    }

 // 入力チェック処理
    function checkInsertData() {

    	$(".error_section").hide();
        var table = document.getElementById("new_form");
        var hasError=false;
        var index =1;
        $('#new_form tbody').each(function(){
              var qz_content = document.getElementById("txtarea_"+index).value;
              var qz_mark = document.getElementById("txt_mark_"+index).value;
              var qz_type = document.getElementById("qztype_no_"+index).value;

              var str = $(this).attr("id");
          	  var num = str.replace(/[^0-9]/g, '');
              var index1 = parseInt(num,10);

              if ( qz_content != "" && qz_content.length > 2048 ){

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("問題を2048字で入力してください。");
					$(".divBody").scrollTop(0);
					return false;
			  }
              if(qz_mark == "") {
                  $('#err_dis').show();
                  $(".error_section").slideToggle('slow')
                  $(".error_msg").html("Markを入力してください。");
                  $(".divBody").scrollTop(0);
                  hasError=true;
                  return false;
              }
			   if ( isNaN(qz_mark) ){

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("Markを数字で入力してください。");
					$(".divBody").scrollTop(0);
					hasError=true;
					return false;
				}
              if (qz_type == "001") {

            	  var radios =  document.getElementsByName('rchoice'+index1);
            	  for (var j = 0; j < radios.length; j++) {
          		    if (radios[j].checked) {
          		        var choice_text = document.getElementById("choice"+index1+"_"+(j+1)).value;
          		        if(choice_text == ""){
          		        	$('#err_dis').show();
                            $(".error_section").slideToggle('slow')
                            $(".error_msg").html("選択したアイテムが存在しません。");
                            $(".divBody").scrollTop(0);
                            hasError = true;}
          		    	}
          		  }

                  var txt_c1 = document.getElementById("choice"+index1+"_1").value;
                  var txt_c2 = document.getElementById("choice"+index1+"_2").value;
				  
				  console.log(txt_c1);
                  if(txt_c1 == "" || txt_c2 == "") {

                      $('#err_dis').show();
                      $(".error_section").slideToggle('slow')
                      $(".error_msg").html("C* を入力してください。");
                      $(".divBody").scrollTop(0);
                     hasError=true;
                     return false;
                  }
              }
              else if(qz_type == "002") {
            	  var txt_b1 = document.getElementById("blank"+index1+"_1").value;
            	  if(txt_b1 == "") {

                      $('#err_dis').show();
                      $(".error_section").slideToggle('slow')
                      $(".error_msg").html("A* を入力してください。");
                      $(".divBody").scrollTop(0);
                     hasError=true;
                     return false;
                  }
              }
          index++;
        });
        //登録処理
        if(!hasError){
          insertListData();
		}
        return true;

    }

  <?php echo '</script'; ?>
>
</head>
<title>クイズアイテム登録</title>
<body class="pushmenu-push">

  <form id="main_form" action="<?php echo @constant('HOME_DIR');?>
QuizDetailsRegist/save" method="post">
	<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:leftMenu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<div class="divHeader">
		<!--header-->
			<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

		<!--header-->
	</div>
	<div class="divBody">

		<?php if (!empty($_smarty_tpl->tpl_vars['error_msg']->value) || $_smarty_tpl->tpl_vars['error_msg']->value != '') {?>
			<input type="hidden" id="err_msg" name="err_msg" value="<?php echo $_smarty_tpl->tpl_vars['error_msg']->value;?>
"/>
		<?php } else { ?>
			<input type="hidden" id="err_msg" name="err_msg" value=""/>
		<?php }?>
		 <div id="err_dis">
          <section class="error_section" id = "err">
            <img src="<?php echo @constant('HOME_DIR');?>
image/close_icon.png" style="width:15px;float:right" class="close_icon">
				<div class="error_msg" id="error_msg">
					<?php if (!empty($_smarty_tpl->tpl_vars['error_msg']->value) || $_smarty_tpl->tpl_vars['error_msg']->value != '') {?>
						<?php echo $_smarty_tpl->tpl_vars['error_msg']->value;?>

					<?php }?>
				</div>
            </section>
        </div>

        <section class = "content">
        <p>
         <span class= "title">試験 / クイズアイテム</span>
         <span style="float:right;padding-right:10px;">
              <input type="button" value="" title="戻る" class="btn_back" onclick="doBack('<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
','<?php echo $_smarty_tpl->tpl_vars['form']->value->quiz_info_no;?>
','<?php echo $_smarty_tpl->tpl_vars['form']->value->screen_mode;?>
','<?php echo @constant('HOME_DIR');?>
QuizDetailsRegist/back', '<?php echo $_smarty_tpl->tpl_vars['form']->value->uid;?>
')" />
        </span>
        </p>
        <div class="qz_name" id="testqz_name">
         	<input type="hidden" id="screen_mode" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->screen_mode;?>
" name="screen_mode">
            <input type="hidden" id="quiz_info_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->quiz_info_no;?>
" name="quiz_info_no">
            <input type="hidden" id="showqz_name" name="showqz_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->showqz_name;?>
" />
			<input type="hidden" id="hid_org_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
" name="org_no">
			<input type="hidden" id="date_flg" value="<?php echo $_smarty_tpl->tpl_vars['date_flg']->value;?>
" name="date_flg">
            <input type="hidden" id="home_dir" value="<?php echo @constant('HOME_DIR');?>
" />
			<input type="hidden" id="arrTypeNameList" name="arrTypeNameList" value=""/>
			<input type="hidden" id="arrTypeNameList1" name="arrTypeNameList1" value=""/>
			<input type="hidden" id="arrTypeNameList2" name="arrTypeNameList2" value=""/>

		 <!-- 戻る処理用データ -->
		<input type="hidden" id="org_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
" name="org_no">
		<input type="hidden" id="quiz_info_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->quiz_info_no;?>
" name="quiz_info_no">
		<input type="hidden" id="quiz_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->quiz_name;?>
" name="quiz_name">
		<input type="hidden" id="long_description" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->long_description, ENT_QUOTES, 'UTF-8', true);?>
" name="long_description">
		<input type="hidden" id="remarks" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->remarks;?>
" name="remarks">
		<input type="hidden" id="audio_file" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->audio_file;?>
" name="audio_file">
		<input type="hidden" id="input_audio_file" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->input_audio_file;?>
" name="input_audio_file">
		<input type="hidden" id="audio_del_flg" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->audio_del_flg;?>
" name="audio_del_flg">
		<input type="hidden" id="audio_chk_del" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->audio_chk_del;?>
" name="audio_chk_del">
		 <!-- 検索利用データ -->
		<input type="hidden" id="search_quiz_name" name="search_quiz_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_quiz_name;?>
"/>
		<input type="hidden" id="search_long_description" name="search_long_description" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->search_long_description, ENT_QUOTES, 'UTF-8', true);?>
"/>
		<input type="hidden" id="search_remark" name="search_remark" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_remark;?>
"/>
		<input type="hidden" id="search_rd_status1" name="search_rd_status1" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_rd_status1;?>
"/>
		<input type="hidden" id="search_org_id" name="search_org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_org_id;?>
"/>
		
		<input type="hidden" id="search_page_qil" name="search_page_qil" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_qil;?>
" />
		<input type="hidden" id="search_page_row_qil" name="search_page_row_qil" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_row_qil;?>
" />
		<input type="hidden" id="search_page_order_column_qil" name="search_page_order_column_qil" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_column_qil;?>
" />
		<input type="hidden" id="search_page_order_dir_qil" name="search_page_order_dir_qil" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_dir_qil;?>
" />


        	<label class="lbl_qz_name"> クイズ名 </label>
<!--             To check<label id="lbl_qz_name"> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->showqz_name, ENT_QUOTES, 'UTF-8', true);?>
 </label> -->
			 <label id="lbl_qz_name"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->quiz_name, ENT_QUOTES, 'UTF-8', true);?>
 </label>
		</div>
		<table class="qz_details_border" id="new_form">
		<?php if (!empty($_smarty_tpl->tpl_vars['qzList']->value)) {?>
		<?php $_smarty_tpl->tpl_vars['indx1'] = new Smarty_Variable(0, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'indx1', 0);?>
        <?php
$_from = $_smarty_tpl->tpl_vars['qzList']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_obj_0_saved_item = isset($_smarty_tpl->tpl_vars['obj']) ? $_smarty_tpl->tpl_vars['obj'] : false;
$_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['obj']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['obj']->key => $_smarty_tpl->tpl_vars['obj']->value) {
$_smarty_tpl->tpl_vars['obj']->_loop = true;
$__foreach_obj_0_saved_local_item = $_smarty_tpl->tpl_vars['obj'];
?>
        <!-- <?php echo $_smarty_tpl->tpl_vars['indx1']->value;?>
 -->

         <tbody id="tbody<?php echo $_smarty_tpl->tpl_vars['obj']->key+1;?>
">
              <tr>
                <td><?php echo $_smarty_tpl->tpl_vars['obj']->key+1;?>
.</td>
                <td width="75px;">タイプ</td>
                <td colspan="2">
                  <select id="qztype_no_<?php echo $_smarty_tpl->tpl_vars['obj']->key+1;?>
" name="qz_type" onchange="changeSelectValue(this,<?php echo $_smarty_tpl->tpl_vars['obj']->key+1;?>
)"  class="qz_type">
                    <?php if (!empty($_smarty_tpl->tpl_vars['qztypeNo']->value)) {?>
                        <?php
$_from = $_smarty_tpl->tpl_vars['qztypeNo']->value;
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
                           <?php if ($_smarty_tpl->tpl_vars['value']->value->type == $_smarty_tpl->tpl_vars['obj']->value->quiz_type) {?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['value']->value->type;?>
" selected><?php echo $_smarty_tpl->tpl_vars['value']->value->name;?>
 </option>
                          <?php } else { ?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['value']->value->type;?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value->name;?>
 </option>
                          <?php }?>
                        <?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_1_saved_local_item;
}
if ($__foreach_value_1_saved_item) {
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_1_saved_item;
}
?>
                     <?php }?>
                  </select>
                </td>
                <td width="200px;"></td>
                 <td width="75px;">Q<span class="required">※</span></td>
                 <td width="118px;"></td>
                 <td width="218px;"></td>
                </tr>

                <tr>
                <td></td>
                <td width="75px;">点数<span class="required">※</span></td>
                <td colspan="2">
                <input type="text" class="text_box" id="txt_mark_<?php echo $_smarty_tpl->tpl_vars['obj']->key+1;?>
" value="<?php echo $_smarty_tpl->tpl_vars['obj']->value->marks;?>
" name="qz_mark" size="30" maxlength = "3">
                </td>
                <td width="100px;"></td>
                <td rowspan="4" colspan="3" ><textarea class="txtarea" id = "txtarea_<?php echo $_smarty_tpl->tpl_vars['obj']->key+1;?>
" name="qz_content" size="30" maxlength = "2048"><?php echo $_smarty_tpl->tpl_vars['obj']->value->description;?>
</textarea></td>
				</tr>
				<tr></tr><tr></tr><tr></tr>
				<?php if ($_smarty_tpl->tpl_vars['obj']->value->quiz_type == "001") {?>

				<?php if (!empty($_smarty_tpl->tpl_vars['qzListOpt']->value)) {?>
				<div style="display: none;"><?php $_smarty_tpl->tpl_vars['idx'] = new Smarty_Variable(1, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'idx', 0);?></div>
				<?php $_smarty_tpl->tpl_vars['qzListOpt'] = new Smarty_Variable(array_slice($_smarty_tpl->tpl_vars['qzListOpt']->value,($_smarty_tpl->tpl_vars['indx1']->value)), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'qzListOpt', 0);?>
				<div style="display: none;"><?php $_smarty_tpl->tpl_vars['indx'] = new Smarty_Variable(0, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'indx', 0);?></div>
				<?php
$_from = $_smarty_tpl->tpl_vars['qzListOpt']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_obj1_2_saved_item = isset($_smarty_tpl->tpl_vars['obj1']) ? $_smarty_tpl->tpl_vars['obj1'] : false;
$_smarty_tpl->tpl_vars['obj1'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['obj1']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['obj1']->value) {
$_smarty_tpl->tpl_vars['obj1']->_loop = true;
$__foreach_obj1_2_saved_local_item = $_smarty_tpl->tpl_vars['obj1'];
?>
				<?php if ($_smarty_tpl->tpl_vars['obj1']->value->quiz_item_no != $_smarty_tpl->tpl_vars['obj']->value->quiz_item_no) {
break 1;?>
				<?php } else { ?>

				<tr class="rc_row<?php echo $_smarty_tpl->tpl_vars['obj']->key+1;?>
">
				<td></td>

				<?php if ($_smarty_tpl->tpl_vars['idx']->value == 1 || $_smarty_tpl->tpl_vars['idx']->value == 2) {?>

					<?php if ($_smarty_tpl->tpl_vars['obj1']->value->correct_flag == "1") {?>
					<td><label class="label_rd"><input type="radio" name="rchoice<?php echo $_smarty_tpl->tpl_vars['obj']->key+1;?>
" value="c<?php echo $_smarty_tpl->tpl_vars['idx']->value;?>
" checked="checked"> c<?php echo $_smarty_tpl->tpl_vars['idx']->value;?>
<span class="required">※ </span> </label></td>
					<?php } else { ?>
					<td><label class="label_rd"><input type="radio" name="rchoice<?php echo $_smarty_tpl->tpl_vars['obj']->key+1;?>
" value="c<?php echo $_smarty_tpl->tpl_vars['idx']->value;?>
" > c<?php echo $_smarty_tpl->tpl_vars['idx']->value;?>
<span class="required">※ </span> </label></td>
					<?php }?>

				<?php } else { ?>
					<?php if ($_smarty_tpl->tpl_vars['obj1']->value->correct_flag == "1") {?>
					<td><label class="label_rd"><input type="radio" name="rchoice<?php echo $_smarty_tpl->tpl_vars['obj']->key+1;?>
" value="c<?php echo $_smarty_tpl->tpl_vars['idx']->value;?>
" checked="checked"> c<?php echo $_smarty_tpl->tpl_vars['idx']->value;?>
 </label></td>
					<?php } else { ?>
					<td><label class="label_rd"><input type="radio" name="rchoice<?php echo $_smarty_tpl->tpl_vars['obj']->key+1;?>
" value="c<?php echo $_smarty_tpl->tpl_vars['idx']->value;?>
"> c<?php echo $_smarty_tpl->tpl_vars['idx']->value;?>
 </label></td>
					<?php }?>
				<?php }?>
				<td><input type="text" class="text_box_rd" id="choice<?php echo $_smarty_tpl->tpl_vars['obj']->key+1;?>
_<?php echo $_smarty_tpl->tpl_vars['idx']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['obj1']->value->description;?>
" name="choice<?php echo $_smarty_tpl->tpl_vars['idx']->value;?>
" size="30" maxlength = "2048"></td>

				</tr>


				<div style="display: none;"><?php echo $_smarty_tpl->tpl_vars['idx']->value++;
echo $_smarty_tpl->tpl_vars['indx']->value++;
$_smarty_tpl->tpl_vars['indx1'] = new Smarty_Variable($_smarty_tpl->tpl_vars['indx']->value, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'indx1', 0);?></div>
				<?php }
$_smarty_tpl->tpl_vars['obj1'] = $__foreach_obj1_2_saved_local_item;
}
if ($__foreach_obj1_2_saved_item) {
$_smarty_tpl->tpl_vars['obj1'] = $__foreach_obj1_2_saved_item;
}
?>
				<?php }?>

				<?php } else { ?>

				<?php if (!empty($_smarty_tpl->tpl_vars['qzListOpt']->value)) {?>
				<?php $_smarty_tpl->tpl_vars['idx'] = new Smarty_Variable(1, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'idx', 0);?>
				<?php $_smarty_tpl->tpl_vars['qzListOpt'] = new Smarty_Variable(array_slice($_smarty_tpl->tpl_vars['qzListOpt']->value,$_smarty_tpl->tpl_vars['indx1']->value), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'qzListOpt', 0);?>
				<!-- <?php echo "array length";
echo count($_smarty_tpl->tpl_vars['qzListOpt']->value);?>
 -->
				<div style="display: none;"><?php $_smarty_tpl->tpl_vars['indx'] = new Smarty_Variable(0, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'indx', 0);?></div>
				<?php
$_from = $_smarty_tpl->tpl_vars['qzListOpt']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_obj1_3_saved_item = isset($_smarty_tpl->tpl_vars['obj1']) ? $_smarty_tpl->tpl_vars['obj1'] : false;
$_smarty_tpl->tpl_vars['obj1'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['obj1']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['obj1']->value) {
$_smarty_tpl->tpl_vars['obj1']->_loop = true;
$__foreach_obj1_3_saved_local_item = $_smarty_tpl->tpl_vars['obj1'];
?>
				<?php if ($_smarty_tpl->tpl_vars['obj1']->value->quiz_item_no != $_smarty_tpl->tpl_vars['obj']->value->quiz_item_no) {
break 1;?>
				<?php } else { ?>

				<tr class="rb_row<?php echo $_smarty_tpl->tpl_vars['obj']->key+1;?>
">
				<td></td>
				<?php if ($_smarty_tpl->tpl_vars['idx']->value == 1) {?>
				<td width="75px;"><label class="label_blank">A<?php echo $_smarty_tpl->tpl_vars['idx']->value;?>
<span class="required">※ </span></label></td>
                <td><input type="text" class="text_box_blank" id="blank<?php echo $_smarty_tpl->tpl_vars['obj']->key+1;?>
_<?php echo $_smarty_tpl->tpl_vars['idx']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['obj1']->value->description;?>
" name="blank<?php echo $_smarty_tpl->tpl_vars['idx']->value;?>
" size="30" maxlength = "2048"></td>
				<?php } else { ?>
				<td width="75px;"><label class="label_blank">A<?php echo $_smarty_tpl->tpl_vars['idx']->value;?>
</label></td>
                <td><input type="text" class="text_box_blank" id="blank<?php echo $_smarty_tpl->tpl_vars['obj']->key+1;?>
_<?php echo $_smarty_tpl->tpl_vars['idx']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['obj1']->value->description;?>
" name="blank<?php echo $_smarty_tpl->tpl_vars['idx']->value;?>
" size="30" maxlength = "2048"></td>
				<?php }?>
				</tr>
				<div style="display: none;"><?php echo $_smarty_tpl->tpl_vars['idx']->value++;
echo $_smarty_tpl->tpl_vars['indx']->value++;
$_smarty_tpl->tpl_vars['indx1'] = new Smarty_Variable($_smarty_tpl->tpl_vars['indx']->value, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'indx1', 0);?></div>
				<?php }
$_smarty_tpl->tpl_vars['obj1'] = $__foreach_obj1_3_saved_local_item;
}
if ($__foreach_obj1_3_saved_item) {
$_smarty_tpl->tpl_vars['obj1'] = $__foreach_obj1_3_saved_item;
}
?>
				<?php }?>

				<?php }?>
				<tr>
					<td></td>
					<td width = "75px;"></td>
					<td colspan="2"></td>
					<td width="100px;"></td>
					<td width="200px;"></td>

					<td style="text-align:right"><input type="button" value="" title="追加" id="btn_add_<?php echo $_smarty_tpl->tpl_vars['obj']->key+1;?>
" onclick="add_single_row(this,this.parentNode.parentNode.rowIndex)" class="btn_row_add"></td>
					<td style="text-align:right"><input type="button" value="" title="削除" id="btn_remove_<?php echo $_smarty_tpl->tpl_vars['obj']->key+1;?>
" onclick="deleteRow(this)" class="btn_delete"></td>
				</tr>
		</tbody>
            <?php
$_smarty_tpl->tpl_vars['obj'] = $__foreach_obj_0_saved_local_item;
}
if ($__foreach_obj_0_saved_item) {
$_smarty_tpl->tpl_vars['obj'] = $__foreach_obj_0_saved_item;
}
?>
            <?php } else { ?>
		<tbody id="tbody1">
              <tr>
                <td>1.</td>
                <td width="75px;">タイプ<span class="required">※</span></td>
                 <td colspan="2">
                  <select id="qztype_no_1" name="qz_type" onchange="changeSelectValue(this,1)"  class="qz_type">
                    <?php if (!empty($_smarty_tpl->tpl_vars['qztypeNo']->value)) {?>
                        <?php
$_from = $_smarty_tpl->tpl_vars['qztypeNo']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_value_4_saved_item = isset($_smarty_tpl->tpl_vars['value']) ? $_smarty_tpl->tpl_vars['value'] : false;
$_smarty_tpl->tpl_vars['value'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['value']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
$__foreach_value_4_saved_local_item = $_smarty_tpl->tpl_vars['value'];
?>
                          <?php if ($_smarty_tpl->tpl_vars['value']->value->type == $_smarty_tpl->tpl_vars['form']->value->qz_type) {?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['value']->value->type;?>
" selected><?php echo $_smarty_tpl->tpl_vars['value']->value->name;?>
 </option>
                          <?php } else { ?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['value']->value->type;?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value->name;?>
 </option>
                          <?php }?>
                        <?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_4_saved_local_item;
}
if ($__foreach_value_4_saved_item) {
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_4_saved_item;
}
?>
                     <?php }?>
                  </select>
                </td>
                 <td width="200px;"></td>
                 <td width="75px;">Q<span class="required">※</span></td>
                 <td width="118px;"></td>
                 <td width="218px;"></td>
                </tr>

                <tr>
                <td></td>
                <td width="75px;">点数<span class="required">※</span></td>
                <td colspan="2">
                <input type="text" class="text_box" id="txt_mark_1" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->qz_mark;?>
" name="qz_mark" size="30" maxlength = "3">
                </td>
                <td width="100px;"></td>
                <td rowspan="4" colspan="3" ><textarea class="txtarea" id = "txtarea_1" name="qz_content" size="30" maxlength = "2048"><?php echo $_smarty_tpl->tpl_vars['form']->value->qz_content;?>
</textarea></td>
				</tr>
				<!-- <tr></tr><tr></tr><tr></tr> -->

				<tr class="rc_row1">
				<td></td>
				<td><label class="label_rd"><input type="radio" name="rchoice1" value="c1" checked="checked"> c1<span class="required">※</span></label></td>
				<td><input type="text" class="text_box_rd" id="choice1_1" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->choice1;?>
" name="choice1" size="30" maxlength = "2048"></td>
				</tr>
				<tr class="rc_row1">
				<td></td>
				<td><label class="label_rd"><input type="radio" name="rchoice1" value="c2"> c2<span class="required">※</span></label></td>
				<td><input type="text" class="text_box_rd" id="choice1_2" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->choice2;?>
" name="choice2" size="30" maxlength = "2048"></td>
				</tr>
				<tr class="rc_row1">
				<td></td>
				<td><label class="label_rd"><input type="radio" name="rchoice1" value="c3"> c3</label></td>
				<td><input type="text" class="text_box_rd" id="choice1_3" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->choice2;?>
" name="choice3" size="30" maxlength = "2048"></td>
				</tr>
				<tr class="rc_row1">
				<td></td>
				<td><label class="label_rd"><input type="radio" name="rchoice1" value="c4"> c4</label></td>
				<td><input type="text" class="text_box_rd" id="choice1_4" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->choice2;?>
" name="choice4" size="30" maxlength = "2048"></td>
				</tr>
				<tr class="rb_row1">
				    <td></td>
				 	<td width="75px;"><label class="label_blank">A1<span class="required">※</span></label></td>
                	<td>
                		<input type="text" class="text_box_blank" id="blank1_1" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->blank1;?>
" name="blank1" size="30" maxlength = "2048">
                	</td>
				</tr>
				<tr class="rb_row1">
					<td></td>
				 	<td width="75px;"><label class="label_blank">A2</label></td>
                	<td>
                		<input type="text" class="text_box_blank" id="blank1_2" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->blank2;?>
" name="blank2" size="30" maxlength = "2048">
                	</td>
				</tr>
				<tr></tr>
				<tr>
					<td></td>
					<td width = "75px;"></td>
					<td colspan="2"></td>
					<td width="100px;"></td>
					<td width="200px;"></td>

					<td style="text-align:right"><input type="button" value="" title="追加" id="btn_add_1" onclick="add_single_row(this,this.parentNode.parentNode.rowIndex)" class="btn_row_add"></td>
					<td style="text-align:right"><input type="button" value="" title="削除" id="btn_remove_1" onclick="deleteRow(this)" class="btn_delete"></td>

				</tr>

            </tbody>
            <?php }?>
		</table>
		<table style="width:95%;">
            <tr>
				<td colspan="6"><input type="button" class="btn_row_add" value="" title="追加" onclick="addRow()" style="float: left;">
				<?php if ($_smarty_tpl->tpl_vars['form']->value->disable_mode == '') {?>
					<input type="button" class="btn_insert" value="" title="登録" onclick="checkInsertData()" style="float: right;"></td>
				<?php }?>
            </tr>
          </table>


        </section>
    </div><!-- End divBody -->
    <!--footer-->
		<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<!--footer-->
  </form>
  <?php echo '<script'; ?>
>

   
  var qzList = [];
  <?php if ($_smarty_tpl->tpl_vars['qzList']->value != null) {
$_from = $_smarty_tpl->tpl_vars['qzList']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_value_5_saved_item = isset($_smarty_tpl->tpl_vars['value']) ? $_smarty_tpl->tpl_vars['value'] : false;
$_smarty_tpl->tpl_vars['value'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['value']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
$__foreach_value_5_saved_local_item = $_smarty_tpl->tpl_vars['value'];
?>
		qzList.push(JSON.stringify('<?php echo json_encode($_smarty_tpl->tpl_vars['value']->value,JSON_HEX_APOS);?>
'));
  <?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_5_saved_local_item;
}
if ($__foreach_value_5_saved_item) {
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_5_saved_item;
}
}?>

  
  var qzListOpt = [];
  <?php if ($_smarty_tpl->tpl_vars['qzListOpt']->value != null) {
$_from = $_smarty_tpl->tpl_vars['qzListOpt']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_value_6_saved_item = isset($_smarty_tpl->tpl_vars['value']) ? $_smarty_tpl->tpl_vars['value'] : false;
$_smarty_tpl->tpl_vars['value'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['value']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
$__foreach_value_6_saved_local_item = $_smarty_tpl->tpl_vars['value'];
?>
		qzListOpt.push(JSON.stringify('<?php echo json_encode($_smarty_tpl->tpl_vars['value']->value,JSON_HEX_APOS);?>
'));
  <?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_6_saved_local_item;
}
if ($__foreach_value_6_saved_item) {
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_6_saved_item;
}
}?>

  
      var arrTypeNameList = [];
      <?php if ($_smarty_tpl->tpl_vars['qztypeNo']->value != null) {
$_from = $_smarty_tpl->tpl_vars['qztypeNo']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_value_7_saved_item = isset($_smarty_tpl->tpl_vars['value']) ? $_smarty_tpl->tpl_vars['value'] : false;
$_smarty_tpl->tpl_vars['value'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['value']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
$__foreach_value_7_saved_local_item = $_smarty_tpl->tpl_vars['value'];
?>
      arrTypeNameList.push(JSON.parse('<?php echo json_encode($_smarty_tpl->tpl_vars['value']->value);?>
'));
      <?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_7_saved_local_item;
}
if ($__foreach_value_7_saved_item) {
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_7_saved_item;
}
}?>

  
      var arrTypeNameList1 = [];
      <?php if ($_smarty_tpl->tpl_vars['qztypeNo']->value != null) {
$_from = $_smarty_tpl->tpl_vars['qztypeNo']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_value_8_saved_item = isset($_smarty_tpl->tpl_vars['value']) ? $_smarty_tpl->tpl_vars['value'] : false;
$_smarty_tpl->tpl_vars['value'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['value']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
$__foreach_value_8_saved_local_item = $_smarty_tpl->tpl_vars['value'];
?>
      arrTypeNameList1.push(JSON.parse('<?php echo json_encode($_smarty_tpl->tpl_vars['value']->value);?>
'));
      <?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_8_saved_local_item;
}
if ($__foreach_value_8_saved_item) {
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_8_saved_item;
}
}?>

  
      var arrTypeNameList2 = [];
      <?php if ($_smarty_tpl->tpl_vars['qztypeNo']->value != null) {
$_from = $_smarty_tpl->tpl_vars['qztypeNo']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_value_9_saved_item = isset($_smarty_tpl->tpl_vars['value']) ? $_smarty_tpl->tpl_vars['value'] : false;
$_smarty_tpl->tpl_vars['value'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['value']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
$__foreach_value_9_saved_local_item = $_smarty_tpl->tpl_vars['value'];
?>
      arrTypeNameList2.push(JSON.parse('<?php echo json_encode($_smarty_tpl->tpl_vars['value']->value);?>
'));
      <?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_9_saved_local_item;
}
if ($__foreach_value_9_saved_item) {
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_9_saved_item;
}
}?>

  <?php echo '</script'; ?>
>


</body>
</html><?php }
}
