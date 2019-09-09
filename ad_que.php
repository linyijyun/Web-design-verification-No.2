<fieldset>
  <legend>新增問卷</legend>
  <form action="api.php?do=newQue" method="post">
    <table style="width:80%">
      <tr>
        <td class="clo">問卷名稱</td>
        <td><input type="text" name="subject"></td>
      </tr>
      <!---在指定的DOM標籤上建立一個id--->
      <!-- 新增html標籤的位置 -->
      <tr class="clo" id="more">
        <td colspan="2">
          選項 <input type="text" name="opt[]" style="width:500px">
                                    <!---點擊更多按鈕時會觸發moreOpt()函式---->
              <input type="button" value="更多" onclick="moreOpt()">
          </td>
  
      </tr>
      <tr>
        <td colspan="2">
          <input type="submit" value="新增"> | <input type="reset" value="清空">
        </td>
      </tr>
    </table>
  </form>

</fieldset>
<script>
//更多選項功能函式
function moreOpt(){
  //建立一個html的語法字串
  let opt=`<tr class="clo">
            <td colspan="2">
              選項 <input type="text" name="opt[]"  style="width:500px">
            </td>
           </tr>`
  //將字串內容插入到id more的位置前面
  $("#more").before(opt)

  /*******************************************************
   * //另一個類似的做法
   * let opt=`選項 <input type="text" name="opt[]" ><br>`
   * //用prepend將字串插入到指定的容器內部最前面的位置
   * $("#more").prepend(opt)
   ******************************************************/
}
</script>