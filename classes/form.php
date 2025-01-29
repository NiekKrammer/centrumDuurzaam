<?php

trait FormTrait {
    public function createForm() {
        $newFields = array_merge($this->fields, [["name" => "submit", "formatted" => "Submit form", "label" => null, "type" => "submit"]]);

        foreach ($newFields as $field) {
            if (!empty($field["html"])) {
                echo $field["html"];
            } else {
                $label = $field['label'];
                $name = $field['name'];
                echo "<label>$label</label><br>
                <label class='errorMessage' id='{$name}Error'></label>";
                if (!empty($field["value"])) {
                    $value = $field["value"];
                    echo "<input type='$name' name='$name' value='$value'></input><br>";
                } else {
                    echo "<input type='$name' name='$name'></input><br>";
                }
            }
        }
    }
}