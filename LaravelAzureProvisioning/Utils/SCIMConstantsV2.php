<?php

namespace Shawinigan\Sso\LaravelAzureProvisioning\Utils;

abstract class SCIMConstantsV2
{
    const SCHEMA_USER = 'urn:ietf:params:scim:schemas:core:2.0:User';
    const SCHEMA_ENTERPRISE_USER = 'urn:ietf:params:scim:schemas:extension:enterprise:2.0:User';
    const SCHEMA_GROUP = 'urn:ietf:params:scim:schemas:core:2.0:Group';
    const SCHEMA_SERVICE_PROVIDER_CONFIG = 'urn:ietf:params:scim:schemas:core:2.0:ServiceProviderConfig';
    const SCHEMA_RESOURCE_TYPE = 'urn:ietf:params:scim:schemas:core:2.0:ResourceType';
    const SCHEMA_SCHEMA = 'urn:ietf:params:scim:schemas:core:2.0:Schema';

    const SCHEMA_ERROR = 'urn:ietf:params:scim:api:messages:2.0:Error';

    const MESSAGE_BULK_REQUEST = 'urn:ietf:params:scim:api:messages:2.0:BulkRequest';
    const MESSAGE_BULK_RESPONSE = 'urn:ietf:params:scim:api:messages:2.0:BulkResponse';
    const MESSAGE_PATCH_OP = 'urn:ietf:params:scim:api:messages:2.0:PatchOp';
    const MESSAGE_LIST_RESPONSE = 'urn:ietf:params:scim:api:messages:2.0:ListResponse';
    const MESSAGE_SEARCH_REQUEST = 'urn:ietf:params:scim:api:messages:2.0:SearchRequest';
}
