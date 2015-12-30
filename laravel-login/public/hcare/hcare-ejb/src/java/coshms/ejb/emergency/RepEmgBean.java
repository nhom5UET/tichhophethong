package coshms.ejb.emergency;

import coshms.util.DBAccess;
import coshms.util.domain.MapInt;
import coshms.util.domain.Mapping;
import coshms.util.emergency.EncounterDetail;
import coshms.util.emergency.reports.DiseaseDiag;
import coshms.util.emergency.reports.EncPatients;
import coshms.util.emergency.reports.RegPatients;
import java.sql.Date;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import javax.ejb.*;

/**
 * This is the bean class for the RepEmgBean enterprise bean.
 * Created Jul 19, 2006 12:57:47 AM
 * @author Asif
 */
public class RepEmgBean implements SessionBean, RepEmgRemoteBusiness {
    private SessionContext context;
    private ResultSet rs;
    private DBAccess db;
    
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
    
    public RegPatients RegPatientBw(Date fromDate, Date toDate){
        RegPatients regPts= null;
        EncounterDetail encD=null;
        DBAccess db=new DBAccess();
        db.prepareCallString("{call emg_repRegPatientsBw(?,?)}"); // fromDate, toDate
        try{
            db.proc.setDate(1,fromDate);
            db.proc.setDate(2,toDate);
            db.proc.execute();
            rs = db.proc.getResultSet();
            regPts = new RegPatients();
            while(rs.next()){
                // regPts.setTotal(rs.getInt("total"));
                regPts.setMales(rs.getInt("males"));
                regPts.setFemales(rs.getInt("females"));
            }
            rs.close();
            db.closeStmtCon();
            rs = null;
            db=null;
        }catch(SQLException e){
            System.out.println(e.getMessage() + "\n" + e.getErrorCode());
            e.printStackTrace();
        }
        return regPts;
    }
    
    public EncPatients PatientsEncBw(Date fromDate, Date toDate){
        EncPatients encPts= null;
        DBAccess db=new DBAccess();
        db.prepareCallString("{call emg_repPatientsEncBw(?,?)}"); // fromDate, toDate
        try{
            db.proc.setDate(1,fromDate);
            db.proc.setDate(2,toDate);
            db.proc.execute();
            rs = db.proc.getResultSet();
            encPts = new EncPatients();
            while(rs.next()){
                //    encPts.setTotal(rs.getInt("total"));
                encPts.setMales(rs.getInt("males"));
                encPts.setFemales(rs.getInt("females"));
            }
            rs.close();
            db.closeStmtCon();
            rs = null;
            db=null;
        }catch(SQLException e){
            System.out.println(e.getMessage() + "\n" + e.getErrorCode());
            e.printStackTrace();
        }
        return encPts;
    }
    
    public ArrayList mlcCasesBw(Date fromDate, Date toDate) {
        ArrayList mlcList=new ArrayList();
        Mapping map = null;
        DBAccess db=new DBAccess();
        db.prepareCallString("{CALL emg_repMlcCasesBw(?,?)}"); // fromDate, toDate
        try{
            db.proc.setDate(1,fromDate);
            db.proc.setDate(2,toDate);
            db.proc.execute();
            rs = db.proc.getResultSet();
            while(rs.next()){
                map = new Mapping();
                map.setKey(rs.getString("mlcName"));
                map.setValue(rs.getString("tCount"));
                mlcList.add(map);
            }
            rs.close();
            db.closeStmtCon();
            rs = null;
            db=null;
        }catch(SQLException e){
            System.out.println(e.getMessage() + "\n" + e.getErrorCode());
            e.printStackTrace();
        }
        return mlcList;
    }
    
    public ArrayList regFromEachCityBw(Date fromDate, Date toDate) {
        ArrayList cityList=new ArrayList();
        MapInt map = null;
        db=new DBAccess();
        db.prepareCallString("{CALL emg_repRegFromEachCityBw(?,?)}"); // fromDate, toDate
        try{
            db.proc.setDate(1,fromDate);
            db.proc.setDate(2,toDate);
            db.proc.execute();
            rs = db.proc.getResultSet();
            while(rs.next()){
                map = new MapInt();
                map.setKey(rs.getString("city"));
                map.setValue(rs.getInt("tCount"));
                cityList.add(map);
            }
            rs.close();
            db.closeStmtCon();
            rs = null;
            db=null;
        }catch(SQLException e){
            System.out.println(e.getMessage() + "\n" + e.getErrorCode());
            e.printStackTrace();
        }
        return cityList;
    }
    
    public ArrayList diseasesDiagBw(Date fromDate, Date toDate){
        ArrayList ddList = new ArrayList();
        DiseaseDiag dd = null; //Disease Diagnosis
        db=new DBAccess();
        db.prepareCallString("{CALL emg_repDiseaseDiagBw(?,?)}"); // fromDate, toDate
        try{
            db.proc.setDate(1,fromDate);
            db.proc.setDate(2,toDate);
            db.proc.execute();
            rs = db.proc.getResultSet();
            while(rs.next()){
                dd = new DiseaseDiag();
                dd.setDCode(rs.getString("dCode"));
                dd.setName(rs.getString("name"));
                dd.setCount(rs.getInt("total"));
                ddList.add(dd);
            }
            rs.close();
            db.closeStmtCon();
            rs = null;
            db=null;
        }catch(SQLException e){
            System.out.println(e.getMessage() + "\n" + e.getErrorCode());
            e.printStackTrace();
        }
        return ddList;
    }
    public ArrayList diseasesDiagBw(String[] diseaseAry,Date fromDate, Date toDate){
        ArrayList ddList = new ArrayList();
        DiseaseDiag dd = null; //Disease Diagnosis
        db=new DBAccess();
        db.prepareCallString("{CALL emg_repGivenDiseaseDiagBw(?,?,?)}"); //diseaseCode, fromDate, toDate
        try{
            for(int i=0; i<diseaseAry.length; i++){
                db.proc.setString(1,diseaseAry[i]);
                db.proc.setDate(2,fromDate);
                db.proc.setDate(3,toDate);
                db.proc.execute();
                rs = db.proc.getResultSet();
                while(rs.next()){
                    dd = new DiseaseDiag();
                    dd.setDCode(diseaseAry[i]);
                    dd.setName(rs.getString("name"));
                    dd.setCount(rs.getInt("total"));
                    ddList.add(dd);
                }
            }
            rs.close();
            db.closeStmtCon();
            rs = null;
            db=null;
        }catch(SQLException e){
            System.out.println(e.getMessage() + "\n" + e.getErrorCode());
            e.printStackTrace();    
        }
        return ddList;
    }
}