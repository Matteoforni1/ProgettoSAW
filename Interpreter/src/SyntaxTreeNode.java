
public class SyntaxTreeNode {                                 //Object representing a node of the syntactical tree that the parser creates
	Token key;                                                //The key of the node, with the exception of the root it can be either an operator, a number or a variable 
	SyntaxTreeNode parent;                                    //The other attributes indicate respectively the parent, the left child and the right child
	SyntaxTreeNode Lchild;                                    //Using this production rules every tree node except the root will have either 2 or 0 sons 
	SyntaxTreeNode Rchild;                                    //An operator node will have 2 sons while a number or variable 0
	
	public SyntaxTreeNode (Token k) {                         //Constructor
		this.key= new Token (k);
		this.parent=null;                                     //Sets every related node to null by default
		this.Lchild=null;
		this.Rchild=null;
	}
	public void setToken (Token k) {                          //Setter
		this.key=k;
	}
	public void setParent (SyntaxTreeNode s) {
		this.parent=s;
	}
	public void setLChild (SyntaxTreeNode s) {
		this.Lchild=s;
	}
	public void setRChild (SyntaxTreeNode s) {
		this.Rchild=s;
	}
	public Token getToken () {                                //Getter
		return this.key;
	}
	public SyntaxTreeNode getParent () {
		return this.parent;
	}
	public SyntaxTreeNode getLeftChild () {
		return this.Lchild;
	}
	public SyntaxTreeNode getRightChild () {
		return this.Rchild;
	}

}
