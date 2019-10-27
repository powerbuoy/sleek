<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf8">
		<style>
			html {

			}

			body {
				margin: 0;
			}

			main {

			}

			.container {
				min-height: 100vh;
				perspective: 50vw;
			}

			.back {
				transform: translateZ(-50vw) scale(2);
			}

			.front {

			}
		</style>
	</head>
	<body>
		<main>
			<?php for ($i = 0; $i < 3; $i++) : ?>
				<section class="container">
					<div class="back">Back</div>
					<div class="front">Front</div>
				</section>
			<?php endfor ?>
		</main>
	</body>
</html>
