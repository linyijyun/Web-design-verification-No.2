<style>
  /*彈出視窗的css設定*/
  .more {
    background: rgba(51, 51, 51, 0.8);
    color: #FFF;
    min-height: 100px;
    width: 300px;
    position: fixed;
    display: none;
    z-index: 9999;
    overflow: auto;
    display:none;
  }
</style>
<fieldset>
  <legend>目前位置：首頁 > 人氣文章區</legend>
  <table style="width:95%;margin:auto">
    <tr>
      <td width="30%">標題</td>
      <td width="50%">內容</td>
      <td></td>
    </tr>
    <?php
//建立分類文字陣列
$typeStr=[
  1=>"健康新知",
  2=>"菸害防治",
  3=>"癌症防治",
  4=>"慢性病防治"
  ];

    //計算分頁需要的各項數值，並取得所需的文章資料
    $all=nums("news",['sh'=>"checked"]);
    $div=5;
    $pages=ceil($all/$div);
    $now=(!empty($_GET['p']))?$_GET['p']:1;
    $start=($now-1)*$div;

    $news=q("select * from news where sh='checked' order by good desc limit $start,$div");
    foreach($news as $k => $n){

?>
    <tr>
      <td class="ti clo" id="ti<?=$k;?>" style="cursor:pointer"><?=$n['title'];?></td>
      <td>
        <!---建立兩個div，一個用來放文章首行縮略，一個用來放完整文章內容--->
        <div id="line<?=$k;?>" class="line"><?=mb_substr($n['text'],0,20,'utf8');?>...</div>
        <div id="all<?=$k;?>" class="more">
          <h3 style='color:#39dde6'><?=$typeStr[$n['type']];?></h3>
          <pre><?=$n['text'];?></pre>
        </div>

      </td>
      <td>
        <?php
        //顯示文章的按讚數，並加上js控制用的id
        echo "<span id='vie".$n['id']."'>".$n['good'] . "</span>個人說<img src='./icon/02B03.jpg' style='width:20px'>";

        //根據登入狀態來決定是否顯示按讚功能
        if(!empty($_SESSION['login'])){
          
          //建立新增log用的資料陣列
          $chk=[
                'news'=>$n['id'],
                'user'=>$_SESSION['login']
              ];
          //如果log資料表中有按讚紀錄則顯示收回讚，反之顯示讚，並加入js控制用的id的onclick資訊    
          if(nums("log",$chk)>0){
            //收回讚
       ?>
        <a id="good<?=$n['id'];?>" href='#' onclick="good('<?=$n['id'];?>','2','<?=$_SESSION['login'];?>')">收回讚</a>
        <?php   
          }else{
            //讚
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

        //顯示分頁資訊及連結
        if(($now-1)>0){
          echo "<a href='?do=pop&p=".($now-1)."'> &lt; </a>";  //<
        }
        for($i=1;$i<=$pages;$i++){
          if($i==$now){
            echo "<span style='font-size:20px'> $i </span>";
          }else{
            echo "<a href='?do=pop&p=$i'> $i </a>";
          }
        }

        if(($now+1)<=$pages){
          echo "<a href='?do=pop&p=".($now+1)."'> &gt; </a>";  //>
        }

      ?>

      </td>
      <td></td>
      <td></td>
    </tr>
  </table>
</fieldset>
<script>
  //建立class='ti'的滑過監聽事件
  $(".ti").hover(function(){

    //滑鼠滑過.ti時，先隱藏所有其他的完整文章內容
    $(".more").hide()
    //接著顯示滑過當下的元表中的.more內容
    $(this).next().children(".more").show();
  },
  //當滑過的事件結束時，隱藏所有的完整文章內容
  function(){
    $(".more").hide()
  }
  )
</script>