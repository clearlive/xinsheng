var grid;
function initGrid(){
	grid = $("#maingrid").ligerGrid({
		url:WST.U('admin/hongli/pageQuery'),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:'99%',
        width:'100%',
        minColToggle:6,
        rownumbers:true,
        columns: [
            { display: '红利id', name: 'id',Sort: false,isSort: false},
	        { display: '订单id', name: 'dataId',Sort: false,isSort: false},
	        { display: '用户id', name: 'targetId',Sort: false,isSort: false},
	        { display: '用户名', name: 'userName',Sort: false,isSort: false},
            { display: '上级关系', name: 'ups',Sort: false,isSort: false},
	        { display: '增加金额', name: 'money',Sort: false,isSort: false},
	        { display: '时间', name: 'createTime',Sort: false,isSort: false},
	        { display: '备注', name: 'remark',Sort: false,isSort: false},
	        
        ]
    });
}

function loadGrid(){
	var p = WST.arrayParams('.j-ipt');
	grid.set('url',WST.U('admin/hongli/pageQuery',p.join('&')));
}