<?php
include "login.check.php";
include "db/db_config.php";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title></title>
	<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/color.css">
	<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/demo/demo.css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.min.js"></script>
	<script type="text/javascript" src="http://www.jeasyui.com/easyui/jquery.easyui.min.js"></script>
</head>
<body>
	
	<table id="dg" title="My Products" class="easyui-datagrid" style="width:90%;height:80%"
			url="action.php?action=get_products"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true" data-options="
			singleSelect:true,
			fitColumns:true">
		<thead>
			<tr>
				<th field="itemno" width="20px">ItemNo.</th>
				<th field="description" width="20px">Description</th>
				<th field="upc" width="20px"> Upc</th>
				<th field="parentupc" width="20px">Parent UPC</th>
				<th field="case_cost" width="20px">Case cost</th>
				<th field="unit_per_case" width="20px">unit Per Case</th>
				<th field="image" width="20px">Image</th>



			</tr>
		</thead>
	</table>
	<div id="toolbar">
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editproduct()">Edit product</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyproduct()">Delete product</a>

	</div>
	
	<div id="dlg" class="easyui-dialog" style="width:600px;height:450px;padding:10px 20px"
			closed="true"  buttons="#dlg-buttons">
		<div class="ftitle">Product Information</div>





		
	        <div class="fitem">
				<label>Item Number:</label>
				<input name="itemno" class="easyui-textbox" >
			</div>

			    <div class="fitem">
				<label>Upc </label>
				<input name="upc" class="easyui-textbox" >
				</div>

				<div class="fitem">
				<label>Description </label>
				<input name="description" class="easyui-textbox" >
				</div>
		
				<div class="fitem">
				<label>Parent UPC:</label>
				<input name="parentupc" class="easyui-textbox" >
				</div>

	        	<div class="fitem">
				<label>Case Cost:</label>
				<input name="case_cost" class="easyui-textbox" >
				</div>

				<div class="fitem">
				<label>Unit Per Case:</label>
				<input name="unit_per_case" class="easyui-textbox" >
				</div>
				
				
				
				
		
		
			
			 <div class="fitem">
				<label>Staus:</label>
				<select class="easyui-combobox" name="state"  labelPosition="top" >
					<option value="active">Active</option>
					<option value="inactive">Inactive</option>
				</select>
			</div>
	
	

		</form>
	</div>
	<div id="dlg-buttons">
		<a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveproduct()" style="width:90px">Save</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
	</div>
	<script type="text/javascript">
		var url;
		function newproduct(){
			$('#dlg').dialog('open').dialog('setTitle','New Product');
			$('#fm').form('clear');
			url = 'action.php?action=save_product';


		}
		function editproduct(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Edit Product');
				$('#fm').form('load',row);
				url = 'action.php?action=update_product&id='+row.id;
			}
		}
		function saveproduct(){
			$('#fm').form('submit',{
				url: url,
				onSubmit: function(){
					return $(this).form('validate');
				},
				success: function(result){
					var result = eval('('+result+')');
					if (result.errorMsg){
						$.messager.show({
							title: 'Error',
							msg: result.errorMsg
						});
					} else {
						$('#dlg').dialog('close');		// close the dialog
						$('#dg').datagrid('reload');	// reload the product data
					}
				}
			});
		}
		function destroyproduct(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$.messager.confirm('Confirm','Are you sure you want to destroy this product?',function(r){
					if (r){
						$.post('action.php?action=destroy_product',{id:row.id},function(result){
							if (result.success){
								$('#dg').datagrid('reload');	// reload the product data
							} else {
								$.messager.show({	// show error message
									title: 'Error',
									msg: result.errorMsg
								});
							}
						},'json');
					}
				});
			}
		}
	</script>
	<style type="text/css">
		#fm{
			margin:0;
			padding:10px 30px;
		}
		.ftitle{
			font-size:14px;
			font-weight:bold;
			padding:5px 0;
			margin-bottom:10px;
			border-bottom:1px solid #ccc;
		}
		.fitem{
			margin-bottom:5px;
		}
		.fitem label{
			display:inline-block;
			width:80px;
		}
		.fitem input{
			width:160px;
		}
	</style>
</body>
</html>