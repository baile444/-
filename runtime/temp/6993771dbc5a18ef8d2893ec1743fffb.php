<?php /*a:3:{s:72:"D:\phpstudy\PHPTutorial\WWW\tp5.1\application\admin\view\shops\work.html";i:1543383153;s:75:"D:\phpstudy\PHPTutorial\WWW\tp5.1\application\admin\view\public\master.html";i:1540867117;s:73:"D:\phpstudy\PHPTutorial\WWW\tp5.1\application\admin\view\public\menu.html";i:1550818501;}*/ ?>
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
            <li class="header">订单管理</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i>
                    <span>订单管理</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo url('admin/order/index'); ?>"><i class="fa fa-circle-o"></i>待发货订单</a></li>
                    <li><a href="<?php echo url('admin/order/wait'); ?>"><i class="fa fa-circle-o"></i>待收货订单</a></li>
                    <li><a href="<?php echo url('admin/order/succ'); ?>"><i class="fa fa-circle-o"></i>成功订单</a></li>
                    <li><a href="<?php echo url('admin/order/recommend'); ?>"><i class="fa fa-circle-o"></i>待退款</a></li>
                    <li><a href="<?php echo url('admin/order/hadrecommend'); ?>"><i class="fa fa-circle-o"></i>已处理退款订单</a></li>
                </ul>
            </li>

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
                    <span>pc商城轮播图</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo url('admin/cate/recommend',['cid'=>9999]); ?>"><i class="fa fa-circle-o"></i>列表</a></li>
                </ul>
            </li>
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
                    <li><a href="<?php echo url('admin/messages/index'); ?>"><i class="fa fa-circle-o"></i>联系我们留言</a></li>
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
                    <li><a href="<?php echo url('admin/user/remoney'); ?>"><i class="fa fa-circle-o"></i>提现申请</a></li>
                    <li><a href="<?php echo url('admin/user/hadremoney'); ?>"><i class="fa fa-circle-o"></i>已提现列表</a></li>
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
        <h3 class="panel-title">服务业务列表</h3>
    </div>
    <div class="panel-body">
        <a href="<?php echo url('admin/category/index'); ?>" class="btn btn-primary">返 回</a>
        <a href="<?php echo url('addwork',['sid'=>$sid]); ?>" class="btn btn-info">新增业务</a>
    </div>
    <div class="panel-body">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>编号</th>
                <th>业务名称</th>
                <th>图片</th>
                <th>排序</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($workData) || $workData instanceof \think\Collection || $workData instanceof \think\Paginator): $i = 0; $__LIST__ = $workData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <tr>
                <td><?php echo htmlentities($vo['wid']); ?></td>
                <td><?php echo htmlentities($vo['wname']); ?></td>
                <td><img src="http://image.qyfw24.com/<?php echo htmlentities($vo['wpic']); ?>" alt=""></td>
                <td><input type="text" name="sort" id="<?php echo htmlentities($vo['sid']); ?>" value="<?php echo htmlentities($vo['wsort']); ?>"></td>
                <td>
                    <a href="<?php echo url('editwork',['sid'=>$vo['sid'],'wid'=>$vo['wid']]); ?>" class="btn btn-primary">编辑</a>
                    <a href="javascript:;" class="btn btn-danger" urls="<?php echo url('del',['id'=>$vo['sid']]); ?>" data-toggle="modal" data-target="#myModal" onclick="attrcid()">删除</a>
                </td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    var str=null;
    $('.btn-danger').click(function () {
        str=$(this).attr('urls');
    });
    function checkdel(){
        location.href=str;
    }


    var oinputs=$('input[name=sort]');
    var t;
    oinputs.focus(function () {
        t=$(this).val();
    });
    oinputs.blur(function () {
        var This=$(this);
        var id=parseInt(This.attr('id'),10);
        var sort=parseInt(This.val(),10);
        if (id&&sort>=0&&sort!=t){
            $.post("<?php echo url('ajaxEditSorts'); ?>",{id:id,wsort:sort},function (res) {
                if (res.valid==1){
                    This.val(sort);
                    alert(res.msg);
                    location.reload();
                }else {
                    alert(res.msg);
                }
            },'json');
        }else {
            This.val(t)
        }
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