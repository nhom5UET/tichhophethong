/*
 * PthAvailableTestsDataBean.java
 *
 * Created on May 6, 2006, 12:45 PM
 *
 * To change this template, choose Tools | Template Manager
 * and open the template in the editor.
 */

package coshms.beans;

import java.util.ArrayList;
import java.util.Iterator;
import coshms.util.pathalogy.*;
/**
 *
 * @author Administrator
 */
public class PthAvailableTestsDataBean {
    
    /** Creates a new instance of PthAvailableTestsDataBean */
    public PthAvailableTestsDataBean() {
        
    }
////////////////////////////////////////////////    
    public ArrayList getPthAvailableTests() {
        
        LookupService lookupService = new LookupService ();
        coshms.ejb.pathalogy.PathalogyRemote  pthRemoteSB  = lookupService.lookupPathalogyBean();
        
        try{
            return pthRemoteSB.getAvailablePthTests();
        }catch(Exception ex){
        }
        return null;
    }
////////////////////////////////////////////////    
    public ArrayList getPthTestConResult(int testId,int testReqId) {
        
        LookupService lookupService = new LookupService ();
        coshms.ejb.pathalogy.PathalogyRemote  pthRemoteSB  = lookupService.lookupPathalogyBean();
        
        try{
            return pthRemoteSB.getPthTestConResult(testId,testReqId);
        }catch(Exception ex){
        }
        return null;
    }
////////////////////////////////////////////////    
    public ArrayList getPatientTestAudit(int ptId) {
        
        LookupService lookupService = new LookupService ();
        coshms.ejb.pathalogy.PathalogyRemote  pthRemoteSB  = lookupService.lookupPathalogyBean();
        
        try{
            return pthRemoteSB.getPthTestAuditInfo(ptId);
        }catch(Exception ex){
        System.out.print("sdfsdfasdf sdfsd  " + ex.getMessage());
        }
        return null;
    }

////////////////////////////////////////////////    
    public ArrayList getPthTestAudit(int ptId) {
        
        LookupService lookupService = new LookupService ();
        coshms.ejb.pathalogy.PathalogyRemote  pthRemoteSB  = lookupService.lookupPathalogyBean();
        try{
            return pthRemoteSB.getPthTestAudit(ptId);
        }catch(Exception ex){
        System.out.print("sdfsdfasdf sdfsd  " + ex.getMessage());
        }
        return null;
    }

/////////////////////////////////////////////    
    public String getPatientName(int ptId) {
        
        LookupService lookupService = new LookupService ();
        coshms.ejb.pathalogy.PathalogyRemote  pthRemoteSB  = lookupService.lookupPathalogyBean();
        
        try{
            return pthRemoteSB.getPatientName(ptId);
        }catch(Exception ex){
        }
        return null;
    }
    
    /////////////////////////////////////////////    
    public ArrayList getPthResultVerify() {
        
        LookupService lookupService = new LookupService ();
        coshms.ejb.pathalogy.PathalogyRemote  pthRemoteSB  = lookupService.lookupPathalogyBean();
        
        try{
            return pthRemoteSB.getPthResultVerifyInfo();
        }catch(Exception ex){
        }
        return null;
    }

//////////////////////////////////////////////    
    public ArrayList getPthAvailableTestCon(int sampleId) {
        
        LookupService lookupService = new LookupService ();
        coshms.ejb.pathalogy.PathalogyRemote  pthRemoteSB  = lookupService.lookupPathalogyBean();
        
        try{
            return pthRemoteSB.getPthResultInfo(sampleId);
        }catch(Exception ex){
        }
        return null;

    }


    //////////////////////////////////////////////    
    public String getPthTestNameforSam(int sampleId) {
        
        LookupService lookupService = new LookupService ();
        coshms.ejb.pathalogy.PathalogyRemote  pthRemoteSB  = lookupService.lookupPathalogyBean();
        
        try{
            return pthRemoteSB.getPthTNameForSam(sampleId);
        }catch(Exception ex){
        }
        return null;
    }

    //////////////////////////////////////////////    
    public int getPtIdfromSamId(int sampleId) {
        
        LookupService lookupService = new LookupService ();
        coshms.ejb.pathalogy.PathalogyRemote  pthRemoteSB  = lookupService.lookupPathalogyBean();
        
        try{
            return pthRemoteSB.getPtIdFromSamId(sampleId);
        }catch(Exception ex){
        }
        return 0;
    }
    
