var grid;
function initGrid(key,value){
  if(key && value){
    var urls = WST.U('admin/Users/pageQuery/'+key+'/'+value);
  }else{
    var urls = WST.U('admin/Users/pageQuery');
  }
	grid = $("#maingrid").ligerGrid({
		url:urls,
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:'99%',
        width:'100%',
        minColToggle:6,
        rownumbers:false,
        columns: [
          { display: '用户ID', name: 'userId', isSort: false},
	        { display: '账号', name: 'loginName', isSort: false},
	        { display: '姓名', name: 'userName', isSort: false},
	        { display: '手机号码', name: 'userPhone', isSort: false},
			{ display: '头像', name: 'userPhoto', isSort: false,render: function (rowdata, rowindex, value){
            return '<img width="50" src="'+value+'">';
          }},
          { display: '余额', name: 'userMoney', isSort: false},
	        { display: '积分', name: 'userScore', isSort: false},
	        { display: '类型', name: 'quname', isSort: false},
          { display: '中奖|返点', name: 'op', isSort: false,render: function (rowdata, rowindex, value){
            return rowdata['allWin']+'|'+rowdata['allRes'];
          }},

          { display: '投注|盈亏', name: 'op', isSort: false,render: function (rowdata, rowindex, value){
            return rowdata['allTouzhu']+'|'+rowdata['allPloss'];
          }},

          { display: '邀请码', name: 'usercode', isSort: false},
          { display: '保证金', name: 'minMoney', isSort: false},
          { display: '红利比例', name: 'percent', isSort: false},
	        { display: '注册时间', name: 'createTime', isSort: false},
          { display: '最后登录时间', name: 'lastTime', isSort: false},
          { display: '所属运营中心', name: 'par101', isSort: false},
          { display: '所属会员单位', name: 'par102', isSort: false},
          { display: '所属代理商', name: 'par103', isSort: false},
          { display: '直接归属', name: 'oid', isSort: false},
	        { display: '状态', name: 'userStatus', isSort: false, render:function(rowdata, rowindex, value){
	        	return (value==1)?'启用':'停用';
	        }},
	        { display: '操作', name: 'op',isSort: false,render: function (rowdata, rowindex, value){
	            var h = "";
	            if(WST.GRANT.HYGL_02)h += "<a href='"+WST.U('admin/Users/toEdit','id='+rowdata['userId'])+"'>修改</a> ";
	            if(WST.GRANT.HYGL_03)h += "<a href='javascript:toDel(" + rowdata['userId'] + ")'>删除</a> "; 
              //h += "<a href='javascript:show_info(" + rowdata['userId'] + ")'>查看</a> ";
              if(WST.GRANT.HYGL_04)h += "<a href='javascript:show_tongji(" + rowdata['userId'] + ")'>统计</a> ";
              if(WST.GRANT.HYGL_05)h += "<a href='"+WST.U('admin/logMoney/index/uid/'+rowdata['userId'])+"'>帐变</a> ";
              if(rowdata['uq'] != 104){
                if(WST.GRANT.HYGL_06)h += "<a href='javascript:;' onclick='initGrid(\"parid\","+rowdata['userId']+");'>下级</a> ";
              }
              

	            return h;
	        }}
        ]
    });
	
	
	
}
function toDel(id){
	var box = WST.confirm({content:"您确定要删除该记录吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/Users/del'),{id:id},function(data,textStatus){
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
                loginName: {
                  rule:"required;loginName;myRemote",
                  msg:{required:"请输入会员账号"},
                  tip:"请输入会员账号",
                  ok:"",
                },
                
                userPhone: {
                  rule:"required;mobile;myRemote",
                  msg:{required:"请输入手机号"},
                  tip:"请输入手机号",
                  ok:"",
                },
                userEmail: {
                  rule:"required;email;myRemote",
                  msg:{required:"请输入邮箱"},
                  tip:"请输入邮箱",
                  ok:"",
                },
                userScore: {
                  rule:"integer[+0]",
                  msg:{integer:"当前积分只能是正整数"},
                  tip:"当前积分只能是正整数",
                  ok:"",
                },
                userTotalScore: {
                  rule:"match[gt, userScore];integer[+0];",
                  msg:{integer:"当前积分只能是正整数",match:'会员历史积分必须大于会员积分'},
                  tip:"当前积分只能是正整数",
                  ok:"",
                },
                userQQ: {
                  rule:"integer[+]",
                  msg:{integer:"QQ只能是数字"},
                  tip:"QQ只能是数字",
                  ok:"",
                },
                
            },

          valid: function(form){
            var params = WST.getParams('.ipt');
            console.log(params);
            var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
            $.post(WST.U('admin/Users/'+((params.userId==0)?"add":"edit")),params,function(data,textStatus){
              layer.close(loading);
              var json = WST.toAdminJson(data);
              if(json.status=='1'){
                  WST.msg("操作成功",{icon:1});
                  location.href=WST.U('Admin/Users/index');
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
        $('#userPhoto').val('/'+json.savePath+json.thumb);
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
          html += '<option value="'+v.userId+'">'+v.userName+'</option>';
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
          html += '<option value="'+v.userId+'">'+v.userName+'</option>';
        })
      
    }
    $('#par103').html(html);
    
  });
});


function show_info(userId) {
    layer.open({
    type: 2,
    content: WST.U('Admin/Users/userinfo','userId='+userId),
     area: ['70%', '80%'],
    success: function(layero, index){
     
    }
  });       
}


function show_tongji(userId) {
    layer.open({
    type: 2,
    content: WST.U('Admin/Users/tongji','uid='+userId),
     area: ['70%', '80%'],
    success: function(layero, index){
     
    }
  });       
}

function addmoney() {
    var query = WST.getParams('.query');
    var posturl = WST.U('Admin/Users/addmoney');
    var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
    $.post(posturl,query,function(res){

        layer.close(loading);
        console.log(res);
        if(res.status=='1'){
            WST.msg("操作成功",{icon:1});
            layer.close(box);
                grid.reload();
        }else{
            WST.msg(res.msg,{icon:2});
        }

    });
    
}