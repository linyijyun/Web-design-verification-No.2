<fieldset style="width:90%;margin:auto;">
  <legend>帳號管理</legend>
<form action="api.php?do=adUser" method="post">
  <table style="width:80%;margin:auto" class="ct">
    <tr class="clo">
      <td>帳號</td>
      <td>密碼</td>
      <td>刪除</td>
    </tr>
    <?php
    //取出所有的會員資料
    $users=all("user","");
    foreach($users as $u){
    ?>
    <tr>
      <!---------------------------------------------
        正常來說，admin的帳號是不可以被刪除的，
        雖然題目沒有提到，但為了避免admin的帳號被誤刪除,
        可以在讀出資料時增加判斷來略過admin帳號，
        比如在foreach內加上
        if($u['acc']!='admin'){
          //表格顯示帳號
        }
      ---------------------------------------------->
      <td><?=$u['acc'];?></td>
      <td><?=str_repeat("*",strlen($u['pw']));?></td>
      <td><input type="checkbox" name="del[]" value="<?=$u['id'];?>"></td>
    </tr>
    <?php
    }
    ?>
    <tr>
      <td colspan="3">
        <input type="submit" value="確定刪除"><input type="reset" value="清空選取">
  
      </td>
    </tr>
  </table>
</form>


<h2>新增會員</h2>  
<form>
      <table>
        <tr>
          <td colspan="2" style="color:red">*請設定您要註冊的帳號及密碼(最長12個字元)</td>
        </tr>
        <tr>
          <td>Step1:登入帳號</td>
          <td><input type="text" name="acc" id="acc" value=""></td>
        </tr>
        <tr>
          <td>Step2:登入密碼</td>
          <td><input type="password" name="pw" id="pw" value=""></td>
        </tr>
        <tr>
          <td>Step3:再次確認密碼</td>
          <td><input type="password" name="pw2" id="pw2" value=""></td>
        </tr>
        <tr>
          <td>Step4:信箱(忘記密碼時使用)</td>
          <td><input type="text" name="email" id="email" value=""></td>
        </tr>        
        <tr>
          <!----因為要使用ajax的方式來做註冊，因此把submit改成button，並用onclick來觸發註冊專用的js函式reg()--->
          <td><input type="button" value="註冊" onclick="reg()"><input type="reset" value="清除"></td>
          <td class='r'>
          </td>
        </tr>
      </table>
    </form>
</fieldset>
<script>
//註冊專用函式
function reg(){

  //取得表單的輸入內容
  let acc=$("#acc").val()
  let pw=$("#pw").val()
  let pw2=$("#pw2").val()
  let email=$("#email").val()
  //console.log(acc,pw,pw2,email)

  //先判斷有沒有任何欄位是空白的
  if(acc=="" || pw=="" || pw2=="" || email==""){

    //顯示提示訊息
    alert("不可空白")
    
  }else{

    //以post的方式傳送帳號,密碼及信箱三項資料到api.php?do=reg
    $.post("api.php?do=reg",{acc,pw,email},function(res){

      //依照回傳值來決定接下來的動作
      if(res=='1'){

        //回傳值1表示註冊成功，
        //重載一次頁面讓新增的帳號可以顯示在上方的帳號列表區
        location.reload();

      }else{

        //回傳值0表示帳號已存在，顯示提示訊息
        alert("帳號重複")
      }

    })
  }
}

</script>