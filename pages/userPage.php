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

<script type="text/javascript" src="pages/bases/javascript/navigationArrows/userPage.js"></script>

<?php 
// If this page is called by an error, will be open the modal window that was being used
if (!empty($_SESSION['openModalWindow'])){
echo "
<script type='text/javascript'>
	$(document).ready(function() {
		libOpenModalWindow('{$_SESSION['openModalWindow']}');
	});
</script>";
}
unset($_SESSION['openModalWindow']);
?>

<div class="userPage">
	<div id="topMenu">
		<div id="logo"></div>
		
		<div id="buttonsAccessibility">
			<input 
				id="btn2"
				type="submit"
				type="image"
				onfocus="showTip('tipFontLess', 'btn2')" 
				onblur="hideTip('tipFontLess')" 
				onmouseover="showTip('tipFontLess')" 
				onmouseout="hideTip('tipFontLess')"
				value=""
				alt="<?php echo $msgs->getText('roomTemplate.btnFontLess.description'); ?>" 
				onclick="resizeFont('less')"
				aria-describedby="tipFontLess"
			/>
			<input 
				id="btn3"
				type="submit"
				type="image"
				onfocus="showTip('tipFontMore', 'btn3')" 
				onblur="hideTip('tipFontMore')" 
				onmouseover="showTip('tipFontMore')" 
				onmouseout="hideTip('tipFontMore')" 
				value=""
				alt="<?php echo $msgs->getText('roomTemplate.btnFontMore.description'); ?>"
				onclick="resizeFont('more')"
				aria-describedby="tipFontMore"
			/>	
		</div>
		
		<div id="buttonsOthers">
			<input 
				type="submit"
				id="btn7"
				type="image"
				style="background-image: url('pages/images/btn7.gif');"
				alt=""
				value=""
				onfocus="showTip('tipHelp', 'btn7')" 
				onblur="hideTip('tipHelp')" 
				onmouseover="showTip('tipHelp')" 
				onmouseout="hideTip('tipHelp')" 
				onclick="libOpenModalWindow('#dialogHelp'); currentModalWindow='dialogHelp';"
				aria-describedby="tipHelp"
				class="counterNavigationUserPage"
			/>
			<form action="wb.php" method="get" style="display:inline">
				<input  type="hidden" name="do" value="logout" />
				<input  
					id="btnLogoutUserPage"
					type="submit"
					type="image" 
					onfocus="showTip('tipBtnLogout', 'btnLogoutUserPage')" 
					onblur="hideTip('tipBtnLogout')"  
					onmouseover="showTip('tipBtnLogout')" 
					onmouseout="hideTip('tipBtnLogout')" 
					value=""
					class="counterNavigationUserPage"
					alt="<?php echo $msgs->getText('userPage.btnLogout.description'); ?>" 
					aria-describedby="tipBtnLogout"
				/>
			</form>
		</div>	
		
	</div>
	<div id="tipsBar">
		<div id="tipBtnLogout" class="tip">
		   	 <?php echo $msgs->getText('userPage.btnLogout.description'); ?>
		</div>
		<div id="tipUptUser" class="tip">
		  	 <?php echo $msgs->getText('userPage.uptUser.description'); ?>
		</div>
		<div id="tipCreateRoom" class="tip">
		   	 <?php echo $msgs->getText('userPage.createRoom.description'); ?>
		</div>
		<div id="tipUptRoom" class="tip">
			<?php echo $msgs->getText('listRoons.editRoom.description'); ?>
		</div>
		<div id="tipEnterRoom" class="tip">
			<?php echo $msgs->getText('listRoons.enterRoom.description'); ?>
		</div>
		<div id="tipFontMore" class="tip">
			<?php echo $msgs->getText('roomTemplate.btnFontMore.description'); ?>
		</div>
		<div id="tipFontLess" class="tip">
			<?php echo $msgs->getText('roomTemplate.btnFontLess.description'); ?>
		</div>
		<div id="tipHelp" class="tip">
			<?php echo $msgs->getText('roomTemplate.btnHelp.description'); ?>
		</div>
		<div id="tipModalRoomCode" class="tip">
			<?php echo $msgs->getText('userPage.roomCode2.description'); ?>
		</div>
	</div>
	<div id="bodyUserPage">
		<div id="listRooms">
			<div id="titleListRooms"><?php echo $msgs->getText('listRoons.title');?></div>
			<div id="boxRooms">
				<?php require_once 'pages/listRoons.php';?>
			</div>
			
			<?php if ($_SESSION['roomCreator']){?>
				<input 
					id="btnOpenNewRoomForm"
					type="submit"
					type="image"
					class="counterNavigationUserPage"
					onfocus="showTip('tipCreateRoom', 'btnOpenNewRoomForm')" 
					onblur="hideTip('tipCreateRoom')"  
					onmousemove="showTip('tipCreateRoom')" 
					onmouseout="hideTip('tipCreateRoom')"  
					value="<?php echo $msgs->getText('userPage.createRoom'); ?>" 
					alt="<?php echo $msgs->getText('userPage.createRoom.description'); ?>"
					onclick="$('#dialogNewRoom').dialog('open'); currentModalWindow='dialogCreateRoom';"
					aria-describedby="tipCreateRoom"
				/>
			<?php } ?>
			
		</div>
		
		<div id="panelUptUser">
			<div style="margin-top: 10px; padding-left: 50px;">
				<?php echo $msgs->getText('userPage.uptUser'); ?>
			</div>
			<div style="margin-top: 10px; padding-left: 95px;">
				<input 
					id="btnUpdateAccount"
					type="submit"
					type="image"
					onfocus="showTip('tipUptUser', 'btnUpdateAccount')" 
					onblur="hideTip('tipUptUser')"
					onmousemove="showTip('tipUptUser')" 
					onmouseout="hideTip('tipUptUser')"
					value="" 
					class="counterNavigationUserPage"
					alt="<?php echo $msgs->getText('userPage.uptUser.description'); ?>"
					onclick="$('#dialogUpdateUser').dialog('open'); currentModalWindow='dialogUptUser';"
					aria-describedby="tipUptUser"
				/>
			</div>
		</div>
		
		<div id="panelEnterRoom">
			<div style="padding-left: 20px; padding-top: 20px;">
				
				<?php echo $msgs->getText('userPage.roomCodeUserPage') . "<br/>"; ?>
				<br />
				
				<div style="padding-left: 50px;">
					<input 
						id="btnModalRoomCode"
						type="submit"
						type="image"
						onfocus="showTip('tipModalRoomCode', 'btnModalRoomCode')" 
						onblur="hideTip('tipModalRoomCode')"
						onmousemove="showTip('tipModalRoomCode')" 
						onmouseout="hideTip('tipModalRoomCode')"
						value="" 
						class="counterNavigationUserPage"
						alt="<?php echo $msgs->getText('userPage.roomCodeUserPage'); ?>"
						onclick="$('#dialogRoomCode').dialog('open'); currentModalWindow='dialogRoomCode';"
						aria-describedby="tipModalRoomCode"
					/>
				</div>
				
			</div>
		</div>

		<div id="panelPublicity"></div>
		
	</div>

	<div id="dialogUpdateUser" title="<?php echo $msgs->getText('updateUserForm.title'); ?>" class="dialog">
		<?php require_once 'pages/updateUserForm.php';?>
	</div>

	<div id="dialogNewRoom" title="<?php echo $msgs->getText('newRoomForm.title'); ?>" class="dialog">
		<?php require_once 'pages/newRoomForm.php';?>
	</div>
	
	<div id="dialogUpdateRoom" title="<?php echo $msgs->getText('updateRoomForm.title'); ?>" class="dialog">
		<?php require_once 'pages/updateRoomForm.php';?>
	</div>
	
	<div id="dialogHelp" title="<?php echo $msgs->getText('roomTemplate.dialogHelp.Title'); ?>" class="dialog"> 
		<?php require_once 'pages/dialogHelp.php';?>
	</div>
	
	<div id="dialogRoomCode" title="<?php echo $msgs->getText('roomTemplate.dialogRoomCode.Title'); ?>" class="dialog"> 
		<?php require_once 'pages/dialogRoomCode.php';?>
	</div>
	
</div>
