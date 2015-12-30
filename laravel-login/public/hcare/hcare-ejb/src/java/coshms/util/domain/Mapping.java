/*
 * Mapping.java
 *
 * Created on May 20, 2006, 3:21 PM
 *
 * To change this template, choose Tools | Template Manager
 * and open the template in the editor.
 */

package coshms.util.domain;

import java.io.Serializable;

/**
 *
 * @author Asif
 */
public class Mapping implements Serializable{
    private String key="";
    private String value="";
    
    /** Creates a new instance of Mapping */
    public Mapping(){        
    }
    
    public Mapping(String key, String value) {
        this.key=key;
        this.value = value;       
    }

    public String getKey() {
        return key;
    }

    public void setKey(String key) {
        this.key = key;
    }

    public String getValue() {
        return value;
    }

    public void setValue(String value) {
        this.value = value;
    }
    
    
}
