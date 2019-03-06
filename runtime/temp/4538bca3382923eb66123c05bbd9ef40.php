<?php /*a:3:{s:74:"D:\phpstudy\PHPTutorial\WWW\tp5.1\application\admin\view\wechat\index.html";i:1545296720;s:75:"D:\phpstudy\PHPTutorial\WWW\tp5.1\application\admin\view\public\master.html";i:1540867117;s:73:"D:\phpstudy\PHPTutorial\WWW\tp5.1\application\admin\view\public\menu.html";i:1545296189;}*/ ?>
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
            
<link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<style>
    .mobile {
        border: 1px solid #cccccc;
        height: 600px;
        display: flex;
    }
    .mobile dl {
        padding: 0px;
        margin: 0;
        display: flex;
        flex-direction: column-reverse;
        flex: 1;
    }
    .mobile dl dt {
        background: #cccccc;
        border: 1px solid #f3f3f3;
        text-align: center;
        height: 30px;
        line-height: 2em;
    }
    .mobile dl dd {
        display: flex;
        flex-direction: column;
    }
    .mobile dl dd a {
        text-align: center;
        padding: 6px;
        border: 1px solid #f3f3f3;
    }
    .topMenu,
    .subMenu {
        position: relative;
    }
    .topMenu .top,
    .subMenu .top,
    .topMenu .sub,
    .subMenu .sub {
        position: absolute;
        right: -10px;
        top: -10px;
        cursor: pointer;
        /*display: none;*/
    }
    /*.topMenu:hover .top,*/
    /*.subMenu:hover .sub {*/
    /*display: block;*/
    /*}*/

