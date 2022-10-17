//クイズアイテム情報

//処理；オプション情報内容入力項目を 1つ追加する
function add_single_row(btnelem,btnIndex){

	//ボタンを押したクイズの行のNo
	var str = btnelem.id;
	var num = str.replace(/[^0-9]/g, '');
    var rowNo = parseInt(num,10);

    //テーブルのID
  　var table = document.getElementById("new_form");
  　
  　//問題に選択したクイズタイプ
  	var e = document.getElementById('qztype_no_'+rowNo);
    var type = e.options[e.selectedIndex].value;

    if(type=='001'){

    	//idx；新しい行の順番（存在した4選択行を数えるため、行のクラスを使う）
    	var idx = document.getElementsByClassName('rc_row'+rowNo).length+1;

    	var row1 = document.createElement('tr');
        var row1 = table.insertRow(btnIndex);

        var col1 = document.createElement('td');
        var col2 = document.createElement('td');
        var col3 = document.createElement('td');

        var itemName = "choice"+idx;
        var itemID = "choice"+rowNo+"_"+idx;

        //col1 is omitted for number.

        var qzrdLabel = document.createElement("LABEL");
        var rdLabel = document.createElement("LABEL");
        var qzRadio = document.createElement("INPUT");
        qzRadio.setAttribute("type", "radio");
        qzRadio.setAttribute("value", "c"+idx );
        qzRadio.setAttribute("type", "radio");
        qzRadio.setAttribute("name", "rchoice"+rowNo );
        rdLabel.innerHTML =" c"+idx;
        qzrdLabel.appendChild(qzRadio);
        qzrdLabel.appendChild(rdLabel);
        col2.appendChild(qzrdLabel);

        var qzItemInput = document.createElement("INPUT");
        qzItemInput.setAttribute("id", itemID);
        qzItemInput.setAttribute("type","text");
        qzItemInput.setAttribute("name",itemName);
        qzItemInput.setAttribute("class","text_box_rd");
        qzItemInput.setAttribute("size",30);
        qzItemInput.setAttribute("maxlength",2048);
        col3.appendChild(qzItemInput);

        row1.appendChild(col1);
        row1.appendChild(col2);
        row1.appendChild(col3);
        row1.setAttribute('class','rc_row'+rowNo);

    }
    else{

    	//idx；新しい行の順番（存在した穴埋め行を数えるため、行のクラスを使う）
    	var idx = document.getElementsByClassName('rb_row'+rowNo).length+1;
    	var itemName = "blank"+idx;
    	var itemID = "blank"+rowNo+"_"+idx;

    	var row1 = document.createElement('tr');
        var row1 = table.insertRow(btnIndex);

        var col1 = document.createElement('td');
        var col2 = document.createElement('td');
        var col3 = document.createElement('td');


    	var qzblabel = document.createElement("label");
    	qzblabel.innerHTML= " A"+idx;
    	col2.appendChild(qzblabel);

    	var qzItemInput = document.createElement("INPUT");
        qzItemInput.setAttribute("id", itemID);
        qzItemInput.setAttribute("type","text");
        qzItemInput.setAttribute("name",itemName);
        qzItemInput.setAttribute("class","text_box_blank");
        qzItemInput.setAttribute("size",30);
        qzItemInput.setAttribute("maxlength",2048);
        col3.appendChild(qzItemInput);

        row1.appendChild(col1);
        row1.appendChild(col2);
        row1.appendChild(col3);
        row1.setAttribute('class','rb_row'+rowNo);

    }

}

