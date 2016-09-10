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
	
	<table id="dg" title="My Users" class="easyui-datagrid" style="width:90%;height:80%"
			url="action.php?action=get_users"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
				<th field="username" width="50">Username</th>
				<th field="fullname" width="50">Fullname</th>
				<th field="email" width="50">Email</th>
				<th field="phone" width="50">Phone</th>
				<th field="usertype" width="50">User Type</th>

			</tr>
		</thead>
	</table>
	<div id="toolbar">
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">New User</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Edit User</a>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width:600px;height:350px;padding:10px 20px"
			closed="true" buttons="#dlg-buttons">
		<div class="ftitle">User Information</div>
		<form id="fm" method="post" novalidate>
			<div class="fitem">
				<label>Username:</label>
				<input name="username" class="easyui-textbox" required="true">
			</div>
		
	        <div class="fitem">
				<label>Password:</label>
				<input name="password" class="easyui-textbox" required="true">
			</div>
		
	        <div class="fitem">
				<label>Fullname:</label>
				<input name="fullname" class="easyui-textbox" >
			</div>
		


	        <div class="fitem">
				<label>Phone:</label>
				<input name="phone" class="easyui-textbox" >
			</div>
		


        <div class="fitem">
				<label>User Type:</label>
				<select class="easyui-combobox" name="state"  >
					<option value="manager">Manager</option>
					<option value="operator">Operator</option>
					<option value="admin">Administrator</option>

				</select>
			</div>
			
			
			
	



			<div class="fitem">
				<label>Store Name:</label>
				 <select class="easyui-combobox" name="state"   >
				 	<option value="">Please Select Store</option>
				 <?php
				 $getStore=R::getAll("select *from store");
				 foreach($getStore as $store)
				 {
				 	print("<option value=$store[id]>$store[store_name]</option>");				 }
				 ?>
				 </select>	
				
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
		<a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Save</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
	</div>
	<script type="text/javascript">
		var url;
		function newUser(){
			$('#dlg').dialog('open').dialog('setTitle','New User');
			$('#fm').form('clear');
			url = 'action.php?action=save_user';
		}
		function editUser(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Edit User');
				$('#fm').form('load',row);
				url = 'action.php?action=update_user&id='+row.id;
			}
		}
		function saveUser(){
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
						$('#dg').datagrid('reload');	// reload the user data
					}
				}
			});
		}
		function destroyUser(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$.messager.confirm('Confirm','Are you sure you want to destroy this user?',function(r){
					if (r){
						$.post('action.php?action=destroy_user',{id:row.id},function(result){
							if (result.success){
								$('#dg').datagrid('reload');	// reload the user data
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