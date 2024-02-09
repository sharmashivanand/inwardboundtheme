<?php
//<!-- Forms !-->
add_action( 'wp_footer', 'ibme_flyout_widget_scripts' );

function ibme_flyout_widget_scripts() {
    ?>
    <script type="text/javascript">
    (function($){
        $(".ibme-optin-form-trigger").click(function(event){
            $(this).siblings('.op-side-panel-container').addClass('is-visible');
            $('body').addClass('overflow-hidden');
            event.stopPropagation();
        });
        
        $(".panel-close").click(function(event){
            $('.op-side-panel-container').removeClass('is-visible');
            $('body').removeClass('overflow-hidden');
            event.stopPropagation();
        });
        
    })(jQuery);
    </script>
    <?php
}


/* Join email list opt-in widget */
// https://dev.to/felipperegazio/how-to-create-a-simple-honeypot-to-protect-your-web-forms-from-spammers--25n8
add_shortcode('email-list-shortcode-widget', 'ibme_email_list_shortcode_widget' );

function ibme_email_list_shortcode_widget($atts) {
	
	extract(shortcode_atts(array(
		'wgt_class' => 'widget-class', 
		'btn_class' => 'center-button', 
		'btn_text' =>'Sign Up', 
		'wgt_btn_text' => 'I&#x27;m In!', 
		'wgt_text' => 'Stay Connected',
		'link' => 'https://ibme.com/confirmation/mailing-list/'
		), $atts)
	);
	
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
	
	<a class="ibme-optin-form-trigger blue-btn $btn_class">$btn_text</a>

	<!-- FORM: HEAD SECTION -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<script type="text/javascript" src="https://ibme.tfaforms.net/wForms/3.11/js/wforms.js?v=88a41a0062f8c011af96ec355938e1dee6e787e3"></script>
    <script type="text/javascript">
        wFORMS.behaviors.prefill.skip = false;
    </script>
	<script type="text/javascript" src="https://ibme.tfaforms.net/wForms/3.11/js/localization-en_US.js?v=88a41a0062f8c011af96ec355938e1dee6e787e3"></script>
	
	<!-- FORM: BODY SECTION -->
	<div class="wFormContainer opt-in-form op-side-panel-container no-iframe"  >
		<div class="op-side-panel $wgt_class">
		<button class="panel-close" aria-label="Close"><svg width="26" height="26" viewBox="0 0 26 22" xmlns="http://www.w3.org/2000/svg"><path d="M12.808 9.393l7.778-7.778L22 3.03l-7.778 7.779L22 18.586 20.586 20l-7.778-7.778L5.029 20l-1.414-1.414 7.778-7.778-7.778-7.779L5.03 1.615l7.779 7.778z"></path></svg></button>
			<div class="wForm" id="322064-WRPR" dir="ltr">
				<div class="opt-in-icon" style="text-align: center; padding: 0 0 20px;"><img src="https://ibme.com/wp-content/themes/ibme-lander-edge/assets/img/icons/opt-in-mail-icon.png" alt="Join Our Mailing List"/></div>
				<div class="codesection" id="code-322064"></div>
				<form method="post" action="https://ibme.tfaforms.net/responses/processor" class="hintsBelow labelsAbove" id="322064" role="form">
					<p class="blue-text bold">$wgt_text</p>
					<div class="form-inputs">
						<div id="email-signup_tfa_1-D" class="oneField opt-in-email-field">
							<p><input type="text" id="email-signup_tfa_1" name="tfa_1" value="" required placeholder="First Name" class="form-field form-left required"></p>
						</div>
						<div id="email-signup_tfa_2-D" class="oneField opt-in-email-field">
							<p><input type="text" id="email-signup_tfa_2" name="tfa_2" value="" required placeholder="Last Name" class="form-field form-left required"></p>
						</div>
						<div id="email-signup_tfa_4-D" class="oneField opt-in-email-field">
							<p><input type="text" id="email-signup_tfa_4" name="tfa_4" value="" required placeholder="Email" class="validate-email form-field form-left required"></p>
						</div>
						<div id="tfa_14-D" class="bears oneField opt-in-email-field">
							<p><input autocomplete="off" type="text" id="tfa_14" name="tfa_14" value="" placeholder="Phone (Optional)" class="form-field form-left"></p>
						</div>
						<div id="tfa_272-D" class="oneField">
							<p style="margin-bottom: 25px !important;">
								<label style="display: none;" id="tfa_272-L" class="label preField " for="tfa_272">State (Optional)</label>
								<select id="tfa_272" name="tfa_272" title="State" class="">
								<option value="">State (Optional)</option>
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
								<option value="tfa_323" id="tfa_323" class="calcval-WY">WY</option></select>
							</p>
						</div>
					</div>
					<div class="actions" id="email-signup_tfa_0-A">
						<input type="submit" class="primaryAction form-left blue-btn" value="$wgt_btn_text">
					</div>
					<div class="bottom-text" style="text-align: center; padding-top: 25px; color: #4c4c4e; font-style: italic;">Please complete the fields above to subscribe. Providing your state of residence will help us share regional-specific programs with you. We respect your privacy - your info will not be shared with anyone else.</div>
					<input type="hidden" id="tfa_5" name="tfa_5" value="" class="">
					<input type="hidden" id="tfa_7" name="tfa_7" value="$url_without_query_string" class="">
					<input type="hidden" id="tfa_9" name="tfa_9" value="$user_agent" class="">
					<input type="hidden" id="tfa_324" name="tfa_324" value="$url_without_query_string?mailing-list-success=1" class="">
					<div style="clear:both"></div>
					<input type="hidden" value="322064" name="tfa_dbFormId" id="email-signup_tfa_dbFormId">
					<input type="hidden" value="" name="tfa_dbResponseId" id="email-signup_tfa_dbResponseId">
					<input type="hidden" value="d630ab5949b47bec7e3d8be75e5dba8b" name="tfa_dbControl" id="email-signup_tfa_dbControl">
					<input type="hidden" value="11" name="tfa_dbVersionId" id="email-signup_tfa_dbVersionId">
					<input type="hidden" value="" name="tfa_switchedoff" id="email-signup_tfa_switchedoff">
				</form>
			</div>
		</div>
	</div>	
IELS;
// !!! THE ABOVE LINE SHOULD NEVER BE INDENTED !!! ///
	$form_output = apply_filters( 'ibme_form_recaptcha', $form_output );
	return $form_output;
}


