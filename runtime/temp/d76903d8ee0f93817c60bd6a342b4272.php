<?php /*a:1:{s:73:"D:\phpstudy\PHPTutorial\WWW\tp5.1\application\index\view\index\index.html";i:1545217877;}*/ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .fizhi{
            width: 100px;
            height: 50px;
            background: yellow;
        }
    </style>
</head>
<body>
<div class="fizhi">fizhi</div>
</body>
<script>
  document.querySelector('.fizhi').onclick=function () {
    const input = document.createElement('input');
    input.setAttribute('readonly', 'readonly');
    input.setAttribute('value', 'hello worldssss');
    document.body.appendChild(input);
    input.select();
    input.setSelectionRange(0, 9999);
    if (document.execCommand('copy')) {
      document.execCommand('copy');
      alert('复制成功');
    }
    document.body.removeChild(input);
  }
</script>
</html>