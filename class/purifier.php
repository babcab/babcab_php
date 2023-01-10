<?php

class Purifier {
    public function __construct ($data) {
        $this->data = $data;
    }

    public function start ($obj) {
        try {
            $this->obj = $obj;

            $this->checkExists();

            $this->setValues();

            $this->checkIsEmpty();

            $this->filterText();

            if ($this->obj['type'] == 'boolean') {
                return $this->value == 'true' ? 1 : 0;
            }
            
            return $this->value;
        } catch (Exception $ex) {
            throw new Exception ($ex->getMessage());
        }
    }

    public function setValues () {
        $this->value = $this->data->{$this->obj['name']};
    }

    public function checkExists () {
        try {
            if ( !isset($this->data->{$this->obj['name']}) ) {
                throw new Exception($this->obj['msg']);
            }
        } catch (Exception $ex) {
            throw new Exception ($ex->getMessage());
        }
    }

    public function checkIsEmpty () {
        try {
            if ( $this->obj['type'] != 'boolean' && empty($this->value) ) {
                throw new Exception($this->obj['msg']);
            }
            
            if (isset($this->obj['defaultValues'])) {
                if (!in_array($this->value,$this->obj['defaultValues'])) {
                    throw new Exception($this->obj['valMsg']);
                }
            }
        } catch (Exception $ex) {
            throw new Exception ($ex->getMessage());
        }
    }

    public function filterText () {
        try {
            if ($this->obj['type'] == 'string') {
                $this->value = filter_var($this->value, FILTER_SANITIZE_STRING);
            } else if ($this->obj['type'] == 'int') {
                $this->value = filter_var($this->value, FILTER_VALIDATE_INT);
            } else if ($this->obj['type'] == 'password') {
                if (strlen($this->value) < 8 || strlen($this->value) > 12) {
                    $this->value = false;
                } else {
                    $this->value = password_hash($this->value, PASSWORD_DEFAULT);
                }
            } else if ($this->obj['type'] == 'email') {
                $this->value = filter_var($this->value, FILTER_VALIDATE_EMAIL);
            }

            if (!$this->value) throw new Exception ($this->obj['valMsg']);

            if ($this->obj['lwCase']) $this->value = strtolower($this->value);

            $this->value = $this->sanitizeString($this->value);
        } catch (Exception $ex) {
            throw new Exception ($ex->getMessage());
        }
    }

    public function sanitizeString($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }
}