
package coshms.ejb.domain;

import java.rmi.RemoteException;
import javax.ejb.CreateException;
import javax.ejb.EJBHome;


/**
 * This is the home interface for Ward enterprise bean.
 */
public interface WardRemoteHome extends EJBHome {
    
    WardRemote create()  throws CreateException, RemoteException;
    
    
}
