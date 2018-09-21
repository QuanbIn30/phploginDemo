<?php  
//注册处理界面 regcheck.php
    if(isset($_POST["Submit"]) && $_POST["Submit"] == "注册")  
    {  
        $user = $_POST["username"];  
        $psw = $_POST["userpwd"];  
        $psw_confirm = $_POST["confirm"];  
        if($user == "" || $psw == "" || $psw_confirm == "")  
        {  
            echo "<script>alert('请确认信息完整性！'); history.go(-1);</script>";  
        }  
        else  
        {  
            if($psw == $psw_confirm)  
            {  
                $conn = mysqli_connect("localhost","root","12345678");   //连接数据库,帐号密码为自己数据库的帐号密码  
                if(mysqli_errno($conn)){
                    echo mysqli_error($conn);
                    exit;
                }
                mysqli_select_db($conn,"userdb");  //选择数据库  
                mysqli_set_charset($conn,'utf8'); //设定字符集  
                $sql = "select username from user where username = '$user'"; //SQL语句
                $result = mysqli_query($conn,$sql);    //执行SQL语句  
                $num = mysqli_num_rows($result); //统计执行结果影响的行数  
                
                if($num)    //如果已经存在该用户  
                {  
                    echo "<script>alert('用户名已存在'); history.go(-1);</script>";  
                }  
                else    //不存在当前注册用户名称  
                {   
                    $sql_insert = "insert into `user` (`username`,`userpwd`) values('" . $user . "','" . $psw ."')"; 
                    $res_insert = mysqli_query($conn,$sql_insert);  
                    //$num_insert = mysql_num_rows($res_insert);  
                    if($res_insert)  
                    {  
                        echo "<script>alert('注册成功！'); history.go(-1);</script>";  
                    }  
                    else  
                    {  
                        echo "<script>alert('系统繁忙，请稍候！'); history.go(-1);</script>";  
                    }  
                }  
            }  
            else  
            {  
                echo "<script>alert('密码不一致！'); history.go(-1);</script>";  
            }  
        }  
    }  
    else  
    {  
        echo "<script>alert('提交未成功！');</script>";  
    }  
?>