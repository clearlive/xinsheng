var grid;
function initGrid(){
	grid = $("#maingrid").ligerGrid({
		url:WST.U('admin/drorder/pageQuery'),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:'99%',
        width:'100%',
        minColToggle:6,
        rownumbers:true,
        columns: [
            { display: '订单编号', name: 'orderNo',isSort: false},
	        { display: '用户', name: 'userName',isSort: false},
	        { display: '手机号', name: 'userPhone',isSort: false},
	        { display: '总金额', name: 'orderMoney',isSort: false},
	        { display: '数量', name: 'orderNum',isSort: false},
	        { display: '下单时间', name: 'createTime',isSort: false},
	        { display: '期数', name: 'sscqishu',isSort: false},
	        { display: '开奖', name: 'sscnum',isSort: false},
	        { display: '产品', name: 'goodsName',isSort: false},
	        { display: '玩法(人)', name: 'drtype',isSort: false},
	        { display: '买入类型', name: 'dd_type',isSort: false},
	        { display: '手续费', name: 'po',isSort: false,render: function (rowdata, rowindex, value){
	            if(rowdata['drtype'] == 2){
	        		return rowdata['play2fee']*rowdata['orderNum'];
	        	}else if(rowdata['drtype'] == 4){
	        		return rowdata['play4fee']*rowdata['orderNum'];
	        	}else if(rowdata['drtype'] == 10){
	        		return rowdata['play10fee']*rowdata['orderNum'];
	        	}else{
	        		return 0;
	        	}
	        }},
	        { display: '盈亏', name: 'winmoney',isSort: false,render: function (rowdata, rowindex, value){
	        	if(rowdata['isover'] == 0){
	        		return '-';
	        	}
	            if(rowdata['drtype'] == 2){
	        		var playfee = rowdata['play2fee']*rowdata['orderNum'];
	        	}else if(rowdata['drtype'] == 4){
	        		var playfee = rowdata['play4fee']*rowdata['orderNum'];
	        	}else if(rowdata['drtype'] == 10){
	        		var playfee = rowdata['play10fee']*rowdata['orderNum'];
	        	}else{
	        		var playfee =  0;
	        	}
	        	return playfee*1+value*1;
	        }},
	        { display: '所属运营中心', name: 'par101',isSort: false},
	        { display: '所属会员单位', name: 'par102',isSort: false},
	        { display: '所属代理商', name: 'par103',isSort: false},
	        { display: '是否兑换金币', name: 'isres',isSort: false,render: function (rowdata, rowindex, value){
	            if(rowdata['isres'] == 0){
	        		return '未兑换金币';
	        	}else{
	        		return '已兑换金币';
	        	}
	        }},

	        { display: '状态', name: 'iswin',isSort: false,render: function (rowdata, rowindex, value){
	            if(rowdata['iswin'] == 0){
	        		return '进行中';
	        	}else if(rowdata['iswin'] == 1){
	        		return '赢利';
	        	}else if(rowdata['iswin'] == 2){
	        		return '亏损';
	        	}
	        }},

	        


	       
        ]
    });
    tongji();
}

function toView(id){
	location.href=WST.U('admin/drorder/view','id='+id);
}
function loadGrid(){
	var p = WST.arrayParams('.j-ipt');
	grid.set('url',WST.U('admin/drorder/pageQuery',p.join('&')));
	tongji();
}


function tongji() {
	var p = WST.arrayParams('.j-ipt');
	$.post(WST.U('admin/drorder/tongji',p.join('&')),'',function(res){
		var obj = JSON.parse(res);
		$.each(obj,function(k,v){
			$('.'+k).html(v);
		})
	});
}


function shuaxin() {
	$('.l-bar-btnload').click();
	tongji();
}

function shuaxin_btn() {
	if(isshuaxin == 1){
		clearInterval(sxd);
		isshuaxin = 0;
		$('.shuaxin_btn').html('点击开始刷新');
	}else if(isshuaxin == 0){
		sxd = setInterval('shuaxin()', 20000);
		isshuaxin = 1;
		$('.shuaxin_btn').html('点击停止刷新');
	}
	
}