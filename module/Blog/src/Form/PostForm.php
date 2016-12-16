<?php


namespace Blog\Form;


use Zend\Form\Element;
use Zend\Form\Form;

class PostForm extends Form
{

    public function __construct($name=null)
    {
        parent::__construct('post');

        $this->add([
           'name' => 'id',
            'type' => Element\Hidden::class
        ]);

        $this->add([
            'name' => 'title',
            'type' => Element\Text::class,
            'options' => [
                'label'=> 'Title'
            ]
        ]);

        $this->add([
            'name' => 'content',
            'type' => Element\Textarea::class,
            'options' => [
                'label'=> 'Content'
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'type' => Element\Submit::class,
            'attributes' => [
                'value'=> 'Go',
                'id'=>'submitbutton'
            ]
        ]);

    }

}