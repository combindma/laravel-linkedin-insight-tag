<?php

namespace Combindma\LinkedinInsightTag\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Combindma\LinkedinInsightTag\LinkedinInsightTag
 */
class LinkedinInsightTag extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Combindma\LinkedinInsightTag\LinkedinInsightTag::class;
    }
}
