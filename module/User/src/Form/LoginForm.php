<?php


namespace User\Form;


use Zend\Form\Element;
use Zend\Form\Form;

class LoginForm extends Form
{

    public function __construct($name=null)
    {
        parent::__construct('login');

        $this->add([
            'name' => 'username',
            'type' => Element\Text::class,
            'options' => [
                'label'=> 'Usuário'
            ]
        ]);

        $this->add([
            'name' => 'password',
            'type' => Element\Password::class,
            'options' => [
                'label'=> 'Senha'
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'type' => Element\Submit::class,
            'attributes' => [
                'value'=> 'Entrar',
                'id'=>'submitbutton'
            ]
        ]);

    }

}