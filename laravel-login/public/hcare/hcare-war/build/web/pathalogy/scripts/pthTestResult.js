// JavaScript Document to pthTestResult.jsp
function validateForm (testResult)
{
	var txtResult = document.testResult.result;
	var txtMinVal = document.testResult.minVal;
	var txtMaxVal = document.testResult.maxVal;
	
	for (var i = 0 ; i < txtResult.length ; i++)
	{
		if (txtResult[i].value < txtMinVal[i].value )
		{
			alert("Observed value can not be less than Min value, try again!");
			txtResult[i].focus();
			return false;
		}
		
		else if (txtResult[i].value > txtMaxVal[i].value )
		{
			alert("Observed value can not be greater than Max value, try again!");
			txtResult[i].focus();
			return false;
		}
	}
}