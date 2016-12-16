<?php


namespace Blog\Controller;


use Blog\Form\CommentForm;
use Blog\Model\Comment;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PostController extends AbstractActionController
{
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var EntityRepository
     */
    private $postRepository;
    /**
     * @var EntityRepository
     */
    private $commentRepository;
    /**
     * @var CommentForm
     */
    private $commentForm;

    public function __construct(
        EntityManager $entityManager,
        EntityRepository $postRepository,
        EntityRepository $commentRepository,
        CommentForm $commentForm
    ) {
        $this->entityManager = $entityManager;
        $this->postRepository = $postRepository;
        $this->commentRepository = $commentRepository;
        $this->commentForm = $commentForm;
    }

    public function indexAction()
    {
        return new ViewModel([
            'posts' => $this->postRepository->findAll()
        ]);
    }

    public function showAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);

        if (!$id || !($post = $this->postRepository->find($id))) {
            return $this->redirect()->toRoute('site-post');
        }

        return new ViewModel([
            'post' => $post,
            'commentForm' => $this->commentForm
        ]);
    }

    public function addCommentAction()
    {
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->redirect()->toRoute('site-post');
        } else {
            $id = (int)$this->params()->fromRoute('id', 0);

            if (!$id || !($post = $this->postRepository->find($id))) {
                return $this->redirect()->toRoute('site-post');
            }

            $commentForm = $this->commentForm;
            $commentForm->setData($request->getPost());

            if (!$commentForm->isValid()) {
                return $this->redirect()->toRoute('site-post', ['action' => 'show', 'id' => $post->getId()]);
            }
            $comment = $commentForm->getData();
            $comment->setPost($post);
            $this->entityManager->persist($comment);
            $this->entityManager->flush();

            return $this->redirect()->toRoute('site-post', ['action' => 'show', 'id' => $post->getId()]);
        }
    }

}