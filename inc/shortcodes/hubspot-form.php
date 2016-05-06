<?php
/**
 * Include a HubSpot form with [hubspot-form portal_id="12" form_id="32"]
 */
# add_shortcode('hubspot-form', 'sleek_hubspot_form');

function sleek_hubspot_form ($atts) {
	return '
	<!-- [if lte IE 8]>
		<script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2-legacy.js"></script>
	<![endif]-->

	<script src="//js.hsforms.net/forms/v2.js" type="text/javascript" charset="utf-8"></script>
	<script>// <![CDATA[
		hbspt.forms.create({
			css: "",
			portalId: "' . $atts['portal_id'] . '",
			formId: "' . $atts['form_id'] . '"
		});
	// ]]></script>';
}
