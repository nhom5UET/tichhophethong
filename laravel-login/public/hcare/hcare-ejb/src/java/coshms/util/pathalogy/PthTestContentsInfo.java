/*
 * PthTestContentsInfo.java
 *
 * Created on May 13, 2006, 11:01 AM
 *
 * To change this template, choose Tools | Template Manager
 * and open the template in the editor.
 */

package coshms.util.pathalogy;
import java.io.Serializable;
/**
 *
 * @author Administrator
 */
public class PthTestContentsInfo implements Serializable {
    
    private String name;
    private double minValue;
    private double maxValue;
    private String unit;
    

    private String testName;
    private int contentId;
    private int empId;
    private double contentValue;
    private String contentNotes;
    
    /** Creates a new instance of PthTestContentsInfo */
    public PthTestContentsInfo() {
    }
    
    public PthTestContentsInfo(String cName,double minV,double maxV,String u) {
      this.setName(cName);
      this.setMaxValue(maxV);
      this.setMinValue(minV);
      this.setUnit(u);
    }

    public PthTestContentsInfo(String cName,double minV,double maxV,String u,String tName) {
      this.setName(cName);
      this.setMaxValue(maxV);
      this.setMinValue(minV);
      this.setUnit(u);
      this.setTestName(tName);
    }

    
      public PthTestContentsInfo(int cid,double cValue,String cNotes) {
      this.setContentId(cid);
      this.setContentValue(cValue);
      this.setContentNotes(cNotes);
      }   
    
    public PthTestContentsInfo(String tName,int cId,String cName,double minV,double maxV,String u) {
      this.setTestName(tName); 
      this.setContentId(cId);
      this.setName(cName);
      this.setMaxValue(maxV);
      this.setMinValue(minV);
      this.setUnit(u);
    }
    
    public PthTestContentsInfo(String cName,double minV,double maxV,String u,double contentValue,String notes) {
      this.setName(cName);
      this.setMaxValue(maxV);
      this.setMinValue(minV);
      this.setUnit(u);
      this.setContentNotes(notes);
      this.setContentValue(contentValue);
    }
    
    
    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public double getMinValue() {
        return minValue;
    }

    public void setMinValue(double minValue) {
        this.minValue = minValue;
    }

    public double getMaxValue() {
        return maxValue;
    }

    public void setMaxValue(double maxValue) {
        this.maxValue = maxValue;
    }

    public String getUnit() {
        return unit;
    }

    public void setUnit(String unit) {
        this.unit = unit;
    }

    public String getTestName() {
        return testName;
    }

    public void setTestName(String testName) {
        this.testName = testName;
    }

    public int getContentId() {
        return contentId;
    }

    public void setContentId(int contentId) {
        this.contentId = contentId;
    }

    public int getEmpId() {
        return empId;
    }

    public void setEmpId(int empId) {
        this.empId = empId;
    }

    public double getContentValue() {
        return contentValue;
    }

    public void setContentValue(double contentValue) {
        this.contentValue = contentValue;
    }

    public String getContentNotes() {
        return contentNotes;
    }

    public void setContentNotes(String contentNotes) {
        this.contentNotes = contentNotes;
    }

}
