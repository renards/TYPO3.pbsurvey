<?php
namespace PatrickBroens\Pbsurvey\Validation\ErrorCheck;

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

use PatrickBroens\Pbsurvey\Domain\Model\Item\Abstracts\AbstractQuestion;
use PatrickBroens\Pbsurvey\Validation\Validator;

/**
 * Maximum checked options validation
 */
class ResponsesCheckedMaximum extends AbstractErrorCheck
{
    /**
     * Check if the item has the required maximum responses
     *
     * @param Validator $validator The validator
     * @param AbstractQuestion $item The item
     */
    public function check(
        Validator $validator,
        AbstractQuestion $item
    ) {
        if (
            $item->needsValidator('responsesCheckedMaximum')
            && is_callable([$item, 'getOptionsResponsesMaximum'])
            && is_callable([$item, 'getOptionsResponsesMinimum'])
            && $item->getOptionsResponsesMaximum() > 0
            && $item->getOptionsResponsesMinimum() === 0
        ) {
            $validatorConfiguration = $item->getValidatorConfiguration('responsesCheckedMaximum');

            $responsesCount = 0;

            foreach ($item->getOptionRows() as $optionRow) {
                foreach ($optionRow->getOptions() as $option) {
                    if ($option->getChecked() === true) {
                        $responsesCount++;
                    }
                }
            }

            // Only validate when there are responses, requiredChecked will check on zero
            if (
                $responsesCount !== 0
                && $responsesCount > $item->getOptionsResponsesMaximum()
            ) {
                $validator->didNotValidate();
                $item->addError($this->getErrorMessage(
                    $validatorConfiguration,
                    $item->getOptionsResponsesMaximum()
                ));
            }
        }
    }
}