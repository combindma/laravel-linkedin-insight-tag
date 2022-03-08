<?php

namespace Combindma\LinkedinInsightTag;

use Illuminate\Support\Traits\Macroable;

class LinkedinInsightTag
{
    use Macroable;

    protected bool $enabled;
    protected string $partnerId;
    protected string $sessionKey;
    protected ConversionLayer $conversionLayer;
    protected ConversionLayer $flashConversionLayer;

    public function __construct()
    {
        $this->enabled = config('linkedin-insight-tag.enabled');
        $this->partnerId = config('linkedin-insight-tag.linkedin_partner_id');
        $this->sessionKey = config('linkedin-insight-tag.sessionKey');
        $this->conversionLayer = new ConversionLayer();
        $this->flashConversionLayer = new ConversionLayer();
    }

    public function partnerId()
    {
        return $this->partnerId;
    }

    public function sessionKey()
    {
        return $this->sessionKey;
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    public function enable()
    {
        $this->enabled = true;
    }

    public function disable()
    {
        $this->enabled = false;
    }

    /**
     * Add event to the event layer.
     *
     */
    public function conversion(int $conversionId)
    {
        $this->conversionLayer->set($conversionId);
    }

    /**
     * Add event data to the event layer for the next request.
     *
     */
    public function flashConversion(int $conversionId)
    {
        $this->flashConversionLayer->set($conversionId);
    }

    /**
     * Merge array data with the event layer.
     *
     */
    public function merge(array $conversionSession)
    {
        $this->conversionLayer->merge($conversionSession);
    }

    /**
     * Retrieve the event layer.
     *
     */
    public function getConversionLayer(): ConversionLayer
    {
        return $this->conversionLayer;
    }

    /**
     * Retrieve the event layer's data for the next request.
     *
     */
    public function getFlashedConversion()
    {
        return $this->flashConversionLayer->toArray();
    }

    public function clear()
    {
        $this->conversionLayer = new ConversionLayer();
    }
}
