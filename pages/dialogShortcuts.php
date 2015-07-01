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

	
<div class="shortcutsList">

	<H3><?php echo $msgs->getText('dialogShortCuts.title1'); ?></H3>
	
	<br />
	<?php echo $msgs->getText('dialogShortCuts.CreateText'); ?>
	<blockquote>
		<?php echo $msgs->getText('dialogShortCuts.CreateText.1'); ?><br />
		<?php echo $msgs->getText('dialogShortCuts.CreateText.2'); ?><br />
		<?php echo $msgs->getText('dialogShortCuts.CreateText.3'); ?>
	</blockquote>

	<br />
	<?php echo $msgs->getText('dialogShortCuts.Drag'); ?>
	<blockquote>
		<?php echo $msgs->getText('dialogShortCuts.Drag.1'); ?><br />
		<?php echo $msgs->getText('dialogShortCuts.Drag.2'); ?>
	 </blockquote>
	
	<br />
	<?php echo $msgs->getText('dialogShortCuts.Delete'); ?>
	<blockquote>
		<?php echo $msgs->getText('dialogShortCuts.Delete.1'); ?><br />
    	<?php echo $msgs->getText('dialogShortCuts.Delete.2'); ?>
	</blockquote>

	<br />
	<?php echo $msgs->getText('dialogShortCuts.Update'); ?>
	<blockquote>
		<?php echo $msgs->getText('dialogShortCuts.Update.1'); ?><br />
    	<?php echo $msgs->getText('dialogShortCuts.Update.2'); ?>
	</blockquote>
	
	
	<br />
	<H3><?php echo $msgs->getText('dialogShortCuts.title2'); ?></H3>
	
	<br />
	<?php echo $msgs->getText('dialogShortCuts.login'); ?>
	<blockquote>
		<?php echo $msgs->getText('dialogShortCuts.login.email'); ?><br />
		<?php echo $msgs->getText('dialogShortCuts.login.password'); ?><br />
		<?php echo $msgs->getText('dialogShortCuts.login.enter'); ?><br />
		<?php echo $msgs->getText('dialogShortCuts.login.register'); ?>
	</blockquote>
	
	<br />
	<?php echo $msgs->getText('dialogShortCuts.userPage'); ?>
	<blockquote>
		<?php echo $msgs->getText('dialogShortCuts.userPage.exit'); ?><br />
		<?php echo $msgs->getText('dialogShortCuts.userPage.update'); ?><br />
		<?php echo $msgs->getText('dialogShortCuts.userPage.newRoom'); ?><br />
		<?php echo $msgs->getText('dialogShortCuts.userPage.inputRoomCode'); ?><br />
		<?php echo $msgs->getText('dialogShortCuts.userPage.btnRoomCode'); ?>
	</blockquote>
	
	</br>
	<?php echo $msgs->getText('dialogShortCuts.roomTemplate'); ?>
	<blockquote>
		<?php echo $msgs->getText('dialogShortCuts.roomTemplate.btnText'); ?><br />
		<?php echo $msgs->getText('dialogShortCuts.roomTemplate.btnVideo'); ?><br />
		<?php echo $msgs->getText('dialogShortCuts.roomTemplate.btnImage'); ?><br />
		<?php echo $msgs->getText('dialogShortCuts.roomTemplate.btnRolateL'); ?><br />
		<?php echo $msgs->getText('dialogShortCuts.roomTemplate.btnRolateR'); ?><br />
		<?php echo $msgs->getText('dialogShortCuts.roomTemplate.btnOpenProduction'); ?><br />
		<?php echo $msgs->getText('dialogShortCuts.roomTemplate.btnExit'); ?><br />
		<?php echo $msgs->getText('dialogShortCuts.roomTemplate.inputChat'); ?><br />
		<?php echo $msgs->getText('dialogShortCuts.roomTemplate.btnSendMessage'); ?><br />
		<?php echo $msgs->getText('dialogShortCuts.roomTemplate.btnInviteFriends'); ?><br />
		<?php echo $msgs->getText('dialogShortCuts.roomTemplate.btnModalShortCuts'); ?><br />
		<?php echo $msgs->getText('dialogShortCuts.roomTemplate.btnModalHelp'); ?><br />
		<?php echo $msgs->getText('dialogShortCuts.roomTemplate.btnPublishCam'); ?><br />
		<?php echo $msgs->getText('dialogShortCuts.roomTemplate.btnPlayStopCam'); ?>
	</blockquote>

	<div class="center" style="float: right;">	
		<div id="tipBtnCloseShortcuts" class="tip">
	     	 <?php echo $msgs->getText('userPage.btnClose.description'); ?>
		</div>	
	</div>
	
</div>