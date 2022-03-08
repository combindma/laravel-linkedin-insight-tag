<?php

namespace Combindma\LinkedinInsightTag;

use Closure;
use Illuminate\Session\Store as Session;

class LinkedinInsightTagMiddleware
{
    protected $linkedinInsightTag;
    protected $session;

    public function __construct(LinkedinInsightTag $linkedinInsightTag, Session $session)
    {
        $this->linkedinInsightTag = $linkedinInsightTag;
        $this->session = $session;
    }

    public function handle($request, Closure $next)
    {
        if ($this->session->has($this->linkedinInsightTag->sessionKey())) {
            $this->linkedinInsightTag->merge($this->session->get($this->linkedinInsightTag->sessionKey()));
        }
        $response = $next($request);

        $this->session->flash($this->linkedinInsightTag->sessionKey(), $this->linkedinInsightTag->getFlashedConversion());

        return $response;
    }
}
