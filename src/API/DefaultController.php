<?php

namespace App\API;

use App\Utils\MerchantSearch;
use App\Utils\TreeTransformer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController
{
    private MerchantSearch $merchantSearch;
    private TreeTransformer $treeTransformer;

    public function __construct(MerchantSearch $merchantSearch, TreeTransformer $treeTransformer)
    {
        $this->merchantSearch = $merchantSearch;
        $this->treeTransformer = $treeTransformer;
    }

    /**
     * @Route("/search", name="search_merchant")
     */
    public function actionSearch(Request $request): Response
    {
        if (!$request->query->has('q')) {
            return new Response('', Response::HTTP_BAD_REQUEST);
        }

        $q = $request->query->get('q');

        if (!trim($q)) {
            return JsonResponse::create([]);
        }

        $results = $this->merchantSearch->search($q);
        $limit = 5 - sizeof($results);
        if ($_SERVER['APP_DEBUG'] && $request->query->has('nolimit')) {
            $results_partial = $this->merchantSearch->searchWildcard($q, null);
        } else if ($limit < 1) {
            $results_partial = [];
        } else {
            $results_partial = $this->merchantSearch->searchWildcard($q, $limit);
        }
        return JsonResponse::create([
            "exact" => $this->treeTransformer->toTree($results),
            "partial" => $this->treeTransformer->toTree($results_partial),
        ]);
    }
}