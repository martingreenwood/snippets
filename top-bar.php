		<div id="top">

			<div class="inner">

				<div class="left">
					<a title="Skip to content" class="skip-link" href="#content"><i class="fa fa-level-down"></i> <?php esc_html_e( 'Skip to content', 'a4c' ); ?></a>
					<a title="Skip to footer" class="skip-link" href="#footer"><i class="fa fa-level-down"></i> <?php esc_html_e( 'Skip to footer', 'a4c' ); ?></a>

					<?php dynamic_sidebar( 'Top Sidebar' ); ?>

				</div>

				<div class="top-sidebar">
					<a id="search-link" href=""><i class="fa fa-search"></i></a>
					<div id="search-box"><?php get_search_form('true'); ?></div>
				</div><!-- #second sidebar -->

			</div>

		</div>


	#top {
		background: $dark-gray;
		color: $white;

		.inner {
			position: relative;
		}

		a {
			color: $white;
			transition: color 500ms ease-in-out;

			&:hover {
				color: $brand-primary;
			}
		}

		.left {
			float: left;

			.widget {
				margin-bottom: 0;
				display: inline-block;

				ul {

					li {
						display: inline-block;

						a {
							color: $white;
							transition: color 500ms ease-in-out;

							span {
								margin-right: 10px;
								color: inherit;
							}

							&:hover {
								color: $brand-primary;
							}
						}
					}
				}
			}
		}

		.right {
			float: right;
		}

		a {
			line-height: 2.5;
			@include rem(margin-right, 20px);

			&.skip-link {
				
			}
			&.login-link {
				
			}
		}

		.top-sidebar {
			float: right;

			p {
				margin-bottom: 0;

				a {
					margin-right: 0;
				}
			}

			#search-link {
				float: right;
				margin: 0;
				padding: 0 10px;
				transition: all 500ms ease-in-out;
			}

			#search-box {
				position: absolute;
				z-index: 27;
				background: $brand-primary;
				right: 0;
				@include rem(top, 40px);
				height: 0;
				overflow: hidden;
				transition: all 500ms ease-in-out;

				form {
				    @include rem(padding, 30px);
    				float: left;
				}
	
				label {
					margin-bottom: 0;
					float: left;

					input[type="search"] {
						margin-bottom: 0;
						float: left;
						@include rem(padding, 8px);
						border: 0;
					}
				}
				
				.search-submit {
					float: left;
				    @include rem(padding, 8px 15px);
					border: 0px solid $white;
					background: $white;
					color: $black;
				}
			}

			&.active,
			&:hover {
				#search-link {
					background: $brand-primary;	
					color: $white;
				}
				
				#search-box {
					@include rem(height, 102px);
				}
			}
		}
	}		