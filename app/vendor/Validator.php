<?php

class Validator{


    private $data = [];
    private $errors = [];

    public function __construct($data){
        $this->data = $data;
    }
    //public function secure(){} Aprés ...
    //check khassha label 3la wad affichage
    public function check($name,$rules='required',$options = false){
        $rulesToCheck = explode(',',$rules);
        foreach($rulesToCheck as $rule){
            if(preg_match('/(.*):(.*)\w+/',$rule)){
                $rulesDo = explode(':',$rule);
                $valide = 'validate_'.$rulesDo[0];
                if($this->$valide($name,$rulesDo[1])!==true) {
                    $this->errors[$name] = $this->$valide($name,$rulesDo[1]);
                }
            }else{
                $valide = 'validate_'.$rule;
                if($this->$valide($name,$options)!== true){
                    $this->errors[$name] = $this->$valide($name,$options);
                }
            }

        }

    }

    private function validate_required($name,$o){
        if(!(array_key_exists($name,$this->data) && $this->data[$name] !='')){
            return "est obligatoire";
        }else{
            return true;
        }
    }

    private function validate_email($name,$o){
        if(!(array_key_exists($name,$this->data) && filter_var($this->data[$name],FILTER_VALIDATE_EMAIL))){
         return "est invalide";
        }else{
            $mailsAvailable = ['gmail.com'];
            return true;
        }
    }

    private function validate_in($name,$values){

        if(array_key_exists($name,$this->data) && in_array($this->data[$name],$values)){
            return true;
        }else{
            return "est invalide";
        }
    }

    private function validate_phone($name,$o){
        if(!(array_key_exists($name,$this->data) && $this->data[$name] !='')){
            return "est obligatoire";
        }else{
            if(strlen($this->data[$name])!=10) return 'est invalide';
            else return true;
        }
    }
    private function validate_number($name,$o){
        return (!(array_key_exists($name,$this->data) && is_numeric($this->data[$name])))?"est doit être un nombre":true;

    }

    /**
     * @param $name
     * @param $min
     * @return bool
     */
    private function validate_minimum($name, $min){
        return (strlen($this->data[$name])<$min)?"est doit être composé de $min caracteres au minimum":true;
    }

    private function validate_maximum($name, $max){
        return (strlen($this->data[$name])>$max)?"est doit être composé de $max caracteres au maximum":true;
    }

    public function foundErrors(){
        if(empty($this->errors)) return true;
        else return false;
    }
    public function noError(){
        if(empty($this->errors)) return true;
        else return false;
    }
    public function errors(){
        return $this->errors;
    }

}

?>