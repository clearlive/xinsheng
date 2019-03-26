
function toEdit(id){
	var box = WST.open({title:'编辑',type:1,content:$('#accountBox'),area: ['450px', '260px'],btn:['确定','取消'],yes:function(){
					$('#accountForm').isValid(function(v){
						if(v){
							var params = WST.getParams('.ipt');
			                if(id>0)
			                	params.userId = id;
			                var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
			           		$.post(WST.U('admin/users/editAccount'),params,function(data,textStatus){
			           			  layer.close(loading);
			           			  var json = WST.toAdminJson(data);
			           			  if(json.status=='1'){
			           			    	WST.msg("操作成功",{icon:1});
			           			    	$('#accountForm')[0].reset();
			           			    	layer.close(box);
			           		            grid.reload();
			           			  }else{
			           			        WST.msg(json.msg,{icon:2});
			           			  }
			           		});
						}else{
							return false;
						}
					});
		        	
		

	},cancel:function(){$('#accountForm')[0].reset();},end:function(){$('#accountForm')[0].reset();}});

}
