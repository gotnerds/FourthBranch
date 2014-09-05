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
	$("input[name='voteUser']").prop('checked',false);
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
function trendingCommentsBoxUser() {
	$('.trendingCommentsBoxUser').mouseover(function() {
	$(this.id).parent().find('span').html('<img src="../images/user.jpg" class="boxUserImage">');
	});
}
$.fn.equalizeHeights = function(){
  return this.height( Math.max.apply(this, $(this).map(function(i,e){ return $(e).height() }).get() ) )
}

$(document).ready(function(){
	$('.tomorrowsBillParticipateBox, .tomorrowsBillBox').equalizeHeights();
	$('.double-border').find('.xbut').click(function(){
		closeOverlaid();
	});
	$('#a, #forgot, #forgot2, #introduction, #individual, #confirm, #confirm2, #organization, #organization2, #organization3').hide();
    var height = $('tomorrowsBillBox').find('p').height();
    $('.tomorrowsBillParticipateBox').find('p').height(height)
    $('.trendingCommentsBoxUser').hover(
    function () {
        $(this).siblings('.trendingCommentsBoxDesc').children('.trendingCommentsBoxImage').animate({ "top": "-=230px" }, "slow" );
    },
    function () {
        $(this).siblings('.trendingCommentsBoxDesc').children('.trendingCommentsBoxImage').animate({ "top": "+=230px" }, "slow" );
    });

});
$(document).mouseup(function (e)
{
    var container = $(".double-border");

    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
    	closeOverlaid();
    }
});