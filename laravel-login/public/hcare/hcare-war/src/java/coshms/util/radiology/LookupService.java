/*
 * LookupService.java
 *
 * Created on June 15, 2006, 1:32 PM
 *
 * To change this template, choose Tools | Template Manager
 * and open the template in the editor.
 */

package coshms.util.radiology;
/**
 *
 * @author Administrator
 */
public class LookupService {
    
    /** Creates a new instance of LookupService */
    public LookupService() {
    }
    
    public coshms.ejb.radiology.RadiologyRemote lookupRadiologyBean() {
        try {
            javax.naming.Context c = new javax.naming.InitialContext();
            Object remote = c.lookup("java:comp/env/ejb/RadiologyBean");
            coshms.ejb.radiology.RadiologyRemoteHome rv = (coshms.ejb.radiology.RadiologyRemoteHome) javax.rmi.PortableRemoteObject.narrow(remote, coshms.ejb.radiology.RadiologyRemoteHome.class);
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