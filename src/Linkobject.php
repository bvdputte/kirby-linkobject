<?php

namespace bvdputte\Linkobject;

use Kirby\Http\Url;
use Kirby\Toolkit\A;
use Kirby\Toolkit\Str;

class Linkobject
{
    protected $obj;

    public function __construct($field)
    {
        $this->obj = $field->toObject();
    }

    public function __call($name, $arguments = [])
    {
        return (in_array($name, array_keys($this->obj->toArray()))) ? $this->obj->$name() : null;
    }

    public function __toString()
    {
        return $this->tag();
    }

    public function linkType()
    {
        // Grabbed from https://github.com/tobimori/kirby-spielzeug/blob/main/config/fieldMethods.php#L10
        $val = $this->obj->link()->value();
        if (empty($val)) return 'custom';

        if (Str::match($val, '/^(http|https):\/\//')) {
            return 'url';
        }

        if (Str::startsWith($val, 'page://') || Str::startsWith($val, '/@/page/')) {
            return 'page';
        }

        if (Str::startsWith($val, 'file://') || Str::startsWith($val, '/@/file/')) {
            return 'file';
        }

        if (Str::startsWith($val, 'tel:')) {
            return 'tel';
        }

        if (Str::startsWith($val, 'mailto:')) {
            return 'email';
        }

        if (Str::startsWith($val, '#')) {
            return 'anchor';
        }

        return 'custom';
    }

    public function linkText()
    {
        $obj = $this->obj;

        // Prioritize overriden linkText
        if (
            ($obj->haslinktext()->toBool()) &&
            ($obj->linktext()->isNotEmpty())
        ) {
            return $obj->linktext();
        }

        // More sensible defaults
        // Inspiration: https://github.com/tobimori/kirby-spielzeug/blob/6d9ebb6cc7de4826ac47c66e525123b2de20a670/config/fieldMethods.php#L43
        $linkField = $obj->link();
        $linkVal = $obj->link()->value();
        $type = $this->linkType();

        switch ($type) {
            case 'url':
                return Url::short($linkVal);
            case 'page':
                $page = $linkField->toPage();
                if ($page) return $page->title();
            case 'file':
                $file = $linkField->toFile();
                if ($file) return $file->filename();
            case 'email':
                return Str::replace($linkVal, 'mailto:', '');
            case 'tel':
                return Str::replace($linkVal, 'tel:', '');
            default:
                return $linkVal;
        };
      }

    public function tag($options = [])
    {
        return snippet('linkobject/tag', A::merge(['linkObject' => $this, 'linkObjectFields' => $this->obj], $options), $return = true);
    }
}
