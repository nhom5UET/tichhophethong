
package coshms.ejb.domain;

import java.util.ArrayList;


/**
 * This is the business interface for Ward enterprise bean.
 */
public interface WardRemoteBusiness {
    ArrayList getAllWards() throws java.rmi.RemoteException;
    
}
