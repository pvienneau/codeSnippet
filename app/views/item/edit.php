<div class="content edit_section" id="edit_item_section">
	
<h3 class="title">Edit Item</h3>

<div class="box">

<form action="item/edit/<?php echo $item->id; ?>" method="post">
	<div class="inline">
		<label>Description</label>
		<input type="text" name="description" class="field" value="<?php echo $item->description; ?>" />
	</div>

	<div class="inline qty">
		<label>Qty</label>
		<input type="text" name="qty" class="field smallest" value="<?php echo $item->qty; ?>" />
		<div class="select_wrapper">
			<select name="kind" class="select">
				<option value="hour"<?php if ($item->kind == 'hour') echo ' selected="selected"'; ?>>hour</option>
				<option value="day"<?php if ($item->kind == 'day') echo ' selected="selected"'; ?>>day</option>
				<option value="service"<?php if ($item->kind == 'service') echo ' selected="selected"'; ?>>service</option>
				<option value="product"<?php if ($item->kind == 'product') echo ' selected="selected"'; ?>>product</option>
			</select>
		</div>
	</div>

	<div class="inline last">
		<label>Price</label>
		<input type="text" name="price" class="field small" value="<?php echo my_number_format($item->price, 2); ?>" />
	</div>

	<div class="inline control">
		<input type="submit" class="button edit" value="Save Changes" />
	</div>
</form>

</div>

</div>