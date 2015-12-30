
package coshms.ejb.domain;

import java.rmi.RemoteException;
import javax.ejb.CreateException;
import javax.ejb.EJBHome;


/**
 * This is the home interface for Employee enterprise bean.
 */
public interface EmployeeRemoteHome extends EJBHome {
    
    EmployeeRemote create()  throws CreateException, RemoteException;
    
    
}
