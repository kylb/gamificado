<?php
namespace Core;

class Validator{

    public static function make(array $data, array $rules, BaseModel $con){
        $errors = null;

        foreach ($rules as $ruleKey => $ruleValue) {

            foreach ($data as $dataKey => $dataValue) {

                if ($dataKey == $ruleKey) {
                    $itemsValue = [];
                    if(strpos($ruleValue, "|")) {
                        $itemsValue = explode("|", $ruleValue);

                        foreach ($itemsValue as $itemValue){
                            $subItems =[];
                            if (strpos($itemValue, ":")){
                                $subItems = explode(":", $itemValue);
                                switch ($subItems[0]) {
                                    case 'min':
                                        if (strlen($dataValue) < $subItems[1]) {
                                            $errors["{$ruleKey}"] = "O campo {$ruleKey} deve ter no mínimo {$subItems[1]} caracteres.";
                                        }
                                        break;
                                    case 'max':
                                        if (strlen($dataValue) > $subItems[1]) {
                                            $errors["{$ruleKey}"] = "O campo {$ruleKey} deve ter no máximo {$subItems[1]} caracteres.";
                                        }
                                        break;
                                    case 'unique':
                                        //$objModel = "\\App\\Models\\" . $subItems[1];
                                        $model = $con;
                                        //$find = $model->where($subItems[2],$dataValue)->first(); //usando eloquent
                                        $find = $model->findWhere([$subItems[2] => $dataValue]);
                                        if($find->id){
                                            if(isset($subItems[3]) && $find->id  == $subItems[3]){
                                                break;
                                            } else{
                                                $errors["{$ruleKey}"] = "{$ruleKey} já está sendo utilizado.";
                                                break;
                                            }
                                        }
                                        break;
                                    default:
                                        break;
                                }
                            } else{
                                switch ($itemValue) {
                                    case 'required':
                                        if ($dataValue == ' ' || empty($dataValue)) {
                                            $errors["{$ruleKey}"] = "O campo {$ruleKey} deve ser PREENCHIDO.";
                                        }
                                        break;
                                    case 'date':
                                        $date = explode("/","$dataValue"); $d = $date[0]; $m = $date[1]; $y = $date[2];
                                        // 1 = true (válida) | 0 = false (inválida)
                                        $res = checkdate($m,$d,$y);
                                        if (!$res) {
                                            $errors["{$ruleKey}"] = "O campo {$ruleKey} deve ser PREENCHIDO.";
                                        }
                                        break;
                                    case 'email':
                                        if (!filter_var($dataValue, FILTER_VALIDATE_EMAIL)) {
                                            $errors["{$ruleKey}"] = strtoupper($ruleKey) . " INVALIDO";
                                        }
                                        break;
                                    case 'float':
                                        if (!filter_var($dataValue, FILTER_VALIDATE_FLOAT)) {
                                            $errors["{$ruleKey}"] = "O campo {$ruleKey} deve conter numero DECIMAL.";
                                        }
                                        break;
                                    case 'int':
                                        if (!filter_var($dataValue, FILTER_VALIDATE_INT)) {
                                            $errors["{$ruleKey}"] = "O campo {$ruleKey} deve conter numero INTEIRO.";
                                        }
                                        break;
                                    default:
                                        break;
                                }
                            }
                        }
                    } else if (strpos($ruleValue, ":")) {
                        $items = explode(":", $ruleValue);
                        switch ($items[0]) {
                            case 'min':
                                if (strlen($dataValue) < $items[1]) {
                                    $errors["{$ruleKey}"] = "O campo {$ruleKey} deve ter no mínimo {$items[1]} caracteres.";
                                }
                                break;
                            case 'max':
                                if (strlen($dataValue) > $items[1]) {
                                    $errors["{$ruleKey}"] = "O campo {$ruleKey} deve ter no máximo {$items[1]} caracteres.";
                                }
                                break;
                            case 'unique':
                                //$objModel = "\\App\\Models\\" . $items[1];
                                $model = $con;
                                //$find = $model->where($items[2],$dataValue)->first(); //usando eloquent
                                $find = $model->findWhere([$items[2] => $dataValue]);
                                if($find->id){
                                    if(isset($items[3]) && $find->id == $items[3]){
                                        break;
                                    } else{
                                        $errors["{$ruleKey}"] = "{$ruleKey} já registrado no banco de dados.";
                                        break;
                                    }
                                }
                                break;
                            default:
                                break;
                        }
                    } else {
                        switch ($ruleValue) {
                            case 'required':
                                if ($dataValue == ' ' || empty($dataValue)) {
                                    $errors["{$ruleKey}"] = "O campo {$ruleKey} deve ser PREENCHIDO.";
                                }
                                break;
                            case 'date':
                                $date = explode("/","$dataValue"); $d = $date[0]; $m = $date[1]; $y = $date[2];
                                // 1 = true (válida) | 0 = false (inválida)
                                $res = checkdate($m,$d,$y);
                                if (!$res) {
                                    $errors["{$ruleKey}"] = "{$ruleKey} Inválida! Formato esperado: DD/MM/YYYY.";
                                }
                                break;
                            case 'email':
                                if (!filter_var($dataValue, FILTER_VALIDATE_EMAIL)) {
                                    $errors["{$ruleKey}"] = strtoupper($ruleKey) . " INVALIDO";
                                }
                                break;
                            case 'float':
                                if (!filter_var($dataValue, FILTER_VALIDATE_FLOAT)) {
                                    $errors["{$ruleKey}"] = "O campo {$ruleKey} deve conter numero DECIMAL.";
                                }
                                break;
                            case 'int':
                                if (!filter_var($dataValue, FILTER_VALIDATE_INT)) {
                                    $errors["{$ruleKey}"] = "O campo {$ruleKey} deve conter numero INTEIRO.";
                                }
                                break;
                            default:
                                break;
                        }
                    }
                }
            }
        }
        if($errors){
            Session::set('errors',$errors);
            Session::set('inputs',$data);
            return true;
        } else{
            Session::destroy('errors');
            Session::destroy('inputs');
            return false;
        }


    }

}