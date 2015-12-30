package coshms.ejb.domain;

import coshms.util.DBAccess;
import coshms.util.domain.Mapping;
import coshms.util.emergency.Medicine;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Types;
import java.util.ArrayList;
import javax.ejb.*;

/**
 * This is the bean class for the EmployeeBean enterprise bean.
 * Created Jun 8, 2006 9:11:44 AM
 * @author Asif
 */
public class EmployeeBean implements SessionBean, EmployeeRemoteBusiness {
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
    
    public ArrayList getMedicineSet(Integer empId) {
        ArrayList list = null;
        DBAccess db = new DBAccess();
        db.prepareCallString("{call dmn_getEmpMedicine(?)}");
        try{
            db.proc.setObject(1,empId);            
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
    
    public ArrayList getDiseaseSet(Integer empId) {
        ArrayList list = null;        
        DBAccess db = new DBAccess();        
        db.prepareCallString("{call dmn_getEmpDisease(?)}");
        try{
            db.proc.setObject(1,empId);            
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
    
    public void addToDiseaseSet(Integer empId, String[] diseaseArr) {
        DBAccess db=new DBAccess();
        db.prepareCallString("{call dmn_setEmpDisease(?,?)}");

            for(int i=0; i<diseaseArr.length; i++){
                try{
                    db.proc.setObject(1,empId);
                    db.proc.setString(2,diseaseArr[i]);
                    db.proc.execute();
                }catch(SQLException e){
                    System.out.println(e.getMessage() + "\n" + e.getErrorCode());
                    //            e.printStackTrace();
                }
            }        
        db.closeStmtCon();
    }
}