package parsing;

import data.Class;

import java.util.ArrayList;
import java.util.List;

import org.xml.sax.Attributes;
import org.xml.sax.SAXException;

public class ClassHandler extends BaseHandler {

	private String actualTag;

	private Class actualClass;

	private List<Class> output;

	// ===========================================================
	// Getter & Setter
	// ===========================================================

	public List<Class> getParsedData() {
		return output;
	}

	// ===========================================================
	// Methods
	// ===========================================================
	@Override
	public void startDocument() throws SAXException {
		this.output = new ArrayList<Class>();
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
		if (qName.equals("class")){
			actualClass = new Class();
		}
		this.actualTag = qName;
	}

	/** Gets be called on closing tags like:
	 * </tag> */
	@Override
	public void endElement(String namespaceURI, String localName, String qName)
	throws SAXException {
		if (qName.equals("class")){
			output.add(actualClass);
			actualClass = null;
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
			actualClass.setId(value);
		}else if (actualTag.equals("name")){
			actualClass.setName(value);
		}else if (actualTag.equals("location")){
			actualClass.setLocation(value);
		}else if (actualTag.equals("division")){
			actualClass.setDivision(value);
		}else if (actualTag.equals("module")){
			actualClass.addModule(value);
		}
	}

}
