package mylib;

import javax.faces.bean.ManagedBean;
import javax.faces.bean.SessionScoped;
import java.io.Serializable;
import java.util.List;
import java.util.LinkedList;

@ManagedBean
@SessionScoped
public class DataBean implements Serializable{
    List data;

    public DataBean(){
	data = new LinkedList();

	// The following Data should be hold out of a Database or any 
	// other persistancy data source.
	// This application emulates the backoffice
	data.add(new Module("2405","Marketing"));
	data.add(new Module("7083","Ergonomie, Psychologie"));
	data.add(new Module("7409a","Linux Ia"));
	data.add(new Module("7409b","Linux Ib"));
	data.add(new Module("7409c","Linux Ic"));
	data.add(new Module("7409p","Linux Ip"));
	data.add(new Module("7409q","Linux Iq"));
	data.add(new Module("7409r","Linux Ir"));
    }

    public List getData(){
	return data;
    }

    public void setData(List l){
	//data = l;

    }
}
