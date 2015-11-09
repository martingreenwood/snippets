<div id="loader">

	<div class="mikepad-loading">
		<div class="binding"></div>
		<div class="pad">
			<div class="line line1"></div>
			<div class="line line2"></div>
			<div class="line line3"></div>
		</div>
		<div class="text">
			Page is loading...
		</div>
	</div>

</div>


SCSS

@-webkit-keyframes writeline {
	0% { width : 0px; opacity: 0; }
	33% { width : 15px; opacity : 1; }
	70% { opacity : 1; }
	100% {opacity : 0; }
}

@-moz-keyframes writeline {
	0% { width : 0px; opacity: 0; }
	33% { width : 15px; opacity : 1; }
	70% { opacity : 1; }
	100% {opacity : 0; }
}

@-o-keyframes writeline {
	0% { width : 0px; opacity: 0; }
	33% { width : 15px; opacity : 1; }
	70% { opacity : 1; }
	100% {opacity : 0; }
}

@keyframes writeline {
	0% { width : 0px; opacity: 0; }
	33% { width : 15px; opacity : 1; }
	70% { opacity : 1; }
	100% {opacity : 0; }
}


#loader {
	position: fixed;
	background-color: $black;

	width: 100%;
	height: 100%;

	width: 100vw;
	height: 100vh;

	z-index: 10;

	.mikepad-loading {
		@include rem(width, 150px);
		position: absolute;
		top: 50%;
		left : 50%;
		-webkit-transform: translateY(-50%) translateX(-50%);
		-moz-transform: translateY(-50%) translateX(-50%);
		-o-transform: translateY(-50%) translateX(-50%);
		transform: translateY(-50%) translateX(-50%);

		.binding {
			content : '';
			@include rem(width, 36px);
			@include rem(height, 10px);
			border : 2px solid $brand-primary;
			margin : 0 auto;
		}

		.pad {
			@include rem(width, 36px);
			@include rem(height, 36px);
			border : 2px solid $brand-primary;
			border-top : 0;
			@include rem(padding, 9px);
			margin : 0 auto;
		}

		.line {
			@include rem(width, 15px);
			@include rem(margin-top, 4px);
			border-top : 2px solid $brand-primary;
			opacity : 0;
			-webkit-animation : writeline 3s infinite ease-in;
			-moz-animation : writeline 3s infinite ease-in;
			-o-animation : writeline 3s infinite ease-in;
			animation : writeline 3s infinite ease-in;

			&:first-child {
				margin-top : 0;
			}

			&.line1 {
				-webkit-animation-delay: 0s;
				-moz-animation-delay: 0s;
				-o-animation-delay: 0s;
				animation-delay: 0s;
			}

			&.line2 {
				-webkit-animation-delay: 0.5s;
				-moz-animation-delay: 0.5s;
				-o-animation-delay: 0.5s;
				animation-delay: 0.5s;
			}

			&.line3 {
				-webkit-animation-delay: 1s;
				-moz-animation-delay: 1s;
				-o-animation-delay: 1s;
				animation-delay : 1s;
			}
		}

		.text {
			text-align : center;
			@include rem(margin-top, 10px);
			@include rem(font-size, 16px);
			color : $white;
			font-weight: 700;
		}
	}
}

JS

// REMOVE LOADERING SCREEN ONCE LOADED
$j(window).load(function() {
	$j('#loader').fadeOut('fast', function() {
		$j(this).remove();
	});
});

