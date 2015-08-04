<?php $ignore = array('contact_submit', 'sleek_module', 'g-recaptcha-response'); ?>

<!doctype html>

<html>
	<head>
		<meta charset="utf8">
		<title>From website</title>
		<style>
			table {
				width: 100%;
				border: 1px solid #ddd;
				border-collapse: collapse;
				border-spacing: 0;
			}

			th, 
			td {
				text-align: left;
				vertical-align: top;
				padding: 15px;
				border: 1px solid #ddd;
			}

			tr:nth-child(event) th, 
			tr:nth-child(event) td {
				background: #eee;
			}
		</style>
	</head>
	<body>
		<table>
			<?php foreach ($fields as $field => $value) : if (!in_array($field, $ignore)) : ?>
				<tr>
					<th scope="row"><?php echo ucfirst(str_replace('_', ' ', $field)) ?></th>
					<td>
						<?php if (is_array($value)) : ?>
							<?php echo implode(', ', $value) ?>
						<?php else : ?>
							<?php echo $value ?>
						<?php endif ?>
					</td>
				</tr>
			<?php endif; endforeach ?>
		</table>
	</body>
</html>
