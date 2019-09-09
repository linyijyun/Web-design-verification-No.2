<fieldset style="width:50%;padding:20px;margin:auto;">
    <legend>會員登入</legend>
    <form>
      <table>
        <tr>
          <td>帳號</td>
          <td><input type="text" name="acc" id="acc"></td>
        </tr>
        <tr>
          <td>密碼</td>
          <td><input type="password" name="pw" id="pw"></td>
        </tr>
        <tr>
          <!---因為要使用ajax的方式來傳送資料，所以將submit改成button，並增加onclick事件去觸發login()函式-->
          <td><input type="button" value="登入" onclick="login()"><input type="reset" value="清除"></td>
          <td class='r'>
            <a href="?do=forget">忘記密碼</a>
            <a href="?do=reg">尚未註冊</a>
  
          </td>
        </tr>
      </table>
    </form>

</fieldset>
<script>
//登入專用函式

function login(){

  //先取得表單輸入的內容
  let acc=$("#acc").val();
  let pw=$("#pw").val();

  //以post的方式傳送帳號及密碼到api.php?do=login
  $.post("api.php?do=login",{acc,pw},function(x){
    
    //根據回傳值x來決定要進行的動作
    switch(x){
      case "1":
        //管理者登入成功，導向後台管理頁面
        location.href="admin.php";
        // lof("admin.php");   一樣
      break;
      case "2":
        //一般使用者登入成功，導向首頁
        location.href="index.php"
      break;
      case "3":
        //密碼錯誤，彈出提示訊息
        alert("密碼錯誤")

        //清空表單輸入欄
        $("#acc,#pw").val("")
      break;
      case "4":
        //查無帳號，彈出提示訊息
        alert("查無帳號")

        //清空表單輸入欄
        $("#acc,#pw").val("")
      break;
    }
  })
}

</script>