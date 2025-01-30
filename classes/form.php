<?php

trait FormTrait {
    public function createForm() {
        // Merge een submit button
        $newFields = array_merge($this->fields, [["name" => "submit", "formatted" => "Submit form", "label" => null, "type" => "submit"]]);

        // Loop door alle heen
        foreach ($newFields as $field) {
            // Check of er al predefined html in zit
            if (!empty($field["html"])) {
                echo $field["html"];
            } else {
                $label = $field['label'];
                $name = $field['name'];
                // Voeg een required ster toe behalve aan de submit
                if ($field['type'] !== "submit") {
                    echo "<label>$label <span style='color: red;'>*</span></label><br>";
                } else {
                    echo "<label>$label</label><br>";
                }
                // Voeg error message toe voor lokale error messages
                echo "<label class='errorMessage' id='{$name}Error'></label>";
                // Check of er al een predefined value is, zo ja zet dat er in
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