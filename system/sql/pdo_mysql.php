<?php 
defined('IN_TS') or die('Access Denied.');
 
class MySql {
	
	public $query_count = 0;
	
	public $conn;
	/**
	 * 执行的SQL语句记录
	 */
	public $arrSql;
	/**
	 * exec执行影响行数
	 */
	private $num_rows;
	
	//初始化
	function __construct($DB){
		$dsn='mysql:host='.$DB['host'].';dbname='.$DB['name'];

		try{
			$this->conn = new pdo($dsn,$DB['user'],$DB['pwd'],array(PDO::ATTR_PERSISTENT => true));//持久链接
			$this->query("set names 'utf8'");
		}catch(PDOException $e){
			echo $e->getMessage();
			exit;
		}
	}
	
	//转义数据字符
	function escape($string){
		return $this->conn->quote($string);
	}
	
	/**
	 * 格式化带limit的SQL语句
	 */
	public function setlimit($sql, $limit)
	{
		return $sql. " LIMIT {$limit}";
	}
	
	//进行 updata insert delete 操作,返回行数
	function query($sql){
		$this->arrSql[] = $sql;
		$result = $this->conn->exec($sql);
		if( FALSE !== $result ){
			$this->num_rows = $result;
			return $result;
		}else{
			$poderror = $this->conn->errorInfo();
			qiMsg("{$sql}<br />执行错误: " .$poderror[2]);
		}
		
	}
	
	//查询数据 返回数组
	function fetch_all_assoc($sql){
		$this->conn->setAttribute(PDO::ATTR_CASE,PDO::CASE_LOWER); //改写获取方式为小写字段
		$rows = $this->conn->prepare($sql);
		
		if ($this->conn->errorCode() != 00000){
			$this->error($this->conn->errorInfo());
		}
		
		$rows->execute();
		
		$this->query_count += 1;
		
		$rows->setFetchMode(PDO::FETCH_ASSOC);//是用fetch_assoc 获取方式
		return $rows->fetchAll(); //取出记录
	}
	
	//返回查询结果一条
	function once_fetch_assoc($sql,$symbols = 0){
		$this->conn->setAttribute(PDO::ATTR_CASE,PDO::CASE_LOWER);
		$rows = $this->conn->prepare($sql);
		if ($this->conn->errorCode() != 00000){
			if($symbols == 0){
				$this->error($this->conn->errorInfo());
			}else{return "Error";}
		}
		
		$rows->execute();
		
		$this->query_count += 1;
		$rows->setFetchMode(PDO::FETCH_ASSOC);//是用fetch_assoc 获取方式
		$da = '';
		while($row = $rows->fetch()){
			  $da = $row;
		}
		
		return $da;
	}

	//统计结果集的行数
	function once_num_rows($sql){
		$rows = $this->conn->prepare($sql);
		$rows->execute();
		$num = $rows->rowCount();
		return $num;
	}

	//取得上一步INSERT产生的ID
	function insert_id(){
		return	$this->conn->lastInsertId();
	}
	
	//数组添加
	function insertArr($arrData,$table,$where=''){
		$Item = array();
		foreach($arrData as $key=>$data){
			$Item[] = "$key='$data'";
		}
		$intStr = implode(',',$Item);
		$sql = "insert into $table  SET $intStr $where";
		//echo $sql;
		$this->query("insert into $table  SET $intStr $where");
		return $this->insert_id();
	}
	
	//数组更新(Update)
	function updateArr($arrData,$table,$where=''){
		$Item = array();
		foreach($arrData as $key => $date)
		{
			$Item[] = "$key='$date'";
		}
		$upStr = implode(',',$Item);
		$this->query("UPDATE $table  SET  $upStr $where");
		return true;
	}
	 
	//获取mysql错误
	function geterror(){
		$result = $this->conn->errorInfo();
		return $result[2];
	}
	
	function getMysqlVersion(){
		$Data = $this->once_fetch_assoc("SELECT version( ) AS version");
		return $Data['version'];
	}
	
	/*报错*/
	function error($err){
		$log = "TIME:".date('Y-m-d :H:i:s')."\n";
		$log .= "SQL:".$err."\n";
		$log .= "--------------------------------------\n";
		logging(date('Ymd').'-mysql-error.txt',$log);
	}

}