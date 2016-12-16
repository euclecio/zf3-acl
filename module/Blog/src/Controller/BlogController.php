<?php


namespace Blog\Controller;


use Blog\Form\PostForm;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class BlogController extends AbstractActionController
{
    /**
     * @var PostForm
     */
    private $form;
    /**
     * @var EntityRepository
     */
    private $repository;
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager, EntityRepository $repository, PostForm $form)
    {
        $this->form = $form;
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    public function indexAction()
    {
        return new ViewModel([
            'posts' => $this->repository->findAll()
        ]);
    }

    public function addAction()
    {
        $form = $this->form;
        $form->get('submit')->setValue('Add Post');

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $post = $form->getData();
        $this->entityManager->persist($post);
        $this->entityManager->flush();

        return $this->redirect()->toRoute('admin-blog/post');
    }

    public function editAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);

        if (!$id || !($post = $this->repository->find($id))) {
            return $this->redirect()->toRoute('admin-blog/post');
        }

        $form = $this->form;
        $form->bind($post);
        $form->get('submit')->setAttribute('value', 'Edit Post');

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return [
                'id' => $id,
                'form' => $form
            ];
        }

        $form->setData($request->getPost());
        if (!$form->isValid()) {
            return [
                'id' => $id,
                'form' => $form
            ];
        }

        $this->entityManager->flush();
        return $this->redirect()->toRoute('admin-blog/post');
    }

    public function deleteAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);

        if (!$id || !($post = $this->repository->find($id))) {
            return $this->redirect()->toRoute('admin-blog/post');
        }

        $this->entityManager->remove($post);
        $this->entityManager->flush();
        return $this->redirect()->toRoute('admin-blog/post');
        
    }

}