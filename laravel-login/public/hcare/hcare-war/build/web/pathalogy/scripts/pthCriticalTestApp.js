// JavaScript Document for pthCriticalTestApp.jsp
function validateForm (appointment)
{
	if (document.appointment.dateOfApp.value == "")
	{
		alert ("Error: Date of appointment is compulsory");
		document.appointment.dt.focus();
		return false;
	}
}