<fieldset>
  <legend>目前位置：首頁 > 最新文章區</legend>
  <table style="width:95%;margin:auto">
    <tr>
      <td width="30%">標題</td>
      <td width="55%">內容</td>
      <td></td>
    </tr>
    <?php
        //計算分頁所需的各項數值，並取出資料
        $all=nums("news",['sh'=>"checked"]);
        $div=5;
        $pages=ceil($all/$div);
        $now=(!empty($_GET['p']))?$_GET['p']:1;
        $start=($now-1)*$div;

        $news=q("select * from news where sh='checked' limit $start,$div");
        foreach($news as $k => $n){
    ?>
    <tr>
      <td class="ti clo" id="ti<?=$k;?>" style="cursor:pointer"><?=$n['title'];?></td>
      <td>
        <!---------------------------------------------------
          建立兩個div並帶入js控制用的id及class，
          第一個div的內容為文章內容只取前20個字
          第二個div的內容文章的完整內容，但這個div預設不顯示
        ----------------------------------------------------->
        <div id="line<?=$k;?>" class="line"><?=mb_substr($n['text'],0,20,'utf8');?>...</div>
        <div id="all<?=$k;?>" style="display:none">
          <pre><?=$n['text'];?></pre>
        </div>

      </td>
      <td>
        <?php
        //以登入的狀態來決定要不要顯示第三欄的內容
        if(!empty($_SESSION['login'])){
          //建立一個陣列,內容為文章的id及登入的會員帳號
          $chk=[
                'news'=>$n['id'],
                'user'=>$_SESSION['login']
              ];
          //在log資料表中確認會員是否有對文章按讚的紀錄
          if(nums("log",$chk)>0){
            //如果有按讚的紀錄，則顯示的文字為收回讚，並在標籤的onclick中加入對應的資料
        ?>
        <a id="good<?=$n['id'];?>" href='#' onclick="good('<?=$n['id'];?>','2','<?=$_SESSION['login'];?>')">收回讚</a>
        <?php   
          }else{
            //如果沒有有按讚的紀錄，則顯示的文字為讚，並在標籤的onclick中加入對應的資料
        ?>
        <a id="good<?=$n['id'];?>" href='#' onclick="good('<?=$n['id'];?>','1','<?=$_SESSION['login'];?>')">讚</a>
        <?php   
          }
        }
        ?>

      </td>
    </tr>
    <?php
    } 
    ?>
    <tr>
      <td>
        <?php
        //顯示分頁的符號及頁碼
        //判斷往左的箭頭是否要印出
        if(($now-1)>0){
          echo "<a href='?do=news&p=".($now-1)."'> &lt; </a>";  //<
        }
        for($i=1;$i<=$pages;$i++){
          if($i==$now){
            //無法點擊的頁碼 而且還會放大
            echo "<span style='font-size:20px'> $i </span>";
          }else{
            //可以點擊的頁碼
            echo "<a href='?do=news&p=$i'> $i </a>";
          }
        }
        //判斷往右的箭頭是否要印出
        if(($now+1)<=$pages){
          echo "<a href='?do=news&p=".($now+1)."'> &gt; </a>";  //>
        }
      ?>
      </td>
      <td></td>
      <td></td>
    </tr>
  </table>
</fieldset>
<script>
  //利用jquery的點擊事件來觸發顯示文章詳細內容  //substr從0數到2 取出
  $(".ti").on("click", function () {
    //點擊文章標題時，取得點擊當下的dom的id值
    let id = $(this).attr("id").substr(2)

    //利用toggle()函式讓原本隱藏的div顯示，而原本顯示的則會隱藏
    $("#line" + id).toggle();
    $("#all" + id).toggle();
  })
</script>