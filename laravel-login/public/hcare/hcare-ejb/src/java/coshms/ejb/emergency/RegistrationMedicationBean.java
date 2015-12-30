package coshms.ejb.emergency;

import coshms.domain.exception.TreatmentNotFoundException;
import coshms.util.DBAccess;
import coshms.util.domain.Mapping;
import coshms.util.emergency.EmgEnc;
import coshms.util.emergency.EncHeading;
import coshms.util.emergency.EncounterDetail;
import coshms.util.emergency.Medicine;
import coshms.util.emergency.Patient;
import coshms.util.emergency.TPRBRecord;
import coshms.util.emergency.Treatment;
import coshms.util.emergency.TreatmentHeading;
import java.io.IOException;
import java.io.InputStream;
import java.sql.Blob;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Types;
import java.util.ArrayList;
import java.util.Iterator;
import javax.ejb.*;

/**
 * This is the bean class for the RegistrationMedicationBean enterprise bean.
 * Created May 10, 2006 1:03:10 PM
 * @author project
 */

public class RegistrationMedicationBean implements SessionBean, RegistrationMedicationRemoteBusiness {
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
    
    public ArrayList getAllMLC() {
        DBAccess db = new DBAccess();
        ArrayList list = null;
        db.prepareCallString("{call dmn_allMLC()}");
        try{
            db.proc.execute();
            rs = db.proc.getResultSet();
            list= new ArrayList();
            Mapping map= new Mapping();
            while(rs.next()){
                map = new Mapping();
                map.setKey( ((Integer)rs.getObject(1)).toString() );
                map.setValue(rs.getString(2));
                list.add(map);
            }
            rs.close();
            db.closeStmtCon();
        }catch(SQLException sqlEx){sqlEx.printStackTrace();}
        return list;
    }
    
    public void emgEncounter(EmgEnc enc) {
        DBAccess db=null;
        if(enc.getIsRefered().booleanValue()){ // IF PATIENT IS REFERED
            db=new DBAccess();
            db.prepareCallString("{call emg_encWRef(?,?,?,?,?,?,?,?,? )}");
            // emg_encWRef(pid, mlcId, broughtBy, isRefered, phNo, empId, refName, refNotes, refPhNo) : 9
            try{
                db.proc.setObject(1,enc.getPid());
                //  if(enc.getMlc().intValue() == 0){db.proc.setObject(2,null);} else{
                db.proc.setObject(2,enc.getMlc());//}
                
                db.proc.setString(3,enc.getBroughtBy());
                db.proc.setBoolean(4,true); // true shows: patient is refered
                db.proc.setString(5,enc.getPhNo());
                db.proc.setObject(6,enc.getEmpId());
                db.proc.setString(7,enc.getRefName());
                db.proc.setString(8,enc.getRefNotes());
                db.proc.setString(9,enc.getRefPhNo());
                db.proc.execute();
                db.closeStmtCon();
            }catch(SQLException sqlEx){sqlEx.printStackTrace();}
        }else{ // IF PATIENT IS NOT REFERED
            db=new DBAccess();
            db.prepareCallString("{call emg_enc(?,?,?,?,?,? )}");
            // emg_enc(pid, mlcId, broughtBy, isRefered, phNo, empId) : 6
            try{
                db.proc.setObject(1,enc.getPid());
                //    if(enc.getMlc().intValue() == 0){ db.proc.setObject(2,null);} else{
                db.proc.setObject(2,enc.getMlc()); //}
                
                db.proc.setString(3,enc.getBroughtBy());
                db.proc.setBoolean(4,false);
                db.proc.setString(5,enc.getPhNo());
                db.proc.setObject(6,enc.getEmpId());
                
                db.proc.execute();
                db.closeStmtCon();
            }catch(SQLException sqlEx){sqlEx.printStackTrace();}
        }
    }
    
