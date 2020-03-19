<?php
require_once __DIR__ . '/../../../wp-load.php';

$domain = home_url();
$path = get_stylesheet_directory() . '/modules/*';
$command = '"/Applications/Google Chrome.app/Contents/MacOS/Google Chrome" --headless --screenshot="%s" --window-size=600,600 --default-background-color=0 %s';

echo "Generating thumbnails for $domain...";

foreach (glob($path) as $modulePath) {
	if (is_dir($modulePath)) {
		$moduleName = pathinfo($modulePath, PATHINFO_FILENAME);

		foreach (glob($modulePath . '/*.php') as $templatePath) {
			$templateName = pathinfo($templatePath, PATHINFO_FILENAME);

			if ($templateName !== 'module') {
				echo "\n\nGenerating thumbnail for $moduleName/$templateName...\n";

				shell_exec(sprintf($command, $modulePath . "/$templateName.png", $domain . "/__SLEEK__/modules/dummy-module-preview/$moduleName/$templateName/"));
				shell_exec("chmod 777 $modulePath/$templateName.png");
			}
		}
	}
}
