var grid;
function initGrid(){
	grid = $("#maingrid").ligerGrid({
		url:WST.U('admin/Play/playlist'),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:'99%',
        width:'100%',
        minColToggle:6,
        rownumbers:true,
        columns: [
	        { display: '游戏名称', name: 'playName', isSort: false},
          { display: '游戏代码', name: 'playCode', isSort: false},
	        { display: '添加时间', name: 'createTime', isSort: false},
	        { display: '状态', name: 'playStatus', isSort: false, render:function(rowdata, rowindex, value){
	        	return (value==1)?'启用':'停用';
	        }},
	        { display: '操作', name: 'op',isSort: false,render: function (rowdata, rowindex, value){
	            var h = "";
	            if(WST.GRANT.HYGL_02)h += "<a href='"+WST.U('admin/play/toEdit','id='+rowdata['playId'])+"'>修改</a> ";
              if(WST.GRANT.HYGL_02)h += "<a href='"+WST.U('admin/play/conf','id='+rowdata['playId'])+"'>配置</a> ";
	            if(WST.GRANT.HYGL_03)h += "<a href='javascript:toDel(" + rowdata['playId'] + ")'>删除</a> "; 
	            return h;
	        }}
        ]
    });
	
	
	
}
function toDel(id){
	var box = WST.confirm({content:"您确定要删除该记录吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/play/del'),{id:id},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg("操作成功",{icon:1});
	           			    	layer.close(box);
	           		            grid.reload();
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}

function userQuery(){

				var query = WST.getParams('.query');
        console.log(WST);
        console.log(query);
			    grid.set('url',WST.U('admin/Users/pageQuery',query));
			}



function editInit(){
	 /* 表单验证 */
    $('#userForm').validator({
            dataFilter: function(data) {
                if (data.ok === '该登录账号可用' ) return "";
                else return "已被注册";
            },
            rules: {
                loginName: function(element) {
                    return /\w{5,}/.test(element.value) || '账号应为5-16字母、数字或下划线';
                },
                myRemote: function(element){
                    return $.post(WST.U('admin/users/checkLoginKey'),{'loginName':element.value,'userId':$('#userId').val()},function(data,textStatus){});
                }
            },
            fields: {
                playName: {
                  rule:"required;playName;myRemote",
                  msg:{required:"请输入游戏名称"},
                  tip:"请输入游戏名称",
                  ok:"",
                },
                playCode: {
                  rule:"required;playCode;myRemote",
                  msg:{required:"请输入游戏名称"},
                  tip:"请输入游戏名称",
                  ok:"",
                },
                
            },

          valid: function(form){
            var params = WST.getParams('.ipt');
            console.log(params);
            var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
            $.post(WST.U('admin/play/add'),params,function(data,textStatus){
              layer.close(loading);
              var json = WST.toAdminJson(data);
              if(json.status=='1'){
                  WST.msg("操作成功",{icon:1});
                  location.href=WST.U('Admin/play/playlist');
              }else{
                    WST.msg(json.msg,{icon:2});
              }
            });

      }

    });



//上传头像
  WST.upload({
      pick:'#adFilePicker',
      formData: {dir:'users'},
      accept: {extensions: 'gif,jpg,jpeg,bmp,png',mimeTypes: 'image/*'},
      callback:function(f){
        var json = WST.toAdminJson(f);
        if(json.status==1){
        $('#uploadMsg').empty().hide();
        //将上传的图片路径赋给全局变量
        $('#userPhoto').val(json.savePath+json.thumb);
        $('#preview').html('<img src="'+WST.conf.ROOT+'/'+json.savePath+json.thumb+'"  height="152" />');
        }else{
          WST.msg(json.msg,{icon:2});
        }
    },
    progress:function(rate){
        $('#uploadMsg').show().html('已上传'+rate+"%");
    }
    });
}

var par102html = $('#par102').html();
var par103html = $('#par103').html();
$("#par101").change(function(){

  
  var userId = $("#par101").val();
  var postdata = 'par101='+userId+"&uq="+102;
  $.post(posturl,postdata,function(res){

    var obj = JSON.parse(res)
    var html = par102html;

    if(obj){
      
        $.each(obj,function(k,v){
          html += '<option value="'+v.userId+'">'+v.loginName+'</option>';
        })
      
    }
    $('#par102').html(html);
    $('#par103').html(par103html);
  });
});

$("#par102").change(function(){

  var userId = $("#par102").val();

  var postdata = 'par102='+userId+"&uq="+103;
  $.post(posturl,postdata,function(res){
    var obj = JSON.parse(res)
    var html = par103html;

    if(obj){
      
        $.each(obj,function(k,v){
          html += '<option value="'+v.userId+'">'+v.loginName+'</option>';
        })
      
    }
    $('#par103').html(html);
    
  });
});


function confInit() {
    /* 表单验证 */
    $('#confForm').validator({
 
          valid: function(form){
            var params = WST.getParams('.ipt');
            console.log(params);
            var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
            $.post(WST.U('admin/play/playconf'),params,function(data,textStatus){
              layer.close(loading);
              var json = WST.toAdminJson(data);
              if(json.status=='1'){
                  WST.msg("操作成功",{icon:1});
                  location.href=WST.U('Admin/play/playlist');
              }else{
                    WST.msg(json.msg,{icon:2});
              }
            });

      }

    });


}