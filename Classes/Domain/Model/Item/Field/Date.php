<?php
namespace PatrickBroens\Pbsurvey\Domain\Model\Item\Field;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Date trait
 */
trait Date
{
    /**
     * Default date
     *
     * @var int
     */
    protected $dateDefault;

    /**
     * Maximum date
     *
     * @var int
     */
    protected $dateMaximum;

    /**
     * Minimum date
     *
     * @var int
     */
    protected $dateMinimum;

    /**
     * Get the default date
     *
     * @return int
     */
    public function getDateDefault()
    {
        return $this->dateDefault;
    }

    /**
     * Set the default date
     *
     * @param int $dateDefault The date
     */
    public function setDateDefault($dateDefault)
    {
        $this->dateDefault = (int)$dateDefault;
    }

    /**
     * Get the maximum date
     *
     * @return int
     */
    public function getDateMaximum()
    {
        return $this->dateMaximum;
    }

    /**
     * Set the maximum date
     *
     * @param int $dateMaximum The maximum date
     */
    public function setDateMaximum($dateMaximum)
    {
        $this->dateMaximum = (int)$dateMaximum;
    }

    /**
     * Get the minimum date
     *
     * @return int
     */
    public function getDateMinimum()
    {
        return $this->dateMinimum;
    }

    /**
     * Set the minimum date
     *
     * @param int $dateMinimum The minimum date
     */
    public function setDateMinimum($dateMinimum)
    {
        $this->dateMinimum = (int)$dateMinimum;
    }
}