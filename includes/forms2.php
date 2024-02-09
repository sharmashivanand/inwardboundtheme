<?php

// Justin's Area.

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start coding here:

/* Custom Log-in Screen Elements */

add_action("login_head", "my_login_head");
function my_login_head() {
	echo "
	<style>
	body.login {background:#FFF; -moz-osx-font-smoothing: grayscale; text-rendering: optimizeLegibility;}
	body.login form {background:#EDEDED; border:1px solid #E0E0E0; margin-top:0;}
	
	input:-webkit-autofill {background:#fbfbfb; border:1px solid #d6d6d6 !important; font-size:15px; color: #848484; -webkit-text-fill-color: #676767 !important; padding:8px; filter:none; -webkit-box-shadow: 0 0 0px 1000px #fbfbfb inset;}
	input:-webkit-autofill:hover, input:-webkit-autofill:focus {border:none !important; -webkit-text-fill-color: inherit !important; -webkit-box-shadow: 0 0 0px 1000px #fff inset; transition: background-color 5000s ease-in-out 0s;}
	body.login form .input {background:#fbfbfb; border:1px solid #d6d6d6 !important; font-size:15px; color:#848484; -webkit-text-fill-color:#848484 !important; padding:8px; filter:none; -webkit-box-shadow: 0 0 0px 1000px #fbfbfb inset;}
	body.login form .input:focus {background:#fff; color:#676767; box-shadow:none; -webkit-text-fill-color:#676767 !important; -webkit-box-shadow: 0 0 0px 1000px #fff inset;}
	body.login form label {color:#5D5D5D;}

	body.login #login h1 a {background: url('https://inwardboundmind.org/wp-content/themes/ibme-lander-edge/assets/img/logo.svg') no-repeat scroll center top transparent; height: 56px; width: 250px; margin-bottom:20px;}
	body.login #login p a {color:#67A5B5;}
	body.login #login p a:hover {color:#000;}
	body.login .submit input {background:#67A5B5; border:1px solid #67A5B5; color:#FFF; box-shadow:none; text-shadow:none; font-size:13px; padding: 3px 20px !important; font-weight: bold; height: auto !important; margin-top: 10px;}
	body.login .submit input:hover {background:#5B99A9; border:1px solid #5B99A9; color:#FFF; box-shadow:none; text-shadow:none;}
	body.login div.updated, body.login .message {background:#67A5B5; border:1px solid #67A5B5; color:#FFF; margin-bottom: 10px;}
	body.login #login_error {background:#67a5b5; border:1px solid #1BB0D1; color:#FFF; margin-bottom: 10px;}
	body.login #login_error a {color:#FFF !important; text-decoration:underline;}
	body.login #login_error a:hover {color:#FFF !important; text-decoration:none;}
	body.login #nav, body.login #backtoblog {margin-left:0;}
	body.login a:focus {box-shadow:none;}
	body.login .privacy-policy-page-link {display:none;}
	</style>
	";
}


/* Opt-in w/ out phone - sends through the Email Opt-in (More Info) form */

add_shortcode('opt-in-no-phone', 'ibme_opt_in_shortcode_nophone' );

function ibme_opt_in_shortcode_nophone($atts) {
	extract( shortcode_atts(array('campaign' => '', 'status' => '', 'link' => 'https://ibme.com/confirmation/response-received/', 'drip' => '', 'btn_text' => 'I&#x27;m In!'), $atts) );
	
	$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http';
	$full_url = $protocol."://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$query_string = $_SERVER['QUERY_STRING'];
	$params = '?'.$query_string;
	$url_without_query_string = str_replace($params, '', $full_url);

	if(empty($url_without_query_string)) {
		$url_without_query_string = 'WordPress could not detect the URL. But the form was submitted via WordPress.';
	}
	
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	if(empty($user_agent)) {
		$user_agent = 'WordPress could not detect the user-agent. But the form was submitted via WordPress.';
	}

	$form_output = <<<IELS

	<!-- FORM: HEAD SECTION -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<script type="text/javascript" src="https://ibme.tfaforms.net/wForms/3.11/js/wforms.js?v=88a41a0062f8c011af96ec355938e1dee6e787e3"></script>
    <script type="text/javascript">
        wFORMS.behaviors.prefill.skip = false;
    </script>
	<script type="text/javascript" src="https://ibme.tfaforms.net/wForms/3.11/js/localization-en_US.js?v=88a41a0062f8c011af96ec355938e1dee6e787e3"></script>

	<!-- FORM: BODY SECTION -->
	<div class="wFormContainer opt-in-form" >
	<div class="">
		<div class="wForm" id="tfa_0-WRPR" dir="ltr">
		<div class="codesection" id="code-tfa_0"></div>
		<form method="post" action="https://ibme.tfaforms.net/responses/processor" class="hintsBelow labelsAbove signup-form" id="tfa_0">
			<!--<p class="one-sixth first blue-text bold">Want more information?</p>-->
			<div class="two-thirds first form-inputs">
			<div id="tfa_1-D" class="oneField one-third first opt-in-email-field">
				<input type="text" id="tfa_1" name="tfa_1" value="" required placeholder="First Name" class="form-field form-left required">
			</div>
			<div id="tfa_2-D" class="oneField one-third opt-in-email-field">
				<input type="text" id="tfa_2" name="tfa_2" value="" required placeholder="Last Name" class="form-field form-left required">
			</div>
			<div id="tfa_4-D" class="oneField one-third opt-in-email-field">
				<input type="text" id="tfa_4" name="tfa_4" value="" required placeholder="Email" class="validate-email form-field form-left required">
			</div>
			<div id="tfa_16-D" class="bears oneField opt-in-email-field">
				<p><input autocomplete="off" type="text" id="tfa_16" name="tfa_16" value="" placeholder="Other (Optional)" class="form-field form-left"></p>
			</div>
			</div>
			<input type="hidden" id="tfa_5" name="tfa_5" value="$campaign" class="">
			<input type="hidden" id="tfa_6" name="tfa_6" value="$status" class="">
			<input type="hidden" id="tfa_8" name="tfa_8" value="$link" class="">
			<input type="hidden" id="tfa_9" name="tfa_9" value="$drip" class="">
			<input type="hidden" id="tfa_12" name="tfa_12" value="$url_without_query_string" class="">
			<input type="hidden" id="tfa_14" name="tfa_14" value="$user_agent" class="">
			<div class="actions one-third" id="tfa_0-A">
			<input type="submit" class="primaryAction form-left mint-button ibme-button style-1" value="$btn_text">
			</div>
			<div style="clear:both"></div>
			<input type="hidden" value="389586" name="tfa_dbFormId" id="tfa_dbFormId">
			<input type="hidden" value="" name="tfa_dbResponseId" id="tfa_dbResponseId">
			<input type="hidden" value="c980754fc1448003855f36a93b8f1d1d" name="tfa_dbControl" id="tfa_dbControl">
			<input type="hidden" value="3" name="tfa_dbVersionId" id="tfa_dbVersionId">
			<input type="hidden" value="" name="tfa_switchedoff" id="tfa_switchedoff">
		</form>
		</div>
	</div>
	</div>
IELS;
// !!! THE ABOVE LINE SHOULD NEVER BE INDENTED !!! ///
	$form_output = apply_filters( 'ibme_form_recaptcha', $form_output );
	return $form_output;
}


/* New subscribe form */

add_shortcode('subscribe-form', 'subscribe_form_shortcode' );

function subscribe_form_shortcode() {

	extract( shortcode_atts(array('link' => 'https://inwardboundmind.org/confirmation/mailing-list/'), $atts) );

	$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http';
	$full_url = $protocol."://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$query_string = $_SERVER['QUERY_STRING'];
	$params = '?'.$query_string;
	$url_without_query_string = str_replace($params, '', $full_url);

	if(empty($url_without_query_string)) {
		$url_without_query_string = 'WordPress could not detect the URL. But the form was submitted via WordPress.';
	}
	
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	if(empty($user_agent)) {
		$user_agent = 'WordPress could not detect the user-agent. But the form was submitted via WordPress.';
	}

	$form_output = <<<IELS

	<!-- FORM: HEAD SECTION -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<script type="text/javascript" src="https://ibme.tfaforms.net/wForms/3.11/js/wforms.js?v=88a41a0062f8c011af96ec355938e1dee6e787e3"></script>
    <script type="text/javascript">
        wFORMS.behaviors.prefill.skip = false;
    </script>
	<script type="text/javascript" src="https://ibme.tfaforms.net/wForms/3.11/js/localization-en_US.js?v=88a41a0062f8c011af96ec355938e1dee6e787e3"></script>
	
	<!-- FORM: BODY SECTION -->
	<div class="wFormContainer subscribe-form"  >
		<div class="wForm" id="389906-WRPR" dir="ltr">
			<div class="codesection" id="code-389906"></div>
			<form method="post" action="https://ibme.tfaforms.net/responses/processor" class="hintsBelow labelsAbove" id="389906" role="form">

				<div class="form-inputs">

					<div id="tfa_1-D" class="oneField one-half first form-field">
						<input type="text" id="tfa_1" name="tfa_1" value="" required placeholder="first name" class="form-field form-left required">
					</div>

					<div id="tfa_2-D" class="oneField one-half form-field">
						<input type="text" id="tfa_2" name="tfa_2" value="" required placeholder="last name" class="form-field form-left required">
					</div>

					<div id="tfa_4-D" class="oneField one-half first form-field">
						<input type="text" id="tfa_4" name="tfa_4" value="" required placeholder="email" class="form-field form-left required">
					</div>

					<div id="tfa_272-D" class="oneField one-half form-field dropdown">
						<label style="display: none;" id="tfa_272-L" class="label preField " for="tfa_272">State (Optional)</label>
						<select id="tfa_272" name="tfa_272" title="State" class="">
							<option value="">state (optional)</option>
							<option value="tfa_273" id="tfa_273" class="calcval-AK">AK</option>
							<option value="tfa_274" id="tfa_274" class="calcval-AL">AL</option>
							<option value="tfa_275" id="tfa_275" class="calcval-AR">AR</option>
							<option value="tfa_276" id="tfa_276" class="calcval-AZ">AZ</option>
							<option value="tfa_277" id="tfa_277" class="calcval-CA">CA</option>
							<option value="tfa_278" id="tfa_278" class="calcval-CO">CO</option>
							<option value="tfa_279" id="tfa_279" class="calcval-CT">CT</option>
							<option value="tfa_280" id="tfa_280" class="calcval-DC">DC</option>
							<option value="tfa_281" id="tfa_281" class="calcval-DE">DE</option>
							<option value="tfa_282" id="tfa_282" class="calcval-FL">FL</option>
							<option value="tfa_283" id="tfa_283" class="calcval-GA">GA</option>
							<option value="tfa_284" id="tfa_284" class="calcval-HI">HI</option>
							<option value="tfa_285" id="tfa_285" class="calcval-IA">IA</option>
							<option value="tfa_286" id="tfa_286" class="calcval-ID">ID</option>
							<option value="tfa_287" id="tfa_287" class="calcval-IL">IL</option>
							<option value="tfa_288" id="tfa_288" class="calcval-IN">IN</option>
							<option value="tfa_289" id="tfa_289" class="calcval-KS">KS</option>
							<option value="tfa_290" id="tfa_290" class="calcval-KY">KY</option>
							<option value="tfa_291" id="tfa_291" class="calcval-LA">LA</option>
							<option value="tfa_292" id="tfa_292" class="calcval-MA">MA</option>
							<option value="tfa_293" id="tfa_293" class="calcval-MD">MD</option>
							<option value="tfa_294" id="tfa_294" class="calcval-ME">ME</option>
							<option value="tfa_295" id="tfa_295" class="calcval-MI">MI</option>
							<option value="tfa_296" id="tfa_296" class="calcval-MN">MN</option>
							<option value="tfa_297" id="tfa_297" class="calcval-MO">MO</option>
							<option value="tfa_298" id="tfa_298" class="calcval-MS">MS</option>
							<option value="tfa_299" id="tfa_299" class="calcval-MT">MT</option>
							<option value="tfa_300" id="tfa_300" class="calcval-NC">NC</option>
							<option value="tfa_301" id="tfa_301" class="calcval-ND">ND</option>
							<option value="tfa_302" id="tfa_302" class="calcval-NE">NE</option>
							<option value="tfa_303" id="tfa_303" class="calcval-NH">NH</option>
							<option value="tfa_304" id="tfa_304" class="calcval-NJ">NJ</option>
							<option value="tfa_305" id="tfa_305" class="calcval-NM">NM</option>
							<option value="tfa_306" id="tfa_306" class="calcval-NV">NV</option>
							<option value="tfa_307" id="tfa_307" class="calcval-NY">NY</option>
							<option value="tfa_308" id="tfa_308" class="calcval-OH">OH</option>
							<option value="tfa_309" id="tfa_309" class="calcval-OK">OK</option>
							<option value="tfa_310" id="tfa_310" class="calcval-OR">OR</option>
							<option value="tfa_311" id="tfa_311" class="calcval-PA">PA</option>
							<option value="tfa_312" id="tfa_312" class="calcval-RI">RI</option>
							<option value="tfa_313" id="tfa_313" class="calcval-SC">SC</option>
							<option value="tfa_314" id="tfa_314" class="calcval-SD">SD</option>
							<option value="tfa_315" id="tfa_315" class="calcval-TN">TN</option>
							<option value="tfa_316" id="tfa_316" class="calcval-TX">TX</option>
							<option value="tfa_317" id="tfa_317" class="calcval-UT">UT</option>
							<option value="tfa_318" id="tfa_318" class="calcval-VA">VA</option>
							<option value="tfa_319" id="tfa_319" class="calcval-VT">VT</option>
							<option value="tfa_320" id="tfa_320" class="calcval-WA">WA</option>
							<option value="tfa_321" id="tfa_321" class="calcval-WI">WI</option>
							<option value="tfa_322" id="tfa_322" class="calcval-WV">WV</option>
							<option value="tfa_323" id="tfa_323" class="calcval-WY">WY</option>
						</select>
					</div>

					<div id="tfa_325-D" class="oneField checkboxes">
						<label id="tfa_325-L" class="label preField">interested in (check all that apply)</label>
						<div class="inputWrapper">
							<span class="oneChoice">
								<input type="checkbox" value="tfa_326" id="tfa_326" name="tfa_326">
								<label class="label postField">teen programs</label>
							</span>
							<span class="oneChoice">
								<input type="checkbox" value="tfa_327" id="tfa_327" name="tfa_327">
								<label class="label postField">young adult programs</label>
							</span>
							<span class="oneChoice">
								<input type="checkbox" value="tfa_329" id="tfa_329" name="tfa_329">
								<label class="label postField">youth-serving professional trainings</label>
							</span>
							<span class="oneChoice">
								<input type="checkbox" value="tfa_328" id="tfa_328" name="tfa_328">
								<label class="label postField">parent/guardian info</label>
							</span>
							<span class="oneChoice">
								<input type="checkbox" value="tfa_330" id="tfa_330" name="tfa_330">
								<label class="label postField">org/school partnerships</label>
							</span>
						</div>
					</div>

					<div id="tfa_14-D" class="bears oneField">
						<p><input autocomplete="off" type="text" id="tfa_14" name="tfa_14" value="" placeholder="Phone (Optional)" class="form-field form-left"></p>
					</div>

					<div class="actions">
						<input type="submit" class="primaryAction" value="Subscribe">
					</div>

				</div>

				<input type="hidden" id="tfa_5" name="tfa_5" value="" class="">
				<input type="hidden" id="tfa_7" name="tfa_7" value="$url_without_query_string" class="">
				<input type="hidden" id="tfa_9" name="tfa_9" value="$user_agent" class="">
				<input type="hidden" id="tfa_324" name="tfa_324" value="$link" class="">
				<div style="clear:both"></div>
				<input type="hidden" value="389906" name="tfa_dbFormId" id="maillinglist_tfa_dbFormId">
				<input type="hidden" value="" name="tfa_dbResponseId" id="maillinglist_tfa_dbResponseId">
				<input type="hidden" value="69a49f1f4a2e33c665257059aa580902" name="tfa_dbControl" id="maillinglist_tfa_dbControl">
				<input type="hidden" value="11" name="tfa_dbVersionId" id="maillinglist_tfa_dbVersionId">
				<input type="hidden" value="" name="tfa_switchedoff" id="maillinglist_tfa_switchedoff">
			</form>
		</div>
	</div>	
IELS;
// !!! THE ABOVE LINE SHOULD NEVER BE INDENTED !!! ///
	// $form_output = apply_filters( 'ibme_form_recaptcha', $form_output );
	return $form_output;
}
