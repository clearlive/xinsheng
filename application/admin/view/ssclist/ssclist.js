var grid;
function initGrid(){
	grid = $("#maingrid").ligerGrid({
		url:WST.U('admin/ssclist/pageQuery'),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:'99%',
        width:'100%',
        minColToggle:6,
        rownumbers:true,
        columns: [
            { display: 'ID', name: 'id',Sort: false},
            { display: '期数', name: 'issue',Sort: false},
            { display: '开奖号', name: 'balls', isSort: false},
            { display: '开奖时间', name: 'createtime', isSort: false},
            { display: '采集时间', name: 'date', isSort: false},
	        { display: '操作', name: 'op', isSort: false,render: function (rowdata, rowindex, value){
	            return "<a href='javascript:;' onclick='addssc("+rowdata['id']+");'>修改</a> ";
	          }}
	        
        ]
    });
}

function loadGrid(){
	var p = WST.arrayParams('.j-ipt');
	grid.set('url',WST.U('admin/ssclist/pageQuery',p.join('&')));
	
}

function addssc(id) {
	layer.open({
    type: 2,
    content: WST.U('Admin/ssclist/add','id='+id),
     area: ['70%', '80%'],
    success: function(layero, index){
     
    }
  }); 
}


function adddata() {
	var p = WST.arrayParams('.jd-ipt');
	$.get(WST.U('admin/ssclist/adddata',p.join('&')),function(data){
		console.log(data);
		if(data.status == 1){
			WST.msg(data.msg,{icon:1});
		}else{
			WST.msg(data.msg,{icon:2});
		}
	});
}