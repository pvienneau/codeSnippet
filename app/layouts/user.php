<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="<?php echo get_url('css/main.css'); ?>" />
	</head>
	<body>
		<div id="tooltop">
			<h1>Code Snippet</h1>
			<?php if(AuthUser::isLoggedIn()): ?>
				<!-- user account info -->
			<?php endif; ?>
			<form class="form_code_search">
				<input name="query" type="text" placeholder="Search for a snippet" />
			</form>
		</div>
		<?php 
		echo $content_for_layout;?>
		
	</body>
</html>