<?php
namespace Netzexpert\RandomReviewCheckout\Block;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Filter\FilterManager;
use Magento\Framework\View\Element\Template;
use Magento\Review\Model\Rating\Option\Vote;
use Magento\Review\Model\ResourceModel\Rating\Option\Vote\Collection;
use Magento\Review\Model\Review;
use Netzexpert\RandomReviewCheckout\Model\CustomReview;

class View extends Template
{
    /** @var CustomReview  */
    private $reviewModel;

    /** @var Review */
    private $review;

    /** @var Collection */
    private $votes;

    /** @var FilterManager */
    protected $filterManager;

    private $productRepository;

    /**
     * View constructor.
     * @param Template\Context $context
     * @param CustomReview $customReview
     */
    public function __construct(
        Template\Context $context,
        CustomReview $customReview,
        FilterManager $filterManager,
        ProductRepository $productRepository
    ) {
        $this->reviewModel = $customReview;
        $this->filterManager = $filterManager;
        $this->productRepository = $productRepository;
        parent::__construct($context);
    }

    public function getVotes() {
        if (!$this->votes) {
            $this->votes = $this->reviewModel->getRandomVotes();
        }
        return $this->votes;
    }

    /**
     * @param Vote $vote
     * @return Review
     */
    public function getReview($vote)
    {
        return $this->reviewModel->getReview($vote->getData('review_id'));
    }

    /**
     * @param string $string
     * @param int $lenght
     * @return string
     */
    public function getTruncateReview($string, $lenght = 90)
    {
        return $this->filterManager->truncate($string, ['length' => $lenght]);
    }

    /**
     * @param Review $review
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProductUrl($review)
    {
        $productId = $review->getEntityPkValue();
        /** @var Product $product */
        $product = $this->productRepository->getById($productId);
        return $product->getProductUrl();
    }


}