//処理；オプション情報内容を追加する
function addRow(){

	var table = document.getElementById("new_form");

	//クイズ情報の順番
	var btnCount = document.getElementsByClassName("btn_delete").length;
    var rowNo = btnCount+1 ;
    var idx = document.getElementsByClassName('rc_row'+rowNo).length+1;

    //tbody作成
    var tbody = document.createElement('tbody');
    tbody.setAttribute("id","tbody"+rowNo)

    //10行
    var row1 = document.createElement('tr');
    var row2 = document.createElement('tr');
    var row3 = document.createElement('tr');
    var row4 = document.createElement('tr');
    var row5 = document.createElement('tr');
    var row6 = document.createElement('tr');
    var row7 = document.createElement('tr');
    var row8 = document.createElement('tr');
    var space1= document.createElement('tr');
    var space2= document.createElement('tr');
    var row9 = document.createElement('tr');
    var row10 = document.createElement('tr');

    //一行
    var col11 = document.createElement('td');
    var col12 = document.createElement('td');
    var col13 = document.createElement('td');
    var col14 = document.createElement('td');
    var col15 = document.createElement('td');
    var col16 = document.createElement('td');
    var col17 = document.createElement('td');
    var col18 = document.createElement('td');

    // no
    col11.innerHTML = rowNo+".";
    col11.style.width = '20px';

    // ラベル
    col12.innerHTML = "タイプ";
    col12.style.width = '75px';

    // タイプ
    var selectList = document.createElement("select");
    createTypeNameList(selectList);
    selectList.onchange = function(){changeSelectValue(this,rowNo);};
    selectList.setAttribute("id","qztype_no_"+rowNo);
    selectList.setAttribute("class","qz_type");
    col13.appendChild(selectList);
    col13.setAttribute("colspan","2");

    col15.style.width = '200px';

    //Q*
    var qzLabel = document.createElement("LABEL");
    qzLabel.innerHTML = "Q";
    var qzRequire = document.createElement("SPAN");
    qzRequire.setAttribute("class", "required");
    qzRequire.innerText = "※";
    qzLabel.appendChild(qzRequire);
    col16.style.width = "75px";
    col16.appendChild(qzLabel);

    col17.style.width="118px";

    col18.style.width="218px";

    row1.appendChild(col11);
    row1.appendChild(col12);
    row1.appendChild(col13);
    row1.appendChild(col15);
    row1.appendChild(col16);
    row1.appendChild(col17);
    row1.appendChild(col18);
   //一行終わり

    //二行
    var col21 = document.createElement('td');
    var col22 = document.createElement('td');
    var col23 = document.createElement('td');
    var col24 = document.createElement('td');
    var col25 = document.createElement('td');
    var col26 = document.createElement('td');

    col21.style.width="20px";

   //クイズマーク
    var qmLabel = document.createElement("LABEL");
    qmLabel.innerHTML = "点数";
    var qzRequire = document.createElement("SPAN");
    qzRequire.setAttribute("class", "required");
    qzRequire.innerText = "※";
    qmLabel.appendChild(qzRequire);
    col22.appendChild(qmLabel);
    col22.style.width = "75px";

    //クイズマークテキストボックス
    var qzMark = document.createElement("INPUT");
    qzMark.setAttribute("type", "text");
    qzMark.setAttribute("id", "txt_mark_"+rowNo);
    qzMark.setAttribute("name", "qz_mark" );
    qzMark.setAttribute("class", "text_box");
    qzMark.setAttribute("size",30);
    qzMark.setAttribute("maxlength",2048);
    col23.setAttribute("colspan", "2");
    col23.appendChild(qzMark);

    col25.style.width = "100px";

    //問題テキスト
    var txtarea = document.createElement("TEXTAREA");
    txtarea.setAttribute("class", "txtarea");
    txtarea.setAttribute("id", "txtarea_"+rowNo);
    txtarea.setAttribute("size",30);
    txtarea.setAttribute("maxlength",2048);
    col26.setAttribute("rowspan","4");
    col26.setAttribute("colspan","3");
    col26.appendChild(txtarea);

    row2.appendChild(col21);
    row2.appendChild(col22);
    row2.appendChild(col23);
    row2.appendChild(col25);
    row2.appendChild(col26);
    //二行終わり

    //三行
    var col31 = document.createElement('td');
    var col32 = document.createElement('td');
    var col33 = document.createElement('td');
    var itemID = "choice"+rowNo+"_"+idx;

    col31.style.width="20px";

    var qzrdLabel = document.createElement("LABEL");
    var rdLabel = document.createElement("LABEL");
    var qzRadio = document.createElement("INPUT");
    qzRadio.setAttribute("type", "radio");
    qzRadio.setAttribute("id", rowNo);
    qzRadio.setAttribute("value", "c1" );
    qzRadio.setAttribute("name", "rchoice"+rowNo );
    qzRadio.setAttribute("checked",true);
    rdLabel.innerHTML = " c1";
    var qzRequire = document.createElement("SPAN");
    qzRequire.setAttribute("class", "required");
    qzRequire.innerText = "※";

    qzrdLabel.appendChild(qzRadio);
    qzrdLabel.appendChild(rdLabel);
    qzrdLabel.appendChild(qzRequire);
    qzrdLabel.setAttribute("class","label_rd");
    col32.appendChild(qzrdLabel);

    var qzItemInput = document.createElement("INPUT");
    qzItemInput.setAttribute("id", itemID);
    qzItemInput.setAttribute("type","text");
    qzItemInput.setAttribute("name","choice1");
    qzItemInput.setAttribute("class","text_box_rd");
    qzItemInput.setAttribute("size",30);
    qzItemInput.setAttribute("maxlength",2048);
    col33.appendChild(qzItemInput);

    row3.appendChild(col31);
    row3.appendChild(col32);
    row3.appendChild(col33);
    row3.setAttribute('class','rc_row'+rowNo);
    //三行終わり

    //四行
    var col41 = document.createElement('td');
    var col42 = document.createElement('td');
    var col43 = document.createElement('td');
    var itemID = "choice"+rowNo+"_"+(idx+1);

    col41.style.width="20px";

    var qzrdLabel = document.createElement("LABEL");
    var rdLabel = document.createElement("LABEL");
    var qzRadio = document.createElement("INPUT");
    qzRadio.setAttribute("type", "radio");
    qzRadio.setAttribute("id", rowNo);
    qzRadio.setAttribute("value", "c2" );
    qzRadio.setAttribute("name", "rchoice"+rowNo );
    rdLabel.innerHTML = " c2";
    var qzRequire = document.createElement("SPAN");
    qzRequire.setAttribute("class", "required");
    qzRequire.innerText = "※";

    qzrdLabel.appendChild(qzRadio);
    qzrdLabel.appendChild(rdLabel);
    qzrdLabel.appendChild(qzRequire);
    qzrdLabel.setAttribute("class","label_rd");
    col42.appendChild(qzrdLabel);

    var qzItemInput = document.createElement("INPUT");
    qzItemInput.setAttribute("id", itemID);
    qzItemInput.setAttribute("type","text");
    qzItemInput.setAttribute("name","choice2");
    qzItemInput.setAttribute("class","text_box_rd");
    qzItemInput.setAttribute("size",30);
    qzItemInput.setAttribute("maxlength",2048);
    col43.appendChild(qzItemInput);

    row4.appendChild(col41);
    row4.appendChild(col42);
    row4.appendChild(col43);
    row4.setAttribute('class','rc_row'+rowNo);
    //四行終わり

    //五行
    var col51 = document.createElement('td');
    var col52 = document.createElement('td');
    var col53 = document.createElement('td');
    var itemID = "choice"+rowNo+"_"+(idx+2);

    col51.style.width="20px";

    var qzrdLabel = document.createElement("LABEL");
    var rdLabel = document.createElement("LABEL");
    var qzRadio = document.createElement("INPUT");
    qzRadio.setAttribute("type", "radio");
    qzRadio.setAttribute("id", rowNo);
    qzRadio.setAttribute("value", "c3" );
    qzRadio.setAttribute("name", "rchoice"+rowNo );
    rdLabel.innerHTML = " c3";
    qzrdLabel.appendChild(qzRadio);
    qzrdLabel.appendChild(rdLabel);
    qzrdLabel.setAttribute("class","label_rd");
    col52.appendChild(qzrdLabel);

    var qzItemInput = document.createElement("INPUT");
    qzItemInput.setAttribute("id", itemID);
    qzItemInput.setAttribute("type","text");
    qzItemInput.setAttribute("name","choice3");
    qzItemInput.setAttribute("class","text_box_rd");
    qzItemInput.setAttribute("size",30);
    qzItemInput.setAttribute("maxlength",2048);
    col53.appendChild(qzItemInput);

    row5.appendChild(col51);
    row5.appendChild(col52);
    row5.appendChild(col53);
    row5.setAttribute('class','rc_row'+rowNo);
    //五行終わり

    //六行
    var col61 = document.createElement('td');
    var col62 = document.createElement('td');
    var col63 = document.createElement('td');
    var itemID = "choice"+rowNo+"_"+(idx+3);

    col61.style.width="20px";

    var qzrdLabel = document.createElement("LABEL");
    var rdLabel = document.createElement("LABEL");
    var qzRadio = document.createElement("INPUT");
    qzRadio.setAttribute("type", "radio");
    qzRadio.setAttribute("id", rowNo);
    qzRadio.setAttribute("value", "c4" );
    qzRadio.setAttribute("name", "rchoice"+rowNo );
    rdLabel.innerHTML = " c4";
    qzrdLabel.appendChild(qzRadio);
    qzrdLabel.appendChild(rdLabel);
    qzrdLabel.setAttribute("class","label_rd");
    col62.appendChild(qzrdLabel);

    var qzItemInput = document.createElement("INPUT");
    qzItemInput.setAttribute("id", itemID);
    qzItemInput.setAttribute("type","text");
    qzItemInput.setAttribute("name","choice4");
    qzItemInput.setAttribute("class","text_box_rd");
    qzItemInput.setAttribute("size",30);
    qzItemInput.setAttribute("maxlength",2048);
    col63.appendChild(qzItemInput);

    row6.appendChild(col61);
    row6.appendChild(col62);
    row6.appendChild(col63);
    row6.setAttribute('class','rc_row'+rowNo);
    //六行終わり

    //七行
    var col71 = document.createElement('td');
    var col72 = document.createElement('td');
    var col73 = document.createElement('td');
    var itemID = "blank"+rowNo+"_"+idx;

    col71.style.width="20px";

    var bkLabel = document.createElement("LABEL");
    bkLabel.innerHTML = "A1";
    var qzRequire = document.createElement("SPAN");
    qzRequire.setAttribute("class", "required");
    qzRequire.innerText = "※";
    bkLabel.appendChild(qzRequire);
    col72.appendChild(bkLabel);

    var qzItemInput = document.createElement("INPUT");
    qzItemInput.setAttribute("id", itemID);
    qzItemInput.setAttribute("type","text");
    qzItemInput.setAttribute("name","blank1");
    qzItemInput.setAttribute("class","text_box_blank ");
    qzItemInput.setAttribute("size",30);
    qzItemInput.setAttribute("maxlength",2048);
    col73.appendChild(qzItemInput);

    row7.appendChild(col71);
    row7.appendChild(col72);
    row7.appendChild(col73);
    row7.setAttribute('class','rb_row'+rowNo);
    //七行終わり

    //八行
    var col81 = document.createElement('td');
    var col82 = document.createElement('td');
    var col83 = document.createElement('td');
    var itemID = "blank"+rowNo+"_"+(idx+1);

    col81.style.width="20px";

    var bkLabel = document.createElement("LABEL");
    bkLabel.innerHTML = "A2";
    col82.appendChild(bkLabel);

    var qzItemInput = document.createElement("INPUT");
    qzItemInput.setAttribute("id", itemID);
    qzItemInput.setAttribute("type","text");
    qzItemInput.setAttribute("name","blank2");
    qzItemInput.setAttribute("class","text_box_blank");
    qzItemInput.setAttribute("size",30);
    qzItemInput.setAttribute("maxlength",2048);
    col83.appendChild(qzItemInput);

    row8.appendChild(col81);
    row8.appendChild(col82);
    row8.appendChild(col83);
    row8.setAttribute('class','rb_row'+rowNo);
    //八行終わり

    //ボタンを行
    var col91 = document.createElement('td');
    col91.style.width="20px";
    var col92 = document.createElement('td');
    col92.style.width="75px";
    var col93 = document.createElement('td');
    col93.setAttribute("colspan","2");
    var col95 = document.createElement('td');
    col95.style.width="100px";
    var col96 = document.createElement('td');
    col96.style.width="200px";

    row9.appendChild(col91);
    row9.appendChild(col92);
    row9.appendChild(col93);
    row9.appendChild(col95);
    row9.appendChild(col96);

    //行一つ追加ボタン
    var col97 = document.createElement('td');
    var btnadd = document.createElement("INPUT");
    btnadd.setAttribute("type", "button");
    btnadd.setAttribute("id", "btn_add_"+rowNo);
    btnadd.setAttribute("value", "");
    btnadd.setAttribute("title", "追加");
    btnadd.onclick=function(){add_single_row(this,this.parentNode.parentNode.rowIndex);};
    btnadd.setAttribute("class", "btn_row_add");
    col97.setAttribute("style", "text-align:right");
    col97.appendChild( btnadd);
    row9.appendChild(col97);

    //削除ボタン
    var col98 = document.createElement('td');
    var btndelete = document.createElement("INPUT");
    btndelete.setAttribute("type", "button");
    btndelete.setAttribute("id", "btn_remove_"+rowNo);
    btndelete.setAttribute("value", "");
	btndelete.setAttribute("title", "削除");
	btndelete.onclick=function(){deleteRow(this);};
    btndelete.setAttribute("class", "btn_delete");
    col98.setAttribute("style", "text-align:right");
    col98.appendChild(btndelete);
    row9.appendChild(col98);
    //終わり

    tbody.appendChild(row1);
    tbody.appendChild(row2);
    tbody.appendChild(row3);
    tbody.appendChild(row4);
    tbody.appendChild(row5);
    tbody.appendChild(row6);
    tbody.appendChild(row7);
    tbody.appendChild(row8);
    tbody.appendChild(space1);
    tbody.appendChild(space2);
    tbody.appendChild(row9);
    table.appendChild(tbody);

    //追加クイズアイテム情報のタイプを4選択と表示
    changeSelectValue("sflag",rowNo);
}

