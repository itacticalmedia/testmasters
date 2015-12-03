<div class="wrap"> <!-- admin page settings -->
<h1>Test Masters Settings</h1>
<?php
global $wpdb;

$api_base_url = get_option('api_base_url');

if(isset($_POST['submit']) && $_POST['submit'] == 'Save Changes') {
	$api_base_url = $_POST['api_base_url'];
	update_option('api_base_url', $api_base_url);
	echo '<div class="updated notice is-dismissible below-h2" id="message"><p>Base URL Updated</p></div>';
}

?>
<form action="" method="post">
<table class="form-table">
	<thead>
	<tr><th>Base URL</th><td><input type="text" name="api_base_url" class="api_base_url" value="<?php echo $api_base_url ?>"></td></tr>
	</thead>
</table>
<p class="submit"><input type="submit" value="Save Changes" class="button button-primary" id="submit" name="submit"></p>
</form>
</div>
