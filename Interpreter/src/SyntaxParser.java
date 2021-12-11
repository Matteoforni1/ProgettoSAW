import java.util.*;
public class SyntaxParser {                                                
	                                                                  //Class in charge of parsing the token array
	ArrayList<Token> tokens;                                          //and ensuring the production rules are respected
	
	public SyntaxParser (ArrayList<Token> t) {                        //Constructor
		this.tokens=new ArrayList<Token> (t);
	} 
	
	public SyntaxTreeNode getSyntaxTreeRoot (Map<String,Long> m) throws SyntaxException {      //This is the method invoked by the main that returns
		int i=0;                                                                               //the root of the syntactical tree
		SyntaxTreeNode root = new SyntaxTreeNode (this.tokens.get(i));                         //The root node is created and the first token (an open parenthesis) is stored as key
		if (!root.getToken().isOpenParenthesis())                                              //Check to see if the first token is effectively an open parenthesis
			throw new SyntaxException (" Expected '(' token at start of line, got "+root.getToken().getString());
		boolean statement=false;                                                               //The variable statement is used to know if a statement declaration has already been given 
		i=recursiveParseExpression (i,root,statement);                                         //statement will be used and updated in this recursive method 
		if (i<this.tokens.size()) {
			throw new SyntaxException (" The expression contains errors causing a premature termination of the program"); //If for any reason the parsing terminates too soon an exception is thrown
		}
		if (root.getToken().isVar()) {                                                         //Then if the statement was a SET the variable is initialized in the variable table
			long a=0;                                                                          
			m.put(root.getToken().getString(),a );
		}
		
		return root;
		
	}
	public int recursiveParseExpression (int i, SyntaxTreeNode s, boolean statement) throws SyntaxException {        //This recursive method is where the production rules check is performed
		if (this.tokens.get(i).isNum()) {                                                                            //it returns an integer which is the index of the tokens array
			return parseNumber(i,s);                                                                                 //If the token at position i is a number it is parsed instantly and i grows by one 
		}
		else 
			if (this.tokens.get(i).isVar()) {                                                                        //The same goes for a variable token
				return parseVariable (i,s);
			}
		else                                                                                                         //If the token is an open parenthesis then a big routine is started
			if (this.tokens.get(i).isOpenParenthesis()) {
				if (!tokens.get(i+1).isStatementDecl() && !this.tokens.get(i+1).isOperator()) {                                              //This first check is dictated by the production rules, in fact after
					throw new SyntaxException (" Expected statement or operator after '(' token, got: "+this.tokens.get(i+1).getString());   //an open parenthesis there must be either an operator or a statement
				}                                                                                                                            //An exception is thrown if this requirement is not fulfilled
				if (this.tokens.get(i+1).isStatementDecl() && !statement) {                                          //Here the method takes care of the first time it encounters an open parenthesis, it is known that
					if (this.tokens.get(i+1).getString().equals("GET")) {                                            //after the first one a statement must be declared and the two cases are handled separately
						statement=true;
						s.setToken((this.tokens.get(i+1)));                                                          //In case of a GET declaration statement is updated to true, the key of the root node is updated 
						i++;                                                                                         //to GET and the method is recalled with index i increased by 2 (needed to get the token after the GET)
						i=recursiveParseExpression (i+1,s,statement);
						
					}
					else {                                                                                           //In case of a SET declaration statement a check is performed to see if the next token is a variable 
						if (this.tokens.get(i+1).getString().equals("SET") && this.tokens.get(i+2).isVar()) {        //an exception is thrown if not
							statement=true;                                                                          //then statement is updated to true, the key of the root node is updated to the variable and 
							s.setToken(this.tokens.get(i+2));                                                        //the method is recalled with index i increased by 3 (needed to get the token after the variable)
							i=i+2;                                                                                   //Recalling the method only once means that the root will only have one child
							i=recursiveParseExpression (i+1,s,statement);
						}
						else 
							throw new SyntaxException (" Expected variable after 'SET' declaration");
					}
				}
				else                                                                                                 //This is where the parsing happens after the first open parenthesis
					if (statement) {
						if (i<this.tokens.size()-1) {                                                                //Check necessary to avoid an index out of bounds exception caused by not respecting the production rules
							if (this.tokens.get(i+1).isOperator() && s.getLeftChild()==null) {                       //For example having "(" ")" as the last two tokens would cause said exception 
								SyntaxTreeNode sl=new SyntaxTreeNode (this.tokens.get(i+1));                         //If the next token is an operator then it checks if a left child for the current node has already been assigned
								sl.setParent(s);                                                                     //if not a new node is created with the operator as key and set as the current node's left child
								s.setLChild(sl);                                                                     //then the method is recalled twice with the new node as a parameter, once for each of the operator's sons
								i=i+2;
								i=recursiveParseExpression(i,sl,statement);
								i=recursiveParseExpression(i,sl,statement);
							}
						}
						if (i<this.tokens.size()-1) {                                                                //A similar routine is performed if only the right child has not been assigned
							if (this.tokens.get(i+1).isOperator() && s.getRightChild()==null) {
								SyntaxTreeNode sr=new SyntaxTreeNode (this.tokens.get(i+1));
								sr.setParent(s);
								s.setRChild(sr);
								i=i+2;
								i=recursiveParseExpression(i,sr,statement);
								i=recursiveParseExpression(i,sr,statement);
							}
						}                                                                                            //As the production rules say after the right child of an operator a closed parenthesis must be present
						if (!this.tokens.get(i).isCloseParenthesis()) {                                              //This checks if this condition is fulfilled, if not an exception is thrown
							System.out.print(i+"");
							throw new SyntaxException (" Expected ')' token at end of line, got"+this.tokens.get(i).getString());
						}	
					}
				if (!statement)                                                                      //A check is performed to see if an operator is given instead of a statement in the first open parenthesis
					throw new SyntaxException(" Expected statement token after '(' token");          //because it is the only case that eludes the early checks after an open parenthesis is recognized
					
			}
		
		else {                                                                                            //If an unknown token is read an exception is thrown
			throw new SyntaxException (" Unexpected token, got:'"+this.tokens.get(i).getString()+"'");
		}
		if (i==this.tokens.size()) {                                                                      //If the tokens array finishes before the method can properly return a value for the first recall
			throw new SyntaxException (" Unexpected end of input");                                       //a value for the first recall an exception is thrown
		}
		return i+1;                                                                                       //When the first call of the method reachs the return line the current token is not parsed
	}                                                                                                     //but since in the Tokenizer class a check for the last character is performed, this does not invalidate the correctness of the algorithm 
	