//クイズタイプの設定
function createTypeNameList(element) {

    var opt = document.createElement('option');
    opt.value = "";
    for(var i= 0; i < arrTypeNameList.length ; i++) {
        var opt = document.createElement('option');
        opt.value = arrTypeNameList[i].type;
        opt.innerHTML = arrTypeNameList[i].name;
        element.appendChild(opt);
    }
}

//クイズタイプ選択処理
function changeSelectValue(elem,rno) {

 var type="";var idx=rno;

 //rno is '0' for initial(loading document)stage. Other states have their own rno.
 if(rno == 0 || elem !="sflag"){
    var type = elem.options[elem.selectedIndex].value;
    var str = elem.id;
    var num = str.replace(/[^0-9]/g, '');
    idx = parseInt(num,10);
 }

  if (type == "001" || type=="") {
    //hide 穴埋め
   var rb_row = document.getElementsByClassName("rb_row"+idx);
   for(var i = 0; i < rb_row.length; i++){
    	document.getElementsByClassName('rb_row'+idx)[i].style.display = "none";
   }
   //show　選択
   if(rno != 0){
	   var rc_row = document.getElementsByClassName("rc_row"+idx);
	   for(var i = 0; i < rc_row.length; i++){
		   document.getElementsByClassName('rc_row'+idx)[i].style.display = "";
	   }
    }
　 }
  else {
	//hide 選択
    var rc_row = document.getElementsByClassName("rc_row"+idx);
    for(var i = 0; i < rc_row.length; i++){
    	document.getElementsByClassName('rc_row'+idx)[i].style.display="none";
    }
    //show 穴埋め
    var rb_row = document.getElementsByClassName("rb_row"+idx);
    for(var i = 0; i < rb_row.length; i++){
    	document.getElementsByClassName('rb_row'+idx)[i].style.display = "";
    }
   }
}

