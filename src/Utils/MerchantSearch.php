<?php

namespace App\Utils;

use Elastica\Query\BoolQuery;
use Elastica\Query\Term;
use Elastica\Query\Wildcard;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;

class MerchantSearch
{
    private PaginatedFinderInterface $finder;

    public function __construct(PaginatedFinderInterface $finder)
    {
        $this->finder = $finder;
    }

    public function search($keyword): array
    {
        return $this->finder->find($keyword);
    }

    public function searchWildcard($keyword, $limit): array
    {
        $term = new Wildcard('name', $keyword . '*');

        $termNot = new Term();
        $termNot->setTerm('name', $keyword);

        $bool = new BoolQuery();
        $bool->addMust($term);
        $bool->addMustNot($termNot);

        return $this->finder->find($bool, $limit);
    }
}