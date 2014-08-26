//Login Functions

function introduction(){
	if ($('body').hasClass('overlaid')) {
	} else {
	$('body').addClass('overlaid');
	}
	$('#introduction').show();
	$('#a, #individual, #organization').hide();
}
function a(){
	if ($('body').hasClass('overlaid')) {
	} else {
	$('body').addClass('overlaid');
	}
	$('#a').show();
	$('#individual, #organization').hide();
}
function forgotPassword(){
	if ($('body').hasClass('overlaid')) {
	} else {
	$('body').addClass('overlaid');
	}
	$('#forgot').show();
	$('#a').hide();
}
function individual(){
	$('#individual').show();
	$('#introduction').hide();
}
function organization(){
	$('#organization').show();
	$('#organization2, #introduction').hide();
}
function organization2(){
	$('#organization2').show();
	$('#organization3, #organization').hide();
}
function organization3(){
	$('#organization3').show();
	$('#organization2').hide();
}
function closeOverlaid(){
	$('body').removeClass('overlaid');
	$('#a, #forgot, #forgot2, #introduction, #individual, #confirm, #confirm2, #organization, #organization2, #organization3').hide();
}
function mergeForms() {
    var forms = [];
    $.each($.makeArray(arguments), function(index, value) {
        forms[index] = document.forms[value];
    });
    var targetForm = forms[0];
    $.each(forms, function(i, f) {
        if (i != 0) {
            $(f).find('input, select, textarea, #reason')
                .hide()
                .appendTo($(targetForm));
        }
    });
    $(targetForm).submit();
}

$(document).ready(function(){
	$('.xbut').click(closeOverlaid());
	$('#a, #forgot, #forgot2, #introduction, #individual, #confirm, #confirm2, #organization, #organization2, #organization3').hide();
});