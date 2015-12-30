
package coshms.ejb.radiology;

import java.rmi.RemoteException;
import javax.ejb.CreateException;
import javax.ejb.EJBHome;


/**
 * This is the home interface for Radiology enterprise bean.
 */
public interface RadiologyRemoteHome extends EJBHome {
    
    RadiologyRemote create()  throws CreateException, RemoteException;
    
    
}
