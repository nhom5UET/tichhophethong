
package coshms.ejb.pathalogy;


/**
 * This is the business interface for Pathalogy enterprise bean.
 */
public interface PathalogyRemoteBusiness {
    boolean addPthTestRequest(int ptId, int encNo, int empId, java.util.ArrayList pthTestReqDetAL) throws java.rmi.RemoteException;

    java.util.ArrayList myTempProc() throws java.rmi.RemoteException;

    java.util.ArrayList getAvailablePthTests() throws java.rmi.RemoteException;

    java.util.ArrayList getPthTestDiscount(int ptId) throws java.rmi.RemoteException;

    boolean addPthTestDiscount(java.util.ArrayList pthTestDisList) throws java.rmi.RemoteException;

    java.util.ArrayList getPthTestPayment(int ptId) throws java.rmi.RemoteException;

    boolean addPthTestPayment(java.util.ArrayList pthTestAccList) throws java.rmi.RemoteException;

    boolean pthTestDomainAdd(java.util.ArrayList pthTestDomainList, String tName, int tStatus, int tCost, int empId) throws java.rmi.RemoteException;

    java.util.ArrayList getPthTestSample(int ptId) throws java.rmi.RemoteException;

    int pthTestSampleAdd(int testReqId, int testId, int empId) throws java.rmi.RemoteException;

    java.util.ArrayList getPthResultInfo(int sampleId) throws java.rmi.RemoteException;

    boolean PthTestResultAdd(int sampleId, int empId, java.util.ArrayList pthTestResList) throws java.rmi.RemoteException;

    java.util.ArrayList getPthTestSampleReject(int sampleId) throws java.rmi.RemoteException;

    boolean PthTestSamRejAdd(int sampleId, int empId, String description) throws java.rmi.RemoteException;

    java.util.ArrayList getPthTestReportInfo(int ptId) throws java.rmi.RemoteException;

    void getPthCriticalTestInfo() throws java.rmi.RemoteException;

    boolean pthCriticalTestSchAdd(int empId, coshms.util.pathalogy.PthCriTestSchInfo pthCriticalSch) throws java.rmi.RemoteException;

    java.lang.String getPatientName(int ptId) throws java.rmi.RemoteException;

    java.util.ArrayList getPthTestInfo(int testId) throws java.rmi.RemoteException;

    java.util.ArrayList getPthTestConInfo(int testId) throws java.rmi.RemoteException;

    boolean pthTestDomainEdit(java.util.ArrayList pthTestConList, String tName, int status, int cost, int empId, int testId) throws java.rmi.RemoteException;

    java.util.ArrayList getPthTestAll() throws java.rmi.RemoteException;

    java.util.ArrayList getPthResultVerifyInfo() throws java.rmi.RemoteException;

    java.util.ArrayList getPthTestConResult(int testId, int testReqId) throws java.rmi.RemoteException;

    boolean pthResultVerifyAdd(int testId, int testReqId, String overAllNotes, int empId) throws java.rmi.RemoteException;

    java.lang.String getTestName(int testId) throws java.rmi.RemoteException;

    java.lang.String getEmployeeName(int empId) throws java.rmi.RemoteException;

    java.lang.String getPthTestOverAllNotes(int testId, int testReqId) throws java.rmi.RemoteException;

    boolean getPthTestIsUrgentBasis(int testId, int testReqId) throws java.rmi.RemoteException;

    coshms.util.pathalogy.PthTestPlanInfo getPthTestPlan() throws java.rmi.RemoteException;

    java.util.ArrayList getPthTestAuditInfo(int ptId) throws java.rmi.RemoteException;

    java.util.ArrayList getPthTestAudit(int ptId) throws java.rmi.RemoteException;

    java.util.ArrayList getPthTestAudit(int testId, int testReqId) throws java.rmi.RemoteException;

    java.util.ArrayList getPthCriticalTest(int ptId) throws java.rmi.RemoteException;

    String getPthTNameForSam(int sid) throws java.rmi.RemoteException;

    int getPtIdFromSamId(int sampleId) throws java.rmi.RemoteException;

    int getPtIdFromTReqId(int testReqId) throws java.rmi.RemoteException;
    
}