/* More info opt-in widget */

add_shortcode('more-info-widget', 'more_info_shortcode_widget' );

function more_info_shortcode_widget($atts) {
	
	extract(shortcode_atts(array(
		'wgt_class' => 'widget-class', 
		'btn_class' => 'center-button', 
		'btn_text' =>'Sign Up', 
		'wgt_btn_text' => 'I&#x27;m In!', 
		'wgt_text' => 'Stay Connected',
		'wgt_footer' => 'Please complete the fields above to subscribe to our emails and receive more details on upcoming programs. Providing your state of residence will help us share regional-specific programs with you. We respect your privacy - your info will not be shared with anyone else.',
		'campaign' => '', 
		'status' => '', 
		'link' => 'https://ibme.com/confirmation/response-received/', 
		'drip' => ''
		), $atts)
	);
	
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
	
	<a class="ibme-optin-form-trigger ibme-button mint-button style-1 $btn_class">$btn_text</a>

	<!-- FORM: HEAD SECTION -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<script type="text/javascript" src="https://ibme.tfaforms.net/wForms/3.11/js/wforms.js?v=88a41a0062f8c011af96ec355938e1dee6e787e3"></script>
    <script type="text/javascript">
        wFORMS.behaviors.prefill.skip = false;
    </script>
	<script type="text/javascript" src="https://ibme.tfaforms.net/wForms/3.11/js/localization-en_US.js?v=88a41a0062f8c011af96ec355938e1dee6e787e3"></script>
	
	<!-- FORM: BODY SECTION -->
	<div class="wFormContainer opt-in-form op-side-panel-container no-iframe"  >
		<div class="op-side-panel $wgt_class">
		<button class="panel-close" aria-label="Close"><svg width="26" height="26" viewBox="0 0 26 22" xmlns="http://www.w3.org/2000/svg"><path d="M12.808 9.393l7.778-7.778L22 3.03l-7.778 7.779L22 18.586 20.586 20l-7.778-7.778L5.029 20l-1.414-1.414 7.778-7.778-7.778-7.779L5.03 1.615l7.779 7.778z"></path></svg></button>
			<div class="wForm" id="385752-WRPR" dir="ltr">
				<div class="codesection" id="code-385752"></div>
				<form method="post" action="https://ibme.tfaforms.net/responses/processor" class="hintsBelow labelsAbove" id="385752" role="form">
					<p class="blue-text bold">$wgt_text</p>
					<div class="form-inputs">
						<div id="tfa_1-D" class="oneField opt-in-email-field">
							<p><input type="text" id="tfa_1" name="tfa_1" value="" required placeholder="First Name" class="form-field form-left required"></p>
						</div>
						<div id="tfa_2-D" class="oneField opt-in-email-field">
							<p><input type="text" id="tfa_2" name="tfa_2" value="" required placeholder="Last Name" class="form-field form-left required"></p>
						</div>
						<div id="tfa_4-D" class="oneField opt-in-email-field">
							<p><input type="text" id="tfa_4" name="tfa_4" value="" required placeholder="Email" class="validate-email form-field form-left required"></p>
						</div>
						<div id="tfa_10-D" class="oneField opt-in-email-field">
							<p><input type="text" id="tfa_10" name="tfa_10" value="" placeholder="Phone (Optional)" class="form-field form-left"></p>
						</div>
						<div id="tfa_16-D" class="bears oneField opt-in-email-field">
							<p><input autocomplete="off" type="text" id="tfa_16" name="tfa_16" value="" placeholder="Other (Optional)" class="form-field form-left"></p>
						</div>
						<div id="tfa_272-D" class="oneField">
							<p style="margin-bottom: 25px !important;">
								<label style="display: none;" id="tfa_272-L" class="label preField " for="tfa_272">State (Optional)</label>
								<select id="tfa_272" name="tfa_272" title="State" class="">
								<option value="">State (Optional)</option>
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
								<option value="tfa_323" id="tfa_323" class="calcval-WY">WY</option></select>
							</p>
						</div>
					</div>
					<div class="actions" id="tfa_0-A">
						<input type="submit" class="primaryAction form-left blue-btn" value="$wgt_btn_text">
					</div>
					<div class="bottom-text" style="text-align: center; padding-top: 25px; color: #4c4c4e; font-style: italic;">$wgt_footer</div>
					<input type="hidden" id="tfa_5" name="tfa_5" value="$campaign" class="">
					<input type="hidden" id="tfa_6" name="tfa_6" value="$status" class="">
					<input type="hidden" id="tfa_8" name="tfa_8" value="$url_without_query_string?opt-in-success=1" class="">
					<input type="hidden" id="tfa_9" name="tfa_9" value="$drip" class="">
					<input type="hidden" id="tfa_12" name="tfa_12" value="$url_without_query_string" class="">
					<input type="hidden" id="tfa_14" name="tfa_14" value="$user_agent" class="">
					<div style="clear:both"></div>
					<input type="hidden" value="389586" name="tfa_dbFormId" id="tfa_dbFormId">
					<input type="hidden" value="" name="tfa_dbResponseId" id="tfa_dbResponseId">
					<input type="hidden" value="c980754fc1448003855f36a93b8f1d1d" name="tfa_dbControl" id="tfa_dbControl">
					<input type="hidden" value="11" name="tfa_dbVersionId" id="tfa_dbVersionId">
					<input type="hidden" value="" name="tfa_switchedoff" id="tfa_switchedoff">
				</form>
			</div>
		</div>
	</div>	
IELS;
// !!! THE ABOVE LINE SHOULD NEVER BE INDENTED !!! ///
	// $form_output = apply_filters( 'ibme_form_recaptcha', $form_output );
	return $form_output;
}


