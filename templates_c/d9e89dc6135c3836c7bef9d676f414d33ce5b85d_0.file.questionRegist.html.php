<?php
/* Smarty version 3.1.29, created on 2022-06-06 10:23:10
  from "/var/www/html/eccadmin_dev/templates/questionRegist.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_629d56fe225a41_16154449',
  'file_dependency' => 
  array (
    'd9e89dc6135c3836c7bef9d676f414d33ce5b85d' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/questionRegist.html',
      1 => 1646812561,
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
function content_629d56fe225a41_16154449 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
	<title> コース / 問題登録 </title>
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
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('HOME_DIR');?>
js/nicEdit-latest.js"><?php echo '</script'; ?>
>
	
	<link href="<?php echo @constant('HOME_DIR');?>
css/jquery-ui.css" rel="stylesheet">
	<link href="<?php echo @constant('HOME_DIR');?>
css/default.css" rel="stylesheet">
	<link href="<?php echo @constant('HOME_DIR');?>
css/style.css" rel="stylesheet">

	<?php echo '<script'; ?>
 type="text/javascript">
		
		bkLib.onDomLoaded(function() {
			new nicEditor({buttonList : ['fontSize','forecolor','bold','italic','underline','strikeThrough','subscript','superscript','html','upload', 'xhtml'],
			 uploadURI :'<?php echo @constant('HOME_DIR');?>
files/image_upload.php'
			 }).panelInstance('description');
			 
			new nicEditor({buttonList : ['upload'],
			 uploadURI :'<?php echo @constant('HOME_DIR');?>
files/v_image_upload.php'}).panelInstance('imgVertical');

		});
		
	<?php echo '</script'; ?>
>
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

			// MSGのあるなし
			if ( $(".error_msg").html() != "" ){

				$(".error_section").slideToggle('slow')
			}

			$(".close_icon").on('click', function(){

				$(".error_section").slideToggle('slow')

			});

			// Speaking / Writing の表示再現
			var test_type = $("#select_tk").val();
			var sqa_pattern = $("#scategory").val();
			var wqa_pattern = $("#wcategory").val();

			// 既定は　Speaking　のとき
			var test_kbn = document.getElementById("test_kbn").value;
			if ( test_kbn == '' || test_kbn == null ){
				document.getElementById("test_kbn").value = "001";
			}

			// テスとタイプは writing なら、
			if ( test_type == "002" ){

				$("#tr_audio_yes").hide();
				$("#tr_audio_no").hide();
				$("#tr_sampleAudio").hide();
				$("#tr_audio_name").hide();
				$("#tr_img_vertical").hide();
				$("#tr_audio_ydec").hide();
				$("#tr_audio_ndec").hide();
				$("#tr_audio_dec").hide();
				$("#tr_prepareTime").hide();

				$("#sample_radio").hide();
				$("#sample_audio").hide();
				$("#sample_text").show();
				$("#prepare_time").val('');

				// writing より問題パターンを表示する
				var divsToShow = document.getElementsByClassName("class_" + wqa_pattern);
				for ( var i = 0; i < divsToShow.length; i++ ){
					divsToShow[i].style.display = "";
				}

				var divsToHide = document.getElementsByClassName("class_" + sqa_pattern);
				for ( var i = 0; i < divsToHide.length; i++ ){
					divsToHide[i].style.display = "none";
				}

				// writing より問題パターンを表示する
				// writing の問題パターンを '001' だけする
				var optionValues = [];
				$('#score_pattern option').each(function() {
					optionValues.push($(this).val());
				});

				targetSubCategory = document.getElementById('score_pattern');
				subCategoryOptionsCount = document.getElementById('score_pattern').length;
				tempVar = 0;

				for (var i = 0; i < subCategoryOptionsCount; i++) {
					if(targetSubCategory.options[i].value != "001" ){
						$('#score_pattern option[value="'+optionValues[i]+'"]').prop("disabled", true);
					}
				}
				// テスとタイプをSpeaking から Writing を変わると 問題パターンを自動的にチェンジする
				var textToFind = 'Writing';
				var dd = document.getElementById('qa_pattern');
				for ( var i = 0; i < dd.options.length; i++ ){
					if ( dd.options[i].text === textToFind ){
						dd.selectedIndex = i;
						break;
					}
				}
			}else {
				// テスとタイプは speaking なら、
				$("#tr_sampleAudio").show();
				$("#tr_audio_name").show();
				$("#tr_img_vertical").show();
				$("#tr_audio_dec").show();
				$("#tr_prepareTime").show();
				$("#sample_radio").show();
				$("#sample_audio").show();

				// speaking より問題パターンを表示する
				var divsToHide = document.getElementsByClassName("class_" + wqa_pattern);
				for ( var i = 0; i < divsToHide.length; i++ ){
					divsToHide[i].style.display = "none";
				}

				var divsToShow = document.getElementsByClassName("class_" + sqa_pattern);
				for ( var i = 0; i < divsToShow.length; i++ ){
					divsToShow[i].style.display = "";
				}
			}
			// 編集モードには テスト区分をチェンジできないようにする
			var temp_sm = $("#screen_mode").val();
			if ( temp_sm == 'update' ){
				document.getElementById("select_tk").disabled = 'true';
				document.getElementById("course_level").disabled = true;
				document.getElementById("test_kbn").disabled = true;

				var img_name = "V_img_" + $("#question_no").val() + "_001.png" ;
				var image_url = "<?php echo @constant('STUDENT_HOME_DIR');?>
files/image/" + img_name ;
				var img_name2 = "V_img_" + $("#question_no").val() + "_001.jpg" ;
				var image_url2 = "<?php echo @constant('STUDENT_HOME_DIR');?>
files/image/" + img_name2 ;
				console.log("here");
				var flg = doesFileExist(image_url);
				if (flg == true){
					console.log("true png");
					document.getElementById("imgVertical").value = "<img src=\"<?php echo @constant('STUDENT_HOME_DIR');?>
files/image/" + img_name + "\" width=\"600\"><br>"
				}else{
					if (doesFileExist(image_url2) == true){
						console.log("true jpg");
						document.getElementById("imgVertical").value = "<img src=\"<?php echo @constant('STUDENT_HOME_DIR');?>
files/image/" + img_name2 + "\" width=\"600\"><br>"
					}
				}
			}else {
				document.getElementById("course_level").disabled = false;
				document.getElementById("test_kbn").disabled = false;
			}

			// 問題パターンのよによりフィールドを表示/非表示にする
			var qa_pattern = $("#qa_pattern").val();
			if ( qa_pattern == "006" ){
				$("#tr_audio_yes").show();
				$("#tr_audio_no").show();
				$("#tr_audio_ydec").show();
				$("#tr_audio_ndec").show();
			}else {
				$("#tr_audio_yes").hide();
				$("#tr_audio_no").hide();
				$("#tr_audio_ydec").hide();
				$("#tr_audio_ndec").hide();
				document.getElementById("yesAudio").value = "";
				document.getElementById("noAudio").value = "";
				document.getElementById("audio_data2").value = "";
				document.getElementById("audio_data3").value = "";
				$("#audio_yeslbl").val('');
				$("#audio_nolbl").val('');
				$("#yes_description").val('');
				$("#no_description").val('');
			}

			// 模範解答 フィールドを audio/text 決める
			var status = $("#sample_status").val();
			if ( status == "0" ){
				$("#sample_text").hide();
				$("#sample_audio").show();
			}else {
				$("#sample_audio").hide();
				$("#sample_text").show();
			}

			$('input:radio[name="rd_sample_status"]').change(
			function(){
				$("#sample_status").val($(this).val());

				if ( $(this).is(':checked') && $(this).val() == '0' ){
					$("#sample_text").hide();
					$("#sample_audio").show();
				}else {
					$("#sample_audio").hide();
					$("#sample_text").show();
				}
			});
			
			function doesFileExist(urlToFile)
			{
				var xhr = new XMLHttpRequest();
				xhr.open('HEAD', urlToFile, false);
				xhr.send();

				if (xhr.status == "404") {
					console.log("File doesn't exist");
					return false;
				} else {
					console.log("File exists");
					return true;
				}
			}

			// オーディオ処理
			File.prototype.convertToBase64 = function(callback){
				var reader = new FileReader();
				reader.onload = function(e) {
					callback(e.target.result)
				};
				reader.onerror = function(e) {
					callback(null);
				};
				reader.readAsDataURL(this);
			};

			// オーディオ名の変化処理
			$("input[type=file]#audio_name").on("change", function () {
				var selectedFile1 = this.files[0];

				console.log(selectedFile1);

				if ( selectedFile1 != null ){
					selectedFile1.convertToBase64(function(base64) {
						document.getElementById("audio_data1").value = base64;
					});
				}else {
					document.getElementById("audio_data1").value = "";
					$("#file_ext").val("");
				}

				var fileName = $("input[type=file]#audio_name").val();
				var clean = fileName.split('\\').pop();
				$("#audio_namelbl").val(clean);
				
				// ファイル拡張子設定
				if (audio_name.value != ""){
					file_ext = "." + audio_name.value.split('.').pop();
					$("#file_ext").val(file_ext);
				}

			});

		// yes オーディオの変化処理
		$("input[type=file]#yesAudio").on("change", function () {

			var selectedFile2 = this.files[0];
			console.log(selectedFile2);
			if ( selectedFile2 != null ){
				selectedFile2.convertToBase64(function(base64) {
					document.getElementById("audio_data2").value = base64;
				});
			}else {
				document.getElementById("audio_data2").value = "";
			}

			var fileName = $("input[type=file]#yesAudio").val();
			var clean = fileName.split('\\').pop();
			$("#audio_yeslbl").val(clean);

		});

		// no オーディオの変化処理
		$("input[type=file]#noAudio").on("change", function () {

			var selectedFile3 = this.files[0];

			console.log(selectedFile3);

			if ( selectedFile3 != null ){
				selectedFile3.convertToBase64(function(base64) {
					document.getElementById("audio_data3").value = base64;
				});
			}else {
				document.getElementById("audio_data3").value = "";
			}

			var fileName = $("input[type=file]#noAudio").val();
			var clean = fileName.split('\\').pop();

			$("#audio_nolbl").val(clean);

		});

		// 模範解答の変化処理
		$("input[type=file]#sampleAnsAudio").on("change", function () {

			var selectedFile4 = this.files[0];

			console.log(selectedFile4);

			if ( selectedFile4 != null ){
				selectedFile4.convertToBase64(function(base64) {
					document.getElementById("audio_data4").value = base64;
				});
			}else {
				document.getElementById("audio_data4").value = "";
			}

			var fileName = $("input[type=file]#sampleAnsAudio").val();
			var clean = fileName.split('\\').pop();
			$("#sample_answerlbl").val(clean);

		});

		// テスト区分の変化処理
		$("#select_tk").on('change',function(){

			var test_type = $("#select_tk").val();

			if ( test_type == '001' ){

				var divsToHide = document.getElementsByClassName("class_" + wqa_pattern);
				for ( var i = 0; i < divsToHide.length; i++ ){
					divsToHide[i].style.display = "none";
				}

				var divsToShow = document.getElementsByClassName("class_" + sqa_pattern);
				for ( var i = 0; i < divsToShow.length; i++ ){
					divsToShow[i].style.display = "";
				}
				$("#qa_pattern").val("option:first");

				var optionValues = [];

				$('#score_pattern option').each(function() {
					optionValues.push($(this).val());
				});
				targetSubCategory = document.getElementById('score_pattern'); //Sub Category option.
				subCategoryOptionsCount = document.getElementById('score_pattern').length;
				tempVar = 0;
				for (var i = 0; i < subCategoryOptionsCount; i++) {
					if(targetSubCategory.options[i].value != "001" ){
						$('#score_pattern option[value="'+optionValues[i]+'"]').prop("disabled", false);
					}
				}
			}
			// writing なら、
			if ( test_type == '002' ){

				var divsToHide = document.getElementsByClassName("class_" + sqa_pattern);
				for ( var i = 0; i < divsToHide.length; i++ ){
					divsToHide[i].style.display = "none";
				}

				var divsToShow = document.getElementsByClassName("class_" + wqa_pattern);
				for ( var i = 0; i < divsToShow.length; i++ ){
					divsToShow[i].style.display = "";
				}

				var textToFind = 'Writing';

				var dd = document.getElementById('qa_pattern');
				for ( var i = 0; i < dd.options.length; i++ ){
					if ( dd.options[i].text === textToFind ){
						dd.selectedIndex = i;
						break;
					}
				}
				// Writing のためオプションを無効にする
				var optionValues = [];

				$('#score_pattern option').each(function() {
					optionValues.push($(this).val());
				});

				targetSubCategory = document.getElementById('score_pattern'); //Sub Category option.
				subCategoryOptionsCount = document.getElementById('score_pattern').length;
				tempVar = 0;
				for (var i = 0; i < subCategoryOptionsCount; i++) {
					if(targetSubCategory.options[i].value != "001" ){
						$('#score_pattern option[value="'+optionValues[i]+'"]').prop("disabled", true);
					}
				}
				//デフォルト値を設定する
				$("#score_pattern").val('001');
				$("#sample_status").val("1");
				$("#prepare_time").val('');

			}
			// speaking なら、
			if ( test_type == "001" ){

				$("#tr_sampleAudio").show();
				$("#tr_audio_name").show();
				$("#tr_audio_dec").show();
				$("#tr_prepareTime").show();
				$("#sample_radio").show();
				$("#sample_audio").show();
				$("#tr_img_vertical").show();
				document.getElementById("sample_answer").value = "";
				document.getElementById("test_kbn").value = "001";
			}else {

				$("#tr_audio_yes").hide();
				$("#tr_audio_no").hide();
				$("#tr_sampleAudio").hide();
				$("#tr_audio_name").hide();
				$("#tr_img_vertical").hide();
				$("#tr_audio_dec").hide();
				$("#tr_audio_ydec").hide();
				$("#tr_audio_ndec").hide();
				$("#tr_prepareTime").hide();
				$("#sample_radio").hide();
				$("#sample_audio").hide();
				$("#sample_text").show();
				document.getElementById("yesAudio").value = "";
				document.getElementById("noAudio").value = "";
				document.getElementById("sampleAnsAudio").value = "";
				document.getElementById("audio_name").value = "";
				document.getElementById("audio_description").value = "";
				document.getElementById("yes_description").value = "";
				document.getElementById("no_description").value = "";
				document.getElementById("test_kbn").value = "002";
				$("#audio_namelbl").val('');
				$("#audio_yeslbl").val('');
				$("#audio_nolbl").val('');
				$("#sample_status").val("1");
			}
		});

		//　問題パターンの変化処理
		$("#qa_pattern").on('change', function() {
			var qa_pattern = $("#qa_pattern").val();

			if ( qa_pattern == "006" ){

				$("#tr_audio_yes").show();
				$("#tr_audio_no").show();
				$("#tr_audio_ydec").show();
				$("#tr_audio_ndec").show();
			}else {

				$("#tr_audio_yes").hide();
				$("#tr_audio_no").hide();
				$("#tr_audio_ydec").hide();
				$("#tr_audio_ndec").hide();
				$("#audio_yeslbl").val('');
				$("#audio_nolbl").val('');
				$("#audio_yes").val('');
				$("#audio_no").val('');
				$("#yesAudio").val("");
				$("#noAudio").val("");
				document.getElementById("audio_data2").value = "";
				document.getElementById("audio_data3").value = "";
				document.getElementById("yes_description").value = "";
				document.getElementById("no_description").value = "";
			}
		});

		// 登録バートンを押す時
		$(".btn_insert").on('click', function(){

			$(".error_section").hide();
			var qa_pattern = $("#qa_pattern").val();
			var question_name = document.getElementById('question_name').value;
			var nic_description = new nicEditors.findEditor('description');
			var description = nic_description.getContent();
			var test_kbn = document.getElementById('test_kbn').value;
			var course_level = $("#course_level").val();
			var score_pattern = $("#score_pattern").val();
			var audio_name = document.getElementById('audio_namelbl').value;
			var answer_time = document.getElementById('answer_time').value;
			var prepare_time = document.getElementById('prepare_time').value;
			var audio_no = document.getElementById('audio_nolbl').value;
			var audio_yes = document.getElementById('audio_yeslbl').value;
			var status = $('input[name=status]:checked').val();
			var yes_description = document.getElementById('yes_description').value;
			var no_description = document.getElementById('no_description').value;
			var type = document.getElementById('select_tk').value;
			var sample_ans = document.getElementById('sample_answer').value;
			var byosha_pt = document.getElementById('byosha_point').value;
			document.getElementById("course_level").disabled = false;
			document.getElementById("test_kbn").disabled = false;
			// 問題名の必須チェック
			if ( question_name == "" || question_name == null ){

				$('#err_dis').show();
				$(".error_section").slideToggle('slow');
				$(".error_msg").html("問題名を入力してください。");
				$(window).scrollTop(0);
				return false;
			}

			// 問題名の文字数チェック
			if ( question_name.length > 32 ){

				$('#err_dis').show();
				$(".error_section").slideToggle('slow');
				$(".error_msg").html("問題名を32字で入力してください。");
				$(window).scrollTop(0);
				return false;
			}

			// 問題説明の文字数チェック
			if ( qa_description.length > 1024 ){

				$('#err_dis').show();
				$(".error_section").slideToggle('slow');
				$(".error_msg").html("問題説明を1024字で入力してください。");
				$(window).scrollTop(0);
				return false;
			}

			// Writingの場合
			if ( type == "002" ){

				var stripedHtml = $("<div>").html(description).text();
				// 内容の必須チェック
				if ( stripedHtml == "" || stripedHtml == null || !stripedHtml.trim() ){

					if ( description.includes("<img") == false ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("Writingの場合は内容を入力してください。");
						$(window).scrollTop(0);
						return false;
					}
				}
			}

			// 問題説明の文字数チェック
			if ( description.length > 2048 ){

				$('#err_dis').show();
				$(".error_section").slideToggle('slow');
				$(".error_msg").html("内容を1024字で入力してください。");
				$(window).scrollTop(0);
				return false;
			}

			// テスト区分の必須チェック
			if ( test_kbn == "" || test_kbn == null ){

				$('#err_dis').show();
				$(".error_section").slideToggle('slow');
				$(".error_msg").html("テスト区分を入力してください。");
				$(window).scrollTop(0);
				return false;
			}

			// コースレベルの必須チェック
			if ( course_level == "0" ){

				$('#err_dis').show();
				$(".error_section").slideToggle('slow');
				$(".error_msg").html("コースレベルを入力してください。");
				$(window).scrollTop(0);
				return false;
			}

			//　問題パターンの必須チェック
			if ( qa_pattern == "0" ){

				$('#err_dis').show();
				$(".error_section").slideToggle('slow');
				$(".error_msg").html("問題パターン	を入力してください。");
				$(window).scrollTop(0);
				return false;
			}

			// 点数パターンの必須チェック
			if ( score_pattern == "0" ){

				$('#err_dis').show();
				$(".error_section").slideToggle('slow');
				$(".error_msg").html("採点パターンを入力してください。");
				$(window).scrollTop(0);
				return false;
			}

			// 準備時間の数字チェック
			if ( prepare_time != "" ){

				if ( isNaN(prepare_time) ){

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("準備時間を数字で入力してください。");
					$(window).scrollTop(0);
					return false;
				}
			}

			// 答え時間の必須チェック
			if ( answer_time == "" ){

				$('#err_dis').show();
				$(".error_section").slideToggle('slow');
				$(".error_msg").html("回答時間を入力してください。");
				$(window).scrollTop(0);
				return false;
			}

			// 答え時間の数字チェック
			if ( isNaN(answer_time) ){

				$('#err_dis').show();
				$(".error_section").slideToggle('slow');
				$(".error_msg").html("回答時間を数字で入力してください。");
				$(window).scrollTop(0);
				return false;
			}

			// speaking なら　オーディオチェック
			if ( test_kbn == '001' ){

			// 2020/07/22 音声ファイル必須チェック削除
			//オーディオ名必須チェック
			//	if ( audio_name == "" ){

			//		$('#err_dis').show();
			//		$(".error_section").slideToggle('slow');
			//		$(".error_msg").html("音声ファイルを入力してください。");
			//		$(window).scrollTop(0);
			//		return false;
			//	}

				//yes/no 問題なら
				if ( qa_pattern == "006" ){
					//yes オーディオ必須チェック
					if ( audio_yes == "" ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("Yes 音声ファイルを入力してください。");
						$(window).scrollTop(0);
						return false;
					}
					//yes オーディオ必須チェック
					if ( audio_no == "" ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("No 音声ファイルを入力してください。");
						$(window).scrollTop(0);
						return false;
					}

					//yes 音声内容必須チェック
					if ( yes_description == "" ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("yes 音声内容を入力してください。");
						$(window).scrollTop(0);
						return false;
					}

					//no 音声内容必須チェック
					if ( no_description == "" ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("no 音声内容を入力してください。");
						$(window).scrollTop(0);
						return false;
					}
				}
			}

			// 公開の必須チェック
			if ( status == "" ){

				$('#err_dis').show();
				$(".error_section").slideToggle('slow');
				$(".error_msg").html("状態を入力してください。");
				$(window).scrollTop(0);
				return false;
			}

			if ( sample_ans != "" ){

				//模範解答の文字数チェック
				var sample_answer = $("sample_answer").val().length;
				if ( sample_answer > 4096 ){

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("模範解答を4096字で入力してください。");
					$(window).scrollTop(0);
					return false;
				}
			}

			if ( byosha_pt != "" ){

				// 描写ポイントの文字数チェック
				var byosha_point = $("byosha_point").val().length;
				if ( byosha_point > 4096 ){

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("描写ポイントを4096字で入力してください。");
					$(window).scrollTop(0);
					return false;
					//loading 進捗を表示する
				}
			}

			//フィルタ
			if ( !document.getElementById("filter") ){

				$("body").append("<div id=\"filter\"></div>");
			}else {
				$("#filter").show();
			}
			return true;
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
	<body class="pushmenu-push" style="overflow-y: scroll;">
		<form id="main_form" action="<?php echo @constant('HOME_DIR');?>
QuestionRegist/save" method="post" >
			<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:leftMenu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<div class="divHeader" style="position:fixed; top:0;z-index: 1000;">
				<!--header-->
					<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

				<!--header-->
			</div>
				<div class="divQuizRegist" style="top:60px; margin-top: 60px;width:100%">
					<section class="error_section">
					<img src="<?php echo @constant('HOME_DIR');?>
image/close_icon.png" style="width:15px;float:right" class="close_icon">
						<?php if (!empty($_smarty_tpl->tpl_vars['msg']->value)) {?>
						<div class="error_msg"><?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
</div>
						<?php } else { ?>
						 <div class="error_msg"></div>
						<?php }?>
					</section>
					<section class="content" style="padding-top:5px;">
						<p>
							><span class="title"> コース / 問題登録</span>
						</p>
						<p style="text-align:right;width:100%;">
							<input type="button" title="戻る" value="" class="btn_back" onclick="javascript:doBack('<?php echo @constant('HOME_DIR');?>
QuestionRegist/back')">
						</p>
						
						<input type="hidden" id="home_dir" value="<?php echo @constant('HOME_DIR');?>
" />
						<input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
"/>
						<input type="hidden" id="search_question_name" name="search_question_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->search_question_name, ENT_QUOTES, 'UTF-8', true);?>
"/>
						<input type="hidden" id="search_status" name="search_status" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_status;?>
"/>
						<input type="hidden" id="search_chk_status1" name="search_chk_status1" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_chk_status1;?>
"/>
						<input type="hidden" id="search_chk_status2" name="search_chk_status2" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_chk_status2;?>
"/>
						<input type="hidden" id="search_test_kbn" name="search_test_kbn" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_test_kbn;?>
"/>
						<input type="hidden" id="search_course_level" name="search_course_level" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_course_level;?>
"/>
						<input type="hidden" id="question_no" name="question_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->question_no;?>
">
						<input type="hidden" id="test_kbn" name="test_kbn" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_kbn;?>
">
						<input type="hidden" id="sw_kbn" name="sw_kbn" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_type;?>
">
						<input type="hidden" id="screen_mode" name="screen_mode" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->screen_mode;?>
">
						<input type="hidden" id="btn_flg" name="btn_flg" value="<?php echo $_smarty_tpl->tpl_vars['btn_flg']->value;?>
">
						<input type="hidden" id="back_flg" name="back_flg" value="">
						<input type="hidden" id="sample_status" name="sample_status" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->sample_status;?>
">
						<input type="hidden" id="audio_data1" name="audio_data1" value=""/>
						<input type="hidden" id="audio_data2" name="audio_data2" value=""/>
						<input type="hidden" id="audio_data3" name="audio_data3" value=""/>
						<input type="hidden" id="audio_data4" name="audio_data4" value=""/>
						<input type="hidden" id="scategory" name="scategory" value="<?php echo @constant('SQA_PATTERN');?>
"/>
						<input type="hidden" id="wcategory" name="wcategory" value="<?php echo @constant('WQA_PATTERN');?>
"/>
						<input type="hidden" id="gamen_name" name="gamen_name" value="question" />
						<input type="hidden" id="orgNo" name="orgNo" value="" />
						<input type="hidden" id="file_ext" name="file_ext" value="" />
						<div class="task_div" style="width:98%;">

							<table style="width:98%;">
								<tr>
									<td>SW<span class="required">※</span></td>
									<td class="input">
										<select id="select_tk">
											<?php if (!empty($_smarty_tpl->tpl_vars['form']->value->test_kbn_list)) {?>
											<?php
$_from = $_smarty_tpl->tpl_vars['form']->value->test_kbn_list;
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
												<?php if ($_smarty_tpl->tpl_vars['value']->value->type == $_smarty_tpl->tpl_vars['form']->value->test_kbn) {?>
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
									</td>
								</tr>
								<tr>
									<td>レベル<span class="required">※</span></td>
									<td class="input">
										<select name="course_level" id="course_level">
											<?php if (!empty($_smarty_tpl->tpl_vars['form']->value->course_level_list)) {?>
											<?php
$_from = $_smarty_tpl->tpl_vars['form']->value->course_level_list;
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
												<?php if ($_smarty_tpl->tpl_vars['value']->value->type == $_smarty_tpl->tpl_vars['form']->value->course_level) {?>
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
								</tr>
								<tr>
									<td style="width:240px">問題パターン<span class="required">※</span></td>
									<td class="input">
										<?php if ($_smarty_tpl->tpl_vars['form']->value->test_kbn == '001') {?>
											<?php $_smarty_tpl->tpl_vars['temp'] = new Smarty_Variable("017", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'temp', 0);?>
										<?php } elseif ($_smarty_tpl->tpl_vars['form']->value->test_kbn == '002') {?>
											<?php $_smarty_tpl->tpl_vars['temp'] = new Smarty_Variable("018", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'temp', 0);?>
										<?php } else { ?>
											<?php $_smarty_tpl->tpl_vars['temp'] = new Smarty_Variable("0", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'temp', 0);?>
										<?php }?>
										<select name="qa_pattern" id="qa_pattern" >
											<?php if (!empty($_smarty_tpl->tpl_vars['form']->value->qa_pattern_list)) {?>
											<?php
$_from = $_smarty_tpl->tpl_vars['form']->value->qa_pattern_list;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_value_2_saved_item = isset($_smarty_tpl->tpl_vars['value']) ? $_smarty_tpl->tpl_vars['value'] : false;
$_smarty_tpl->tpl_vars['value'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['value']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
$__foreach_value_2_saved_local_item = $_smarty_tpl->tpl_vars['value'];
?>
												<?php if ($_smarty_tpl->tpl_vars['value']->value->type == $_smarty_tpl->tpl_vars['form']->value->qa_pattern && $_smarty_tpl->tpl_vars['value']->value->category == $_smarty_tpl->tpl_vars['temp']->value) {?>
													<option value="<?php echo $_smarty_tpl->tpl_vars['value']->value->type;?>
" class="class_<?php echo $_smarty_tpl->tpl_vars['value']->value->category;?>
" selected><?php echo $_smarty_tpl->tpl_vars['value']->value->name;?>
</option>
												<?php } else { ?>
													<option value="<?php echo $_smarty_tpl->tpl_vars['value']->value->type;?>
" class="class_<?php echo $_smarty_tpl->tpl_vars['value']->value->category;?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value->name;?>
 </option>
												<?php }?>
											<?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_2_saved_local_item;
}
if ($__foreach_value_2_saved_item) {
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_2_saved_item;
}
?>
											<?php }?>
										</select>
									</td>
								</tr>
								<tr>
									<td style="width:240px">採点パターン<span class="required">※</span></td>
									<td class="input">
										<select name="score_pattern" id="score_pattern">
											<?php if (!empty($_smarty_tpl->tpl_vars['form']->value->score_pattern_list)) {?>
											<?php
$_from = $_smarty_tpl->tpl_vars['form']->value->score_pattern_list;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_value_3_saved_item = isset($_smarty_tpl->tpl_vars['value']) ? $_smarty_tpl->tpl_vars['value'] : false;
$_smarty_tpl->tpl_vars['value'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['value']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
$__foreach_value_3_saved_local_item = $_smarty_tpl->tpl_vars['value'];
?>
												<?php if ($_smarty_tpl->tpl_vars['value']->value->type == $_smarty_tpl->tpl_vars['form']->value->score_pattern) {?>
													<option value="<?php echo $_smarty_tpl->tpl_vars['value']->value->type;?>
" class="class_<?php echo $_smarty_tpl->tpl_vars['value']->value->category;?>
" selected><?php echo $_smarty_tpl->tpl_vars['value']->value->name;?>
 </option>
												<?php } else { ?>
													<option value="<?php echo $_smarty_tpl->tpl_vars['value']->value->type;?>
" class="class_<?php echo $_smarty_tpl->tpl_vars['value']->value->category;?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value->name;?>
 </option>
												<?php }?>
											<?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_3_saved_local_item;
}
if ($__foreach_value_3_saved_item) {
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_3_saved_item;
}
?>
											<?php }?>
										</select>
									</td>
								</tr>
								<tr>
									<td style="width:240px">問題名<span class="required">※</span></td>
									<td><input type="text" class="text" id="question_name" name="question_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->question_name, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "32" size="30"></td>
								</tr>
								<tr>
									<td style="width:240px">問題説明</td>
									<td><br/><textarea name="qa_description" id="qa_description" rows="2" class="txtarea"
									cols="40"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->qa_description, ENT_QUOTES, 'UTF-8', true);?>
</textarea></td>
								</tr>
								<tr>
									<td style="width:240px">内容</td>
									<td><br/><div style="position: relative;"><textarea name="description" id="description" rows="2" class="txtarea" style="width:800px"
									cols="40"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->description, ENT_QUOTES, 'UTF-8', true);?>
</textarea></div></td>
								</tr>
								<tr id="tr_img_vertical">
									<td style="width:240px">画像（携帯、タブレット縦用）</td>
									<td><br/><div style="position: relative;"><textarea name="imgVertical" id="imgVertical" rows="2" class="txtarea" style="width:800px" 
									cols="40"></textarea></div></td>
								</tr>
								<tr id="tr_prepareTime">
									<td style="width:240px">準備時間</td>
									<td><input type="text" class="text" id="prepare_time" name="prepare_time"  value="<?php echo $_smarty_tpl->tpl_vars['form']->value->prepare_time;?>
" maxlength = "3" size="30"></td>
								</tr>
								<tr>
									<td style="width:240px">回答時間<span class="required">※</span></td>
									<td><input type="text" class="text" id="answer_time" name="answer_time"  value="<?php echo $_smarty_tpl->tpl_vars['form']->value->answer_time;?>
" maxlength = "4" size="30"></td>
								</tr>
								<tr id="tr_audio_name">
									<td style="width:240px">音声ファイル名</td>
									<td><input type="text" id="audio_namelbl" name="audio_namelbl" readonly="readonly" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->audio_namelbl, ENT_QUOTES, 'UTF-8', true);?>
" style="width:200px;height:25px;margin-top:0px;"/>
										<input type="file" id="audio_name" name="audio_name" style="width:250px;height:30px;margin-top:0px;" accept="audio/mp3,video/mp4"/></td>
								</tr>
								<tr id="tr_audio_dec">
									<td style="width:240px">音声内容</td>
									<td><br/><textarea name="audio_description" id="audio_description" rows="3" class="txtarea"
									cols="40" maxlength="1024"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->audio_description, ENT_QUOTES, 'UTF-8', true);?>
</textarea></td>
								</tr>
								<tr id="tr_audio_yes">
									<td style="width:240px">yes音声ファイル<span class="required">※</span></td>
									<td><input type="text" id="audio_yeslbl" name="audio_yeslbl" readonly="readonly" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->audio_yeslbl, ENT_QUOTES, 'UTF-8', true);?>
" style="width:200px;height:25px;margin-top:0px;"/>
										<input type="file" id="yesAudio" name="audio_yes" style="width:250px;height:30px;margin-top:0px;" accept="audio/mp3"/></td>
								</tr>
								<tr id="tr_audio_ydec">
									<td style="width:240px">yes音声内容<span class="required">※</span></td>
									<td><br/><textarea name="yes_description" id="yes_description" rows="3" class="txtarea"
									cols="40" maxlength="1024"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->yes_description, ENT_QUOTES, 'UTF-8', true);?>
</textarea></td>
								</tr>
								<tr id="tr_audio_no">
									<td style="width:240px">no音声ファイル<span class="required">※</span></td>
									<td><input type="text" id="audio_nolbl" name="audio_nolbl" readonly="readonly" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->audio_nolbl, ENT_QUOTES, 'UTF-8', true);?>
" style="width:200px;height:25px;margin-top:0px;"/>
										<input type="file" id="noAudio" name="audio_no" style="width:250px;height:30px;margin-top:0px;" accept="audio/mp3"/></td>
								</tr>
								<tr id="tr_audio_ndec">
									<td style="width:240px">no音声内容<span class="required">※</span></td>
									<td><br/><textarea name="no_description" id="no_description" rows="3" class="txtarea"
									cols="40" maxlength="1024"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->no_description, ENT_QUOTES, 'UTF-8', true);?>
</textarea></td>
								</tr>
								<tr>
									<td style="width:240px">状態<span class="required">※</span></td>
									<td>
										<?php if ($_smarty_tpl->tpl_vars['form']->value->status != '公開' && $_smarty_tpl->tpl_vars['form']->value->status != '1') {?>
										<input type="radio" name="status" value="0" id="status1" checked />
										<label for="status1">しない </label></input>
										<input type="radio" name="status" value="1" id="status2" />
										<label for="status2">する</label></input>
										<?php } else { ?>
										<input type="radio" name="status" value="0" id="status1" />
										<label for="status1">しない </label></input>
										<input type="radio" name="status" value="1" id="status2" checked />
										<label for="status2">する</label>
										</input>
										<?php }?>
									</td>
								</tr>

								<tr id="sp_modelAns">
									<td style="width:240px">模範解答</td>

									<td>
										<div id="sample_radio">
											<?php if ($_smarty_tpl->tpl_vars['form']->value->sample_status != '0') {?>
												<input type="radio" name="rd_sample_status" value="0" id="sample_status1" />
												<label for="sample_status1">Audio </label></input>
												<input type="radio" name="rd_sample_status" value="1" id="sample_status2" checked/>
												<label for="sample_status2">Text</label></input>
											<?php } else { ?>
												<input type="radio" name="rd_sample_status" value="0" id="sample_status1" checked/>
												<label for="sample_status1">Audio </label></input>
												<input type="radio" name="rd_sample_status" value="1" id="sample_status2" />
												<label for="sample_status2">Text</label></input>
											<?php }?>
										</div>
										<br/>
										<div id="sample_audio">
											<input type="text" id="sample_answerlbl" name="sample_answerlbl" readonly="readonly" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->sample_answerlbl, ENT_QUOTES, 'UTF-8', true);?>
" style="width:200px;height:25px;margin-top:0px;"/>
											<input type="file" id="sampleAnsAudio" name="sample_answer_audio" style="width:250px;height:30px;margin-top:0px;" accept="audio/mp3"/>
										</div>
										<div id="sample_text">
											<textarea name="sample_answer" id="sample_answer" rows="3" class="txtarea"
											cols="40" maxlength="4096"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->sample_answer, ENT_QUOTES, 'UTF-8', true);?>
</textarea>
										</div>
									</td>
								</tr>

								<tr>
									<td style="width:240px">描写ポイント</td>
									<td><br/><textarea name="byosha_point" id="byosha_point" rows="3" class="txtarea" maxlength="4096"
									cols="40"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->byosha_point, ENT_QUOTES, 'UTF-8', true);?>
</textarea></td>
								</tr>
								<tr>
									<td style="width:240px">備考</td>
									<td><input type="text" class="text" id="remarks" name="remarks"  value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->remarks, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "32" size="30"></td>
								</tr>
								<tr>
									<td colspan="2">
									</td>
								</tr>
							</table>
						</div>
						<p style="text-align:right;width:100%;height:100px">
							<input type="submit" name="insert" value="" class="btn_insert" title="登録">
						</p>
					</section>
					
				</div>
			<!--footer-->
				<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<!--footer-->
		</form>
	</body>
	</div>
</html>
<?php }
}
