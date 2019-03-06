$(function () {
    //上传图片---单图
  var pathnames=$('#file_uploads').attr('pathname');
    $('#file_uploads').uploadify({
      'buttonText' : '请选择图片',
      'formData'     : {
        'timestamp' : '',
        'token'     : ''
      },
      'fileSizeLimit' : '500MB',
      'swf'      : "/uploadify/uploadify.swf",
      'uploader' : "/admin/index/uploads/name/"+pathnames,
        'onUploadSuccess' : function(file, data, response) {
            var data=JSON.parse(data);
            if(data.valid==1){
                var str='<div class="images"><input name="npic" type="hidden" value="'+data.msg+'"/><img src="'+'http://image.qyfw24.com/'+data.msg+'" width="150px" height="100px"><a href="javascript:;" class="btn btn-danger col-sm-offset-1 delimg">删除</a></div>';
                $('#dispatheds').append(str);
            }else{
                alert('失败');
            }
        }
    });
     //删除图片
    // $('.panel-body').on('click','.delimg',function () {
    //     var path=$(this).parents('.images').find('input').val();
    //     var ourl='/admin/news/delimg';
    //     $.post(ourl,{path:path},function (res) {
    //     },'json');
    //     $(this).parents('.images').remove();
    // });
});