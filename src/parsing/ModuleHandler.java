package parsing;

import java.util.ArrayList;
import java.util.List;

import org.xml.sax.Attributes;
import org.xml.sax.SAXException;

import data.Module;

import parsing.BaseHandler;

public class ModuleHandler extends BaseHandler {

	private String actualTag;

	private Module actualModule;

	private List<Module> output;

	// ===========================================================
	// Getter & Setter
	// ===========================================================

	public List<Module> getParsedData() {
		return output;
	}

	// ===========================================================
	// Methods
	// ===========================================================
	@Override
	public void startDocument() throws SAXException {
		this.output = new ArrayList<Module>();
	}

	@Override
	public void endDocument() throws SAXException {
		// Nothing to do
	}

	/** Gets be called on opening tags like:
	 * <tag>
	 * Can provide attribute(s), when xml was like:
	 * <tag attribute="attributeValue">*/
	@Override
	public void startElement(
			String namespaceURI, 
			String localName,
			String qName, 
			Attributes atts
	) throws SAXException {
		if (qName.equals("module")){
			actualModule = new Module();
		}
		this.actualTag = qName;
	}

	/** Gets be called on closing tags like:
	 * </tag> */
	@Override
	public void endElement(String namespaceURI, String localName, String qName)
	throws SAXException {
		if (qName.equals("module")){
			output.add(actualModule);
			actualModule = null;
		}
	}

	/** Gets be called on the following structure:
	 * <tag>characters</tag> */
	@Override
	public void characters(char ch[], int start, int length) {
		setValue(new String(ch, start, length));
	}

	private void setValue (String value){

		if (actualTag.equals("id")){
			actualModule.setId(value);
		}else if (actualTag.equals("class")){
			actualModule.addClass(value);
		}else if (actualTag.equals("start_time")){
			actualModule.setStart(value);
		}else if (actualTag.equals("end_time")){
			actualModule.setEnd(value);
		}else if (actualTag.equals("day_of_week")){
			actualModule.setWeekday(Integer.parseInt(value));
		}else if (actualTag.equals("lection_id")){
			actualModule.setLection(value);
		}else if (actualTag.equals("shortname")){
			actualModule.setShortname(value);
		}else if (actualTag.equals("name_de")){
			actualModule.setNameDe(value);
		}else if (actualTag.equals("name_fr")){
			actualModule.setNameFr(value);
		}else if (actualTag.equals("location")){
			actualModule.setLocation(value);
		}else if (actualTag.equals("execution")){
			actualModule.setExecution(value);
		}
	}
}
