<?php

declare(strict_types=1);

namespace App\Controllers;

use App\ResponseFormatter;
use App\Services\CategoryService;
use App\Services\TransactionService;
use DateTime;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

readonly class HomeController
{
    
    public function __construct(
        private Twig               $twig,
        private TransactionService $transactionService,
        private CategoryService    $categoryService,
        private ResponseFormatter  $responseFormatter
    ) {}
    
    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function index(Response $response): Response
    {
        $startDate             = DateTime::createFromFormat('Y-m-d', date('Y-m-01'));
        $endDate               = new DateTime('now');
        $totals                = $this->transactionService->getTotals($startDate, $endDate);
        $recentTransactions    = $this->transactionService->getRecentTransactions(10);
        $topSpendingCategories = $this->categoryService->getTopSpendingCategories(4);
        
        return $this->twig->render(
            $response,
            'dashboard.twig',
            [
                'totals'                => $totals,
                'transactions'          => $recentTransactions,
                'topSpendingCategories' => $topSpendingCategories,
            ]
        );
    }
    
    public function getYearToDateStatistics(Response $response): Response
    {
        $data = $this->transactionService->getMonthlySummary((int)date('Y'));
        
        return $this->responseFormatter->asJson($response, $data);
    }
    
}
