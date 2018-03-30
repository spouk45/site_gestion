<?php

class FournisseurManager  extends Generic{


    public function addFournisseur(Fournisseur $Fournisseur){

       // $id=$Fournisseur->getId();
        $name=$Fournisseur->getName();
        $data['name']=$name;

        // ---- rechercher si pas d�j� existant ---
        $free=$this->getFournisseur($data,'');
        if($free!=null){throw new Exception('Nom d�j� existant dans la base.');}

            $sql = 'INSERT INTO fournisseur (name)
              VALUES (:name)';
            $stmnt = $this->_db->prepare($sql);
            $stmnt->bindParam(':name', $name);
            $stmnt->execute();

            $error = $stmnt->errorInfo();
            if ($error[0] != 00000) {
                throw new Exception($error[2]);
            }
            if ($stmnt->rowCount() == 0) {
                throw new Exception('L\'enregistrement semble avoir �chou�.');
            }
    }

    public function updateFournisseur(Fournisseur $Fournisseur){
        $id=$Fournisseur->getId();
        $name=$Fournisseur->getName();

        // ---- rechercher si pas d�j� existant ---
        $data['name']=$name;
        $free=$this->getFournisseur($data,'');
        if($free!=null){throw new Exception('Nom d�j� existant dans la base.');}

        $sql = 'UPDATE fournisseur SET name=:name
                WHERE id=:id';
        $stmnt = $this->_db->prepare($sql);
        $stmnt->bindValue(':id', $id);
        $stmnt->bindValue(':name', $name);
        $stmnt->execute();
        $error = $stmnt->errorInfo();
        if ($error[0] != 00000) {
            throw new Exception($error[2]);
        }
        if ($stmnt->rowCount() == 0) {
            throw new Exception('La mise a jout semble avoir �chou�.');
        }
    }

    public function deleteFournisseur($id){
        if (!is_numeric($id)) {
            throw new Exception('id doit etre numeric');
        }
        $sql = 'DELETE FROM fournisseur WHERE id=:id';
        $stmnt = $this->_db->prepare($sql);
        $stmnt->bindParam(':id', $id);
        $stmnt->execute();
        $error = $stmnt->errorInfo();
        if ($error[0] != 00000) {
            throw new Exception($error[2]);
        }
        if ($stmnt->rowCount() == 0) {
            throw new Exception('La suppression semble avoir �chou�.');
        }
    }

}