
package coshms.ejb.domain;

import coshms.util.PatientNotFoundException;
import coshms.util.domain.Patient;
import java.util.ArrayList;

/**
 * This is the business interface for RegisterPatient enterprise bean.
 */
public interface RegisterPatientRemoteBusiness {
    String getString() throws java.rmi.RemoteException;
    Integer registerPatient(Patient pt) throws java.rmi.RemoteException;
    Patient getPatient(Integer pid) throws java.rmi.RemoteException ;
    void editPtInfo(Patient pt) throws java.rmi.RemoteException;
    
    ArrayList searchPatient(Patient pt) throws java.rmi.RemoteException;
}
