<fieldset>
  <legend>目前位置：首頁 > 問卷調查</legend>
  <table style="width:90%">
    <tr class='ct'>
      <td width="10%">編號</td>
      <td width="60%">問卷題目</td>
      <td width="10%">投票總數</td>
      <td width="10%">結果</td>
      <td width="10%">狀態</td>
    </tr>
    <?php
    //取得所有的問卷主題並顯示在網頁上
    $ques=all('que',['parent'=>0]);
    foreach($ques as $k => $q){

    ?>
    <tr>
      <td class="ct"><?=($k+1);?>.</td>
      <td><?=$q['text'];?></td>
      <td class="ct"><?=$q['count'];?></td>
                    <!--建立查看結果的連結並加上主題的id-->
      <td class="ct"><a href='?do=result&id=<?=$q['id'];?>'>結果</a></td>
      <td class="ct">
      <?php
      //根據登入的狀況來決定要顯示的內容
      if(empty($_SESSION['login'])){
        echo "請先登入";
      }else{
        //提供參與投票的連結並加上主題的id
        echo "<a href='?do=vote&id=".$q['id']."'>參與投票</a>";
      }

      ?>
      </td>
    </tr>
    <?php
      
    }
?>    
  </table>
</fieldset>