    public Integer emgEncounterFileId(EmgEnc enc) {
        // if patient is refered and fildId is required to be generated
        DBAccess db=null;
        Integer fileId=null;
        db=new DBAccess();
        db.prepareCallString("{call emg_encWRefFId(?,?,?,?,?,?,?,?,?,?)}");
        // emg_enc(pid, mlcId, broughtBy, isRefered, phNo, empId, refName, refNotes, refPhNo, fileId_Out) : 10
        try{
            db.proc.setObject(1,enc.getPid());
//            if(enc.getMlc().intValue() == 0){db.proc.setObject(2,null);} else{
            db.proc.setObject(2,enc.getMlc()); //}
            
            db.proc.setString(3,enc.getBroughtBy());
            db.proc.setBoolean(4,true); // true shows: patient is refered
            db.proc.setString(5,enc.getPhNo());
            db.proc.setObject(6,enc.getEmpId());
            db.proc.setString(7,enc.getRefName());
            db.proc.setString(8,enc.getRefNotes());
            db.proc.setString(9,enc.getRefPhNo());
            db.proc.registerOutParameter(10,Types.INTEGER);
            db.proc.execute();
            fileId = (Integer)db.proc.getObject(10);
            db.closeStmtCon();
        }catch(SQLException sqlEx){sqlEx.printStackTrace();}
        return fileId;
    }
    
    public Patient getPtForTPRB(Integer pid) { //get Patient info for TPRB input interface
        //Its gets patient and ecnounter info where encounter number is maximum
        ResultSet rs=null;
        Patient ptTP=null;
        DBAccess db=null;
        db = new DBAccess();
        db.prepareCallString("{call emg_getPtForTPRB(?)}");
        try{
            db.proc.setObject(1,pid);
            db.proc.execute();
            rs = db.proc.getResultSet();
            int size = 0;
            
            while(rs.next()){
                ptTP = new Patient();
                ptTP.setPid(pid);
                ptTP.setName(rs.getString(1)+" " + rs.getString(2));
                ptTP.setFatherName(rs.getString(3));
                ptTP.setGender(rs.getString(4));
                ptTP.setDob(rs.getDate(5));
                ptTP.setAddress(rs.getString(6)+", " + rs.getString(7)+", "+ rs.getString(8));
                ////////////////////////
                
                Blob blob = rs.getBlob(9);     //10 is Picture
                  if(blob==null){                    
                    ptTP.setPicExist(false);
                    System.out.println( "RegisterPatient Bean: SET PIC = FALSE" );
                }else{
                    size = Integer.parseInt(Long.valueOf(blob.length()).toString());
                    ptTP.setPicSize(size);
                    byte by1[] = new byte[size];
                    InputStream in = blob.getBinaryStream();
                    in.read( by1, 0, size );
                    ptTP.setPicByte(by1);
                    ptTP.setPicExist(true);
                }
                ///////////////////////
                ptTP.setCnic(rs.getString(10));
                ptTP.setEncNo((Integer)rs.getObject(11)); //encNO
                ptTP.setEncDateTime(rs.getTimestamp(12));
                ptTP.setMlc(rs.getString(13));
            }
            rs.close();
            db.closeStmtCon();
            rs = null;
            db=null;
        }catch(SQLException e){
            System.out.println(e.getMessage() + "\n" + e.getErrorCode());
            e.printStackTrace();
        }catch(IOException ioExp){
            ioExp.printStackTrace();
        }
        return ptTP;
    }
    
    public void setTPRB(coshms.util.emergency.TPRBRecord tprb){
        DBAccess db=new DBAccess();
        db.prepareCallString("{call emg_setTPRB(?,?,?,?,?,?,?,?)}");
        try{
            db.proc.setObject(1,tprb.getPid());
            db.proc.setObject(2,tprb.getEmgEncNo());
            db.proc.setObject(3,tprb.getMinBp());
            db.proc.setObject(4,tprb.getMaxBp());
//            db.proc.setString(3,tprb.getBp());
            db.proc.setObject(5,tprb.getPulse());
            db.proc.setObject(6,tprb.getTemp());
            db.proc.setObject(7,tprb.getRRate());
            db.proc.setObject(8,tprb.getEmpId());
            db.proc.execute();
            db.closeStmtCon();
        }catch(SQLException e){
            System.out.println(e.getMessage() + "\n" + e.getErrorCode());
            e.printStackTrace();
        }
    }
    
