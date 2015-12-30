
package coshms.ejb.domain;

import java.util.ArrayList;


/**
 * This is the business interface for Employee enterprise bean.
 */
public interface EmployeeRemoteBusiness {
    ArrayList getMedicineSet(Integer empId) throws java.rmi.RemoteException;

    ArrayList getDiseaseSet(Integer empId) throws java.rmi.RemoteException;

    void addToDiseaseSet(Integer empId, String[] diseaseList) throws java.rmi.RemoteException;

 
    
}
