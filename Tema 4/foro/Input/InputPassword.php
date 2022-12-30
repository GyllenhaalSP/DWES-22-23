<?php
    namespace Input;

    use Utils\Placeholder, Utils\InputType, Utils\Regex;

    class InputPassword extends Input {
        public function __construct($name, $value, $placeholder = null) {
            $this->type = InputType::PASSWORD->value;
            $this->regex = Regex::PASSWORD->value;
            $this->placeholder = $placeholder;
            parent::__construct($name, $value);
        }

        public function validate() {
            parent::validate();

            if (count($this->error) == 0 && !preg_match($this->regex, $this->value)) {
                $this->error[] = "El campo " . ucfirst($this->name) . " no tiene un valor válido";
            }
        }

        public function printInput() { ?>
            <label class="form__label">
                <?= ucfirst($this->name) ?>:
                <input required class="form__input" type="<?= $this->type ?>" name="<?= $this->name ?>" placeholder="<?= $this->placeholder ?>">
                <?= parent::printErrors() ?>
            </label>
        <?php }
    }
?>