<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Kosmo
 *
 * @author Thomas
 */
class Kosmo extends Model {

    function getAll() {
        $stmt = $this->db->query('SELECT * FROM kosmonaut');
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    function getAllSorted($sort, $typ) {
        if (strtolower($typ) == 'desc') {
        $stmt = $this->db->query("SELECT * FROM kosmonaut ORDER BY lower($sort) DESC");
        } else {
            $stmt = $this->db->query("SELECT * FROM kosmonaut ORDER BY lower($sort) ASC");
        }
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    function getKosmo($id) {
        $stmt = $this->db->prepare('SELECT * FROM kosmonaut WHERE idCosmo = :id');
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    function addKosmo($data) {
        $stmt = $this->db->prepare('INSERT INTO kosmonaut '
                . '(jmeno, prijmeni, datum_narozeni, superschopnost)'
                . ' VALUES '
                . '(:first, :last, :birth, :super)');
        $stmt->bindValue(':first', $data['first']);
        $stmt->bindValue(':last', $data['last']);
        $stmt->bindValue(':birth', $data['birth']);
        $stmt->bindValue(':super', $data['super']);
        return $stmt->execute();
    }

    function delKosmo($id) {
        $stmt = $this->db->prepare('DELETE FROM kosmonaut '
                . 'WHERE idCosmo = :id ');
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    function updateKosmo($data, $id) {
        $stmt = $this->db->prepare('UPDATE kosmonaut SET jmeno = :f, prijmeni= :l, datum_narozeni = :d, superschopnost = :s WHERE idCosmo = :id ');
        $stmt->bindValue(':f', $data['first']);
        $stmt->bindValue(':l', $data['last']);
        $stmt->bindValue(':d', $data['birth']);
        $stmt->bindValue(':s', $data['super']);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

}
