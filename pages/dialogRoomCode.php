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

<?php $msgs = Localization::getInstance(); ?>

	
<div class="helpForm">

	<form action="wb.php?do=enterWithCode" method="post">
		
		<?php echo $msgs->getText('userPage.roomCodeTitle') . "<br/>"; ?>
		<br />
		
		<input 
			id="textRoomCode" 
			type="text" 
			class="input counterNavigationCode"
			name="roomCode" 
			onfocus="showTip('tipRoomCode', 'textRoomCode')" 
			onblur="hideTip('tipRoomCode')" 
			onmousemove="showTip('tipRoomCode')" 
			onmouseout="hideTip('tipRoomCode')" 
		    alt="<?php echo $msgs->getText('userPage.roomCode.description'); ?>"
			maxlength="32"
			size="18"
			aria-describedby="tipRoomCode"
		/>
		
		<input 
			id="btnEnterRoomCode"
			type="submit"
			type="image"
			class="counterNavigationCode"
			onfocus="showTip('tipEnterRoom', 'textEnterRoom')" 
			onblur="hideTip('tipEnterRoom')"
			onmousemove="showTip('tipEnterRoom')" 
			onmouseout="hideTip('tipEnterRoom')"   
			value="<?php echo $msgs->getText('listRoons.enterRoom'); ?>" 
			alt="<?php echo $msgs->getText('userPage.enterRoom.description'); ?>"
			aria-describedby="tipEnterRoom"
		/>
	</form>	

	<div class="center" style="float: right;">	
		<div id="tipBtnCloseRoomCode" class="tip">
	     	 <?php echo $msgs->getText('userPage.btnClose.description'); ?>
		</div>	
		<div id="tipRoomCode" class="tip">
		   	 <?php echo $msgs->getText('userPage.roomCode.description'); ?>
		</div>
		<div id="tipEnterRoom" class="tip">
			<?php echo $msgs->getText('listRoons.enterRoom.description'); ?>
		</div>	
	</div>
	
</div>