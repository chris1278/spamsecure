/* acp_spsedimmer.js
------------------------------------*/

'use strict';
spamsecureACP.setState = function () {
	const enabledOpacity = "1.0";
	const disabledOpacity = "0.35";

	$('#dim_spse_coustom').css('opacity', (
			$('#spamsecure_invalid_chars_lang_custom_0').prop('checked')
		) ? disabledOpacity : enabledOpacity
	);

	$('#dim_spse_counter').css('opacity', (
			$('#spamsecure_invalid_chars_counter_switch_0').prop('checked')
		) ? disabledOpacity : enabledOpacity
	);
};

$(window).ready(spamsecureACP.setState);