    public TPRBRecord getLatestTPRB(Integer pid, Integer emgEncNo) {
        ResultSet rs=null;
        DBAccess db=null;
        TPRBRecord tprb=null;
        db = new DBAccess();
        db.prepareCallString("{call emg_getLatestTPRB(?,?)}");
        
        try{
            db.proc.setObject(1,pid);
            db.proc.setObject(2,emgEncNo);
            db.proc.execute();
            rs = db.proc.getResultSet();
            
            while(rs.next()){
                tprb = new TPRBRecord();
                tprb.setDTime(rs.getTimestamp(1));
                tprb.setMinBp((Integer)rs.getObject(2));
                tprb.setMaxBp((Integer)rs.getObject(3));
                tprb.setPulse((Integer)rs.getObject(4));
                tprb.setTemp((Integer)rs.getObject(5));
                tprb.setRRate((Integer)rs.getObject(6));
            }
            rs.close();
            db.closeStmtCon();
            rs = null;
            db=null;
        }catch(SQLException e){
            System.out.println(e.getMessage() + "\n" + e.getErrorCode());
            e.printStackTrace();
        }
        return tprb;
    }
    
    public ArrayList getAllTPRB(Integer pid, Integer emgEncNo) {
        ResultSet rs=null;
        DBAccess db=null;
        ArrayList list=null;
        TPRBRecord tprb=null;
        
        db = new DBAccess();
        db.prepareCallString("{call emg_getAllTPRB(?,?)}");
        try{
            db.proc.setObject(1,pid);
            db.proc.setObject(2,emgEncNo);
            db.proc.execute();
            rs = db.proc.getResultSet();
            list  = new ArrayList();
            while(rs.next()){
                tprb = new TPRBRecord();
                tprb.setDTime(rs.getTimestamp(1));
                tprb.setMinBp((Integer)rs.getObject(2));
                tprb.setMaxBp((Integer)rs.getObject(3));
                tprb.setPulse((Integer)rs.getObject(4));
                tprb.setTemp((Integer)rs.getObject(5));
                tprb.setRRate((Integer)rs.getObject(6));
                list.add(tprb);
            }
            rs.close();
            db.closeStmtCon();
            rs = null;
            db=null;
        }catch(SQLException e){
            System.out.println(e.getMessage() + "\n" + e.getErrorCode());
            e.printStackTrace();
        }
        return list;
    }
    
    public Integer performTreatment(Treatment treatment){
        Integer treatmentNo=null;
        Medicine medicine=null;
        DBAccess db=new DBAccess();
        db.startTransaction(); //////////////// start trasnaction
        db.prepareCallString("{call emg_setTreatment(?,?,?,?,?,?)}");
        try{
            // Treatment Record Insertion
            db.proc.setObject(1,treatment.getPid());
            db.proc.setObject(2,treatment.getEmgEncNo());
            db.proc.setString(3,treatment.getPComplaints());
            db.proc.setObject(4,treatment.getWardNo());
            db.proc.setObject(5,treatment.getEmpId());
            db.proc.registerOutParameter(6,Types.INTEGER);
            db.proc.execute();
            treatmentNo = (Integer)db.proc.getObject(6);
//            db.closeStmt();
            
            //start of dieases insertion in DB
            String[] dArr = treatment.getDCodeArr();
            db.prepareCallString("{call emg_setDisease(?,?,?,?)}");
            for(int i=0; i<dArr.length; i++){
                db.proc.setObject(1,treatment.getPid());
                db.proc.setObject(2,treatment.getEmgEncNo());
                db.proc.setObject(3,treatmentNo);
                db.proc.setString(4,dArr[i]);
                db.proc.execute();
            }
            //          db.closeStmt();
            //medicine insertion in DB system
            ArrayList mList = treatment.getMedicineList();
            Iterator itr = mList.iterator();
            db.prepareCallString("{call emg_setMedicine(?,?,?,?,?,?,?,?)}");
            while(itr.hasNext()){
                medicine = (Medicine)itr.next();
                db.proc.setObject(1,treatment.getPid());
                db.proc.setObject(2,treatment.getEmgEncNo());
                db.proc.setObject(3,treatmentNo);
                db.proc.setString(4,medicine.getMCode());
                db.proc.setObject(5,medicine.getTiming());
                db.proc.setObject(6,medicine.getQty());
                db.proc.setObject(7,medicine.getPeriod());
                db.proc.setString(8,medicine.getComments());
                db.proc.execute();
            }
            db.endTransaction(); //commit
            db.closeStmtCon();
        }catch(SQLException e){
            System.out.println(e.getMessage() + "\n" + e.getErrorCode());
            e.printStackTrace();
//            try{
//                db.con.rollback();
//                db.closeStmtCon();
//            }catch(SQLException ex){
//                System.out.println(ex.getMessage() + "\n" + ex.getErrorCode());
//                ex.printStackTrace();
//            }
            return null;
        }
        return treatmentNo;
    }
    
