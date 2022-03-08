<?php

namespace Combindma\LinkedinInsightTag;

use Exception;
use Illuminate\View\View;

class ScriptViewCreator
{
    protected $linkedinInsightTag;

    public function __construct(LinkedinInsightTag $linkedinInsightTag)
    {
        $this->linkedinInsightTag = $linkedinInsightTag;
    }

    public function create(View $view)
    {
        if ($this->linkedinInsightTag->isEnabled() && empty($this->linkedinInsightTag->partnerId())) {
            throw new Exception('You need to set a LinkedIn Partner ID Id in .env file.');
        }

        if ($this->linkedinInsightTag->isEnabled() && empty($this->linkedinInsightTag->sessionKey())) {
            throw new Exception('You need to set a session key for LinkedIn Insight Tag in .env file.');
        }

        $view
            ->with('enabled', $this->linkedinInsightTag->isEnabled())
            ->with('partnerId', $this->linkedinInsightTag->partnerId())
            ->with('conversionLayer', $this->linkedinInsightTag->getConversionLayer());
    }
}
