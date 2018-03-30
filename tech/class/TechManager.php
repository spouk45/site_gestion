<?php
class TechManager{
    private $_db;

    public function __construct(PDO $db)
    {
        $this->_db = $db;
    }

    public function getTech($id){
        $where='';
        if($id!=null){
            $where = ' WHERE id=:id';
        }

        $sql='SELECT id,name,firstname FROM tech';
        $sql.=$where;
        $stmnt=$this->_db->prepare($sql);
        if($id!=null){
            $stmnt->bindValue(':id',$id);
        }
        $stmnt->execute();
        $error=$stmnt->errorInfo();

        if($error[0]!=00000){
            throw new Exception($error[2]);
        }
        $data=null;
        $i=0;
        while($row=$stmnt->fetch(PDO::FETCH_ASSOC)) // a finir
        {
            foreach($row as $key=>$value){
                $data[$i][$key]=$row[$key];
            }
            $i++;
        }

        if($data==null){
            throw new Exception('Aucun résultat.');
        }
        return $data;
    }
}