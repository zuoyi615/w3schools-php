<!doctype html>
<html lang="en" class="dark">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Transactions</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
        tailwind.config = {
          darkMode: 'class',
        }
        </script>
    </head>
    <body class="dark:bg-gray-900 p-4">
        <div class="container mx-auto">
            <table class="border-collapse table-auto w-full text-sm table-auto dark:text-slate-400 shadow">
                <caption class="caption-top text-left dark:text-slate-200 dark:leading-loose mb-2 pl-8 text-2xl">
                    Transactions
                </caption>
                <thead>
                <tr>
                    <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 dark:text-slate-200 text-left">
                        Date
                    </th>
                    <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 dark:text-slate-200 text-left">
                        Check #
                    </th>
                    <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 dark:text-slate-200 text-left">
                        Description
                    </th>
                    <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 dark:text-slate-200 text-left">
                        Amount
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800">
                <?php if (!empty($transactions)): ?>
                    <?php foreach ($transactions as $transaction): ?>
                        <tr>
                            <td class="border-b dark:border-slate-600 p-4 pl-8 dark:text-slate-400">
                                <?= formatDate($transaction['date']) ?>
                            </td>
                            <td class="border-b dark:border-slate-600 p-4 pl-8 dark:text-slate-400">
                                <?= $transaction['checkNumber'] ?: 'N/A' ?>
                            </td>
                            <td class="border-b dark:border-slate-600 p-4 pl-8 dark:text-slate-400">
                                <?= $transaction['description'] ?>
                            </td>
                            <td
                                class="<?php echo 'border-b dark:border-slate-600 p-4 pl-8 '.($transaction['amount'] > 0
                                        ? 'dark:text-pink-700' : 'dark:text-lime-700') ?>">
                                <?= formatDollarAmount($transaction['amount']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="3"
                        class="border-b dark:border-slate-600 p-4 pl-8 dark:text-slate-400 dark:bg-slate-800 text-right">
                        &nbsp;
                    </th>
                    <td class="border-b dark:border-slate-600 p-4 pl-8 dark:text-slate-400 dark:bg-slate-800">&nbsp;
                    </td>
                </tr>
                <tr>
                    <th
                        class="border-b dark:border-slate-600 py-4 pl-8 dark:text-slate-400 dark:bg-slate-800 text-left">
                        Total InCome:
                        <?= $totals->totalIncome ?>
                    </th>
                    <td class="border-b dark:border-slate-600 p-4 pl-8 dark:text-slate-400 dark:bg-slate-800"
                        colspan="3">
                    </td>
                </tr>
                <tr>
                    <th class="border-b dark:border-slate-600 p-4 pl-8 dark:text-slate-400 dark:bg-slate-800 text-left">
                        Total Expense:
                        <?= $totals->totalExpense ?>
                    </th>
                    <td class="border-b dark:border-slate-600 p-4  pl-8 dark:text-slate-400 dark:bg-slate-800"
                        colspan="3">
                    </td>
                </tr>
                <tr>
                    <th class="border-b dark:border-slate-600 p-4 pl-8 dark:text-slate-400 dark:bg-slate-800 text-left">
                        Net Total:
                        <?= $totals->netTotal ?>
                    </th>
                    <td class="border-b dark:border-slate-600 p-4 pl-8 dark:text-slate-400 dark:bg-slate-800"
                        colspan="3">
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </body>
</html>
