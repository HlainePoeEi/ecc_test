<?php
/* Smarty version 3.1.29, created on 2022-04-19 12:10:44
  from "/var/www/html/eccadmin_dev/templates/quizDetailsPreview.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_625e2834a3e3a9_55603749',
  'file_dependency' => 
  array (
    'e09f2e8b1d661c5cc090609dfc196bc8e9d2ee11' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/quizDetailsPreview.html',
      1 => 1649910268,
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
function content_625e2834a3e3a9_55603749 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
	<title>クイズアイテムプレビュー</title>

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
    
    <link href="<?php echo @constant('HOME_DIR');?>
css/default.css" rel="stylesheet">
 	<link href="<?php echo @constant('HOME_DIR');?>
css/testpreview.css" rel="stylesheet">
	
	<style type="text/css">
		.disabled {
			background-color: grey;
			pointer-events: none;
			opacity: 0.3;
			cursor: default;
			border: none;
			padding: 12px 16px;
			font-size: 24px;
			width:30px;
			height:30px;
			margin:10px 10px 10px 10px;
			border-radius:30px;
		  }
		.started {
			background-color: #32CD32;
			pointer-events: none;
			opacity: 0.3;
			cursor: default;
			border: none;
			padding: 12px 16px;
			font-size: 24px;
			width:30px;
			height:30px;
			margin:10px 10px 10px 10px;
			border-radius:30px;
		  }
		  
		.description{
			float:left;
			width: 600px;
			text-align: left;
			margin-top: 5px;
			margin-bottom: -20px;
			font-size: 16px; 
			margin-left: 20px;
		}
		
		.textFill{
			 border: 0;
			 width:80%;
			 height:30px;
			 border-bottom: 1px solid black;
			 margin-top:5px;
			 font-size: 14px;
		}
		.endBtn{
			  border: none;
			  color: white;
			  text-align: center;
			  text-decoration: none;
			  display: inline-block;
			  margin-top:10px;
			  border-radius:3px;
			  width:80px;
			  height:35px;
			  cursor: pointer;
			  background-color: #008CBA;
		}
		
		.btnRadio{
		 font-size: 16px;
		}
		
		.btnAudio{
			
			  border: none;
			  color: white;
			  padding: 12px 16px;
			  font-size: 24px;
			  cursor: pointer;
			  width:30px;
			  height:30px;
			  margin:10px 10px 10px 10px;
			  border-radius:30px;
	}
		.tableRadio{
			
			background-color: #dcf2f9;
			border: none;
			border-collapse: collapse !important;
			margin-top:2px;
		}
		
		.items{
			margin-left:30px;
			margin-top:15px;
		}
		.options{
			margin-left:40px;
		}
	</style>
	<?php echo '<script'; ?>
>

    $(document).ready(function() {

    	 var err_msg =  document.getElementById('err_msg').value;
    	 if ( err_msg != "" ){
             $('#err_dis').show();
             $(".error_section").slideToggle('slow');
             $(".error_msg").html(err_msg);
         }
        else {
            $('#err_dis').hide();
       }

        // MSGのあるなし
        $(".close_icon").on('click',function(){
        	 $(".error_section").slideToggle('slow');
        	 $('#err_dis').hide();
         });

		// テーブルのラジオクリックイベント追加
		$(".radio_td").click(function () {
			var id =  $(this).attr('id');
			var name =  $(this).attr('name');
			
			var rdoId = id.replace("td_", "");
			var rdoName = name.replace("td_", "");
			
			$("input[name= " + rdoName + "][id='" + rdoId + "']").prop("checked",true);
			
			// テーブルの色をリセット
			var elements = document.getElementsByName(name);
			for (var i = 0; i < elements.length; i++) {
				elements[i].style.backgroundColor = "#e2eff3";
			}

			// 選択中の色セット
			$(this).css('background-color', '#79b7e7');
		});

   });
    function doBack(screen_mode,quiz_info_no, action , uid ) {
 	    var menuOpen = document.getElementById('menuOpen').value;
        var menuStatus = document.getElementById('menuStatus').value;

        $("#quiz_info_no").val(quiz_info_no);
        $("#screen_mode").val(screen_mode);
        $("#main_form").attr("action", action);
        $("#uid").val(uid);
        $("#menuOpen").val(menuOpen);
        $("#menuStatus").val(menuStatus);

        $("#main_form").submit();
	}
		 

	<!--playAudio音楽を開ける	-->
	function playAudio(ID) { 
				
				var play_flg = document.getElementById('play_flg'+ID);
				var player = document.getElementById('resQuiz_audio_'+ID);
				var aTagBtn = document.getElementById('btnAudio'+ID);
				var label = document.getElementById('lblAudio'+ID);
				var flag=false; 
				var allAudio=document.getElementsByTagName('audio');
				var img;
				for(var i=0;i<allAudio.length;i++){	
					if(allAudio[i].currentTime>0 && !allAudio[i].ended){
						//もう一度再生できるように修正
						//flag=true;
					}	
				}
				if(flag==false){		
					
					if(play_flg.value == 'false' && !player.ended){
						player.play();
						aTagBtn.classList.add("started");
						document.getElementById('btnAudio'+ID).classList.remove("btnAudio");
						img = document.getElementById('play_img'+ID).style.visibility = 'hidden';
						showTime(player, ID);
					}else if(play_flg.value == 'false' && player.ended){
						//もう一度再生できるように修正
					//	aTagBtn.classList.add("disabled");
					//	play_flg.value = 'true';
					//	player.setAttribute('src','');
						document.getElementById('play_img'+ID).style.visibility = 'visible';
						document.getElementById('btnAudio'+ID).classList.remove("started");
						aTagBtn.classList.add("btnAudio");
						player.pause();
						player.currentTime = 0;
					}else if(player.currentTime > 0){
						player.pause();
					}else{
						player.pause();
					}		  
					
				}
			}
			
	function showTime(player,ID){
		var timeoutHandle;
		var duration = player.duration;
		console.log("duration :" + duration);

		var aTagBtn = document.getElementById('btnAudio'+ID);
		var label = document.getElementById('lblAudio'+ID);

		var dHours = Math.floor(duration / 3600);
		var dMinutes = Math.floor(duration % 3600 / 60);
		var dSeconds = Math.floor(duration % 3600 % 60);

		var lastDuration = (dHours < 10 ? "0" : "") + dHours.toString()
			+ ":" + (dMinutes < 10 ? "0" : "") + dMinutes.toString()
			+ ":" + (dSeconds < 10 ? "0" : "") + String(dSeconds);

		function countdown2(hours, minutes, seconds){
			function tick(){
			label.innerHTML = (hours < 10 ? "0" : "") + hours.toString()
					+ ":" + (minutes < 10 ? "0" : "") + minutes.toString()
					+ ":" + (seconds < 10 ? "0" : "") + String(seconds)
					+ " / " + lastDuration;
			seconds--;
			if (seconds >= 0) {
				timeoutHandle = setTimeout(tick, 1000);
			} else {
				if (minutes >= 1) {
					setTimeout(function() {
						countdown2(hours, minutes - 1, 59);
					}, 1000);
				} else {
					if (minutes >= 0) {
						if (hours > 0) {
							timeoutHandle = setTimeout(tick, 1000);
							setTimeout(function() {
								countdown2(hours - 1, 59, 59);
							}, 1000);
						}
					}
				}
			}
			if (hours <= 0 && minutes <= 0 && seconds < 0) {
				//もう一度再生できるように修正
			//	aTagBtn.classList.add("disabled");
			//	document.getElementById('btnAudio'+ID).classList.remove("started");
			//	img = document.getElementById('play_img'+ID).style.visibility = 'hidden';
				img = document.getElementById('play_img'+ID).style.visibility = 'visible';
				document.getElementById('btnAudio'+ID).classList.remove("started");
				aTagBtn.classList.add("btnAudio");
				player.pause();
				player.currentTime = 0;
			}
		}
		tick();
		}
		countdown2(dHours, dMinutes, dSeconds);
	}
     <?php echo '</script'; ?>
>

</head>

<body class="pushmenu-push">
  <form id="main_form" action="<?php echo @constant('HOME_DIR');?>
QuizInfoList/search" method="post">
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
            <div class="error_msg" id = "error_msg">
              <input type="hidden" id="err_msg" name="err_msg" value="<?php echo $_smarty_tpl->tpl_vars['error_msg']->value;?>
"/>
				     <?php echo $_smarty_tpl->tpl_vars['error_msg']->value;?>

            </div>
          </section>
        </div>
		<section class="content">
			<p>
            <span class="title">テスト情報 / クイズプレビュー</span>
            <span style="float:right;padding-right:10px;">
              <input type="button" value="" title="戻る" class="btn_back" onclick="doBack('update','<?php echo $_smarty_tpl->tpl_vars['form']->value->quiz_info_no;?>
','<?php echo @constant('HOME_DIR');?>
QuizDetailsPreview/back', '<?php echo $_smarty_tpl->tpl_vars['form']->value->uid;?>
')" />
            </span>
            </p>
              <!-- 戻る処理用データ -->
         <input type="hidden" id="gamen_name" name="gamen_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->gamen_name;?>
"/>
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
		<input type="hidden" id="audio_del_flg " value="<?php echo $_smarty_tpl->tpl_vars['form']->value->audio_del_flg;?>
" name="audio_del_flg ">
		<input type="hidden" id="audio_chk_del" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->audio_chk_del;?>
" name="audio_chk_del">
		 <!-- 検索利用データ -->
		<input type="hidden" id="search_quiz_name" name="search_quiz_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_quiz_name;?>
"/>
		<input type="hidden" id="search_long_description" name="search_long_description" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_long_description;?>
"/>
		<input type="hidden" id="search_remark" name="search_remark" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_remark;?>
"/>
		<input type="hidden" id="search_rd_status1" name="search_rd_status1" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_rd_status1;?>
"/>
		<input type="hidden" id="search_org_id" name="search_org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_org_id;?>
"/>
		<input type="hidden" id="screen_mode" name="screen_mode" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->screen_mode;?>
"/>
		
		<input type="hidden" id="search_page_qil" name="search_page_qil" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_qil;?>
" />
		<input type="hidden" id="search_page_row_qil" name="search_page_row_qil" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_row_qil;?>
" />
		<input type="hidden" id="search_page_order_column_qil" name="search_page_order_column_qil" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_column_qil;?>
" />
		<input type="hidden" id="search_page_order_dir_qil" name="search_page_order_dir_qil" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_dir_qil;?>
" />

         <div class = "qz_no">
             <input type="hidden" id="quiz_info_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->quiz_info_no;?>
" name="quiz_info_no">
             <label class="qz_name"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->quiz_name, ENT_QUOTES, 'UTF-8', true);?>
</label>
         </div>
         <div style="word-break : break-all;">
            <label style="white-space: pre-wrap;"><b>Q1.</b> <?php echo $_smarty_tpl->tpl_vars['form']->value->long_description;?>
</label>
         </div>
		<input type="hidden" id="audio_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->audio_name;?>
" name="audio_name">
		<div style="margin-left:60px;">
		<?php if (!empty($_smarty_tpl->tpl_vars['form']->value->audio_name)) {?>
			<?php $_smarty_tpl->tpl_vars["audiomsg"] = new Smarty_Variable(((string)$_smarty_tpl->tpl_vars['folder_check']->value).((string)$_smarty_tpl->tpl_vars['audio_file']->value)."/".((string)$_smarty_tpl->tpl_vars['form']->value->audio_name), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "audiomsg", 0);?>
			<?php ob_start();
echo $_smarty_tpl->tpl_vars['audiomsg']->value;
$_tmp1=ob_get_clean();
if (file_exists($_tmp1)) {?>
			<span>
			<audio id="resQuiz_audio_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="quiz_audio" style="display:none">
			<source src="<?php echo @constant('ADMIN_HOME_DIR');?>
/<?php echo $_smarty_tpl->tpl_vars['audio_file']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['form']->value->audio_name;?>
" type="audio/mpeg" >
			</audio>
			<input type="hidden" id="play_flg<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" value="false"/>
			</span>											
			<span class="btnAudio" id="btnAudio<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
">
				<a id="aBtn<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" onclick="javascript:playAudio('<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
')" >
				<img src="<?php echo @constant('HOME_DIR');?>
image/play.svg" style="width:45px;" id="play_img<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
"></a></a>
				<label id="lblAudio<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
"></label>
			</span>	
			<?php }?>
		<?php }?>
		</div>
		<input type="hidden" id="total_item_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" value="<?php echo count($_smarty_tpl->tpl_vars['items']->value[$_smarty_tpl->tpl_vars['i']->value]);?>
" />
			<?php if (!empty($_smarty_tpl->tpl_vars['items']->value[$_smarty_tpl->tpl_vars['i']->value])) {?>										
				<?php
$_from = $_smarty_tpl->tpl_vars['items']->value[$_smarty_tpl->tpl_vars['i']->value];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_item_0_saved_item = isset($_smarty_tpl->tpl_vars['item']) ? $_smarty_tpl->tpl_vars['item'] : false;
$__foreach_item_0_saved_key = isset($_smarty_tpl->tpl_vars['j']) ? $_smarty_tpl->tpl_vars['j'] : false;
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['j'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['item']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['j']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$__foreach_item_0_saved_local_item = $_smarty_tpl->tpl_vars['item'];
?>											
															 
					<div class="items">	
					<?php if (!empty($_smarty_tpl->tpl_vars['items']->value[$_smarty_tpl->tpl_vars['i']->value][$_smarty_tpl->tpl_vars['j']->value]->item_description) || $_smarty_tpl->tpl_vars['items']->value[$_smarty_tpl->tpl_vars['i']->value][$_smarty_tpl->tpl_vars['j']->value]->item_description != '') {?>	
						<p><?php echo $_smarty_tpl->tpl_vars['items']->value[$_smarty_tpl->tpl_vars['i']->value][$_smarty_tpl->tpl_vars['j']->value]->item_description;?>
</p>
					<?php }?>	
							<div style="margin_left:20px;">
							 <input type="hidden" id="item_id_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['items']->value[$_smarty_tpl->tpl_vars['i']->value][$_smarty_tpl->tpl_vars['j']->value]->quiz_item_no;?>
">	
							 <input type="hidden" id="type_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
" name="type" value="<?php echo $_smarty_tpl->tpl_vars['items']->value[$_smarty_tpl->tpl_vars['i']->value][$_smarty_tpl->tpl_vars['j']->value]->quiz_type;?>
"/>																							
								<?php if (!empty($_smarty_tpl->tpl_vars['optionList']->value)) {?>				
								<input type="hidden" id="total_option_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
" value="<?php echo count($_smarty_tpl->tpl_vars['options']->value[$_smarty_tpl->tpl_vars['i']->value][$_smarty_tpl->tpl_vars['j']->value]);?>
" />																							
									<?php
$_from = $_smarty_tpl->tpl_vars['options']->value[$_smarty_tpl->tpl_vars['i']->value][$_smarty_tpl->tpl_vars['j']->value];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_option_1_saved_item = isset($_smarty_tpl->tpl_vars['option']) ? $_smarty_tpl->tpl_vars['option'] : false;
$__foreach_option_1_saved_key = isset($_smarty_tpl->tpl_vars['k']) ? $_smarty_tpl->tpl_vars['k'] : false;
$_smarty_tpl->tpl_vars['option'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['k'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['option']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['option']->value) {
$_smarty_tpl->tpl_vars['option']->_loop = true;
$__foreach_option_1_saved_local_item = $_smarty_tpl->tpl_vars['option'];
?>																
										<?php if (!empty($_smarty_tpl->tpl_vars['options']->value[$_smarty_tpl->tpl_vars['i']->value][$_smarty_tpl->tpl_vars['j']->value][$_smarty_tpl->tpl_vars['k']->value])) {?>																	
											
											<input type="hidden" id="option_id_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['options']->value[$_smarty_tpl->tpl_vars['i']->value][$_smarty_tpl->tpl_vars['j']->value][$_smarty_tpl->tpl_vars['k']->value]->option_no;?>
" />
																					
											<?php if ($_smarty_tpl->tpl_vars['items']->value[$_smarty_tpl->tpl_vars['i']->value][$_smarty_tpl->tpl_vars['j']->value]->quiz_type == 001) {?>																
											<table id="tbl_<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" style="width: 95%;" class="tableRadio">
											<tr class="radio_tr" id="tr_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" name="tr_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
">
												<td width="95%" class="radio_td" id="td_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" name="td_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
">
													
														<input class="btnRadio" type="radio" name="rdo_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
" id="rdo_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['options']->value[$_smarty_tpl->tpl_vars['i']->value][$_smarty_tpl->tpl_vars['j']->value][$_smarty_tpl->tpl_vars['k']->value]->correct_flag;?>
">
														<label for="rdo_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['options']->value[$_smarty_tpl->tpl_vars['i']->value][$_smarty_tpl->tpl_vars['j']->value][$_smarty_tpl->tpl_vars['k']->value]->option_description;?>
</label>
													
												</td>
											</tr>
											</table>														
											<?php } else { ?>
											<input type="text" id="txt_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" name="ans_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" class="textFill"  maxlength ="100"><br>															
											<input type="hidden" id="ans_txt_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" name="txt_ans" value="<?php echo $_smarty_tpl->tpl_vars['options']->value[$_smarty_tpl->tpl_vars['i']->value][$_smarty_tpl->tpl_vars['j']->value][$_smarty_tpl->tpl_vars['k']->value]->option_description;?>
">
											<?php }?>
									<?php }?>
								<?php
$_smarty_tpl->tpl_vars['option'] = $__foreach_option_1_saved_local_item;
}
if ($__foreach_option_1_saved_item) {
$_smarty_tpl->tpl_vars['option'] = $__foreach_option_1_saved_item;
}
if ($__foreach_option_1_saved_key) {
$_smarty_tpl->tpl_vars['k'] = $__foreach_option_1_saved_key;
}
?>
							<?php }?>
							
						</div>
					</div>
						 
				<?php
$_smarty_tpl->tpl_vars['item'] = $__foreach_item_0_saved_local_item;
}
if ($__foreach_item_0_saved_item) {
$_smarty_tpl->tpl_vars['item'] = $__foreach_item_0_saved_item;
}
if ($__foreach_item_0_saved_key) {
$_smarty_tpl->tpl_vars['j'] = $__foreach_item_0_saved_key;
}
?>
			<?php }?>
			<br/>
 		</section><!-- End Content -->
    </div><!-- End divBody -->
<!--footer-->
		<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<!--footer-->
  </form>

</body>
</html><?php }
}