    public Treatment getTreatment(Integer pid, Integer emgEncNo, Integer treatmentNo) throws TreatmentNotFoundException{
        Treatment treatment=new Treatment();
        ArrayList diseaseList,medicineList;
        Medicine medicine;
        Mapping map;
        treatment.setPid(pid);
        treatment.setEmgEncNo(emgEncNo);
        treatment.setTreatmentNo(treatmentNo);
        
        DBAccess db = new DBAccess();
        db.prepareCallString("{call emg_getTreatment(?,?,?)}");
        try{
            db.proc.setObject(1,pid);
            db.proc.setObject(2,emgEncNo);
            db.proc.setObject(3,treatmentNo);
            db.proc.execute();
            rs = db.proc.getResultSet();
            
            while(rs.next()){
                treatment.setDTime(rs.getTimestamp(1));
                treatment.setPComplaints(rs.getString(2));
                treatment.setWardNo((Integer)rs.getObject(3));
                treatment.setWardName(rs.getString(4));
                treatment.setEmpId((Integer)rs.getObject(5));
                treatment.setEmpName(rs.getString(6));
            }
            rs.close();
            
            db.prepareCallString("{call emg_getTreatmentDisease(?,?,?)}");
            db.proc.setObject(1,pid);
            db.proc.setObject(2,emgEncNo);
            db.proc.setObject(3,treatmentNo);
            db.proc.execute();
            rs = db.proc.getResultSet();
            diseaseList = new ArrayList();
            while(rs.next()){
                map = new Mapping();
                map.setKey(rs.getString(1));
                map.setValue(rs.getString(2));
                diseaseList.add(map);
            }
            treatment.setDiseaseList(diseaseList);
            rs.close();
            
            db.prepareCallString("{call emg_getTreatmentMedicine(?,?,?)}");
            db.proc.setObject(1,pid);
            db.proc.setObject(2,emgEncNo);
            db.proc.setObject(3,treatmentNo);
            db.proc.execute();
            rs = db.proc.getResultSet();
            medicineList = new ArrayList();
            while(rs.next()){
                medicine = new Medicine();
                medicine.setMCode( rs.getString(1) );
                medicine.setMName(rs.getString(2)); //medicineName
                medicine.setTiming((Integer)rs.getObject(3));
                medicine.setQty((Integer)rs.getObject(4));
                medicine.setPeriod((Integer)rs.getObject(5))                ;
                medicine.setComments(rs.getString(6));
                medicineList.add(medicine);
            }
            treatment.setMedicineList(medicineList);
            rs.close();
            db.closeStmtCon();
            rs = null;
            db=null;
        }catch(SQLException e){
            System.out.println(e.getMessage() + "\n" + e.getErrorCode());
            e.printStackTrace();
            throw new TreatmentNotFoundException(pid,emgEncNo,treatmentNo);
        }
        return treatment;
    }
    
    public Patient getPatient(Integer pid, Integer emgEncNo) {
        Patient pt=null;
        DBAccess db=new DBAccess();
        db.prepareCallString("{call emg_getPatient(?,?)}");
        try{
            db.proc.setObject(1,pid);
            db.proc.setObject(2,emgEncNo);
            db.proc.execute();
            rs = db.proc.getResultSet();
            while(rs.next()){
                pt = new Patient();
                pt.setPid(pid);
                pt.setName(rs.getString(1)+" " + rs.getString(2));
                pt.setFatherName(rs.getString(3));
                pt.setGender(rs.getString(4));
                pt.setDob(rs.getDate(5));
                pt.setAddress(rs.getString(6)+", " + rs.getString(7)+", "+ rs.getString(8));
                pt.setEncNo((Integer)rs.getObject(9)); //encNO
                pt.setEncDateTime(rs.getTimestamp(10));
                pt.setMlc(rs.getString(11));
            }
            rs.close();
            db.closeStmtCon();
            rs = null;
            db=null;
        }catch(SQLException e){
            System.out.println(e.getMessage() + "\n" + e.getErrorCode());
            e.printStackTrace();
        }
        return pt;
    }
    
