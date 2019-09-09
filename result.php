
<fieldset>
<?php
  //根據id值來取出主題的資料內容
  $subject=find('que',$_GET['id']);

  //取得主題的票數總計
  $total=$subject['count'];
?>
                                  <!--------顯示主題文字在導航列----->
  <legend>目前位置：首頁 > 問卷調查 > <?=$subject['text'];?></legend>

  <!--------顯示主題文字----->
  <h3> <?=$subject['text'];?></h3>
  
  <!---使用ul或table都可以ul的樣式設定另外寫在css.css檔--->
  <ul id="list">
  <?php

    //根據主題的id來取得所有的選項資料
    $options=all("que",['parent'=>$_GET['id']]);

    //以迴圈來列出每一個選項
    foreach($options as $key => $opt){

      //以四捨五入方式計算選項票數與總票數的比率
      $rate=round($opt['count']/$total,2);
  ?>
    <li>

    <!--利用key值來顯示編號-->
    <div><?=($key+1) . "." . $opt['text'];?></div>

    <!--長條圖用div來呈現，長度使用計算過的比率來指定，另外乘上一個定值來控制長度的實際程式，原則上在40～60之間-->
    <div style="background:#ddd;width:<?=$rate*40;?>%;height:20px"></div>

    <!--最後呈現的是選項的票數及百分比-->
    <div><?=$opt['count'];?>票(<?=$rate*100;?>%)</div>
    </li>

  <?php
  }
  ?>
  </ul>
  <div class="ct"><button onclick="javascript:lof('?do=que')">返回</button></div>
</fieldset>