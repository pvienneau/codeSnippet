<?php $company = Settings::company(); ?>
<div id="update_new_client_dialog">
	<div class="dialog" id="new_client_dialog" style="display: none">
		<form action="client/add" method="post">
			<div id="update_new_client">
				<label>Name</label>
				<input type="text" name="name" class="field" />

				<label>Email</label>
				<input type="text" name="email" class="field" />

				<label class="optional">Company</label>
				<input type="text" name="company" class="field" />

				<label>Country</label>
				<div class="select_wrapper">
					<select name="country" class="select">
					<?php echo country_select_option(); ?>
					</select>
				</div>

				<div class="more" style="display: none">
					<label class="optional">Address Line 1</label>
					<input type="text" name="address_line_1" class="field" />

					<label class="optional">Address Line 2</label>
					<input type="text" name="address_line_2" class="field" />

					<label class="optional">City</label>
					<input type="text" name="city" class="field" />

					<label class="optional">ZIP Code</label>
					<input type="text" name="zip_code" class="field" />

					<label class="optional">State</label>
					<input type="text" name="state" class="field" />
					
					<label class="optional">Phone Number</label>
					<input type="text" name="phone_number" class="field" value="" />
					
					<!--label>Tax 1 (%)</label>
					<div class="checkbox_wrapper">
						<input type="checkbox" name="tax_status" class="checkbox" id="tax_status"<?php is_checked(!empty($company->tax)); ?> />
					</div>
					<input type="text" name="tax_name" class="field" id="tax_name" value="<?php echo $company->tax_name; ?>" /><input type="text" name="tax" class="field" id="tax" value="<?php echo my_number_format($company->tax, 3); ?>" maxlength="6"<?php is_display(!empty($company->tax)); ?> />
				
					<label>Tax 2 (%)</label>
					<div class="checkbox_wrapper">
						<input type="checkbox" name="tax2_status" class="checkbox" id="tax2_status"<?php is_checked(!empty($company->tax2)); ?> />
					</div>
					<span id="tax2_span"<?php is_display(!empty($company->tax2)); ?>>
						<input type="text" name="tax2_name" class="field" id="tax2_name" value="<?php echo $company->tax2_name; ?>" /><input type="text" name="tax2" class="field" id="tax2" value="<?php echo my_number_format($company->tax2, 3); ?>" maxlength="6" />
						<div class="checkbox_wrapper">
							<input type="checkbox" name="tax2_cumulative" class="checkbox" id="tax2_cumulative"<?php is_checked(!empty($company->tax2_cumulative)); ?> />
						</div>
						cumulative
					</span-->
					
					<label class="optional">Tax ID</label>
					<input type="text" name="tax_id" class="field" />
				</div>

				<a href="#" class="add_more">Add more details…</a>

				<div class="control">
					<input type="submit" class="button" value="Add Client" />
					<a class="small_button">Cancel</a>
				</div>
			</div>
		</form>
	</div>
</div>