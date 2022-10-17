<?php
/* Smarty version 3.1.29, created on 2022-09-11 09:50:35
  from "/var/www/html/eccadmin_dev/templates/testInfoPreview.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_631d30dbd2f104_60272695',
  'file_dependency' => 
  array (
    '4b2e4505512a3a2aab98a1e1ddb88a7db1635aef' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/testInfoPreview.html',
      1 => 1662093607,
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
function content_631d30dbd2f104_60272695 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
<title>試験確認</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta name="robots" content="noindex, nofollow">
<meta name="googlebot" content="noindex, nofollow">

<?php echo '<script'; ?>
 type="text/javascript"
	src="<?php echo @constant('HOME_DIR');?>
js/jquery.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript"
	src="<?php echo @constant('HOME_DIR');?>
js/jquery-ui.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript"
	src="<?php echo @constant('HOME_DIR');?>
js/common.js"><?php echo '</script'; ?>
>

<link href="<?php echo @constant('HOME_DIR');?>
css/jquery-ui.css" rel="stylesheet">
<link href="<?php echo @constant('HOME_DIR');?>
css/default.css" rel="stylesheet">
<link href="<?php echo @constant('HOME_DIR');?>
css/testpreview.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
 type="text/javascript">

	//表示再現
	$(document).ready(function() {
		// テーブルの色を変える
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

		//MSGのあるなし
		if ( $(".error_msg").html() != "" ) {
			$(".error_section").slideToggle('slow');
		}
		
		$(".close_icon").on('click',function(){
		
			$(".error_section").slideToggle('slow')
		
		});
	});
	
	//戻るボタン処理
	function doBack(action) {

		$("#main_form").attr("action", action);
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

<!--stopAudio音楽をやめる	-->	
			function stopAudio() {	
				var elems = document.getElementsByTagName('audio');			
				var a_elems = document.getElementsByTagName('a');
				for (var i = 0; i < elems.length; i++) {
						elems[i].setAttribute('src','');
						elems[i].pause();
				}		

				for(var a=0; a<a_elems.length; a++){
					a_elems[a].classList.add("disabled");
				}
			} 
<?php echo '</script'; ?>
>
</head>
<body class="pushmenu-push">
	<form id="main_form"
		action="<?php echo @constant('HOME_DIR');?>
TestInfoList/index" method="post">
		<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:leftMenu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

		<div class="divHeader">
			<!-- header -->
			<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<!-- header -->
		</div>
		<div class="divBody">
			<div class="main">
				<section class="error_section">
					<img src="<?php echo @constant('HOME_DIR');?>
image/close_icon.png"
						style="width: 15px; float: right" class="close_icon"> <?php if (!empty($_smarty_tpl->tpl_vars['msg']->value)) {?>
					<div class="error_msg"><?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
</div>
					<?php } else { ?>
					<div class="error_msg"></div>
					<?php }?>
				</section>
				<div id="filter"></div>
				<section class="content" id="secContent">
					<p>
						><span class="title">試験 / 試験プレビュー</span>
					</p>
					<p style="text-align: right; width: 100%;">
						<input type="button" title="戻る" value="" id="btn_back" class="btn_back"
							onclick="javascript:doBack('<?php echo @constant('HOME_DIR');?>
TestInfoPreview/back')">
					</p>
					<input type="hidden" id="home_dir" value="<?php echo @constant('HOME_DIR');?>
" />
					<input type="hidden" id="back_gamen" name="back_gamen" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->back_gamen;?>
" />
					<input type="hidden" id="at_report_no" name="at_report_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->at_report_no;?>
" />
					<input type="hidden" id="search_page" name="search_page"
						value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
" /> <input type="hidden"
						id="search_start_period" name="search_start_period"
						value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_start_period;?>
" /> <input type="hidden"
						id="search_end_period" name="search_end_period"
						value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_end_period;?>
" /> <input type="hidden"
						id="search_test_info_name" name="search_test_info_name"
						value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->search_test_info_name, ENT_QUOTES, 'UTF-8', true);?>
" /> <input
						type="hidden" id="search_remark" name="search_remark"
						value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->search_remark, ENT_QUOTES, 'UTF-8', true);?>
" /> <input type="hidden"
						id="search_rd_status1" name="search_rd_status1"
						value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_rd_status1;?>
" /> <input type="hidden"
						id="search_rd_status2" name="search_rd_status2"
						value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_rd_status2;?>
" /> <input type="hidden"
						id="search_rdstatus" name="search_rdstatus"
						value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_rdstatus;?>
" /> <input type="hidden"
						id="search_chk_status1" name="search_chk_status1"
						value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_chk_status1;?>
" /> <input type="hidden"
						id="search_chk_status2" name="search_chk_status2"
						value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_chk_status2;?>
" /> <input type="hidden"
						id="search_status" name="search_status"
						value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_status;?>
" /> <input type="hidden"
						id="date_flg" name="date_flg" value="<?php echo $_smarty_tpl->tpl_vars['date_flg']->value;?>
" />

						<input type="hidden" id="search_page_row_til" name="search_page_row_til" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_row_til;?>
" />
						<input type="hidden" id="search_page_order_column_til" name="search_page_order_column_til" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_column_til;?>
" />
						<input type="hidden" id="search_page_order_dir_til" name="search_page_order_dir_til" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_dir_til;?>
" />
						<input type="hidden" id="search_page_til" name="search_page_til" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_til;?>
" />
						
						<div align="left">
							<span class="title" style="font-size:20px;margin-left:10px;"><?php echo $_smarty_tpl->tpl_vars['test_name']->value;?>
</span>
							<div align="right" class="fixed_label">Remaining time:<label id=timer></label></div>
		
						</div>
						<p style="font-size:16px;margin-left:20px;margin-bottom:10px;"><?php echo $_smarty_tpl->tpl_vars['description']->value;?>
</p>
				
						<div id="divQuiz" align="left">
							<?php if (!empty($_smarty_tpl->tpl_vars['quiz_list']->value)) {?>	
							
								<input type="hidden" id="total_quiz" value="<?php echo count($_smarty_tpl->tpl_vars['quiz_list']->value);?>
" />							
								<?php
$_from = $_smarty_tpl->tpl_vars['quiz_list']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_q_0_saved_item = isset($_smarty_tpl->tpl_vars['q']) ? $_smarty_tpl->tpl_vars['q'] : false;
$__foreach_q_0_saved_key = isset($_smarty_tpl->tpl_vars['i']) ? $_smarty_tpl->tpl_vars['i'] : false;
$_smarty_tpl->tpl_vars['q'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['i'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['q']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['i']->value => $_smarty_tpl->tpl_vars['q']->value) {
$_smarty_tpl->tpl_vars['q']->_loop = true;
$__foreach_q_0_saved_local_item = $_smarty_tpl->tpl_vars['q'];
?>
								<input type="hidden" id="quiz_id_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['q']->value->quiz_info_no;?>
">
									<b><p  style="font-size:16px;margin-top:10px;"><?php echo $_smarty_tpl->tpl_vars['q']->value->quiz_name;?>
</p></b>
									<p style="margin-top:20px;"><?php echo $_smarty_tpl->tpl_vars['quiz_description']->value[$_smarty_tpl->tpl_vars['i']->value];?>
</p>
									
									<div style="margin-left:60px;">
									  <?php if (!empty($_smarty_tpl->tpl_vars['q']->value->audio_name)) {?>
										<?php $_smarty_tpl->tpl_vars["audiomsg"] = new Smarty_Variable(((string)$_smarty_tpl->tpl_vars['folder_check']->value).((string)$_smarty_tpl->tpl_vars['audio_file']->value)."/".((string)$_smarty_tpl->tpl_vars['q']->value->audio_name), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "audiomsg", 0);?>
										<?php ob_start();
echo $_smarty_tpl->tpl_vars['audiomsg']->value;
$_tmp1=ob_get_clean();
if (file_exists($_tmp1)) {?>
										<span>
										<audio id="resQuiz_audio_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="quiz_audio" controls>
										<source src="<?php echo @constant('HOME_DIR');?>
/<?php echo $_smarty_tpl->tpl_vars['audio_file']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['q']->value->audio_name;?>
" type="audio/mpeg" >
										</audio>
										<input type="hidden" id="play_flg<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" value="false"/>
										</span>											
									<!--	<span class="btnAudio" id="btnAudio<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
">
											<a id="aBtn<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" onclick="javascript:playAudio('<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
')" >
											<img src="<?php echo @constant('HOME_DIR');?>
image/play.svg" style="width:45px;" id="play_img<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
"></a></a>
											<label id="lblAudio<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
"></label>
										</span>	-->
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
$__foreach_item_1_saved_item = isset($_smarty_tpl->tpl_vars['item']) ? $_smarty_tpl->tpl_vars['item'] : false;
$__foreach_item_1_saved_key = isset($_smarty_tpl->tpl_vars['j']) ? $_smarty_tpl->tpl_vars['j'] : false;
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['j'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['item']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['j']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$__foreach_item_1_saved_local_item = $_smarty_tpl->tpl_vars['item'];
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
$__foreach_option_2_saved_item = isset($_smarty_tpl->tpl_vars['option']) ? $_smarty_tpl->tpl_vars['option'] : false;
$__foreach_option_2_saved_key = isset($_smarty_tpl->tpl_vars['k']) ? $_smarty_tpl->tpl_vars['k'] : false;
$_smarty_tpl->tpl_vars['option'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['k'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['option']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['option']->value) {
$_smarty_tpl->tpl_vars['option']->_loop = true;
$__foreach_option_2_saved_local_item = $_smarty_tpl->tpl_vars['option'];
?>																
																<?php if (!empty($_smarty_tpl->tpl_vars['options']->value[$_smarty_tpl->tpl_vars['i']->value][$_smarty_tpl->tpl_vars['j']->value][$_smarty_tpl->tpl_vars['k']->value])) {?>																	
																	
																	<input type="hidden" id="option_id_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['options']->value[$_smarty_tpl->tpl_vars['i']->value][$_smarty_tpl->tpl_vars['j']->value][$_smarty_tpl->tpl_vars['k']->value]->option_no;?>
" />
																											
																	<?php if ($_smarty_tpl->tpl_vars['items']->value[$_smarty_tpl->tpl_vars['i']->value][$_smarty_tpl->tpl_vars['j']->value]->quiz_type == 001) {?>		

																	<?php if ($_smarty_tpl->tpl_vars['options']->value[$_smarty_tpl->tpl_vars['i']->value][$_smarty_tpl->tpl_vars['j']->value][$_smarty_tpl->tpl_vars['k']->value]->correct_flag == 1) {?>																
																		<table id="tbl_<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" style="width: 95%;background-color:#79b7e7" class="tableRadio">
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
"  checked>
																				<label for="rdo_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['options']->value[$_smarty_tpl->tpl_vars['i']->value][$_smarty_tpl->tpl_vars['j']->value][$_smarty_tpl->tpl_vars['k']->value]->option_description;?>
</label>
																			</td>
																		</tr>
																		</table>
																	<?php } else { ?>
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
																			
																			<?php }?>
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
$_smarty_tpl->tpl_vars['option'] = $__foreach_option_2_saved_local_item;
}
if ($__foreach_option_2_saved_item) {
$_smarty_tpl->tpl_vars['option'] = $__foreach_option_2_saved_item;
}
if ($__foreach_option_2_saved_key) {
$_smarty_tpl->tpl_vars['k'] = $__foreach_option_2_saved_key;
}
?>
													<?php }?>
													
												</div>
											</div>
												 
										<?php
$_smarty_tpl->tpl_vars['item'] = $__foreach_item_1_saved_local_item;
}
if ($__foreach_item_1_saved_item) {
$_smarty_tpl->tpl_vars['item'] = $__foreach_item_1_saved_item;
}
if ($__foreach_item_1_saved_key) {
$_smarty_tpl->tpl_vars['j'] = $__foreach_item_1_saved_key;
}
?>
									<?php }?>
									<br/>
								<?php
$_smarty_tpl->tpl_vars['q'] = $__foreach_q_0_saved_local_item;
}
if ($__foreach_q_0_saved_item) {
$_smarty_tpl->tpl_vars['q'] = $__foreach_q_0_saved_item;
}
if ($__foreach_q_0_saved_key) {
$_smarty_tpl->tpl_vars['i'] = $__foreach_q_0_saved_key;
}
?>
							<?php }?>
						</div>
					<?php if (!empty($_smarty_tpl->tpl_vars['quiz_list']->value)) {?>
					<div align="right" style="margin-top:20px;">
						<input id="btn_save" type="button" class="endBtn" title="終了" value="終了" 
							onclick="javascript:doBack('<?php echo @constant('HOME_DIR');?>
TestInfoPreview/back')">
					</div>
					<?php }?>
				</section>
			</div>
		</div>
		<!--footer-->
		<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

		<!--footer-->
	</form>
</body>
<?php echo '<script'; ?>
 type="text/javascript">
	var timeoutHandle;
	var d=<?php echo $_smarty_tpl->tpl_vars['time']->value;?>
;
	console.log("d:" + d);
	var h = Math.floor(d / 3600);
	var m = Math.floor(d % 3600 / 60);
	var s = Math.floor(d % 3600 % 60);
	var stop_flg = false;
	var myfunc;

	// Remaining時間表示設定・カウントダウンタイマー
	function startCountDown(){
	
		var timer_text = document.getElementById("timer");
		var timeleft = <?php echo $_smarty_tpl->tpl_vars['time']->value;?>
;
		console.log("total time:" + timeleft);
		
		// Run myfunc every second
		var myfunc = setInterval(function() {

			timeleft--;
		//	console.log("timeleft:" + timeleft);
			
			// Calculating the days, hours, minutes and seconds left
		
			var hours = Math.floor(timeleft / 3600);
			var minutes = Math.floor(timeleft % 3600 / 60);
			var seconds = Math.floor(timeleft % 3600 % 60);
			
			timer_text.innerHTML = (hours < 10 ? "0" : "") + hours.toString()+ ":" + (minutes < 10 ? "0" : "") + minutes.toString()+ ":" + (seconds < 10 ? "0" : "") + seconds.toString();
				
			// Display the message when countdown is over
			if (timeleft < 0) {
				clearInterval(myfunc);
				timer_text.innerHTML = "00:00:00";
				stopAnswer();
			}
		}, 1000);
	}

	/* 試験を停止する	 */
	function stopAnswer(){
		document.getElementById("timer").innerHTML ="00:00:00";
		var elems = document.getElementsByTagName('input');				
		for (var i = 0; i < elems.length; i++) {
			if(elems[i].id == 'btn_back' || elems[i].id=="btn_save")
				elems[i].disabled = false;
			else{
				elems[i].disabled = true;
			}
		}			
		stopAudio();
	}
			  
	$(window).load(function () { //全ての読み込みが完了したら実行
	   $('#filter').hide();
	   $('#secContent').show();
	   startCountDown();
	   console.log("filter hide");
	});
<?php echo '</script'; ?>
>
</html>
<?php }
}
