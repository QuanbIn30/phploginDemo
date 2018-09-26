<?php

// 显示所有的错误
error_reporting(E_ALL & ~E_NOTICE );
// 连接mysql数据库
$link = mysqli_connect('localhost','root', '12345678');
if (!$link) {
 echo "connect mysql error!";
 exit();
}
// 选中数据库 news为数据库的名字
$db_selected = mysqli_select_db($link, 'news');
if (!$db_selected) {
 echo "<br>selected db error!";
 exit();
}
// 设置mysql字符集 为 utf8
$link->query("set names utf8");

$sql = "SELECT `id`, `category_id`, `title`, `content`, `tag`, `author`, `is_published`, `pic`, `created_at` FROM `new` WHERE 1"; // 查询语句
$result = mysqli_query($link, $sql);
$arr_news = mysqli_fetch_array($result, MYSQLI_ASSOC);

//新闻分类
$sql = "select * from new_category ";
$result = mysqli_query($link, $sql);
$new_category = mysqli_fetch_array($result, MYSQLI_ASSOC);
$new_category_value = array();
foreach($new_category as $val ){
 $new_category_value[$val['id']] = $val['category'];
}


?>

<!DOCTYPE html>
<html lang="zh-cn">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
 <meta name="renderer" content="webkit">
 <title></title>
 <link rel="stylesheet" href="css/pintuer.css">
 <link rel="stylesheet" href="css/admin.css">
 <script src="js/jquery.js"></script>
 <script src="js/pintuer.js"></script>
</head>
<body>
<form method="get" action="" id="listform">
 <div class="panel admin-panel">
 <div class="panel-head">
 	<strong class="icon-reorder"> 内容列表</strong>
 	<a href="" style="float:right; display:none;">添加字段</a></div>
 <div class="padding border-bottom">
 <ul class="search" style="padding-left:10px;">
 <li> <a class="button border-main icon-plus-square-o" href="news_add.php"> 添加内容</a> </li>
 <if condition="$iscid eq 1">
 <li>
 <select name="category_id" class="input" style="width:200px; line-height:17px;" onchange="changesearch()">
 <option value="">-请选择-</option>
 <?php
 foreach( $new_category_value as $key => $val );
 ?>
 <option value="<?php echo $key;?>" <?php if($_GET['category_id']==$key) echo "selected";?>><?php echo $val;?></option>
 </select>
 </li>
 </if>
 <li>
 <input type="text" placeholder="请输入搜索关键字" name="keywords" class="input" style="width:250px; line-height:17px;display:inline-block" />
 <a href="javascript:void(0)" class="button border-main icon-search" onclick="changesearch()" > 搜索</a>
</li>
 </ul>
 </div>
 <table class="table table-hover text-center">
 <tr>
 <th width="100" style="text-align:left; padding-left:20px;">ID</th>
 <th>分类名</th>
 <th>标题</th>
 <th>内容</th>
 <th>关键字</th>
 <th>图片</th>
 <th>作者</th>
 <th width="10%">更新时间</th>
 <th width="310">操作</th>
 </tr>
 <?php
 if($arr_news){
 foreach ($arr_news as $val){
 echo "<tr>";
 echo " <td style='text-align:left; padding-left:20px;'>
 <input type='checkbox' name='id[]' value='' />{$val['id']}</td>";
 echo "<td>{$new_category_value[$val['id']]}</td>";
 echo "<td>". mb_substr($val['title'], 0,15,"utf-8")."</td>";
 echo "<td>". mb_substr($val['content'], 0,20,"utf-8")."</td>";
 echo "<td>{$val['tag']}</td>";

 if($val['pic']){
 //echo "<td ><img src='{$val[pic]}' style='width: 50px; height: 50px'></td>";
 echo "这是替代图片";
 }else{
 echo "<td>暂无图片</td>";
 }
 echo "<td>{$val[author]}</td>";
 echo "<td>{$val[created_at]}</td>";
 ?>
 <td>
 <div class='button-group'> 
 <a class='button border-main' href='new_edit.php?id=<?php echo $val['id'];?>'>
 <span class='icon-edit'></span> 修改</a>
 <a class='button border-red' href='javascript:;' onclick='return del(<?php echo $val['id']?>)'>
 <span class='icon-trash-o'></span> 删除</a> 
 </div>
 </td>
 <?
 echo "</tr>";
 }
 }
 ?>

 <tr>
 <td style="text-align:left; padding:19px 0;padding-left:20px;">
 <input type="checkbox" id="checkall"/>
 全选 </td>
 <td colspan="8" style="text-align:left;padding-left:20px;">
 <a href="javascript:void(0)" class="button border-red icon-trash-o" style="padding:5px 15px;" onclick="DelSelect()"> 删除</a>
 移动到：
 <select name="movecid" style="padding:5px 15px; border:1px solid #ddd;" onchange="changecate(this)">
 <option value="">请选择分类</option>
 <option value="">产品分类</option>
 <option value="">产品分类</option>
 <option value="">产品分类</option>
 <option value="">产品分类</option>
 </select>
 </td>
 </tr>








 <!--


 <tr>

 <td colspan="8">
 <div class="pagelist">
 <a href="new_list.php">首页</a>
 <?php
 if( $page > 1 ){
 ?>
 <a href="new_list.php?page=<?php echo $pre_page;?>">上一页</a>
 <?
 }
 if( $page < $max_page ){
 ?>
 <a href="new_list.php?page=<?php echo $next_page;?>">下一页</a>
 <?
 }
 ?>
 <a href="new_list.php?page=<?php echo $max_page;?>">末页</a>
 / 总页码 <font color="red"><?php echo $max_page;?></font>页 当前页码 <font color="red"><?php echo $page;?></font>页
 </div>
 </td>
 </tr>
 </table>
 </div>