// formのデータを取得する
function insertListData() {

    var homeDir = $('#home_dir').val();
    var table = document.getElementById("new_form");
    var listIndex=1;
    //クイズアイテム情報リスト
    var qzItemsList=[];
    $('#new_form tbody').each(function(){
		
        qzItemsList.push({
                "qz_content":document.getElementById("txtarea_"+listIndex).value.replace(/[\n]/g, '\\n'),
                "qz_type":document.getElementById("qztype_no_"+listIndex).value,
                "qz_mark":document.getElementById("txt_mark_"+listIndex).value,

      });

     listIndex++;

   });
    var jsonString = JSON.stringify(qzItemsList);
    document.getElementById("arrTypeNameList").value = jsonString;

	//クイズオプションリスト

	//4選択リスト
	var rbList=[];var bkList=[];
	rbList = getItemOptionListrb();
	var jsonString1 = JSON.stringify(rbList);
	document.getElementById("arrTypeNameList1").value = jsonString1;
	
	console.log(jsonString1);

	//穴埋めリスト
	bkList = getItemOptionListbk();
	var jsonString2 = JSON.stringify(bkList);
    document.getElementById("arrTypeNameList2").value = jsonString2;

	$("#main_form").submit();

}

//4選択リストの設定
function getItemOptionListrb(){

	var qzOptionsListrb=[];
     $('#new_form tbody').each(function(){
    	var str = $(this).attr("id");
    	var num = str.replace(/[^0-9]/g, '');

    	//r；クイズアイテムNo、indx；クイズアイテム順番
        var r = parseInt(num,10);
        var indx = 1;
        var selected = document.getElementById("qztype_no_"+r).value;
        if(selected=="001"){
		var radios =  document.getElementsByName('rchoice'+r);

		$('.rc_row'+r).each(function(){
			var ename = 'choice'+r+"_"+indx;
			var e=document.getElementById(ename);
			var chkvalued=0;

			if(e.value != ""){

				if(radios[indx-1].checked){chkvalued = 1;}
				
				var opt_content = e.value.replace(/[\t]/g, '');
				
				qzOptionsListrb.push({

					"qzItemNo":r,
					"content":opt_content,
					 "cflag":chkvalued
					});
			}
			indx++;
		});
     }
	});
	return qzOptionsListrb;
}

