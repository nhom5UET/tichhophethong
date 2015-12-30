
package coshms.ejb.domain;

import java.rmi.RemoteException;
import javax.ejb.CreateException;
import javax.ejb.EJBHome;


/**
 * This is the home interface for RegisterPatient enterprise bean.
 */
public interface RegisterPatientRemoteHome extends EJBHome {
    
    RegisterPatientRemote create()  throws CreateException, RemoteException;
    
    
}
