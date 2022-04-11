<?php

namespace Sdkconsultoria\Core\Models\Traits;


trait Field
{
    public function getFields()
    {
        foreach ($this->fields() as $field) {
            # code...
        }
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
