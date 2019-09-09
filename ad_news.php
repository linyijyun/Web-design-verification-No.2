<fieldset>
  <legend>最新文章管理</legend>
  <form action="api.php?do=editNews" method="post">
    <table class='ct'>
      <tr>
        <td width="5%">編號</td>
        <td width="70%">標題</td>
        <td width="10%">顯示</td>
        <td width="10%">刪除</td>
      </tr>
      <?php
        //計算分頁需要的各項數據並取出資料來顯示
        $all=nums("news","");
        $div=3;
        $pages=ceil($all/$div);
        $now=(!empty($_GET['p']))?$_GET['p']:1;
        $start=($now-1)*$div;
        $news=q("select * from news limit $start,$div");
        foreach($news as $k => $n){
      ?>
      <tr>
        <td class="clo"><?=($k+1+$start);?>.</td>
        <td><?=$n['title'];?></td>
        <td><input type="checkbox" name="sh[]" value="<?=$n['id'];?>" <?=$n['sh'];?>></td>
        <td><input type="checkbox" name="del[]" value="<?=$n['id'];?>"></td>
        <input type="hidden" name="id[]" value="<?=$n['id'];?>">
      </tr>
      <?php
      }
      ?>
      <tr>
        <td colspan="4">
          <?php

             if(($now-1)>0){
               echo "<a href='?do=news&p=".($now-1)."'> < </a>";  //<
             }
             for($i=1;$i<=$pages;$i++){
               if($i==$now){
                 echo "<span style='font-size:20px'> $i </span>";
               }else{
                 echo "<a href='?do=news&p=$i'> $i </a>";
               }
             }
             
             if(($now+1)<=$pages){
               echo "<a href='?do=news&p=".($now+1)."'> > </a>";  //>
             }
             
             ?>
        </td>
      </tr>
      <tr>
        <td colspan="4"><input type="submit" value="確定修改"></td>
      </tr>

    </table>
  </form>
</fieldset>