<?php
/* Smarty version 3.1.29, created on 2022-10-13 17:06:05
  from "/var/www/html/eccadmin_dev/templates/leftMenu.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_6347c6ed833dd2_30680933',
  'file_dependency' => 
  array (
    'e1c7e085885d7a7773bbd1c4cfe1ec427a724a9d' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/leftMenu.html',
      1 => 1663295203,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6347c6ed833dd2_30680933 ($_smarty_tpl) {
?>
<input type="hidden" id ="menuOpen" name="menuOpen" value="<?php echo $_smarty_tpl->tpl_vars['menuOpen']->value;?>
" >
<input type="hidden" id ="menuStatus" name="menuStatus" value="<?php echo $_smarty_tpl->tpl_vars['menuStatus']->value;?>
" >
<input type="hidden" id ="uid" name="uid" value="<?php echo $_smarty_tpl->tpl_vars['uid']->value;?>
" >
<input type="hidden" id ="admin_kbn" name="admin_kbn" value="<?php echo $_smarty_tpl->tpl_vars['admin_kbn']->value;?>
" >
<input type="hidden" id ="type1" name="type1" value="<?php echo @constant('ADMIN_KBN');?>
" >
<input type="hidden" id ="type2" name="type2" value="<?php echo @constant('ADMIN_FOLLOW_KBN');?>
" >
<input type="hidden" id ="type3" name="type3" value="<?php echo @constant('ADMIN_4SKILL_KBN');?>
" >
<input type="hidden" id ="type4" name="type4" value="<?php echo @constant('CEBU_TEACHER_KBN');?>
" >
<input type="hidden" id ="type5" name="type5" value="<?php echo @constant('BU_ADMIN_KBN');?>
" >
<nav class="pushmenu pushmenu-left">
	<ul id="menu" >
		<li class="drawer-menu">
			<a href="<?php echo @constant('HOME_DIR');?>
Menu">
				<h3><?php echo $_smarty_tpl->tpl_vars['admin_name']->value;?>
様 (<?php echo $_smarty_tpl->tpl_vars['romaji_name']->value;?>
)
					<?php echo $_smarty_tpl->tpl_vars['login_time']->value;?>

				</h3>
			</a>
		</li>
	</ul>
	<div style="overflow: auto;" id="div_menu">
		<ul>
			<li class="drawer-dropdown" id="menu_li_orgMenu">
				<a class="drawer-menu-item" data-target="#" href="javascript:void(0);" data-toggle="dropdown" role="button" aria-expanded="false" id="orgMenu">
				<span class="orgMenuIcon"></span><label class="menu-label">組織</label>
				<span class="drawer-caret"></span>
				</a>
				<ul class="drawer-dropdown-menu" style="display:none;">
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="OrganizationList">組織一覧</a></li>
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="OrganizationRegist/index">組織登録</a></li>
				</ul>
			</li>
		</ul>
		<ul>
			<li class="drawer-dropdown" id="menu_li_swApp">
				<a class="drawer-menu-item" data-target="#" href="javascript:void(0);" data-toggle="dropdown" role="button" aria-expanded="false" id="swAppMenu">
				<span class="courseMenuIcon"></span><label class="menu-label">SW 申込</label>
				<span class="drawer-caret"></span>
				</a>
				<ul class="drawer-dropdown-menu" style="display:none;">
				<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="CourseContractList">コース契約一覧</a></li>
				</ul>
			</li>
		</ul>
		<ul>
			<li class="drawer-dropdown" id="menu_li_swStatus">
				<a class="drawer-menu-item" data-target="#" href="javascript:void(0);" data-toggle="dropdown" role="button" aria-expanded="false" id="swStatusMenu">
				<span class="courseMenuIcon"></span><label class="menu-label">SW 状況</label>
				<span class="drawer-caret"></span>
				</a>
				<ul class="drawer-dropdown-menu" style="display:none;">
				<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="CourseContractConfirmList">コース契約確認</a></li>
				<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="CourseStatusList">コース受講状況一覧</a></li>
				</ul>
			</li>
		</ul>
		<ul>
			<li class="drawer-dropdown" id="menu_li_swref">
				<a class="drawer-menu-item" data-target="#" href="javascript:void(0);" data-toggle="dropdown" role="button" aria-expanded="false" id="swRefMenu">
				<span class="courseMenuIcon"></span><label class="menu-label">SW 参照</label>
				<span class="drawer-caret"></span>
				</a>
				<ul class="drawer-dropdown-menu" style="display:none;">
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="SWPracticeReferenceList">SW Practice 参照</a></li>
				</ul>
			</li>
		</ul>
		<ul>
			<li class="drawer-dropdown" id="menu_li_wordMenu">
				<a class="drawer-menu-item" data-target="#" href="javascript:void(0);" data-toggle="dropdown" role="button" aria-expanded="false" id="wordMenu">
				<span class="wordMenuIcon"></span><label class="menu-label">単語</label>
				<span class="drawer-caret"></span>
				</a>
				<ul class="drawer-dropdown-menu" style="display:none;">
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="WordBookList">単語帳一覧</a></li>
					<li class="admintype5"><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="WordBookRegist">単語帳登録</a></li>
					<li class="admintype5"><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="WordList">単語一覧</a></li>
					<li class="admintype5"><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="WordRegist">単語登録</a></li>
				</ul>
			</li>
		</ul>
		<ul>
			<li class="drawer-dropdown" id="menu_li_testMenu">
				<a class="drawer-menu-item" data-target="#" href="javascript:void(0);" data-toggle="dropdown" role="button" aria-expanded="false" id="testMenu">
				<span class="testMenuIcon"></span><label class="menu-label">テスト</label>
				<span class="drawer-caret"></span>
				</a>
				<ul class="drawer-dropdown-menu" style="display:none;">
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="TestList">テスト一覧</a></li>
					<li class="admintype5"><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="TestRegist">テスト登録</a></li>
					<li class="admintype5"><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="QuizList">クイズ一覧</a></li>
					<li class="admintype5"><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="QuizRegist">クイズ登録</a></li>
				</ul>
			</li>
		</ul>
		<ul>
			<li class="drawer-dropdown" id="menu_li_testInfoMenu">
				<a class="drawer-menu-item" data-target="#" href="javascript:void(0);" data-toggle="dropdown" role="button" aria-expanded="false" id="testInfoMenu">
				<span class="testInfoMenuIcon"></span><label class="menu-label">試験</label>
				<span class="drawer-caret"></span>
				</a>
				<ul class="drawer-dropdown-menu" style="display:none;">
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="TestInfoList">試験一覧</a></li>
					<li class="admintype5"><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="TestInfoRegist">試験登録</a></li>
					<li class="admintype5"><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="QuizInfoList">クイズ一覧</a></li>
					<li class="admintype5"><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="QuizInfoRegist">クイズ登録</a></li>
				</ul>
			</li>
		</ul>
		<ul>
			<li class="drawer-dropdown" id="menu_li_teacher">
				<a class="drawer-menu-item" data-target="#" href="javascript:void(0);" data-toggle="dropdown" role="button" aria-expanded="false" id="teacherMenu">
				<span class="courseMenuIcon"></span><label class="menu-label">講師</label>
				<span class="drawer-caret"></span>
				</a>
				<ul class="drawer-dropdown-menu" style="display:none;">
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="TeacherList">講師一覧</a></li>
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="TeacherRegist">講師登録</a></li>
				</ul>
			</li>
		</ul>
		<ul>
			<li class="drawer-dropdown" id="menu_li_reportMenu">
				<a class="drawer-menu-item" data-target="#" href="javascript:void(0);" data-toggle="dropdown" role="button" aria-expanded="false" id="reportMenu">
				<span class="reportMenuIcon"></span><label class="menu-label">レポート</label>
				<span class="drawer-caret"></span>
				</a>
				<ul class="drawer-dropdown-menu" style="display:none;">
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="ReportList">レポート一覧</a></li>
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="ReportRegist">レポート登録</a></li>
				</ul>
			</li>
		</ul>
		<ul>
			<li class="drawer-dropdown" id="menu_li_atReportMenu">
				<a class="drawer-menu-item" data-target="#" href="javascript:void(0);" data-toggle="dropdown" role="button" aria-expanded="false" id="atReportMenu">
				<span class="reportMenuIcon"></span><label class="menu-label">Online Practice</label>
				<span class="drawer-caret"></span>
				</a>
				<ul class="drawer-dropdown-menu" style="display:none;">
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="AtReportList">Online Practice List</a></li>
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="AtReportRegist">Online Practice Regist</a></li>
				</ul>
			</li>
		</ul>
		<ul>
			<li class="drawer-dropdown" id="menu_li_excel_extract">
				<a class="drawer-menu-item" data-target="#" href="javascript:void(0);" data-toggle="dropdown" role="button" aria-expanded="false" id="excelExtractMenu">
				<span class="courseMenuIcon"></span><label class="menu-label">データ抽出</label>
				<span class="drawer-caret"></span>
				</a>
				<ul class="drawer-dropdown-menu" style="display:none;">
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="SubjectAreaSubjectDataExport">教科：科目</a></li>
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="ManagerDataExport">担当者</a></li>
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="LessonDataExport">レッスン</a></li>
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="GroupDataExport">グループ</a></li>
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="StudentDataExport">受講者</a></li>
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="ManagerSubjectLessonDataExport">担当者：教科：レッスン</a></li>
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="GroupStudentDataExport">グループ：受講者</a></li>
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="LessonGroupStudentDataExport">レッスン：グループ：受講者</a></li>
				</ul>
			</li>
		</ul>
		<ul>
			<li class="drawer-dropdown" id="menu_li_excel">
				<a class="drawer-menu-item" data-target="#" href="javascript:void(0);" data-toggle="dropdown" role="button" aria-expanded="false" id="excelMenu">
				<span class="courseMenuIcon"></span><label class="menu-label">データ登録</label>
				<span class="drawer-caret"></span>
				</a>
				<ul class="drawer-dropdown-menu" style="display:none;">
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="ExcelSubjectAreaList">教科登録</a></li>
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="ExcelSubjectList">科目登録</a></li>
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="ExcelLessonManagerList">担当者登録</a></li>
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="ExcelLessonList">レッスン登録</a></li>
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="ExcelGroupList">グループ登録</a></li>
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="ExcelStudentList">受講者登録</a></li>
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="ExcelLessonGroupList">レッスン：グループ登録</a></li>
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="ExcelGroupStudentList">グループ：受講者登録</a></li>
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="ExcelStudentNoChangeList">受講者番号更新</a></li>
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="ExcelContractList">契約情報登録</a></li>
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="ExcelContract2SkillList">2技能契約受講者登録</a></li>
				</ul>
			</li>
		</ul>
		<ul>
			<li class="drawer-dropdown" id="menu_li_noticeMenu">
				<a class="drawer-menu-item" data-target="#" href="javascript:void(0);" data-toggle="dropdown" role="button" aria-expanded="false" id="noticeMenu">
				<span class="noticeMenuIcon"></span><label class="menu-label">お知らせ</label>
				<span class="drawer-caret"></span>
				</a>
				<ul class="drawer-dropdown-menu" style="display:none;">
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="SystemNoticeRegist">お知らせ設定</a></li>
				</ul>
			</li>
		</ul>
		<ul>
			<li class="drawer-dropdown" id="menu_li_setting">
				<a class="drawer-menu-item" data-target="#" href="javascript:void(0);" data-toggle="dropdown" role="button" aria-expanded="false" id="settingMenu">
				<span class="settingMenuIcon"></span><label class="menu-label">設定</label>
				<span class="drawer-caret"></span>
				</a>
				<ul class="drawer-dropdown-menu" style="display:none;">
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="CourseList">コース一覧</a></li>
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="CourseDetailList">コース詳細</a></li>
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="QuestionList">問題一覧</a></li>
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="AdminList">運用管理者</a></li>
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="Maintenance">メンテナンス</a></li>
				</ul>
			</li>
		</ul>
		<ul>
			<li class="drawer-dropdown" id="menu_li_pswChange">
				<a class="drawer-menu-item" data-target="#" href="javascript:void(0);" data-toggle="dropdown" role="button" aria-expanded="false" id="pswChangeMenu">
				<span class="settingMenuIcon"></span><label class="menu-label">パスワード変更</label>
				<span class="drawer-caret"></span>
				</a>
				<ul class="drawer-dropdown-menu" style="display:none;">
					<li><a class="drawer-dropdown-menu-item" href="javascript:void(0);" id="PasswordChange">パスワード変更</a></li>
				</ul>
			</li>
		</ul>
		<ul>
			<li class="drawer-dropdown" id="menu_li_logout">
				<a class="drawer-menu-item" data-target="#" href="javascript:void(0);"  id="logout" onclick="doLogout();">
				<span class="logoutMenuIcon"></span><label class="menu-label">ログアウト</label>
				</a>
			</li>
		</ul>
	</div>
</nav>
<?php echo '<script'; ?>
 type='text/javascript'>
	$(window).resize(function() {
	    $('#div_menu').height($(window).height()-46);
	});

	$(window).trigger('resize');

	$(window).load(function(){

		$(document).ready(function() {

			var admin_kbn = document.getElementById('admin_kbn').value;
			var type1 = document.getElementById('type1').value;
			var type2 = document.getElementById('type2').value;
			var type3 = document.getElementById('type3').value;
			var type4 = document.getElementById('type4').value;
			
			//事業部担当者
			var type5 = document.getElementById('type5').value;

			if ( admin_kbn != type1 ){

				$('ul #menu_li_orgMenu').hide();
				$('ul #menu_li_setting').hide();
				if ( admin_kbn == type2 ){

					$('ul #menu_li_teacher').hide();
				}else if ( admin_kbn == type3 ){

					$('ul #menu_li_swApp').hide();
					$('ul #menu_li_teacher').hide();
					$('ul #menu_li_excel').hide();
					$('ul #menu_li_excel_extract').hide();
					$('ul #menu_li_noticeMenu').hide();
				}else if ( admin_kbn == type4 ){

					$('ul #menu_li_swApp').hide();
					$('ul #menu_li_swStatus').hide();
					$('ul #menu_li_excel').hide();
					$('ul #menu_li_excel_extract').hide();
					$('ul #menu_li_noticeMenu').hide();
				}else if ( admin_kbn == type5 ) {
				//事業部担当者
					$('ul #menu_li_orgMenu').show();
					$('ul #menu_li_teacher').hide();
					$('ul #menu_li_noticeMenu').hide();
					$('ul #menu_li_setting').hide();
					
					$('li.admintype5').hide();	
				}
			}

			$menuLeft = $('.pushmenu-left');
			$nav_list = $('#nav_list');

			$nav_list.click(function() {

				$('.pushmenu , .pushmenu-push').css("-webkit-transition","all 0.3s ease");
				$('.pushmenu , .pushmenu-push').css("-moz-transition","all 0.3s ease");
				$('.pushmenu , .pushmenu-push').css("transition","all 0.3s ease");

				$(this).toggleClass('active');
				$('.pushmenu-push').toggleClass('pushmenu-push-toright');
				$menuLeft.toggleClass('pushmenu-open');

				if ($('input:hidden[name="menuOpen"]').val() != "open"){

					//メインを狭くする
					$(".main").css("calc","100% - 240px");
					$("#menuOpen").val("open");

				}else {

					$("#menuOpen").val("");

				}

			});
		});
	});

	//menu 表示切替
	$(".drawer-menu-item").on('click',function(){

		//閉じる場合
		if ($(this).next("ul").is(":visible")){

			$(this).next("ul").hide("normal");
			$(this).children('span').removeClass("open");
			$(this).parent().removeClass("open");

			$("#menuStatus").val("");

		}else {

			//開く場合
			//いったん全てを閉じる
			$(".drawer-dropdown-menu").hide("normal");
			$(".drawer-menu-item").children('span').removeClass("open");
			$(".drawer-menu-item").parent().removeClass("open");

			$(this).next("ul").show("normal");
			$(this).children('span').addClass("open");

			$(this).children('span').css("transition","all 0.3s ease");
			$(this).parent().addClass("open");

			//$("#menuOpen").val("open");
			$("#menuStatus").val($(this).attr("id"));

		}

	});

	//submit
	$(document).ready(function() {
	    $(".drawer-dropdown-menu-item,.drawer-menu-single-item").click(function() {

	        $('#main_form').attr("action", "<?php echo @constant('HOME_DIR');?>
" + $(this).attr("id"));

	        //いったん退避
	        var menuOpen = $("#menuOpen").val();
	        var menuStatus = $("#menuStatus").val();
	        var uid = $("#uid").val();
	        var manager_kbn = $("#manager_kbn").val();

			//クリア
			$('#main_form')
				.find('input,textarea')
				.not(':button, :submit,:reset')
				.val('');

			//値を戻す
	        $("#menuOpen").val(menuOpen);
	        $("#menuStatus").val(menuStatus);
	        $("#uid").val(uid);
	        $("#manager_kbn").val(manager_kbn);

	        $('#main_form').submit();

	    });
	});

	//表示再現
	$(document).ready(function() {

		// Menu開閉
		$menuLeft = $('.pushmenu-left');
		$nav_list = $('#nav_list');
		if ($("#menuOpen").val() == "open"){
			$(this).toggleClass('active');
			$('.pushmenu-push').toggleClass('pushmenu-push-toright');
			$menuLeft.toggleClass('pushmenu-open');

			//すぐに開く
			$('.pushmenu , .pushmenu-push').css("-webkit-transition","all 0s ease");
			$('.pushmenu , .pushmenu-push').css("-moz-transition","all 0s ease");
			$('.pushmenu , .pushmenu-push').css("transition","all 0s ease");

		}

		// Drop Menu 開閉
		if ( $("#menuStatus").val() != "" ){
			//menu_li_
			//すぐに開く
			$("#" + $("#menuStatus").val()).next("ul").show(0);
			$("#" + $("#menuStatus").val()).children('span').addClass("open");
			$("#" + $("#menuStatus").val()).children('span').css("transition","all 0s ease");
			$("#" + $("#menuStatus").val()).parent().addClass("open");

		}
	});

	//ログアウト処理
	function doLogout(){

		// result変数に「はい」を選んだらtrue「いいえ」を選んだらfalseが入る
		var result = confirm("ログアウトします。よろしいでしょうか");

		if (result){
		  //はいを選んだときの処理
			window.location.href = '<?php echo @constant('HOME_DIR');?>
Login/logout';
		}else {
		 //いいえを選んだときの処理
		}
	}

<?php echo '</script'; ?>
><?php }
}
