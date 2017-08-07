<?php defined("DATABASE") or die("Access denied"); ?>
<section class="content">
		<div class="excel_file_data no_print"><div class="ajaxloading"><span class="glyphicon glyphicon-refresh"></span>Please wait...</div></div>
		</div>
		<div class="title">
			<h1 class="h1">Members</h1>
		</div>
		<table class="membersTable" id="membersTable">
			<tr class="header">
				<th class="cell">ID</th>
				<th class="cell">Name</th>
				<th class="cell">Phone</th>
				<th class="cell">Email</th>
				<th class="cell">Birthday</th>
			</tr>
			<?= Model_main::getMembers() ?>
		</table>
</section>

<div class="modal fade memberInfo" id="modalInfo">
  <div class="modal-dialog">
    <div class="modal-content" id="content"></div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
	function getMemberInfo(_id){
		$('#modalInfo #content').html('<div class="ajaxloading"><span class="glyphicon glyphicon-refresh"></span>Please wait...</div>');
		$('#modalInfo').modal('show');
		$.ajax({
	        type:'get',//тип запроса: get,post либо head
	        url: 'ajax',//url адрес файла обработчика
	        data:{'type':'memberInfo', 'memberId': _id},//параметры запроса
	        response:'text',//тип возвращаемого ответа text либо xml
	        success:function (data) {//возвращаемый результат от сервера
	            $('#modalInfo #content').html(data);
	            $('.editMember').click(function(){editMember();});
	            $('.deleteMember').click(function(){deleteMember();});
	            $('.saveMember').click(function(){saveMember('edit');});
	        }
		});
	}
</script>
<script type="text/javascript">
	function editMember(){
		var element = $('.inputEditMember');
		for (var i = 0; i < element.length; i++) {
			var _name = $(element[i]).data('name'),
			 	_type = $(element[i]).data('type'),
				_class = $(element[i]).data('class'),
				_val = $(element[i]).html(),
				_input = $("<input>").val(_val).prop('type', _type).prop('name', _name).addClass(_class);
			$(element[i]).html(_input);
		}
		jQuery(function($){
	  		$("input.maskedPhone").mask("+48-999-999-999");
		});
		jQuery(function($){
	  		$("input.maskedBirthday").mask("99.99.9999");
		});
		$('.deleteMember').hide();
		$('.editMember').hide();
		$('.saveMember').show();
		$('.closeMember').removeClass('btn-default').addClass('btn-danger').html('Cancel');
	}
</script>
<script type="text/javascript">
	function deleteMember(){
		var id = $('.deleteMember').data('id');
		if(confirm("Are you sure you want to delete member?") === true){
			$.ajax({
		        type:'get',//тип запроса: get,post либо head
		        url: 'ajax',//url адрес файла обработчика
		        data:{'type':'deleteMember', 'memberId':id},//параметры запроса
		        response:'text',//тип возвращаемого ответа text либо xml
		        success:function (data) {//возвращаемый результат от сервер
		        	if(data == 'success'){
			        	$('#modalInfo').modal('hide');
			        	$('.member_'+id).hide();
			        	$('.alert').fadeIn(500);
						setTimeout(function(){
							$('.alert').fadeOut(500);
						}, 5000);
					}else{
						alert('Operation failed.');
					}
		        }
			});
		}
	}
</script>
<script type="text/javascript">
	function addUser(){
		$('#modalInfo #content').html('<div class="ajaxloading"><span class="glyphicon glyphicon-refresh"></span>Please wait...</div>');
		$('#modalInfo').modal('show');
		$.ajax({
	        type:'get',//тип запроса: get,post либо head
	        url: 'ajax',//url адрес файла обработчика
	        data:{'type':'addUser'},//параметры запроса
	        response:'text',//тип возвращаемого ответа text либо xml
	        success:function (data) {//возвращаемый результат от серверa
	        	$('#modalInfo #content').html(data);
				$('.saveUser').click(function(){saveUser();});
	        }
		});
	}
