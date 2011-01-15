package data;

import java.util.ArrayList;
import java.util.List;

public class Class {
	private String id;
	private String name;
	private String division;
	private String location;
	private List<String> modules;
	
	public Class (){
		modules = new ArrayList<String>();
	}
	
	public void setId(String id) {
		this.id = id;
	}
	public String getId() {
		return id;
	}
	public void setName(String name) {
		this.name = name;
	}
	public String getName() {
		return name;
	}
	public void setDivision(String division) {
		this.division = division;
	}
	public String getDivision() {
		return division;
	}
	public void setLocation(String location) {
		this.location = location;
	}
	public String getLocation() {
		return location;
	}
	
	public void addModule (String mod){
		modules.add(mod);
	}
	
	public List<String> getModules (){
		return this.modules;
	}
}
