package coshms.ejb.domain;

import coshms.util.DBAccess;
import coshms.util.domain.Mapping;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import javax.ejb.*;

/**
 * This is the bean class for the DiseaseBean enterprise bean.
 * Created Jun 11, 2006 10:21:13 AM
 * @author Asif
 */
public class DiseaseBean implements SessionBean, DiseaseRemoteBusiness {
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
    
    /**
     * See section 7.10.3 of the EJB 2.0 specification
     * See section 7.11.3 of the EJB 2.1 specification
     */
    public void ejbCreate() {
        // TODO implement ejbCreate if necessary, acquire resources
        // This method has access to the JNDI context so resource aquisition
        // spanning all methods can be performed here such as home interfaces
        // and data sources.
    }
    public ArrayList getDiseaseLike(String diseaseSubString){
        ArrayList list = null;
        DBAccess db = new DBAccess();
        db.prepareCallString("{call dmn_getDiseaseLike(?)}");
        try{
            db.proc.setString(1,diseaseSubString);
            db.proc.execute();
            rs = db.proc.getResultSet();
            Mapping map= null;
            list= new ArrayList();
            while(rs.next()){
                map = new Mapping();
                map.setKey(rs.getString(1));
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
    
    public ArrayList getAllDiseases(){
        ArrayList list = null;
        DBAccess db = new DBAccess();
        db.prepareCallString("{call dmn_getAllDiseases()}");
        try{
            db.proc.execute();
            rs = db.proc.getResultSet();
            Mapping map= null;
            list= new ArrayList();
            while(rs.next()){
                map = new Mapping();
                map.setKey(rs.getString(1));
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
    
    
    // Add business logic below. (Right-click in editor and choose
    // "EJB Methods > Add Business Method" or "Web Service > Add Operation")
    
    
    
}
