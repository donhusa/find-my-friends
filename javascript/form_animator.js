console.log('yeah buddy');
$(document).ready(function(){
	$("#jobrequest").change(function(){
		if ($(this).val()==="mut friends") {
			$("#mutualfriends").show('slow');
			$("#friendgroups").hide('slow');
		}
		if ($(this).val()==="friend group") {
			$("#mutualfriends").hide('slow');
			$("#friendgroups").show('slow');
		}
	});
});