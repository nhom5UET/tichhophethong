
package coshms.ejb.emergency;

import java.rmi.RemoteException;
import javax.ejb.CreateException;
import javax.ejb.EJBHome;


/**
 * This is the home interface for Pharmacy enterprise bean.
 */
public interface PharmacyRemoteHome extends EJBHome
{
    
    PharmacyRemote create ()  throws CreateException, RemoteException;
    
    
}
