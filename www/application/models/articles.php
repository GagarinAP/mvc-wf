<?php

class ArticlesModel extends Model{

	function __construct(){
		parent::__construct('articles');
	}
        
        function create($data){
            // prepare data
            $fieldSet = "`user_id`, `title`, `content`, `date_created`";
            $keys = ['user_id', 'title', 'content'];
            $sqlData = [];
            foreach($keys as $key){
                $sqlData[] = $data[$key];
            }
            // sql query
            $sql = "INSERT INTO `{$this->table}` ({$fieldSet}) VALUES (?, ?, ?, NOW()); ";
            return $this->db->insert($sql, $sqlData);
        }
}