<h1><?php echo !empty($tag->id) ? 'Update tag': 'New tag';  ?></h1>

<form class="form_data" action="<?php echo !empty($tag->id) ? get_url('tag/edit/'.$tag->id): get_url('tag/add');  ?>" method="post">
<div class="fieldset">
 
  <div class="field">
    <label for="tag-name">Name</label>
    <input class="text" type="text" id="tag-name" maxlength="50" name="tag[name]" value="<?php echo $tag->name ?>" />
  </div>
 
</div>
<div class="buttons">
  <input class="button" name="commit" type="submit" value=" Save " /> 
  or <a href="<?php echo get_url('tag'); ?>"> Cancel </a>
</div>
</form>
