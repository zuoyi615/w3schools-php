<?php

  namespace MVCModels\Models;

  class Invoice extends Model {
    public function create(float $amount, int $userId): int {
      $query = 'INSERT INTO invoices (amount, user_id) VALUES (?, ?)';
      $stmt  = $this->db->prepare($query);
      $stmt->execute([$amount, $userId]);
      return (int)$this->db->lastInsertId();
    }

    public function find(int $id): array {
      $query = 'SELECT i.id,i.amount,u.full_name 
                FROM invoices i
                LEFT JOIN users u on u.id = i.user_id
                WHERE i.id=?';
      $stmt  = $this->db->prepare($query);
      $stmt->execute([$id]);
      $invoice = $stmt->fetch();
      return $invoice ?? [];
    }
  }
