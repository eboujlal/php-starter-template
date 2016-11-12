<?php

class Form{

    private $data = [];

    public function __construct($data = []){
        $this->data = $data;
    }

    private function getValueOf($name){
        $value = "";
        if(isset($this->data[$name])) $value = $this->data[$name];
        return $value;
    }

    public function addForm($type=1,$action=''){
        if($type==1) return "<form method='post' action='$action'>";
        else if($type==2) return "<form method='get' action='$action'>";
        else if($type==3) return "<form method='post' enctype='multipart/form-data' action='$action' >";
    }

    private function input($type,$name,$label,$icon,$rang='',$attr=''){
        $value = $this->getValueOf($name);
        if($rang=='optional') {
            $input = "<label for='$name'>$label</label>";
        }else{
            $input = "<label for='$name'><font color='red'>*</font>$label</label>";
        }
        if($type=='textarea'){
            $input .= "<textarea name='$name' autocomplete=\"off\" class='form-control' placeholder=\"$label\" id='input$name' $attr>$value</textarea>";
        }else{
            $input .= "<input type=\"$type\" autocomplete=\"off\" class='form-control'  placeholder=\"$label\" id='input$name' name=\"$name\" value='$value' $attr/>";
        }
        return "
            <div class=\"form-group form-group-attaleb\">
                <span id='icon$name'><i class='fa fa-$icon'></i></span>
                $input
            </div>";
    }

    public function optionalText($name,$label,$icon=''){
        return $this->input('text',$name,$label,$icon,'optional');
    }
    public function text($name,$label,$icon=''){
        return $this->input('text',$name,$label,$icon);
    }
    public function hidden($name,$label,$icon=''){
        return $this->input('hidden',$name,$label,$icon);
    }

    public function file($name,$label,$icon=''){
        return $this->input('file',$name,$label,$icon);
    }


    public function attrText($name,$label,$icon='',$attr){
        return $this->input('text',$name,$label,$icon,'',$attr);
    }


    public function password($name,$label,$icon=''){

        return $this->input('password',$name,$label,$icon);
    }

    public function attPassword($name,$label,$icon=''){
        return $this->input('password',$name,$label,$icon,'','disabled');
    }

    public function textarea($name,$label,$icon=''){
        return $this->input('textarea',$name,$label,$icon);
    }

    /**
     * cette methode vous permet d'ajouter un champ de selectio
     * @param $name
     * @param $label
     * @param $options
     * @return string
     */
    public function select($name,$label,$options,$addons=''){
        $optionHtml = '';
        $value = $this->getValueOf($name);
        foreach($options as $k=>$v){
            if($value == $k) $selected = ' selected';
            else $selected ='';
            $optionHtml.= "<option value='$k'$selected>$v</option>";
        }
        return "<div class=\"form-group\">
                    <label for='$name'>$label</label>
                    <select name='$name' class='form-control s2' id='input$name' $addons>$optionHtml</select>
                </div>
                ";
    }

    public function radio($name,$label,$data){
        $show = "<div class='form-group'>
                    <label for='$name'>$label</label>
                </div>";
        foreach($data as $k=>$v){
            if($k==$this->getValueOf($name)) $checked = ' checked';
            else $checked = '';
            $show.= "$v<input name='$name' value='$k' type='radio' class='radio-inline'$checked/>";
        }
        return $show;
    }

    public function submit($name,$value,$icon=''){
        return "<div class=\"form-group\">
                <label for=\"\">&nbsp;</label>
                <button type=\"submit\" class=\"btn btn-primary\" name=\"$name\" id='input$name'>$icon $value</button>
            </div>";
    }

    public function closeForm(){
        return "</form>";
    }

}
?>