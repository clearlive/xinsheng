var grid;
function initGrid(){
	grid = $("#maingrid").ligerGrid({
		url:WST.U('admin/price/pageQuery'),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:'99%',
        width:'100%',
        minColToggle:6,
        rownumbers:true,
        columns: [
            { display: '用户ID', name: 'userId',Sort: false},
            { display: '用户名', name: 'userName',Sort: false},
            { display: '身份', name: 'quname', isSort: false},
            { display: '所属运营中心', name: 'par101', isSort: false},
	        { display: '所属会员单位', name: 'par102', isSort: false},
	        { display: '所属代理商', name: 'par103', isSort: false},
	        { display: '直接归属', name: 'oid', isSort: false},
	        { display: '余额', name: 'userMoney', isSort: false},
	        { display: '总红利', name: 'hongli', isSort: false},
	        { display: '总手续费', name: 'shouxufee', isSort: false},
	        { display: '总流水返佣', name: 'liushui', isSort: false},
	        { display: '下级总订单', name: 'ordernum', isSort: false},
	        { display: '下级总盈亏', name: 'sonfee', isSort: false},
	        { display: '自己总入金', name: 'selfrech', isSort: false},
	        { display: '自己总出金', name: 'selfcash', isSort: false},
	        { display: '下级总入金', name: 'sonrech', isSort: false},
	        { display: '下级总出金', name: 'soncash', isSort: false},
	        { display: '客户总余额', name: 'kehumoney', isSort: false},
        ]
    });
}

function loadGrid(){
	var p = WST.arrayParams('.j-ipt');
	grid.set('url',WST.U('admin/price/pageQuery',p.join('&')));
	
}