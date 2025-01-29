<?php

trait FormTrait {
    public function createForm() {
        $newFields = array_merge($this->fields, [["name" => "submit", "formatted" => "Submit form", "label" => null, "type" => "submit"]]);

        foreach ($newFields as $field) {
            $label = $field['label'];
            $name = $field['name'];
            echo "<label>$label</label>
            <label class='errorMessage' id='{$name}Error'></label>
            <input type='$name' name='$name'></input>";
        }
    }
}