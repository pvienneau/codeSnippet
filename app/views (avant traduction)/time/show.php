<h1>log <?php echo $log->id' ?></h1>

<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
 
  <tr>
    <td class="label">User id</td>
    <td class="field"><?php echo $log->user_id ?></td>
  </tr>
 
  <tr>
    <td class="label">Project id</td>
    <td class="field"><?php echo $log->project_id ?></td>
  </tr>
 
  <tr>
    <td class="label">Client id</td>
    <td class="field"><?php echo $log->client_id ?></td>
  </tr>
 
  <tr>
    <td class="label">Duration</td>
    <td class="field"><?php echo $log->duration ?></td>
  </tr>
 
  <tr>
    <td class="label">Description</td>
    <td class="field"><?php echo $log->description ?></td>
  </tr>
 
  <tr>
    <td class="label">Created on</td>
    <td class="field"><?php echo $log->created_on ?></td>
  </tr>
 
</table>
