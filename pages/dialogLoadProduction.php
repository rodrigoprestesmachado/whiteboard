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

	
<div class="dialogLoadProduction">
	<form id="frmProductions"> 
	
		<div class="center">
		
		<?php echo $msgs->getText('dialogLoadProduction.description'); ?>
		<br />
		<?php 
		$_POST['currentRoom'] = $_GET['idRoom'];
		$listProductionsAction = new ListProductionsAction();
		$listProductionsAction->execute($action);
		
		$productions = $_REQUEST["productions"];
		?>
		<select 
			id="listProductions" 
			name="listProductions"
			size="10"
			class="counterNavigationLoadProduction"
		> 
		
		<?php
		foreach ($productions as $production){
			echo "<option value=".$production->getProductionId().">".$production->getProductionId()." - ".$production->getCreationDate()."</option>";
		}
		?>
		
		</select>
		
		<br />
		
			<input 
				id="btnLoadProduction"
				type="button" 
				class="counterNavigationLoadProduction"
				value="<?php echo $msgs->getText('dialogLoadProduction.btnLoadProduction'); ?>" 
				onclick="loadPreviusProduction();" 
				onfocus="showTip('tipBtnLoadProduction', 'btnLoadProduction')" 
				onblur="hideTip('tipBtnLoadProduction')" 
				onmouseover="showTip('tipBtnLoadProduction')" 
				onmouseout="hideTip('tipBtnLoadProduction')" 
				aria-describedby="tipBtnLoadProduction"
			/> 
			
		
		</div> 
	</form>


	<div class="center" style="float: right;">	
		<div id="tipBtnCloseDialogLoadProduction" class="tip">
	     	 <?php echo $msgs->getText('userPage.btnClose.description'); ?>
		</div>	
		<div id="tipBtnLoadProduction" class="tip">
	     	 <?php echo $msgs->getText('dialogLoadProduction.btnLoadProduction.description'); ?>
		</div>
	</div>
	
</div>