<?
/**
 * This is a bootstrapped form, you should pass along the following
 * array to this view to render it properly.
 *
 * $fields = array(
 *    array(
 *       'name' => What post variable it will return. [ex. first_name]
 *       'type' => The field type [ex. password, text, etc.]
 *       'default' => The default value for this field.
 *    )
 * )
 */
?>

<form class="form-horizontal" method="POST">

   <? foreach ($fields as $field): ?>
      <? $error = form_error($field['name']) ?>
      <div class="control-group <? if(!empty($error)): ?>error<? endif; ?>">
      	<label class="control-label"><?= humanize($field['name']) ?></label>
         <? $value = set_value($field['name'], ($field['default']) ? $field['default'] : ''); ?>
      	<div class="controls">
				<input 
               class="input-xlarge" 
               type="<?= $field['type'] ?>" 
               name="<?= $field['name'] ?>" 
               value="<? if (!empty($value)) echo $value; ?>" 
            />
            <div class="help-block">
               <?= $error ?>
            </div>
			</div>
      </div>
   <? endforeach; ?>

   <div class="form-actions">
      <button type="submit" class="btn btn-primary">Submit</button>
   	<a onclick="history.go(-1)" class="btn">Cancel</a>
   </div>
</form>