import java.util.*;
public class Evaluator {                                                              //This class is in charge of calculating the result of the expression
	                                                                                  //contained in the syntactical tree
	SyntaxTreeNode root;                                                              //Root of the syntactical tree
	Map <String,Long> table;                                                          //Variable Table
	

	public Evaluator (SyntaxTreeNode r, Map<String,Long> m) {                         //Constructor
		this.root=r;
		this.table=m;
		
	}
	public void printResult (long result) {                                           //Method that covers the printing of the result
		if (this.root.getToken().isVar()) {                                           //It is also responsible of updating the variable table in case of a SET statement
			this.table.put(this.root.getToken().getString(), result);
			System.out.println(this.root.getToken().getString()+" = "+result);
		}
		else
			System.out.println(result);
	}
	public long computeOperation (SyntaxTreeNode s, long l,long r) throws EvaluationException {             //This is the method in charge of doing the mathematical operations
		long result=0;                                                                                      
		this.checkVariablesValid(s);                                                                        //A check is performed to see if the variables that may be contained as children are valid
		long left=0;                                                                                        //Then the variables representing the two operands are initialized
		long right=0;
		if (s.getLeftChild().getToken().isVar_or_Num() && s.getRightChild().getToken().isVar_or_Num()) {    //If both children are variables or numbers, left and right are updated accordingly
			left=getNodeValue(s.getLeftChild());                                                            //by extracting the number value out of the node key string or searching for the variable value
			right=getNodeValue(s.getRightChild());
		}
		else {                                                                                              //If at least one of the child is an operator then the method uses the values that are passed as parameters
			left=l;
			right=r;
		}
		try {                                                                                               //Now the function executes the right operation based on the node key value
			if (s.getToken().getString().equals("ADD")) {                                                   
				result=Math.addExact(left, right);
			}
			if (s.getToken().getString().equals("SUB")) {
				result=Math.subtractExact(left, right);
			}
			if (s.getToken().getString().equals("MUL")) {
				result=Math.multiplyExact(left, right);
			}
			if (s.getToken().getString().equals("DIV")) {
				result=Math.floorDiv(left, right);
			}
			return result;                                                                                   //If no anomaly is detected the result is returned
		}
		catch (ArithmeticException a) {                                                                      //If an ArithemticException is caught it is converted into a custom exception and thrown
			throw new EvaluationException (a.getMessage());
		}
	}
	public long getNodeValue (SyntaxTreeNode s) {                              //This method is in charge of extracting the number value from the node key
		long value=0;
		if (s.getToken().isNum())                                              
			value= Long.parseLong(s.getToken().getString());
		if (s.getToken().isVar())
			value=this.table.get(s.getToken().getString());
		return value;
	}
	public void checkVariablesValid (SyntaxTreeNode s) throws EvaluationException {                                             //This function serves the purpose of checking if any of the variables have yet to be defined 
		                                                                                                                        //If it happens an exception is thrown
		if (s.getLeftChild().getToken().isVar() && !this.table.containsKey(s.getLeftChild().getToken().getString())) {
			throw new EvaluationException ("The variable "+s.getLeftChild().getToken().getString()+" has not been defined");
		}
		if (s.getRightChild().getToken().isVar() && !this.table.containsKey(s.getRightChild().getToken().getString())) {
			throw new EvaluationException ("The variable "+s.getRightChild().getToken().getString()+" has not been defined");
		}
	}
	public long evaluateResult (SyntaxTreeNode s) throws EvaluationException{                                       //Recursive method in charge of visiting the syntactical tree in order to calculate the result of the given expression
		long left=0;                                                                                                //The left and right values representing the operands are initialized as variables
		long right=0;
		if (this.root.equals(s)) {                                                                                  //if the current node is the root of the tree it is known from the SyntaxParser class that it will only have a single child
			s=s.getLeftChild();                                                                                     //the child can be either a number/variable or an operator, so the current node is updated to the child
		}
		if (s.getToken().isVar_or_Num()) {                                                                          //This if block covers the case of the root having a number/variable child (e.g. GET y or GET 12)
			if (s.getToken().isVar() && !this.table.containsKey(s.getToken().getString()))                          //The method checkVariablesValid cannot be used for the root as it would throw a nullPointerException
			  throw new EvaluationException ("The variable "+s.getToken().getString()+" has not been defined");     //A check must then be performed to see if a possible variable would be valid
			else
				return getNodeValue(s);                                                                             //If no anomalies are detected the result is returned and the function stops
		}
		if (!s.getToken().isVar_or_Num()) {                                                                         //In case the current node key is an operator a routine starts
			if (!s.getLeftChild().getToken().isVar_or_Num()) {                                                      //If the left child is an operator the method is recalled with the left child as the parameter
				left=evaluateResult(s.getLeftChild());                                                              //then the value of the operand left is set as the result of the recalled method
			}
			else {                                                                                                  //If the left child is a number/variable then the value is correctly extracted and left is updated
				this.checkVariablesValid(s);
				left=getNodeValue(s.getLeftChild());
			}
			if (!s.getRightChild().getToken().isVar_or_Num()) {                                                     //After the analysis of the left child the same is applied to the right child 
				right=evaluateResult(s.getRightChild());
			}
			else {
				this.checkVariablesValid(s);
				right=getNodeValue(s.getRightChild());
			}                                                                                                       //This approach guarantees that all the operator nodes will be visited
		}
		return this.computeOperation(s, left, right);                                                               
		
	}
}
