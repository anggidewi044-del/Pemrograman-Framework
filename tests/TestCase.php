<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();

        $compiledViews = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'eventrize-test-views';
        if (!is_dir($compiledViews)) {
            mkdir($compiledViews, 0777, true);
        }
        config(['view.compiled' => $compiledViews]);
    }
}
