<?php

namespace Sdkconsultoria\Core\Fields;

abstract class Field
{
    public bool $visible_on_index = true;

    public bool $visible_on_create = true;

    public bool $visible_on_update = true;

    public bool $visible_on_show = true;

    public string $name;

    public array $rules;

    public string $label;

    public array $searchable;

    public array $filter;

    public bool $can_be_saved = true;

    public static function make(string $name)
    {
        $model = new (get_called_class());
        $model->name = $name;

        return $model;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function label(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function rules(array $rules)
    {
        $this->rules = $rules;

        return $this;
    }

    public function filter($filter)
    {
        return $this;
    }

    public function canBeSaved($can_be_saved)
    {
        $this->can_be_saved = $can_be_saved;

        return $this;
    }

    public function searchable(bool $searchable)
    {
        $this->searchable = $searchable;

        return $this;
    }

    public function getField(): array
    {
        return [
            'component' => $this->component,
            'name' => $this->name,
            'label' => $this->label,
            'rules' => $this->rules,
            'filter' => $this->name,
            'can_be_saved' => $this->can_be_saved,
            'visible_on' => [
                'index' => $this->visible_on_index,
                'update' => $this->visible_on_update,
                'create' => $this->visible_on_create,
                'update' => $this->visible_on_update,
                'show' => $this->visible_on_show,
            ],
        ];
    }

    public function hideOnIndex()
    {
        $this->visible_on_index = false;

        return $this;
    }
}
