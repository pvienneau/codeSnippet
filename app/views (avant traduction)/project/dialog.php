<div id="update_new_project_dialog">
	<div class="dialog" id="new_project_dialog" style="display: none">
		<form action="project/add" method="post">
			<div id="new_project">
				
				<div id="update_clients">
					<div class="inline">
						<label>Client</label>
						<div class="select_wrapper">
							<select name="client_id" class="select" id="client_select">
								<option value="new_client">New Client…</option>
								<option value=""  selected="selected"> </option>
								<?php echo clients_select_option(); ?>
							</select>
						</div>
					</div>
				</div>
				
				<label>Name</label>
				<input type="text" name="name" class="field" />

				<label>Description</label>
				<textarea name="description" class="textarea notes"></textarea>

				<label>Hours</label>
				<input type="text" name="hours" class="field smallest" value="0.00" />
				
				<label class="optional">Rate</label>
				<input type="text" name="rate" class="field small" value="<?php echo my_number_format(Settings::company()->rate); ?>" />
			
				<div class="control">
					<input type="submit" class="button" value="Add Project" />
					<a class="small_button">Cancel</a>
				</div>
			</div>
		</form>
	</div>
</div>