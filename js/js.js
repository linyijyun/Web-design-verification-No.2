// JavaScript Document
function lo(th,url)
{
	$.ajax(url,{cache:false,success: function(x){$(th).html(x)}})
}

//按讚的js函式
function good(id,type,user)
{
  //以post的方式將id,type,user三個參數傳送到api.php?do=good程式中
	$.post("api.php?do=good",{id,type,user},function()
	{
    //依照type值的不同來決定要對網頁上的dom做什麼事
		if(type=="1")
		{
      //找到頁面中id為vie+id的元件，並將其內容加1
      $("#vie"+id).text($("#vie"+id).text()*1+1)
      
      //找到頁面中id為good+id的元件，並將文字改為"收回讚"
      //同時將元件中的onclick屬性做修改
			$("#good"+id).text("收回讚").attr("onclick","good('"+id+"','2','"+user+"')")
		}
		else
		{
      //找到頁面中id為vie+id的元件，並將其內容減1
      $("#vie"+id).text($("#vie"+id).text()*1-1)

      //找到頁面中id為good+id的元件，並將文字改為"收回讚"
      //同時將元件中的onclick屬性做修改
			$("#good"+id).text("讚").attr("onclick","good('"+id+"','1','"+user+"')")
		}
	})
}

//JS的導航函式，將網頁導向傳入的路徑
function lof(url){
	location.href=url;
}