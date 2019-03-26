var grid;
function initGrid(){
	grid = $("#maingrid").ligerGrid({
		url:WST.U('admin/orders/pageQuery'),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:'99%',
        width:'100%',
        minColToggle:6,
        rownumbers:true,
        columns: [
            { display: '订单编号', name: 'orderNo',isSort: false},
	        { display: '用户', name: 'userName',isSort: false},
	        { display: '订单总金额', name: 'goodsMoney',isSort: false},
	        { display: '下单时间', name: 'createTime',isSort: false},
	        { display: '订单状态', name: 'status',isSort: false,render: function (rowdata, rowindex, value){
	        	if(rowdata['playtype'] == 0){
	        		return '未操作';
	        	}else{
	        		return '已操作';
	        	}
	        }},
	        { display: '游戏', name: 'playName'},
	        { display: '盈亏', name: 'winmoney'},

	        { display: '促销状态', name: 'is_over',isSort: false,render: function (rowdata, rowindex, value){
	            if(rowdata['is_over'] == 1 && rowdata['iswin'] == 1){
	            	return '<font color="red">大升级</font>';
	            }else if(rowdata['is_over'] == 1 && rowdata['iswin'] == 0){
	            	return '<font color="green">小升级</font>';
	            }else{
	            	return '未参与';
	            }
	        }},

	        { display: '所属运营中心', name: 'par101'},
	        { display: '所属会员单位', name: 'par102'},
	        { display: '所属代理商', name: 'par103'},
	        { display: '是否兑换金币', name: 'is_duihuan',isSort: false,render: function (rowdata, rowindex, value){
	            if(rowdata['is_duihuan'] == 0){
	        		return '未兑换金币';
	        	}else{
	        		return '已兑换金币';
	        	}
	        }},

	        { display: '是否提货', name: 'is_tihuo',isSort: false,render: function (rowdata, rowindex, value){
	            if(rowdata['is_tihuo'] == 0){
	        		return '未提货';
	        	}else{
	        		return '已提货';
	        	}
	        }},

	        { display: '是否退货', name: 'is_tuihuo',isSort: false,render: function (rowdata, rowindex, value){
	            if(rowdata['is_tuihuo'] == 0){
	        		return '未退货';
	        	}else{
	        		return '已退货';
	        	}
	        }},


	        { display: '操作', name: 'op',isSort: false,render: function (rowdata, rowindex, value){
	            var h = "";
	            h += "<a href='javascript:toView(" + rowdata['orderId'] + ")'>详情</a> ";
	            return h;
	        }}
        ]
    });
}

function toView(id){
	location.href=WST.U('admin/orders/view','id='+id);
}
function loadGrid(){
	var p = WST.arrayParams('.j-ipt');
	grid.set('url',WST.U('admin/orders/pageQuery',p.join('&')));
}