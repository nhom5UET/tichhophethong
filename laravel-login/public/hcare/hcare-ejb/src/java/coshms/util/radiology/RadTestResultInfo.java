/*
 * RadTestResultInfo.java
 *
 * Created on June 6, 2006, 10:50 PM
 *
 * To change this template, choose Tools | Template Manager
 * and open the template in the editor.
 */

package coshms.util.radiology;
import java.io.*;
import java.io.Serializable;
/**
 *
 * @author Administrator
 */
public class RadTestResultInfo  implements Serializable {
    
    private File image;
    private int imageSize;
    private byte by[];    
    private int testId;
    private int testReqId;

    private String testName;
    private java.util.Date reqDate;
    private String notes;
    private int empId;
    private java.util.Date resDate;
    
    /** Creates a new instance of RadTestResultInfo */
    public RadTestResultInfo() {
    }

    public RadTestResultInfo(String fileName) {
    this.setImage(new File(fileName));
    }
    
    public RadTestResultInfo(String notes,int size,String testName,int empId,java.util.Date resDate) {
    this.setNotes(notes);
    this.setBy(new byte[size]);
    this.setImageSize(size);
    this.setResDate(resDate);
    this.setTestName(testName);
    this.setEmpId(empId);
    }
    
    public RadTestResultInfo(int testId,int testReqId,String testName,java.util.Date reqDate) {
    this.setTestId(testId);
    this.setTestReqId(testReqId);
    this.setTestName(testName);
    this.setReqDate(reqDate);
    }
    
    public File getImage() {
        return image;
    }

    public void setImage(File image) {
        this.image = image;
    }

    public int getTestId() {
        return testId;
    }

    public void setTestId(int testId) {
        this.testId = testId;
    }

    public int getTestReqId() {
        return testReqId;
    }

    public void setTestReqId(int testReqId) {
        this.testReqId = testReqId;
    }

    public String getTestName() {
        return testName;
    }

    public void setTestName(String testName) {
        this.testName = testName;
    }

    public java.util.Date getReqDate() {
        return reqDate;
    }

    public void setReqDate(java.util.Date reqDate) {
        this.reqDate = reqDate;
    }

    public String getNotes() {
        return notes;
    }

    public void setNotes(String notes) {
        this.notes = notes;
    }

    public byte[] getBy() {
        return by;
    }

    public void setBy(byte[] by) {
        this.by = by;
    }

    public int getImageSize() {
        return imageSize;
    }

    public void setImageSize(int imageSize) {
        this.imageSize = imageSize;
    }

    public int getEmpId() {
        return empId;
    }

    public void setEmpId(int empId) {
        this.empId = empId;
    }

    public java.util.Date getResDate() {
        return resDate;
    }

    public void setResDate(java.util.Date resDate) {
        this.resDate = resDate;
    }
    
}
