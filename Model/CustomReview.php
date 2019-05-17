<?php


namespace Netzexpert\RandomReview\Model;

use Magento\Review\Model\Rating\Option\Vote;
use Magento\Review\Model\ResourceModel\Rating\Option\Vote\Collection;
use Magento\Review\Model\ResourceModel\Rating\Option\Vote\CollectionFactory;
use Magento\Review\Model\Review;
use Magento\Review\Model\ReviewFactory;

class CustomReview
{
    /** @var CollectionFactory  */
    private $votesCollectionFactory;

    /** @var ReviewFactory  */
    private $reviewFactory;

    /**
     * CustomReview constructor.
     * @param CollectionFactory $votesCollectionFactory
     * @param ReviewFactory $reviewFactory
     */
    public function __construct(
        CollectionFactory $votesCollectionFactory,
        ReviewFactory $reviewFactory
    ) {
        $this->votesCollectionFactory = $votesCollectionFactory;
        $this->reviewFactory          = $reviewFactory;
    }

    /**
     * @return Collection
     */
    public function getRandomVotes()
    {
        /** @var Collection $collection */
        $collection = $this->votesCollectionFactory->create();
        $collection->join(
            ['review' => $collection->getTable('review')],
            'main_table.review_id = review.review_id',
            'status_id'
        )->addFieldToFilter('value', ['gteq' => 4])
            ->addFieldToFilter('review.status_id', ['eq' => '1']);
        $collection->getSelect()->orderRand()->limitPage(1,3);

        return $collection;
    }

    /**
     * @param $reviewId
     * @return Review
     */
    public function getReview($reviewId)
    {
        /** @var Review $review */
        $review = $this->reviewFactory->create()->load($reviewId);

        return $review;
    }
}