	$(document).ready(function(){
		var sessionStorage= window.sessionStorage;
		var sessionUID = sessionStorage.getItem('username');
		var sessionTOKEN = sessionStorage.getItem('token');
		console.log(sessionTOKEN);
		console.log(sessionUID);
		check(sessionTOKEN);
		//if either is empty, attempt to get sessionStorage from
		//other (page that might be open), Otherwise, just clear() +
		//redirect
		$.post('http://127.0.0.1/Front/sessionValidate.php',{username: sessionUID, token: sessionTOKEN}, function(data){
			console.log(data);
			check(data);
		} );
			
	});




function check(data){

	if (data == false || data == null){

		//sessionStorage.clear();
		//window.location.href="http://127.0.0.1/Front/index.html";
		console.log(data);
	}



}


