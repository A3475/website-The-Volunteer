<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>登录</title>
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link href="../assets/style.css" rel="stylesheet">
    <script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript"> 
    function countDown(secs,surl){ 
      var jumpTo = document.getElementById('jumpTo');
      jumpTo.innerHTML=secs; 
      if(--secs>0){ 
       setTimeout("countDown("+secs+",'"+surl+"')",1000); 
      }
      else
      {  
       location.href=surl; 
      } 
    } 
  </script>
  </head>
  
  <body>
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">The volunteer</a></div>
        <ul class="nav navbar-nav">
          <li class="active">
            <a href="">首页</a></li>
          <li>
            <a href="">关于</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li>
            <a href="login.php">登录</a></li>
          <li>
            <a href="reg.php">注册</a></li>
          <li>
            <a href="">z3475</a></li>
        </ul>
      </div>
    </nav>
  <div class="container">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <div class="form-group">
              <label for="exampleInputEmail1">智学网账号</label>
              <input type="text" class="form-control" id="exampleInputEmail1" placeholder="智学网账号" name="n">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">智学网密码</label>
              <input type="password" class="form-control" id="exampleInputPassword1" placeholder="智学网密码" name="p">
            </div>
          <button type="submit" class="btn btn btn-primary">登录</button>
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
          if ($_POST["n"]==''){
            echo "<p class=\"text-danger\">";
            echo "用户名没有填写";
            echo "</p>";
          }else
          if ($_POST['p']==''){
            echo "<p class=\"text-danger\">";
            echo "密码没有填写";
            echo "</p>";
          }else
          if (!preg_match("/[^\d-., ]/",$_POST["n"])){
            require_once './do.php';
            $db = new DBConnection();
            $con = $db->connect();
            if ($db->isStore($_POST["n"],$con)){
			  if ($db->check($_POST["n"],$_POST["p"],$con)){
				$db->setCookies($db->getToken($_POST["n"],$con));
				header("Location: http://47.104.0.124/vol/person.php");
				exit;
			  }else{
				echo "<p class=\"text-danger\">";
				echo "用户名或密码错误。";
				echo "</p>";
			  }
            }else
            if (!$db->isInQueue($_POST["n"],$con)){
              echo "<p class=\"text-danger\">";
              echo "本用户没有注册!";
              echo "</p>";
            }else{
              echo "<p class=\"text-danger\">";
              echo "此用户正在验证中,请稍候。";
              echo "</p>";
            }
          }else
          {
           echo "<p class=\"text-danger\">";
           echo "用户名只允许数字!";
           echo "</p>";
          }
        }
        ?>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
  <footer>
      <small>
        Made by z3475
        Use Bootstrap
        <p>
          本项目前端和后端代码开源托管在<a herf="https://github.com/A3475/website-The-Volunteer">Github</a>
        </p>
      </small>
  </footer>
</div>
  </body>

</html>