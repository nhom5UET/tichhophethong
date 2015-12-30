// JavaScript Document for pthAvailableTests.jsp
function validateForm (availableTest)
{
	var avTests = document.availableTest.testCB;
	var temp = 0;
	for (var i = 0 ; i <avTests.length ; i++)
	{
		if (avTests[i].checked=true)
		{
			temp = 1;
			alert (temp);
		}
	}
	if (temp ==0)
	{
		alert ("You must select a test to proceed, try again!");
		return false;
	}
	else
	{
		return false;
	}
	
}