/*
 * RadAvailableTestsDataBean.java
 *
 * Created on June 4, 2006, 9:13 PM
 *
 * To change this template, choose Tools | Template Manager
 * and open the template in the editor.
 */

package coshms.beans;

import java.util.ArrayList;
import java.util.Iterator;
import coshms.util.radiology.*;


/**
 *
 * @author Administrator
 */
public class RadAvailableTestsDataBean {
    
    /** Creates a new instance of RadAvailableTestsDataBean */
    public RadAvailableTestsDataBean() {
    }

    
//////////////////////////////////////////////    
    public ArrayList getRadTestAll() {
        
        LookupService lookupService = new LookupService ();
        coshms.ejb.radiology.RadiologyRemote  radRemoteSB  = lookupService.lookupRadiologyBean();
        
        try{
            return radRemoteSB.getRadTestAll();
        }catch(Exception ex){
        }
        return null;
    }

//////////////////////////////////////////////    
    public ArrayList getRadAvailableTests() {
        
        LookupService lookupService = new LookupService ();
        coshms.ejb.radiology.RadiologyRemote  radRemoteSB  = lookupService.lookupRadiologyBean();
        
        try{
            return radRemoteSB.getRadAvailableTests();
        }catch(Exception ex){
        }
        return null;
    }
//////////////////////////////////////////////    
    public ArrayList getPtRadTestList(int ptId) {
        
        LookupService lookupService = new LookupService ();
        coshms.ejb.radiology.RadiologyRemote  radRemoteSB  = lookupService.lookupRadiologyBean();
        
        try{
            return radRemoteSB.getRadTestAudit(ptId);
        }catch(Exception ex){
        }
        return null;
    }

//////////////////////////////////////////////    
    public ArrayList getRadTestDiscount(int ptId) {
        
        LookupService lookupService = new LookupService ();
        coshms.ejb.radiology.RadiologyRemote  radRemoteSB  = lookupService.lookupRadiologyBean();
        
        try{
            return radRemoteSB.getRadTestDiscount(ptId);
        }catch(Exception ex){
        }
        return null;
    }
//////////////////////////////////////////////    
    public ArrayList getRadTestResultInfo(int ptId) {
        
        LookupService lookupService = new LookupService ();
        coshms.ejb.radiology.RadiologyRemote  radRemoteSB  = lookupService.lookupRadiologyBean();
        
        try{
            return radRemoteSB.getRadTestResultInfo(ptId);
        }catch(Exception ex){
        }
        return null;
    }
//////////////////////////////////////////////    
    public ArrayList getRadTestReportInfo(int ptId) {
        
        LookupService lookupService = new LookupService ();
        coshms.ejb.radiology.RadiologyRemote  radRemoteSB  = lookupService.lookupRadiologyBean();
        
        try{
            return radRemoteSB.getRadTestReportInfo(ptId);
        }catch(Exception ex){
        }
        return null;
    }

//////////////////////////////////////////////    
    public ArrayList getRadTestInfo(int testId) {
        
        LookupService lookupService = new LookupService ();
        coshms.ejb.radiology.RadiologyRemote  radRemoteSB  = lookupService.lookupRadiologyBean();
        
        try{
            return radRemoteSB.getRadTestInfo(testId);
        }catch(Exception ex){
        }
        return null;
    }

    //////////////////////////////////////////////    
    public ArrayList getRadTestPayment(int ptId) {
        
        LookupService lookupService = new LookupService ();
        coshms.ejb.radiology.RadiologyRemote  radRemoteSB  = lookupService.lookupRadiologyBean();
        
        try{
            return radRemoteSB.getRadTestFee(ptId);
        }catch(Exception ex){
        }
        return null;
    }

/////////////////////////////////////////////    
    public String getPatientName(int ptId) {
        
        LookupService lookupService = new LookupService ();
        coshms.ejb.radiology.RadiologyRemote  radRemoteSB  = lookupService.lookupRadiologyBean();
        
        try{
            return radRemoteSB.getPatientName(ptId);
        }catch(Exception ex){
        }
        return null;
    }


    
}
