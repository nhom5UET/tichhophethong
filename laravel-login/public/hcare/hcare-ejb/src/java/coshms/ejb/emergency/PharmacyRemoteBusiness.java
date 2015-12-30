
package coshms.ejb.emergency;

import java.sql.Date;
import java.util.ArrayList;


/**
 * This is the business interface for Pharmacy enterprise bean.
 */
public interface PharmacyRemoteBusiness
{
    ArrayList   getPatientRegInfo   (int pid) throws java.rmi.RemoteException;
    
    ArrayList   getTprbRecord       (int pid) throws java.rmi.RemoteException;
   
    ArrayList   getMedicineRecord   (int pid , int emgEncNo , int treatmentNo) throws java.rmi.RemoteException;
    
    boolean     setMedicineTransac (int pid, int emgEncNo, String mCode, int issueQty , int actQty , int empId , char shift , int treatmentNo , int workForBalance) throws java.rmi.RemoteException;

    ArrayList   getMedicineInStock  (char shift) throws java.rmi.RemoteException;

    void        setPhramacyTransac  (int empId, char shift, String mCode, int updQty) throws java.rmi.RemoteException;

    ArrayList   getAllTreatmentOnMaxEnc (int pid) throws java.rmi.RemoteException;

    ArrayList   getBalanceMedicine  (int pid, int emgEncNo, int trtmntNo) throws java.rmi.RemoteException;

    //void        setBalncMedicineTransac (int pid, int emgEncNo, String mCode, int issueQty, int actBlncQty, int empId, char shift, int trtmntNo) throws java.rmi.RemoteException;

    int authenticatUser (String userName, String password) throws java.rmi.RemoteException;

    int authorizedUser (int userId, String interfaceName) throws java.rmi.RemoteException;

    java.util.ArrayList getCurrentStockByShift(String shift) throws java.rmi.RemoteException;

    java.util.ArrayList getStockInflow(Date fromThisDate, Date toThisDate, String shift) throws java.rmi.RemoteException;

    java.util.ArrayList getStockOutflow(Date fromThisDate, Date toThisDate, String shift) throws java.rmi.RemoteException;

    java.util.ArrayList getStockConsumption(Date fromThisDate, Date toThisDate) throws java.rmi.RemoteException;
}
