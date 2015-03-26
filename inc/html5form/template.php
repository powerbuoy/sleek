<!doctype html>

<html>
	<head>
		<meta charset="utf8">
		<title>From website</title>
	</head>
	<body>
		<table>
			<?php foreach ($fields as $field => $value) : ?>
				<tr>
					<th scope="row"><?php echo $field ?></th>
					<td>
						<?php if (is_array($value)) : ?>
							<?php echo implode(', ', $value) ?>
						<?php else : ?>
							<?php echo $value ?>
						<?php endif ?>
					</td>
				</tr>
			<?php endforeach ?>
		</table>
	</body>
</html>
