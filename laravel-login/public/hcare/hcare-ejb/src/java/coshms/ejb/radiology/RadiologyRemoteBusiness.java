
package coshms.ejb.radiology;


/**
 * This is the business interface for Radiology enterprise bean.
 */
public interface RadiologyRemoteBusiness {
    java.util.ArrayList getRadTestAll() throws java.rmi.RemoteException;

    boolean addRadTestRequest(int ptId, int encNo, int empId, java.util.ArrayList radTestReqDet) throws java.rmi.RemoteException;

    java.util.ArrayList getRadTestDiscount(int ptId) throws java.rmi.RemoteException;

    java.lang.String getPatientName(int ptId) throws java.rmi.RemoteException;

    boolean addRadTestDiscount(java.util.ArrayList radTestDis) throws java.rmi.RemoteException;

    java.util.ArrayList getRadTestFee(int ptId) throws java.rmi.RemoteException;

    boolean addRadTestFee(java.util.ArrayList pthTestAccList) throws java.rmi.RemoteException;

    boolean radTestDomainAdd(String tName, int tStatus, int tCost, int empId) throws java.rmi.RemoteException;

    java.util.ArrayList getRadTestInfo(int testId) throws java.rmi.RemoteException;

    java.util.ArrayList getRadAvailableTests() throws java.rmi.RemoteException;

    boolean radTestDomainEdit(String tName, int status, int cost, int empId, int testId) throws java.rmi.RemoteException;

    boolean radTestResultAdd(int testId, int testReqId, int empId, String notes, java.util.ArrayList imageList) throws java.rmi.RemoteException;

    java.util.ArrayList getRadTestResultInfo(int ptId) throws java.rmi.RemoteException;

    java.util.ArrayList getRadTestReportInfo(int ptId) throws java.rmi.RemoteException;

    java.util.ArrayList getRadTestReport(int testId, int testReqId) throws java.rmi.RemoteException;

    java.io.InputStream getRadImage(int testId, int testReqId) throws java.rmi.RemoteException;

    java.lang.String getEmployeeName(int empId) throws java.rmi.RemoteException;

    int getPatientAge(int ptId) throws java.rmi.RemoteException;

    java.util.ArrayList getRadTestAudit(int ptId) throws java.rmi.RemoteException;

    java.util.ArrayList getRadTestAudit(int testId, int testReqId) throws java.rmi.RemoteException;

    coshms.util.radiology.RadTestPlanInfo getRadTestPlan() throws java.rmi.RemoteException;
    
}
