import java.util.ArrayList;             
public class Tokenizer {                                                                      //This class is where the Token objects are created starting from the input line
	StringBuilder sb;                                                                         //The variable sb is the string read from Scanner in main 
	ArrayList <String> statementList;                                                         //These 2 arrays are the one provided in main and are needed in order to be passed 
	ArrayList <String> operatorList;                                                          //to the Token constructor
	
	public Tokenizer (StringBuilder s,ArrayList <String> sl, ArrayList <String> ol) {         //Constructor
		this.sb= new StringBuilder (s);
		this.statementList= new ArrayList <String> (sl);
		this.operatorList= new ArrayList <String> (ol);
	}
	public ArrayList<Token> getTokens () throws SyntaxException{                              
		ArrayList<Token> line = new ArrayList<Token> ();                                      //Initialization of the ArrayList that will be returned
		if (this.sb.charAt(0) != '(' || this.sb.charAt(sb.length()-1) != ')') {                            //First layer of syntactical checks, it is known that any correct input  
			throw new SyntaxException (" A line needs to start with '(' token and end with ')' token");    //will start and end with round parenthesis
		}
		for (int i=0;i<this.sb.length();i++) {                                                //This for loop ensures that every character in the string is read 
			if (Character.isWhitespace(this.sb.charAt(i)))                                    //if the character at position i is a white space it is skipped
				continue;
			if (Character.isLetter(this.sb.charAt(i))) {                                      //If the character at position i is a letter the position is stored into a new variable j
				int j=i;                                                                      //while i continues to grow, this part of the method is used to recognize variables
				while (Character.isLetter(this.sb.charAt(i))) {                               
					i++;
				}
				Token t=new Token (this.sb.substring(j, i),this.statementList,this.operatorList);                      //Then a Token object is created and added to the array, a check is performed to see
				line.add(t);                                                                                           //if the real name given by the user contains only letters
				if (this.sb.charAt(i)!='(' && this.sb.charAt(i)!=')' && !Character.isWhitespace(this.sb.charAt(i))) {
					throw new SyntaxException (" A variable name must contain only letters");
				}
				i--;                                                                                                   //index i must then decrease by one since the current character at position i
			}                                                                                                          //is the successor of the last one recognized as a letter
			else if (Character.isDigit(this.sb.charAt(i)) || this.sb.charAt(i)=='-') {                                 
				int j=i;                                                                      //Now if the character at position i is a number or the minus sign a routine similar to the previous begins
				if ( this.sb.charAt(i)=='-')                                                  //This part of the method is used to recognize numbers  
					i++;                                                                      //(a negative number can have white spaces between the minus sign and the digits)
				while (Character.isWhitespace(this.sb.charAt(i))) {
					i++;
				}
					
				while (Character.isDigit(this.sb.charAt(i))) {
					i++;
				}
			
				Token t=new Token (this.sb.substring(j, i).trim(),this.statementList,this.operatorList);
				line.add(t);
				i--;
			}
			else if (this.sb.charAt(i)=='(' || this.sb.charAt(i)==')') {                                           //If the character is a parenthesis then a Token is created and added to the array
				Token t= new Token (Character.toString(this.sb.charAt(i)),this.statementList,this.operatorList);
				line.add(t);
			}
			else {                                                                                                 //If no if block is entered an exception is thrown as the character is not valid 
				throw new SyntaxException (" "+this.sb.charAt(i)+" is not a recognizable character");
			}
				
		}
		
		return line;
	}

}
