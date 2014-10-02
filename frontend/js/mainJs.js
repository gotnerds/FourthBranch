//User Vote
function userVote() {
	$.POST( "userVote.php, $(this).serialize() );");

}

//Login Functions
function formhash(form, password) {
    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");
 
    // Add the new element to our form. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
 
    // Make sure the plaintext password doesn't get sent. 
    password.value = "";
 
    // Finally submit the form. 
    form.submit();
}
function shareButton(){
  $.ajax({
    type: "POST",
    url: "addToShareCount.php",
    data: { name: $("select[name='players']").val()},
    success:function( msg ) {
     alert( "Data Saved: " + msg );
    }
   });
}
function regformhash(form, uid, email, password, conf) {
     // Check each field has a value
    if (uid.value == ''         || 
          email.value == ''     || 
          password.value == ''  || 
          conf.value == '') {
 
        alert('You must provide all the requested details. Please try again');
        return false;
    }
 
    // Check the username
 
    re = /^\w+$/; 
    if(!re.test(uid.value)) { 
        alert("Username must contain only letters, numbers and underscores. Please try again"); 
        form.username.focus();
        return false; 
    }
 
    // Check that the password is sufficiently long (min 6 chars)
    // The check is duplicated below, but this is included to give more
    // specific guidance to the user
    if (password.value.length < 6) {
        alert('Passwords must be at least 6 characters long.  Please try again');
        form.password.focus();
        return false;
    }
 
    // At least one number, one lowercase and one uppercase letter 
    // At least six characters 
 
    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/; 
    if (!re.test(password.value)) {
        alert('Passwords must contain at least one number, one lowercase and one uppercase letter.  Please try again');
        return false;
    }
 
    // Check password and confirmation are the same
    if (password.value != conf.value) {
        alert('Your password and confirmation do not match. Please try again');
        form.password.focus();
        return false;
    }
 
    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");
 
    // Add the new element to our form. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
 
    // Make sure the plaintext password doesn't get sent. 
    password.value = "";
    conf.value = "";
 
    // Finally submit the form. 
    form.submit();
    return true;
}

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
    return regformhash(targetForm,
                       'Fakeuser1',
                       (targetForm).emailS,
                       targetForm.passS,
                       targetForm.passS2);
    //$(targetForm).submit();
}
//Bill Functions
function trendingCommentsBoxUser() {
	$('.trendingCommentsBoxUser').mouseover(function() {
	$(this.id).parent().find('span').html('<img src="../images/user.jpg" class="boxUserImage">');
	});
}
//Equalize Heights of Sections
$.fn.equalizeHeights = function(){
  return this.height( Math.max.apply(this, $(this).map(function(i,e){ return $(e).height() }).get() ) )
}
function equalizeHeight(one, two){
	var height = $(one).height();
    $(two).height(height);
}
function equalizeNotdHeight(){
	var notdHeight = (($('#newsOfTheDay').height()) + ($('#newsOfTheDay').offset().top));
	var billDetailsHeight = ($('.billDetails').height() + $('.billDetails').offset().top);
	var marginCalc = ((billDetailsHeight - notdHeight) / 4);
	$('#newsOfTheDay img').css('margin-bottom', marginCalc);
}
jQuery(function($) {
    $('#dreamAndWish').bind('scroll', function() {
        if($(this).scrollTop() + $(this).innerHeight() >= this.scrollHeight) {
            alert('end reached');
        }
    })
});
$(document).ready(function(){

    $(".headerLogin input[name='password']").keypress(function(event) {
	    if (event.which == 13) {
	    	formhash(this.form, this.form.password);
	    }
	});
	$('.tomorrowsBillParticipateBox, .tomorrowsBillBox').equalizeHeights();
	$('.double-border').find('.xbut').click(function(){
		closeOverlaid();
	});
	$('#a, #forgot, #forgot2, #introduction, #individual, #confirm, #confirm2, #organization, #organization2, #organization3').hide();
    equalizeHeight('.tomorrowsBillBox', '.tomorrowsBillParticipateBox');
    $('.trendingCommentsBoxUser').hover(
    function () {
        $(this).siblings('.trendingCommentsBoxDesc').children('.trendingCommentsBoxImage').animate({ "top": "-=230px" }, "slow" );
    },
    function () {
        $(this).siblings('.trendingCommentsBoxDesc').children('.trendingCommentsBoxImage').animate({ "top": "+=230px" }, "slow" );
    });
    if ($('#newsOfTheDay:visible').length == 0) {
    } else {
    equalizeNotdHeight();
	}
	if ($('.introduction:visible').length == 0) {
    } else {
    equalizeHeight('.introductionVideo', '.introductionDesc');
   	}
    var max = 3;
    var checkboxes = $('.proposal1 input[type="checkbox"]');

    checkboxes.change(function(){
        var current = checkboxes.filter(':checked').length;
        checkboxes.filter(':not(:checked)').prop('disabled', current >= max);
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