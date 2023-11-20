<?php

namespace Shawinigan\Sso\LaravelAzureProvisioning\Controllers;

use Shawinigan\Sso\LaravelAzureProvisioning\SCIM\ResourceType;
use Illuminate\Routing\Controller;

class ResourceTypeController extends Controller
{
    private $resourceTypes = null;

    public function __construct()
    {
        $resourceTypes = [];

        foreach (config('azureprovisioning') as $type => $settings) {
            if (isset($settings['schema'])) {
                $resourceTypes[] = new ResourceType(
                    $settings['singular'],
                    $type,
                    $type,
                    $settings['description'],
                    $settings['schema']
                );
            }
        }

        $this->resourceTypes = collect($resourceTypes);
    }

    public function index()
    {
        return $this->resourceTypes;
    }
}
