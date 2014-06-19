<li class="line">
	<a href="#" class="remove_line">Remove Line</a>
	<span class="qty">
	<input type="text" name="line[<?php echo $index; ?>][qty]" class="field" value="<?php echo $line->qty; ?>" />
	<div class="select_wrapper">
		<select name="line[<?php echo $index; ?>][kind]" class="select">
			<option value="hour"<?php is_selected($line->kind == 'hour'); ?>>hour</option>
			<option value="day"<?php is_selected($line->kind == 'day'); ?>>day</option>
			<option value="service"<?php is_selected($line->kind == 'service'); ?>>service</option>
			<option value="product"<?php is_selected($line->kind == 'product'); ?>>product</option>
		</select>
	</div>
	</span>
	<span class="description"><textarea name="line[<?php echo $index; ?>][description]" class="textarea"><?php echo $line->description; ?></textarea></span>
	<span class="price"><input type="text" name="line[<?php echo $index; ?>][price]" class="field" value="<?php echo my_number_format($line->price); ?>"/></span>
	<span class="total"><span class="total_line"><?php echo my_number_format($line->total); ?></span></span>
</li>
