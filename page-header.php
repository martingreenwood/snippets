	<header id="page-header">
		<div class="inner">
			<div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
			<?php if(function_exists('bcn_display')) {
				bcn_display();
			} ?>
			</div>
			<h1 class="page-title">RESOURCES</h1>
		</div>
	</header><!-- .entry-header -->


	#page-header {
	background: $dark-gray;
	@include rem(padding, 40px 0);
	color: $white;

	.breadcrumbs {
		float: right;
		line-height: 59px;
		@include rem(font-size, 14px);
	}

	a {
		color: $white;
	}
	
	h1 {
		float: left;
		margin: 0;
		clear: none;
		@include rem(font-size, 50px);
		line-height: 1;
	}
}

