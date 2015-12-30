/*
 * Patient.java
 *
 * Created on May 26, 2006, 12:07 PM
 *
 * To change this template, choose Tools | Template Manager
 * and open the template in the editor.
 */

package coshms.util.emergency;

import java.io.File;
import java.io.Serializable;
import java.sql.Date;
import java.sql.Timestamp;

/**
 *
 * @author Asif
 */
public class Patient implements Serializable{
    private Integer pid;
    private String name;
    private String fatherName;
    private String gender;
    private Date dob;
    private String address;
    private String cnic;
    private boolean picExist;
    private File picture;
    private byte picByte[];
    private int picSize;
    
    private String mlc;
    private Integer encNo;
    private Timestamp encDateTime; //it assumes last incounter when getting data back fro DB
        
    /**
     * Creates a new instance of Patient
     */
    public Patient() {
    }
    
    public String getCnic(){
        return this.cnic;                
    }
    public void setCnic(String cnic){
        this.cnic = cnic;        
    }
    
    public Integer getPid() {
        return pid;
    }

    public void setPid(Integer pid) {
        this.pid = pid;
    }

       public String getFatherName() {
        return fatherName;
    }

    public void setFatherName(String fatherName) {
        this.fatherName = fatherName;
    }

    public String getGender() {
        return gender;
    }

    public void setGender(String gender) {
        this.gender = gender;
    }

    public Date getDob() {
        return dob;
    }

    public void setDob(Date dob) {
        this.dob = dob;
    }

    public String getAddress() {
        return address;
    }

    public void setAddress(String address) {
        this.address = address;
    }

    public String getMlc() {
        return mlc;
    }

    public void setMlc(String mlc) {
        this.mlc = mlc;
    }

    public Integer getEncNo() {
        return encNo;
    }

    public void setEncNo(Integer encNo) {
        this.encNo = encNo;
    }

    public Timestamp getEncDateTime() {
        return encDateTime;
    }

    public void setEncDateTime(Timestamp encDateTime) {
        this.encDateTime = encDateTime;
    }
    
    public int getAge(){
        int todayYrs;
        todayYrs= new java.util.Date().getYear() + 1900;
        return todayYrs - (this.dob.getYear()+1900);
    }
    
    public String getName() {
        return name;
    }
    
    public void setName(String name) {
        this.name = name;
    }
    
    public void setPicture(File picture){
        this.picture = picture;
    }
    
    public File getPicture(){
        return picture;
    }

    public byte[] getPicByte() {
        return picByte;
    }

    public void setPicByte(byte[] picByte) {
        this.picByte = picByte;
    }

    public int getPicSize() {
        return picSize;
    }

    public void setPicSize(int picSize) {
        this.picSize = picSize;
    }

    public boolean isPicExist() {
        return picExist;
    }

    public void setPicExist(boolean picExist) {
        this.picExist = picExist;
    }
}
