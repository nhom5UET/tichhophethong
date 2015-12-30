/*
 * Test.java
 *
 * Created on May 20, 2006, 2:46 PM
 *
 * To change this template, choose Tools | Template Manager
 * and open the template in the editor.
 */
package test;

import java.sql.Date;

/**
 *
 * @author Asif
 */
public class Test {
    
    
    /** Creates a new instance of Test */
    public Test() {
    }
    
    public static void main(String args[]){
        Long dbFid=new Long(607000045);
        Long fid = new Long(10);
        String strDbFid = dbFid.toString();
        
      
        
        
        
        
        String strThisYear = Integer.valueOf(new java.util.Date().getYear()).toString().substring(1, 3);
        String strThisMonth = Integer.valueOf(new java.util.Date().getMonth() + 1).toString();
        
        System.out.println("strThisYear: = " + strThisYear);
        System.out.println("strThisMonth: = " + strThisMonth);
        
        if(strThisMonth.length() ==  1)
            strThisMonth = "0"+strThisMonth;
        
        if(dbFid == null){
            String strFid = new String( strThisYear + strThisMonth + "000001" );
            fid = Long.valueOf(strFid);
        } else{
            String strDbYear = strDbFid.substring( 0, strDbFid.length() - 8 );
            String strDbMonth = strDbFid.substring(strDbFid.length() - 8, strDbFid.length() - 6 );
            
            if(strDbYear.length() == 1)
                strDbYear = "0" + strDbYear;
            
            if(strDbMonth.equalsIgnoreCase(strThisMonth) && strDbYear.equalsIgnoreCase(strThisYear) ){
                long intPid = dbFid.intValue() + 1 ;
                fid = Long.valueOf(intPid) ;
            }else{
                String strFid = strThisYear + strThisMonth + "000001";
                System.out.println(strThisYear);
                fid = Long.valueOf(strFid);
            }
        }
        
        System.out.println(fid);
    }
    
}
