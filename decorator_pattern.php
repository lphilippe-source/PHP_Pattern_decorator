<?php

interface DecoratorComponent{

    public function display(?string $str=null);
    public function getStr();
}

//instancie un object qui sera stocké en proprieté de Decorator
class ConcreteComponent implements DecoratorComponent
{
    private $str;

    public function display(?string $str=null):?string{
       if(!$str)return $this->getStr();
       $this->setStr($str);
       return $str;
    }
    public function getStr():?string{
        return $this->str;
    }
    public function setStr(?string $str):void{
        $this->str = $str;
    }
}

class Decorator implements DecoratorComponent{

    //object wrapped
    private $decorator;

    public function __construct(DecoratorComponent $decorator){
        $this->decorator = $decorator;
    }

    public function display(?string $str=null):?string{
       return $this->getStr();
    }
    public function getStr():?string{
        return $this->decorator->getStr();
    }
}

class DecoratorUcfirst extends Decorator{

    public function display(?string $str=null):?string{
        return ucfirst(parent::display($str));
    }
}

class DecoratorReplaceA extends Decorator{

    public function display(?string $str=null):?string{
        $text = parent::display($str);
        return str_replace('a','@',$text);
    }
}

$lorem = "le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression.";
//le composant initial
$simpleComponent = new ConcreteComponent;
echo $simpleComponent->display($lorem)."\n";

// wrapped object
$wrapped = new Decorator($simpleComponent);

//decorateur majuscule
$ucFirst=new DecoratorUcfirst($wrapped);
echo $ucFirst->display()."\n";

//decorateur remplace a par @
$strReplace = new DecoratorReplaceA($wrapped);
echo $strReplace->display()."\n";
?>
