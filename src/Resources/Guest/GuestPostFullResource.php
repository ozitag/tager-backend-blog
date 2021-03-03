<?php

namespace OZiTAG\Tager\Backend\Blog\Resources\Guest;

use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Fields\FieldFactory;

class GuestPostFullResource extends GuestPostResource
{
    public function getRelatedPostsJson()
    {
        $result = [];

        foreach ($this->relatedPosts as $relatedPost) {
            $result[] = new GuestPostResource($relatedPost);
        }

        return $result;
    }

    public function getAdditionalFields()
    {
        $result = [];

        $modelFields = $this->fields()->get();

        foreach (TagerBlogConfig::getPostAdditionalFields() as $fieldName => $fieldData) {

            $value = null;
            foreach ($modelFields as $modelField) {
                if ($modelField->field == $fieldName) {
                    $value = $modelField->value;
                    break;
                }
            }

            $fieldModel = FieldFactory::create($fieldData['type'], null, $fieldData['meta'] ?? []);
            $type = $fieldModel->getTypeInstance();
            $type->loadValueFromDatabase($value);

            $result[$fieldName] = $type->getPublicValue();
        }

        return $result;
    }


    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'image' => $this->image ? $this->image->getFullJson() : null,
            'body' => $this->body,
            'pageTitle' => $this->publicPageTitle,
            'pageDescription' => $this->publicPageDescription,
            'openGraphImage' => $this->openGraphImage ? $this->openGraphImage->getFullJson() : null,
            'relatedPosts' => $this->getRelatedPostsJson(),
            'tags' => $this->tagsArray,
            'additionalFields' => $this->getAdditionalFields()
        ]);
    }
}