</script>
<script type="text/javascript">
	function addMember(){
		$('#modalInfo #content').html('<div class="ajaxloading"><span class="glyphicon glyphicon-refresh"></span>Please wait...</div>');
		$('#modalInfo').modal('show');
		$.ajax({
	        type:'get',//тип запроса: get,post либо head
	        url: 'ajax',//url адрес файла обработчика
	        data:{'type':'addMember'},//параметры запроса
	        response:'text',//тип возвращаемого ответа text либо xml
	        success:function (data) {//возвращаемый результат от сервера
	            $('#modalInfo #content').html(data);
				jQuery(function($){
			  		$("input.maskedPhone").mask("+48-999-999-999");
				});
				jQuery(function($){
			  		$("input.maskedBirthday").mask("99.99.9999");
				});
	            $('.saveMember').click(function(){saveMember();});
	        }
		});
	}
</script>
<script type="text/javascript">
	function saveUser(){
		var inputs = $('.addUser input'),
			confirm = true;
		for (var i = 0; i < inputs.length; i++) {
			if($(inputs[i]).val().length < 2){
				alert('Too small login or password');
				confirm = false;
				break;
			}else if($(inputs[i]).prop('name') == 'password' && $(inputs[i]).val().length < 6){
				alert('Too small password. Min length 6');
				confirm = false;
				break;
			}
		}
		if(confirm === true){
			var request = '',
				reqarray = '';
			for (var i = 0; i < inputs.length; i++) {
				reqarray += '"'+ $(inputs[i]).prop('name')+'":"'+ $(inputs[i]).val()+'",';
			}
			request = '{'+reqarray.substr(0, reqarray.length-1)+'}';
			$.ajax({
		        type:'get',//тип запроса: get,post либо head
		        url: 'ajax',//url адрес файла обработчика
		        data:{'type':'addUser', 'request':request},//параметры запроса
		        response:'text',//тип возвращаемого ответа text либо xml
		        success:function (data) {//возвращаемый результат от сервера
		            $('#modalInfo').modal('hide');
		            location.reload(true);
		        }
			});
		}
	}
</script>

<script type="text/javascript">
	function saveMember(_type){
		var inputs = $('.addMember input'),
			confirm = true,
			email = '';
		if(_type == 'edit'){
			inputs = $('.inputEditMember input');
			var _id = $('.deleteMember').data('id');
		}
		for (var i = 0; i < inputs.length; i++) {
			if($(inputs[i]).val().length < 2){
				alert('Too small inputs length');
				confirm = false;
				break;
			}else if($(inputs[i]).prop('name') == 'email' ){
					email = $(inputs[i]).val();
				if( email.length < 6 || email.indexOf('@') < 1 ){
					alert('invalid E-mail');
					confirm = false;
					break;
				}
			}else if($(inputs[i]).prop('name') == 'birthday'){
				if($(inputs[i]).val().substring(0, 2) > 31){
					alert('incorrect birthday day');
					confirm = false;
					break;
				}
				if($(inputs[i]).val().substring(3, 5) > 12){
					alert('incorrect birthday mounth');
					confirm = false;
					break;
				}
				if($(inputs[i]).val().substring(6, 10) < 1917 && $(inputs[i]).val().substring(6, 10) > 2017){
					alert('incorrect birthday year');
					confirm = false;
					break;
				}
			}
		}
		if(confirm === true){
			$.ajax({
		        type:'get',//тип запроса: get,post либо head
		        url: 'ajax',//url адрес файла обработчика
		        data:{'type':'emailCheck', 'email':email},//параметры запроса
		        response:'text',//тип возвращаемого ответа text либо xml
		        success:function (data) {//возвращаемый результат от сервер
		        	if(data == ' find'){
		        		alert('E-mail alredy exist');
						confirm = false;
		        	}else{
						var request = '',
							reqarray = '';
						for (var i = 0; i < inputs.length; i++) {
							reqarray += '"'+ $(inputs[i]).prop('name')+'":"'+ $(inputs[i]).val()+'",';
						}
						request = '{'+reqarray.substr(0, reqarray.length-1)+'}';
						if(_type == 'edit'){
							var reqtype = 'editMember';
						}else{
							var reqtype = 'addMember';
						}
						$.ajax({
					        type:'get',//тип запроса: get,post либо head
					        url: 'ajax',//url адрес файла обработчика
					        data:{'type':reqtype, 'request':request, 'id': _id},//параметры запроса
					        response:'text',//тип возвращаемого ответа text либо xml
					        success:function (data) {//возвращаемый результат от сервер
					        	$('#modalInfo').modal('hide');
					        	location.reload(true);
					        }
						});
		        	}
		        }
			});
		}
	}
</script>