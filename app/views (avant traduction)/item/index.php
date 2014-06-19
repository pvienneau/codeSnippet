<div class="content new_section" id="new_item_section" style="display: none">

<ul class="sidebar">
	<li><a href="#" id="cancel">Cancel</a></li>
</ul>
	
<h3 class="title">New Item</h3>

<div class="box">

<form action="item/add" method="post">

	<div class="inline">
		<label>Description</label>
		<input type="text" name="description" class="field" maxlength="30" />
	</div>

	<div class="inline qty">
		<label>Qty</label>
		<input type="text" name="qty" class="field smallest" value="1" />
		<div class="select_wrapper">
			<select name="kind" class="select">
				<option value="hour">hour</option>
				<option value="day">day</option>
				<option value="service">service</option>
				<option value="product">product</option>
			</select>
		</div>
	</div>

	<div class="inline last">
		<label>Price</label>
		<input type="text" name="price" class="field small" value="0.00" />
	</div>

	<div class="inline control">
		<input type="submit" class="button add" value="Add Item" />
	</div>

</form>

</div>

</div>

<div class="content main_section" id="items_section">

<ul class="sidebar">
	<li><a href="#" id="new">New Item</a></li>
</ul>

<h3 class="title">Items</h3>

<ul>
	<li id="bar">
		<span class="description">Description</span>
		<span class="qty">Qty</span>
		<span class="price">Price</span>
		<span class="total">Total</span>
	</li>
</ul>

<ul class="rows">

<?php foreach($items as $item): ?>
	<li class="row" id="<?php echo $item->id; ?>">

		<span class="actions" style="display: none">
			<a href="#" class="remove">Remove</a>
			<a href="item/edit/<?php echo $item->id; ?>" class="edit">Edit</a>
		</span>

		<span class="description"><?php echo $item->description; ?></span>
		<span class="qty"><?php echo $item->qty.' '.$item->kind; ?></span>
		<span class="price"><?php echo $item->price; ?></span>
		<span class="total"><?php echo $item->total; ?></span>

	</li>
<?php endforeach; ?>

</ul>

</div>