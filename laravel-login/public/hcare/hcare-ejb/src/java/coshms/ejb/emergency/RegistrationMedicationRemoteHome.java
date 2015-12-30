
package coshms.ejb.emergency;

import java.rmi.RemoteException;
import javax.ejb.CreateException;
import javax.ejb.EJBHome;


/**
 * This is the home interface for RegistrationMedication enterprise bean.
 */
public interface RegistrationMedicationRemoteHome extends EJBHome {
    
    RegistrationMedicationRemote create()  throws CreateException, RemoteException;
    
    
}
