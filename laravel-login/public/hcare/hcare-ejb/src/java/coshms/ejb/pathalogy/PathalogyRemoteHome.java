
package coshms.ejb.pathalogy;

import java.rmi.RemoteException;
import javax.ejb.CreateException;
import javax.ejb.EJBHome;


/**
 * This is the home interface for Pathalogy enterprise bean.
 */
public interface PathalogyRemoteHome extends EJBHome {
    
    PathalogyRemote create()  throws CreateException, RemoteException;
    
    
}
