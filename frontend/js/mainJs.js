
//userVote
   function userVote(e) {
        console.log(e);
        var postData = $(e).serializeArray();
        console.log(postData);
        $.ajax(
        {
            url : 'inc/postVote.php',
            type: "POST",
            data : postData,
            success:function(data) 
            {
                console.log(data);
                $(e).html(data);
                //data: return data from server
            },
            error: function(jqXHR, textStatus, errorThrown) 
            {
                console.log("NO!");
                //if fails      
            }
        });
        e.preventDefault(); //STOP default action
        e.unbind(); //unbind. to stop multiple form submit.
    }
//userShare
   function userShare(e) {
        console.log(e);
        var postData = $(e).serializeArray();
        console.log(postData);
        $.ajax(
        {
            url : 'inc/shareActions.php',
            type: "POST",
            data : postData,
            success:function(data) 
            {
                console.log(data);
                $(e).append(data);
                //data: return data from server
            },
            error: function(jqXHR, textStatus, errorThrown) 
            {
                console.log("NO!");
                //if fails      
            }
        });
        e.preventDefault(); //STOP default action
        e.unbind(); //unbind. to stop multiple form submit.
    }

   function userCart(e) {
        console.log(e);
        var postData = $(e).serializeArray();
        console.log(postData);
        $.ajax(
        {
            url : 'inc/cartUpdate.php',
            type: "POST",
            data : postData,
            success:function(data) 
            {
                console.log(data);
                location.reload();
                //data: return data from server
            },
            error: function(jqXHR, textStatus, errorThrown) 
            {
                console.log("NO!");
                //if fails      
            }
        });
        event.preventDefault(); //STOP default action
        e.unbind(); //unbind. to stop multiple form submit.
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
function imageCycle() {
	console.log($(this));


}

function imageClicked()
{
  //get images in the set
  var imageSrcs = this.getAttribute('data-altsrc');

  //var urlSet = $(this).closest('.linkerrr').getAttribute('data-alturl').split(',');
  //var headlineSet = $(this).closest('.newsItem').getAttribute('headline').split(',');

  //Use a closure to wrap the counter variable
  //so each image element has their own unique counter
  var counter = 0;
  return function(event)
  {
    //Increment counter
    counter++;
    //The context of "this" is the image element
    //Use a modulus
    this.src = imageSet[counter % imageSet.length];
    this.src = imageSet[counter % imageSet.length];
    //this.parent().href = urlSet[counter % urlSet.length];
    //this.parent().href = urlSet[counter % urlSet.length];
  
  }
}
jQuery(function($) {
    $('#dreamAndWish').bind('scroll', function() {
        if($(this).scrollTop() + $(this).innerHeight() >= this.scrollHeight) {
            alert('end reached');
        }
    })
});
//Select all elements on the page with the name attribute equal to VCRImage

$(document).ready(function(){
	var counter = 0;

	$('.newsItem a').click(function() {
		var urlHrefs = $(this).attr('data-alturl');
		var urlSet = urlHrefs.split(',');
		var headlines = $(this).closest('.newsItem').attr('headliners');
		var headlineSet = headlines.split('/');
		var imageSrcs = $(this).children('.newsImage').attr('data-altsrc');
		var imageSet = imageSrcs.split(',');
		$(this).attr("href", urlSet[counter]);
		if ((counter+1) == imageSet.length) {
			counter = 0;
		} else {
			counter++;
		}
		$(this).children('.newsImage').attr("src", imageSet[counter]);
		$(this).closest('.newsItem').attr("headline", headlineSet[counter]);
    
	});
	$(".newsItem").each(function(){
    // Uncomment the following if you need to make this dynamic
    var refH = $(this).height();
    var refW = $(this).width();
    var refRatio = refW/refH;

    // Hard coded value...
    var refRatio = 240/300;

    var imgH = $(this).children("img").height();
    var imgW = $(this).children("img").width();

    if ( (imgW/imgH) < refRatio ) { 
        $(this).addClass("portrait");
	    } else {
	        $(this).addClass("landscape");
	    }
	})
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
    //equalizeNotdHeight();
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
    //validation rules\
    $("#signupOrganization").validate({
        rules: {
            nameOrganization: "required",
            addressOrganization: "required",
            cityOrganization: "required",
            stateOrganization: "required",
            zipOrganization: {
                required: true,
                minlength: 5,
                maxlength: 5
            },
            phoneOrganization: {
                required: true,
            },
            imgInp: "required",
            reason: "required",
        },
        errorElement: "div",
        errorPlacement: function(error, element) {
            error.appendTo("element");
        }, 
        showErrors: function(errorMap, errorList) {
            $("#summary").html("Your form contains "
              + this.numberOfInvalids()
              + " errors, see details below.");
            this.defaultShowErrors();
        }

    });
    $("#goToOrganization2").click(function(){
        if ($('#signupOrganization').valid()) {
            organization2();
        } else {
            alert ("Please fill in all fields correctly.");
        }
    });
    $("#signupOrganization2").validate({
        rules: {
            nameI: "required",
            titleI: "required",
            phonePersonal: "required",
            emailO: {
                required: true,
                email: true
            }
        },
        errorElement: "div",
        errorPlacement: function(error, element) {
            error.appendTo("element");
        }, 
        showErrors: function(errorMap, errorList) {
            $("#summary").html("Your form contains "
              + this.numberOfInvalids()
              + " errors, see details below.");
            this.defaultShowErrors();
        }
    });
    $("#goToOrganization3").click(function(){
        if ($('#signupOrganization2').valid()) {
            organization3();
        } else {
            alert ("Please fill in all fields correctly.");
        }
    });
    $("#signupOrganization3").validate({
        rules: {
            emailS: {
                required: true,
                email: true
            },
            emailS2: {
                required: true,
                email: true
            },
            passS: {
                required: true,
                minlength: 6
            },
            passS2: {
                required: true,
                minlength: 6
            }
        },
        errorElement: "div",
        errorPlacement: function(error, element) {
            error.appendTo("element");
        }, 
        showErrors: function(errorMap, errorList) {
            $("#summary").html("Your form contains "
              + this.numberOfInvalids()
              + " errors, see details below.");
            this.defaultShowErrors();
        }
    });

    $("#addOrganization-button").click(function(){
        if ($('#signupOrganization').valid()) {
            mergeForms('signupOrganization', 'signupOrganization3', 'signupOrganization2');
        } else {
            alert ("Please fill in all fields correctly.");
        }
    });
    $("#addIndividual").validate({
        rules: {
            fname: "required",
            lname: "requred",
            pseudonym: "required",
            dob: "required",
            emailI: {
                required: true,
                email: true
            }, 
            emailI2: {
                required: true,
                email: true,
            },
            password: {
                required: true,
                minlength: 5
            },
            confirmpwd: {
                required: true,
                minlength: 5
            },
            address: "required",
            city: "required",
            state: "required",
            zip: {
                minlength: 5,
                required: true,
                maxlength: 5
            }
        },
        messages: {
            emailI: {
                required: "Please enter an email",
                email: "Please enter a valid email"
            }
        },
        errorElement: "div",
        errorPlacement: function(error, element) {
            error.appendTo("element");
        }, 
        showErrors: function(errorMap, errorList) {
            $("#summary").html("Your form contains "
              + this.numberOfInvalids()
              + " errors, see details below.");
            this.defaultShowErrors();
        }
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