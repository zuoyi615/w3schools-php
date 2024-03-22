<?php

namespace App\Services;

use App\Contracts\SessionInterface;
use App\DataObjects\DataTableQueryParams;
use Psr\Http\Message\ServerRequestInterface as Request;

readonly class RequestService
{

    public function __construct(private SessionInterface $session) {}

    public function getReferer(Request $request): string
    {
        $referer = $request->getHeader('referer')[0] ?? '';
        if (!$referer) {
            return $this->session->get('previousUrl');
        }

        $refererHost = parse_url($referer, PHP_URL_HOST);
        if ($refererHost !== $request->getUri()->getHost()) {
            $referer = $this->session->get('previousUrl');
        }

        return $referer;
    }

    public function isXhr(Request $request): bool
    {
        return $request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest';
    }

    public function getDataTableQueryParameters(Request $request): DataTableQueryParams
    {
        $params = $request->getQueryParams();

        $start    = (int) $params['start'];
        $length   = (int) $params['length'];
        $draw     = (int) $params['draw'];
        $orderBy  = $params['columns'][$params['order'][0]['column']]['data'];
        $orderDir = $params['order'][0]['dir'];
        $search   = $params['search']['value'];

        return new DataTableQueryParams(
            $start,
            $length,
            $orderBy,
            $orderDir,
            $search,
            $draw,
        );
    }

    public function getClientIp(Request $request, array $trustedProxies): ?string
    {
        $serverParams = $request->getServerParams();
        $clientIp     = $serverParams['REMOTE_ADDRESS'];
        $forwarded    = $serverParams['HTTP_X_FORWARDED_FOR'];

        if (in_array($clientIp, $trustedProxies, true) && isset($forwarded)) {
            $ipTable = explode(',', $forwarded);

            return trim($ipTable[0]);
        }

        return $clientIp ?? null;
    }

}