	public int parseNumber (int i,SyntaxTreeNode s) throws SyntaxException {                                                   //This method covers the parsing of numbers
		if (this.tokens.get(i).getString().charAt(0) == 0 && Character.isDigit(this.tokens.get(i).getString().charAt(1))) {    //A check is performed to see if the number token starts with a 0 but continues (e.g. 05, 00234)
			throw new SyntaxException (" Number must start with a digit different from 0");                                    //in this case an exception is thrown
		}
		if (s.getLeftChild()==null) {                                                                     //Then it checks if the left child is null, if it is a new node is created and its key is 
			SyntaxTreeNode sl = new SyntaxTreeNode(this.tokens.get(i));                                   //initialized as the number, finally it is set as the current node (s is the current node) left child
			s.setLChild(sl);
			sl.setParent(s);
		}
		else                                                                                              //The same routine is applied if only the right child of the current node is null
			if (s.getRightChild()==null) {                                                                //of course the new node will be set as the right child
				SyntaxTreeNode sr = new SyntaxTreeNode(this.tokens.get(i));
				s.setRChild(sr);
				sr.setParent(s);
			}
		return i+1;                                                                                       //The method returns the index of the next Token in the array
	}
	public int parseVariable (int i,SyntaxTreeNode s) throws SyntaxException {                            //This method is identical to parseNumber but is invoked if the current Token is a variable
		if (s.getLeftChild()==null) {
			SyntaxTreeNode sl = new SyntaxTreeNode(this.tokens.get(i));
			s.setLChild(sl);
			sl.setParent(s);                                                                              //Possibile aggregarlo a parseNumber, in questo caso il metodo é ridondante
		}
		else 
			if (s.getRightChild()==null) {
				SyntaxTreeNode sr = new SyntaxTreeNode(this.tokens.get(i));
				s.setRChild(sr);
				sr.setParent(s);
			}
		return i+1;
	}

}
