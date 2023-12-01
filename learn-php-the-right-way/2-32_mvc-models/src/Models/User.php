<?php

  namespace MVCModels\Models;

  class User extends Model {
    public function create(string $email, string $name, bool $isActive = true): int {
      $query = 'INSERT INTO users ( email, full_name, is_active, create_at) VALUES (?,?,?,NOW())';
      $stmt  = $this->db->prepare($query);
      $stmt->execute([$email, $name, $isActive]);
      return (int)$this->db->lastInsertId();
    }
  }
