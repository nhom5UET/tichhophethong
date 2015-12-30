/*
 * Treatment.java
 *
 * Created on June 9, 2006, 11:02 AM
 *
 * To change this template, choose Tools | Template Manager
 * and open the template in the editor.
 */

package coshms.util.emergency;

import java.io.Serializable;
import java.sql.Timestamp;
import java.util.ArrayList;

/**
 *
 * @author Asif
 */
public class Treatment implements Serializable{
    private Integer pid;
    private Integer emgEncNo;
    private String pComplaints;    
    private String[] dCodeArr;    //disease Codes Array
    private ArrayList medicineList;
    private Integer wardNo;
    private Integer empId;
    
    //below fields use when getting data back from DB.
    private Timestamp dTime;
    private Integer treatmentNo;
    private String wardName;
    private ArrayList diseaseList;
    private String empName; 
            
    /** Creates a new instance of Treatment */
    public Treatment() {
    }

    public Integer getPid() {
        return pid;
    }

    public void setPid(Integer pid) {
        this.pid = pid;
    }

    public Integer getEmgEncNo() {
        return emgEncNo;
    }

    public void setEmgEncNo(Integer emgEncNo) {
        this.emgEncNo = emgEncNo;
    }

    public String getPComplaints() {
        return pComplaints;
    }

    public void setPComplaints(String pComplaints) {
        this.pComplaints = pComplaints;
    }

    public String[] getDCodeArr() {
        return dCodeArr;
    }

    public void setDCodeArr(String[] dCodeArr) {
        this.dCodeArr = dCodeArr;
    }

    public ArrayList getMedicineList() {
        return medicineList;
    }

    public void setMedicineList(ArrayList medicineList) {
        this.medicineList = medicineList;
    }

    public Integer getWardNo() {
        return wardNo;
    }

    public void setWardNo(Integer wardNo) {
        this.wardNo = wardNo;
    }

    public Integer getEmpId() {
        return empId;
    }

    public void setEmpId(Integer empId) {
        this.empId = empId;
    }

    public Timestamp getDTime() {
        return dTime;
    }

    public void setDTime(Timestamp dTime) {
        this.dTime = dTime;
    }

    public Integer getTreatmentNo() {
        return treatmentNo;
    }

    public void setTreatmentNo(Integer treatmentNo) {
        this.treatmentNo = treatmentNo;
    }

    public String getWardName() {
        return wardName;
    }

    public void setWardName(String wardName) {
        this.wardName = wardName;
    }

    public ArrayList getDiseaseList() {
        return diseaseList;
    }

    public void setDiseaseList(ArrayList diseaseList) {
        this.diseaseList = diseaseList;
    }

    public String getEmpName() {
        return empName;
    }

    public void setEmpName(String empName) {
        this.empName = empName;
    }

  
    
}
