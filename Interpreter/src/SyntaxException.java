
public class SyntaxException extends Exception{

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;

	public SyntaxException (String s) {
		super("ERROR "+s);
	}
}
