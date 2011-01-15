package data;

import java.io.IOException;
import java.io.InputStreamReader;
import java.io.Reader;
import java.io.UnsupportedEncodingException;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.List;

import javax.xml.parsers.ParserConfigurationException;
import javax.xml.parsers.SAXParser;
import javax.xml.parsers.SAXParserFactory;

import org.xml.sax.InputSource;
import org.xml.sax.SAXException;
import org.xml.sax.SAXParseException;
import org.xml.sax.XMLReader;

import parsing.*;

public class DataManager {
	
	private static String baseURL = "http://awt.choschi.com/xml/";
	
	/**
	 * gets the basic user data from the db returns null on failure
	 * @param username
	 * @param password
	 * @return User object
	 */
	
	public static User login (String username, String password){
		
		URL url = generateUrl ("user/login/"+username+"/"+password+"/");

		LoginHandler handler = new LoginHandler();
		
		Object result = parseData(handler, url);
		
		return (User)result;
		
	}
	
	/**
	 * adds a module to a users list of modules
	 * @param userid
	 * @param moduleid
	 * @return true on success false on failure
	 */
	
	public static boolean addModule (String userid,String moduleid){
		
		URL url = generateUrl ("/user/add/"+userid+"/"+moduleid+"/");
		
		SimpleRequestHandler handler = new SimpleRequestHandler();
		
		Object result = parseData(handler, url);
		
		return (Boolean)result;
	}
	
	/**
	 * removes a module from a users list of modules
	 * @param userid
	 * @param moduleid
	 * @return true on success false on failure
	 */
	
	public static boolean removeModule (String userid,String moduleid){
		
		URL url = generateUrl ("/user/remove/"+userid+"/"+moduleid+"/");
		
		SimpleRequestHandler handler = new SimpleRequestHandler();
		
		Object result = parseData(handler, url);
		
		return (Boolean)result;
	}
	
	/**
	 * gets the list of a users modules
	 * @param userid
	 * @return List<Module>
	 */
	
	@SuppressWarnings("unchecked")
	public static List<Module> getModulesForUser (String userid){
		URL url = generateUrl ("/user/module/"+userid+"/"+userid+"/");
		
		ModuleHandler handler = new ModuleHandler();
		
		Object result = parseData(handler, url);
		
		return (List<Module>)result;
	}
	
	/**
	 * returns the list of modules for a certain class
	 * @param classid
	 * @return List<Module>
	 */
	
	@SuppressWarnings("unchecked")
	public static List<Module> getModulesForClass (String classid){
		URL url = generateUrl ("/module/class/"+classid+"/");
		
		ModuleHandler handler = new ModuleHandler();
		
		Object result = parseData(handler, url);
		
		return (List<Module>)result;
	}
	
	/**
	 * returns the list of classes for a certain module
	 * @param classid
	 * @return List<Module>
	 */
	
	@SuppressWarnings("unchecked")
	public static List<Class> getClassesForModule (String moduleid){
		URL url = generateUrl ("/class/module/"+moduleid+"/");
		
		ClassHandler handler = new ClassHandler();
		
		Object result = parseData(handler, url);
		
		return (List<Class>)result;
	}
	
	public static List<Class> getClass (String classid){
		URL url = generateUrl ("/class/"+classid+"/");
		
		ClassHandler handler = new ClassHandler();
		
		Object result = parseData(handler, url);
		
		return (List<Class>)result;
	}
	
	public static List<Module> getModule (String moduleid){
		URL url = generateUrl ("/module/"+moduleid+"/");
		
		ModuleHandler handler = new ModuleHandler();
		
		Object result = parseData(handler, url);
		
		return (List<Module>)result;
	}
	
	/**
	 * parses the contents of an InputSource an returns the result object
	 * @param handler an extension of BaseHandler
	 * @param URL object which contains the location of the data xml file
	 * @return a DataObject
	 */
	
	private static Object parseData(BaseHandler handler, URL url) {
		
		InputSource is = xmlSourceUTF8(url);
		
		SAXParserFactory spf = SAXParserFactory.newInstance();
		SAXParser sp = null;
		try {
			sp = spf.newSAXParser();
		} catch (ParserConfigurationException e1) {
			System.out.println(e1.toString());
		} catch (SAXException e1) {
			System.out.println(e1.toString());
		}

		/* Get the XMLReader of the SAXParser we created. */
		XMLReader xr = null;
		try {
			xr = sp.getXMLReader();
		} catch (SAXException e1) {
			System.out.println(e1.toString());
		}
		xr.setContentHandler(handler);

		// parse the shite
		try {
			xr.parse(is);
		} catch (IOException e) {
			System.out.println(e.toString());
		} catch (SAXParseException e){
			System.out.println("parsing threw: "+e.toString());
		} catch (SAXException e){
			System.out.println(e.toString());
		}
		/* Parsing has finished. */

		// get the user
		return handler.getParsedData();
	}
	
	/**
	 * creates an InputSource object from an url, whos contents are utf-8 encoded
	 * @param url
	 * @return input soure
	 */

	private static InputSource xmlSourceUTF8 (URL url){
		Reader reader = null;
		try {
			reader = new InputStreamReader(url.openStream(),"UTF-8");
		} catch (UnsupportedEncodingException e) {
			System.out.println(e.toString());
		} catch (IOException e) {
			System.out.println(e.toString());
		}

		InputSource is = new InputSource(reader);
		is.setEncoding("UTF-8");
		return is;
	}
	
	/**		
	 * generates the URL object for the request
	 * @param a string containing the rest api call e.g.: user/login/username/password/
	 * @return the corresponding URL object
	 */
	private static URL generateUrl(String rest){
		URL url = null;
		try {
			url = new URL(baseURL+rest);
		} catch (MalformedURLException e) {
			System.out.println(e.toString());
		}
		return url;
	}
}
