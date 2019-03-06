<?php /*a:3:{s:80:"D:\phpstudy\PHPTutorial\WWW\tp5.1\application\admin\view\cate\editrecommend.html";i:1545210463;s:75:"D:\phpstudy\PHPTutorial\WWW\tp5.1\application\admin\view\public\master.html";i:1540867117;s:73:"D:\phpstudy\PHPTutorial\WWW\tp5.1\application\admin\view\public\menu.html";i:1545296189;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>当日后台管理</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/admins/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/admins/css/AdminLTE.min.css">
    <link rel="stylesheet" href="/admins/css/_all-skins.min.css">
    <link rel="stylesheet" type="text/css" href="/uploadify/uploadify.css" />
    <script src="/admins/js/jquery.min.js"></script>
    <script type="text/javascript" src="/uploadify/jquery.uploadify.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="/admins/js/app.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.all.min.js"> </script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <!--header-contont-->
    <header class="main-header">
        <a href="javascript:;" class="logo">
            <span class="logo-mini"><b>后台</b></span>
            <span class="logo-lg"><b>当日</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="hidden-sm" style="font-size: x-large;"><b>当日后台</b></span>
                        </a>
                    </li>
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="hidden-xs">技术支持：晗特互联</span>
                        </a>
                    </li>
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!--<img src="/public/admins/img/user2-160x160.jpg" class="user-image" alt="User Image">-->
                            <span class="hidden-xs"><?php echo htmlentities($adminDate['name']); ?></span>
                        </a>
                    </li>
                    <li class="dropdown user user-menu">
                        <a href="#" onclick="out()" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="hidden-xs">退出</span>
                        </a>
                    </li>
                    <script>
                        function out() {
                            $.post("<?php echo url('admin/index/out'); ?>",{},function (res) {
                                if (res){
                                    location.reload();
                                }
                            },'json');
                        }
                    </script>
                </ul>
            </div>
        </nav>
    </header>

 <aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="header">展示页面信息管理</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i>
                    <span>首页管理</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo url('admin/banner/index'); ?>"><i class="fa fa-circle-o"></i>banner</a></li>
                    <li><a href="<?php echo url('admin/servers/index'); ?>"><i class="fa fa-circle-o"></i>服务优势</a></li>
                    <li><a href="<?php echo url('admin/firendship/index'); ?>"><i class="fa fa-circle-o"></i>友情链接</a></li>
                    <li><a href="<?php echo url('admin/logos/index',['id'=>1]); ?>"><i class="fa fa-circle-o"></i>基本信息</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i>
                    <span>服务商信息管理</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo url('admin/category/index'); ?>"><i class="fa fa-circle-o"></i>分类列表</a></li>
                    <!--<li><a href="<?php echo url('admin/shops/index'); ?>"><i class="fa fa-circle-o"></i>服务商</a></li>-->
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i>
                    <span>新闻管理</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo url('admin/newscate/index'); ?>"><i class="fa fa-circle-o"></i>分类列表</a></li>
                    <li><a href="<?php echo url('admin/news/index'); ?>"><i class="fa fa-circle-o"></i>新闻列表</a></li>
                </ul>
            </li>

            <li class="header">商品管理</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i>
                    <span>分类管理</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo url('admin/cate/index'); ?>"><i class="fa fa-circle-o"></i>分类列表</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i>
                    <span>商品管理</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo url('admin/goods/index'); ?>"><i class="fa fa-circle-o"></i>商品列表</a></li>
                    <!--<li><a href="<?php echo url('admin/recommend/index'); ?>"><i class="fa fa-circle-o"></i>商品广告设置</a></li>-->
                </ul>
            </li>

            <li class="header">会员管理</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i>
                    <span>留言管理</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo url('admin/smess/index'); ?>"><i class="fa fa-circle-o"></i>商户留言列表</a></li>
                    <li><a href="<?php echo url('admin/smess/bmess'); ?>"><i class="fa fa-circle-o"></i>平台留言</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i>
                    <span>会员管理</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo url('admin/user/index'); ?>"><i class="fa fa-circle-o"></i>会员列表</a></li>
                </ul>
            </li>

            <li class="header">微信管理</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i>
                    <span>菜单栏</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo url('admin/wechat/index'); ?>"><i class="fa fa-circle-o"></i>菜单</a></li>
                    <li><a href="<?php echo url('admin/Wechatmess/index'); ?>"><i class="fa fa-circle-o"></i>自定义消息</a></li>
                </ul>
            </li>

            <li class="header">安全管理</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i>
                    <span>密码管理</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo url('admin/index/editpass'); ?>"><i class="fa fa-circle-o"></i>修改密码</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i>
                    <span>积分管理</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo url('admin/jifen/index'); ?>"><i class="fa fa-circle-o"></i>积分兑换比例</a></li>
                </ul>
            </li>
        </ul>
    </section>
</aside>
<script>
    $('.treeview').click(function () {
      var menu_num=$(this).index();
      console.log(menu_num)
      localStorage.setItem('menu_num',menu_num);
    });
    var menu_num=localStorage.getItem('menu_num');
    if (menu_num>0){
      $('.sidebar-menu>li').eq(menu_num).addClass('active');
      $('.treeview').find('.treeview-menu').addClass('menu-open');
    }
</script>
    <div class="content-wrapper">
        <section class="content">
            
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">广告新增</h3>
    </div>
    <div class="panel-body">
        <a href="<?php echo url('recommend',['cid'=>app('request')->param('cid')]); ?>" class="btn btn-info">返回列表</a>
    </div>
    <div class="panel-body">
        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">广告描述</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputEmail3" placeholder="广告描述" name="content" value="<?php echo htmlentities($oldData['content']); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">url地址</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputEmail3" placeholder="url地址" name="urls" value="<?php echo htmlentities($oldData['urls']); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">上传图片(365*245)</label>
                <div class="col-sm-10" id="dispathed">
                    <input type="file"  name="file_upload" id="file_upload" pathname="recommend"/>
                    <div class="images">
                        <input type="hidden" value="<?php echo htmlentities($oldData['pic']); ?>" name="pic">
                        <img src="http://image.qyfw24.com/<?php echo htmlentities($oldData['pic']); ?>" width="500" style="background: black;">
                        <a href="javascript:;" class="btn btn-danger col-sm-offset-1 delimg">删除</a>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                    <button type="submit" class="btn btn-primary">提交保存</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="/admins/js/pic.js"></script>
<script>
   var ue = UE.getEditor('editor',{
       initialFrameHeight:300,
       initialFrameWidth:800,
   });
</script>

        </section>
    </div>

    <!-- /.contents.html-footer -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2017-2027 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights
        reserved.
    </footer>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                确定删除么？
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" onclick="return checkdel()">确定删除</button>
            </div>
        </div>
    </div>
</div>

</body>
<script>
  var wheight=$(window).height()-104;
  $('.content').css({'minHeight':wheight+'px'});
</script>
</html>