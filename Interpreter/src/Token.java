import java.util.ArrayList;
public class Token {                                          //Object representing the terminal symbols (parenthesis are considered tokens even if not terminal symbols by themselves)
	String string;                                            //String value of the token (e.g. "23",")","ADD","SET")
	int type;                                                 //The type of the token 0 = unknown 1 = statement, 2 = operator, 3 = '(', 4 = ')', 5 = number, 6 = variable, 
	
	
	public Token (String s,ArrayList<String> slist,ArrayList<String> olist) {      //Constructor
		this.string=s;
		this.type=0;                                                               //At first the type is set to unknown
		if (s.equals("(")) {                                                       
			this.type=3;                                                           //Then the method starts a series of checks
		}                                                                          //If one of the if statement is fulfilled then the type of the token is changed
		if (s.equals(")")) {
			this.type=4;
		}
		boolean num=true;                                                          //Here in the number check the program assumes the string
		try {                                                                      //represents a number and tries to parse it, if an exception is caught 
			Long.parseLong(s);                                                     //then the string does not represent a number and the type is not changed
		}
		catch (NumberFormatException nfe) {
			num=false;
		}
		if (num) {
			this.type=5;
		}
		boolean var=true;                                                          //In the variable check it is only important to see 
		for (int i=0;i<s.length();i++) {                                           //whether all the string characters are letters or not
			if (Character.isLetter(s.charAt(i)))                                   //if one of the character is not a letter then the type will not be changed
				continue;
			else
				var=false;
		}
		if (var) {                                                                 
			this.type=6;
		}                                                                          //If the string represents an operator or a statement
		if (slist.contains(s)) {                                                   //the program will at first see it as a variable and then performs checks 
			this.type=1;                                                           //to see if the string is contained in the arrays provided in the main
		}
		
		if (olist.contains(s)) {
			this.type=2;
		}
		
	}
	public Token (Token t) {                                                       //Copy constructor
		this.string=t.string;
		this.type=t.type;
	}
	public void setString (String s) {                                             //Setter
		this.string=s;
	}
	public String getString () {                                                   //Getter
		return this.string;
	}
	public boolean isStatementDecl () {                                            //All of the following methods performs checks on the type attribute
		if (this.type == 1)                                                        //they return true if the Token is of the requested type and false if it is not                                    
			return true;                                                           //e.g. if I want to know if a Token t is an operator I can call the method t.isOperator() 
		return false;                                                              //if it returns true then t is an operator, if it returns false t is not 
	}
	public boolean isOperator () {
		if (this.type == 2)
			return true;
		return false;
	}
	public boolean isParenthesis () {
		if (this.type ==3 || this.type == 4)
			return true;
		return false;
	}
	public boolean isOpenParenthesis () {
		if (this.type == 3)
			return true;
		return false;
	}
	public boolean isCloseParenthesis () {
		if (this.type == 4)
			return true;
		return false;
	}
	public boolean isVar () {
		if (this.type == 6)
			return true;
		return false;
	}
	public boolean isNum () {
		if (this.type == 5)
			return true;
		return false;
	}
	public boolean isVar_or_Num () {
		if (this.type == 5 || this.type == 6) 
			return true;
		return false;
	}
}
