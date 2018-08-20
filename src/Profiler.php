<?php
declare(strict_types=1);

namespace jp3cki\yii2\feed;

use Yii;

class Profiler
{
    private $token;
    private $category;

    public function __construct(string $token, string $category)
    {
        $this->token = $token;
        $this->category = $category;

        $this->beginProfile();
    }

    public function __destruct()
    {
        $this->endProfile();
    }

    protected function beginProfile(): void
    {
        Yii::beginProfile($this->token, $this->category);
    }

    protected function endProfile(): void
    {
        Yii::endProfile($this->token, $this->category);
    }
}
