/*
 * MapInt.java
 *
 * Created on July 20, 2006, 9:12 PM
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
public class MapInt implements Serializable{
    private String key;
    private int value;
    
    /** Creates a new instance of MapInt */
    public MapInt() {
    }

    public String getKey() {
        return key;
    }

    public void setKey(String key) {
        this.key = key;
    }

    public int getValue() {
        return value;
    }

    public void setValue(int value) {
        this.value = value;
    }
    
    
}
