<?php
namespace PatrickBroens\Pbsurvey\Domain\Model;

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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use PatrickBroens\Pbsurvey\Utility\Reflection;

/**
 * Abstract
 */
class AbstractModel
{
    /**
     * The uid
     *
     * @var int
     */
    protected $uid;

    /**
     * Get the uid
     *
     * @return int The uid
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Set the uid
     *
     * @param int $uid The uid
     */
    public function setUid($uid)
    {
        $this->uid = (int)$uid;
    }

    /**
     * Fill the model based on the database record
     *
     * @param array $record The database record
     */
    public function fill(array $record)
    {
        $reflection = GeneralUtility::makeInstance(Reflection::class, get_class($this));
        $properties = $reflection->getProperties(\ReflectionProperty::IS_PROTECTED);

        foreach ($properties as $property) {

            $databaseField = GeneralUtility::camelCaseToLowerCaseUnderscored($property->name);
            $type = $reflection->getPropertyTag($property, 'var');
            if (substr($type, -2) === '[]') {
                $type = 'array';
            }

            if (isset($record[$databaseField]) && $type !== 'array') {
                settype($record[$databaseField], $type);
                $this->{$property->name} = $record[$databaseField];
            }
        }
    }
}