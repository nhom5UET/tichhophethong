
package coshms.ejb.domain;

import java.rmi.RemoteException;
import javax.ejb.CreateException;
import javax.ejb.EJBHome;


/**
 * This is the home interface for Disease enterprise bean.
 */
public interface DiseaseRemoteHome extends EJBHome {
    
    DiseaseRemote create()  throws CreateException, RemoteException;
    
    
}
