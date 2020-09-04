// Recaptcha success callback
window.recaptchaCallback = function(token) {
	document.getElementById('form-seeker-details').submit();
}
