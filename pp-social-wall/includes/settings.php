<?php
if( !defined( 'ABSPATH' ) ) {
	exit;
}

$this->pp_social_wall = get_option( 'pp_social_wall_option_name' ); ?>

<style> .indent {padding-left: 2em} </style>

<div class="wrap">
	
	<h1><?php _e( 'PP Social Wall', 'pp-social-wall') ?></h1>
	
	<form action="options.php" method="post" id="pp-social-wall">
	<?php settings_fields( 'pp_social_wall_option_group' ); ?>	
		<fieldset>

			<ul>

				<li>
					<h3>General Settings</h3>
					<p>General settings for the social wall.</p>
					<?php
					do_settings_sections( 'ppsw-admin' );
					?>

				</li>

				<li>
					<h3>Facebook Settings</h3>
					<p>Please add your facebook app info below.</p>
					<?php
					do_settings_sections( 'ppsw-facebook' );
					?>
				</li>

				<li>
					<h3>Twitter Settings</h3>
					<p>Please add your twitter app info below.</p>
					<?php
					do_settings_sections( 'ppsw-twitter' );
					?>

				</li>

				<li>
					<h3>Instagram Settings</h3>
					<p>Please add your instagram app info below.</p>
					<?php
					do_settings_sections( 'ppsw-instagram' );
					?>
				</li>

			</ul>

		</fieldset>

		<p class="submit">
			<?php submit_button(); ?>
		</p>

	</form>

</div>

<script>
  logInWithFacebook = function() {
    FB.login(function(response) {
      if (response.authResponse) {
        alert('You are logged in & cookie set!');
        // Now you can redirect the user or do an AJAX request to
        // a PHP script that grabs the signed request from the cookie.
      } else {
        alert('User cancelled login or did not fully authorize.');
      }
    });
    return false;
  };
  window.fbAsyncInit = function() {
    FB.init({
      appId: '189994884669966',
      cookie: true, // This is important, it's not enabled by default
      version: 'v2.2'
    });
  };

  (function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script>