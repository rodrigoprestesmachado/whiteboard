<?php 
	/**
	 * Copyright 2011 - Nucleo de Informatica na Educacao Especial (NIEE) 
	 * 
	 * Licensed under the Apache License, Version 2.0 (the "License");
	 * you may not use this file except in compliance with the License.
	 * You may obtain a copy of the License at
	 * 
	 *     http://www.apache.org/licenses/LICENSE-2.0
	 * 
	 * Unless required by applicable law or agreed to in writing, software
	 * distributed under the License is distributed on an "AS IS" BASIS,
	 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
	 * See the License for the specific language governing permissions and
	 * limitations under the License.
	 */
?>

<?php 
$msgs = Localization::getInstance(); 

// List users
$action = new ActionMapping();
$action->setName("listUsers");
$action->setType("ListUsersAction");
$action->setRole("");

$listUsersAction = new ListUsersAction();
$listUsersAction->execute($action);

$listUsers = $_REQUEST['users'];
$listUsers2 = $_REQUEST['users'];

// List permissions
$_POST['currentRoom'] = $_GET['idRoom'];
$action = new ActionMapping();
$action->setName("listPermissions");
$action->setType("ListPermissionsAction");
$action->setRole("");

$listPermissionsAction = new ListPermissionsAction();
$listPermissionsAction->execute($action);

$listPermissions = $_REQUEST["permissions"];

?>
<script type="text/javascript">
	$('#textBtnLeft3').focus(function(){
		$('#textInviteFriendSubmit').focus();
	})
	
	$('#selectelectedUsers3').focus(function(){
		$('#selectAllUsers3').focus();
	})
	
	$("#selectAllUsers3").keydown(function(event) {
		switch(event.which)	{
			case 32:
				var retorno = move(this.form.list1,this.form.list2); 
				myfilter3 = new filterlist(document.inviteFriendForm.list1);
				break;
		}
	});	
