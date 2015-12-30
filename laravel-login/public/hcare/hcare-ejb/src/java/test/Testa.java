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
public class Testa {
    
    
    /** Creates a new instance of Test */
    public Testa() {
    }
    
    public static void main(String args[]){
       
//        Date dt = new Date(11,11,2005);
//        dt.setDate(21);
//        dt.setMonth(12);
//        dt.setYear(2005);
//        
//        System.out.println(dt.toString());
       
//        Long dbFid=new Long("4112000099");
//        Long fid = new Long(10);
//
//
//        String strThisYear = Integer.valueOf(new java.util.Date().getYear()).toString().substring(1, 3);
//        String strThisMonth = Integer.valueOf(new java.util.Date().getMonth() + 1).toString();
//
//        if(strThisMonth.length() ==  1)
//            strThisMonth = "0"+strThisMonth;
//
//        System.out.println("strThisYear: = " + strThisYear);
//        System.out.println("strThisMonth: = " + strThisMonth);
//
//        if(dbFid == null){
//            String strFid = new String( strThisYear + strThisMonth + "000001" );
//            fid = Long.valueOf(strFid);
//        } else{
//            String strDbFid = dbFid.toString();
//            String strDbYear = strDbFid.substring( 0, strDbFid.length() - 8 );
//            String strDbMonth = strDbFid.substring(strDbFid.length() - 8, strDbFid.length() - 6 );
//
//            if(strDbYear.length() == 1)
//                strDbYear = "0" + strDbYear;
//
//            if(strDbMonth.equalsIgnoreCase(strThisMonth) && strDbYear.equalsIgnoreCase(strThisYear) ){
//                long longFid = dbFid.longValue() + 1 ;
//                fid = Long.valueOf(longFid) ;
//            }else{
//                String strFid = strThisYear + strThisMonth + "000001";
//                System.out.println(strThisYear);
//                fid = Long.valueOf(strFid);
//            }
//        }
//
//        System.out.println(fid);
        long l = 7;
        
        Object o = (Long)l;
        
        int i = (int)l;

        System.out.println ("-------------------"+i);


    }
    
}
