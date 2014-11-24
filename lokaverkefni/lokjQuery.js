var elementPos = $("nav").offset();

$(document).ready(function() {

	$("#contButton").click(function() {
		contactMe();
	});

	$(window).scroll(function() {
		stickyNav();
	});

	$("#signIn").click(function(e) {
		signInUp(e);
	});

	$("#register").click(function(e) {
		signInUp(e);
	});

	$("#newgame").click(function() {
		pandaNewGame();
	});

	$("#addCard").click(function() {
		drawCard();
	});
    
    $("#undo").click(function() {
		undo();
	});
});

function contactMe() {
	var contact = $(".contactForm");
	var form = $("#contactForm");
	var contactSubject = $("#contSubject").val();
	var contactContent = $("#contContent").val();
	var contactEmail = $("#contEmail").val();
	var serializedData = form.serialize();

	if ((contactSubject && contactContent && contactEmail) !== '') {
		var request = $.ajax({
			type: "POST",
			url: "mailto.php",
			data: serializedData
		});

		request.done(function(data) {
			contact.children().hide();
			var label = $("<label />");
			var succ = $(label).append("Takk fyrir að hafa samband ! ég svara eins fljótt og ég get.").fadeIn("slow");
			contact.append(succ);
			console.log("Contact form send success")
		});

		request.fail(function(jqrq, status, err) {
			console.log("Contact form fail: " + "\n Type: " + jqrq + " " + status + "\n Reason: " + err)
		});
	}
	return false;
}

function signInUp(e) {
	e.preventDefault();

	$("#overlay").fadeIn(800);
	$("#overlay").fadeTo("slow", 0.8);
	$("#loginBox, #signUpBox").show();

	$("#signIn, #register").on("scroll touchmove mousewheel", function(e) {
		e.preventDefault();
		e.stopPropagation();
		return false;
	});

	$("#overlay").click(function() {
		$("#overlay, #loginBox, #signUpBox");	
		$("#overlay, #loginBox, #signUpBox").hide();

		$("#signIn, #register").off("scroll touchmove mousewheel")
	});
}

function stickyNav() {
	if ($(window).scrollTop() > elementPos.top) {
		$("nav").removeClass("navbar");
		$("nav").addClass("navbarSticky");
	} else {
		$("nav").removeClass("navbarSticky");
		$("nav").addClass("navbar");
	}    
}

function pandaNewGame() {
	// var newGame = true;

	$.ajax({
		type: "POST",
		url: "pandakapall/playGame.php",
		data: {new: true},
		success: function(data) {
			// alert(data);
			console.log("hallo");
            console.log("Starting new game");
			$("#newGame").html(data);
			// $("#playWindow").append(data);
			// $("").append(data);
			
		}
	});

	// return false;
}

function drawCard() {
	$.ajax({
		type: "POST",
		url: "pandakapall/playGame.php",
		data: {draw: true},
		success: function(data) {
			console.log("Drawing 1 card");
			// $(".cards").hide();
			$("#newGame").html(data);
		}
	});
}
function undo() {
	$.ajax({
		type: "POST",
		url: "pandakapall/playGame.php",
		data: {undo: true},
		success: function(data) {
			console.log("undo");
			// $(".cards").hide();
			$("#newGame").html(data);
		}
	});
}