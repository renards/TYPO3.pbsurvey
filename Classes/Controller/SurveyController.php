<?php
namespace PatrickBroens\Pbsurvey\Controller;

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

use PatrickBroens\Pbsurvey\Provider\Configuration\ConfigurationProvider;
use PatrickBroens\Pbsurvey\Provider\Element\PageProvider;
use PatrickBroens\Pbsurvey\Provider\User\UserProvider;
use TYPO3\CMS\Core\Http\ServerRequest;

/**
 * Survey controller
 */
class SurveyController extends AbstractController
{
    /**
     * The page provider
     *
     * @var PageProvider
     */
    protected $pages;

    /**
     * The server request
     *
     * @var ServerRequest
     */
    protected $serverRequest;

    /**
     * The user provider
     *
     * @var UserProvider
     */
    protected $user;

    /**
     * Constructor
     *
     * @param ServerRequest $serverRequest The server request
     * @param ConfigurationProvider $configuration The configuration provider
     * @param PageProvider $pages The page provider
     * @param UserProvider $user The user provider
     */
    public function __construct(
        ServerRequest $serverRequest,
        ConfigurationProvider $configuration,
        PageProvider $pages,
        UserProvider $user
    )
    {
        $this->serverRequest = $serverRequest;
        $this->pages = $pages;
        $this->user = $user;

        parent::__construct($configuration);
    }

    /**
     * Display the survey
     *
     * @return string The rendered view
     */
    public function indexAction()
    {

        $this->view->setTemplate('Survey');
        return $this->view->render();
    }
}