/* More info opt-in widget (no phone or state) */

add_shortcode('more-info-widget-nophone', 'more_info_shortcode_widget_nophone' );

function more_info_shortcode_widget_nophone($atts) {
	
	extract(shortcode_atts(array(
		'wgt_class' => 'widget-class', 
		'btn_class' => 'center-button', 
		'btn_text' =>'Sign Up', 
		'wgt_btn_text' => 'I&#x27;m In!', 
		'wgt_text' => 'Stay Connected',
		'wgt_footer' => 'Please complete the fields above to subscribe to our emails and receive more details on upcoming programs. Providing your state of residence will help us share regional-specific programs with you. We respect your privacy - your info will not be shared with anyone else.',
		'campaign' => '', 
		'status' => '', 
		'link' => 'https://ibme.com/confirmation/response-received/', 
		'drip' => ''
		), $atts)
	);
	
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
	
	<a class="ibme-optin-form-trigger blue-btn $btn_class">$btn_text</a>

	<!-- FORM: HEAD SECTION -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<script type="text/javascript" src="https://ibme.tfaforms.net/wForms/3.11/js/wforms.js?v=88a41a0062f8c011af96ec355938e1dee6e787e3"></script>
    <script type="text/javascript">
        wFORMS.behaviors.prefill.skip = false;
    </script>
	<script type="text/javascript" src="https://ibme.tfaforms.net/wForms/3.11/js/localization-en_US.js?v=88a41a0062f8c011af96ec355938e1dee6e787e3"></script>
	
	<!-- FORM: BODY SECTION -->
	<div class="wFormContainer opt-in-form op-side-panel-container no-iframe"  >
		<div class="op-side-panel $wgt_class">
		<button class="panel-close" aria-label="Close"><svg width="26" height="26" viewBox="0 0 26 22" xmlns="http://www.w3.org/2000/svg"><path d="M12.808 9.393l7.778-7.778L22 3.03l-7.778 7.779L22 18.586 20.586 20l-7.778-7.778L5.029 20l-1.414-1.414 7.778-7.778-7.778-7.779L5.03 1.615l7.779 7.778z"></path></svg></button>
			<div class="wForm" id="385752-WRPR" dir="ltr">
				<div class="codesection" id="code-385752"></div>
				<form method="post" action="https://ibme.tfaforms.net/responses/processor" class="hintsBelow labelsAbove" id="385752" role="form">
					<p class="blue-text bold">$wgt_text</p>
					<div class="form-inputs">
						<div id="tfa_1-D" class="oneField opt-in-email-field">
							<p><input type="text" id="tfa_1" name="tfa_1" value="" required placeholder="First Name" class="form-field form-left required"></p>
						</div>
						<div id="tfa_2-D" class="oneField opt-in-email-field">
							<p><input type="text" id="tfa_2" name="tfa_2" value="" required placeholder="Last Name" class="form-field form-left required"></p>
						</div>
						<div id="tfa_4-D" class="oneField opt-in-email-field">
							<p><input type="text" id="tfa_4" name="tfa_4" value="" required placeholder="Email" class="validate-email form-field form-left required"></p>
						</div>
						<div id="tfa_16-D" class="bears oneField opt-in-email-field">
							<p><input autocomplete="off" type="text" id="tfa_16" name="tfa_16" value="" placeholder="Other (Optional)" class="form-field form-left"></p>
						</div>
					</div>
					<div class="actions" id="tfa_0-A">
						<input type="submit" class="primaryAction form-left blue-btn" value="$wgt_btn_text">
					</div>
					<div class="bottom-text" style="text-align: center; padding-top: 25px; color: #4c4c4e; font-style: italic;">$wgt_footer</div>
					<input type="hidden" id="tfa_5" name="tfa_5" value="$campaign" class="">
					<input type="hidden" id="tfa_6" name="tfa_6" value="$status" class="">
					<input type="hidden" id="tfa_8" name="tfa_8" value="$url_without_query_string?opt-in-success=1" class="">
					<input type="hidden" id="tfa_9" name="tfa_9" value="$drip" class="">
					<input type="hidden" id="tfa_12" name="tfa_12" value="$url_without_query_string" class="">
					<input type="hidden" id="tfa_14" name="tfa_14" value="$user_agent" class="">
					<div style="clear:both"></div>
					<input type="hidden" value="389586" name="tfa_dbFormId" id="tfa_dbFormId">
					<input type="hidden" value="" name="tfa_dbResponseId" id="tfa_dbResponseId">
					<input type="hidden" value="c980754fc1448003855f36a93b8f1d1d" name="tfa_dbControl" id="tfa_dbControl">
					<input type="hidden" value="11" name="tfa_dbVersionId" id="tfa_dbVersionId">
					<input type="hidden" value="" name="tfa_switchedoff" id="tfa_switchedoff">
				</form>
			</div>
		</div>
	</div>	
IELS;
// !!! THE ABOVE LINE SHOULD NEVER BE INDENTED !!! ///
	// $form_output = apply_filters( 'ibme_form_recaptcha', $form_output );
	return $form_output;
}