</form>
<script type="text/javascript">

 //搜索
 function changesearch(){

 }

 //单个删除
 function del(id){
 if(confirm("您确定要删除吗?")){
 document.location.href = "new_delete.php?id=" + id ;
 }
 }

 //全选
 $("#checkall").click(function(){
 $("input[name='id[]']").each(function(){
 if (this.checked) {
 this.checked = false;
 }
 else {
 this.checked = true;
 }
 });
 })

 //批量删除
 function DelSelect(){
 var Checkbox=false;
 $("input[name='id[]']").each(function(){
 if (this.checked==true) {
 Checkbox=true;
 }
 });

 //单个删除
 if (Checkbox){
 var t=confirm("您确认要删除选中的内容吗？");
 if (t==false) return false;
 $("#listform").submit();
 }
 else{
 alert("请选择您要删除的内容!");
 return false;
 }
 }

 //批量排序
 function sorts(){
 var Checkbox=false;
 $("input[name='id[]']").each(function(){
 if (this.checked==true) {
 Checkbox=true;
 }
 });
 if (Checkbox){

 $("#listform").submit();
 }
 else{
 alert("请选择要操作的内容!");
 return false;
 }
 }


 //批量首页显示
 function changeishome(o){
 var Checkbox=false;
 $("input[name='id[]']").each(function(){
 if (this.checked==true) {
 Checkbox=true;
 }
 });
 if (Checkbox){

 $("#listform").submit();
 }
 else{
 alert("请选择要操作的内容!");

 return false;
 }
 }

 //批量推荐
 function changeisvouch(o){
 var Checkbox=false;
 $("input[name='id[]']").each(function(){
 if (this.checked==true) {
 Checkbox=true;
 }
 });
 if (Checkbox){


 $("#listform").submit();
 }
 else{
 alert("请选择要操作的内容!");

 return false;
 }
 }

 //批量置顶
 function changeistop(o){
 var Checkbox=false;
 $("input[name='id[]']").each(function(){
 if (this.checked==true) {
 Checkbox=true;
 }
 });
 if (Checkbox){

 $("#listform").submit();
 }
 else{
 alert("请选择要操作的内容!");

 return false;
 }
 }


 //批量移动
 function changecate(o){
 var Checkbox=false;
 $("input[name='id[]']").each(function(){
 if (this.checked==true) {
 Checkbox=true;
 }
 });
 if (Checkbox){

 $("#listform").submit();
 }
 else{
 alert("请选择要操作的内容!");

 return false;
 }
 }

 //批量复制
 function changecopy(o){
 var Checkbox=false;
 $("input[name='id[]']").each(function(){
 if (this.checked==true) {
 Checkbox=true;
 }
 });
 if (Checkbox){
 var i = 0;
 $("input[name='id[]']").each(function(){
 if (this.checked==true) {
 i++;
 }
 });
 if(i>1){
 alert("只能选择一条信息!");
 $(o).find("option:first").prop("selected","selected");
 }else{

 $("#listform").submit();
 }
 }
 else{
 alert("请选择要复制的内容!");
 $(o).find("option:first").prop("selected","selected");
 return false;
 }
 }

</script>
</body>
</html>
