<ul>
	<?php if(!empty($codes)): foreach($codes as $code): ?>
		<li>
			<a href="<?php echo get_url('code/'.$code->code_id); ?>">
				<p>
					<em>
						<?php echo $code->title; ?>
					</em>
					&nbsp;-&nbsp;<?php echo $code->description; ?>
				</p>
			</a>
		</li>
	<?php endforeach; else: ?>
		<li>No code snippets found.</li>
	<?php endif; ?>
</ul>