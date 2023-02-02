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

        $results = $this->merchantSearch->search($q);
        $results_partial = $this->merchantSearch->searchWildcard($q);
        return JsonResponse::create([
            $this->treeTransformer->toTree($results),
            $this->treeTransformer->toTree($results_partial),
        ]);
    }
}