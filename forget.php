<fieldset style="width:50%;padding:20px;margin:auto;">
    <legend>忘記密碼</legend>
    <form>
      <table style="width:90%">
        <tr>
          <td>請輸入信箱以查詢密碼</td>
        </tr>
        <tr>
          <td><input type="text" name="email" id="email" style="width:98%"></td>
        </tr>
        <tr>
          <!---這邊建立一個空列並在欄位中加入id=result，用來放置回傳的文字--->
          <td id="result"></td>
        </tr>
        <tr>
          <td><input type="button" value="尋找" onclick="forget()"></td>
        </tr>
      </table>
    </form>

</fieldset>
<script>

  //找回密碼專用函式
  function forget(){

    //取得表單輸入的email
    let email=$("#email").val();

    //以post的方式傳到api.php?do=forget
    $.post("api.php?do=forget",{email},function(res){

      //將回傳的內容顯示在id=result的dom中
      $("#result").html(res)

    })

  }

</script>