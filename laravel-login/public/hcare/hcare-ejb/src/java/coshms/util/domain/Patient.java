/* Patient.java
 * Created on May 11, 2006, 3:22 PM */

package coshms.util.domain;

import java.io.File;
import java.io.FileNotFoundException;
import java.io.Serializable;
import java.sql.Date;

/**
 *
 * @author project
 */
public class Patient implements Serializable{    
    private Integer pid;
    private String firstName;
    private String lastName;
    private String fatherName;
    private String cnic;
    private String gender;
    private Date dob;
    private Date regDate;
    private String streetAddress;
    private String town;
    private String city;
    private boolean picExist;
    private File picture;
    private byte picByte[];
    private int picSize;
    
    private Integer empId;    
    /** Creates a new instance of Patient */
    public Patient() {
    }

    public Integer getPid() {
        return pid;
    }

    public void setPid(Integer pid) {
        this.pid = pid;
    }

    public String getFirstName() {
        return firstName;
    }

    public void setFirstName(String firstName) {
        this.firstName = firstName;
    }
    

    public String getLastName() {
        return lastName;
    }

    public void setLastName(String lastName) {
        this.lastName = lastName;
    }

    public String getGender() {
        return gender;
    }
    public String getCnic() {
        return cnic;
    }
    public void setCnic(String cnic){
        this.cnic = cnic;
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

    public Date getRegDate() {
        return regDate;
    }

    public void setRegDate(Date regDate) {
        this.regDate = regDate;
    }

    public String getStreetAddress() {
        return streetAddress;
    }

    public void setStreetAddress(String streetAddress) {
        this.streetAddress = streetAddress;
    }

    public String getTown() {
        return town;
    }

    public void setTown(String town) {
        this.town = town;
    }

    public String getCity() {
        return city;
    }

    public void setCity(String city) {
        this.city = city;
    }

    public Integer getEmpId() {
        return empId;
    }

    public void setEmpId(Integer empId) {
        this.empId = empId;
    }

    public String getFatherName() {
        return fatherName;
    }

    public void setFatherName(String fatherName) {
        this.fatherName = fatherName;
    }
    
    public int getAge(){
        int todayYrs;
        todayYrs= new java.util.Date().getYear() + 1900;
        return todayYrs - (this.getDob().getYear()+1900);
    }
    
    public void setPicture(File picture){
        this.picture = picture;
    }
    
    public File getPicture(){
        return this.picture;        
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
