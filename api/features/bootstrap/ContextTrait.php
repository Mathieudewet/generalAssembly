<?php

declare(strict_types=1);

use ApiExtension\Context\ApiContext;
use ApiExtension\Context\FixturesContext;
use Behat\Behat\Context\Environment\InitializedContextEnvironment;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\MinkExtension\Context\MinkContext;
use Behatch\Context\JsonContext;
use Behatch\Context\RestContext;

/**
 * @author Vincent Chalamon <vincent@les-tilleuls.coop>
 */
trait ContextTrait
{
    /**
     * @var RestContext
     */
    private $restContext;

    /**
     * @var MinkContext
     */
    private $minkContext;

    /**
     * @var JsonContext
     */
    private $jsonContext;

    /**
     * @var FixturesContext
     */
    private $fixturesContext;

    /**
     * @var ApiContext
     */
    private $apiContext;

    /**
     * @var FeatureContext
     */
    private $featureContext;

    /**
     * @var AuthContext
     */
    private $authContext;

    /**
     * @BeforeScenario
     */
    public function gatherContexts(BeforeScenarioScope $scope)
    {
        /** @var InitializedContextEnvironment $environment */
        $environment = $scope->getEnvironment();
        $this->restContext = $environment->getContext(RestContext::class);
        $this->minkContext = $environment->getContext(MinkContext::class);
        $this->jsonContext = $environment->getContext(JsonContext::class);
        $this->fixturesContext = $environment->getContext(FixturesContext::class);
        $this->apiContext = $environment->getContext(ApiContext::class);
        $this->featureContext = $environment->getContext(FeatureContext::class);
        $this->authContext = $environment->getContext(AuthContext::class);
    }
}
