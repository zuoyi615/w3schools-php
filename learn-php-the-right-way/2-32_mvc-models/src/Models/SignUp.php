<?php

  namespace MVCModels\Models;

  use PDOException;

  class SignUp extends Model {
    public function __construct(protected User $user, protected Invoice $invoice) {
      parent::__construct();
    }

    public function register(array $user, array $invoice): int {
      try {
        $this->db->beginTransaction();
        $userId    = $this->user->create($user['email'], $user['name']);
        $invoiceId = $this->invoice->create($invoice['amount'], $userId);
        $this->db->commit();
        return $invoiceId;
      } catch (PDOException $e) {
        if ($this->db->inTransaction()) {
          $this->db->rollBack();
        }
        throw new PDOException($e->getMessage(), (int)$e->getCode());
      }
    }
  }
