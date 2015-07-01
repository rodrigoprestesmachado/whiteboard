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

<div class="moveElementForm">
	
	<input type="hidden" id="s-mvElement" value="" />
	
	<div class="left">
		<?php echo $msgs->getText("mvElementDescriptionAPointsL");?>:
		<input type="text" class="input counterNavigationMoveElement" id="i-mvElementAPointsL" disabled="disabled" size="3" value="" />
		<br />
		<?php echo $msgs->getText("mvElementDescriptionAPointsT");?>:
		<input type="text" class="input counterNavigationMoveElement" id="i-mvElementAPointsT" disabled="disabled" size="3" value="" />
		
		<br /><br />
		
		<?php echo $msgs->getText("mvElementDescriptionWidthB");?>:
		<input type="text" class="input counterNavigationMoveElement" id="i-mvElementWidth" disabled="disabled" size="3" value="" />
		<br /><br />
	</div>
	
	<div class="right">
		<?php echo $msgs->getText("mvElementDescriptionAPointsR");?>:
		<input type="text" class="input counterNavigationMoveElement" id="i-mvElementAPointsR" disabled="disabled" size="3" value="" />
		<br />
		<?php echo $msgs->getText("mvElementDescriptionAPointsB");?>:
		<input type="text" class="input counterNavigationMoveElement" id="i-mvElementAPointsB" disabled="disabled" size="3" value="" />
		
		<br /><br />
		
		<?php echo $msgs->getText("mvElementDescriptionHeightB");?>:
		<input type="text" class="input counterNavigationMoveElement" id="i-mvElementHeight" disabled="disabled" size="3" value="" /> 
		<br /><br />
	</div>

	<p>
		<?php echo $msgs->getText("mvElementDescriptionXDisplacement");?>:
		<input 
			type="text" 
			class="input counterNavigationMoveElement" 
			id="x-mvElement" 
			class="dialog" 
			value="" 
			onfocus="showTip('tipHorizontalMovement', 'x-mvElement')" 
			onblur="hideTip('tipHorizontalMovement')"  
			onmousemove="showTip('tipHorizontalMovement')" 
			onmouseout="hideTip('tipHorizontalMovement')"
		/>
		
		<?php echo $msgs->getText("mvElementDescriptionXDisplacL");?>:
		<input 
			id="radioLeft"
			type="radio" 
			class="counterNavigationMoveElement"
			name="direction-x" 
			value="l" 
			onfocus="showTip('tipMoveLeft', 'radioLeft')" 
			onblur="hideTip('tipMoveLeft')"  
			onmousemove="showTip('tipMoveLeft')" 
			onmouseout="hideTip('tipMoveLeft')"
		/>
		
		<?php echo $msgs->getText("mvElementDescriptionXDisplacR");?>:
		<input 
			id="radioRight"
			type="radio" 
			class="counterNavigationMoveElement"
			name="direction-x" 
			value="r" 
			onfocus="showTip('tipMoveRight', 'radioRight')" 
			onblur="hideTip('tipMoveRight')"  
			onmousemove="showTip('tipMoveRight')" 
			onmouseout="hideTip('tipMoveRight')"
		/></p>
	<p>
		<?php echo $msgs->getText("mvElementDescriptionYDisplacement");?>:
		<input 
			type="text" 
			class="input" 
			id="y-mvElement" 
			class="dialog counterNavigationMoveElement" 
			value="" 
			onfocus="showTip('tipVerticalMovement', 'y-mvElement')" 
			onblur="hideTip('tipVerticalMovement')"  
			onmousemove="showTip('tipVerticalMovement')" 
			onmouseout="hideTip('tipVerticalMovement')"
		/>
		
		<?php echo $msgs->getText("mvElementDescriptionYDisplacT");?>:
		<input 
			id="radioTop"
			type="radio" 
			class="counterNavigationMoveElement"
			name="direction-y" 
			value="t" 
			onfocus="showTip('tipMoveTop', 'radioTop')" 
			onblur="hideTip('tipMoveTop')"  
			onmousemove="showTip('tipMoveTop')" 
			onmouseout="hideTip('tipMoveTop')"
		/>
		
		<?php echo $msgs->getText("mvElementDescriptionYDisplacB");?>:
		
		<input 
			id="radioBottom"
			type="radio" 
			class="counterNavigationMoveElement"
			name="direction-y" 
			value="b" 
			onfocus="showTip('tipMoveBottom', 'radioBottom')" 
			onblur="hideTip('tipMoveBottom')"  
			onmousemove="showTip('tipMoveBottom')" 
			onmouseout="hideTip('tipMoveBottom')"
		/>
	</p>
	<input 
		type="button" 
		id="btn-mvElement" 
		class="counterNavigationMoveElement"
		value="<?php echo $msgs->getText("mvElementButtonMove");?>" 
		onclick="libMoveElement()" 
		onfocus="showTip('tipBtnMoveElement', 'btn-mvElement')" 
		onblur="hideTip('tipBtnMoveElement')"  
		onmousemove="showTip('tipBtnMoveElement')" 
		onmouseout="hideTip('tipBtnMoveElement')"
		aria-describedby="tipBtnMoveElement"
	/>
	
	<br />
	
	<div id="tipBtnMoveElement" class="tip">
		<?php echo $msgs->getText('mvElementButtonMove.description'); ?>
		</div>
		<div id="tipBtnCloseMoveElementForm" class="tip">
     		<?php echo $msgs->getText('userPage.btnClose.description'); ?>
		</div>
		<div id="tipHorizontalMovement" class="tip">
     		<?php echo $msgs->getText('mvElement.horizontalMovement.description'); ?>
		</div>
		<div id="tipVerticalMovement" class="tip">
     		<?php echo $msgs->getText('mvElement.verticalMovement.description'); ?>
		</div>
		<div id="tipMoveLeft" class="tip">
     		<?php echo $msgs->getText('mvElement.moveLeft.description'); ?>
		</div>
		<div id="tipMoveRight" class="tip">
     		<?php echo $msgs->getText('mvElement.moveRight.description'); ?>
		</div>
		<div id="tipMoveTop" class="tip">
     		<?php echo $msgs->getText('mvElement.moveTop.description'); ?>
		</div>
		<div id="tipMoveBottom" class="tip">
     		<?php echo $msgs->getText('mvElement.moveBottom.description'); ?>
	</div>
</div>