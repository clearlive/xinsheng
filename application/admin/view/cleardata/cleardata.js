var grid;
function initGrid(){
	grid = $("#maingrid").ligerGrid({
		url:WST.U('admin/cleardata/pageQuery'),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:'99%',
        width:'100%',
        minColToggle:6,
        rownumbers:true,
        columns: [
          	{ display: 'ID', name: 'id', isSort: false},
	        { display: '名称', name: 'filename', isSort: false},
	        { display: '大小', name: 'size', isSort: false},
	        { display: '备份时间', name: 'time', isSort: false},
          
	       
	        { display: '操作', name: 'op',isSort: false,render: function (rowdata, rowindex, value){
	            var h = ""; 
	            h += "<a href='"+WST.U('admin/cleardata/backupsbase','tp=dowonload&name='+rowdata.filename)+"'>下载</a> | ";
	            h += "<a href='javascript:;' onclick='beifen(\"del\",\""+rowdata.filename+"\");' >删除</a> ";
	            return h;
	        }}
        ]
    });
	
	
	
}

function loadGrid(){
	var p = WST.arrayParams('.j-ipt');
	grid.set('url',WST.U('admin/cleardata/clear',p.join('&')));
}

function beifen(tp,name=''){   
   
        if (tp){
            $.post("/admin/cleardata/backupsbase.html",{tp:tp,name:name},function(response){
                if (response){
                    layer.msg(response, {icon: 1,time: 2000},function(){
                      history.go(0);
                    });
                }else{
                    layer.msg("操作失败，请重试!!", {icon: 2}); 
                }
    
            }); 
        }
    }

function cleardata() {
	var box = WST.confirm({content:"您确定要清除记录吗?",yes:function(){
				var ctype = $('#ctype').val();
				var stacerateTime = $('#stacerateTime').val();
				var endcerateTime = $('#endcerateTime').val();

	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           
	           	$.post(WST.U('admin/cleardata/clear'),{ctype:ctype,stacerateTime:stacerateTime,endcerateTime:endcerateTime},function(data,textStatus){
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