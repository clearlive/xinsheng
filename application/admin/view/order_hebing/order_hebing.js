var grid;
function initGrid(){
	grid = $("#maingrid").ligerGrid({
		url:WST.U('admin/order_hebing/pageQuery'),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:'99%',
        width:'100%',
        minColToggle:6,
        rownumbers:true,
        columns: [
            { display: '合并编号', name: 'hbid',isSort: false},
	        { display: '用户', name: 'userName',isSort: false},
	        { display: '合并时间', name: 'ohcreatetime',isSort: false},
	        
	        { display: '总价', name: 'zongjia'},
	        { display: '运费', name: 'fee'},
	        { display: '收货姓名', name: 'username'},
	        { display: '手机号', name: 'phone'},
	        { display: '地址', name: 'address'},
	        { display: '状态', name: 'static',isSort: false,render: function (rowdata, rowindex, value){
	            if(rowdata['static'] == 0){
	        		return '审核中';
	        	}else if(rowdata['static'] == 1){
	        		return '已发货';
	        	}else if(rowdata['static'] == 2){
	        		return '已拒绝';
	        	}else if(rowdata['static'] == 3){
	        		return '已收货';
	        	}
	        }},

	        


	        { display: '操作', name: 'op',isSort: false,render: function (rowdata, rowindex, value){
	            var h = "";
	            h += "<a href='javascript:toView(" + rowdata['hbid'] + ")'>详情</a> ";
	            return h;
	        }}
        ]
    });
}

function toView(id){
	location.href=WST.U('admin/order_hebing/view','id='+id);
}



function loadGrid(){
	var p = WST.arrayParams('.j-ipt');
	grid.set('url',WST.U('admin/order_hebing/pageQuery',p.join('&')));
}

function editInit(){
	 /* 表单验证 */
    $('#userForm').validator({
           
          
          valid: function(form){
            var params = WST.getParams('.ipt');
            console.log(params);
            var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
            $.post(WST.U('admin/order_hebing/fahuo'),params,function(data,textStatus){
            	console.log(data);
            	
              layer.close(loading);
              var json = WST.toAdminJson(data);
              if(json.status=='1'){
                  WST.msg("操作成功",{icon:1});
                  location.href=WST.U('Admin/order_hebing/index');
              }else{
                    WST.msg(json.msg,{icon:2});
              }
              
            });

      }

    });
}

function jujue(hbid) {
	var params = 'hbid='+hbid+'&_static=2';
	


	var box = WST.confirm({content:"您确定要拒绝吗?",yes:function(){
	   var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	   	$.post(WST.U('admin/order_hebing/fahuo'),params,function(data,textStatus){
	   		console.log(data);
	   		layer.close(loading);
	   		var json = WST.toAdminJson(data);
              if(json.status=='1'){
                  WST.msg("操作成功",{icon:1});
                  location.href=WST.U('Admin/order_hebing/index');
              }else{
                    WST.msg(json.msg,{icon:2});
              }
	   		});
	    }});

}

function shouhuo(hbid) {
	var params = 'hbid='+hbid+'&_static=3';
	


	var box = WST.confirm({content:"您确定要收货吗?",yes:function(){
	   var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	   	$.post(WST.U('admin/order_hebing/fahuo'),params,function(data,textStatus){
	   		console.log(data);
	   		layer.close(loading);
	   		var json = WST.toAdminJson(data);
              if(json.status=='1'){
                  WST.msg("操作成功",{icon:1});
                  location.href=WST.U('Admin/order_hebing/index');
              }else{
                    WST.msg(json.msg,{icon:2});
              }
	   		});
	    }});

}