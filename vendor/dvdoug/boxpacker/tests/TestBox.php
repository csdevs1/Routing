<?php
/**
 * Box packing (3D bin packing, knapsack problem)
 * @package BoxPacker
 * @author Doug Wr
 ight
 */

namespace DVDoug\BoxPacker\Test;

use DVDoug\BoxPacker\Box;

class TestBox implements Box
{

    /**
     * @var string
     */
    public $reference;

    /**
     * @var int
     */
    public $outerWidth;

    /**
     * @var int
     */
    public $outerLength;

    /**
     * @var int
     */
    public $outerDepth;

    /**
     * @var int
     */
    public $emptyWeight;

    /**
     * @var int
     */
    public $innerWidth;

    /**
     * @var int
     */
    public $innerLength;

    /**
     * @var int
     */
    public $innerDepth;

    /**
     * @var int
     */
    public $maxWeight;

    /**
     * @var int
     */
    public $innerVolume;

    /**
     * TestBox constructor.
     *
     * @param string $reference
     * @param int $outerWidth
     * @param int $outerLength
     * @param int $outerDepth
     * @param int $emptyWeight
     * @param int $innerWidth
     * @param int $innerLength
     * @param int $innerDepth
     * @param int $maxWeight
     */
    public function __construct(
        $reference,
        $outerWidth,
        $outerLength,
        $outerDepth,
        $emptyWeight,
        $innerWidth,
        $innerLength,
        $innerDepth,
        $maxWeight
    ) {
        $this->reference = $reference;
        $this->outerWidth = $outerWidth;
        $this->outerLength = $outerLength;
        $this->outerDepth = $outerDepth;
        $this->emptyWeight = $emptyWeight;
        $this->innerWidth = $innerWidth;
        $this->innerLength = $innerLength;
        $this->innerDepth = $innerDepth;
        $this->maxWeight = $maxWeight;
        $this->innerVolume = $this->innerWidth * $this->innerLength * $this->innerDepth;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @return int
     */
    public function getOuterWidth()
    {
        return $this->outerWidth;
    }

    /**
     * @return int
     */
    public function getOuterLength()
    {
        return $this->outerLength;
    }

    /**
     * @return int
     */
    public function getOuterDepth()
    {
        return $this->outerDepth;
    }

    /**
     * @return int
     */
    public function getEmptyWeight()
    {
        return $this->emptyWeight;
    }

    /**
     * @return int
     */
    public function getInnerWidth()
    {
        return $this->innerWidth;
    }

    /**
     * @return int
     */
    public function getInnerLength()
    {
        return $this->innerLength;
    }

    /**
     * @return int
     */
    public function getInnerDepth()
    {
        return $this->innerDepth;
    }

    /**
     * @return int
     */
    public function getInnerVolume()
    {
        return $this->innerVolume;
    }

    /**
     * @return int
     */
    public function getMaxWeight()
    {
        return $this->maxWeight;
    }
}
