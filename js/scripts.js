(function($) {
'use strict';
$(function() {
	$('.form-control.is-invalid').on('focus', function() {$(this).removeClass('is-invalid');});
	$('.form-control.is-valid').on('focus', function() {$(this).removeClass('is-valid');});
});
})(jQuery)