<?php

namespace Shawinigan\Sso\LaravelAzureProvisioning\Resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Shawinigan\Sso\LaravelAzureProvisioning\Exceptions\AzureProvisioningException;

class GroupsResourceType extends ResourceType
{

    /**
     *
     */
    public function createFromSCIM(array $validatedData)
    {
        $model = $this->getModel();
        $name = ($validatedData['displayname']) ?: null;

        if ($name === null) {
            throw (new AzureProvisioningException("name not provided"));
        }

        try {
            $model::findOrCreate($name);
        } catch (QueryException $exception) {
            throw $exception;
        }

        if (isset($validatedData['members'])) {
            foreach ($validatedData['members'] as $member) {
                $user = $this->user()->getModel()::find($member['value']);
                $method = $this->getMemberMappingMethod()[0];

                if (method_exists($user, $method)) {
                    call_user_func([$user, $method], $name);
                }
            }
        }

        return $model::findByName($name);
    }

    public function replaceFromSCIM(array $validatedData, Model $group)
    {
        $groupModel = $this->getModel();

        // Remove all members
        $this->removeMembers($group->users, $group->name);

        if (isset($validatedData['members'])) {
            $this->addMembers($validatedData['members'], $group->name);
            unset($validatedData['members']);
        }

        foreach ($validatedData as $scimAttribute => $scimValue) {
            if (is_array($scimValue)) {
                $array = $this->getMappingForArrayAttribute($scimAttribute, $scimValue);
                $map = $array[0];
                $value = $array[1];
            } else {
                $map = $this->getMappingForAttribute($scimAttribute);
                $value = $scimValue;
            }

            if ($map <> null) {
                if (is_array($map)) {
                    foreach ($map as $key => $attribute) {
                        $group->{$attribute} = $value[$key];
                    }
                } else {
                    $group->{$map} = $scimValue;
                }
            }
        }

        $group->save();

        return $groupModel::findByName($group->name);
    }

    public function patch(array $operation, Model $object)
    {
        switch (strtolower($operation['op'])) {
            case "add":
                if ($operation['path'] === "members" && is_array($operation['value'])) {
                    $this->addMembers($operation['value'], $object->name);
                } else {
                    // This passes MS tests but is very incorrect. An exception should not return a 2xx status code
                    throw (new AzureProvisioningException("Operations value is incorrectly formatted"))->setCode(204);
                }
                break;
            case "remove":
                if (isset($operation['path'])) {
                    if ($operation['path'] === "members") {
                        if (isset($operation['value'])) {
                            $this->removeMembers($operation['value'], $object->name);
                        } else {
                            $this->removeMembers($object->users, $object->name);
                        }
                    }
                } else {
                    throw new AzureProvisioningException("You must provide a \"Path\"");
                }
                break;
            case "replace":
                if (isset($operation['path'])) {
                    $attribute = $this->getMappingForAttribute($operation['path']);
                    $object->{$attribute} = $operation['value'];
                } else {
                    foreach ($operation['value'] as $key => $value) {
                        $attribute = $this->getMappingForAttribute($key);
                        $object->{$attribute} = $value;
                    }
                }
                break;
            default:
                throw new AzureProvisioningException(sprintf('Operation "%s" is not supported', $operation['op']));
        }

        $object->save();

        return $this->getModel()::findByName($object->name);
    }

    public function getMemberMappingMethod()
    {
        return $this->configuration['mapping']['members'];
    }

    private function addMembers($members, $groupName)
    {
        foreach ($members as $member) {
            $user = $this->user()->getModel()::find($member['value']);
            $method = $this->getMemberMappingMethod()[0];

            if (method_exists($user, $method)) {
                call_user_func([$user, $method], $groupName);
            }
        }
    }

    private function removeMembers($members, $groupName)
    {
        foreach ($members as $member) {
            $id = ($member['value']) ?: $member->id;
            $user = $this->user()->getModel()::find($id);
            $method = $this->getMemberMappingMethod()[1];

            if (method_exists($user, $method)) {
                call_user_func([$user, $method], $groupName);
            }
        }
    }
}
