<?php
$dsn = "mysql:host=localhost;charset=utf8;dbname=complete-db02";
$pdo = new PDO($dsn, 'root', '');
session_start();


/***************************************************
 * 以日期為條件的瀏灠人次統計
 * 資料庫中必須有一個欄位用來記錄日期，當日的瀏灠人次都
 * 更新在同一筆資料中
 * 在判斷是否要更新瀏灠人次時，需要先檢查資料表中有無今天
 * 的日期，如果沒有今天的日期，則新增今天的日期。
 ***************************************************/

if(empty($_SESSION['total'])){  //先判斷session是否存在
  $chkDate=nums('total',['date'=>date("Y-m-d")]); //判斷今天日期的資料是否存在
  if($chkDate>0){

      //取出今天日期的瀏灠人次資料
      $today=find("total",['date'=>date("Y-m-d")]);
      //瀏灠人次加1
      $today['total']=$today['total']+1;
      //建立session資料
      $_SESSION['total']=$today['total'];
      //存回資料資料表
      save("total",$today);
  }else{
    //如果資料表中沒有今天日期的資料，則新增一筆今天的資料，同時把瀏灠人次設為1
      
      $today=[
          'date'=>date("Y-m-d"),
          'total'=>1
      ];

       //建立session資料
      $_SESSION['total']=1;
      save("total",$today);

  }

}
/***************************************************
 * 查詢指定條件資料的函式，參數需要table名稱及條件陣列
 * 如果條件陣列非陣列形態的話，則預設為資料id
 * 此函式預設只會回傳單筆資料，如果條件陣列可能會有多條
 * 結果資料時，則只回傳第一筆資料
 ***************************************************/
function find($table,$def){
  global $pdo;
  if(is_array($def)){
    foreach($def as $key => $val){
      $str[]=sprintf("%s='%s'",$key,$val);
    }

    //因為find()出來的資料大多會做為save()使用，因此要特別註明使用FETCH_ASSOC的方式來取得只包含欄位名稱的陣列
    //否則預設會取得有欄位名及欄位索引的陣列，會造成save()函式的錯誤。
    return $pdo->query("select * from $table where ".implode(" && ",$str)."")->fetch(PDO::FETCH_ASSOC);
  }else{
    return $pdo->query("select * from $table where id='$def'")->fetch(PDO::FETCH_ASSOC);
  }
}


/***************************************************
 * 查詢資料的函式
 * 參數需要table名稱及條件，條件以陣列形式呈現
 * 如果條件參數非陣列，則表示要取得資料表的全部資料
 * 陣列內有元素時表示只取得符合條件的資料
 * 陣列的形式為['欄位名'=>'值']
 * 多個條件時，預設以&&連結。
 ***************************************************/
function all($table,$def){
  global $pdo;
  if(is_array($def)){
    foreach($def as $key => $val){
      $str[]=sprintf("%s='%s'",$key,$val);
    }
    return $pdo->query("select * from $table where ".implode(" && ",$str)."")->fetchAll();
  }else{
    return $pdo->query("select * from $table ")->fetchAll();
  }
}


/***************************************************
 * 計算資料筆數的函式
 * 參數需要table名稱及條件，條件以陣列形式呈現
 * 如果條件參數非陣列，則表示要計算table全部的筆數
 * 陣列內有元素時表示計算符合條件的資料筆數
 * 陣列的形式為['欄位名'=>'值']
 * 多個條件時，預設以&&連結。
 ***************************************************/
function nums($table,$def){
  global $pdo;
  if(is_array($def)){
    foreach($def as $key => $val){
      $str[]=sprintf("%s='%s'",$key,$val);
    }
    return $pdo->query("select count(*) from $table where ".implode(" && ",$str)."")->fetchColumn();
  }else{
    return $pdo->query("select count(*) from $table ")->fetchColumn();
  }
}


/***************************************************
 * 通用query函式
 * 簡化pdo的指令
 * 一律以fetchAll()的方式取資料
 ***************************************************/
function q($str){
  global $pdo;
  return $pdo->query($str)->fetchAll();
}


/***************************************************
 * 刪除資料專用函式
 * 需帶入兩個參數，資料表名及刪除的條件
 * 當刪除的條件為數值時，表示刪除指定id的資料
 ***************************************************/
function del($table,$def){
  global $pdo;
  if(is_array($def)){
    foreach($def as $key => $val){
      $str[]=sprintf("%s='%s'",$key,$val);
    }
    return $pdo->exec("delete from $table where ".implode(" && ",$str)."");
  }else{
    return $pdo->exec("delete from $table where id='$def'");
  }
}


/***************************************************
 * 新增及更新資料通用函式
 * 以有無id值來判斷是要做新增還是更新的動作
 * 預設會先以find()拿到指定id的資料後，進行內容的修改再
 * 做更新進資料庫的動作
 * 利用array_keys()來取出陣列中的key值陣列
 * 利用implode()來組合陣列
 ***************************************************/
function save($table,$data){
  global $pdo;
  if(!empty($data['id'])){
    //update
    foreach($data as $key => $val){
      if($key!='id'){
        $str[]=sprintf("%s='%s'",$key,$val);
      }
    }
    return $pdo->exec("update $table set ".implode(",",$str)." where id='".$data['id']."'");
  }else{
    //insert
    return $pdo->exec("insert into $table (`".implode("`,`",array_keys($data))."`) value('".implode("','",$data)."')");
  }
}


/***************************************************
 * 頁面導向專用函式
 * 需帶入兩個參數，路徑檔名及路徑參數
 ***************************************************/
function to($page,$param){
  header("location:$page?$param");
}


?>