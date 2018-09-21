<!DOCTYPE html>
<html>
 <head>
 <title>php.cn</title>
 <meta charset="utf-8" />
 <style>
	 	.box{
	 		width:250px;
	 		height:120px;
	 		background:#f0f0f0;
	 	}
	</style>
 </head>
 <body>
 	<!-- 注册界面 register.php-->
 	 <div class="box">
	 <form action="regcheck.php" method="post"> 
	 <table>
				<tr>
					<td align="right">用户名：</td>
					<td><input type="text" name="username" value="请输入用户名" maxLength="6"/></td>
				</tr>
				<tr>
					<td align="right">密 码：</td>
					<td><input type="password" name="userpwd" maxLength="6"/></td>
				</tr>
				<tr>
					<td align="right">确认密码：</td>
					<td><input type="password" name="confirm" maxLength="6"/></td>
				</tr>
				<tr>
					<td colspa="2" align="right"><input type="Submit" name="Submit" value="注册"/></td>
				</tr>
	 		</table>
	 </form>
 </div> 
 </body>
</html>