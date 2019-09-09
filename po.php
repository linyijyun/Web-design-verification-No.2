<div>目前位置：首頁 > 分類網誌 > <span id="nav">健康新知</span></div>
<fieldset style="width:20%;display:inline-block;vertical-align:top">
  <legend>網誌分類</legend>
  <ul style="list-style-type:none;padding:0">
    <!---為了方便jquery的控制，所以在分類標籤上都加上id及class--->
    <li id="type1" class="item"><a>健康新知</a></li>
    <li id="type2" class="item"><a>菸害防治</a></li>
    <li id="type3" class="item"><a>癌症防治</a></li>
    <li id="type4" class="item"><a>慢性病防治</a></li>
  </ul>
</fieldset>
<fieldset style="width:70%;display:inline-block">
  <legend>文章列表</legend>
  <!--這邊建立兩個div，一個用來放置文章標題列表，一個用來放文章詳細內容-->
  <div id="list"></div>
  <div id="text"></div>
</fieldset>
<script>
//宣告一個全域變數article用來存放分類的文章內容
let article;

//先執行一次getList(1)來取得分類項目健康新知的文章列表
getList(1);

//建立對分類項目(class='item')的點擊監聽事件及行為
$(".item").on("click",function(){
  //取得點擊當下的dom的內容(即分類項目文字)
  let str=$(this).text();

  //將取得的分類項目文字放到導覽列中
  $("#nav").html(str)

  //取得點擊當下的dom的id值(即分類項目代號)
  let type=$(this).attr("id").substr(4,1);

  //執行取得文章列表的函式getList()
  getList(type)
  
})

//取得文章列表函式
function getList(type){

  //以post的方式將分類項目代號傳至api.php?do=getList
  $.post("api.php?do=getList",{type},function(res){ 

    //將回傳的json字串解析成為json物件並指定給全域變數article
    article=JSON.parse(res)
    //console.log(article)

    //宣告一個字串變數list用來存放列表的內容
    let list="";
    article.forEach(function(val,idx){

      //以迴圈方式來取得article中的每個項目內容並組成畫面顯示需要的html內容
      list=list+`<div><a href="javascript:showPost(${idx})">${val.title}</a></div>`;
    })

    //將文章詳細內容的div先隱藏
    $("#text").hide();

    //將list變數放入到id=list的div中
    $("#list").html(list);

    //將id=list的div顯示出來
    $("#list").show();

  })
}

//顯示詳細文章內容
function showPost(idx){
  //根據傳入的索引值，從全域變數article中取得文章的詳細內容  //<pre>自動斷行
  let post="<pre>"+article[idx].text+"</pre>"

  //先將文章列表的list隱藏
  $("#list").hide()

  //將詳細內容放到id=text的div內容
   $("#text").html(post)

   //將id=text的div顯示出來
   $("#text").show()
}

</script>