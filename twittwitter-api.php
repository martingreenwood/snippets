		<?php
		require get_stylesheet_directory() . '/inc/twitteroauth/twitteroauth.php';

		// TWITTER OAUTH SETTINGS
		$twitteruser = 'irvingstageco';
		$notweets = '120';
		
		$consumerkey = 'OkxbGAuGZbHHE5grz2XQpaGh6';
		$consumersecret = 'X9GZ3UYr8KDTG7EAJDFoDcARLdNkmebENNuxJKwdtWOPrgYKiF';
		$accesstoken = '1365348631-0VemSQN7TPD2Wf6HgjRy9j9Hdz8h7sqCTvj0DJT';
		$accesstokensecret = 'TddN5dF9LGKCIJ1AAH4GieE3137drNqT1cYi2ZzqnjiGU';

		function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
  			$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
			return $connection;
		}

		$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
		$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser."&include_rts=true&exclude_replies=true&trim_user=true&contributor_details=false&count=".$notweets);
	    $counter = 0; //set up a counter so we can count the number of iterations
		if ($tweets): ?>
		<i class="fa fa-twitter"></i>
		<h2>@IrvingStageCo on Twitter</h2>
		<div class="slick">
		<?php 
		foreach ($tweets as $tweet):
		if (isset($tweet->entities->media[0])):
			$counter++;
			$created = $tweet->created_at;
			$text = $tweet->text;
			$tweet_url = $tweet->entities->media[0]->url;
			$media = $tweet->entities->media[0];
			$media_url = $media->media_url_https;
		?>
		<div class="tweet">
			<div class="tweet-text">
				<p><?php echo $text; ?></p>
				<small><em>Posted on <?php echo date('l jS F Y G:i', strtotime($created)); ?></em></small>
			</div>
		</div>
		<?php endif;
		if ($counter == $notweets) break;
		endforeach;
		?>
		</div>
		<?php else: ?>
		<div class="no-tweet">
			<h3>Follow us on Twitter. <a href="https://twitter.com/irvingstageco" target="_blank">@irvingstageco</a></h3>
		</div>
		<?php endif; ?>
