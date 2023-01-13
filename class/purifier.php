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
            $objType = $this->obj['type'];
            if ($objType == 'string') {
                $this->value = filter_var($this->value, FILTER_SANITIZE_STRING);

            } else if ($objType == 'int') {
                $this->value = filter_var($this->value, FILTER_VALIDATE_INT);
            } else if ($objType == 'double') {
                $this->value = filter_var($this->value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            } else if ($objType == 'password') {
                if (strlen($this->value) < 8 || strlen($this->value) > 12) {
                    $this->value = false;
                } else {
                    $this->value = password_hash($this->value, PASSWORD_DEFAULT);
                }
            } else if ($objType == 'email') {
                $this->value = filter_var($this->value, FILTER_VALIDATE_EMAIL);
            } else if ($objType == 'time') {

                if (!$this->isValidTimeStamp($this->value)) throw new Exception ("Time stamp is not valid!");
                
            }


            if (!$this->value) throw new Exception ($this->obj['valMsg']);

            if ($this->obj['lwCase']) $this->value = strtolower($this->value);

            $this->value = $this->sanitizeString($this->value);
        } catch (Exception $ex) {
            throw new Exception ($ex->getMessage());
        }
    }

    public function isValidTimeStamp($date_time_string) {
        if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]) (2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]$/", $date_time_string)) {
            return true;
        }
        return false;
    }

    public function sanitizeString($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }
}