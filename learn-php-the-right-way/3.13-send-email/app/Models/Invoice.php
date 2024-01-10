<?php

  declare(strict_types=1);

  namespace SendEmail\Models;

  use SendEmail\Enums\InvoiceStatus;
  use SendEmail\Model;
  use PDO;

  class Invoice extends Model {
    public function all(InvoiceStatus $status): array {
      $stmt = $this->db->prepare(
        'SELECT id, invoice_number, amount, status
             FROM invoices
             WHERE status = ?'
      );

      $stmt->execute([$status->value]);

      return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
  }