//穴埋めリストの設定
function getItemOptionListbk(){

	var qzOptionsListbk=[];
	$('#new_form tbody').each(function(){
    	var str = $(this).attr("id");
    	var num = str.replace(/[^0-9]/g, '');
    	//r；クイズアイテムNo、indx；クイズアイテム順番
        var r = parseInt(num,10);
        var indx2 =1;var chkvalued=1;

        var selected = document.getElementById("qztype_no_"+r).value;
        if(selected=="002"){
		$('.rb_row'+r).each(function(){
			var ename = 'blank'+r+"_"+indx2;
			var e=document.getElementById(ename);


			if(e.value!=""){
			if(indx2==1){chkvalued = 1;}
			qzOptionsListbk.push({

				"qzItemNo":r,
                "content":e.value,
                "cflag":chkvalued
          });}

			indx2++;
			chkvalued=0;
		});
        }
	});
	return qzOptionsListbk;
}

//削除ボタン処理
function deleteRow(btn_del) {

	var str = btn_del.id;
	var num = str.replace(/[^0-9]/g, '');
    var rowNo = parseInt(num,10);
	var tbodyLength= $('#new_form tbody').length;
	var current_tbody=1;

	 $('#new_form tbody').each(function(){
      if(current_tbody==rowNo && tbodyLength >1){
    	 $(this).remove();
      }

      current_tbody++;
  });
	 renameRows();
}

