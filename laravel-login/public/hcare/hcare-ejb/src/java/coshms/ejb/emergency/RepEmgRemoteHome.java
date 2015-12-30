
package coshms.ejb.emergency;

import java.rmi.RemoteException;
import javax.ejb.CreateException;
import javax.ejb.EJBHome;


/**
 * This is the home interface for RepEmg enterprise bean.
 */
public interface RepEmgRemoteHome extends EJBHome {
    
    RepEmgRemote create()  throws CreateException, RemoteException;
    
    
}
