var grid;
function initGrid(){
	grid = $("#maingrid").ligerGrid({
		url:WST.U('admin/coupon/pageQuery'),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:'99%',
        width:'100%',
        minColToggle:6,
        rownumbers:true,
        columns: [
            { display: 'id', name: 'cid',Sort: false,isSort: false},
	        { display: '名称', name: 'cName',isSort: false},
	        { display: '金额(元)', name: 'cMoney',Sort: false,isSort: false},
	        { display: '满使用(元)', name: 'cUse',Sort: false,isSort: false},
	        { display: '有效期(天)', name: 'cTime',Sort: false,isSort: false},
	        { display: '是否使用', name: 'cStatic',Sort: false,isSort: false,render: function (rowdata, rowindex, value){
	        	if(value == 1){
	        		return '可使用'
	        	}else{
	        		return '已停用'
	        	}
	        }},
	        
	        { display: '操作', name: 'op',isSort: false,render: function (rowdata, rowindex, value){
	        	if(uq != 0) return;
	            var h = "<a href='javascript:toEdit(" + rowdata['cid'] + ")'>修改</a> ";
	            h += " | <a href='javascript:del(" + rowdata['cid'] + ")'>删除</a> ";
	            
	            return h;
	        }}
        ]
    });
}
function toEdit(id){
	location.href=WST.U('admin/coupon/edit','id='+id);
}
function index() {
	location.href=WST.U('admin/coupon/index');
}



function editInit(){
	 /* 表单验证 */
    $('#cForm').validator({
            

          valid: function(form){
            var params = WST.getParams('.ipt');
            console.log(params);
            var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
            $.post(WST.U('admin/coupon/add'),params,function(data,textStatus){
              layer.close(loading);
              var json = WST.toAdminJson(data);
              if(json.status=='1'){
                  WST.msg("操作成功",{icon:1});
                  location.href=WST.U('Admin/coupon/index');
              }else{
                    WST.msg(json.msg,{icon:2});
              }
            });

      }

    });

}

/**
 * 发送记录
 * @author lukui  2017-11-19
 * @return {[type]} [description]
 */
function sendlist() {
	location.href=WST.U('admin/coupon/sendlist');
}

function sendpage(){
	grid = $("#sendpage").ligerGrid({
		url:WST.U('admin/coupon/sendpage'),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:'99%',
        width:'100%',
        minColToggle:6,
        rownumbers:true,
        columns: [
            { display: 'id', name: 'csid',Sort: false,isSort: false},
	        { display: '名称', name: 'cName',isSort: false},
	        { display: '金额(元)', name: 'cMoney',Sort: false,isSort: false},
	        { display: '用户名', name: 'userName',Sort: false,isSort: false},
	        { display: '发送时间', name: 'sendTime',Sort: false,isSort: false},
	        { display: '到期时间', name: 'endTime',Sort: false,isSort: false},
	        { display: '优惠券状态', name: 'cStatic',Sort: false,isSort: false,render: function (rowdata, rowindex, value){
	        	if(value == 1){
	        		return '可使用'
	        	}else{
	        		return '已停用'
	        	}
	        }},

	        { display: '是否使用', name: 'isUse',Sort: false,isSort: false,render: function (rowdata, rowindex, value){
	        	if(value == 1){
	        		return '已使用'
	        	}else{
	        		return '未使用'
	        	}
	        }},
	        
	        { display: '操作', name: 'op',isSort: false,render: function (rowdata, rowindex, value){
	        	if(uq != 0) return;
	            var h = "<a href='javascript:delcs(" + rowdata['csid'] + ")'>删除</a> ";
	            
	            return h;
	        }}
        ]
    });
}

function delcs(id) {
	var box = WST.confirm({content:"您确定要删除该记录吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/coupon/delcs'),{csid:id},function(data,textStatus){
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