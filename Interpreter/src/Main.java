import java.io.FileReader;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.util.*;
public class Main {                                                                            //The program is divided in three main sections
	public static void main(String[] args)  {                                                  //The first section is in charge of reading the input from the file and creating "Token" objects 
		if (args.length<1) {                                                                   //The second section parses the array of tokens and controls if the production rules have been respected
			return;                                                                            //The third section is in charge of calculating the value of the expression and dealing with arithmetic errors
		}
		ArrayList<String> statements = new ArrayList<String> (Arrays.asList("GET","SET"));                 //Initially the program stores all the possible values that the non-terminal symbol statement can assume
		ArrayList<String> operators = new ArrayList<String> (Arrays.asList("ADD","SUB","MUL","DIV"));      //Then it stores all the possible operators
		try {                                                                                              
			FileReader fr = new FileReader (args[0]);                                                      //Here the objects in charge of reading the input file are initialized 
			Scanner input=new Scanner(fr);                                                                 //if the input file is not found an exception will be caught
			Map<String,Long> variable_table = new HashMap <String,Long> ();                                //Initialization of the table that will serve as the storage of all the variables introduced by the user in the file
			while (input.hasNextLine()) {                                                                  //This while loop has the only purpose of ensuring that all the file lines are read, if there are no lines then it is skipped
				StringBuilder sb = new StringBuilder();                                                    
				sb.append(input.nextLine());                                                               //The newly read line is stored as a string of characters
				if (sb.length()==0)                                                                        //If the line is blank the program goes to the next iteration
					continue;
				Tokenizer t=new Tokenizer(sb,statements,operators);                                        //The first section of the program is now invoked 
				ArrayList<Token> line = new ArrayList<Token> (t.getTokens());                              //The variable line represents the ordered collection of tokens that were created from the original line 
				/*for (int i=0;i<line.size();i++) {
					System.out.print(line.get(i).getString()+" ");
				}
				System.out.println();*/
				SyntaxParser sp = new SyntaxParser (line);                                                 //Now the program moves to the second section
				SyntaxTreeNode root = sp.getSyntaxTreeRoot(variable_table);                                //After the production rules check a tree containing the tokens is created and its root is returned 
				Evaluator eval = new Evaluator (root, variable_table);                                     //Then the third section is invoked where the program calculates the result and prints it
				long line_result = eval.evaluateResult(root);
				eval.printResult(line_result);
			}
			fr.close();                                                                                    
			input.close();
		}
		catch (FileNotFoundException f) {                                                                  //If meaningful exceptions are caught they are handled 
			System.out.print("ERROR File not found");                                                      //by printing a custom error message and then terminating the program
		}
		catch (IOException i) {
			System.out.print("ERROR "+i.getMessage());
		}
		catch (SyntaxException | EvaluationException s) {
			System.out.print(s);
		}
	

	}

}