//SLPP
//削除後、順番ソート
function renameRows(){

	var index=1;

	var table=document.getElementById("new_form");


	var tbodyIndex= [].slice.call(table.tBodies);

	$('#new_form tbody').each(function(){

		//クイズNoリネーム
	     this.rows[0].cells[0].innerHTML=index+'.';

	    //4選択と穴埋めボックスリネーム
	  	var bodyIndex=tbodyIndex[index-1].id;
		var count = $('#'+bodyIndex).children().length;
		var idx=1;　//ループ
		//eidx；行順番、cidx；4選択順番、bidx；穴埋め順番
		var eidx = 1;var cidx=1;var bidx=1;

	      for(var idx = 2;idx < count-1; idx++){

	    	  if(typeof( $(this).find("tr").eq(idx).attr("class"))!="undefined"){
	    		  var strText=$(this).find("tr").eq(idx).attr("class");
		    	  var rText = strText.substring(0, 6);
		    	  if(rText=="rc_row"){
		    		  $(this).find("tr").eq(idx).attr("class", "rc_row"+index);
		    		  $(this).find('input[type="text"]').eq(eidx).attr("id","choice"+index+"_"+cidx);
		    		  $(this).find('input[type="radio"]').eq(eidx-1).attr("name","rchoice"+index);
		    		  eidx++;cidx++;
		    	  }else{
		    		$(this).find("tr").eq(idx).attr("class", "rb_row"+index);
                    $(this).find('input[type="text"]').eq(eidx).attr("id","blank"+index+"_"+bidx);
                    eidx++;bidx++;
		    	  }
		    }
	     }

		 $(this).find('input[type="button"] ').eq(0).attr("id","btn_add_"+index);
		 $(this).find('input[type="button"] ').eq(1).attr("id","btn_remove_"+index);

		 $(this).find('select').attr("id","qztype_no_"+index);

		 $(this).find('textarea').attr("id","txtarea_"+index);
		 $(this).find('input[type="text"]').eq(0).attr("id","txt_mark_"+index);

		 $(this).attr("id","tbody"+index);

	     index++;
	});
}

//戻る処理
function doBack(quiz_info_no,screen_mode, action,uid) {

	var menuOpen = document.getElementById('menuOpen').value;
    var menuStatus = document.getElementById('menuStatus').value;
	var $form = $('<form/>', {
		'action' : action,
		'method' : 'post'
	});
	$form.append($('<input/>', {
		'type' : 'hidden',
		'name' : 'quiz_info_no',
		'value' : quiz_info_no
	}));
	$form.append($('<input/>', {
		'type' : 'hidden',
		'name' : 'screen_mode',
		'value' : screen_mode
	}));
	$form.append($('<input/>', {'type': 'hidden', 'name':'uid', 'value': uid}));
	$form.append($('<input/>', {'type': 'hidden', 'name':'menuOpen', 'value': menuOpen}));
    $form.append($('<input/>', {'type': 'hidden', 'name':'menuStatus', 'value': menuStatus}));
	$form.appendTo(document.body);
	$form.submit();
}
