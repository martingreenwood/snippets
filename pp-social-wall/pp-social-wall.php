<?php 
/*
Plugin Name: PP Social Wall
Plugin URI:  http://pixelpudu.com/social-wall
Description: A social wall for facebok & twitter
Version:     0.1
Author:      Martin Greenwood
Author URI:  http://pixelpudu.com/
Domain Path: /languages
Text Domain: pp-social-wall

/ Copyright (c) 2015 Pixel Pudu. All rights reserved.
//
// Released under the GPL license
// http://www.opensource.org/licenses/gpl-license.php
//
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
// **********************************************************************

*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// define fb sdk
define('FACEBOOK_SDK_V4_SRC_DIR', dirname( __FILE__ ) . '/includes/facebook/src/Facebook/');
require dirname( __FILE__ ) . '/includes/facebook/autoload.php';

// define call
use Facebook\FacebookSession;
use Facebook\FacebookRequest;

// Load Twitter oAuth
require dirname( __FILE__ ) . '/includes/twitteroauth/twitteroauth.php';


class PP_Social_Wall {
    private static $instance = null;
    private $pp_social_wall;

    public static function get_instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    private function __construct() {
        add_action( 'admin_menu', array( $this, 'pp_social_wall_add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'pp_social_wall_page_init' ) );
    }

    public function pp_social_wall_add_plugin_page() {
        add_options_page(
            'PP Social Wall',	// page_title
            'PP Social Wall',	// menu_title
            'manage_options',	// capability
            'pp-social-wall',	// menu_slug
            array( $this, 'pp_social_wall_create_admin_page' ) // function
        );
    }

    public function pp_social_wall_create_admin_page() {
		include dirname( __FILE__ ) . '/includes/settings.php';
    }

    public function pp_social_wall_page_init() {


        register_setting(
            'pp_social_wall_option_group',					// option_group
            'pp_social_wall_option_name',					// option_name
            array( $this, 'pp_social_wall_sanitize' )		// sanitize_callback
        );

        add_settings_section(
            'pp_social_wall_setting_section',				// id
            '',												// title
            '',												// callback
            'ppsw-admin'									// page
        );

        add_settings_section(
            'pp_social_wall_twitter_section',				// id
            '',												// title
            '',												// callback
            'ppsw-twitter'									// page
        );

        add_settings_section(
            'pp_social_wall_facebook_section',              // id
            '',                                             // title
            '',                                             // callback
            'ppsw-facebook'                                 // page
        );
        add_settings_section(
            'pp_social_wall_instagram_section',              // id
            '',                                             // title
            '',                                             // callback
            'ppsw-instagram'                                 // page
        );

        /*
         * Wall Fields
         */
        add_settings_field(
            'ppsw_main_title', 								// id
            'Social Wall Title', 							// title
            array( $this, 'ppsw_main_title_cb' ), 			// callback
            'ppsw-admin', 					// page
            'pp_social_wall_setting_section' 				// section
        );

        add_settings_field(
            'ppsw_main_tagline',                            // id
            'Social Wall Tagline',                          // title
            array( $this, 'ppsw_main_tagline_cb' ),         // callback
            'ppsw-admin',                   // page
            'pp_social_wall_setting_section'                // section
        );
        add_settings_field(
            'ppsw_font_awesome',                            // id
            'Enable Font Awesome',                          // title
            array( $this, 'ppsw_font_awesome_cb' ),         // callback
            'ppsw-admin',                                   // page
            'pp_social_wall_setting_section'                // section
        );

        /*
         * Instgram Fields
         */
        add_settings_field(
            'ppsw_ig_id',                                    // id
            'Instagram ID',                                  // title
            array( $this, 'ppsw_ig_id_cb' ),                 // callback
            'ppsw-instagram',                                 // page
            'pp_social_wall_instagram_section'               // section
        );
        add_settings_field(
            'ppsw_ig_token',                                 // id
            'Instagram Access Token',                                  // title
            array( $this, 'ppsw_ig_token_cb' ),              // callback
            'ppsw-instagram',                                 // page
            'pp_social_wall_instagram_section'               // section
        );

        /*
         * Facebook Fields
         */
        add_settings_field(
            'ppsw_fb_page_id',                              // id
            'Facebook Page ID',                             // title
            array( $this, 'ppsw_fb_page_id_cb' ),           // callback
            'ppsw-facebook',                                // page
            'pp_social_wall_facebook_section'               // section
        );
        add_settings_field(
            'ppsw_fb_app_id', 								// id
            'Facebook App ID', 								// title
            array( $this, 'ppsw_fb_app_id_cb' ), 			// callback
            'ppsw-facebook', 								// page
            'pp_social_wall_facebook_section' 				// section
        );
        add_settings_field(
            'ppsw_fb_app_sekret', 							// id
            'Facebook App Secret', 							// title
            array( $this, 'ppsw_fb_app_sekret_cb' ), 		// callback
            'ppsw-facebook', 								// page
            'pp_social_wall_facebook_section' 				// section
        );
        add_settings_field(
            'ppsw_fb_album_id', 							// id
            'Facebook Album ID', 							// title
            array( $this, 'ppsw_fb_album_id_cb' ), 			// callback
            'ppsw-facebook', 								// page
            'pp_social_wall_facebook_section' 				// section
        );
        add_settings_field(
            'ppsw_fb_acces_token', 							// id
            'Facebook Long Term Access Token', 				// title
            array( $this, 'ppsw_fb_acces_token_cb' ), 			// callback
            'ppsw-facebook', 								// page
            'pp_social_wall_facebook_section' 				// section
        );


        /*
         * Twitter Fields
         */
        add_settings_field(
            'ppsw_twiter_username', 						// id
            'Twitter Username', 							// title
            array( $this, 'ppsw_twiter_username_cb' ), 		// callback
            'ppsw-twitter', 								// page
            'pp_social_wall_twitter_section' 				// section
        );
        add_settings_field(
            'ppsw_twiter_no_of_tweets', 						// id
            'Number of Tweets', 								// title
            array( $this, 'ppsw_twiter_no_of_tweets_cb' ), 		// callback
            'ppsw-twitter', 									// page
            'pp_social_wall_twitter_section' 					// section
        );
        add_settings_field(
            'ppsw_twiter_consumer_key', 						// id
            'Consumer Key', 									// title
            array( $this, 'ppsw_twiter_consumer_key_cb' ), 		// callback
            'ppsw-twitter', 									// page
            'pp_social_wall_twitter_section' 					// section
        );
        add_settings_field(	
            'ppsw_twiter_consumer_sekret', 						// id
            'Consumer Secret',						 			// title
            array( $this, 'ppsw_twiter_consumer_sekret_cb' ), 	// callback
            'ppsw-twitter', 									// page
            'pp_social_wall_twitter_section' 					// section
        );
        add_settings_field(
            'ppsw_twiter_access_token', 						// id
            'Access Token', 									// title
            array( $this, 'ppsw_twiter_access_token_cb' ), 		// callback
            'ppsw-twitter', 									// page
            'pp_social_wall_twitter_section' 					// section
        );
        add_settings_field(
            'ppsw_twiter_access_sekret',                        // id
            'Access Secret',                                    // title
            array( $this, 'ppsw_twiter_access_sekret_cb' ),     // callback
            'ppsw-twitter',                                     // page
            'pp_social_wall_twitter_section'                    // section
        );
        add_settings_field(
            'ppsw_twiter_widget_id',                            // id
            'Twitter Widget ID',                                    // title
            array( $this, 'ppsw_twiter_widget_id_cp' ),         // callback
            'ppsw-twitter',                                     // page
            'pp_social_wall_twitter_section'                    // section
        );

    }

   /*
    * GENERAL OPTIONS CALLBACKS
    */
    // Callback for Social Wall Title
    public function ppsw_main_title_cb() {
        printf(
            '<input class="regular-text" type="text" name="pp_social_wall_option_name[ppsw_main_title]" id="ppsw_main_title" value="%s">',
            isset( $this->pp_social_wall['ppsw_main_title'] ) ? esc_attr( $this->pp_social_wall['ppsw_main_title']) : ''
        );
    }
    // Callback for Social Wall Tagline
    public function ppsw_main_tagline_cb() {
        printf(
            '<input class="regular-text" type="text" name="pp_social_wall_option_name[ppsw_main_tagline]" id="ppsw_main_tagline" value="%s">',
            isset( $this->pp_social_wall['ppsw_main_tagline'] ) ? esc_attr( $this->pp_social_wall['ppsw_main_tagline']) : ''
        );
    }
    // Callback for Social Wall FA
    public function ppsw_font_awesome_cb() {
        ?>        
            <input type="checkbox" name="pp_social_wall_option_name[ppsw_font_awesome]" value="1" <?php if (isset($this->pp_social_wall['ppsw_font_awesome'])): checked( $this->pp_social_wall['ppsw_font_awesome'], 1 ); endif; ?> id="ppsw_font_awesome"><label>Tick to enable the Font Awesome CSS (some themes come with this already enabled)</label>
        <?php  
    }

   /*
    * INSTAGRAM OPTIONS CALLBACKS
    */
    // Callback for instagram ID
    public function ppsw_ig_id_cb() {
        printf(
            '<input class="regular-text" type="text" name="pp_social_wall_option_name[ppsw_ig_id]" id="ppsw_ig_id" value="%s">',
            isset( $this->pp_social_wall['ppsw_ig_id'] ) ? esc_attr( $this->pp_social_wall['ppsw_ig_id']) : ''
        );
    }
    // Callback for token ID
    public function ppsw_ig_token_cb() {
        printf(
            '<input class="regular-text" type="text" name="pp_social_wall_option_name[ppsw_ig_token]" id="ppsw_ig_token" value="%s">',
            isset( $this->pp_social_wall['ppsw_ig_token'] ) ? esc_attr( $this->pp_social_wall['ppsw_ig_token']) : ''
        );
    }

   /*
    * TWITTER OPTIONS CALLBACKS
    */
    // Callback for Twitter Username
    public function ppsw_twiter_username_cb() {
        printf(
            '<input class="regular-text" type="text" name="pp_social_wall_option_name[ppsw_twiter_username]" id="ppsw_twiter_username" value="%s">',
            isset( $this->pp_social_wall['ppsw_twiter_username'] ) ? esc_attr( $this->pp_social_wall['ppsw_twiter_username']) : ''
        );
    }
    // Callback for Twitter number of tweets
    public function ppsw_twiter_no_of_tweets_cb() {
        printf(
            '<input class="regular-text" type="text" name="pp_social_wall_option_name[ppsw_twiter_no_of_tweets]" id="ppsw_twiter_no_of_tweets" value="%s">',
            isset( $this->pp_social_wall['ppsw_twiter_no_of_tweets'] ) ? esc_attr( $this->pp_social_wall['ppsw_twiter_no_of_tweets']) : ''
        );
    }
    // Callback for Twitter consumne key
    public function ppsw_twiter_consumer_key_cb() {
        printf(
            '<input class="regular-text" type="text" name="pp_social_wall_option_name[ppsw_twiter_consumer_key]" id="ppsw_twiter_consumer_key" value="%s">',
            isset( $this->pp_social_wall['ppsw_twiter_consumer_key'] ) ? esc_attr( $this->pp_social_wall['ppsw_twiter_consumer_key']) : ''
        );
    }
    // Callback for Twitter consumer sekret
    public function ppsw_twiter_consumer_sekret_cb() {
        printf(
            '<input class="regular-text" type="text" name="pp_social_wall_option_name[ppsw_twiter_consumer_sekret]" id="ppsw_twiter_consumer_sekret" value="%s">',
            isset( $this->pp_social_wall['ppsw_twiter_consumer_sekret'] ) ? esc_attr( $this->pp_social_wall['ppsw_twiter_consumer_sekret']) : ''
        );
    }
    // Callback for Twitter access token
    public function ppsw_twiter_access_token_cb() {
        printf(
            '<input class="regular-text" type="text" name="pp_social_wall_option_name[ppsw_twiter_access_token]" id="ppsw_twiter_access_token" value="%s">',
            isset( $this->pp_social_wall['ppsw_twiter_access_token'] ) ? esc_attr( $this->pp_social_wall['ppsw_twiter_access_token']) : ''
        );
    }
    // Callback for Twitter access sekret
    public function ppsw_twiter_access_sekret_cb() {
        printf(
            '<input class="regular-text" type="text" name="pp_social_wall_option_name[ppsw_twiter_access_sekret]" id="ppsw_twiter_access_sekret" value="%s">',
            isset( $this->pp_social_wall['ppsw_twiter_access_sekret'] ) ? esc_attr( $this->pp_social_wall['ppsw_twiter_access_sekret']) : ''
        );
    }

   /*
    * FACEBOOK OPTIONS CALLBACKS
    */
    // Callback for Pacebook Page ID
    public function ppsw_fb_page_id_cb() {
        printf(
            '<input class="regular-text" type="text" name="pp_social_wall_option_name[ppsw_fb_page_id]" id="ppsw_fb_page_id" value="%s">',
            isset( $this->pp_social_wall['ppsw_fb_page_id'] ) ? esc_attr( $this->pp_social_wall['ppsw_fb_page_id']) : ''
        );
    }
    public function ppsw_fb_app_id_cb() {
        printf(
            '<input class="regular-text" type="text" name="pp_social_wall_option_name[ppsw_fb_app_id]" id="ppsw_fb_app_id" value="%s">',
            isset( $this->pp_social_wall['ppsw_fb_app_id'] ) ? esc_attr( $this->pp_social_wall['ppsw_fb_app_id']) : ''
        );
    }
    public function ppsw_fb_app_sekret_cb() {
        printf(
            '<input class="regular-text" type="text" name="pp_social_wall_option_name[ppsw_fb_app_sekret]" id="ppsw_fb_app_sekret" value="%s">',
            isset( $this->pp_social_wall['ppsw_fb_app_sekret'] ) ? esc_attr( $this->pp_social_wall['ppsw_fb_app_sekret']) : ''
        );
    }
    public function ppsw_fb_album_id_cb() {
        printf(
            '<input class="regular-text" type="text" name="pp_social_wall_option_name[ppsw_fb_album_id]" id="ppsw_fb_album_id" value="%s">',
            isset( $this->pp_social_wall['ppsw_fb_album_id'] ) ? esc_attr( $this->pp_social_wall['ppsw_fb_album_id']) : ''
        );
    }
    public function ppsw_fb_acces_token_cb() {
        printf(
            '<input class="regular-text" type="text" name="pp_social_wall_option_name[ppsw_fb_acces_token]" id="ppsw_fb_acces_token" value="%s">
            <br><span>To obtail a long term access token, follow the guidelines set out on this post <a rel="nofollow" target="_blank" href="https://www.rocketmarketinginc.com/blog/get-never-expiring-facebook-page-access-token/">here</a></span>',
            isset( $this->pp_social_wall['ppsw_fb_acces_token'] ) ? esc_attr( $this->pp_social_wall['ppsw_fb_acces_token']) : ''
        );
    }
    public function ppsw_twiter_widget_id_cp() {
        printf(
            '<input class="regular-text" type="text" name="pp_social_wall_option_name[ppsw_twiter_widget_id]" id="ppsw_twiter_widget_id" value="%s">',
            isset( $this->pp_social_wall['ppsw_twiter_widget_id'] ) ? esc_attr( $this->pp_social_wall['ppsw_twiter_widget_id']) : ''
        );
    }


    public function pp_social_wall_sanitize($input) {
        $sanitary_values = array();
        
        // genral
        if ( isset( $input['ppsw_main_title'] ) ) {
            $sanitary_values['ppsw_main_title'] = sanitize_text_field( $input['ppsw_main_title'] );
        }
        if ( isset( $input['ppsw_main_tagline'] ) ) {
            $sanitary_values['ppsw_main_tagline'] = sanitize_text_field( $input['ppsw_main_tagline'] );
        }
        if ( isset( $input['ppsw_font_awesome'] ) ) {
            $sanitary_values['ppsw_font_awesome'] = $input['ppsw_font_awesome'];
        }

        // IG
        if ( isset( $input['ppsw_ig_token'] ) ) {
            $sanitary_values['ppsw_ig_token'] = sanitize_text_field( $input['ppsw_ig_token'] );
        }
        if ( isset( $input['ppsw_ig_id'] ) ) {
            $sanitary_values['ppsw_ig_id'] = sanitize_text_field( $input['ppsw_ig_id'] );
        }

        // twitters
        if ( isset( $input['ppsw_twiter_username'] ) ) {
            $sanitary_values['ppsw_twiter_username'] = sanitize_text_field( $input['ppsw_twiter_username'] );
        }
        if ( isset( $input['ppsw_twiter_no_of_tweets'] ) ) {
            $sanitary_values['ppsw_twiter_no_of_tweets'] = sanitize_text_field( $input['ppsw_twiter_no_of_tweets'] );
        }
        if ( isset( $input['ppsw_twiter_consumer_key'] ) ) {
            $sanitary_values['ppsw_twiter_consumer_key'] = sanitize_text_field( $input['ppsw_twiter_consumer_key'] );
        }
        if ( isset( $input['ppsw_twiter_consumer_sekret'] ) ) {
            $sanitary_values['ppsw_twiter_consumer_sekret'] = sanitize_text_field( $input['ppsw_twiter_consumer_sekret'] );
        }
        if ( isset( $input['ppsw_twiter_access_token'] ) ) {
            $sanitary_values['ppsw_twiter_access_token'] = sanitize_text_field( $input['ppsw_twiter_access_token'] );
        }
        if ( isset( $input['ppsw_twiter_access_sekret'] ) ) {
            $sanitary_values['ppsw_twiter_access_sekret'] = sanitize_text_field( $input['ppsw_twiter_access_sekret'] );
        }
        if ( isset( $input['ppsw_twiter_widget_id'] ) ) {
            $sanitary_values['ppsw_twiter_widget_id'] = sanitize_text_field( $input['ppsw_twiter_widget_id'] );
        }

		// facebooks
        if ( isset( $input['ppsw_fb_page_id'] ) ) {
            $sanitary_values['ppsw_fb_page_id'] = sanitize_text_field( $input['ppsw_fb_page_id'] );
        }
        if ( isset( $input['ppsw_fb_app_id'] ) ) {
            $sanitary_values['ppsw_fb_app_id'] = sanitize_text_field( $input['ppsw_fb_app_id'] );
        }
        if ( isset( $input['ppsw_fb_app_sekret'] ) ) {
            $sanitary_values['ppsw_fb_app_sekret'] = sanitize_text_field( $input['ppsw_fb_app_sekret'] );
        }
        if ( isset( $input['ppsw_fb_album_id'] ) ) {
            $sanitary_values['ppsw_fb_album_id'] = sanitize_text_field( $input['ppsw_fb_album_id'] );
        }
        if ( isset( $input['ppsw_fb_acces_token'] ) ) {
            $sanitary_values['ppsw_fb_acces_token'] = sanitize_text_field( $input['ppsw_fb_acces_token'] );
        }

        return $sanitary_values;
    }

    public static function display_pp_soicial_wall() {
    
    	$pp_social_wall_options = get_option( 'pp_social_wall_option_name' );
		$ppsw_main_title = $pp_social_wall_options['ppsw_main_title'];
		$ppsw_main_tagline = $pp_social_wall_options['ppsw_main_tagline'];

        $ppsw_ig_id = $pp_social_wall_options['ppsw_ig_id'];
        $ppsw_ig_token = $pp_social_wall_options['ppsw_ig_token'];

		$ppsw_twiter_username = $pp_social_wall_options['ppsw_twiter_username'];
		$ppsw_twiter_no_of_tweets = $pp_social_wall_options['ppsw_twiter_no_of_tweets'];
		$ppsw_twiter_consumer_key = $pp_social_wall_options['ppsw_twiter_consumer_key'];
		$ppsw_twiter_consumer_sekret = $pp_social_wall_options['ppsw_twiter_consumer_sekret'];
		$ppsw_twiter_access_token = $pp_social_wall_options['ppsw_twiter_access_token'];
        $ppsw_twiter_access_sekret = $pp_social_wall_options['ppsw_twiter_access_sekret'];
        $ppsw_twiter_widget_id = $pp_social_wall_options['ppsw_twiter_widget_id'];

		$ppsw_fb_page_id = $pp_social_wall_options['ppsw_fb_page_id'];
		$ppsw_fb_app_id = $pp_social_wall_options['ppsw_fb_app_id'];
		$ppsw_fb_app_sekret = $pp_social_wall_options['ppsw_fb_app_sekret'];
		$ppsw_fb_album_id = $pp_social_wall_options['ppsw_fb_album_id'];
		$ppsw_fb_acces_token = $pp_social_wall_options['ppsw_fb_acces_token'];

    	?>
		<div id="ppsw_social_wall" class="social_wall">

			<header>
				<div class="heading">
					<h3><?php echo $ppsw_main_title; ?></h3>
					<p><?php echo $ppsw_main_tagline; ?></p>
				</div>
			</header>

			<div class="container">
			<div class="wall">
				<?php

				// TWITTER OAUTH SETTINGS
				$twitteruser = $ppsw_twiter_username;
				$notweets = $ppsw_twiter_no_of_tweets;
				$consumerkey = $ppsw_twiter_consumer_key;
				$consumersecret = $ppsw_twiter_consumer_sekret;
				$accesstoken = $ppsw_twiter_access_token;
				$accesstokensecret = $ppsw_twiter_access_sekret;

				function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
		  			$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
					return $connection;
				}

				$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
				$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser."&include_rts=false&exclude_replies=true&trim_user=true&contributor_details=false&count=".$notweets);
				$followers = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser);
			    $counter = 0; //set up a counter so we can count the number of iterations

				foreach ($tweets as $tweet):
				if (isset($tweet->entities->media[0])):
					$counter++;
					$created = $tweet->created_at;
					$text = $tweet->text;
					$tweet_url = $tweet->entities->media[0]->url;
					$media = $tweet->entities->media[0];
					$media_url = $media->media_url;
				?>
				<div class="ppsw-card twitter">
					<div class="caption">
						<p><em>Posted on <?php echo date('l jS F Y G:i', strtotime($created)); ?></em><br>
						<p><?php echo $text; ?></p>
					</div>
					<img src="<?php echo str_replace('http','https', $media_url); ?>">
					<div class="icon"><a target="_blank" href="<?php echo $tweet_url; ?>"><i class="fa fa-twitter"></i></a></div>
				</div>
				<?php 
				endif;
				if ($counter == 2) break;
				endforeach; ?>			

				<div class="ppsw-card timeline">
					<a class="twitter-timeline" 
					data-dnt="true" 
					href="https://twitter.com/<?php echo $ppsw_twiter_username; ?>" 
					data-widget-id="<?php echo $ppsw_twiter_widget_id; ?>" 
					data-tweet-limit="2" 
					data-chrome="nofooter transparent noheader noborders"></a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

				</div>
				
				<!--<div class="multi"> -->

				<?php
					
					$app_id = $ppsw_fb_app_id;
					$app_secret = $ppsw_fb_app_sekret;
					$page_id = $ppsw_fb_page_id; // page id 
					$album_id = $ppsw_fb_album_id; // album id
					$access_token = $ppsw_fb_acces_token;

					// setup app credentials
					FacebookSession::setDefaultApplication($app_id, $app_secret);

					// define session
					$session = new FacebookSession($access_token);

					// make the API call
					$request = new FacebookRequest(
					  $session,
					  'GET',
					  '/'.$album_id.'/photos'
					);
					$response = $request->execute();
					$graphObject = $response->getGraphObject()->asArray();

					// make the data array
					$GOdata = $graphObject['data'];

					// countless
					$counter = 0;

					foreach ($GOdata as $data):
						// get the posy id to colect more info, for some reason facebook 
						// stoped returing most of what we need in the first request
						$p_id = $data->id;
						
						// gets the image
						$p_request = new FacebookRequest(
							$session,
							'GET',
							'/'.$p_id,
							array(
								'fields' => 'source'
							)
						);
						$p_response = $p_request->execute();
						$p_graphObject = $p_response->getGraphObject()->asArray();

						// link to the post - how many request do 
						// i need to make goddammit! 
						$l_request = new FacebookRequest(
							$session,
							'GET',
							'/'.$p_id,
							array(
								'fields' => 'link'
							)
						);
						$l_response = $l_request->execute();
						$l_graphObject = $l_response->getGraphObject()->asArray();
					?>
					<div class="ppsw-card facebook">
						<?php if(isset($data->name)): ?>
						<div class="caption">
							<p><em style="font-size: 0.875em;"><?php echo date('l jS F', strtotime($data->created_time)); ?></em><br><?php echo substr($data->name, 0, 50); ?>...</p>
						</div>
						<?php endif; ?>

						<img src="<?php echo $p_graphObject['source']; ?>">
						<div class="icon"><a href="<?php echo $l_graphObject['link']; ?>" target="_blank"><i class="fa fa-facebook"></i></a></div>					
					</div>


					<?php if ($counter++ == 1) break; ?>

					<?php endforeach;

				?>

					<div class="ppsw-card follow">

						<p>Follow Us</p>

						<ul>
							<li><a href="https://www.facebook.com/cumbriatouristboard" target="_blank"><i class="fa fa-facebook"></i></a></li>
							<li><a href="https://twitter.com/cumbriatourism" target="_blank"><i class="fa fa-twitter"></i></a></li>
						</ul>

					
					</div>

				<!--</div>-->

				<div class="ppsw-card twitter_stats">

					<?php 
					$followers_count  = $followers[0]->user->followers_count; 
					$followers_floored = floor( $followers_count / 100) * 100;
					$followers_round = round(($followers_count/1000),1) . 'k';
					?>

					<div class="bird">
                        <i class="fa fa-twitter"></i>
						<span><?php echo $followers_count; ?></span>
					</div>

					<p>Twitter<br>Followers</p>
			
				</div>

                <?php
                    // Supply a user id and an access token
                    $userid = $ppsw_ig_id;
                    $accessToken = $ppsw_ig_token;

                    $counter = 0;
                   
                    // Gets our data
                    function fetchData($url){
                         $ch = curl_init();
                         curl_setopt($ch, CURLOPT_URL, $url);
                         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                         curl_setopt($ch, CURLOPT_TIMEOUT, 20);
                         $result = curl_exec($ch);
                         curl_close($ch); 
                         return $result;
                    }

                    // Pulls and parses data.
                    $result = fetchData("https://api.instagram.com/v1/users/{$userid}/media/recent/?access_token={$accessToken}");
                    $result = json_decode($result);
                ?>

                <?php foreach ($result->data as $post): ?>
                <div class="ppsw-card instagram">
                    <?php if(isset($post->caption->text)): ?>
                    <div class="caption">
                        <p><em style="font-size: 0.875em;"><?php echo 'date'; ?></em><br><?php echo $post->caption->text; ?></p>
                    </div>
                    <?php endif; ?>

                    <img src="<?php echo $post->images->standard_resolution->url ?>" alt="<?php echo $post->caption->text ?>">
                    <div class="icon"><a href="" target="_blank"><i class="fa fa-instagram"></i></a></div>                    <!-- Renders images. @Options (thumbnail,low_resoulution, high_resolution) -->
                </div>
                <?php if ($counter++ == 1) break; ?>
                <?php endforeach ?> 
			
			</div>
			
			</div>

		</div> 
    	<?php
    }
}
add_shortcode( 'pp_social_wall', array( 'PP_Social_Wall', 'display_pp_soicial_wall' ) );

function ppsw_enqueue_script() {
    wp_register_style( 'ppsw-fa', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css','','', 'screen' );
    wp_enqueue_style( 'ppsw-fa' );
}
function ppsw_enqueue_base() {
    wp_register_script( 'ppsw-js',  plugin_dir_url(__FILE__) . '/js/ppsw.js','','', true );
    wp_register_style( 'ppsw-css', plugin_dir_url(__FILE__) . '/css/ppsw.css','','', 'screen' );

    wp_enqueue_style( 'ppsw-css' );
    wp_enqueue_script( 'ppsw-js' );
}

if (!is_admin()) {

    $pp_social_wall_options = get_option( 'pp_social_wall_option_name' );
    if (isset($pp_social_wall_options['ppsw_font_awesome'])):
        add_action( 'wp_enqueue_scripts', 'ppsw_enqueue_script' );
    endif;

    add_action( 'wp_enqueue_scripts', 'ppsw_enqueue_base', 90 );
}



PP_Social_Wall::get_instance();


/*
 * Retrieve this value with:
 * $pp_social_wall_options = get_option( 'pp_social_wall_option_name' ); // Array of All Options
 */
