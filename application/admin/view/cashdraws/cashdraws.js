var grid;
function initGrid(){
	grid = $("#maingrid").ligerGrid({
		url:WST.U('admin/cashdraws/pageQuery'),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:'99%',
        width:'100%',
        minColToggle:6,
        rownumbers:true,
        columns: [
            { display: '提现单号', name: 'cashNo',Sort: false,isSort: false},

            { display: '用户ID', name: 'targetId',Sort: false,isSort: false},
            { display: '用户名', name: 'userName',Sort: false,isSort: false},
            { display: '上级关系', name: 'ups',Sort: false,isSort: false},


	        { display: '提现银行', name: 'accTargetName',isSort: false},
	        { display: '银行卡号', name: 'accNo',Sort: false,isSort: false},
	        { display: '持卡人', name: 'accUser',Sort: false,isSort: false},
	        { display: '提现金额', name: 'money',Sort: false,isSort: false,render: function (rowdata, rowindex, value){
	            return '¥'+value;
	        }},
	        { display: '到账金额', name: 'money',Sort: false,isSort: false,render: function (rowdata, rowindex, value){
	            return '¥'+(value-2);
	        }},
	        { display: '提现时间', name: 'createTime',Sort: false,isSort: false},
	        { display: '状态', name: 'cashSatus',Sort: false,isSort: false,render: function (rowdata, rowindex, value){
	        	if(rowdata['cashSatus']==1){
	        		return "已通过";
	        	}else if(rowdata['cashSatus']==0){
	        		return "待处理";
	        	}else if(rowdata['cashSatus']==2){
	        		return "已拒绝";
	        	}
	            //return (rowdata['cashSatus']==1)?"已通过":"待处理";
	        }},
	        { display: '操作', name: 'op',isSort: false,render: function (rowdata, rowindex, value){
	        	if(uq != 0) return;
	            var h = "";
	            if(rowdata['cashSatus']==0 && WST.GRANT.TXSQ_04)h += "<a href='javascript:toEdit(" + rowdata['cashId'] + ")'>处理</a> ";
	            return h;
	        }}
        ]
    });
}
function toEdit(id){
	location.href=WST.U('admin/cashdraws/toHandle','id='+id);
}
function loadGrid(){
	var p = WST.arrayParams('.j-ipt');
	grid.set('url',WST.U('admin/cashdraws/pageQuery',p.join('&')));
}

function save(cashSatus){
	if(WST.confirm({content:'您确定审核该提现申请吗？',yes:function(){
        var params = WST.getParams('.ipt');
        params.cashSatus = cashSatus;
        
		var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	    $.post(WST.U('admin/cashdraws/handle'),params,function(data,textStatus){
	    	layer.close(loading);
	    	var json = WST.toAdminJson(data);
	    	if(json.status=='1'){
	    		WST.msg("操作成功",{icon:1});

	    		if(isa != 1){
	    			location.href=WST.U('admin/cashdraws/index');
	    		}
	    		
	    	}else{
	    		WST.msg(json.msg,{icon:2});
	    	}
	    });
	}}));
}