</style>
<link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<script src="https://cdn.bootcss.com/vue/2.0.0/vue.min.js"></script>
<!--百度搜索bootscdn，在cdn搜多框输入underscore-->
<script src="https://cdn.bootcss.com/underscore.js/1.8.3/underscore-min.js"></script>
<form action="" method="POST" class="form-horizontal" role="form">
    <div class="container" id="box">
        <div class="row">
            <!--手机预览-->
            <div class="col-xs-4">
                <div class="mobile">
                    <dl v-for="v in button">
                        <dt>{{v.name}}</dt>
                        <dd v-for="vv in v.sub_button">
                            <a href="">{{vv.name}}</a>
                        </dd>
                    </dl>
                </div>
            </div>
            <!--编辑页面-->
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">编辑</h3>
                    </div>
                    <div class="panel-body">
                        <!--一级菜单开始-->
                        <div class="panel panel-default topMenu" v-for="v in button">
                            <i class="fa fa-times-circle fa-2x top" @click="delTopMenu(v)"></i>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">菜单名称</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" v-model.trim.lazy="v.name">
                                    </div>
                                </div>
                                <div class="form-group" v-if="v.type">
                                    <label for="" class="col-sm-2 control-label">菜单类型</label>
                                    <div class="col-sm-10">
                                        <label class="radio-inline">
                                            <input type="radio" v-model="v.type" value="click"> 发送消息
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" v-model="v.type" value="view"> 跳转地址
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group" v-if="v.type=='click'">
                                    <label for="" class="col-sm-2 control-label">发送消息</label>
                                    <div class="col-sm-10">
                                        <select v-model="v.key" class="form-control">
                                            <option v-for="m in mess" v-bind="m">{{m}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" v-if="v.type=='view'">
                                    <label for="" class="col-sm-2 control-label">跳转地址</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" v-model.trim.lazy="v.url">
                                    </div>
                                </div>

                                <!--二级菜单开始-->
                                <div class="panel panel-default subMenu" v-for="vv in v.sub_button">
                                    <i class="fa fa-times-circle fa-2x sub" @click="delSubMenu(v,vv)"></i>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label for="" class="col-sm-2 control-label">菜单名称</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" v-model="vv.name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">菜单类型</label>
                                        <div class="col-sm-10">
                                            <label class="radio-inline">
                                                <input type="radio" v-model="vv.type" value="click"> 发送消息
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" v-model="vv.type" value="view"> 跳转地址
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group" v-if="vv.type=='click'">
                                        <label for="" class="col-sm-2 control-label">发送消息</label>
                                        <div class="col-sm-10">
                                            <select v-model="vv.key" class="form-control">
                                                <option v-for="m in mess" v-bind="m">{{m}}</option>
                                                <!--<option v-for="m in mess" value="{{m}}"></option>-->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" v-if="vv.type=='view'">
                                        <label for="" class="col-sm-2 control-label">跳转地址</label>
                                        <div class="col-sm-10">
                                            <input type="text" v-model="vv.url" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-info" type="button" @click="addSubMenu(v)">添加二级菜单</button>
                                <!--二级菜单结束-->
                            </div>
                        </div>

                        <button class="btn btn-success" type="button" @click="addTopMenu">添加一级菜单</button>
                        <!--一级菜单结束-->
                    </div>
                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-2">
                            <button type="button" class="btn btn-primary col-sm-12" @click="submess">提交保存</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
  new Vue({
    el: '#box',
    data:{
      button:[

      ],
      mess:[],
    },
    beforeCreate:function () {
      var This=this;
      $.post("<?php echo url('admin/wechat/getorder'); ?>",{},function (res) {
        This.button=JSON.parse(res);
      });
      $.post("<?php echo url('admin/wechat/getverson'); ?>",{},function (res) {
        This.mess=res;
      });
    },
    created:function () {
      var This=this;


    },
    methods:{
      //添加一级菜单
      addTopMenu(){
        var con = {name:'',sub_button:[],type:'1',url:'',key:''};
        if(this.button.length == 3){
          alert('一级菜单最多三个');
          return false;
        }else{
          this.button.push(con);
        }
      },
      //添加二级菜单
      addSubMenu(v){
        var con = {type:'',name:'',url:'',key:''};
        if(v.sub_button.length == 5){
          alert('二级级菜单最多五个');
          return false;
        }else{
          v.type="";
          v.sub_button.push(con);
        }
      },
      //删除一级菜单
      delTopMenu(v){
        this.button = _.without(this.button,v);
      },
      //删除二级菜单
      delSubMenu(v,vv){
        if(v.sub_button.length == 1){
          v.type=1;
        }
        v.sub_button = _.without(v.sub_button,vv);
      },
      delonetype(v){
        v.type="";
      },
      submess(){
        var This=this;
//        var data=JSON.stringify(this.button);
        var data=[];
        for (var i=0;i<this.button.length;i++){
          var obj={};
          if (this.button[i].sub_button==false){
            obj.type=this.button[i]['type'];
            obj.name=this.button[i]['name'];
            if (this.button[i]['type']=="click"){
              obj.key=this.button[i]['key'];
            }else if(this.button[i]['type']=="view") {
              obj.url=this.button[i]['url'];
            }else {
              alert('请正确输入顶级菜单信息');return false;
            }
          }else {
            obj.name=this.button[i]['name'];
            obj.sub_button=[];
            for (var j=0;j<this.button[i]['sub_button'].length;j++){
              obj.sub_button[j]={};
              obj.sub_button[j].type=this.button[i]['sub_button'][j]['type'];
              obj.sub_button[j].name=this.button[i]['sub_button'][j]['name'];
              if (this.button[i]['sub_button'][j]['type']=='click'){
                obj.sub_button[j].key=this.button[i]['sub_button'][j]['key'];
              }else if(this.button[i]['sub_button'][j]['type']=='view'){
                obj.sub_button[j].url=this.button[i]['sub_button'][j]['url'];
              }else {
                alert('请正确输入二级菜单信息');return false;
              }
            }
          }
          data.push(obj);
        }
        var oldData=JSON.stringify(this.button);
        $.post("<?php echo url('admin/wechat/setorder'); ?>",{button:data,oldbutton:oldData},function (res) {
          if (res==1){
            alert('成功');
          }else {
            alert('失败');
          }
        });
      }
    }
  })
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