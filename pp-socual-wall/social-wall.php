<div class="social_wall">
	

	<header>
		<div class="heading fadeInBlock">
			<h3>Join The conversation</h3>
			<p>#theplacetobe</p>
		</div>
	</header>

	<div class="container">
	<div class="wall">
		<?php
		// Load Twitter oAuth
		require get_template_directory() . '/twitteroauth/twitteroauth.php';

		// TWITTER OAUTH SETTINGS
		$twitteruser = "cumbriatourism";
		$notweets = 150;
		$consumerkey = "NJyXCRphf4K35hmE7tXDwTctQ";
		$consumersecret = "NYrojnNRvhgk99Q5lFJJX1Rv11u6UJ2eSUGBxBGuL9gk9MnJ7k";
		$accesstoken = "21858190-oXApBmHRuOiNtqUm0UAxqwkgEMKJMmTgE7U9MH2qn";
		$accesstokensecret = "PKYCx1AwY348teifmUMwO3HSxRW31fwQ5JscG0812KWvs";

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
			$media = $tweet->entities->media[0];
			$media_url = $media->media_url;
		?>
		<div class="card twitter fadeInBlock" style="background-image:url(<?php echo str_replace('http','https', $media_url); ?>);">
			<div class="icon"></div>
			<div class="caption">
				<p><em>Posted on <?php echo date('l jS F Y G:i', strtotime($created)); ?></em><br>
				<p><?php echo $text; ?></p>
			</div>
		</div>
		<?php 
		endif;
		if ($counter == 3) break;
		endforeach; ?>	
	</div>
	<div class="wall fadeInBlock">
	

		<div class="card timeline">
			<a class="twitter-timeline" 
			data-dnt="true" 
			href="https://twitter.com/cumbriatourism" 
			data-widget-id="618034235941736448" 
			data-tweet-limit="2" 
			data-chrome="nofooter transparent noheader noborders"></a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

		</div>
		
		<div class="multi facebook_image">

		<?php
			
			// define fb sdk
			define('FACEBOOK_SDK_V4_SRC_DIR', get_template_directory() . '/facebook/src/Facebook/');
			require get_template_directory() . '/facebook/autoload.php';

			$page_id = '157264857664710'; // page id for CT
			$app_id = '1666055203626261'; // app id for CT
			$app_secret = '7e8079ef391ddc414b5d10c40652d8fe'; // app secret
			$album_id = '266800200044508'; // album id

			// tokens			
			// expires never (unless password is chamged)
			//$token = 'CAAXrRLSWnRUBAOiXdQT0cl6qbhS1k4eqkxHb3NAuxKxbEW9O4NWQ9XghB7caGQsViHeamQdjZBINkmdF73fs1yiLZB9JkZAWJJcFWoX0aUTCCFAEWkjD1VzxlyDlMWZCbKKaDZAVYaCLzr6iRWaVHrc6ywKxySSn1MBRZB48jaaJwYCRO096ZCH';
			//$token = 'CAAXrRLSWnRUBAGbwZCfAXT3Mhe4AvuUsCqobok71mQ84g695DFgjtDo7BWg0CbS0MD8ertP34OomwSUxIlzpZC7j1lpvJkwCIZArZCDwaQFfrGQpwPiSNO7gTH48M567uk1x2p8tSUdiWfaqwgaFN62F4B18YLiEOdIt65SPvOMUaXmubzSZAxZBjMEckTX70ZD';
			$token = 'CAAXrRLSWnRUBABzHxRhLPGPxnd3rbgIZBZA24zTMJzBvOQxHnZBOJrQGuTBrPsdrNLVkfhoTLbZBsaFolDPK1levG0tvZCZBAlamx0ZBi0ebdYorZA18XKDWjc7cQpMwvU8Qi7j4iEbTv7dyouDssZBMmZCnxYUoPWAvcSi0zgeAp1TcAIzHZB2wVzvAM16kw2rCIEZD';

			// access token
			$access_token = $token;

			// define call
			use Facebook\FacebookSession;
			use Facebook\FacebookRequest;

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

			$GOdata = $graphObject['data'];

			$counter = 0;
			
		?>
			
		<?php

			foreach ($GOdata as $data): ?>
			
			<div class="sub-card bgimg fadeInBlock" style="background-image: url(<?php echo $data->source; ?>)">

				<div class="icon"></div>
				<?php if(isset($data->name)): ?>
				<div class="caption">
					<p><em style="font-size: 0.875em;"><?php echo date('l jS F', strtotime($data->updated_time)); ?></em><br><?php echo substr($data->name, 0, 50); ?>...</p>
				</div>
				<?php endif; ?>
			
			</div>

			<?php if ($counter++ == 2) break; ?>

			<?php endforeach;

		?>

			<div class="sub-card follow fadeInBlock">

				<p>Follow Us</p>

				<ul>
					<li><a href="https://www.facebook.com/cumbriatouristboard" target="_blank"><i class="fa fa-facebook"></i></a></li>
					<li><a href="https://twitter.com/cumbriatourism" target="_blank"><i class="fa fa-twitter"></i></a></li>
					<li><a href="https://www.facebook.com/cumbriatouristboard" target="_blank"><i class="fa fa-google-plus"></i></a></li>
				</ul>

			
			</div>

		</div>

		<div class="card twitter_stats fadeInBlock">

			<?php 
			$followers_count  = $followers[0]->user->followers_count; 
			$followers_floored = floor( $followers_count / 100) * 100;
			$followers_round = round(($followers_count/1000),1) . 'k';
			?>

			<div class="bird">
				<span><?php echo $followers_round; ?></span>
			</div>

			<p>Twitter<br>Followers</p>
	
		</div>

	
	</div>
	
	</div>

</div>