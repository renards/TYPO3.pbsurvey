<?php
namespace PatrickBroens\Pbsurvey\Configuration;

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

use PatrickBroens\Pbsurvey\Domain\Repository\ScoreRepository;
use PatrickBroens\Pbsurvey\Utility\ArrayUtility;
use PatrickBroens\Pbsurvey\Utility\Reflection;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Application configuration populator for content element settings
 */
class ContentElementConfigurationPopulator
{
    /**
     * Populate the application configuration based on settings in the content element
     *
     * @param ApplicationConfiguration $configuration
     * @param array $typoScriptConfiguration The TypoScript configuration
     * @param array $contentObjectConfiguration The content object configuration
     */
    public function populate(
        ApplicationConfiguration $configuration,
        array $typoScriptConfiguration,
        array $contentObjectConfiguration
    )
    {
        $contentElementUid = $contentObjectConfiguration['uid'];

        $contentObjectConfiguration = $this->prepareContentObjectConfiguration($contentObjectConfiguration);

        $reflection = GeneralUtility::makeInstance(Reflection::class, $configuration);
        $properties = $reflection->getProperties(\ReflectionProperty::IS_PROTECTED);

        foreach ($properties as $property) {
            $databaseField = GeneralUtility::camelCaseToLowerCaseUnderscored($property->name);
            $type = $reflection->getPropertyTag($property, 'var');

            if (
                substr($type, -2) !== '[]'
                && is_callable([$configuration, 'set' . ucfirst($property->name)])
            ) {
                $methodName = ucfirst($property->name);
                $setMethod = 'set' . $methodName;
                $getMethod = 'get' . $methodName;

                // Then overwrite with content object configuration
                if (
                    $configuration->$getMethod() === null
                    || (
                        $configuration->$getMethod() !== null
                        && !empty($contentObjectConfiguration[$databaseField])
                    )
                ) {
                    $configuration->$setMethod($contentObjectConfiguration[$databaseField]);
                }
            } else {
                if (
                    $property->name === 'scoring'
                    && (int)$contentObjectConfiguration[$databaseField] > 0
                ) {
                    /** @var ScoreRepository $scoreRepository */
                    $scoreRepository = GeneralUtility::makeInstance(ScoreRepository::class);
                    $configuration->addScorings($scoreRepository->findByContentElement($contentElementUid));
                }
            }
        }
    }

    /**
     * Only get the data specifically for pbsurvey and remove the prefix from the keys
     *
     * @param array $contentObjectConfiguration The content object data
     * @return array
     */
    protected function prepareContentObjectConfiguration(array $contentObjectConfiguration)
    {
        $contentObjectConfiguration = ArrayUtility::filterArrayWhereKeyStartsWithKeyword(
            $contentObjectConfiguration,
            'pbsurvey_'
        );

        return ArrayUtility::removePrefixFromKey($contentObjectConfiguration, 'pbsurvey_');
    }
}