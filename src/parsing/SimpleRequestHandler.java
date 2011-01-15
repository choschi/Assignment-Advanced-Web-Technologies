package parsing;

import org.xml.sax.Attributes;
import org.xml.sax.SAXException;

import parsing.BaseHandler;

public class SimpleRequestHandler extends BaseHandler {

	private String actualTag;

	private boolean output = false;

	// ===========================================================
	// Getter & Setter
	// ===========================================================

	public Boolean getParsedData() {
		return output;
	}

	// ===========================================================
	// Methods
	// ===========================================================
	@Override
	public void startDocument() throws SAXException {
		this.output = false;
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
		if (actualTag.equals("code")){
			if (value.equals("user_11") || value.equals("user_12")){
				output = true;
			}
		}
	}
}
