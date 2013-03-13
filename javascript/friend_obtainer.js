console.log('yeah buddy');
$(document).ready(function(){
	$(".mutual-friends").click(function(){
		var friendIDtext=$(this).children("span").text();
		var id1=""; var id2="";
		for (var i = 0; i < friendIDtext.length; i++) {
			if(friendIDtext.charAt(i)==='n'){
				id1=friendIDtext.substring(0,i);
				id2=friendIDtext.substring(i+1,friendIDtext.length);
			}
		}
		console.log(friendIDtext+ "~"+id1+"k"+id2);

		FB.api("/me","POST",{batch: [{"method":"GET","relative_url":'me/mutualfriends/'+id1+''},
									{"method":"GET","relative_url":"me/mutualfriends/"+id2+''}]},
			function(response){
				alert("finished");
				console.log(response);
				//decode the JSON
				//create new elements n display
			});
	});
});