    public int getPtIdfromtReqId(int testReqId) {
        
        LookupService lookupService = new LookupService ();
        coshms.ejb.pathalogy.PathalogyRemote  pthRemoteSB  = lookupService.lookupPathalogyBean();
        
        try{
            return pthRemoteSB.getPtIdFromTReqId(testReqId);
        }catch(Exception ex){
        }
        return 0;
    }
    
//////////////////////////////////////////////    
    public ArrayList getPthTestAll() {
        
        LookupService lookupService = new LookupService ();
        coshms.ejb.pathalogy.PathalogyRemote  pthRemoteSB  = lookupService.lookupPathalogyBean();
        
        try{
            return pthRemoteSB.getPthTestAll();
        }catch(Exception ex){
        }
        return null;
    }

///////////////////////////////////////////////    
    public ArrayList getPthTestsDis(int ptId){
    
        LookupService lookupService = new LookupService ();
        coshms.ejb.pathalogy.PathalogyRemote  pthRemoteSB  = lookupService.lookupPathalogyBean();
        try{
           return pthRemoteSB.getPthTestDiscount(ptId);
        }catch(Exception ex){
        }
        return null;
    }
///////////////////////////////////////////////    
    public ArrayList getPthTestInfo(int testId){
    
        LookupService lookupService = new LookupService ();
        coshms.ejb.pathalogy.PathalogyRemote  pthRemoteSB  = lookupService.lookupPathalogyBean();
        try{
            return pthRemoteSB.getPthTestInfo(testId);
        }catch(Exception ex){
        }
        return null;
    }

//////////////////////////////////////////////////    
    public ArrayList getPthTestConInfo(int testId){
    
        LookupService lookupService = new LookupService ();
        coshms.ejb.pathalogy.PathalogyRemote  pthRemoteSB  = lookupService.lookupPathalogyBean();
        try{
            return pthRemoteSB.getPthTestConInfo(testId);
        }catch(Exception ex){
        }
        return null;
    }
/////////////////////////////////////////////////////    
    public ArrayList getPthTestReportInfo(int ptId){
    
        LookupService lookupService = new LookupService ();
        coshms.ejb.pathalogy.PathalogyRemote  pthRemoteSB  = lookupService.lookupPathalogyBean();
        try{
            return pthRemoteSB.getPthTestReportInfo(ptId);
        }catch(Exception ex){
        }
        return null;
    }
////////////////////////////////////////////////////////    
    public ArrayList getPthCriticalTestInfo(int ptId){
    
        LookupService lookupService = new LookupService ();
        coshms.ejb.pathalogy.PathalogyRemote  pthRemoteSB  = lookupService.lookupPathalogyBean();
        try{
            return pthRemoteSB.getPthCriticalTest(ptId);
        }catch(Exception ex){
        }
        return null;
    }
////////////////////////////////////////////////////////    
    public ArrayList getPthTestsSampleReject(int sampleId){
    
        LookupService lookupService = new LookupService ();
        coshms.ejb.pathalogy.PathalogyRemote  pthRemoteSB  = lookupService.lookupPathalogyBean();
        try{
            return pthRemoteSB.getPthTestSampleReject(sampleId);
        }catch(Exception ex){
        }        
        return null;
    }
    ////////////////////////////////////////////////////////    
    public ArrayList getPthTestsSample(int ptId){
    
        LookupService lookupService = new LookupService ();
        coshms.ejb.pathalogy.PathalogyRemote  pthRemoteSB  = lookupService.lookupPathalogyBean();
        try{
            return pthRemoteSB.getPthTestSample(ptId);
        }catch(Exception ex){
        }
        return null;
    }

//////////////////////////////////////////////////////    
    public ArrayList getPthTestsPayement(int ptId){
    
        LookupService lookupService = new LookupService ();
        coshms.ejb.pathalogy.PathalogyRemote  pthRemoteSB  = lookupService.lookupPathalogyBean();
        try{
            return pthRemoteSB.getPthTestPayment(ptId);
        }catch(Exception ex){
        }
        return null;
    }
////////////////////////////////////////////////////////    
    public String check()
    {
        LookupService lookupService = new LookupService ();
        coshms.ejb.pathalogy.PathalogyRemote  pthRemoteSB  = lookupService.lookupPathalogyBean();
        try{
             pthRemoteSB.getPthTestDiscount(1);
        }catch(Exception ex){
        return ex.getMessage();
        }
        return "ok";
    }
    
    
}
