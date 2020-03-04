<?php
class Validacion extends Singleton
{
    private $_rules = array(); // _rules['nombre'] => 'required|alpha_space', _rules['apellidos'] => 'required|alpha_space'
    private $_errors = array(); // _errors['nombre'] = array('value' => '','rule' => 'required') o _errors['nombre'] = array('value' => 'Pedro5','rule' => 'alpha_space') o _errors['nombre'] = array('value' => 'Pedro','rule' => 'ok')
    private $_oks = array(); // _oks['nombre'] =>'Luis', _oks['apellidos'] => "Sánchez Ruiz"
    private $_exists;
    private $_errorFoto = array();
    private $_salidaRepeat;

    public function addRules($rules)
    {
        $this->_rules = $rules;
    }

    public function setExists($dup)
    {
        $this->_exists = $dup;
    }

    public function setSalidaRepeat($rep)
    {
        $this->_salidaRepeat = $rep;
    }

    private function _validate_repeated($field, $value)
    {
        if ($this->_salidaRepeat) {
            $this->_setError($field, $value, 'repeated');
        }
    }

    public function run($toValidate)
    {
        foreach ($toValidate as $field => $value) {
            // si el nombre del campo no está como índice en $this->_rules, no hay que validarlo
            if (!array_key_exists($field, $this->_rules)) {
                continue;
            }
            // creamos un array con la cadena $this->_rules[$field] usando como separador de elementos |
            $rules = explode('|', $this->_rules[$field]);
            // Si el campo es requerido en $rules hay un elemento cuyo contenido es 'required'
            if (in_array('required', $rules)) {
                // el método validate_required verifica si el campo tiene contenido, es decir, ha sido rellenado
                // si no es así, añade el campo al array _errors
                $this->_validate_required($field, $value);
                // si el campo no se ha rellenado no sigue relizando el control de entrada
                // por ello verifica que si existe un elemento con el 'rule'='required'
                // getArray() esta definida en common.php
                if (getArray($this->getErrorsByField($field), 'rule') == 'required') {
                    continue;
                }
            }
            foreach ($rules as $rule) {
                if ($rule == 'required') {
                    continue;
                }
                $method = '_validate_' . $rule;
                // verifica si el método de validación existe en esta clase (constante __CLASS__)
                // la constante __CLASS__ almacena la clase que se está ejecutando en este momento
                if (!method_exists(__CLASS__, $method)) {
                    continue;
                }
                // ejecuta el método de validación (por ejemplo, validate_alpha_space)
                $this->$method($field, $value);
            }
            // puede que en los formularios haya algún campo que no queramos validar,
            // pero hay que registrarle en _errors para que el método mdlPaso1() recupere su valor
            if (empty($this->getErrorsByField($field))) {
                $this->_setError($field, $value, 'ok');
            }
        }
    }
    public function isValid()
    {
        if (count($this->_oks) == count($this->_errors)) {
            return true;
        }
        return false;
    }
    public function getStrRule($rule)
    {
        switch ($rule) {
                // solo hay una posible coincidencia, pero ya añadiremeos más
            case 'alpha_space':
                return 'Solo puede contener letras (a-z) y espacios en blanco';
            case 'alpha_num_space':
                return 'Números y letras de 5 a 15 caracteres sin espacios';
            case 'alpha_non_space':
                return '6 caracteres alfabéticos sin espacios';
            case 'numeric':
                return 'Solo números';
            case 'duplicate':
                return 'Duplicado';
            case 'dni':
                return 'El campo debe tener formato Dni (8-num 1-letra)';
            case 'email':
                return 'El campo debe tener formato EMAIL';
            case 'repeated':
                return 'Ciudad repetida';
            case 'telefono':
                return 'El teléfono debe tener 9 números';
            case 'foto':
                return 'Foto necesaria';
            case 'nombre':
                return 'Solo letras max 20 caracteres, min 2 caracteres';
            case 'salida':
                return 'Solo letras max 20 caracteres, min 2 caracteres';
            case 'descripcion':
                return 'Solo letras y signos de puntuación max 100 caracteres, min 2 caracteres';
            case 'precio':
                return 'Solo numeros max 5 numeros';
            case 'idTipo':
                return '1: Cultural | 2: Deprtivo | 3: Turístico';
        }
        return '';
    }
    // Este método sirve también para los elementos <textarea>
    public function restoreValue($name)
    {
        if (array_key_exists($name, $this->_errors)) {
            $value = $this->_errors[$name]['value'];
            return $value;
        }
        return '';
    }
    public function getOks()
    {
        return $this->_oks;
    }
    // método que devuelve el elemento del array _errors de un campo (si existe)
    public function getErrorsByField($field)
    {
        return getArray($this->_errors, $field, array());
    }
    public function getErrors()
    {
        return $this->_errors;
    }
    private function _setError($field, $value, $rule)
    {
        $this->_errors[$field] = array(
            'value' => $value,
            'rule' => $rule
        );
        if ($rule == 'ok') {
            $this->_oks[$field] = $value;
        }
    }
    // Método que valida que el dato introducido en el campo es correcto
    // Observa que la 2ª parte del nombre del método (alpha_space) coincide con el tipo de dato
    // que se utiliza en el array $_rules de la clase mdlPaso1
    private function _validate_alpha_space($field, $value)
    {
        if (!preg_match('/^[a-zÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ][a-zÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ\s]+$/i', $value)) {
            $this->_setError($field, $value, 'alpha_space');
        }
    }
    private function _validate_nombre($field, $value)
    {
        if (!preg_match('/^[a-zÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ][a-zÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ\s]{1,20}+$/i', $value)) {
            $this->_setError($field, $value, 'nombre');
        }
    }

