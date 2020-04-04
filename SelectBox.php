<?php

    abstract class Element {
        protected $tag;
        protected $tagAttributes;
        protected $html;
        protected $value;

        protected function renderOpenTag() {
            $this->html = "<" . $this->tag;

            if (!empty($this->tagAttributes)) {
                $this->html .= " " . implode(" ", $this->tagAttributes);
            }

            $this->html .= ">";
        }

        protected function renderCloseTag() {
            $this->html .= "</" . $this->tag . ">";
        }

        public function setValue($value) {
            $this->value = $value;

            return $this;
        }

        public function setAttribute($attr, $value = null) {
            $newAttribute = $attr;

            if (!is_null($value)) {
                $newAttribute .= "='" . $value . "'";
            }

            $this->tagAttributes[] = $newAttribute;
            return $this;
        }

        abstract public function render();
    }

    class SelectBox extends Element {
        private $options;

        public function __construct() {
            $this->tag = 'select';
        }

        public function setOptions($options) {
            $this->options = $options;
        }

        public function render() {
            $this->renderOpenTag();

            foreach ($this->options as $option) {
                $this->html .= $option->render();
            }

            $this->renderCloseTag();

            return $this->html;
        }
    }

    class Option extends Element {
        public function __construct() {
            $this->tag = 'option';
        }

        public function render() {
            $this->renderOpenTag();
            $this->html .= $this->value;
            $this->renderCloseTag();

            return $this->html;
        }
    }

    $options = [
        (new Option)->setAttribute("value", "test")->setValue("First option"),
        (new Option)->setAttribute("disabled")->setValue("Second option"),
        (new Option)->setAttribute("selected")->setValue("Third option"),
        (new Option)->setAttribute("value", "test")->setValue("Fourth option"),
        (new Option)->setAttribute("value", "test")->setValue("Fifth option")
    ];

    $newSelectBox = new SelectBox();
    $newSelectBox->setOptions($options);
    print_r($newSelectBox->render());