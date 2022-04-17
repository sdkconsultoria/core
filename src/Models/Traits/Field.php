<?php

namespace Sdkconsultoria\Core\Models\Traits;


trait Field
{
    public static array $fields = [];

    public function getFields(): array
    {
        if ($this::$fields) {
            return $this::$fields;
        }

        $this::$fields= [];

        foreach ($this->fields() as $index => $field) {
            $this::$fields[$index] = $field->getField();
            $this::$fields[$index]['value'] = $this->{$this::$fields[$index]['name']};
        }

        return $this::$fields;
    }

    public function getIndexFields()
    {
        $fields = [];
        foreach ($this->fields() as $field) {
            if ($field->visible_on_index) {
                $fields[] = $field->name;
            }
        }

        return $fields;
    }
}
