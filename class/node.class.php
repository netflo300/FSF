<?php
class Node {
	private $value;
	private $listOfNode;
	
	public function __construct( $value) {
		$this->value = $value;
		$listOfNode = array();
	}
	
	public function addChildNode($node) {
		$this->listOfNode[$node->value] = $node;
	}
	
	public function explore(&$listSaw) {
		global $db;
		$db->query("SELECT id_step_target FROM fsf_step_link WHERE id_step_origin ='".$this->value."' ;");
		if($db->get_num_rows() > 0) {
			foreach($db->fetch_array() as $k => $v) {
				//echo 'Node courant '.$this->value . ' - Noeud suivant : ' . $v['id_step_target']."\n";
				$newNode = new Node($v['id_step_target']);
				$this->addChildNode($newNode);
				if(!key_exists($v['id_step_target'], $listSaw)) {
					$listSaw[$v['id_step_target']] = 1;
					$newNode->explore($listSaw);
				} else {
					$newNode->listOfNode = 'R';
				}
			}
		}
	}
	
}