    private function _validate_salida($field, $value)
    {
        if (!preg_match('/^[a-zÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ][a-zÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ\s]+$/i', $value)) {
            $this->_setError($field, $value, 'salida');
        }
    }


    private function _validate_descripcion($field, $value)
    {
        if (!preg_match('/^[a-zÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ,.][a-zÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ,.\s]{1,100}+$/i', $value)) {
            $this->_setError($field, $value, 'descripcion');
        }
    }

    //  Empieza por-> ^
    //  [a-z]intervalo
    //  {0, 10} minimo 0, maximo 10 {5}-> OBLIGATORIAMENTE 5 caracteres
    //  * 0 o más
    //  + uno o mas
    // /s permite espacios
    private function _validate_alpha_numeric($field, $value)
    {
        if (!preg_match('/[a-zA-Z0-9]+/i', $value)) {
            $this->_setError($field, $value, 'alpha_numeric');
        }
    }
    private function _validate_edad($field, $value)
    {
        if (!preg_match('/^[0-9]{0,2}+$/', $value)) {
            $this->_setError($field, $value, 'edad');
        }
    }
    private function _validate_telefono($field, $value)
    {
        if (!preg_match('/^[0-9]{9}+$/', $value)) {
            $this->_setError($field, $value, 'telefono');
        }
    }

    // método que añade una elemento al array _errors cuando un campo obligatorio no se ha completado
    private function _validate_required($field, $value)
    {
        if (strlen($value) == 0) {
            $this->_setError($field, $value, 'required');
        }
    }

    private function _validate_numeric($field, $value)
    {
        if (!preg_match('/^[0-9]*$/i', $value)) {
            $this->_setError($field, $value, 'numeric');
        }
    }

    private function _validate_idTipo($field, $value)
    {
        if (!preg_match('/^[1-3]{1}+$/i', $value)) {
            $this->_setError($field, $value, 'idTipo');
        }
    }
    private function _validate_precio($field, $value)
    {
        if (!preg_match('/^[0-9]{1,5}+$/i', $value)) {
            $this->_setError($field, $value, 'precio');
        }
    }

    private function _validate_dni($field, $value)
    {
        if (!preg_match('/^[0-9]{8}[A-Z]{1}$/i', $value)) {
            $this->_setError($field, $value, 'dni');
        }
    }

    private function _validate_duplicate($field, $value)
    {
        if ($this->_exists) {
            $this->_setError($field, $value, 'duplicate');
        }
    }

    private function _validate_email($field, $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->_setError($field, $value, 'email');
        }
    }

    private function _validate_pass($field, $value)
    {
        if (!preg_match('/^[a-zA-Z0-9-_@!?¿]{8-20}$/', $value)) {
            $this->_setError($field, $value, 'pass');
        }
    }


    public function restoreCheckboxes($name, $value, $default = false)
    {
        //si _errors está vacío, es la primera vez que se visualiza el formulario
        if ($this->_errors) {
            if (array_key_exists($name, $this->_errors)) {
                // _errors[$name]['value'] es un array (Bicicleta, Tren etc.)
                if ($this->_errors[$name]['value'] == $value) {
                    return 'checked';
                }
            }
            // es la primera vez que se visualiza el formulario y podemos poner valores por defecto.
        } elseif ($default) {
            return 'checked';
        }
    }

    public function restoreRadios($name, $value, $default = false)
    {
        if (array_key_exists($name, $this->_errors)) {
            if ($this->_errors[$name]['value'] == $value) {
                return 'checked';
            }
            // si el nombre del campo no está en _errors, es que es la primera vez que se visualiza el formulario
            // y es cuando podemos poner valores por defecto.
        } elseif ($default) {
            return 'checked';
        }
        return '';
    }
    public function restoreOptions($name, $value, $default = false)
    {
        if (array_key_exists($name, $this->_errors)) {
            if ($this->_errors[$name]['value'] == $value) {
                return 'selected';
            }
            // si el nombre del campo no está en _errors, es que es la primera vez que se visualiza el formulario
            // y es cuando podemos poner valores por defecto.
        } elseif ($default) {
            return 'selected';
        }
        return '';
    }
    private function _validate_foto($field, $value)
    {
        if ($value["error"] == UPLOAD_ERR_OK) {
            if (($value["type"] != "image/pjpeg") and ($value["type"] != "image/jpeg")) {
                $this->_setError($field, $value, 'foto');
                $this->_errorFoto[$field] = "<b>JPEG fotos solamente, gracias!</b>";
            } elseif (!move_uploaded_file($value["tmp_name"], "fotos/" . basename($value["name"]))) {
                $this->_setError($field, $value, 'foto');
                $this->_errorFoto[$field] = "<b>Lo sentimos, hubo un problema al subir esa foto</b>" . $value["error"];
            } else {
                $this->_setError($field, $value, 'ok');
            }
        } else {
            $this->_setError($field, $value, 'foto');
            switch ($value["error"]) {
                case UPLOAD_ERR_INI_SIZE:
                    $this->_errorFoto[$field] = "<b>La foto es más grande de lo que permite el servidor.<b>";
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $this->_errorFoto[$field] = "<b>La foto es más grande de lo que permite el formulario.<b>";
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $this->_setError($field, $value, 'required');
                    break;
                default:
                    $this->_errorFoto[$field] = "Ponte en contacto con el administrador del servidor para obtener ayuda.";
            }
        }
    }
}