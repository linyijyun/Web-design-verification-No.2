
<fieldset>
<?php
  //根據id值來取出主題的資料內容
  $subject=find('que',$_GET['id']);
?>
                                  <!--------顯示主題文字在導航列----->
  <legend>目前位置：首頁 > 問卷調查 > <?=$subject['text'];?></legend>

  <!--------顯示主題文字----->
  <h3> <?=$subject['text'];?></h3>

  <!--以表單的方式將投票的結果傳送到api.php?do=vote-->
  <form action="api.php?do=vote" method="post">
  
    <!---使用ul或table都可以，這邊直接把ul的樣式設定寫在行內--->
    <ul style="list-style-type:none;padding:0;margin:0">
    <?php

      //根據主題的id來取得所有的選項資料
      $options=all("que",['parent'=>$_GET['id']]);

        //以迴圈來列出每一個選項
      foreach ($options as  $opt) {
        
    ?>
      <li style="margin:10px 0">
        <!--因為是單選，所以使用radio button來呈現-->
        <input type="radio" name="opt" value="<?=$opt['id'];?>">

        <!--顯示選項文字 等於是echo的意思 -->    
        <?=$opt['text'];?>   
      </li>
      <?php

      }      
      ?>
    </ul>
    <div><input type="submit" value="我要投票"></div>
  </form>

</fieldset>