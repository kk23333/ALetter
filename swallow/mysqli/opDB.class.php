<?php
class opDB {
	private $mysqli;
	private $host = "localhost";
	private $root = "root";
	private $password = "960104";
	private $db = "hy";

	function __construct() {
		$this -> mysqli = new mysqli($this -> host, $this -> root, $this -> password, $this -> db);
		if (!$this -> mysqli) {
			die("connect error！" . $this -> mysqli -> connect_error);
		}
		$this -> mysqli -> query("set names 'utf8'");
		$this -> mysqli -> query("set charset set 'utf8'");
	}

	// 只是查询操作
	public function excute_dql($sql) {
		$res = $this -> mysqli -> query($sql) or die($this -> mysqli -> error);
		if ($row = mysqli_fetch_row($res)) {
			return 1;
		} else {
			return -1;
		}
	}
	//查询   数目
	public function excute_num($sql) {
		$res = $this -> mysqli -> query($sql) or die($this -> mysqli -> error);
		return $res;
	}
	}
	//取结果
	public function get_result($sql) {
		$res = $this -> mysqli -> query($sql) or die($this -> mysqli -> error);
		if ($res) {
			return $res;
		} else {
			return -1;
		}
	}

	//增删改操作
	public function excute_dml($sql) {
		$res = $this -> mysqli -> query($sql) or die($this -> mysqli -> error);
		if (!$res) {
			return -1;
		} else {
			if ($this -> mysqli -> affected_rows == 0) {
				return -1;
			} else {
				return 1;
			}
		}
	}
	
	public function get_length($sql){
		$res = $this -> mysqli ->query($sql);
		return $res;
	}

	//关闭自动提交
	function auto_commit() {
		$this -> mysqli -> autocommit(FALSE);
	}

	//确认提交
	function my_commit() {
		$this -> mysqli -> commit();
	}
	//回滚 
	function my_rollback() {
		$this-> mysqli-> rollback();
	}
	//获得最新的id
	function get_id() {
		return $this -> mysqli -> insert_id;
	}

	function for_close() {
		$this -> mysqli -> close();
	}
}
?>