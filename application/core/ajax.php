 <?

if(isset($_GET['type'])){
	switch ($_GET['type']) {
		case 'deleteMember':
			if(isset($_GET['memberId'])){
				include "application/models/model_main.php";
				$delete = Model_main::memberDelete($_GET['memberId']);
				if($delete == 'success'){
					$_SESSION['message']['type'] = 'success';
			        $_SESSION['message']['text'] = 'Delete success';
					echo 'success'; 
				}
			}
			break;
		case 'emailCheck':
			include "application/models/model_main.php";
			if(Model_main::getMemberEmail($_GET['email']) == 'find'){
				echo 'find';
			}
			break;

		case 'memberInfo':
			if(isset($_GET['memberId'])){
				include "application/models/model_main.php";
				$member = Model_main::getMemberInfo($_GET['memberId']); 
				if( !is_null($member) ) { ?>
                  <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			        <h4 class="modal-title"><span data-name="name" data-type="text" class="inputEditMember"><?= $member['name'] ?></span> <span data-name="surname" data-type="text" class="inputEditMember"><?= $member['surname'] ?></span></h4>
			      </div>
			      <div class="modal-body">
			      	<div class="container-fluid">
						<div class="col-md-4">
							<div class="photo">
								<?php if(file_exists("images/members/{$member['id']}.jpg")) { ?>
									<img src="<?= PATH ?>images/members/<?= $member['id'] ?>.jpg" alt="">
								<?php }else{?>
									<img src="<?= PATH ?>images/members/nophoto.jpg" alt="">
								<?php }?>
							</div>
						</div>
						<div class="col-md-8">
							<h5 class="h5">Info</h5>
							<div class="line">
								<div class="cell">Phone</div>
								<div class="cellBig"><span data-name="phone" data-class="maskedPhone" data-type="text" class="inputEditMember"><?= (isset($member['phone']) && strlen($member['phone']) > 0 ) ? $member['phone'] : '---' ?></span></div>
							</div>
							<div class="line">
								<div class="cell">Email</div>
								<div class="cellBig"><span data-name="email" data-type="email"  class="inputEditMember"><?= (isset($member['email']) && strlen($member['email']) > 0 ) ? $member['email'] : '---' ?></span></div>
							</div>
							<div class="line">
								<div class="cell">Birthday</div>
								<div class="cellBig"><span data-name="birthday_date" data-type="text" data-class="maskedBirthday" class="inputEditMember"><?= date('d.m.Y', strtotime($member['birthday_date'])) ?></span></div>
							</div>
						</div>
					</div>
			      </div>
			      <div class="modal-footer">
			      	<button type="button" style="float: left;" class="btn btn-danger deleteMember" data-id="<?= $member['id'] ?>">Delete</button>
			      	<button type="button" style="float: left; display: none;" class="btn btn-success saveMember" data-id="<?= $member['id'] ?>">Save</button>
			      	<button type="button" class="btn btn-warning editMember">Edit</button>
			        <button type="button" class="btn btn-default closeMember" data-dismiss="modal">Close</button>
			      </div>
			<?php } else { ?>
				<div class="ajaxloading error"><span class="glyphicon glyphicon-remove"></span>ERROR! Command not found!</div>
			<?php } }
			break;

		case 'addUser':
			if( !isset($_GET['request']) ) { ?>
             <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title">Add new user</h4>
		      </div>
		      <div class="modal-body addUser">
		      	<div class="container-fluid">
					<div class="col-md-12">
						<div class="line">
							<div class="cell">Name</div>
							<div class="cellBig"><input type="text" name="name"></div>
						</div>
						<div class="line">
							<div class="cell">Password</div>
							<div class="cellBig"><input type="password" name="password"></div>
						</div>
					</div>
				</div>
		      </div>
		      <div class="modal-footer">
		      	<button type="button" class="btn btn-success saveUser">Save</button>
		        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
		      </div>
			<?php } else{
				include "application/models/model_main.php";
				$addUser = Model_main::addUser($_GET['request']);
			}
			break;

		case 'addMember':
			if( !isset($_GET['request']) ) { ?>
                <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title">Add new user</h4>
		      </div>
		      <div class="modal-body addMember">
		      	<div class="container-fluid">
					<div class="col-md-12">
						<div class="line">
							<div class="cell">Name</div>
							<div class="cellBig"><input type="text" name="name"></div>
						</div>
						<div class="line">
							<div class="cell">Surname</div>
							<div class="cellBig"><input type="text" name="surname"></div>
						</div>
						<div class="line">
							<div class="cell">Phone</div>
							<div class="cellBig"><input type="text" name="phone" class="maskedPhone"></div>
						</div>
						<div class="line">
							<div class="cell">Email</div>
							<div class="cellBig"><input type="email" name="email"></div>
						</div>
						<div class="line">
							<div class="cell">Birthday</div>
							<div class="cellBig"><input type="text" name="birthday_date" class="maskedBirthday"></div>
						</div>
					</div>
				</div>
		      </div>
		      <div class="modal-footer">
		      	<button type="button" class="btn btn-success saveMember">Save</button>
		        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
		      </div>
			<?php } else{
				include "application/models/model_main.php";
				$addMember = Model_main::addMember($_GET['request']);
			}
			break;

		case 'editMember':
			if( isset($_GET['request']) ) { 
				include "application/models/model_main.php";
				$addMember = Model_main::editMember($_GET['request'], $_GET['id']);
			}
			break;

		case 'generate':
			include "application/models/model_main.php";
			$result = Model_main::getnerateText($_GET['text']); 
			echo $result;
			break;

		default:
			echo '<div>Отримали порожні дані через Ajax</div>';
			break;
	}
}