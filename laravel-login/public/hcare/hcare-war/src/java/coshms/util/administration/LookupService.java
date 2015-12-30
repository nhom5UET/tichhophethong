/*
 * LookupService.java
 *
 * Created on May 6, 2006, 3:28 PM
 *
 * To change this template, choose Tools | Template Manager
 * and open the template in the editor.
 */

package coshms.util.administration;

/**
 *
 * @author Tahir
 */
public class LookupService
{
    
    /** Creates a new instance of LookupService */
    public LookupService ()
    {
    }

    public coshms.ejb.domain.AuthenticationRemote lookupAuthenticationBean() {
        try {
            javax.naming.Context c = new javax.naming.InitialContext();
            Object remote = c.lookup("java:comp/env/ejb/AuthenticationBean");
            coshms.ejb.domain.AuthenticationRemoteHome rv = (coshms.ejb.domain.AuthenticationRemoteHome) javax.rmi.PortableRemoteObject.narrow(remote, coshms.ejb.domain.AuthenticationRemoteHome.class);
            return rv.create();
        }
        catch(javax.naming.NamingException ne) {
            java.util.logging.Logger.getLogger(getClass().getName()).log(java.util.logging.Level.SEVERE,"exception caught" ,ne);
            throw new RuntimeException(ne);
        }
        catch(javax.ejb.CreateException ce) {
            java.util.logging.Logger.getLogger(getClass().getName()).log(java.util.logging.Level.SEVERE,"exception caught" ,ce);
            throw new RuntimeException(ce);
        }
        catch(java.rmi.RemoteException re) {
            java.util.logging.Logger.getLogger(getClass().getName()).log(java.util.logging.Level.SEVERE,"exception caught" ,re);
            throw new RuntimeException(re);
        }
    }

    
 
    

    
    
}
