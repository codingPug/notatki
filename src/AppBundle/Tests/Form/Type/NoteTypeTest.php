<?php
namespace Tests\AppBundle\Test\Form\Type;

use AppBundle\Form\NoteType;
use AppBundle\Entity\Note;
use Symfony\Component\Form\Test\TypeTestCase;



class NoteTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = array(
            'title' => 'tytul',
            'text' => 'test notatki',
        );

        $form = $this->factory->create(NoteType::class);

        $object = new Note();
        $object->setTitle($formData['title']);
        $object->setText($formData['text']);


        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($object, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }

}