    public ArrayList getAllEncsHeading(Integer pid){
        ArrayList listEnc = null;
        EncHeading encH = null;
        DBAccess db=new DBAccess();
        db.prepareCallString("{call emg_getAllEncsHeading(?)}");
        try{
            db.proc.setObject(1,pid);
            db.proc.execute();
            rs = db.proc.getResultSet();
            listEnc =  new ArrayList();
            while(rs.next()){
                encH = new EncHeading();
                encH.setEmgEncNo((Integer)rs.getObject(1));
                encH.setDTime(rs.getTimestamp(2));
                encH.setMlcType(rs.getString(3));
                listEnc.add(encH);
            }
            rs.close();
            db.closeStmtCon();
            rs = null;
            db=null;
        }catch(SQLException e){
            System.out.println(e.getMessage() + "\n" + e.getErrorCode());
            e.printStackTrace();
        }
        return listEnc;
    }
    
    public ArrayList getAllTreatmentsHeading(Integer pid, Integer emgEncNo) {
        ArrayList listTrt = null;
        TreatmentHeading trtH = null;     //Trt for "Treatment"
        DBAccess db=new DBAccess();
        db.prepareCallString("{call emg_getAllTreatmentsHeading(?,?)}");
        try{
            db.proc.setObject(1,pid);
            db.proc.setObject(2,emgEncNo);
            db.proc.execute();
            rs = db.proc.getResultSet();
            listTrt =  new ArrayList();
            while(rs.next()){
                trtH = new TreatmentHeading();
                trtH.setTreatmentNo((Integer)rs.getObject(1));
                trtH.setDTime(rs.getTimestamp(2));
                trtH.setDrName(rs.getString(3)+" "+rs.getString(4) ); //FirstName || Last Name
                listTrt.add(trtH);
            }
            rs.close();
            db.closeStmtCon();
            rs = null;
            db=null;
        }catch(SQLException e){
            System.out.println(e.getMessage() + "\n" + e.getErrorCode());
            e.printStackTrace();
        }
        return listTrt;
    }
    
    public EncounterDetail getEncounterDetail(int pid, int emgEncNo){
        EncounterDetail encD=null;
        DBAccess db=new DBAccess();
        db.prepareCallString("{call emg_getEncDetail(?,?)}"); // pid, emgEncNo
        try{
            db.proc.setInt(1,pid);
            db.proc.setInt(2,emgEncNo);
            db.proc.execute();
            rs = db.proc.getResultSet();
            while(rs.next()){
                encD  = new EncounterDetail();
                encD.setMlc(rs.getString("mlc"));
                encD.setBroughtBy(rs.getString("broughtBy"));
                encD.setPhNo(rs.getString("phNo"));
                encD.setIsRefered(rs.getBoolean("isRefered"));
                encD.setEncDateTime(rs.getTimestamp("encDateTime"));
                if(encD.isIsRefered()){
                encD.setRefName(rs.getString("refName"));
                encD.setRefNotes(rs.getString("refNotes"));
                encD.setRefPhNo(rs.getString("refPhNo"));
                encD.setFileId(rs.getInt("fileId"));
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
        return encD;
    }
    
    private Long getNextFileId(Long dbFid){
        String strThisYear = Integer.valueOf(new java.util.Date().getYear()).toString().substring(1, 3);
        String strThisMonth = Integer.valueOf(new java.util.Date().getMonth() + 1).toString();

        if(strThisMonth.length() ==  1 )
            strThisMonth = "0"+strThisMonth;
        System.out.println("strThisYear: = " + strThisYear);
        System.out.println("strThisMonth: = " + strThisMonth);
        
        Long fid = null;
        if(dbFid == null){
            String strFid = new String( strThisYear + strThisMonth + "000001" );
            fid = Long.valueOf(strFid);
            return fid;
        } else{
            String strDbFid = dbFid.toString();
            String strDbYear = strDbFid.substring( 0, strDbFid.length() - 8 );
            String strDbMonth = strDbFid.substring(strDbFid.length() - 8, strDbFid.length() - 6 );
            
            if(strDbYear.length()==1)//becoz this year contains 2 characters
                strDbYear = "0"+strDbYear;
            
            if(strDbMonth.equalsIgnoreCase(strThisMonth) && strDbYear.equalsIgnoreCase(strThisYear) ){
                long longFid = dbFid.longValue() + 1 ;
                fid = Long.valueOf(longFid) ;
            }else{
                String strFid = strThisYear + strThisMonth + "000001";
                System.out.println(strThisYear);
                fid = Long.valueOf(strFid);
            }
        }
        return fid;
    }
}