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

$action = new ActionMapping();
$action->setName("listUsers");
$action->setType("ListUsersAction");
$action->setRole("");

$listUsersAction = new ListUsersAction();
$listUsersAction->execute($action);

$users = $_REQUEST['users'];
?>
<script type="text/javascript">
	$('#textBtnLeft').focus(function(){
		$('#textNewRoomSubmit').focus();
	})
	
	$('#selectelectedUsers').focus(function(){
		$('#selectAllUsers').focus();
	})
	
	$("#selectAllUsers").keydown(function(event) {
		switch(event.which)	{
			case 32:
				var retorno = move(this.form.list1,this.form.list2); 
				myfilter = new filterlist(document.inviteFriendForm.list1);
				break;
		}
	});	
</script>
<form action="wb.php?do=createRoom" method="post" name="newRoomForm">
	
	<div class="newRoom">
		
		<div class="line">
			<div class="left">
				<?php echo $msgs->getText('newRoomForm.name'); ?>
			</div>
			<input 
				id="textNewRoomName" 
				type="text" 
				class="input counterNavigationCreateRoom"
				name="name" 
				onfocus="showTip('tipNewRoomName', 'textNewRoomName')" 
				onblur="hideTip('tipNewRoomName')" 
				onmousemove="showTip('tipNewRoomName')" 
				onmouseout="hideTip('tipNewRoomName')" 
			    alt="<?php echo $msgs->getText('newRoomForm.name.description'); ?>"
				maxlength="45"
				aria-describedby="tipNewRoomName"
			/>
		</div>	

		<div class="center">
			<br />
			<?php echo $msgs->getText('newRoomForm.permissionsTitle'); ?>
		</div>
		
		<?php echo $msgs->getText('newRoomForm.srcUserName'); ?><br />
		
		<input 
			id="textSrcUserName" 
			type="text" 
			class="inputSrc counterNavigationCreateRoom"
			name="scrUserName" 
			onfocus="showTip('tipSrcUserName', 'textSrcUserName')" 
			onblur="hideTip('tipSrcUserName')"
			onmousemove="showTip('tipSrcUserName')" 
			onmouseout="hideTip('tipSrcUserName')" 
			onkeyup="myfilter.set(this.value)"
			alt="<?php echo $msgs->getText('newRoomForm.srcUserName.description'); ?>"
			aria-describedby="tipSrcUserName"
			size="15"
		/>
		
		<br />
		
		<div class="lLeft">
			<select 
				id="selectAllUsers"
				multiple 
				size="10"
				onfocus="showTip('tipListAllUsers', 'textListAllUsers')" 
				onblur="hideTip('tipListAllUsers')"
				onmousemove="showTip('tipListAllUsers')" 
				onmouseout="hideTip('tipListAllUsers')"  
				name="list1"
				aria-describedby="tipListAllUsers"
				class="counterNavigationCreateRoom"
			>
				<?php 
                foreach ($users as $user){
                		if ($user->getUserId() != $_SESSION['id']){
                	?>
                	<option 
                		value="<?php echo $user->getUserId(); ?>"
                	>
                		<?php echo $user->getName(); ?>
                	</option>
                <?php
                		}
                	}
                ?>
			</select>
			
			<SCRIPT TYPE="text/javascript">
				var myfilter = new filterlist(document.newRoomForm.list1);
			</SCRIPT>		
		</div>
		
		<div class="bLeft">
			<input 
				id="textBtnLeft"
				type="button"
				onfocus="showTip('tipBtnLeft', 'textBtnLeft')" 
				onblur="hideTip('tipBtnLeft')"
				onmousemove="showTip('tipBtnLeft')" 
				onmouseout="hideTip('tipBtnLeft')"  
				onClick="move(this.form.list2,this.form.list1)"  
				value="<" 
			    alt="<?php echo $msgs->getText('newRoomForm.btnLeft.description'); ?>"
			    aria-describedby="tipBtnLeft"
			/>
			<input 
				id="textBtnRight"
				type="button"
				onfocus="showTip('tipBtnRight', 'textBtnRight')" 
				onblur="hideTip('tipBtnRight')"
				onmousemove="showTip('tipBtnRight')" 
				onmouseout="hideTip('tipBtnRight')" 
				onClick="move(this.form.list1,this.form.list2)"  
				value=">" 
			    alt="<?php echo $msgs->getText('newRoomForm.btnRight.description'); ?>"
			    aria-describedby="tipBtnRight"
			/>
		</div>
		
		<div class="lLeft">
			<select 
				id="selectelectedUsers"
				multiple 
				size="10"
				onfocus="showTip('tipListSelectedUsers', 'textListSelectedUsers')" 
				onblur="hideTip('tipListSelectedUsers')" 
				onmousemove="showTip('tipListSelectedUsers')" 
				onmouseout="hideTip('tipListSelectedUsers')" 
				name="list2"
				aria-describedby="tipListSelectedUsers"
			>
			</select> 		
		</div>
		
		<div class="center" style="float: right;"><br />
			<input 
				id="textNewRoomSubmit"
				class="counterNavigationCreateRoom"
				type="submit"
				onfocus="showTip('tipNewRoomSubmit', 'textNewRoomSubmit')" 
				onblur="hideTip('tipNewRoomSubmit')" 
				onmousemove="showTip('tipNewRoomSubmit')" 
				onmouseout="hideTip('tipNewRoomSubmit')" 
				onClick="selectListBoxAllOptions(this.form.list2)"
				value="<?php echo $msgs->getText('newRoomForm.submit'); ?>" 
			    alt="<?php echo $msgs->getText('newRoomForm.submit.description'); ?>"
			    aria-describedby="tipNewRoomSubmit"
			/>
		</div>
		
		<div class="line">
			<font size="2"><?php echo $msgs->getText('userPage.requiredField');?></font>
		</div>
			
		<input type="hidden" name="idsSelecteds" />
			
		<div class="center" style="float: right;">
			<div id="tipNewRoomName" class="tip">
		     	 <?php echo $msgs->getText('newRoomForm.name.description'); ?>
			</div>
			<div id="tipNewRoomSubmit" class="tip">
		     	 <?php echo $msgs->getText('newRoomForm.submit.description'); ?>
			</div>		
			<div id="tipBtnCloseNewRoomForm" class="tip">
		     	 <?php echo $msgs->getText('userPage.btnClose.description'); ?>
			</div>	
			<div id="tipSrcUserName" class="tip">
		     	 <?php echo $msgs->getText('newRoomForm.srcUserName.description'); ?>
			</div>
			<div id="tipListAllUsers" class="tip">
		     	 <?php echo $msgs->getText('newRoomForm.listAllUsers.description'); ?>
			</div>
			<div id="tipListSelectedUsers" class="tip">
		     	 <?php echo $msgs->getText('newRoomForm.listSelectedUsers.description'); ?>
			</div>
			<div id="tipBtnRight" class="tip">
		     	 <?php echo $msgs->getText('newRoomForm.btnRight.description'); ?>
			</div>
			<div id="tipBtnLeft" class="tip">
		     	 <?php echo $msgs->getText('newRoomForm.btnLeft.description'); ?>
			</div>
		</div>
	</div>
</form>