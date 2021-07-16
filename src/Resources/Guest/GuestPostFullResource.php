<?php

namespace OZiTAG\Tager\Backend\Blog\Resources\Guest;

use OZiTAG\Tager\Backend\Blog\Models\BlogPost;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Fields\FieldFactory;

class GuestPostFullResource extends GuestPostResource
{
    public function getRelatedPostsJson()
    {
        /** @var BlogPost $model */
        $model = $this->resource;

        $result = [];

        $resourceClass = TagerBlogConfig::getShortResourceClass();
        foreach ($model->relatedPosts as $relatedPost) {
            if (!empty($resourceClass)) {
                $result[] = new $resourceClass($relatedPost);
            } else {
                $result[] = new GuestPostResource($relatedPost);
            }
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

            $fieldModel = FieldFactory::create($fieldData['type'], "", $fieldData['meta'] ?? []);
            $type = $fieldModel->getTypeInstance();
            $type->loadValueFromDatabase($value);

            $result[$fieldName] = $type->getPublicValue();
        }

        return $result;
    }


    public function toArray($request)
    {
        /** @var BlogPost $model */
        $model = $this->resource;

        return array_merge(parent::toArray($request), [
            'image' => $model->image ? $model->image->getFullJson() : null,
            'imageMobile' => $model->imageMobile ? $model->imageMobile->getFullJson() : null,
            'body' => $model->body,
            'pageTitle' => $model->getWebPageTitle(),
            'pageDescription' => $model->getWebPageDescription(),
            'openGraphImage' => $model->getWebOpenGraphImageUrl(),
            'relatedPosts' => $this->getRelatedPostsJson(),
            'tags' => $this->tagsArray,
            'additionalFields' => $this->getAdditionalFields()
        ]);
    }
}
