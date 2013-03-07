<?php 
    echo head(array('title' => 'Afterthoughts', 'bodyclass' => 'afterthoughts')); ?>


<h1>Afterthoughts</h1>
<div id="primary">
    <?php echo flash(); ?>

    <p>
        To update files, copy and paste a list of filenames into the text box, select the field you want to add data for, and enter your data.</p>

    <form action="<?php echo html_escape(url(array('action'=>'edit'))); ?>" enctype="multipart/form-data" method="post" accept-charset="utf-8">

        <h2>Batch Update Files</h2>
        <p>A new entry will be created in the ElementsText table for each filename.</p>
        <h3>Insert your data</h3>
        <fieldset>
            <div class="field">
            	<label for="filebox">Original Filenames</label>
            	<div class="inputs" style="width:50%;">
            	<?php echo $this->formTextarea('afterthoughts-files',null,array('class' => 'textinput'));?>
            	</div>
            </div>
            <h3>Enter Metadata</h3>
            <div class="field">
	            <div class="inputs" style="float: left; width: 23%;">
	            <?php echo $this->formSelect(
					'afterthoughts-element-id',(!isset($item))? null : $item->element_id,array('id'=>'element_id', 'style' => 'width:25%; float:left'),get_table_options('Element'));?>
					<label for="afterthoughts-public">Use HTML
					<div class="inputs" style="float:right">
					    <?php echo $this->formCheckbox('afterthoughts-html'); ?>
					</div></label>
					
				</div>
				<div class="inputs" style="float: right; width: 75%;">
					<?php echo $this->formTextArea('afterthoughts-element-text',null,array('class' => 'textinput', 'style' => 'height:100px'));?>
				</div>
			</div>
        </fieldset>		
        <div class="input">
            <input type="submit" class="submit" name="submit" id="afterthoughts-edit-files" value="Apply Metadata" />
        </div>
    </form>
</div>

<?php echo foot();
