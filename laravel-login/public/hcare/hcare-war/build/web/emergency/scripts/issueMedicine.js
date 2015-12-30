// JavaScript Document for updatePharmStock.jsp

function validateForm (issueMeds)
{
	var validChars="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz~-!@#$%^&*()_+|}{\"><.?/;:";
	var spaceChar = " ";
	var validDigs="0123456789";

	var myIssueQty = document.issueMeds.issueQty;
	var myactQty = document.issueMeds.actQty;
		
	for (var c = 0 ; c < myIssueQty.length ; c++)
	{
		if (myIssueQty[c].value == "")
		{
			
			alert ("Error: Invalid issued quantity, Please try again");
			myIssueQty[c].focus();
			return false;
		}
		
		// start checking character one by one
		
		for (var i=0;i<myIssueQty[c].value.length;i++)
		{
			temp=myIssueQty[c].value.substring(i,i+1)

			if (validDigs.indexOf(temp)==-1  && myIssueQty[c].value.substring(0,1) ==spaceChar)
   			{
				alert ("Error: Invalid issued quantity, Please try again");
				myIssueQty[c].focus();
				return false;
			}
			else if (validChars.indexOf(temp)>=0)
			{
				alert ("Error: Invalid issued quantity, Please try again");
				myIssueQty[c].focus();
	    		return false;
   			}
		
			else if (temp == spaceChar)
			{
    			alert ("Error: Invalid issued quantity, Please try again");
				myIssueQty[c].focus();
				return false;
   			}
 		}
		
		/*
		alert (myIssueQty[c].value);
		alert (myactQty[c].value);
		*/
		var issue = myIssueQty[c].value;
		var act = myactQty[c].value;
		var temp = act - issue ;
		//alert (temp);
		// comparing issueQty with the actQty
		if (temp < 0)
		{
			alert ("Error: You cant issue more than prescribed quantity, Please try again");
			myIssueQty[c].focus();
			return false;
		}
	}
}