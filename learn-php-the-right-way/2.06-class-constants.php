<?php

    declare(strict_types=1);

    namespace Constants;

    use InvalidArgumentException;

    class Transaction
    {
        public const STATUS_PAID     = 'paid';
        public const STATUS_PENDING  = 'pending';
        public const STATUS_DECLINED = 'declined';
        public const ALL_STATUSES
                                     = [ // lookup table
            self::STATUS_PAID     => 'Paid',
            self::STATUS_PENDING  => 'Pending',
            self::STATUS_DECLINED => 'Declined',
          ];

        private string $status;

        public function getStatus(): string
        {
            return $this->status;
        }

        public function __construct()
        {
            // var_dump(self::STATUS_PENDING); // here self, reference to current class
            // echo '<br />';
            $this->status = self::STATUS_PENDING;
        }

        public function setStatus(string $status): self
        {
            if (!isset(self::ALL_STATUSES[$status])) {
                throw new InvalidArgumentException();
            }

            $this->status = $status;
            return $this;
        }
    }

    // echo Transaction::STATUS_PAID;
    // echo '<br />';
    // $transaction = new Transaction();
    // echo $transaction::STATUS_PAID;
    // echo '<br />';
    // echo $transaction::class; // Constants\Transaction

    $transaction = new Transaction();
    // $transaction->setStatus('Hello'); // error
    $transaction->setStatus(Transaction::STATUS_PAID);
    var_dump($transaction->getStatus());
