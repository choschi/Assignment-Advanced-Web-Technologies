package data;

import java.util.ArrayList;
import java.util.List;

public class Module {
	private String id;
	private List<String> classes;
	private String start;
	private String end;
	private int weekday;
	private String lection;
	private String shortname;
	private String nameDe;
	private String nameFr;
	private String location;
	private String execution;
	
	public Module (){
		this.classes = new ArrayList<String>();
	}
	
	public void setId (String id){
		this.id = id;
	}
	
	public String getId (){
		return this.id;
	}

	public void setStart(String start) {
		this.start = start;
	}

	public String getStart() {
		return start;
	}

	public void setEnd(String end) {
		this.end = end;
	}

	public String getEnd() {
		return end;
	}

	public void setWeekday(int weekday) {
		this.weekday = weekday;
	}

	public int getWeekday() {
		return weekday;
	}

	public void setLection(String lection) {
		this.lection = lection;
	}

	public String getLection() {
		return lection;
	}

	public void setShortname(String shortname) {
		this.shortname = shortname;
	}

	public String getShortname() {
		return shortname;
	}

	public void setLocation(String location) {
		this.location = location;
	}

	public String getLocation() {
		return location;
	}

	public void setExecution(String execution) {
		this.execution = execution;
	}

	public String getExecution() {
		return execution;
	}

	public void setNameDe(String nameDe) {
		this.nameDe = nameDe;
	}

	public String getNameDe() {
		return nameDe;
	}

	public void setNameFr(String nameFr) {
		this.nameFr = nameFr;
	}

	public String getNameFr() {
		return nameFr;
	}
	
	public void addClass(String Class){
		this.classes.add(Class);
	}
	
	public List<String> classes (){
		return this.classes;
	}
}
