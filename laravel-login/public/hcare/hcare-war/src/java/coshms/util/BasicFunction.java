/*
 * BasicFunction.java
 * Created on 13 May 2006, 14:28
 */

package coshms.util;

import java.sql.Date;
/*
 * @author asif
 */

public class BasicFunction {
    public BasicFunction() {
    }    
    public Date strToDate(String dob){
        String[] strMonths = {"January","February","March","April","May","June","July","August","September","October","November","December"};
        int i, j=-10;
        for(i=0; i<=11; i++){
            j = dob.indexOf(strMonths[i]);
            if(j>=0) {
                j = i;
                break;
            }
        }
        String strDay = dob.substring(0,dob.indexOf( new String("/")));
        String strYear = dob.substring(dob.length()-4, dob.length());
        return new java.sql.Date(Integer.parseInt(strYear)-1900, j, Integer.parseInt(strDay));
    }
    public String getMonthName(int month){
        String[] strMonths = {"January","February","March","April","May","June","July","August","September","October","November","December"};
        return strMonths[month];
    }
    
    public String getDateString(java.sql.Date date){
        if(date.getDate()<10)
            return "0"+date.getDate()+"/"+getMonthName(date.getMonth())+"/"+(1900+date.getYear());
        else
            return date.getDate()+"/"+getMonthName(date.getMonth())+"/"+(1900+date.getYear());
    }
    
    public String getTiming(Integer timeInt){
        int time = timeInt.intValue();
        String strTime;        
        switch (time){
            case 0:
                strTime = "0 + 0 + 0";
                break;
            case 1:
                strTime = "0 + 0 + 1";
                break;
            case 2:
                strTime = "0 + 1 + 0";
                break;
            case 3:
                strTime = " 0 + 1 + 1";
                break;
            case 4:
                strTime = "1 + 0 + 0";
                break;
            case 5:
                strTime = "1 + 0 + 1";
                break;
            case 6:
                strTime = "1 + 1 + 0";
                break;
            case 7:
                strTime = "1 + 1 + 1";
                break;
            default:
                strTime = "N/A";
        }
        return strTime;
    }
}
