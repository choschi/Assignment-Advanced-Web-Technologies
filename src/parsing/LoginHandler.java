package parsing;

import org.xml.sax.Attributes;
import org.xml.sax.SAXException;

import data.User;

public class LoginHandler extends  BaseHandler{

	// ===========================================================
	// Fields
	// ===========================================================


	private String actualTag;

	private User output = new User();

	// ===========================================================
	// Getter & Setter
	// ===========================================================

	public User getParsedData() {
		return output;
	}

	// ===========================================================
	// Methods
	// ===========================================================
	@Override
	public void startDocument() throws SAXException {
		this.output = new User();
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
		this.actualTag = qName;
	}

	/** Gets be called on closing tags like:
	 * </tag> */
	@Override
	public void endElement(String namespaceURI, String localName, String qName)
	throws SAXException {
	}

	/** Gets be called on the following structure:
	 * <tag>characters</tag> */
	@Override
	public void characters(char ch[], int start, int length) {
		setValue(new String(ch, start, length));
	}

	private void setValue (String value){
		if (actualTag.equals("name")){
			output.setUsername(value);
		}else if(actualTag.equals("id")){
			output.setUserid(value);
		}
	}
}
