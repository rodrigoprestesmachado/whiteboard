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
?>
<script type="text/javascript">
	$('#textBtnLeft2').focus(function(){
		$('#textUpdateRoomSubmit').focus();
	})
	
	$('#selectelectedUsers2').focus(function(){
		$('#selectAllUsers2').focus();
	})
	
	$("#selectAllUsers2").keydown(function(event) {
		switch(event.which)	{
			case 32:
				var retorno = move(this.form.list1,this.form.list2); 
				myfilter2 = new filterlist(document.inviteFriendForm.list1);
				break;
		}
	});	
</script>

<form action="wb.php?do=updateRoom" method="post" name="uptRoomForm">
	
	<div class="updateRoom">

		<div class="line">
			<div class="left">
				<?php echo $msgs->getText('updateRoomForm.roomName'); ?>
			</div>
			<input 
				id="textUpdateRoomName" 
				type="text" 
				class="input counterNavigationUptRoom"
				name="roomName" 
				onfocus="showTip('tipUpdateRoomName', 'textUpdateRoomName')" 
				onblur="hideTip('tipUpdateRoomName')" 
				onmousemove="showTip('tipUpdateRoomName')" 
				onmouseout="hideTip('tipUpdateRoomName')" 
			    alt="<?php echo $msgs->getText('updateRoomForm.name.description'); ?>"
				maxlength="45"
				aria-describedby="tipUpdateRoomName"
			/>
		</div>	
		
		<div class="center">
			<br />
			<?php echo $msgs->getText('newRoomForm.permissionsTitle'); ?>
		</div>
		
		<?php echo $msgs->getText('newRoomForm.srcUserName'); ?><br />
		
		<input 
			id="textSrcUserName2" 
			type="text" 
			class="inputSrc counterNavigationUptRoom"
			name="scrUserName" 
			onfocus="showTip('tipSrcUserName2', 'textSrcUserName2')" 
			onblur="hideTip('tipSrcUserName2')"
			onmousemove="showTip('tipSrcUserName2')" 
			onmouseout="hideTip('tipSrcUserName2')" 
			onkeyup="myfilter2.set(this.value)"
			alt="<?php echo $msgs->getText('newRoomForm.srcUserName.description'); ?>"
			aria-describedby="tipSrcUserName2"
			size="15"
		/>
		
		<br />
		
		<div class="lLeft">
			<select 
				id="selectAllUsers2"
				class="counterNavigationUptRoom"
				multiple 
				size="10"
				onfocus="showTip('tipListAllUsers2', 'textListAllUsers2')" 
				onblur="hideTip('tipListAllUsers2')" 
				onmousemove="showTip('tipListAllUsers2')" 
				onmouseout="hideTip('tipListAllUsers2')" 
				name="list1"
				aria-describedby="tipListAllUsers2"
			>
			</select>
			<SCRIPT TYPE="text/javascript">
				var myfilter2 = new filterlist(document.uptRoomForm.list1);
			</SCRIPT>
		</div>
		
		<div class="bLeft">
                <input 
				id="textBtnLeft2"
				type="button"
				onfocus="showTip('tipBtnLeft2', 'textBtnLeft2')" 
				onblur="hideTip('tipBtnLeft2')"
				onmousemove="showTip('tipBtnLeft2')" 
				onmouseout="hideTip('tipBtnLeft2')" 
				onClick="move(this.form.list2,this.form.list1); myfilter2 = new filterlist(document.uptRoomForm.list1);"  
				value="<" 
			    alt="<?php echo $msgs->getText('newRoomForm.btnLeft.description'); ?>"
			    aria-describedby="tipBtnLeft2"
			/>
			<input 
				id="textBtnRight2"
				type="button"
				onfocus="showTip('tipBtnRight2', 'textBtnRight2')" 
				onblur="hideTip('tipBtnRight2')"
				onmousemove="showTip('tipBtnRight2')" 
				onmouseout="hideTip('tipBtnRight2')" 
				onClick="move(this.form.list1,this.form.list2); myfilter2 = new filterlist(document.uptRoomForm.list1);"  
				value=">" 
			    alt="<?php echo $msgs->getText('newRoomForm.btnRight.description'); ?>"
			    aria-describedby="tipBtnRight2"
			/>
		</div>
		
		<div class="lLeft">
			<select 
				id="selectelectedUsers2"
				multiple 
				size="10"
				onfocus="showTip('tipListSelectedUsers2', 'textListSelectedUsers2')" 
				onblur="hideTip('tipListSelectedUsers2')" 
				onmousemove="showTip('tipListSelectedUsers2')" 
				onmouseout="hideTip('tipListSelectedUsers2')" 
				name="list2"
				aria-describedby="tipListSelectedUsers2"
			>
			</select> 
		</div>
		
		<div class="center" style="float: right;"><br />
			<input 
				id="textUpdateRoomSubmit"
				type="submit"
				class="counterNavigationUptRoom"
				onfocus="showTip('tipUpdateRoomSubmit', 'textUpdateRoomSubmit')" 
				onblur="hideTip('tipUpdateRoomSubmit')"  
				onmousemove="showTip('tipUpdateRoomSubmit')" 
				onmouseout="hideTip('tipUpdateRoomSubmit')" 
				onClick="selectListBoxAllOptions2(this.form.list2, '<?php echo $_SESSION["id"];?>')"
				value="<?php echo $msgs->getText('updateRoomForm.submit'); ?>" 
			    alt="<?php echo $msgs->getText('updateRoomForm.submit.description'); ?>"
			    aria-describedby="tipUpdateRoomSubmit"
			/>
			<input type="hidden" name="roomId" />
		</div>
		
		<div class="line">
			<font size="2"><?php echo $msgs->getText('userPage.requiredField');?></font>
		</div>
		
		<input type="hidden" name="idsSelecteds" />
		
		<div class="center" style="float: right;">
			<div id="tipUpdateRoomName" class="tip">
		     	 <?php echo $msgs->getText('updateRoomForm.roomName.description'); ?>
			</div>
			<div id="tipUpdateRoomSubmit" class="tip">
		     	 <?php echo $msgs->getText('updateRoomForm.submit.description'); ?>
			</div>
			<div id="tipBtnCloseUptRoomForm" class="tip">
		     	 <?php echo $msgs->getText('userPage.btnClose.description'); ?>
			</div>	
			<div id="tipSrcUserName2" class="tip">
		     	 <?php echo $msgs->getText('newRoomForm.srcUserName.description'); ?>
			</div>
			<div id="tipListAllUsers2" class="tip">
		     	 <?php echo $msgs->getText('newRoomForm.listAllUsers.description'); ?>
			</div>
			<div id="tipListSelectedUsers2" class="tip">
		     	 <?php echo $msgs->getText('newRoomForm.listSelectedUsers.description'); ?>
			</div>
			<div id="tipBtnRight2" class="tip">
		     	 <?php echo $msgs->getText('newRoomForm.btnRight.description'); ?>
			</div>
			<div id="tipBtnLeft2" class="tip">
		     	 <?php echo $msgs->getText('newRoomForm.btnLeft.description'); ?>
			</div>
		</div>		
	</div>
</form>