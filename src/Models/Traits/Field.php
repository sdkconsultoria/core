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

        foreach ($this->fields() as $field) {
            $this::$fields[] = $field->getField();
        }

        return $this::$fields;
    }

    public function getIndexFields()
    {
        $fields = [];
        foreach ($this->fields() as $field) {
            if ($field->visible_on_index) {
                $fields[] = $field->field;
            }
        }

        return $fields;
    }
}
