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

		var thisElement=$(this);
		FB.api("/me","POST",{batch: [{"method":"GET","relative_url":'me/mutualfriends/'+id1+''},
									{"method":"GET","relative_url":"me/mutualfriends/"+id2+''}]},
			function(response){
				alert("finished");
				var mut_friends={};
				for (var i in response) {
					var obj=JSON.parse(response[i]['body']);
					mut_friends[i]=obj;
				}
				var friend1=mut_friends[0]['data'];
				var friend2=mut_friends[1]['data'];

				var overlap=[];
				for (var f1 in friend1) {
					for (var f2 in friend2) {
						if (friend1[f1]['id']===friend2[f2]['id']) {
							//overlap.push(friend1[f1]['id']);
							overlap.push(friend1[f1]);
						}
					}
				}
				var spanText="";
				var imSrc="";
				thisElement.append($('<br />'));
				for (var j in overlap) {
					imSrc="https://graph.facebook.com/"+overlap[j]['id']+"/picture";
					spanText=overlap[j]['name'];
					var im=$('<img />').attr('src',imSrc);
					var sp=$('<span />').text(spanText);
					thisElement.append(im);
					thisElement.append(sp);
					$('<br />').appendTo(thisElement);
				}
				console.log(overlap);
				//float the divs?
				//make popup display 
			}
		);
	});
});