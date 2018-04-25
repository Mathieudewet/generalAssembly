<?php

use App\Security\CognitoAuthenticator;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Vincent Chalamon <vincent@les-tilleuls.coop>
 */
final class AuthContext implements Context
{
    use ContextTrait;

    /**
     * @Given /^I am authenticated as (?P<email>[A-z\d\-_@\.]+)$/
     */
    public function iAmAuthenticated(string $email)
    {
        $this->featureContext->iAddCookieEqualTo(CognitoAuthenticator::COOKIE_NAME, $email);
    }

    /**
     * @When I get a private resource
     */
    public function iGetAPrivateResource()
    {
        $this->restContext->iAddHeaderEqualTo('Accept', 'application/ld+json');
        $this->restContext->iSendARequestTo(Request::METHOD_GET, '/api/customers');
    }

    /**
     * @When I get a public resource
     */
    public function iGetAPublicResource()
    {
        $this->restContext->iAddHeaderEqualTo('Accept', 'application/ld+json');
        $this->restContext->iSendARequestTo(Request::METHOD_GET, '/api/products');
    }

    /**
     * @Then I am authorized to access this resource
     */
    public function iShouldNotBeForbiddenToAccessThisResource()
    {
        $this->minkContext->assertResponseStatus(200);
    }

    /**
     * @Then I am forbidden to access this resource
     */
    public function iShouldBeForbiddenToAccessThisResource()
    {
        $this->minkContext->assertResponseStatus(403);
    }

    /**
     * @Then I am unauthorized to access this resource
     */
    public function iShouldBeUnauthorizedToAccessThisResource()
    {
        $this->minkContext->assertResponseStatus(401);
    }

    /**
     * @When /^I get the API doc in (?P<format>[A-z]+)$/
     */
    public function iGetTheApiDocInFormat(string $format)
    {
        $this->restContext->iSendARequestTo(Request::METHOD_GET, '/api/docs.'.$format);
    }

    /**
     * @Then /^I see the API doc in (?P<format>[A-z]+)$/
     */
    public function iShouldGetTheApiDocInFormat(string $format)
    {
        $this->minkContext->assertResponseStatus(200);
        switch ($format) {
            case 'json':
                $this->jsonContext->theResponseShouldBeInJson();
                $this->jsonContext->theJsonShouldBeValidAccordingToThisSchema(new PyStringNode([<<<'JSON'
{
    "type": "object",
    "properties": {
        "swagger": {"pattern": "^2.0$"},
        "basePath": {"type": "string"},
        "info": {
            "type": "object",
            "properties": {
                "version": {"type": "string"}
            }
        },
        "paths": {
            "type": "object"
        }
    }
}
JSON
                ], 0));
                break;
            case 'jsonld':
                $this->jsonContext->theResponseShouldBeInJson();
                $this->jsonContext->theJsonShouldBeValidAccordingToThisSchema(new PyStringNode([<<<'JSON'
{
    "type": "object",
    "properties": {
        "@context": {
            "type": "object"
        },
        "@id": {"pattern": "^/api/docs.jsonld$"},
        "@type": {"pattern": "^hydra:ApiDocumentation$"},
        "hydra:entrypoint": {"pattern": "^/api$"},
        "hydra:supportedClass": {
            "type": "array",
            "items": {
                "type": "object",
                "properties": {
                    "@type": {"pattern": "^hydra:Class$"},
                    "hydra:supportedProperty": {
                        "type": "array"
                    }
                }
            }
        }
    }
}
JSON
                ], 0));
                break;
            case 'html':
                $this->jsonContext->theResponseShouldNotBeInJson();
                break;
        }
    }
}
