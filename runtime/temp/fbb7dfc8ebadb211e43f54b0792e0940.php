<?php /*a:1:{s:73:"D:\phpstudy\PHPTutorial\WWW\tp5.1\application\admin\view\login\index.html";i:1534747014;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta content="IE=10.000" http-equiv="X-UA-Compatible" />
    <title></title>
    <style>
        body{margin:0px;padding:0px;width:100%;}
        .bg{width:954px;height:504px;position:relative;margin:0 auto;top:150px;}
        .table_login{margin:0 auto;width: 280px;border: 1px solid black;padding: 20px;}
        .font{text-align: center;font-size: 20px;letter-spacing: 1px;color: #555555;font-weight: bold;line-height: 60px;}
        .td_logo img{width:40px;vertical-align:middle;margin:0 10px;}
        .td_img img{width:394px;margin:0 3px 10px 0;}
        .td_input img{vertical-align:top;}
        .kuang{margin-top: 10%;border-bottom: 1px solid #c1c1c1;}
        .input{width: 100%;height: 40px;color: #424242;text-indent: 12px;border:0;font-size: 16px;}
        .but{width: 100%;height: 40px;background-color: #5E7DEC;color: #fff;border: 0;font-size: 18px;border-radius: 3px;}
        .imgs{cursor: pointer;}
    </style>
</head>
<body>
<form id="form" method="POST" >
    <div class="bg">
        <div class="table_login">
            <div><img src="/index/img/logo.png" alt=""></div>
            <div class="font">当日管理系统</div>
            <div class="kuang">
                <input type="text" name="name" id="name" placeholder="用户名" class="input" required/>
            </div>
            <div class="kuang">
                <input type="password" name="password" placeholder="密 码" class="input" required />
            </div>
            <div class="kuang">
                <input type="text" name="code" placeholder="验证码" class="input" required />
            </div>
            <div class="imgs"><?php echo captcha_img(); ?>看不清，换一张</div>
            <div style="margin-top: 15%;"><button class="but">登 录</button></div>
        </div>
    </div>
    <input type="hidden" name="__hash__" value="<?php echo htmlentities(app('request')->token()); ?>" />
    <script src="https://cdn.bootcss.com/jquery/2.2.3/jquery.min.js"></script>
    <script>
      $('.imgs').click(function () {
        var url=$(this).find('img').attr('src');
        var a=Math.random();
        $(this).find('img').attr('src',url+'?a='+a);
      })
    </script>
</form>
</body>
</html>
