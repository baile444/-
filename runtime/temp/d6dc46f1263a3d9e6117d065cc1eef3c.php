<?php /*a:3:{s:72:"D:\phpstudy\PHPTutorial\WWW\tp5.1\application\admin\view\user\index.html";i:1548234949;s:75:"D:\phpstudy\PHPTutorial\WWW\tp5.1\application\admin\view\public\master.html";i:1540867117;s:73:"D:\phpstudy\PHPTutorial\WWW\tp5.1\application\admin\view\public\menu.html";i:1547545117;}*/ ?>
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
        <h3 class="panel-title">会员列表</h3>
    </div>
    <div class="panel-body">
        <form class="form-inline" method="get">
            <div class="form-group">
                <label for="exampleInputEmail2">手机号</label>
                <input type="text" class="form-control" id="exampleInputEmail2" placeholder="手机号" name="phone">
            </div>
            <button type="submit" class="btn btn-default">搜索</button>
        </form>
    </div>

    <!-- Modal 积分-->
    <div class="modal fade" id="myModaljifen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">积分增加/减少</h4>
                </div>
                <form action="" method="post" enctype="multipart/form-data" id="jifenform" class="form-horizontal" role="form" onsubmit="return jifen()">
                    <div class="modal-body">
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">理由</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputEmail1" required placeholder="理由"  name="can_content">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">积分数</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="inputEmail1" required placeholder="负数为减正数为加"  name="can_fen">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-primary">提交保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal 余额-->
    <div class="modal fade" id="myModalmoney" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">余额增加/减少</h4>
                </div>
                <form action="" method="post" enctype="multipart/form-data" id="moneyform" class="form-horizontal" role="form" onsubmit="return money()">
                    <div class="modal-body">
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">理由</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputEmail1" required placeholder="理由"  name="can_content">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">余额</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="inputEmail1" required placeholder="负数为减正数为加"  name="can_money">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-primary">提交保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--<div class="panel-body">-->
        <!--<a href="<?php echo url('addbanner'); ?>" class="btn btn-info">新增banner</a>-->
    <!--</div>-->
    <div class="panel-body">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>编号</th>
                <th>手机</th>
                <th>注册时间</th>
                <th>是否绑定微信</th>
                <th>支付宝账户</th>
                <th>支付宝账号</th>
                <th>积分</th>
                <th>余额</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($userData) || $userData instanceof \think\Collection || $userData instanceof \think\Paginator): $i = 0; $__LIST__ = $userData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <tr>
                <td><?php echo htmlentities($vo['user_id']); ?></td>
                <td><?php echo htmlentities($vo['phone']); ?></td>
                <td><?php echo date('Y-m-d H:i:s',$vo['create_time']); ?></td>
                <td><?php if($vo['wechat']): ?>是<?php else: ?>否<?php endif; ?></td>
                <td><?php if($vo['apayname']): ?><?php echo htmlentities($vo['apayname']); else: ?>无<?php endif; ?></td>
                <td><?php if($vo['apay']): ?><?php echo htmlentities($vo['apay']); else: ?>无<?php endif; ?></td>
                <td>
                    <div style="width: 100px;float: left"><?php echo htmlentities($vo['jifen']); ?></div>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary jifenadd" userid="<?php echo htmlentities($vo['user_id']); ?>" data-toggle="modal" data-target="#myModaljifen">
                        +/-
                    </button>
                </td>
                <td><div style="width: 100px;float: left"><?php echo htmlentities($vo['money']); ?></div>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary jifenadd" userid="<?php echo htmlentities($vo['user_id']); ?>" data-toggle="modal" data-target="#myModalmoney">
                        +/-
                    </button></td>
                <td>
                    <?php if($vo['lv']==0): ?>
                    <a href="<?php echo url('admin/user/edit',['user_id'=>$vo['user_id'],'lv'=>1,'page'=>app('request')->param('page')]); ?>" class="btn btn-primary">添加推广</a>
                    <?php else: ?>
                    <a href="<?php echo url('admin/user/edit',['user_id'=>$vo['user_id'],'lv'=>0,'page'=>app('request')->param('page')]); ?>" class="btn btn-danger">取消推广</a>
                    <?php endif; ?>
                    <a href="<?php echo url('admin/user/jifenlist',['user_id'=>$vo['user_id']]); ?>" class="btn btn-info">积分流水</a>
                    <a href="<?php echo url('admin/user/moneylist',['user_id'=>$vo['user_id']]); ?>" class="btn btn-danger">余额流水</a>
                    <!--<a href="javascript:;" class="btn btn-danger" urls="<?php echo url('admin/user/del'); ?>" data-toggle="modal" data-target="#myModal">删除</a>-->
                </td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </div>
    <div class="text-center"><?php echo $userData; ?></div>
</div>

<script>
    var jifensta = '';
    var userid = '';
    $('.jifenadd').click(function () {
      userid = $(this).attr('userid')
    })
    $('.jifenmiuns').click(function () {
      userid = $(this).attr('userid')
    })
  function jifen() {
    var data = $('#jifenform').serialize();
    data+='&userid=' + userid
    $.post("<?php echo url('ajaxJifen'); ?>",data,function (res) {
      if (res == 1) {
        location.reload();
      } else {
        alert(res)
      }
    },'json');
    return false
  }

    function money() {
      var data = $('#moneyform').serialize();
      data+='&userid=' + userid
      $.post("<?php echo url('ajaxMoney'); ?>",data,function (res) {
        if (res == 1) {
          location.reload();
        } else {
          alert(res)
        }
      },'json');
      return false
    }


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
            $.post("<?php echo url('ajaxEditSort'); ?>",{id:id,sort:sort},function (res) {
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