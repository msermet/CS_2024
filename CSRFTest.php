<?php

use PHPUnit\Framework\TestCase;

class CSRFTest extends TestCase
{
    protected function setUp(): void
    {
        session_start();
        $_SESSION = [];
    }

    public function testGenereCSRFInitial()
    {
        $token = genereCSRF();
        $this->assertNotEmpty($token, "CSRF token should be generated for a new session.");
        $this->assertIsString($token, "CSRF token should be a string.");
        $this->assertArrayHasKey("CSRF", $_SESSION, "CSRF session variable should be set.");
        $this->assertCount(1, $_SESSION["CSRF"], "CSRF session should contain one token.");
    }

    public function testGenereCSRFReuse()
    {
        $token1 = genereCSRF();
        $token2 = genereCSRF();
        $this->assertSame($token1, $token2, "CSRF token should be reused if not used.");
    }

    public function testGenereCSRFAfterUsage()
    {
        $token1 = genereCSRF();
        verifierCSRF($token1);
        $token2 = genereCSRF();
        $this->assertNotSame($token1, $token2, "New CSRF token should be generated after usage.");
        $this->assertCount(2, $_SESSION["CSRF"], "CSRF session should contain two tokens.");
    }

    public function testGenereChampHiddenCSRF()
    {
        $hiddenField = genereChampHiddenCSRF();
        $this->assertStringContainsString('type="hidden"', $hiddenField, "Hidden field should contain CSRF token.");
        $this->assertStringContainsString('name="CSRF"', $hiddenField, "Hidden field should have name 'CSRF'.");
    }

    public function testGenereVarHrefCSRF()
    {
        $hrefVar = genereVarHrefCSRF();
        $this->assertStringStartsWith('&CSRF=', $hrefVar, "Href variable should start with '&CSRF='.");
    }

    public function testVerifierCSRFValid()
    {
        $token = genereCSRF();
        $isValid = verifierCSRF($token);
        $this->assertTrue($isValid, "CSRF token should be valid.");
        $this->assertEquals(1, $_SESSION["CSRF"][0]["nbUsage"], "CSRF token usage count should be incremented.");
    }

    public function testVerifierCSRFInvalid()
    {
        $isValid = verifierCSRF('invalid_token');
        $this->assertFalse($isValid, "CSRF token should be invalid.");
    }

    public function testDireIsReload()
    {
        $token1 = genereCSRF();
        verifierCSRF($token1);
        $token2 = genereCSRF();
        $this->assertFalse(direIsReload(), "Page should not be a reload.");

        verifierCSRF($token2);
        $token3 = genereCSRF();
        $this->assertTrue(direIsReload(), "Page should be a reload after second usage of token.");
    }
}