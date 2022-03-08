<?php

return [
    /*
     * LinkedIn Partner Id id provided by LinkedIn
     */
    'linkedin_partner_id' => env('LINKEDIN_PARTNER_ID', ''),

    /*
     * The key under which data is saved to the session with flash.
     */
    'sessionKey' => env('LINKEDIN_SESSION_KEY', config('app.name').'_linkedinInsightTag'),

    /*
     * Enable or disable script rendering. Useful for local development.
     */
    'enabled' => env('LINKEDIN_INSIGHT_TAG_ENABLED', false),
];
