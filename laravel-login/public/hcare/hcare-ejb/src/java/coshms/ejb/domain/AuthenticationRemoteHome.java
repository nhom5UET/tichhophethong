
package coshms.ejb.domain;

import java.rmi.RemoteException;
import javax.ejb.CreateException;
import javax.ejb.EJBHome;


/**
 * This is the home interface for Authentication enterprise bean.
 */
public interface AuthenticationRemoteHome extends EJBHome {
    
    AuthenticationRemote create()  throws CreateException, RemoteException;
    
    
}