/* TEST info opt-in widget */

add_shortcode('test-widget', 'test_shortcode_widget' );

function test_shortcode_widget($atts) {
	
	extract(shortcode_atts(array(
		'wgt_class' => 'widget-class', 
		'btn_class' => 'center-button', 
		'btn_text' =>'Sign Up', 
		'wgt_btn_text' => 'I&#x27;m In!', 
		'wgt_text' => 'Stay Connected',
		'campaign' => '', 
		'status' => '', 
		'link' => 'https://ibme.com/confirmation/response-received/', 
		'drip' => ''
		), $atts)
	);
	
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
	
	<a class="ibme-optin-form-trigger blue-btn $btn_class">$btn_text</a>

	<!-- FORM: HEAD SECTION -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<script type="text/javascript" src="https://ibme.tfaforms.net/wForms/3.11/js/wforms.js?v=88a41a0062f8c011af96ec355938e1dee6e787e3"></script>
    <script type="text/javascript">
        wFORMS.behaviors.prefill.skip = false;
    </script>
	<script type="text/javascript" src="https://ibme.tfaforms.net/wForms/3.11/js/localization-en_US.js?v=88a41a0062f8c011af96ec355938e1dee6e787e3"></script>
	
	<!-- FORM: BODY SECTION -->
	<div class="wFormContainer opt-in-form op-side-panel-container no-iframe"  >
		<div class="op-side-panel $wgt_class">
		<button class="panel-close" aria-label="Close"><svg width="26" height="26" viewBox="0 0 26 22" xmlns="http://www.w3.org/2000/svg"><path d="M12.808 9.393l7.778-7.778L22 3.03l-7.778 7.779L22 18.586 20.586 20l-7.778-7.778L5.029 20l-1.414-1.414 7.778-7.778-7.778-7.779L5.03 1.615l7.779 7.778z"></path></svg></button>
			<div class="wForm" id="389835-WRPR" dir="ltr">
				<div class="codesection" id="code-389835"></div>
				<form method="post" action="https://ibme.tfaforms.net/responses/processor" class="hintsBelow labelsAbove" id="389835" role="form">
					<p class="blue-text bold">$wgt_text</p>
					<div class="form-inputs">
						<div id="tfa_1-D" class="oneField opt-in-email-field">
							<p><input type="text" id="tfa_1" name="tfa_1" value="" required placeholder="First Name" class="form-field form-left required"></p>
						</div>
						<div id="tfa_2-D" class="oneField opt-in-email-field">
							<p><input type="text" id="tfa_2" name="tfa_2" value="" required placeholder="Last Name" class="form-field form-left required"></p>
						</div>
						<div id="tfa_4-D" class="oneField opt-in-email-field">
							<p><input type="text" id="tfa_4" name="tfa_4" value="" required placeholder="Email" class="validate-email form-field form-left required"></p>
						</div>
						<div id="tfa_10-D" class="oneField opt-in-email-field">
							<p><input type="text" id="tfa_10" name="tfa_10" value="" placeholder="Phone (Optional)" class="form-field form-left"></p>
						</div>
						<div id="tfa_16-D" class="bears oneField opt-in-email-field">
							<p><input autocomplete="off" type="text" id="tfa_16" name="tfa_16" value="" placeholder="Other (Optional)" class="form-field form-left"></p>
						</div>
						<div id="tfa_272-D" class="oneField">
							<p style="margin-bottom: 25px !important;">
								<label style="display: none;" id="tfa_272-L" class="label preField " for="tfa_272">State (Optional)</label>
								<select id="tfa_272" name="tfa_272" title="State" class="">
								<option value="">State (Optional)</option>
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
								<option value="tfa_323" id="tfa_323" class="calcval-WY">WY</option></select>
							</p>
						</div>
					</div>
					<div class="actions" id="tfa_0-A">
						<input type="submit" class="primaryAction form-left blue-btn" value="$wgt_btn_text">
					</div>
					<div class="bottom-text" style="text-align: center; padding-top: 25px; color: #4c4c4e; font-style: italic;">Please complete the fields above to subscribe to our emails and receive more details on upcoming programs. Providing your state of residence will help us share regional-specific programs with you. We respect your privacy - your info will not be shared with anyone else.</div>
					<input type="hidden" id="tfa_5" name="tfa_5" value="$campaign" class="">
					<input type="hidden" id="tfa_6" name="tfa_6" value="$status" class="">
					<input type="hidden" id="tfa_8" name="tfa_8" value="$url_without_query_string?opt-in-success=1" class="">
					<input type="hidden" id="tfa_9" name="tfa_9" value="$drip" class="">
					<input type="hidden" id="tfa_12" name="tfa_12" value="$url_without_query_string" class="">
					<input type="hidden" id="tfa_14" name="tfa_14" value="$user_agent" class="">
					<div style="clear:both"></div>
					<input type="hidden" value="389835" name="tfa_dbFormId" id="tfa_dbFormId">
					<input type="hidden" value="" name="tfa_dbResponseId" id="tfa_dbResponseId">
					<input type="hidden" value="3b724da40b478fff84dcbe0e37a1c193" name="tfa_dbControl" id="tfa_dbControl">
					<input type="hidden" value="11" name="tfa_dbVersionId" id="tfa_dbVersionId">
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



/* Workshop opt-in widget (drop-in meditations) */

add_shortcode('workshop-opt-in-widget', 'workshop_opt_in_shortcode_widget' );

function workshop_opt_in_shortcode_widget($atts) {
	
	extract(shortcode_atts(array(
		'wgt_class' => 'widget-class', 
		'btn_class' => 'center-button', 
		'btn_text' =>'Sign Up', 
		'wgt_btn_text' => 'I&#x27;m In!', 
		'wgt_text' => 'Join Us!',
		'campaign' => '', 
		'status' => '', 
		'link' => 'https://ibme.com/confirmation/meditation-opt-in/', 
		'drip' => ''
		), $atts)
	);

	$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http';
	$full_url = $protocol."://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$query_string = $_SERVER['QUERY_STRING'];
	$params = '?'.$query_string;
	$url_without_query_string = str_replace($params, '', $full_url);

	if(empty($url_without_query_string)) {
		$url_without_query_string = 'WordPress could not detect the URL. But the form was submitted via WordPress.';
	} 

	$form_output = <<<IELS
	
	<a class="ibme-optin-form-trigger blue-btn $btn_class">$btn_text</a>

	<!-- FORM: HEAD SECTION -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<script type="text/javascript" src="https://ibme.tfaforms.net/wForms/3.11/js/wforms.js?v=88a41a0062f8c011af96ec355938e1dee6e787e3"></script>
    <script type="text/javascript">
        wFORMS.behaviors.prefill.skip = false;
    </script>
	<script type="text/javascript" src="https://ibme.tfaforms.net/wForms/3.11/js/localization-en_US.js?v=88a41a0062f8c011af96ec355938e1dee6e787e3"></script>
	
	<!-- FORM: BODY SECTION -->
	<div class="wFormContainer opt-in-form op-side-panel-container no-iframe"  >
		<div class="op-side-panel $wgt_class">
		<button class="panel-close" aria-label="Close"><svg width="26" height="26" viewBox="0 0 26 22" xmlns="http://www.w3.org/2000/svg"><path d="M12.808 9.393l7.778-7.778L22 3.03l-7.778 7.779L22 18.586 20.586 20l-7.778-7.778L5.029 20l-1.414-1.414 7.778-7.778-7.778-7.779L5.03 1.615l7.779 7.778z"></path></svg></button>
			<div class="wForm" id="388696-WRPR" dir="ltr">
				<div class="codesection" id="code-388696"></div>
				<form method="post" action="https://ibme.tfaforms.net/responses/processor" class="hintsBelow labelsAbove" id="385752" role="form">
					<p class="blue-text bold">$wgt_text</p>
					<div class="form-inputs">
						<div id="tfa_1-D" class="oneField opt-in-email-field">
							<p><input type="text" id="tfa_1" name="tfa_1" value="" required placeholder="First Name" class="form-field form-left required"></p>
						</div>
						<div id="tfa_2-D" class="oneField opt-in-email-field">
							<p><input type="text" id="tfa_2" name="tfa_2" value="" required placeholder="Last Name" class="form-field form-left required"></p>
						</div>
						<div id="tfa_4-D" class="oneField opt-in-email-field">
							<p><input type="text" id="tfa_4" name="tfa_4" value="" required placeholder="Email" class="validate-email form-field form-left required"></p>
						</div>
						<div id="tfa_9-D" class="oneField opt-in-email-field">
							<p><input type="text" id="tfa_9" name="tfa_9" value="" placeholder="Phone (Optional)" class="form-field form-left"></p>
						</div>
						<div id="tfa_325-D" class="bears oneField opt-in-email-field">
							<p><input autocomplete="off" type="text" id="tfa_16" name="tfa_16" value="" placeholder="Other (Optional)" class="form-field form-left"></p>
						</div>
						<div id="tfa_272-D" class="oneField">
							<p style="margin-bottom: 25px !important;">
								<label style="display: none;" id="tfa_272-L" class="label preField " for="tfa_272">State (Optional)</label>
								<select id="tfa_272" name="tfa_272" title="State" class="">
								<option value="">State (Optional)</option>
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
								<option value="tfa_323" id="tfa_323" class="calcval-WY">WY</option></select>
							</p>
						</div>
					</div>
					<div class="actions" id="tfa_0-A">
						<input type="submit" class="primaryAction form-left blue-btn" value="$wgt_btn_text">
					</div>
					<div class="bottom-text" style="text-align: center; padding-top: 25px; color: #4c4c4e; font-style: italic;">Please complete the fields above to subscribe to our emails and receive info on our drop-in meditations. Providing your state of residence will help us share regional-specific programs with you. We respect your privacy - your info will not be shared with anyone else.</div>
					<input type="hidden" id="tfa_5" name="tfa_5" value="$campaign" class="">
					<input type="hidden" id="tfa_6" name="tfa_6" value="$status" class="">
					<input type="hidden" id="tfa_11" name="tfa_11" value="$url_without_query_string?drop-in-signup" class="">
					<input type="hidden" id="tfa_8" name="tfa_8" value="$drip" class="">
					<div style="clear:both"></div>
					<input type="hidden" value="388696" name="tfa_dbFormId" id="tfa_dbFormId">
					<input type="hidden" value="" name="tfa_dbResponseId" id="tfa_dbResponseId">
					<input type="hidden" value="3834cc363661a86dd0e8ae4f33a2b846" name="tfa_dbControl" id="tfa_dbControl">
					<input type="hidden" value="11" name="tfa_dbVersionId" id="tfa_dbVersionId">
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



/* Event opt-in widget (generic event) */

add_shortcode('event-opt-in-widget', 'event_opt_in_shortcode_widget' );

function event_opt_in_shortcode_widget($atts) {
	
	extract(shortcode_atts(array(
		'wgt_class' => 'widget-class', 
		'btn_class' => 'center-button', 
		'btn_text' =>'Sign Up', 
		'wgt_btn_text' => 'I&#x27;m In!', 
		'wgt_text' => 'Join Us!',
		'campaign' => '', 
		'status' => '', 
		'link' => 'https://ibme.com/confirmation/meditation-opt-in/', 
		'drip' => ''
		), $atts)
	);

	$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http';
	$full_url = $protocol."://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$query_string = $_SERVER['QUERY_STRING'];
	$params = '?'.$query_string;
	$url_without_query_string = str_replace($params, '', $full_url);

	if(empty($url_without_query_string)) {
		$url_without_query_string = 'WordPress could not detect the URL. But the form was submitted via WordPress.';
	}

	$form_output = <<<IELS
	
	<a class="ibme-optin-form-trigger blue-btn $btn_class">$btn_text</a>

	<!-- FORM: HEAD SECTION -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<script type="text/javascript" src="https://ibme.tfaforms.net/wForms/3.11/js/wforms.js?v=88a41a0062f8c011af96ec355938e1dee6e787e3"></script>
    <script type="text/javascript">
        wFORMS.behaviors.prefill.skip = false;
    </script>
	<script type="text/javascript" src="https://ibme.tfaforms.net/wForms/3.11/js/localization-en_US.js?v=88a41a0062f8c011af96ec355938e1dee6e787e3"></script>
	
	<!-- FORM: BODY SECTION -->
	<div class="wFormContainer opt-in-form op-side-panel-container no-iframe"  >
		<div class="op-side-panel $wgt_class">
		<button class="panel-close" aria-label="Close"><svg width="26" height="26" viewBox="0 0 26 22" xmlns="http://www.w3.org/2000/svg"><path d="M12.808 9.393l7.778-7.778L22 3.03l-7.778 7.779L22 18.586 20.586 20l-7.778-7.778L5.029 20l-1.414-1.414 7.778-7.778-7.778-7.779L5.03 1.615l7.779 7.778z"></path></svg></button>
			<div class="wForm" id="388696-WRPR" dir="ltr">
				<div class="codesection" id="code-388696"></div>
				<form method="post" action="https://ibme.tfaforms.net/responses/processor" class="hintsBelow labelsAbove" id="385752" role="form">
					<p class="blue-text bold">$wgt_text</p>
					<div class="form-inputs">
						<div id="tfa_1-D" class="oneField opt-in-email-field">
							<p><input type="text" id="tfa_1" name="tfa_1" value="" required placeholder="First Name" class="form-field form-left required"></p>
						</div>
						<div id="tfa_2-D" class="oneField opt-in-email-field">
							<p><input type="text" id="tfa_2" name="tfa_2" value="" required placeholder="Last Name" class="form-field form-left required"></p>
						</div>
						<div id="tfa_4-D" class="oneField opt-in-email-field">
							<p><input type="text" id="tfa_4" name="tfa_4" value="" required placeholder="Email" class="validate-email form-field form-left required"></p>
						</div>
						<div id="tfa_9-D" class="oneField opt-in-email-field">
							<p><input type="text" id="tfa_9" name="tfa_9" value="" placeholder="Phone (Optional)" class="form-field form-left"></p>
						</div>
						<div id="tfa_325-D" class="bears oneField opt-in-email-field">
							<p><input autocomplete="off" type="text" id="tfa_16" name="tfa_16" value="" placeholder="Other (Optional)" class="form-field form-left"></p>
						</div>
						<div id="tfa_272-D" class="oneField">
							<p style="margin-bottom: 25px !important;">
								<label style="display: none;" id="tfa_272-L" class="label preField " for="tfa_272">State (Optional)</label>
								<select id="tfa_272" name="tfa_272" title="State" class="">
								<option value="">State (Optional)</option>
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
								<option value="tfa_323" id="tfa_323" class="calcval-WY">WY</option></select>
							</p>
						</div>
					</div>
					<div class="actions" id="tfa_0-A">
						<input type="submit" class="primaryAction form-left blue-btn" value="$wgt_btn_text">
					</div>
					<div class="bottom-text" style="text-align: center; padding-top: 25px; color: #4c4c4e; font-style: italic;">Please complete the fields above to subscribe to our emails and receive info about this event. Providing your state of residence will help us share regional-specific programs with you. We respect your privacy - your info will not be shared with anyone else.</div>
					<input type="hidden" id="tfa_5" name="tfa_5" value="$campaign" class="">
					<input type="hidden" id="tfa_6" name="tfa_6" value="$status" class="">
					<input type="hidden" id="tfa_11" name="tfa_11" value="$url_without_query_string?drop-in-signup" class="">
					<input type="hidden" id="tfa_8" name="tfa_8" value="$drip" class="">
					<div style="clear:both"></div>
					<input type="hidden" value="388696" name="tfa_dbFormId" id="tfa_dbFormId">
					<input type="hidden" value="" name="tfa_dbResponseId" id="tfa_dbResponseId">
					<input type="hidden" value="3834cc363661a86dd0e8ae4f33a2b846" name="tfa_dbControl" id="tfa_dbControl">
					<input type="hidden" value="11" name="tfa_dbVersionId" id="tfa_dbVersionId">
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



/* Application Step 1 form */

add_shortcode('app-start-shortcode-widget', 'app_start_shortcode_widget' );

function app_start_shortcode_widget($atts) {
	
	extract(shortcode_atts(array(
		'wgt_class' => 'widget-class', 
		'btn_class' => 'center-button', 
		'btn_text' =>'Sign Up', 
		'wgt_btn_text' => 'I&#x27;m In!', 
		'wgt_text' => 'Stay Connected',
		'campaign' => '',
		'form_id' => ''
		), $atts)
	);
	
	$url = $_SERVER['REQUEST_URI'];

	if(empty($url)) {
		$url = 'WordPress could not detect the URL. But the form was submitted via WordPress.';
	}
	
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	if(empty($user_agent)) {
		$user_agent = 'WordPress could not detect the user-agent. But the form was submitted via WordPress.';
	}

	$form_output = <<<IELS
	
	<a class="ibme-optin-form-trigger ibme-button mint-button style-3 $btn_class">$btn_text</a>

	<!-- FORM: HEAD SECTION -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<!-- FORM: BODY SECTION -->
	<div class="wFormContainer opt-in-form op-side-panel-container"  >
		<div class="op-side-panel full-form $wgt_class">
		<button class="panel-close" aria-label="Close"><svg width="26" height="26" viewBox="0 0 26 22" xmlns="http://www.w3.org/2000/svg"><path d="M12.808 9.393l7.778-7.778L22 3.03l-7.778 7.779L22 18.586 20.586 20l-7.778-7.778L5.029 20l-1.414-1.414 7.778-7.778-7.778-7.779L5.03 1.615l7.779 7.778z"></path></svg></button>
			<iframe src="https://ibme.tfaforms.net/389577?c_id=$campaign&tfa_1415=$form_id&tfa_1419=$url" title="iBme Start App Form"></iframe>
		</div>
	</div>	
IELS;
// !!! THE ABOVE LINE SHOULD NEVER BE INDENTED !!! ///
	// $form_output = apply_filters( 'ibme_form_recaptcha', $form_output );
	return $form_output;
}


/* Custom Program Inquiry form */

add_shortcode('custom-program-inquiry-widget', 'custom_program_inquiry_widget' );

function custom_program_inquiry_widget($atts) {
	
	extract(shortcode_atts(array(
		'wgt_class' => 'widget-class', 
		'btn_class' => 'center-button', 
		'btn_text' =>'Sign Up', 
		'wgt_btn_text' => 'I&#x27;m In!', 
		'wgt_text' => 'Stay Connected',
		'campaign' => '',
		'form_id' => ''
		), $atts)
	);
	
	$url = $_SERVER['REQUEST_URI'];
	if(empty($url)) {
		$url = 'WordPress could not detect the URL. But the form was submitted via WordPress.';
	}
	
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	if(empty($user_agent)) {
		$user_agent = 'WordPress could not detect the user-agent. But the form was submitted via WordPress.';
	}

	$form_output = <<<IELS
	
	<a class="ibme-optin-form-trigger ibme-button mint-button style-1 $btn_class">$btn_text</a>

	<!-- FORM: HEAD SECTION -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<!-- FORM: BODY SECTION -->
	<div class="wFormContainer opt-in-form op-side-panel-container"  >
		<div class="op-side-panel full-form $wgt_class">
		<button class="panel-close" aria-label="Close"><svg width="26" height="26" viewBox="0 0 26 22" xmlns="http://www.w3.org/2000/svg"><path d="M12.808 9.393l7.778-7.778L22 3.03l-7.778 7.779L22 18.586 20.586 20l-7.778-7.778L5.029 20l-1.414-1.414 7.778-7.778-7.778-7.779L5.03 1.615l7.779 7.778z"></path></svg></button>
			<iframe src="https://ibme.tfaforms.net/389876?c_id=$campaign&tfa_1419=$url" title="Custom Program Inquiry Form"></iframe>
		</div>
	</div>	
IELS;
// !!! THE ABOVE LINE SHOULD NEVER BE INDENTED !!! ///
	// $form_output = apply_filters( 'ibme_form_recaptcha', $form_output );
	return $form_output;
}

/* Fundraiser Signup form */

add_shortcode('fundraiser-signup-widget', 'fundraiser_signup_widget' );

function fundraiser_signup_widget($atts) {
	
	extract(shortcode_atts(array(
		'wgt_class' => 'widget-class', 
		'btn_class' => 'center-button', 
		'btn_text' =>'Sign Up', 
		'wgt_btn_text' => 'I&#x27;m In!', 
		'wgt_text' => 'Stay Connected',
		'campaign' => '',
		'form_id' => ''
		), $atts)
	);
	
	$url = $_SERVER['REQUEST_URI'];
	if(empty($url)) {
		$url = 'WordPress could not detect the URL. But the form was submitted via WordPress.';
	}
	
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	if(empty($user_agent)) {
		$user_agent = 'WordPress could not detect the user-agent. But the form was submitted via WordPress.';
	}

	$form_output = <<<IELS
	
	<a class="ibme-optin-form-trigger blue-btn $btn_class">$btn_text</a>

	<!-- FORM: HEAD SECTION -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<!-- FORM: BODY SECTION -->
	<div class="wFormContainer opt-in-form op-side-panel-container"  >
		<div class="op-side-panel full-form $wgt_class">
		<button class="panel-close" aria-label="Close"><svg width="26" height="26" viewBox="0 0 26 22" xmlns="http://www.w3.org/2000/svg"><path d="M12.808 9.393l7.778-7.778L22 3.03l-7.778 7.779L22 18.586 20.586 20l-7.778-7.778L5.029 20l-1.414-1.414 7.778-7.778-7.778-7.779L5.03 1.615l7.779 7.778z"></path></svg></button>
			<iframe src="https://ibme.tfaforms.net/389895" title="Fundraiser Signup Form"></iframe>
		</div>
	</div>	
IELS;
// !!! THE ABOVE LINE SHOULD NEVER BE INDENTED !!! ///
	// $form_output = apply_filters( 'ibme_form_recaptcha', $form_output );
	return $form_output;
}


define( 'THANKYOU_INQ', '13323' );
// Thank you page

function thank_you_inq_content( $content ) {
	$details = '';
	$output  = '';
	if ( is_page( THANKYOU_INQ ) ) {
		$content = $output;
	}
	return $content;
}

add_action('wp_head','thank_you_inq_view');

function thank_you_inq_view() {
	if ( is_page( THANKYOU_INQ ) ) {
		remove_action( 'lander_header', 'lander_header' );
		remove_action( 'lander_footer', 'lander_footer_open', 5 );
		remove_action( 'lander_footer', 'ibme_custom_footer_content' );
		remove_action( 'lander_footer', 'lander_footer_close', 15 );

	}
}


define( 'THANKYOU_APP', '9480' );
// Thank you page

function thank_you_app_content( $content ) {
	$details = '';
	$output  = '';
	if ( is_page( THANKYOU_APP ) ) {
		$content = $output;
	}
	return $content;
}

function thank_you_app_view() {
	if ( is_page( THANKYOU_APP ) ) {
		remove_action( 'lander_header', 'lander_header' );

		remove_action( 'lander_footer', 'lander_footer_open', 5 );
		remove_action( 'lander_footer', 'ibme_custom_footer_content' );
		remove_action( 'lander_footer', 'lander_footer_close', 15 );

	}
}

add_action( 'wp_head', 'app_start_thankyou' );

// open thankyou page in iframe conditionally else bust out of iframe.
function app_start_thankyou() {
	?>
	<script type="text/javascript">
	var urlParamsT = new URLSearchParams( self.location.search );
	var urlParamT = urlParamsT.get( 'show_in_iframe' );
	console.dir(urlParamT);
	console.dir(typeof urlParamT);
	if(urlParamT && urlParamT == '0' ){ 
			if( top.location != self.location ) {			
				top.location = self.location.href.replace(self.location.search,'');
			}
	}
	</script>
	<?php
}
