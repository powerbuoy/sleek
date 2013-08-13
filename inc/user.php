<?php
function h5b_user_data ($ip) {
	static $users = array();

	$ip = $ip ? $ip : $_SERVER['REMOTE_ADDR'];

	if (isset($users[$ip])) {
		return $users[$ip];
	}

	$user		= array();
	$ip2c		= new ip2country();
	$country	= $ip2c->get_country($ip);

	if ($country) {
		include TEMPLATEPATH . '/inc/currency-array.php';

		$country = $user['country'] = $country['id2'];

		if (isset($cc2currency[$country])) {
			$currency = $user['currency'] = $cc2currency[$country];

			if (isset($currencies[$currency])) {
				$user['symbol'] = $currencies[$currency]['symbol'];
			}
			else {
				$user['symbol'] = false;
			}
		}
		else {
			$user['currency']	= false;
			$user['symbol']		= false;
		}
	}
	else {
		$user['country']	= false;
		$user['currency']	= false;
		$user['symbol']		= false;
	}

	if ($user['country']) {
		$users[$ip] = $user;

		return $user;
	}

	return false;
}
