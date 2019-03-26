var grid;
function initGrid(){
	grid = $("#maingrid").ligerGrid({
		url:WST.U('admin/recharge/pageQuery'),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:'99%',
        width:'100%',
        minColToggle:6,
        rownumbers:true,
        columns: [
            { display: '编号', name: 'bpid',Sort: false},
	        { display: '用户', name: 'userName',isSort: false},
	        { display: '充值金额', name: 'bpprice',isSort: false},
	        { display: '实际到账', name: 'bpprice',isSort: false,render: function (rowdata, rowindex, value){
            return (value*1 - rowdata['reg_par']*1).toFixed(2);
          }},
	        { display: '充值时间', name: 'createTime',isSort: false},
	        { display: '用户余额', name: 'bpbalance',isSort: false},
	        { display: '充值方式', name: 'pay_type',isSort: false},
	        
        ]
    });
}
function toEdit(id){
	location.href=WST.U('admin/recharge/toHandle','id='+id);
}
function loadGrid(){
	var p = WST.arrayParams('.j-ipt');
	grid.set('url',WST.U('admin/recharge/pageQuery',p.join('&')));
}

function save(){
	if(WST.confirm({content:'您确定通过该提现申请吗？',yes:function(){
        var params = WST.getParams('.ipt');
		var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	    $.post(WST.U('admin/cashdraws/handle'),params,function(data,textStatus){
	    	layer.close(loading);
	    	var json = WST.toAdminJson(data);
	    	if(json.status=='1'){
	    		WST.msg("操作成功",{icon:1});
	    		location.href=WST.U('admin/cashdraws/index');
	    	}else{
	    		WST.msg(json.msg,{icon:2});
	    	}
	    });
	}}));
}

function tongji() {
	var p = WST.arrayParams('.j-ipt');
	$.post(WST.U('admin/recharge/tongji',p.join('&')),'',function(res){

		console.log(res);
		$.each(res,function(k,v){
			$('.'+k).html(v);
		})
	});
}