</script>
<form action="wb.php?do=inviteFriends" method="post" name="inviteFriendForm">
	
	<div class="inviteFriend">
	
		<?php echo $msgs->getText('inviteFriendForm.message'); ?>
		
		<textarea 
			id="textareainviteFriend"
			name="inviteFriendMessage"
			class="input counterNavigationInviteFriends"
			onfocus="showTip('tipInviteFriendMessage', 'inviteFriendMessage')" 
			onblur="hideTip('tipInviteFriendMessage')"
			onmousemove="showTip('tipInviteFriendMessage')" 
			onmouseout="hideTip('tipInviteFriendMessage')"
			rows="5" 
			cols="10"
			style="resize: none;"
			aria-describedby="tipInviteFriendMessage"></textarea>
			
			
		<div class="center">
			<br />
			<?php echo $msgs->getText('newRoomForm.permissionsTitle'); ?>
		</div>	
		
		<?php echo $msgs->getText('newRoomForm.srcUserName'); ?><br />
		
		<input 
			id="textSrcUserName3" 
			type="text" 
			class="inputSrc counterNavigationInviteFriends"
			name="scrUserName" 
			onfocus="showTip('tipSrcUserName3', 'textSrcUserName3')" 
			onblur="hideTip('tipSrcUserName3')"
			onmousemove="showTip('tipSrcUserName3')" 
			onmouseout="hideTip('tipSrcUserName3')"
			onkeyup="myfilter3.set(this.value)"
			alt="<?php echo $msgs->getText('newRoomForm.srcUserName.description'); ?>"
			aria-describedby="tipSrcUserName3"
			size="15"
		/>
		
		<br />
		
		<div class="lLeft">
			<select 
				id="selectAllUsers3"
				multiple 
				size="10"
				class="counterNavigationInviteFriends"
				onfocus="showTip('tipListAllUsers3', 'textListAllUsers3')" 
				onblur="hideTip('tipListAllUsers3')" 
				onmousemove="showTip('tipListAllUsers3')" 
				onmouseout="hideTip('tipListAllUsers3')"
				name="list1"
				aria-describedby="tipListAllUsers3"
			>
				<?php 
				$control = FALSE;
                foreach ($listUsers as $user){
                	if ($user->getUserId() != $_SESSION['id']){
                		foreach ($listPermissions as $permission){
                			if ($user->getUserId() == $permission->getUserId()){
                				$control = TRUE;
                			}
                		}
                		if (!$control){
                			?>
                			<option	value="<?php echo $user->getEmail(); ?>">
                			<?php echo $user->getName(); ?>
                			</option>
                			<?php
                		}
                		$control = FALSE;
                	}
                }
                ?>
			</select>
			
			<SCRIPT TYPE="text/javascript">
				var myfilter3 = new filterlist(document.inviteFriendForm.list1);
			</SCRIPT>
		
		</div>
		
		<div class="bLeft">
			<input 
				id="textBtnLeft3"
				type="button"
				onfocus="showTip('tipBtnLeft3', 'textBtnLeft3')" 
				onblur="hideTip('tipBtnLeft3')"
				onmousemove="showTip('tipBtnLeft3')" 
				onmouseout="hideTip('tipBtnLeft3')"
				onClick="move(this.form.list2,this.form.list1); myfilter3 = new filterlist(document.inviteFriendForm.list1);"  
				value="<" 
			    alt="<?php echo $msgs->getText('newRoomForm.btnLeft.description'); ?>"
			    aria-describedby="tipBtnLeft3"
			/>
			<input 
				id="textBtnRight3"
				type="button"
				onfocus="showTip('tipBtnRight3', 'textBtnRight3')" 
				onblur="hideTip('tipBtnRight3')"
				onmousemove="showTip('tipBtnRight3')" 
				onmouseout="hideTip('tipBtnRight3')"
				onClick="move(this.form.list1,this.form.list2); myfilter3 = new filterlist(document.inviteFriendForm.list1);"  
				value=">" 
			    alt="<?php echo $msgs->getText('newRoomForm.btnRight.description'); ?>"
			    aria-describedby="tipBtnRight3"
			/>
		</div>
		
		<div class="lLeft">
			<select 
				id="selectelectedUsers3"
				multiple 
				size="10"
				onfocus="showTip('tipListSelectedUsers3', 'textListSelectedUsers3')" 
				onblur="hideTip('tipListSelectedUsers3')" 
				onmousemove="showTip('tipListSelectedUsers3')" 
				onmouseout="hideTip('tipListSelectedUsers3')"
				name="list2"
				aria-describedby="tipListSelectedUsers3"
			>
			</select> 	
		</div>
		
		<div class="center" style="float: right;"><br />
			<input 
				id="textInviteFriendSubmit"
				type="submit"
				class="counterNavigationInviteFriends"
				onfocus="showTip('tipInviteFriendSubmit', 'textInviteFriendSubmit')" 
				onblur="hideTip('tipInviteFriendSubmit')"  
				onmousemove="showTip('tipInviteFriendSubmit')" 
				onmouseout="hideTip('tipInviteFriendSubmit')"
				onClick="selectListBoxAllOptions3(this.form.list2);"
				value="<?php echo $msgs->getText('inviteFriendForm.submit'); ?>" 
			    alt="<?php echo $msgs->getText('inviteFriendForm.submit.description'); ?>"
			    aria-describedby="tipInviteFriendSubmit"
			/>
			<input type="hidden" name="roomId" value="<?php echo $_GET['idRoom']; ?>"/>		
		</div>
	
		<input type="hidden" name="emailsSelecteds" />
		
		<div class="center" style="float: right;">	
			<div id="tipInviteFriendMessage" class="tip">
		     	 <?php echo $msgs->getText('inviteFriendForm.message.description'); ?>
			</div>
			<div id="tipInviteFriendSubmit" class="tip">
		     	 <?php echo $msgs->getText('updateRoomForm.submit.description'); ?>
			</div>
			<div id="tipBtnCloseInviteFriendForm" class="tip">
		     	 <?php echo $msgs->getText('userPage.btnClose.description'); ?>
			</div>	
			<div id="tipSrcUserName3" class="tip">
		     	 <?php echo $msgs->getText('newRoomForm.srcUserName.description'); ?>
			</div>
			<div id="tipListAllUsers3" class="tip">
		     	 <?php echo $msgs->getText('newRoomForm.listAllUsers.description'); ?>
			</div>
			<div id="tipListSelectedUsers3" class="tip">
		     	 <?php echo $msgs->getText('newRoomForm.listSelectedUsers.description'); ?>
			</div>
			<div id="tipBtnRight3" class="tip">
		     	 <?php echo $msgs->getText('newRoomForm.btnRight.description'); ?>
			</div>
			<div id="tipBtnLeft3" class="tip">
		     	 <?php echo $msgs->getText('newRoomForm.btnLeft.description'); ?>
			</div>
		</div>
	</div>
</form>