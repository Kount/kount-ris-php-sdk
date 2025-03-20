<?php

class PfConnectivityTest extends \PHPUnit\Framework\TestCase
{
    const MIGRATION_MODE_ENABLED_ENV_NAME = 'MIGRATION_MODE_ENABLED';
    public function testHappyPath()
    {
        // get initial value
        $prev = getenv(self::MIGRATION_MODE_ENABLED_ENV_NAME);

        putenv(self::MIGRATION_MODE_ENABLED_ENV_NAME . '=true');
        $inquiry = (new UtilityHelperTest())->createInquiry();

        // reset to default
        putenv(self::MIGRATION_MODE_ENABLED_ENV_NAME . '=' . $prev);

        $response = $inquiry->getResponse();
        $this->assertEquals(count($response->getErrors()), 0);
    }
}