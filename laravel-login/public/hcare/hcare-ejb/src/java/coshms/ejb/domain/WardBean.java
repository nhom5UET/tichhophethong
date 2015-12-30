package coshms.ejb.domain;

import coshms.util.DBAccess;
import coshms.util.domain.Mapping;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import javax.ejb.*;

/**
 * This is the bean class for the WardBean enterprise bean.
 * Created Jun 8, 2006 11:35:11 AM
 * @author Asif
 */

public class WardBean implements SessionBean, WardRemoteBusiness {
    private SessionContext context;
    private ResultSet rs;
    
    // <editor-fold defaultstate="collapsed" desc="EJB infrastructure methods. Click the + sign on the left to edit the code.">
    // TODO Add code to acquire and use other enterprise resources (DataSource, JMS, enterprise bean, Web services)
    // TODO Add business methods or web service operations
    /**
     * @see javax.ejb.SessionBean#setSessionContext(javax.ejb.SessionContext)
     */
    public void setSessionContext(SessionContext aContext) {
        context = aContext;
    }
    
    /**
     * @see javax.ejb.SessionBean#ejbActivate()
     */
    public void ejbActivate() {
        
    }
    
    /**
     * @see javax.ejb.SessionBean#ejbPassivate()
     */
    public void ejbPassivate() {
        
    }
    
    /**
     * @see javax.ejb.SessionBean#ejbRemove()
     */
    public void ejbRemove() {
        
    }
    // </editor-fold>
   
   public void ejbCreate() {
   }
   
   public ArrayList getAllWards() {       
        ArrayList list = null;
        Mapping map= null;
        DBAccess db = new DBAccess();
        db.prepareCallString("{call dmn_getAllWards()}");
        try{
            db.proc.execute();
            rs = db.proc.getResultSet();
            list= new ArrayList();
            while(rs.next()){
                map = new Mapping();
                map.setKey(((Integer)rs.getObject(1)).toString());  //Object->Integer->String
                map.setValue(rs.getString(2));
                list.add(map);
            }
            rs.close();
            db.closeStmtCon();
        }catch(SQLException sqlEx){
            sqlEx.printStackTrace();
        }
        return list;
    }
}