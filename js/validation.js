function formValidation()
{
	//declaring variables
	var pass = document.registration.pass; 
	var fname = document.registration.fname; 
	var lname = document.registration.lname; 
	var uemail = document.registration.email; 
	if(pass_validation(pass,8))
	{
		if(allLetter(fname))
		{
			if(allLetter(lname))
			{
				if(ValidateEmail(uemail))
				{
				}
			}
		}
		
	}
	return false;
}
//validation of password
function pass_validation(pass,min)
{ 
	var pass_len = pass.value.length; 
	if (pass_len == 0 || pass_len < min)
	{
		msgAlert("Password must have at least 8 characters.");
		pass.focus();
		return false;
	}
	return true;
}
//validation of username
function allLetter(uname)
{ 
	var letters = /^[A-Za-z]+$/; 
	if(uname.value.match(letters))
	{
		return true;
	}
	else
	{
		msgAlert("Name must have alphabet characters only !");
		uname.focus();
		return false;
	}
}

//validation of E-mail
function ValidateEmail(uemail)
{ 
	var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	if(uemail.value.match(mailformat))
	{
		window.location.load();
		return true;
	}
	else
	{
		msgAlert("You have entered an invalid email address !");
		uemail.focus();
		return false;
	}
}