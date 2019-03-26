var grid;
$(function(){
	$("#startDate").ligerDateEditor();
	$("#endDate").ligerDateEditor();
	grid = $("#maingrid").ligerGrid({
		url:WST.U('admin/log_user_logins/pageQuery'),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:'99%',
        width:'100%',
        minColToggle:6,
        rownumbers:true,
        columns: [
	        { display: 'id', name: 'loginId', isSort: false},
	        { display: '用户名', name: 'userName', isSort: false},
	        { display: '登录IP', name: 'loginIp', isSort: false},
	        { display: '地点', name: 'address', isSort: false},
	        { display: '浏览器', name: 'chrome', isSort: false},
	        { display: '操作系统', name: 'OS', isSort: false},
	        { display: '移动设备', name: 'isMobile', isSort: false, render:function(rowdata, rowindex, value){
	        	return (value==1)?'是':'否';
	        }},
	        { display: '登录时间', name: 'loginTime', isSort: false},
	        { display: '登录IP', name: 'loginIp', isSort: false},
	        { display: '操作', name: 'op', isSort: false, render:function(rowdata, rowindex, value){
	        	return "<a href='javascript:userId_loadGrid(" + rowdata['userId'] + ")'>只看此人</a> ";
	        }},
        ]
    });
})

function loadGrid(){
	grid.set('url',WST.U('admin/log_user_logins/pageQuery','startDate='+$('#startDate').val()+"&endDate="+$('#endDate').val()))
}

function userId_loadGrid(userId){
	grid.set('url',WST.U('admin/log_user_logins/pageQuery','userId='+userId))
}