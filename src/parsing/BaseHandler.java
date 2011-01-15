package parsing;

import org.xml.sax.helpers.DefaultHandler;

public abstract class BaseHandler extends DefaultHandler {
	public abstract Object getParsedData();
}
