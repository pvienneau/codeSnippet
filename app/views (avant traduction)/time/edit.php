<h1><?php echo !empty($log->id) ? 'Update log': 'New log';  ?></h1>

<form class="form_data" action="<?php echo !empty($log->id) ? get_url('log/edit/'.$log->id): get_url('log/add');  ?>" method="post">
<div class="fieldset">
 
  <div class="field">
    <label for="log-user_id">User id</label>
    <input class="text" type="text" id="log-user_id" maxlength="11" name="log[user_id]" value="<?php echo $log->user_id ?>" />
  </div>
 
  <div class="field">
    <label for="log-project_id">Project id</label>
    <input class="text" type="text" id="log-project_id" maxlength="11" name="log[project_id]" value="<?php echo $log->project_id ?>" />
  </div>
 
  <div class="field">
    <label for="log-client_id">Client id</label>
    <input class="text" type="text" id="log-client_id" maxlength="11" name="log[client_id]" value="<?php echo $log->client_id ?>" />
  </div>
 
  <div class="field">
    <label for="log-duration">Duration</label>
    <input class="text" type="text" id="log-duration" maxlength="0" name="log[duration]" value="<?php echo $log->duration ?>" />
  </div>
 
  <div class="field">
    <label for="log-description">Description</label>
    <input class="text" type="text" id="log-description" maxlength="255" name="log[description]" value="<?php echo $log->description ?>" />
  </div>
 
  <div class="field">
    <label for="log-created_on">Created on</label>
    <input class="text" type="text" id="log-created_on" name="log[created_on]" value="<?php echo $log->created_on ?>" />
  </div>
 
</div>
<div class="buttons">
  <input class="button" name="commit" type="submit" value=" Save " /> 
  or <a href="<?php echo get_url('log'); ?>"> Cancel </a>
</div>
</form>
