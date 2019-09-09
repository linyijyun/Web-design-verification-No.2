<?php
include_once "base.php";

$do=(!empty($_GET['do']))?$_GET['do']:"";
switch($do){
  case "reg":
  //註冊會員

    //取得post傳過來的值
    $acc=$_POST['acc'];
    $pw=$_POST['pw'];
    $email=$_POST['email'];

    //檢查資料表是否已經存在該帳號
    $chkAcc=nums("user",['acc'=>$acc]);

    if($chkAcc>0){
      //帳號己存在時回傳0
      echo 0;
    }else{

      //新增資料的陣列
      $data=[
        'acc'=>$acc,
        'pw'=>$pw,
        'email'=>$email
      ];

      //新增資料
      save("user",$data);

      //回傳1代表新增註冊成功
      echo 1;
    }
  
  break;
  case "login":
    //登入判斷

    //取得post過來的值
    $acc=$_POST['acc'];
    $pw=$_POST['pw'];     

    //檢查資料表中是否有符合的帳號
    $chkAcc=nums("user",['acc'=>$acc]);

    if($chkAcc>0){

      //資料表中有符合的帳號時，進一步檢查密碼是否正確
      $chkPass=nums("user",['acc'=>$acc,'pw'=>$pw]);
      if($chkPass>0){

        //帳密都正確時，建立一個session來存放帳號
        $_SESSION['login']=$acc;

        //進一步判斷登入的帳號是否為管理者admin
        if($acc=='admin'){

          //登入者為管理者時回傳1
          echo 1;
        }else{

          //登入者為一般會員時回傳2
          echo 2;
        }
      }else{

        //密碼錯誤時回傳3
        echo 3;
      }

    }else{

      //帳號不存在時回傳4
      echo 4;
    }

  break;
  case "forget":
    //找回密碼

    //取得post傳過來的email
    $email=$_POST['email'];

    //檢查該email是否存在
    $chkEmail=nums("user",['email'=>$email]);
    if($chkEmail>0){

      //如果email的資料存在，則取得該筆資料中的密碼並回傳
      echo "您的密碼為：" . find("user",['email'=>$email])['pw'];
    }else{

      //如果資料表中不存在該筆email，則回傳查無資料
      echo "查無此資料";
    }

  break;
  case "getList":
  //分類網誌中取得分類文章

    //取得post過來的分類值
    $type=$_POST['type'];

    //依據分類值(type)，取出該分類的所有文章
    $news=all("news",['type'=>$type]);

    //建立一個文章列表的陣列
    foreach($news as $n){
      $data[]=[
        'id'=>$n['id'],
        'title'=>$n['title'],
        'text'=>$n['text']
      ];
    }

    //以json格式回傳文章列表
    echo json_encode($data);

  break;
  case "adUser":
  //會員管理

    //判斷是否有會員需要刪除
    if(!empty($_POST['del'])){
      foreach($_POST['del'] as $id){

        //執行刪除會員
        del("user",$id);
      }
    }
    to("admin.php","do=user");
  break;
  case "editNews":
  //最新文章管理

    //依迴圈逐一檢查每個post過來的id是否需要刪除或是更改顯示狀態
    foreach($_POST['id'] as $key => $id){

      //先檢查$_POST['del']是否存在，如果$_POST['del']存在
      //則進一步檢查$_POST['del']陣列中是否有需要刪除的文章id
      if(!empty($_POST['del']) && in_array($id , $_POST['del'])){
        del("news",$id);
      }else{

        //取出該id的文章資料
        $data=find("news",$id);

        //依據$_POST['sh']陣列是否存在文章id來決定是否要更新文章的顯示狀態
        $data['sh']=(in_array($id,$_POST['sh']))?"checked":"";

        //回存資料
        save("news",$data);
      }
    }
    to("admin.php","do=news");
  break;
  case "newQue":
  //新增問卷

    //取得表單傳過來的主題及選項
    $subject=$_POST['subject'];
    $options=$_POST['opt'];

    //先將主題存入資料庫  (只存入標題名稱)
    save("que",['text'=>$subject]);

    //取得主題存入資料庫後的id  有兩種方式可以取得id  //第0個欄位第0行
    $parent=q("select max(`id`) from que")[0][0];  
    //$parent=find("que",['text'=>$subject])['id'];

    //以迴圈方式將選項逐入存入資料表，並帶入主題的id
    foreach($options as $opt){
      save("que",['text'=>$opt,'parent'=>$parent]);      //'parent'欄位塞入$parent值(上面得到的id值)
    }

    to("admin.php","do=que");
  break;
  case "vote";
  //投票統計
    
  //根據表單傳來的選項id取出該選項的資料
  $vote=find("que",$_POST['opt']);
  
  /*
    //將選項中的count欄位加1後回存即可完成投票的統計
    $vote['count']++;
    save("que",$vote);

    //根據選項的parent欄位來取出主題的資料
    $subject=find("que",$vote['parent']);

    //將主題的count欄位加1後回存即可同時完成主題的統計
    $subject['count']++;
    save("que",$subject); */
    
    //分別取得選項的id 及主題的id
    $id=$_POST['opt'];
    $parent=$vote['parent'];

    //利用sql語法中的IN()指令同時對兩筆資料進行count欄位加1的動作
    $sql="update que set count=count+1 where id in($id,$parent)";
    $pdo->exec($sql);

    to("index.php","do=result&id=$parent");
  case "good":
  //按讚紀錄

    //取得post過來的資料
    $id=$_POST['id'];
    $type=$_POST['type'];
    $user=$_POST['user'];

    //根據type的狀態來決定要進行按讚還是收回讚的動作
    if($type==1){
      //按讚->新增log,文章按讚數加1

      //將文章id及登入的會員帳號以新增的方式存入log資料表
      save("log",['news'=>$id,'user'=>$user]);

      //取出文章的資料
      $news=find("news",$id);

      //將文章的按讚數加1後回存
      $news['good']++;
      save("news",$news);

    }else{
      //收回讚->刪除log,文章按讚數減1

      //將文章id及登入的會員帳號由log資料表中刪除
      $log=find("log",['news'=>$id,'user'=>$user]);
      del("log",$log['id']);
      //del("log",['news'=>$id,'user'=>$user]);

      //取出文章的資料
      $news=find("news",$id);

      //將文章的按讚數減1後回存
      $news['good']--;
      save("news",$news);
      
    }

  break;

}


?>